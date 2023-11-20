function init() {
    getNotification();
}

function getNotification() {
    $.ajax({
        url: '../controllers/calendar.php?op=getUpcomingEvents',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Manejar la respuesta de eventos próximos
        },
        error: function(error) {
            console.error('Error al obtener eventos próximos:', error);
        }
    });
}


init();