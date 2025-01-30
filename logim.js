document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('login').addEventListener('click', mock);
    document.getElementById('password').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            mock();
        }
    });
});

let loginCount = 0;

function mock() {
    let header = document.getElementById('header');
    if (loginCount === 0) {
        header.innerHTML = 'HA';
    }
    else {
        header.innerHTML += 'HA';
    }
    loginCount++;

    let password = document.getElementById('password').value;
    let p = document.createElement('p');
    p.innerHTML = `Somebody knows the password you like to use is <b>${password}</b>.`
    document.getElementById('section').appendChild(p);
}