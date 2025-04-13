@extends('layouts.app')

@section('content')
    <h1>This is Foods Page</h1>
    <a href="foods/create" class="btn btn-success mb-3">Create a new food</a>
    <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Count</th>
            <th scope="col">Category Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
          <tr>
            <th scope="row">{{ $food->id }}</th>
            <td>{{ $food->name }}</td>
            <td>{{ $food->description }}</td>
            <td>{{ $food->count }}</td>
            <td>{{ $food->category->name}}</td>
            <td class="d-flex gap-2">
              <a href="/foods/{{ $food->id }}" class="btn btn-success btn-sm">View</a>
                <a href="foods/{{ $food->id }}/edit"class="btn btn-warning btn-sm">Edit</a>
                <form action="/foods/{{ $food->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
@endsection