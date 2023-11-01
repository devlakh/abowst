class Index
{
    /**
     * 
     * @TODO - Modal For More Details 
     * @TODO - Modal For Message After Inserting Data
     * or
     * @TODO - Redirect to Success After Inserting Data
     * 
     */
    constructor(_links)
    {
        /**
         * Contains a list of url
         * @type {Dictionary}
         */ 
        this.links = _links;
        this.limit = 5;
        this.offset = 0;

        this.pullCards();
    }

    /**
     * Gather Data For The Cards In The Deck.
     *
     */
    pullCards()
    {
        let formData = new FormData();
        formData.append("limit", this.limit);
        formData.append("offset", this.offset);

        fetch(this.links.grabCardsPartial, {
            method: 'POST',
            body: formData,
            headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value}
        })
        .then(response => response.json())
        .then(results => {
            let last_card_message = document.querySelector("[data-last_card_message]");

            if(results.data.length != 0)
            {
                this.fillDeck(results.data);
                this.offset += this.limit;
                
                last_card_message.innerHTML = "New Data Has Been Loaded";
                last_card_message.setAttribute("class", "card-text text-info")
            }
            else
            {
                last_card_message.innerHTML = "No Additional Data";
                last_card_message.setAttribute("class", "card-text text-warning")
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    /**
     * Display A Card.
     *
     * @param {dictionary} _results - an array with collapsed authors
     */
    fillDeck(_results)
    {
        //Go Through all the card details
        for(let i = 0; i < _results.length; i++)
        {
            //Render The Card
            this.renderCard(_results[i]);
        }
        
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
    renderCard(_data)
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
            console.log(_data.id);
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
}