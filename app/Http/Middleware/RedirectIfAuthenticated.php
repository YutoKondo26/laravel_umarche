<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    private const GUARD_USER = 'users';//config/auth.phpのguardsで設定したいた名前
    private const GUARD_OWNER = 'owner';
    private const GUARD_ADMIN = 'admin';
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {//ログインしていたら
        //         return redirect(RouteServiceProvider::HOME);//リダイレクト
        //     }
        // }
        if(Auth::guard(self::GUARD_USER)->check() && $request->routeIs('user.*')){//ログインしていて配下のURLにアクセスしてきたら
            return redirect(RouteServiceProvider::HOME);//RouteServiceProviderで定義した定数のURLにリダイレクト

        }
        if(Auth::guard(self::GUARD_OWNER)->check() && $request->routeIs('owner.*')){//ログインしていて配下のURLにアクセスしてきたら
            return redirect(RouteServiceProvider::OWNER_HOME);//RouteServiceProviderで定義した定数のURLにリダイレクト

        }
        if(Auth::guard(self::GUARD_ADMIN)->check() && $request->routeIs('admin.*')){//ログインしていて配下のURLにアクセスしてきたら
            return redirect(RouteServiceProvider::ADMIN_HOME);//RouteServiceProviderで定義した定数のURLにリダイレクト

        }

        return $next($request);
    }
}
