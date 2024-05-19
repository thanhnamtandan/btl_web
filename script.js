const showPopupBtn = document.querySelector(".button-header-login");
const hidePopupBtn = document.querySelector(".blur-bg-overplay .form-popup .close-btn");
const formPopup = document.querySelector(".blur-bg-overplay .form-popup");
const loginSignuplink = document.querySelectorAll(".form-box .bottom-link a");
showPopupBtn.addEventListener("click",() => {
document.body.classList.toggle("show-popup")
});

hidePopupBtn.addEventListener("click",() => showPopupBtn.click());
loginSignuplink.forEach(link =>{
link.addEventListener("click",(e) => {
e.preventDefault();
formPopup.classList[link.id === "signup-link" ? 'add':'remove']("show-signup");
    });
});


var createPwField = document.getElementById('createPw');
    var confirmPwField = document.getElementById('confirmPw');
    var submitBtn = document.getElementById('submitBtn');

    createPwField.addEventListener('input', function() {
        var createPwValue = this.value;

        if (createPwValue.length > 8) {
            confirmPwField.removeAttribute('disabled');
        } else {
            confirmPwField.setAttribute('disabled', 'disabled');
            submitBtn.setAttribute('disabled', 'disabled');
        }
    });

    confirmPwField.addEventListener('input', function() {
        var createPwValue = createPwField.value;
        var confirmPwValue = this.value;

        if (createPwValue === confirmPwValue) {
            submitBtn.removeAttribute('disabled');
        } else {
            submitBtn.setAttribute('disabled', 'disabled');
        }
    });

