<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $title = 'Some products';
        $x = 1;
        $y = 2;
        $name = 'Nhu Y';
        // return view('product.index', compact('title', 'x', 'y'));

        //with: chỉ truyền đc 1 para
        // return view('product.index')->with('name', $name);

        // Truyền 1 mảng dạng đối tượng
        $products = [
            'name' =>  'iPhone 15',
            'year' => '2023',
            'isFavorited' => true
        ];
        // return view('product.index', compact('products'));

        print_r(route('products'));
        // Truyền trực tiếp
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function detail($id){
        // return "product's id = " .$id;
        $product = [
            'name' =>  'iPhone 16',
            'year' => '2023'
        ];
        // return view('product.index', compact('products'));

        // Truyền trực tiếp
        return view('product.index', [
            'products' => $product
        ]);
    }

    // public function search($keyword){
    //     // return "product's id = " .$id;
    //     $products = [
    //         'iphone 15' =>  'iPhone 16',
    //         'samsung' => 'samsung'
    //     ];
    //     return view('product.index', [
    //         'product' => $products[$keyword] ?? 'Dont have'
    //     ]);
    // }
}