@extends("layout")

@section("title", "ABOWST : Login")

@section("content")
    
    <div class="row h-100 mt-5 pt-5">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <form class="card bg-secondary h-100" action="{{ route('user.login') }}" method="post">
            @csrf
                <div class="card-header text-center">
                    Login
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Login</button>
                    @if($errors->any())
                    <div class="text-left text-warning">
                        @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                    </div> 
                    @endif

                    @if(session()->has("err"))
                    <div class="text-left text-info">
                        <div>{{ session('err') }}</div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-sm-2"></div>
        
    </div>

@endsection
@section("scripts")
<script>
</script>
@endsection