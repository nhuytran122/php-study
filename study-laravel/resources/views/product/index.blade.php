<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>
<body>
    <h1>Index function of ProductController</h1>
    {{-- <h2>Title: {{$title}}</h2> --}}
    {{-- <h3>x = {{$x}}</h3>
    <h3>y = {{$y}}</h3> --}}
    {{-- <h3>Name: {{$name}}</h3> --}}
    <h3>@foreach($products as $item)
        <h3>{{ $item }}</h3>
        @endforeach
    </h3>

    <a href="{{ route('products')}}">Link to Products</a>

    {{-- <h3>Product: {{$product}}</h3> --}}
</body>
</html>