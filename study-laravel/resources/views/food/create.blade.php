@extends('layouts.app')

@section('content')
    <h1>Create food</h1>

    <form action="/foods" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label>Image</label>
          <input type="file"
            name="image" class="form-control">
        </div>
        <div class="form-group">
          <label>Food name</label>
          <input type="text"
            name="name" class="form-control" placeholder="Enter food's name">
        </div>
        <div class="form-group">
          <label>Description</label>
          <input type="text"
            name="description" class="form-control" placeholder="Enter food's description">
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number"
              name="count" class="form-control" placeholder="Enter food's count">
        </div>
        <div class="form-group">
          <label>Choose a category</label>
          <select name="category_id" class="form-control">
            @foreach($categories as $category)
              <option value="{{ $category->id }}">
                {{ $category->name }}
              </option>
            @endforeach
            
          </select>
      </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
      @if($errors->any())
        <div>
          @foreach($errors->all() as $error)
            <p class="text-danger">
              {{ $error }}
            </p>

          @endforeach
        </div>
      @endif
@endsection