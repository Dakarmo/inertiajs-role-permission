<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\Response;

class ErrorController extends Controller
{
    public function showError($status)
    {
        return Inertia::render('Error', ['status' => $status])
            ->toResponse(request()) 
            ->setStatusCode($status);
    }
}
