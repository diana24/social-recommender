<?php
/**
 * Created by PhpStorm.
 * User: digitalya
 * Date: 10/2/2015
 * Time: 1:56 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class Graph
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = Auth::user()->getGraphPath();

        if(!$path){
            return Redirect::back()->withErrors('Please connect at least one social account!');
        }
        return $next($request);
    }
}