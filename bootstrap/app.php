<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Policy denials (AccessDeniedHttpException) and role-middleware denials
        // (Spatie UnauthorizedException) both surface as a toast + redirect
        // instead of the default 403 error page. Status 303 so Inertia follows
        // the redirect as a GET even on DELETE/PUT requests.
        $exceptions->render(function (AccessDeniedHttpException|UnauthorizedException $e, Request $request) {
            if ($request->is('api/*')) {
                return null; // fall through default JSON 403
            }

            Inertia::flash('toast', [
                'type' => 'error',
                'message' => __('You do not have permission to access the page.'),
            ]);

            return redirect()->route('dashboard', status: 303);
        });
    })->create();
