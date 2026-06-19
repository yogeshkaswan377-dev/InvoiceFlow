<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Auth\AuthenticationException;

use App\Http\Middleware\EnsureCompanySelected;
use App\Http\Middleware\EnsureCompanySelectedApi;
use App\Http\Middleware\CheckPermission;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        // Middleware Aliases
        $middleware->alias([
            'company.selected'     => EnsureCompanySelected::class,
            'company.selected.api' => EnsureCompanySelectedApi::class,
            'permission'           => CheckPermission::class,
            'super.admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);

        // CORS Configuration for API
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        // Trust proxies (for production behind nginx/apache)
        $middleware->trustProxies(at: '*');
    })

    ->withExceptions(function (Exceptions $exceptions) {
        // RFC 7807 Error Format for API routes
        $exceptions->render(function (Throwable $e, Request $request) {
            // Only apply to API routes
            if (!$request->is('api/*')) {
                return null;
            }

            $status = 500;
            $type = 'https://tools.ietf.org/html/rfc7231#section-6.6.1';
            $title = 'Internal Server Error';
            $detail = config('app.debug') ? $e->getMessage() : 'An unexpected error occurred.';

            // Validation Errors (422)
            if ($e instanceof ValidationException) {
                $status = 422;
                $type = 'https://tools.ietf.org/html/rfc7231#section-6.5.1';
                $title = 'Validation Error';
                $detail = 'The given data was invalid.';

                return response()->json([
                    'type' => $type,
                    'title' => $title,
                    'status' => $status,
                    'detail' => $detail,
                    'errors' => $e->errors(),
                ], $status);
            }

            // Not Found (404)
            if ($e instanceof NotFoundHttpException) {
                $status = 404;
                $type = 'https://tools.ietf.org/html/rfc7231#section-6.5.4';
                $title = 'Not Found';
                $detail = 'The requested resource was not found.';
            }

            // Method Not Allowed (405)
            if ($e instanceof MethodNotAllowedHttpException) {
                $status = 405;
                $type = 'https://tools.ietf.org/html/rfc7231#section-6.5.5';
                $title = 'Method Not Allowed';
                $detail = 'The HTTP method is not supported for this endpoint.';
            }

            // Too Many Requests (429)
            if ($e instanceof TooManyRequestsHttpException) {
                $status = 429;
                $type = 'https://tools.ietf.org/html/rfc6585#section-4';
                $title = 'Too Many Requests';
                $detail = 'Rate limit exceeded. Please try again later.';
            }

            // Authentication Error (401)
            if ($e instanceof AuthenticationException) {
                $status = 401;
                $type = 'https://tools.ietf.org/html/rfc7235#section-3.1';
                $title = 'Unauthenticated';
                $detail = 'Authentication is required to access this resource.';
            }

            return response()->json([
                'type' => $type,
                'title' => $title,
                'status' => $status,
                'detail' => $detail,
            ], $status);
        });
    })->create();
