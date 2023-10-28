@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf
    <h1> Academic Works Page </h1>

    <div data-deck>
        <div class="row" data-initial_row>

            <div class="col-sm-6 mt-3">
                <div class="card border-light bg-secondary h-100">
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link p-0 mb-3" href="{{ route('work.create') }}">New Entry +</a></h5>
                        <p class="card-text text-muted">Click "New Entry +" above to add an entry</p>
                        <p class="card-text">You are currently Looking at some of the latest entry made.</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mt-3" data-last_card>
                <div class="card border-warning bg-secondary h-100">
                    <div class="card-body">
                        <h5 class="card-title"><a class="nav-link p-0 mb-3" href="">Show More Entries</a></h5>
                        <p class="card-text text-muted">Loads Additional Entries</p>
                        <p class="card-text">You are currently Looking at some of the latest entry made.</p>
                    </div>
                </div>
            </div>
            
        </div>
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