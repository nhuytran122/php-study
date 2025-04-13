<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return view('index');
    }

    public function about(){
        $name = 'Nhu Y';
        $names = array('Hoang', 'Khoa', 'Khanh', 'Minh');
        // return view('about')->with('name', $name);
        return view('about', [
            'names'=>$names,
        ]);
    }
}