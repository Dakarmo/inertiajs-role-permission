<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\RedirectResponse;
use Throwable;
use Inertia\Inertia;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
 * Prepare exception for rendering.
 *
 * @param  \Throwable  $e
 * @return \Throwable
 */


    // public function render($request, Throwable $e)
    // {
    //     $response = parent::render($request, $e);

    //     if (!app()->environment(['local', 'testing']) && in_array($response->status(), [500, 503, 404, 403])) {
    //         return redirect()->route('error', ['status' => $response->status()]);
           
    //     } else if ($response->status() === 419) {
    //         return back()->with([
    //             'message' => __('The page expired, please try again.'),
    //         ]);
    //     }

    //     return $response;
    // }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        $status = $response->status();

        if (!app()->environment(['local', 'testing'])) {

            return match ($status) {
                404 => Inertia::render('Errors/404')->toResponse($request)->setStatusCode($status),
                500, 503 => Inertia::render('Errors/500')->toResponse($request)->setStatusCode($status),
                403 => Inertia::render('Errors/403')->toResponse($request)->setStatusCode($status),
                401 => Inertia::render('Errors/401')->toResponse($request)->setStatusCode($status),
                419 => redirect()->back()->withErrors(['status' => __('The page expired, please try again.')]),
                default => $response
            };

        }

        return $response;

    }
}
