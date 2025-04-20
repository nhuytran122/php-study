@extends('layouts.app')

@section('content')
    <h1>Show detail food</h1>
    <h3>Name: {{$food->name}}</h3>
    <h3>Count: {{$food->count}}</h3>
    <h3>Description: {{$food->description}}</h3>
    <h3>Category name: {{$food->category->name}}</h3>
    <img src="{{ asset('images/' . $food->image_path) }}" alt="">
@endsection