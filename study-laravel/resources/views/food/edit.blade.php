@extends('layouts.app')

@section('content')
    <h1>Update a food</h1>

    <form action="/foods/{{ $food->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label>Food name</label>
          <input type="text"
            name="name" class="form-control" 
            value="{{$food->name ?? ""}}"
            placeholder="Enter food's name">
        </div>
        <div class="form-group">
          <label>Description</label>
          <input type="text"
            name="description" class="form-control" 
            value="{{$food->description ?? ""}}"
            placeholder="Enter food's description">
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number"
              name="count" class="form-control" 
              value="{{$food->count ?? ""}}"
              placeholder="Enter food's count">
          </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
@endsection