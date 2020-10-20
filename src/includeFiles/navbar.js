const searchBar = document.querySelector('#searchBooks');
events();
/*DENEME YERİ SONRA SİL */
let c = document.querySelector('#deneme');
function events(){
    searchBar.addEventListener('keyup',searchABook);
}

function searchABook(e){
    if(e.target.value.length === 0){
        c.innerHTML = "No Matches Found";
    }else{
        let url = "searchBooksDropdown.php?q=";
        url += e.target.value;
        let xhr = new XMLHttpRequest();
        xhr.onload = function(){
            if(this.status === 200){
                let post = JSON.parse(this.responseText);
                if(post['Response'] === 'Failed'){
                    c.innerHTML = post['Text'];
                    return;
                }
                html = `<table border = '1' id="dropdownBooks">`;
                let allTheBookIds = [];
                let authorElement = null;
                post.forEach(element => {
                    if(!isSame(allTheBookIds,element.book_id)){
                        html += `
                            <tr>
                                <td id='book${element.book_id}'><a href='${element.book_id}' target='_self'>${element.title}</a></td>
                                <td>${element.isbn}</td>
                                <td><a href='${element.author_id}' target='_self'>${element.fullName}</a></td>
                                <td>${element.year_published}</td>
                            </tr>
                        `;
                        c.innerHTML = html;
                    }else{
                        let q1 = "#book" + element.book_id;
                        authorElement = document.querySelector(q1);
                        authorElement.nextElementSibling.nextElementSibling.innerHTML += 
                        ',' + `<a href='${element.author_id}' target='_self'>${element.fullName}</a>`;
                    }
                });
                c.innerHTML += "</table>";
                
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