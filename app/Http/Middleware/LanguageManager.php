<?php
  
namespace App\Http\Middleware;
  
use Closure;
use App;
  
class LanguageManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    // public function handle($request, Closure $next)
    // {
    //     // Check if the request matches the 'admin/*' pattern
    //     if ($request->is('admin/*')) {
    //         // Do not set locale for admin routes
    //         return $next($request);
    //     }

    //     // If not an admin route, set the locale based on the session
    //     if (session()->has('locale')) {
    //         App::setLocale(session()->get('locale'));
    //     }

    //     // Continue to the next middleware or the route handler
    //     return $next($request);
    // }
}