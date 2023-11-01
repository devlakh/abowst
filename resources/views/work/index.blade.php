@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf
    <h1> Academic Works Page </h1>

    <div class="row" data-deck>
    <!-- text-center -->
        <div class="col-sm-6 mt-3">
            <div class="card bg-secondary h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Create New Entry</h5>
                    <p class="card-text text-muted">Click "Create New Entry" below to add an entry</p>
                    <h5 class="card-text">You are currently Looking at some of the latest entry made.</h5>
                </div>
                <div class="card-footer p-0">
                    <a href="{{ route('work.create') }}" class="btn btn-outline-success btn-lg btn-block" role="button">Create New Entry</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 mt-3" data-last_card>
            <div class="card bg-secondary h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Load More Entry</h5>
                    <p class="card-text text-muted">Click "Load More" below to reveal more entries</p>
                    <p class="card-text text-info" data-last_card_message>Loading Data</p>
                </div>
                <div class="card-footer p-0">
                    <button type="button" class="btn btn-outline-warning btn-lg btn-block" data-load_more_btn>Load More</button>
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

    document.querySelector("[data-load_more_btn]").addEventListener("click", (event)=>{
        index.pullCards();
    });
</script>
@endsection