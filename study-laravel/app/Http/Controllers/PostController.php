<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(){
        // Query builder
        // $posts = DB::select('select * from posts WHERE id = :id;', 
        // [
        //     'id' => 3
        // ]);

        //C2
        $posts = DB::table("posts")
                    ->where("id", 1)
                    ->select('title')
                    ->get();
        
        $posts = DB::table("posts")
                    ->where("created_at", ">", now()->subDay())
                    ->select('title')
                    ->get();

        $posts = DB::table("posts")
                    ->where("created_at", ">", now()->subDay())
                    ->orWhere('id', '>', 1)
                    ->select('title')
                    ->get();
                    
        $posts = DB::table("posts")
                    ->whereBetween("id", [1, 3])
                    ->get();

        $posts = DB::table("posts")
                    ->whereNotNull("body")
                    ->orderBy('id', 'desc')
                    ->get();

        $posts = DB::table("posts")
                    ->latest()
                    ->get();
                    
        $posts = DB::table("posts")
                    ->oldest()
                    ->get();

        $posts = DB::table("posts")
                    ->whereNotNull("body")
                    ->oldest()
                    ->first();
                    // ->get();

        $posts = DB::table("posts")
                    ->find(3); // find by id
        
        $posts = DB::table("posts")
                    ->count(); // select count(*)

        $posts = DB::table("posts")
                    ->max('id'); 
        $posts = DB::table("posts")
                    ->min('id'); 
        $posts = DB::table("posts")
                    ->sum('id');
        $posts = DB::table("posts")
                    ->avg('id'); 

        $posts = DB::table("posts")
                    ->insert([
                        'title' => "haha",
                        'body' => "abcdef"
                    ]);
                    
        $posts = DB::table("posts")
                    ->where('id', '=', 5)
                    ->update([
                        'title' => 'haha title',
                        'body' =>'xyz'
                    ]); 
        dd($posts); //dd: die dump
        return view('post.index');
    }
}