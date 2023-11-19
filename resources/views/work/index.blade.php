@extends("layout")

@section("title", "Academic Works:Splash")

@section("content")
    @csrf
    <h1> Academic Works Page </h1>

    <div class="row" data-deck>
    <!-- text-center -->
        @auth
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
        @endauth

        <div class="col-sm-6 mt-3" data-last_card>
            <div class="card bg-secondary h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">Load More Entry</h5>
                    <p class="card-text text-muted">Click "Load More" below to reveal more entries</p>
                    <p class="card-text text-info" data-last_card_message>Loading Data</p>
                </div>
                <div class="card-footer p-0">
                    <button type="button" class="btn btn-outline-warning btn-lg btn-block" data-load_more_button>Load More</button>
                </div>
            </div>
        </div>
            
    </div>
@endsection
@section("scripts")
<script>
(()=>{
    let limit = 2;
    let offset = 0;
    
    /**
     * 
     * @param {html_element} _element
     * @param {string} _bs_color 
     * @param {string} _message 
     */
    function render_last_card_message(_element, _bs_color, _message)
    {
        _element.innerHTML = _message;
        _element.setAttribute("class", "card-text text-" + _bs_color);
    }
 
    /**
     * Gather Data For The Cards In The Deck.
     *
     */
    function pullCards()
    {
        let last_card_message = document.querySelector("[data-last_card_message]");

        let formData = new FormData();
        formData.append("limit", limit);
        formData.append("offset", offset);

        fetch("{{ route('work.grabCardsPartial') }}", {
            method: 'POST',
            body: formData,
            headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value}
        })
        .then(response => response.json())
        .then(results => {
            
            if(results.data === undefined) render_last_card_message(last_card_message, "danger", "Could Not Connect To Server");
            else if(results.data.length == 0) render_last_card_message(last_card_message, "warning", "⚠ No Additional Data ⚠");
            else
            {
                fillDeck(results.data);
                offset += limit;
                render_last_card_message(last_card_message, "info", "New Data Has Been Loaded");
            }

        })
        .catch(error => {
            console.error('Error:', error);
            render_last_card_message(last_card_message, "danger", "Failed To Load Data");
        });
    }

    /**
     * Display A Card.
     *
     * @param {dictionary} _results - an array with collapsed authors
     */
    function fillDeck(_results)
    {
        //Go Through all the card details
        for(let i = 0; i < _results.length; i++)
        {
            //Render The Card
            renderCard(_results[i]);
        }
        
        //Keep Moving The last Card to The end of the deck
        let deck = document.querySelector("[data-deck]");
        let card = document.querySelector("[data-last_card]");
        document.querySelector("[data-last_card]").remove();

        deck.appendChild(card);
    }

    /**
     * Display A Card.
     *
     * @param {dictionary} _data - Card Details
     */
    function renderCard(_data)
    {
        //Gather Elements
        let deck = document.querySelector("[data-deck]");

        //Create Elements
        let card_parent = document.createElement("div");
        let card = document.createElement("div");

        let card_body = document.createElement("div");
        let title = document.createElement("h5");
        let academic_work_department = document.createElement("p");
        let description = document.createElement("p");
        let authors = document.createElement("ul");

        let footer = document.createElement("div");
        let more_details_btn = document.createElement("button");

        //Set Attributes
        card_parent.setAttribute("class", "col-sm-6 mt-3");
        card.setAttribute("class", "card bg-secondary h-100");

        card_body.setAttribute("class", "card-body");
        title.setAttribute("class", "card-title");
        academic_work_department.setAttribute("class", "card-text text-muted");
        description.setAttribute("class", "card-text");
        authors.setAttribute("class", "card-text text-muted list-unstyled");

        footer.setAttribute("class", "card-footer p-0");
        more_details_btn.setAttribute("class", "btn btn-outline-light btn-lg btn-block");

        //Set Details
        title.innerHTML = _data.title;
        academic_work_department.innerHTML = "From " + _data.department;
        description.innerHTML = _data.description;
        authors.innerHTML = _data.type_of_work.charAt(0).toUpperCase() + _data.type_of_work.substring(1) + " By";

        more_details_btn.innerHTML = "More Details";

        // Go Through The Authors For Each Row / Academic Work
        for(let i = 0; i < _data.collapsed_authors.length; i++)
        {
            if(i == 5) 
            {
                authors.innerHTML += "<li>And More</li>";
                break;
            }
            else if(_data.collapsed_authors[i] === null)authors.innerHTML += "<li>Anon</li>";
            else if(_data.collapsed_authors[i].name.trim().length == 0)authors.innerHTML += "<li>Anon#</li>";
            else authors.innerHTML += "<li>"+_data.collapsed_authors[i].name+" from "+_data.collapsed_authors[i].department+"</li>";
        }

        //Add Listeners
        more_details_btn.addEventListener("click", ()=>{
            window.location.href = "{{ route('work.show', 0) }}".slice(0, -1) + _data.id;
        });

        //Append Elements
        deck.appendChild(card_parent);
        card_parent.appendChild(card);

        card.appendChild(card_body);
        card_body.appendChild(title);
        card_body.appendChild(academic_work_department);
        card_body.appendChild(description);
        card_body.appendChild(authors);

        card.appendChild(footer);
        footer.appendChild(more_details_btn);
    }

    pullCards();
    document.querySelector("[data-load_more_button]").addEventListener("click", pullCards);
})();
</script>
@endsection