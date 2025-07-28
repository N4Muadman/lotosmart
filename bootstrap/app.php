<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withCommands()
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('app:save-ai-prediction-results')->everyMinute();
    })
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin/*') || $request->is('admin')) {
                return route('admin.login.form');
            }
            return route('login.form');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UnauthorizedException $e, $request) {
            if ($request->is('admin/*')) {

                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login.form')
                    ->with('error', 'Bạn không có quyền truy cập vào trang này.');
            }

            return redirect()->route('login.form')
                ->with('error', 'Bạn không có quyền truy cập.');
        });

        $exceptions->render(function (ThrottleRequestsException $e, $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;

            // if ($request->expectsJson()) {
            //     return response()->json([
            //         'message' => "Quá nhiều lần thử. Vui lòng thử lại sau {$retryAfter} giây.",
            //         'retry_after' => $retryAfter
            //     ], 429);
            // }

            if ($request->is('admin/login')) {
                return back()->withErrors([
                    'email' => "Bạn đã thử đăng nhập quá nhiều lần. Vui lòng thử lại sau {$retryAfter} giây."
                ])->withInput($request->except('password'));
            }

            return response()->view('errors.429', [
                'message' => "Quá nhiều requests. Thử lại sau {$retryAfter} giây.",
                'retry_after' => $retryAfter
            ], 429);
        });
    })->create();
