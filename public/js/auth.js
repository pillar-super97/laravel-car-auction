$(document).ready( () => {
    $('.btn-Login').click( () => {

        let username = $('.tbUsername').val();
        let password = $('.tbPassword').val();

        const regUsername = /^[A-z][A-Za-z0-9\_]{3,20}$/;
        const regPassword = /^[A-z][A-Za-z0-9\_]{3,20}$/;
        let errors = false;

        if(!regUsername.test(username)){
            $('.username.error').text("Username is invalid").css('color', 'red');
            errors = true
        }
        else {
            $('.username.error').text("")
        }
        if(!regPassword.test(password)){
            $('.password.error').text("Password is invalid").css('color', 'red');
            errors = true
        }
        else {
            $('.password.error').text("")
        }

        if(!errors)
            $('#loginForm').submit();
    })

    $('.btnRegister').click( () => {
        let firstName = $('.tbFirstName').val()
        let lastName = $('.tbLastName').val()
        let username = $('.tbUsername').val()
        let password = $('.tbPassword').val()
        let retype = $('.tbRetype').val()
        let email = $('.tbEmail').val()

        const regFirstName = /^[A-Z][a-z]{3,20}(\s[A-z][a-z]{1,20}){0,2}$/;
        const regUsername = /^[A-z][A-Za-z0-9\_]{3,20}$/;
        const regPassword = /^[A-z][A-z\!\?\_\*\-\#\$\%\^\&\.\,0-9]{3,20}$/;
    })
})

