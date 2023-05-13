<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Protype;
use App\Cart;
use Illuminate\Support\Facades\Session;
class ProductController extends Controller
{
    public function index(){
        
            //get all protype
            $protype = Protype::all();
    
            //Get product to filter
            $products = Product::select('*', 'products.name AS product_name', 'products.id AS product_id')
                ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
                ->where('featured', '=', '1')
                ->orderBy('products.name', 'desc')
                ->take(20)
                ->get();
    
            //Get 10 new products
            $get10Products = Product::orderBy('created_at', 'desc')->take(10)->get();
    
            //Get latest products
            $latestProduts = Product::orderBy('created_at', 'asc')->take(6)->get();
    
            //Get low price produts
            $lowPriceProducts = Product::select('*', DB::raw('price - price*sales/100 AS price_discount'))->orderBy('price_discount', 'asc')->take(6)->get();
    
            //Get high price produts
            $highPriceProducts = Product::select('*', DB::raw('price - price*sales/100 AS price_discount'))->orderBy('price_discount', 'desc')->take(6)->get();
    
            //return
            return view(
                'User.index',
                [
                    'getProtypes' => $protype,
                    'getProducts' => $products,
                    
                    'getNewProduct' => $get10Products,
                    'getLatestProduct' => $latestProduts,
                    'getLowPriceProduct' => $lowPriceProducts,
                    'getHighPriceProduct' => $highPriceProducts,
                ]
            );
        
    }
    function product_detail($id)
    {
        //View product detail
        $detail = Product::find($id);
        $type = Product::select('protypes.name')->join('protypes', 'protypes.id', '=', 'products.type_id')
            ->where('products.id', $id)
            ->get()->toArray();
        $products = Product::select('*', 'products.name AS product_name', 'products.id AS product_id')
            ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
            ->where('featured', '=', '1')
            ->orderBy('products.name', 'desc')
            ->take(20)
            ->get();


        return view(
            'User.shop-details',
            [
                'productDetail' => $detail,
                'getType' => $type,
                'getProducts' => $products,
            ]
        );
    }
    public function getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);

        return view('User.cart');
    }
    public function getCart()
    {
        $protypes = Protype::all();
        if (!Session::has('cart')) {
            return view('User.shopping-cart', [
                'getProtypes' => $protypes,
            ]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('User.shopping-cart', [
            'getProtypes' => $protypes,
            'products' => $cart->items,
            'totalPrice' => $cart->totalPrice,
        ]);
    }
    public function deleteItemCart(Request $request, $id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->deleteItem($id);

        if (Count($newCart->items) > 0) {
            $request->session()->put('cart', $newCart);
        } else {
            $request->session()->forget('cart');
        }
        return view('User.deleteCart');
    }
    public function saveAllItemCart(Request $request)
    {
        foreach ($request->data as $item) {
            $oldCart = Session('cart') ?  Session('cart') : null; // cart current
            $newCart = new Cart($oldCart);
            $newCart->updateAllCart($item['key'], $item['value']);
            $request->Session()->put('cart', $newCart);
        }
    }
   
}
