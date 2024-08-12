<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;//読み込むrouteやisのメソッドを使えるように

class Authenticate extends Middleware
{
    protected $user_route = 'user.login';//ログイン画面を設定(リダイレクト先)
    protected $owner_route = 'owner.login';
    protected $admin_route = 'admin.login';
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {//認証されていないユーザーは
             if(Route::is('owner.*')){//owner系のURLに認証されていなかったら
                return route($this->owner_route);
             }elseif(Route::is('admin.*')){
                return route($this->admin_route);
             }else{
                return route($this->user_route);
             }
        }
    }
}
