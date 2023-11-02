@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf
    

    <div class="row text-center" data-deck>
    
        <div class="col-sm-12 mt-3">
            <h1> Title </h1>
            <h5 class="text-muted">Type Of Work</h5>
            <div class="clearfix hidden-xs hidden-sm"></div>
            <h5 class="">Description</h5>
        </div>
        
    </div>

    <div class="row" data-deck>

        <div class="col-lg-6 mt-3">
            <div class="card bg-secondary h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Author Name</h5>
                    <p class="card-text text-muted">Born mm/dd/yyyy</p>
                    <p class="card-text">From Department</p>
                </div>
            </div>
        </div>
        
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