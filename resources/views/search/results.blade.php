@extends("layout")

@section("title", "ABOWST : Search Results")

@section("content")
    @csrf
    <div class="form-inline my-2">
        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#filterModal"><i class="fas fa-filter"></i></button>
        <h5 class="mt-1 ml-2">Results for {{ request()->get('query') }}</h5>
    </div>
    <div class="deck">
        <div class="card bg-dark mt-3">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <small class="card-text text-muted">search relationship</small>
            </div>
            <div class="card-footer p-0 m-0">
                <button class="btn btn-info btn-block btn-sm">More Details</button>
            </div>
        </div>
    </div>
    

    <!-- Modal Start -->
    <div class="modal fade pr-0" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Set Filters</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <div class="dropdown col-6" id="type_of_work_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-field_button>
                            Specific Fields
                        </button>
                        <form class="dropdown-menu">

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="id" id="idCheck" data-filter-field>
                                <label class="form-check-label" for="idCheck">Entry ID</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="title" id="titleCheck" data-filter-field>
                                <label class="form-check-label" for="titleCheck">Title</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="department" id="departmentCheck" data-filter-field>
                                <label class="form-check-label" for="departmentCheck">Department</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="language" id="languageCheck" data-filter-field>
                                <label class="form-check-label" for="languageCheck">Language</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="description" id="descriptionCheck" data-filter-field>
                                <label class="form-check-label" for="descriptionCheck">Description</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="abstract" id="abstractCheck" data-filter-field>
                                <label class="form-check-label" for="abstractCheck">Abstract</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="name" id="nameCheck" data-filter-field>
                                <label class="form-check-label" for="nameCheck">Author Name</label>
                            </div>

                        </form>
                    </div>
                    <label class="col-6 col-form-label" for="type_of_work_dropdown">Specific Fields</label>
                </div>

                <div class="form-group row">
                    <div class="dropdown col-6" id="type_of_work_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-type_of_work_button>
                            Type Of Work
                        </button>
                        <form class="dropdown-menu">

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="thesis" id="thesisCheck" data-filter-type_of_work>
                                <label class="form-check-label" for="thesisCheck">Thesis</label>
                            </div>
                            
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="capstone" id="capstoneCheck" data-filter-type_of_work>
                                <label class="form-check-label" for="capstoneCheck">Capstone</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="dissertation" id="dissertationCheck" data-filter-type_of_work>
                                <label class="form-check-label" for="dissertationCheck">Dissertation</label>
                            </div>

                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="journal" id="journalCheck" data-filter-type_of_work>
                                <label class="form-check-label" for="journalCheck">Journal</label>
                            </div>

                        </form>
                    </div>
                    <label class="col-6 col-form-label" for="type_of_work_dropdown">Type Of Work</label>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" id="startDate" data-filter-start_date>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" id="endDate" data-filter-end_date>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-set_filters>Set Filters</button>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal End -->
@endsection

@section("scripts")
<script>
(()=>{
    document.querySelectorAll('[data-filter-field]').forEach((element) => {
        element.addEventListener("change", ()=>{
            let selected = document.querySelectorAll('[data-filter-field]:checked').length;
            if(selected > 0) document.querySelector("[data-field_button]").innerHTML = selected + " Selected";
            else document.querySelector("[data-field_button]").innerHTML = "Specfic Fields";
        });
    });

    document.querySelectorAll('[data-filter-type_of_work]').forEach((element) => {
        element.addEventListener("change", ()=>{
            let selected = document.querySelectorAll('[data-filter-type_of_work]:checked').length;
            if(selected > 0) document.querySelector("[data-type_of_work_button]").innerHTML = selected + " Selected";
            else document.querySelector("[data-type_of_work_button]").innerHTML = "Type Of Work";
        });
    });

    document.querySelector("[data-set_filters]").addEventListener("click", ()=>{
        setFilters();
        query();
    });

    let limit = 10;
    let offset = 0;
    let page = 1;
    let query_statement = "{{ request()->get('query') }}";
    let filters = {};
    document.querySelector("[data-input_field]").value = query_statement;

    query();

    function query()
    {
        let formData = new FormData();
        formData.append("limit", limit);
        formData.append("offset", offset);
        formData.append("query", query_statement);
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
    }

    /**
     * Gather Filters and add them to filters[]
     */
    function setFilters()
    {
        filters["field"] = [];
        document.querySelectorAll('[data-filter-field]:checked').forEach((element) => filters["field"].push(element.value));

        filters["type_of_work"] = [];
        document.querySelectorAll('[data-filter-type_of_work]:checked').forEach((element) => filters["type_of_work"].push(element.value));

        filters["start_date"] = document.querySelector("[data-filter-start_date]").value;
        filters["end_date"] = document.querySelector("[data-filter-end_date]").value;
    }

    
})();
</script>
@endsection