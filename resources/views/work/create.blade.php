@extends("layout")

@section("title", "Academic Works:Create Entry")

@section("content")
    @csrf
    <div class="card bg-secondary mt-3">

    <form class="card-body" action="">
    
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter Academic Title" data-title>
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" data-date>
    </div>

    <div class="form-group">
        <label for="department">Department</label>
        <input type="text" class="form-control" id="department" placeholder="Enter Department" data-department>
    </div>

    <div class="form-group">
        <label for="type">Type of Academic Text</label>
        <select id="type" class="form-control" data-type_of_work>
            <option value="" disabled selected>Type of Academic Text</option>
            <option value="thesis">Thesis</option>
            <option value="capstone">Capstone</option>
            <option value="dissertation">Dissertation</option>
            <option value="journal">Journal</option>
        </select>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="1" data-description></textarea>
    </div>

    <div class="form-group">
        <label for="abstract">Abstract</label>
        <textarea class="form-control" id="abstract" rows="3" data-abstract></textarea>
    </div>

    <div class="form-group">
        <label for="add_author">The Button Below Opens the Menu For Declaring Authors</label>
    </div>

    <div class="form-group">
        <button id="add_author" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add Author
        </button>
    </div>

    <div class="form_group">
        <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">DOB</th>
            <th scope="col">Department</th>
            <th scope="col">Evict</th>
          </tr>
        </thead>
        <tbody data-authors>
        </tbody>
        </table>
    </div>

    <button type="button" class="btn btn-primary" onclick="submit_btn();">Submit</button>

    </form>
    
    </div>


    <!-- MODAL START-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header bg-dark">
            <h5 class="modal-title" id="exampleModalLongTitle">Enter Authors Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body bg-dark">
        <form>
            
            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                        <label for="modal_prefix">Prefix</label>
                        <input type="text" class="form-control" id="modal_prefix" placeholder="Eng. / Dr. / Bro / Dude" data-modal_prefix>
                    </div>
                    <div class="col">
                        <label for="modal_suffix">Suffix</label>
                        <input type="text" class="form-control" id="modal_suffix" placeholder="Jr. / Sr. / iii / xxvii" data-modal_suffix>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="modal_given_name">Given Name</label>
                <input type="text" class="form-control" id="modal_given_name" placeholder="Enter Given Name" data-modal_given_name>
            </div>

            <div class="form-group">
                <label for="modal_middle_name">Middle Name</label>
                <input type="text" class="form-control" id="modal_middle_name" placeholder="Enter Middle Name" data-modal_middle_name>
            </div>

            <div class="form-group">
                <label for="modal_last_name">Last Name</label>
                <input type="text" class="form-control" id="modal_last_name" placeholder="Enter Last Name" data-modal_last_name>
            </div>

            <div class="form-group">
                <label for="modal_dob">Date of Birth</label>
                <input type="date" class="form-control" id="modal_dob" data-modal_dob>
            </div>

            <div class="form-group">
                <label for="modal_department">Department</label>
                <input type="text" class="form-control" id="modal_department" placeholder="Enter Department" data-modal_department>
            </div>

        </form>
        </div>
        <div class="modal-footer bg-dark">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="insert_author();">Insert</button>
        </div>
        </div>
    </div>
    </div>
    <!-- MODAL END-->

@endsection
@section("scripts")
<script>

//Used for emulating DB Like Behavior
//on author removal , authors[index] = null
//Needed to keep index in memory in line
var authors = [];

function submit_btn()
{
    let formData = new FormData();
    formData.append("academic_work", JSON.stringify({
        "title":document.querySelector("[data-title]").value
        ,"date":document.querySelector("[data-date]").value
        ,"department":document.querySelector("[data-department]").value
        ,"type_of_work":document.querySelector("[data-type_of_work]").value
        ,"description":document.querySelector("[data-description]").value
        ,"abstract":document.querySelector("[data-abstract]").value
    }));
    formData.append("authors", JSON.stringify(clean_list(authors)));

    fetch("{{ route('work.store') }}", {
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
        
}

//Father the data from the modal
function insert_author()
{
    var author = {
        "prefix":document.querySelector("[data-modal_prefix]").value
        ,"given_name":document.querySelector("[data-modal_given_name]").value
        ,"middle_name":document.querySelector("[data-modal_middle_name]").value
        ,"last_name":document.querySelector("[data-modal_last_name]").value
        ,"suffix":document.querySelector("[data-modal_suffix]").value
        ,"date_of_birth":document.querySelector("[data-modal_dob]").value
        ,"department":document.querySelector("[data-modal_department]").value
    };

    authors.push(author);

    render_author(
        author.prefix +" "+ author.given_name +" "+ author.middle_name +" "+ author.last_name +" "+ author.suffix
        ,author.date_of_birth
        ,author.department
        ,authors.length-1   
    );
}

//Create tags to display the inserted author
function render_author(_name, _dob, _department, _index)
{
    var args = [_name, _dob, _department];
    var tbody = document.querySelector("[data-authors]");

    tbody.appendChild((() => {
        var tr = document.createElement("tr");

        for (var i = 0; i < args.length; i++)
        {
            tr.appendChild((()=>{
            var td = document.createElement("td");
            td.innerHTML = args[i];
            return td;
            })());
        } 

        tr.appendChild((()=>{
            var td = document.createElement("td");
            var button = document.createElement("button");

            button.innerText = "x";
            button.setAttribute("type" , "button");
            button.setAttribute("class" , "btn btn-danger");
            button.addEventListener("click", (event)=>{
                remove_author(button, _index)
                event.preventDefault(); 
            });

            td.appendChild(button);
            return td;
        })());

        return tr;
    })());
}

//Emulate DB Like removal
//Keeps the index in memory
function remove_author(_button, _index)
{
    _button.parentElement.parentElement.remove();
    authors[_index] = null;
}

function clean_list(_list)
{
    var clean_list = []
    for(var i = 0; i < _list.length; i++)
    {
        if (_list[i] != null) clean_list.push(_list[i]);
    }
    return clean_list;
}
</script>
@endsection