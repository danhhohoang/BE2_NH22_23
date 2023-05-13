<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use App\Models\Protype;
use Illuminate\Http\Request;
<<<<<<< HEAD
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
   
=======
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {

        $protype = Protype::all();
        return view('User.index', ['getProtypes' => $protype]);
    }

    public function drid(Request $request)
    {
        $url = $request->path();
        $type = explode('/', $url);
        // get all protypes
        $protypes = Protype::all();
        //Pagination when there are more than 6 products
        $products = DB::table('products')->orderBy('id', 'desc')->paginate(6);
        // Get product by prince
        $orderprice = isset($_GET['field']) ? $_GET['field'] : "price";
        $ordersort = isset($_GET['sort']) ? $_GET['sort'] : "desc";

        //Get latest products
        $latestProduts = Product::orderBy('created_at', 'asc')->take(6)->get();

        //Get price
        $min = isset($_GET['Min']) ? $_GET['Min'] : "0";
        $max = isset($_GET['Max']) ? $_GET['Max'] : "500";

        //Get 9 new products
        if (isset($type[1])) {
            if ($orderprice == "price") {
                $products = Product::select('*', 'products.name AS product_name', 'products.id AS product_id', DB::raw('price - price*sales/100 AS price_discount'))
                    ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
                    ->orderBy('price_discount', $ordersort)
                    ->where('type_id', $type[1])
                    ->whereBetween('price', [$min, $max])
                    ->paginate(6);
            } else {
                $products = Product::select('*', 'products.name AS product_name', 'products.id AS product_id', DB::raw('price - price*sales/100 AS price_discount'))
                    ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
                    ->orderBy($orderprice, $ordersort)
                    ->where('type_id', $type[1])
                    ->whereBetween('price', [$min, $max])
                    ->paginate(6);
            }

            $count = Product::orderBy($orderprice, $ordersort)
                ->where('type_id', $type[1])
                ->whereBetween('price', [$min, $max])
                ->get();

            //price Min,Max product
            $minProduct = Product::where('type_id', $type[1])
                ->min('price');
            $maxProduct = Product::where('type_id', $type[1])
                ->max('price');
        } else {
            if ($orderprice == "price") {
                $products = Product::select('*', 'products.name AS product_name', 'products.id AS product_id', DB::raw('price - price*sales/100 AS price_discount'))
                    ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
                    ->orderBy('price_discount', $ordersort)
                    ->whereBetween('price', [$min, $max])
                    ->paginate(6);
            } else {
                $products = Product::select('*', 'products.name AS product_name', 'products.id AS product_id', DB::raw('price - price*sales/100 AS price_discount'))
                    ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
                    ->orderBy($orderprice, $ordersort)
                    ->whereBetween('price', [$min, $max])
                    ->paginate(6);
            }

            $count = Product::orderBy($orderprice, $ordersort)
                ->whereBetween('price', [$min, $max])
                ->get();

            //price Min,Max product
            $minProduct = Product::min('price');
            $maxProduct = Product::max('price');
        }
        //Get sale off
        $saleOff = Product::select('*', 'products.name AS product_name', 'products.id AS product_id')
            ->leftJoin('protypes', 'protypes.id', '=', 'products.type_id')
            ->where('sales', '>', '0')
            ->orderBy('sales', 'desc')
            ->take(9)
            ->get();
        return view('User.shop-grid', [
            'countAllProduct' => $count,
            'getProtypes' => $protypes,
            'getProducts' => $products,
            'getLatestProduct' => $latestProduts,
            'saleOff' => $saleOff,
            'type' => $type,
            'minproduct' => $minProduct,
            'maxproduct' => $maxProduct,
            'min' => $min,
            'max' => $max,
            'field' => $orderprice,
            'sort' => $ordersort,
        ]);
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
>>>>>>> origin/shop-grid
}
