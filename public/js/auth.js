$(document).ready( () => {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.btn-Login').click( () => {

        let username = $('.tbUsername').val();
        let password = $('.tbPassword').val();

        const regUsername = /^[A-z][A-Za-z0-9\_]{3,20}$/;
        const regPassword = /^[A-z][A-z\!\?\_\*\-\#\$\%\^\&\.\,0-9]{3,20}$$/;
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


    let usernameAvb = false;

    $('#tbUsername').blur( function() {
        const username = $(this).val();
        const regUsername = /^[A-z][A-Za-z0-9\_]{3,20}$/;
        let error = false;

        if(!regUsername.test(username)){
            $('.username.error').text('Username is invalid').css('color', 'red');
            error = true;
        }
        else{
            $('.username.error').text('')
        }

        if(!error){
            $.ajax({
                type: "POST",
                url: "/checkUsername",
                data: {username},
                success(data){
                    if(data.message === 'taken'){
                        usernameAvb = false;
                        $('.username.error').text('Username is already taken').css('color', 'red');
                    }
                    else {
                        $('.username.error').text('');
                        usernameAvb = true;
                    }
                }
            })
        }
    });

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
        const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let error = false;

        if(!regFirstName.test(firstName)){
            $('.firstname.error').text('Name is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.firstname.error').text('')
        }
        if(!regFirstName.test(lastName)){
            $('.lastname.error').text('Last name is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.lastname.error').text('')
        }
        if(!regUsername.test(username) || usernameAvb === false){
            $('.username.error').text('Username is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.username.error').text('')
        }
        if(!regPassword.test(password)){
            $('.password.error').text('Password is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.password.error').text('')
        }
        if(!regEmail.test(email)){
            $('.email.error').text('Email is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.email.error').text('')
        }
        if(password !== retype){
            $('.retype.error').text('Passwords don\'t match').css('color', 'red');
            error = true;
        }
        else {
            $('.retype.error').text('Matching').css('color', 'green');
        }

        if(!error && usernameAvb){
            $('#registerForm').submit();
        }
    })
})

