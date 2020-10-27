const searchBar = document.querySelector('#searchBooks');
events();

const c = document.querySelector('#bookResults');
const bookData = document.querySelector('#bookData');

let extraAuthor = false;
let extraAuthorValue = "";

function events(){
    searchBar.addEventListener('keyup',searchABook);
    
}

function searchABook(e){
    if(e.target.value.length === 0){
        c.style.display = 'none';
    }else{
        let url = "../includeFiles/searchBooksDropdown.php?q=";
        url += e.target.value;
        let xhr = new XMLHttpRequest();
        xhr.onload = function(){
            if(this.status === 200){
                let post = JSON.parse(this.responseText);
                c.style.display = 'inline-block';
                if(post['Response'] === 'Failed'){
                    bookData.innerHTML = "<div id='nothingFound'>" + post['Text'] + "</div>";
                    return;
                }
                html = `<ul id="dropdownBooks">`;
                let allTheBookIds = [];
                /* The reason i'm creating a counter is because,a dropdown book list can at most have 5
                books in it.If user couldn't find the book we will automatictally simulate the search button
                with <a> tag.
                */
                let counter = 0;
                let authorElement = null;
                /* 
                    I am planning to break out of the loop,so i don't use forEach(or filter) because it is hard
                    to break out of them
                */
                for(let element of post){
                    counter++;
                    if(!isSame(allTheBookIds,element.book_id)){
                        html += `
                            <li class='dropdownElement'>
                                <div id="bookImage"><img src='../book_img/${element.isbn}.jpg' 
                                alt='${element.title} Image'></div>
                                <a href='${element.book_id}' target='_self' id='book${element.book_id}' class='bookTitle'>
                                ${element.title}</a><br>
                                <div id='authorNames'>
                                    <span>by</span>
                                    <a href='${element.author_id}' target='_self'>${element.fullName}</a>
                                </div>
                                <span>${element.year_published}</span>
                            </li><hr>
                        `;
                    }else{
                        /*If we are in this else statement,that means there is an extra author to a particular book
                          hence the extraAuthor variable.
                        */
                        extraAuthor = true;
                        extraAuthorValue = ',' + `<a href='${element.author_id}' target='_self'>${element.fullName}</a>`;
                    }
                    if(counter === 5){
                        /* When there are 5 books on dropdownlist,there can't be anymore books
                            so user should use either <a> tag for search or the search button.
                        */
                        break;
                    }
                };

                bookData.innerHTML = html;

                /* Simulating search all the results with a tag */
                document.querySelector('#dropdownBooks').innerHTML += "<li><a href='searchBooks.php?searchBooks=" 
                + e.target.value + "' target='_self' id='searchAll'>"
                + "Search all results for '" + e.target.value + "'</a></li>";

                /* Taking care of adding the extra author(s) 
                   Setting extraAuthor variable false because when we search next time,the author will not 
                   show up as the author of the other books.
                */
                if(extraAuthor){
                    document.querySelector('#authorNames').innerHTML += extraAuthorValue;
                    extraAuthor = false;
                }

                bookData.innerHTML += "</ul>";
                
            }
        }
        xhr.open('GET',url,true);
        xhr.send();
    }
}
//The reason i'm creating isSame is that,if a book is written by more than one authors
//the book don't show up twice in the records.
function isSame(x,y){
    if(x.length === 0){
        x.push(y);
        return false;
    }else{
        for(let i = 0; i < x.length; i++){
            if(y === x[i]){
                return true;
            }
        }
        return false;
    }
}

