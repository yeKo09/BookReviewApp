let createBtn = document.querySelectorAll('.sUpBtn');
let sUpBox = document.querySelector('#signUpBox');
createBtn.forEach(item =>{
    item.addEventListener('click',signUpBox);
});
let isTheBoxOpen = false;
function signUpBox(e){
    if(!isTheBoxOpen){
        sUpBox.style.display = 'inline-block';
        isTheBoxOpen = true;
    }else{
        sUpBox.style.display = 'none';
        isTheBoxOpen = false;
    }
}