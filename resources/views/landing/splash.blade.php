@extends("layout")

@section("title", "ABOWST : Welcome")

@section("content")
    <h1> Splash Page </h1>

    <a class="nav-link" href="{{ route('work.index') }}">Schorlarly Texts</a>
@endsection