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

        <button id="add_author" type="button" class="btn btn-warning" data-toggle="modal" data-target="#authors_modal">
            Add Author
        </button>

        <!-- AUTHORS CONTAINER -->
        <div class="row" data-authors>

        </div>

        <button type="button" class="btn btn-success mt-3" data-submit_btn>Submit</button>

        </form>
    
    </div>


    <!-- MODAL START-->
    <div class="modal fade" id="authors_modal" tabindex="-1" role="dialog" aria-labelledby="authors_modal_Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="authors_modal_Title">Enter Authors Information</h5>
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
                    <button type="button" class="btn btn-danger mx-3" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning mx-3" data-insert_author_btn>Insert Author</button>
            </div>
        </div>
    </div>
    </div>
    <!-- MODAL END-->

@endsection
@section("scripts")
<script>
//@TODO GET THIS INTO A lambda insta function to keep data in memory
(()=>{
    //Event Listeners
    document.querySelector("[data-submit_btn]").addEventListener("click", submit);
    document.querySelector("[data-insert_author_btn]").addEventListener("click", insert_author);

    //Used for emulating DB Like Behavior
    //on author removal , authors[index] = null
    //Needed to keep index in memory in line
    let authors = [];

    function submit()
    {
        console.log(authors);
        return;
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

    /**
     * Gather Data from the model and insert it into authors{}
     */
    function insert_author()
    {
        let author = {
            "prefix":document.querySelector("[data-modal_prefix]").value
            ,"given_name":document.querySelector("[data-modal_given_name]").value
            ,"middle_name":document.querySelector("[data-modal_middle_name]").value
            ,"last_name":document.querySelector("[data-modal_last_name]").value
            ,"suffix":document.querySelector("[data-modal_suffix]").value
            ,"date_of_birth":document.querySelector("[data-modal_dob]").value
            ,"department":document.querySelector("[data-modal_department]").value
            ,"is_lead":false
        };

        //Check if Empty
        if(document.querySelector("[data-modal_dob]").value == "") author.date_of_birth = null;

        authors.push(author);

        render_author(
            author.prefix +" "+ author.given_name +" "+ author.middle_name +" "+ author.last_name +" "+ author.suffix
            ,author.date_of_birth
            ,author.department
            ,authors.length-1  
        );
    }

    /**
     * Renders an Author and Sets Listeners For Buttons
     * 
     * @param {string} _name
     * @param {date} _dob
     * @param {string} _department
     * @param {integer} _index
     */
    function render_author(_name, _dob ,_department, _index)
    {
        let deck = document.querySelector("[data-authors]");

        deck.appendChild((() => {
            //Card Parent and Container
            let card_parent = createAndSetElement("div", "class", "col-lg-12 mt-3 "); 
            let card = createAndSetElement("div", "class", "card bg-secondary h-100 border-warning"); card.setAttribute("data-author_card", "");

            card_parent.appendChild(card);

            //Card Body and Details
            let card_body = createAndSetElement("div", "class", "card-body");
            let name = createAndSetElement("h5", "class", "card-title", _name);
            let dob = createAndSetElement("p", "class", "card-text text-muted", _dob);
            let authorship = createAndSetElement("p", "class", "card-text", "Author"); authorship.setAttribute("data-authorship", "");
            let department = createAndSetElement("p", "class", "card-text", _department);

            card.appendChild(card_body);
            card_body.appendChild(name);
            card_body.appendChild(dob);
            card_body.appendChild(authorship);
            card_body.appendChild(department);

            //Card Footer and Buttons
            let card_footer = createAndSetElement("div", "class", "card-footer text-right py-1");
            let make_lead_btn = createAndSetElement("button", "class", "btn btn-sm btn-info mr-3", "♕ | Set As Lead Author"); make_lead_btn.setAttribute("type", "button");
            let remove_btn = createAndSetElement("button", "class", "btn btn-sm btn-danger", "⛒ | Remove"); remove_btn.setAttribute("type", "button");
            
            card.appendChild(card_footer);
            card_footer.appendChild(make_lead_btn);
            card_footer.appendChild(remove_btn);

            make_lead_btn.addEventListener("click", ()=>{ set_as_lead(card, authorship, _index); });
            remove_btn.addEventListener("click", ()=>{ remove_author(card_parent, _index); });

            return card_parent;
        })());
    }

    /**
     * Declare a Lead Author
     * 
     * @param {html_element} _card - not the parent
     * @param {int} _index
     */
    function set_as_lead(_card, _authorship_text, _index)
    {
        document.querySelectorAll("[data-author_card]").forEach(element => { element.setAttribute("class", "card bg-secondary h-100 border-warning"); });
        _card.setAttribute("class", "card bg-secondary h-100 border-info");

        document.querySelectorAll("[data-authorship]").forEach(element => { element.innerHTML = "Author"; });
        _authorship_text.innerHTML = "Lead Author";

        authors.forEach(author => { if(author != null) author.is_lead = false; });
        authors[_index].is_lead = true;
    }

    /**
     * Emulate DB Like removal, Keeps the index in memory
     * 
     * @param {html_element} _card_parent
     * @param {int} _index
     */
    function remove_author(_card_parent, _index)
    {
        authors[_index] = null;
        _card_parent.remove();
    }

    /**
     * Creates a new Dictionary with all the null indexes excluded
     * 
     * @param {dictionary} _list - dictionary with a bunch of null values
     * @return {dictionary} - Dictionary with all the null Removed
     */
    function clean_list(_list)
    {
        var clean_list = []
        for(var i = 0; i < _list.length; i++)
        {
            if (_list[i] != null) clean_list.push(_list[i]);
        }
        return clean_list;
    }
})();
</script>
@endsection