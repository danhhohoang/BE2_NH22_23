<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use App\Models\Protype;
use Illuminate\Http\Request;
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
}
