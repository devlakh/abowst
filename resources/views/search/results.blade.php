@extends("layout")

@section("title", "ABOWST : Search Results")

@section("content")
    @csrf
    <h5 class="mt-3"> Results for {{ request()->get('query') }} </h5>
@endsection

@section("scripts")
<script>
(()=>{
    let query = "{{ request()->get('query') }}";
    let filters = {};
    document.querySelector("[data-input_field]").value = query;

    let formData = new FormData();
    formData.append("query", query);
    formData.append("filters", JSON.stringify(filters));

    fetch("{{ route('search.query') }}", {
        method: 'POST',
        body: formData,
        headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value}
    })
    .then(response => response.json())
    .then(results => {
        
        console.log(results);

    })
    .catch(error => {
        console.error('Error:', error);
    });

})();
</script>
@endsection