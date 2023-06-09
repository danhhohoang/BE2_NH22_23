<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Protype;
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

   
}