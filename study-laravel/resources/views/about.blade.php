@extends('layouts.app')

@section('content')
    <h1>About Page</h1>
{{-- 
    {{
        $x = 10;
    }}
    @if($x > 2)
        <h3>
            x is grater than 2
        </h3>
    @elseif($x < 10)
        <h3>
            x is less than 10
        </h3>
    @else
        <h3>All conditions are not match</h3>
    @endif

    @unless(empty($name))
        <h3>Name is not empty</h3>
    @endunless

    @if(!empty($name))
        <h3>Name is not empty</h3>
    @endif

    @empty(!$name)
        <h3>Name is {{$name}}</h3>
    @endempty

    @empty($age)
        <h3>Age is empty</h3>
    @endempty

    @isset($name)
        <h3>Name has been set</h3>
    @endisset

    @switch($name)
        @case('Nhu Y')
            <h3>This is Nhu Y</h3>
            @break
        @default
            <h3>No one selected</h3>
    @endswitch

    @for($i = 0; $i < 20; $i++)
        <h2>
            i = {{$i}}
        </h2>
    @endfor --}}

    @foreach($names as $name)
        <h2>
            {{$name}}
        </h2>
    @endforeach

    {{-- Ít dùng --}}
    @forelse ($names as $name)
        <h2>
            {{$name}}
        </h2>
    @empty
        <h3>The array is empty</h3>
    @endforelse

    {{ $i = 0 }}
    @while($i < 10)
        <h3>
            i = {{$i}}
        </h3>
        {{$i++}}
    @endwhile
@endSection