// $(document).ready(function () {
//     setAjaxHeader();
//
//     $("#register-submit").click(function() {
//         let myFirstname = $("#firstname").val();
//         let myLastname = $("#lastname").val();
//         let myUsername = $("#username").val();
//         let myPassword = $("#password").val();
//         let myEmail = $("#email").val();
//         let myUserType = $("input[name='gender']:checked").val();
//         $.ajax({
//             type: "POST",
//             url: '/register',
//             data: {
//                 firstname: myFirstname,
//                 lastname: myLastname,
//                 username: myUsername,
//                 password: myPassword,
//                 email: myEmail,
//                 usertype: myUserType
//             }
//         }).done(function(response) {
//             $("#alert-message").html(response.message);
//             $("#alert-register-info").show().delay(3000).fadeOut(400);
//         });
//     });
//
//     function setAjaxHeader() {
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//     }
//
// })
