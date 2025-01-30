const prices = [100, 150, 20, 15];
let c = document.getElementById('credit');
let credit = parseFloat(c.innerText.replace(/[^\d.]/g, ''));
let username = get_username();

let spans = document.getElementsByTagName('span');
for (let i = 0; i < spans.length; ++i) {
    spans[i].innerHTML = `$${prices[i].toFixed(2)}`;
}
let images = document.getElementsByTagName('img');
let checkboxes = [];
for (let cb of document.getElementsByTagName('input')) {
    if (cb.type === 'checkbox') {
        checkboxes.push(cb);
    }
}
let code_box = document.getElementById('coupon');
let msg = document.getElementById('checkout-msg');

// Add 6 event listeners.
document.addEventListener('DOMContentLoaded', function() {
    for (let i = 0; i < images.length; ++i) {
        images[i].addEventListener('click', function() {
            if (!checkboxes[i].disabled) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        });
        checkboxes[i].addEventListener('click', function() {
            if (!checkboxes[i].disabled) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        });
    }
    
    code_box.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            validate_coupon_code(code_box.value);
            code_box.value = '';
            sales_total();
        }
    });
    document.getElementById('checkout').addEventListener('click', function() {
        validate_coupon_code(code_box.value);
        code_box.value = '';
        sales_total();
    });
});

function update_credit(credit) {
    document.getElementById('credit').innerHTML = `Your credit: $${credit.toFixed(2)}`;
    let request = new XMLHttpRequest();
    request.onload = function() {
        if (request.status === 200) {
            console.log(request.responseText);
        }
    }
    request.open('POST', 'money.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    let data = `username=${encodeURIComponent(username)}&credit=${credit}`;
    request.send(data);
}

function validate_coupon_code(code) {
    if (code === 'COUPON5') {
        credit += 5;
        update_credit(credit);
    }
    else if (code === 'COUPON10') {
        credit += 10;
        update_credit(credit);
    }
    else if (code === 'COUPON20') {
        credit += 20;
        update_credit(credit);
    }
}

function sales_total() {
    // Calculate the price from only the checked checkboxes
    let checked_indices = [];
    for (let i = 0; i < checkboxes.length; ++i) {
        if (checkboxes[i].checked) {
            checked_indices.push(i);
        }
    }

    if (checked_indices.length === 0) {
        msg.innerHTML = '';
    }
    else {
        let temp = 0;
        for (let i = 0; i < checked_indices.length; i++) {
            temp += prices[checked_indices[i]];
        }
        let total = temp * 107.25;

        if (Math.floor((total * 10) % 10) === 5) {
            if (Math.floor(total) % 2) {
                total = Math.ceil(total) / 100;
            }
            else {
                total = Math.floor(total) / 100;
            }
        }
        else {
            total = Math.round(total) / 100;
        }

        if (total > credit) {
            alert('Insufficient credit');
        }
        else {
            msg.innerHTML = `
                &nbsp;&nbsp;&nbsp;\$${temp.toFixed(2)}<br>
                +&nbsp;sales tax (7.25%)<br>
                =&nbsp;\$${total}
                `;
            credit -= total;
            update_credit(credit);

            // Change checked boxes to be disabled.
            for (let i = 0; i < checked_indices.length; ++i) {
                checkboxes[checked_indices[i]].checked = false;
                checkboxes[checked_indices[i]].disabled = true;
            }
        }
    }
}
