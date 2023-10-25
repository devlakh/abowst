@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    <h1> Academic Works Page </h1>

    <a class="nav-link" href="{{ route('work.create') }}">Add Academic Works</a>
    <br/>

    @if (count($papers) != 0)
        <ul>
        @foreach($papers as $paper)
            <li>{{ $paper["title"] }}</li>
        @endforeach
        </ul>

    @else

        <h3>No Data</h3>

    @endif
    
@endsection