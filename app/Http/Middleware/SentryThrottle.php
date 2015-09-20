<?php

/*
 * This file is part of Laravel Credentials.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use Closure;
use App\Credentials;
use Illuminate\Contracts\Routing\Middleware;

/**
 * This is the sentry thottle middleware class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class SentryThrottle implements Middleware
{
    /**
     * The credentials instance.
     *
     * @var \App\Facades\Credentials
     */
    protected $credentials;

    /**
     * Create a new instance.
     *
     * @param \App\Facades\Credentials $credentials
     *
     * @return void
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->credentials->getThrottleProvider()->enable();

        return $next($request);
    }

    /**
     * Get credentials instance.
     * @return \App\Facades\Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}
