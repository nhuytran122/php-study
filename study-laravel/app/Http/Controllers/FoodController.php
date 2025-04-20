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
        // return view('food.index',[
        //     'foods' => $foods
        // ]);
        return response()->json([
            'foods' => $foods
        ]);
    }

    public function show($id){
        $food = Food::find($id);
        if (!$food) {
            return response()->json([
                'message' => 'Food not found!'
            ], 404);
        }
        // return view('food.show')->with('food', $food);
        return response()->json([
            'food' => $food
        ]);
    }

    public function create(){
        $categories = Category::all();
        return view('food.create')->with('categories', $categories);
    }
    // public function store(CreateValidationRequest $request){
        // dd($request->all());
    public function store(Request $request){
        // $food = new Food();
        // $food->name = $request->input('name');
        // $food->description = $request->input('description');
        // $food->count = $request->input('count');

        // $request->validate([
        //     'name' => new Uppercase,
        //     'count' => 'required|integer|min:0|max:1000',
        //     'category_id' => 'required',
        // ]);

        // dd($request->file('image')->guessExtension());
        // dd($request->file('image')->getSize());
        // dd($request->file('image')->getError());
        // dd($request->file('image')->isValidId());

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'count' => 'required|integer|min:0|max:1000',
            'category_id' => 'required',
            'image' => 'required|mimes:jpg,png,png,jpeg|max:5048'
        ]);

        $generatedImageName = $this->uploadImage($request->file('image'), $request->input('name'));
        $food = Food::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'count' => $request->input('count'),
            'category_id' => $request->input('category_id'),
            'image_path' => $generatedImageName
        ]);
        $food->save();
        // return redirect('/foods');
        return response()->json([
            'message' => 'Food created successfully',
            'food' => $food
        ], 201);
    }

    public function edit($id){
        $food = Food::find($id)->first();
        if (!$food) {
            return response()->json([
                'message' => 'Food not found!'
            ], 404);
        }
        // return view('food.edit')->with('food', $food);
        return response()->json([
            'food' => $food
        ]);
    }

    public function update(CreateValidationRequest $request, $id){
    // public function update(Request $request, $id){
        // dd($request->all());
        $request->validated();
        $food = Food::find($id);
        if (!$food) {
            return response()->json([
                'message' => 'Food not found!'
            ], 404);
        }
        $food->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'count' => $request->input('count'),
            'category_id' => $request->input('category_id'),
            'image_path' => $request->hasFile('image') ? $this->uploadImage($request->file('image'), $food->name) : $food->image_path
        ]);
        // return redirect('/foods');
        return response()->json([
            'message' => 'Food updated successfully',
            'food' => $food
        ], 200);
    }

    public function destroy($id){
        $food = Food::find($id);
        if (!$food) {
            return response()->json([
                'message' => 'Food not found!'
            ], 404);
        }
        $food->delete();
        // return redirect('/foods');
        return response()->json([
            'message' => 'Food deleted successfully'
        ], 200);
    }
    private function uploadImage($image, $foodName){
        $generatedImageName = 'image' . time() . '-' . $foodName . '.' . $image->extension();
        $image->move(public_path('images'), $generatedImageName);
        return $generatedImageName;
    }
}