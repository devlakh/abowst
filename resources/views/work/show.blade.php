@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf

    <div class="row text-left" data-deck>
    
        <div class="col-lg-12 mt-3">
            <h1>{{ $data->title }}</h1>
            <h5 class="text-muted">{{ $data->type_of_work }} From {{ $data->department }}</h5>
            <p class="text-muted">{{ $data->date }}</p>
        </div>

        <div class="col-lg-12 mt-3">
            <div class="card bg-secondary h-100 text-center">
                <div class="card-header">
                    <p class="text-sm">{{ $data->description }}</p>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $data->abstract }}</p>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row text-left" data-deck>
    
        <div class="col-lg-12 mt-3">
            <p class="text-muted">Authors :</p>
        </div>

    </div>

    <div class="row" data-deck>
    
        @foreach ($data->collapsed_authors as $author)
        <div class="col-lg-12 mt-3">
            <div class="card bg-secondary h-100 text-left">
                <div class="card-body">
                    <h5 class="card-title">{{ $author->name }}</h5>
                    <p class="card-text">Born {{ $author->dob }}</p>
                    <p class="card-text">From {{ $author->department }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
@section("scripts")
<script>
class Show
{
    constructor()
    {

    }
}
var show = new Show();
</script>
@endsection