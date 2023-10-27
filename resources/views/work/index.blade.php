@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf
    <h1> Academic Works Page </h1>

    <a class="nav-link" href="{{ route('work.create') }}">Add Academic Works</a>

@endsection

@section("scripts")
<script>
(()=>{

    let formData = new FormData();
    formData.append("limit", 3);
    formData.append("offset", 7);

    fetch("{{ route('work.grabCardsPartial') }}", {
        method: 'POST',
        body: formData,
        headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value}
    })
    .then(response => response.json())
    .then(results => {
        console.log('Success:', results);
    })
    .catch(error => {
        console.error('Error:', error);
    });

})();
</script>
@endsection