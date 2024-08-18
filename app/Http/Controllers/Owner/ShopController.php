<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');//ownersで認証しているか

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('shop'); // shop の ID を取得
            
            if (!is_null($id)) { // null 判定
                $shop = Shop::find($id); // find() は存在しない場合に null を返す
        
                if ($shop) {
                    $shopsOwnerId = $shop->owner->id;
                    $shopId = (int) $shopsOwnerId; // キャスト 文字列→数値に型変換
                    $ownerId = Auth::id();
        
                    if ($shopId !== $ownerId) { // 同じでなかったら
                        abort(404); // 404 ページ表示
                    }
                } else {
                    abort(404); // ID に対応する Shop が見つからない場合も 404
                }
            }
            
            return $next($request);
        });
        
        
    }

    public function index()
    {
        $ownerId = Auth::id();//文字列
        $shops = Shop::where('owner_id', $ownerId)->get();//数字

        return view('owner.shops.index', compact('shops'));

    }

    public function edit($id)
    {
        dd(Shop::findOrFail($id));


    }

    public function update(Request $request, $id)
    {

    }
}
