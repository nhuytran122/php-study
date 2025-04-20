<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FoodController;

// Route::get('/', [PageController::class, 'index']);
// Route::get('/about', [PageController::class, 'about']);
// Route::get('/posts', [PostController::class, 'index']);
// Route::resource('/foods', FoodController::class);

// // Route::get('/', function () {
// //     return view('home');
// //     // return env('APP_NAME');
// // });

// Route::get('/users', function(){
//     return 'This is users page';
// });

// // Route::get('/foods', function(){
// //     return ['apple', 'lemon'];
// // });

// Route::get('/about-me', function(){
//     return response()->json(
//         [
//             'name'=> 'Nhu Y',
//             'age'=> 22
//         ]
//     );
// });

// Route::get('/something', function(){
//     return redirect('/foods');
// });

// Route::get('/products', [
//     ProductController::class,
//     'index' //hàm thực thi
// ])->name('products');

// Route::get('/products/{id}', [
//     ProductController::class,
//     'detail'
// ])->where('id', '[0-9]+');

// Route::get('/products/{keyword}', [
//     ProductController::class,
//     'search'
// ])->where('keyword', '[a-zA-Z0-9]+');

// //VD validate nhiều tham số
// // Route::get('/products/{keyword}/{id}', [
// //     ProductController::class,
// //     'search'
// // ])->where([
// //     'keyword', '[a-zA-Z0-9]+',
// //     'id', '[0-9]+'
// // ]);