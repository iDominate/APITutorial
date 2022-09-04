<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SwitchLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        app()->setlocale('ar');
        if(isset($request->lang) && $request->lang == 'en')
        app()->setlocale('en');
        return $next($request);
    }
}
