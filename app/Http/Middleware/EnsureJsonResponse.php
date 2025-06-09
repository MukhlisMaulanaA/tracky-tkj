<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonResponse
{
  public function handle(Request $request, Closure $next)
  {
    // Force Accept header for AJAX requests
    if ($request->ajax() || $request->wantsJson()) {
      $request->headers->set('Accept', 'application/json');
    }

    return $next($request);
  }
}