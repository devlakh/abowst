@extends("layout")

@section("title", "ABOWST : Welcome")

@section("content")
    @csrf
    <h1 class="text-center mt-5"> A Collection of Academic Texts </h1>

    <a class="nav-link" href="{{ route('work.index') }}">Academic Works</a>
    <a class="nav-link" href="{{ route('user.login_page') }}">Login</a>
    <a class="nav-link" href="{{ route('user.logout') }}">Logout</a>
@endsection
@section("scripts")
<script>
</script>
@endsection