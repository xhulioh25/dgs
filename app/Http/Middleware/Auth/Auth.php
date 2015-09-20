<?php

/*
 * This file is part of Laravel Credentials.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware\Auth;

use App\Credentials;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Auth implements Middleware
{
    protected $credentials;
    protected $logger;

    public function __construct(Credentials $credentials, LoggerInterface $logger)
    {
        $this->credentials = $credentials;
        $this->logger = $logger;
    }

    public function handle($request, \Closure $next)
    {
        if (!$this->credentials->check()) {
            $this->logger->info('User tried to access a page without being logged in', ['path' => $request->path()]);
            if ($request->ajax()) {
                throw new UnauthorizedHttpException('Action Requires Login');
            }

            return Redirect::guest(URL::route('account.login'))
                ->with('error', 'You must be logged in to perform that action.');
        }

        if (!$this->credentials->hasAccess($level = $this->level())) {
            $this->logger->warning(
                'User tried to access a page without permission',
                ['path' => $request->path(), 'permission' => $level]
            );
            throw new AccessDeniedHttpException(ucfirst($level) . ' Permissions Are Required');
        }
    }

    protected function level()
    {
        $reflection = new ReflectionClass($this);

        $level = $reflection->getShortName();

        return strtolower($level);
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function getLogger()
    {
        return $this->logger;
    }
}