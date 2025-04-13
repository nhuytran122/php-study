<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateValidationRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Rules\Uppercase;

class FoodController extends Controller
{
    public function index(){
        $foods = Food::all();
        // $foods = Food::where('name', '=', 'sushi')
        //             -> firstOrFail(); // chỉ trả về 1 phần tử, hạn chế dùng
        return view('food.index',[
            'foods' => $foods
        ]);
    }

    public function show($id){
        $food = Food::find($id);
        return view('food.show')->with('food', $food);
    }

    public function create(){
        $categories = Category::all();
        return view('food.create')->with('categories', $categories);
    }
    public function store(CreateValidationRequest $request){
    // public function store(Request $request){
        // $food = new Food();
        // $food->name = $request->input('name');
        // $food->description = $request->input('description');
        // $food->count = $request->input('count');

        // $request->validate([
        //     'name' => new Uppercase,
        //     'count' => 'required|integer|min:0|max:1000',
        //     'category_id' => 'required',
        // ]);

        $request->validated();

        $food = Food::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'count' => $request->input('count'),
            'category_id' => $request->input('category_id')
        ]);
        $food->save();
        return redirect('/foods');
    }

    public function edit($id){
        $food = Food::find($id)->first();
        return view('food.edit')->with('food', $food);
    }

    public function update(CreateValidationRequest $request, $id){
    // public function update(Request $request, $id){
        $request->validated();
        $food = Food::where('id', $id)
                    ->update([
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'count' => $request->input('count')
                    ]);
        return redirect('/foods');
    }

    public function destroy($id){
        $food = Food::find($id);
        $food->delete();
        return redirect('/foods');
    }
}