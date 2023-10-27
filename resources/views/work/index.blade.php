@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf
    <h1> Academic Works Page </h1>

    <a class="nav-link" href="{{ route('work.create') }}">Add Academic Works</a>

    <div data-deck>

    </div>
@endsection

@section("scripts")
<script src="{{ url('template_resource/work/index.js') }}"></script>
<script>
    var index = new Index({
        "grabCardsPartial":"{{ route('work.grabCardsPartial') }}"
    });
</script>
@endsection