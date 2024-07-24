<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SiteVisitCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    final public function handle(Request $request, Closure $next): Response
    {
        try {
            $current_visit = new SiteVisit();
            $current_visit->increase_count($current_visit->get_current_data());
        } catch (Throwable $th) {
            app_error_log('VISITOR_COUNTER_ERROR', $th);
        }
        return $next($request);
    }
}
