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
                let result = JSON.parse(response);
                if (result.success) {
                    window.location.href = '../views/home.php';
                } else {
                    bootbox.alert("Credenciales incorrectas, intente nuevamente");
                }
            }
        });
    });
});