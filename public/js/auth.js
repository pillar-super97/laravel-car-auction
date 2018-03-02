// $(document).ready( () => {
//     $('.btn-Login').click( () => {
//         let username = $('.tbUsername').val();
//         let password = $('.tbPassword').val();
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             type: 'post',
//             url: '/login',
//             data:{username, password},
//             success(data){
//                 alert(data);
//             }
//         })
//     })
// })