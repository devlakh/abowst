class Index
{
    constructor(_links)
    {
        /**
         * Contains a list of url
         * @type {Dictionary}
         */ 
        this.links = _links;
        this.limit = 2;
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

            if(results.Data.length != 0)
            {
                this.fillDeck(this.collapseAuthors(results.Data));
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
            //Start Counting Cards
            this.card_count++;

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
     * @param {dictionary} _details - Card Details
     */
    renderCard(_details)
    {
        let deck = document.querySelector("[data-deck]");

        let card_parent = document.createElement("div");
        card_parent.setAttribute("class", "col-sm-6 mt-3");
        
        let card = document.createElement("div");
        card.setAttribute("class", "card bg-secondary h-100");
    
        let card_body = document.createElement("div");
        card_body.setAttribute("class", "card-body");
    
        let title = document.createElement("h5");
        title.setAttribute("class", "card-title");
        title.innerHTML = _details.title;

        let academic_work_department = document.createElement("p");
        academic_work_department.setAttribute("class", "card-text text-muted");
        academic_work_department.innerHTML = "From " + _details.academic_work_department;

        let description = document.createElement("p");
        description.setAttribute("class", "card-text");
        description.innerHTML = _details.description;

        let authors = document.createElement("ul");
        authors.setAttribute("class", "card-text text-muted list-unstyled");
        authors.innerHTML = _details.type_of_work.charAt(0).toUpperCase() + _details.type_of_work.substring(1) + " By";

        //Go Through The Authors For Each Row / Academic Work
        for(let i = 0; i <= 5; i++)
        {
            
            if(_details.authors[i] !== undefined)
            {
                if(i == 5) authors.innerHTML += "<li>And More</li>";
                else if(_details.authors[i].name === null)
                {
                    authors.innerHTML += "<li>Anon</li>";
                }
                else
                {
                    authors.innerHTML += "<li>"+_details.authors[i].name+" from "+_details.authors[i].department+"</li>";
                }
                
            }
        }

        deck.appendChild(card_parent);
        card_parent.appendChild(card);
        card.appendChild(card_body);

        // Card Details
        card_body.appendChild(title);
        card_body.appendChild(academic_work_department);
        card_body.appendChild(description);
        card_body.appendChild(authors);
    }
    
    /**
     * Collapses Multiple authors with 
     * the same work into an array
     * then inserts the names into the row
     *
     * @param {Array.<objects>} _objects - An Array of Objects From Fetch Result result.Data
     * @return {Array.<objects>} - rows of academic works with collapsed authors
     */
    collapseAuthors(_objects)
    {
        let arr = [];
        let current_academic_work_id;

        for(let i = 0; i < _objects.length; i++)
        {
            //Check if the selected academic work is same with the last listed academic work
            if(_objects[i].academic_work_id == current_academic_work_id)
            {
                //If the current_academic_work_id is same as the selected_academic_work
                //The author_name should now be an array
                //Find the authors array from the last object inserted then insert next author
                arr[arr.length - 1].authors.push({
                    "name":_objects[i].author_name
                    ,"id":_objects[i].author_id
                    ,"department":_objects[i].author_department
                })
            }
            else
            {
                //Remember a New Academic Work
                current_academic_work_id = _objects[i].academic_work_id;

                //Convert the author_name from a string to an array
                _objects[i].authors = [{
                    "name":_objects[i].author_name
                    ,"id":_objects[i].author_id
                    ,"department":_objects[i].author_department
                }];

                //Remove Other Author Keys
                delete _objects[i].author_name
                delete _objects[i].author_id
                delete _objects[i].author_department

                //Insert object into the new array with converted author_name[]
                arr.push(_objects[i]);
            }
        }
        return arr;
    }

}