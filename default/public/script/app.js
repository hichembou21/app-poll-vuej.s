'use strict';

let div = document.querySelector('.avatar-c');
let listeAll = document.querySelector('.liste-persons');
let inscrip = document.querySelector('.sign-up');

let aAffich = document.querySelector('#liste');
let aInscrip = document.querySelector('#inscrip');
let afichUsers = true;
let afichInscrip = true;

aAffich.addEventListener('click', function () {
    if (afichUsers) {
        listeAll.style.display = 'flex';
        afichUsers = !afichUsers;
    } else {
        listeAll.style.display = 'none';  
        afichUsers = !afichUsers;      
    }
});

aInscrip.addEventListener('click', function () {
    if (afichInscrip) {
        inscrip.style.display = 'flex';
        afichInscrip = !afichInscrip;
    } else {
        inscrip.style.display = 'none';  
        afichInscrip = !afichInscrip;      
    }
});