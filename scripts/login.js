$(document).ready(function() {
    $('#frmLogin').submit(function(event) {
        event.preventDefault();

        var username = $('#username').val();
        var password = $('#password').val();

        $.ajax({
            type: 'POST',
            url: '../controllers/login.php?op=authenticateUser',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                console.log(response)
                if (response == 1) {
                    window.location.href = '../views/home.php';
                } else {
                    bootbox.alert("Credenciales incorrectas, intente nuevamente");
                }
            }
        });
    });
});