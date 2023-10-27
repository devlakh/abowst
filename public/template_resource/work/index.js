class Index
{
    constructor(_links)
    {
        /**
         * Contains a list of url
         * @type {Dictionary}
         */ 
        this.links = _links;

        this.card_count = 0;
        this.limit = 20;
        this.offset = 0;

        this.init();
    }

    init()
    {
        var formData = new FormData();
        formData.append("limit", this.limit);
        formData.append("offset", this.offset);

        fetch(this.links.grabCardsPartial, {
            method: 'POST',
            body: formData,
            headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value}
        })
        .then(response => response.json())
        .then(results => {
            // console.log(this.collapseAuthors(results.Data));

            /**@type {Array.<Objects>}*/ 
            var data = this.collapseAuthors(results.Data)

            /**@type {HTMLElement}*/ 
            var card_row;

            for(var i = 0; i < data.length; i++)
            {
                //Start Counting Cards
                this.card_count++;

                //Check If New Card Needs a New Row
                if(this.card_count % 2 != 0) card_row = this.createCardRow();

                //Render The Card
                this.renderCard(card_row, data[i]);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    /**
     * Display A Card.
     *
     * @param {HTMLElement} _row - Number of Cards In The Deck
     * @param {dictionary} _details - Card Details
     */
    renderCard(_row, _details)
    {
        // console.log(_details);

        var deck = document.querySelector("[data-deck]");

        var card_parent = document.createElement("div");
        card_parent.setAttribute("class", "col-sm-6 mt-3");
        
        var card = document.createElement("div");
        card.setAttribute("class", "card bg-secondary");
    
        var card_body = document.createElement("div");
        card_body.setAttribute("class", "card-body");
    
        var title = document.createElement("h5");
        title.setAttribute("class", "card-title");
        title.innerHTML = _details.title;

        var academic_work_department = document.createElement("p");
        academic_work_department.setAttribute("class", "card-text text-muted");
        academic_work_department.innerHTML = "From " + _details.academic_work_department;

        var description = document.createElement("p");
        description.setAttribute("class", "card-text");
        description.innerHTML = _details.description;

        var authors = document.createElement("ul");
        authors.setAttribute("class", "card-text text-muted list-unstyled");
        authors.innerHTML = _details.type_of_work.charAt(0).toUpperCase() + _details.type_of_work.substring(1) + " By";

        //Go Through The Authors For Each Row
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
            else if(_details.authors[i] === undefined)
            {
                authors.innerHTML += "<li>&nbsp</li>";
            }
        }


        deck.appendChild(_row);
        _row.appendChild(card_parent)
        card_parent.appendChild(card);
        card.appendChild(card_body);

        // Card Details
        card_body.appendChild(title);
        card_body.appendChild(academic_work_department);
        card_body.appendChild(description);
        card_body.appendChild(authors);
    }

    /**
     * Create a row for the Cards.
     *
     * @return {HTMLElement} - Row for cards
     */
    createCardRow()
    {
        var card_row = document.createElement("div");
        card_row.setAttribute("class", "row");

        return card_row;
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
        var arr = [];

        var current_academic_work_id;
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