<?php

namespace Ramzeng\LaravelTamperAttack\Middlewares;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Ramzeng\LaravelTamperAttack\Exceptions\TamperAttackException;
use Symfony\Component\HttpFoundation\Response;

class TamperAttack
{
    public function __construct(protected Repository $configRepository)
    {

    }

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->validateSignature($request)) {
            throw new TamperAttackException('invalid signature.');
        }

        return $next($request);
    }

    protected function validateSignature(Request $request): bool
    {
        if (empty($request->query('signature'))) {
            return false;
        }

        $values = $request->input();

        unset($values['signature']);

        ksort($values);

        $signature = sha1(sprintf('%s%s', http_build_query($values), $this->configRepository->get('tamper_attack.secret')));

        return $signature === $request->query('signature');
    }
}
