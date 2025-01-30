document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form').addEventListener('submit', validate_username);
});

window.onload = function() {
    let uname = get_username();
    if (uname !== '') {
        document.getElementById('username').value = uname;
    }
}

function hour_in_future() {
    let d = new Date();
    d.setHours(d.getHours() + 1);
    return d.toUTCString();
}

function validate_username(event) {
    let username = document.getElementById('username').value;
    let valid = true;
    let alphanumeric = /^[a-zA-Z0-9]+$/;
    let symbols = "!@#$%^*()-_+[]{}:'|`~<.>/?";
    let alerts = []
    if (username.length < 5) {
        valid = false;
        alerts.push("Username must be at least 5 characters.");
    }
    if (username.length > 40) {
        valid = false;
        alerts.push("Username must be at most 40 characters.");
    }
    let has_space = false;
    let has_comma = false;
    let has_semicolon = false;
    let has_equals = false;
    let has_amp = false;
    for (let i = 0; i < username.length; i++) {
        let cur = username[i];
        if (!has_space && cur === ' ') {
            valid = false;
            has_space = true;
            alerts.push("Username cannot contain spaces.");
        }
        else if (!has_comma && cur === ',') {
            valid = false;
            has_comma = true;
            alerts.push("Username cannot contain commas.");
        }
        else if (!has_semicolon && cur === ';') {
            valid = false;
            has_semicolon = true;
            alerts.push("Username cannot contain semicolons.");
        }
        else if (!has_equals && cur === '=') {
            valid = false;
            has_equals = true;
            alerts.push("Username cannot contain =.");
        }
        else if (!has_amp && cur === '&') {
            valid = false;
            has_amp = true;
            alerts.push("Username cannot contain &.")
        }
        if (valid && !(alphanumeric.test(cur)) && !symbols.includes(cur)) {
            valid = false;
            alerts = ["Username can only use characters from the following string:\nabcdefghijklmnopqrstuvwxyz\nABCDEFGHIJKLMNOPQRSTUVWXYZ\n0123456789\n!@#$%^*()-_+[]{}:'|`~<.>/?"];
        }
    }
    if (valid) {
        document.cookie = `username=${username}; expires=${hour_in_future()}`;
    }
    else {
        let alert_msg = "";
        for (let i = 0; i < alerts.length; ++i) {
            alert_msg += (alerts[i] + '\n');
            console.log(alert_msg);
        }
        alert(alert_msg);
        event.preventDefault();
    }
}