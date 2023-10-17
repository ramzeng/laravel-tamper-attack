<?php

namespace Ramzeng\LaravelTamperAttack\Tests;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Ramzeng\LaravelTamperAttack\Exceptions\TamperAttackException;
use Ramzeng\LaravelTamperAttack\Middlewares\TamperAttack;
use Throwable;

class TamperAttackTest extends TestCase
{
    public function test_tamper_attack()
    {
        $configRepository = new ConfigRepository([
            'tamper_attack' => [
                'secret' => 'secret',
            ],
        ]);

        $middleware = new TamperAttack($configRepository);

        $timestamp = time();
        $nonce = Str::uuid()->toString();

        $payloads = [
            'timestamp' => $timestamp,
            'nonce' => $nonce,
        ];

        ksort($payloads);

        $signature = sha1(sprintf('%s%s', http_build_query($payloads), $configRepository->get('tamper_attack.secret')));

        $request = Request::create('http://localhost', 'GET', [
            ...$payloads,
            'signature' => $signature,
        ]);

        // ok
        $middleware->handle($request, function () {
            return new Response();
        });

        // invalid signature
        try {
            $request = Request::create('http://localhost', 'GET', [
                ...$payloads,
                'signature' => 'invalid signature',
            ]);

            $middleware->handle($request, function () {
                return new Response();
            });
        } catch (Throwable $e) {
            $this->assertInstanceOf(TamperAttackException::class, $e);
        }
    }
}
