//SINGN IN POPUP-----------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", () => {
    const showPopUp = document.querySelector(".login-btn");
    const hidePopUp = document.querySelectorAll(".close-btn");
    const loginSignuoLink = document.querySelectorAll(".box .links .sign-btn");
    const loginBox = document.querySelector(".box.login");
    const signupBox = document.querySelector(".box.signup");
    const signupLink = document.getElementById("signup-link");
    const signinLink = document.getElementById("signin-link");


    document.querySelector(".box.login form").addEventListener("submit", e => {

    });


    //SHOW THE POPUP WINDOW (LOGIN FORM)
    showPopUp.addEventListener("click", () => {
        document.body.classList.toggle("show-popup");
        loginBox.style.display = "block";
        signupBox.style.display = "none";
    });

    //HIDE THE POPUP WINDOW (LOGIN FORM)
    hidePopUp.forEach(btn => {
        btn.addEventListener("click", () => document.body.classList.remove("show-popup"));
        loginBox.style.display = "none";
        signupBox.style.display = "block";
    });


    //SWITCH FROM SIGNUP TO SIGNIN
    signupLink.addEventListener("click", function (event) {
        event.preventDefault();
        loginBox.style.display = "none";
        signupBox.style.display = "block";
    });

    //SWITCH FROM SIGNIN TO SIGNUP
    signinLink.addEventListener("click", function (event) {
        event.preventDefault();
        signupBox.style.display = "none";
        loginBox.style.display = "block";
    });
});