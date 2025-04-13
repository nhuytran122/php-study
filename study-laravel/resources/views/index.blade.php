@extends('layouts.app')

@section('content')
    <h1>HomePage</h1>
    {{ print_r(URL(''))}}
    <img src="{{ asset('storage/Kim-Ji-Won-6.jpg')}}"
        width="100"
        height="100"
        alt="">
@endSection