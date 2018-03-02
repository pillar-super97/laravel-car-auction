$(document).ready( () => {
    $('.btn-Login').click( () => {
        let username = $('.tbUsername').val();
        let password = $('.tbPassword').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: '/login',
            data:JSON.stringify({username, password}),
            success(data){
                alert(data);
            }
        })
    })
})

// AJAX Requests & Validation
// In this example, we used a traditional form to send data to the application. However, many applications use AJAX requests. When using the validate method during an AJAX request, Laravel will not generate a redirect response. Instead, Laravel generates a JSON response containing all of the validation errors. This JSON response will be sent with a 422 HTTP status code.
