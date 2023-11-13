function init() {
    getEvents();

}

function getEvents() {
    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];

    $.ajax({
        url: "../controllers/calendar.php?op=getEvents",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response && response.length > 0) {
                events = response.map(row => ({
                    id: row.id,
                    title: row.title,
                    start: row.start_datetime,
                    end: row.end_datetime,
                    color: row.color
                }));

                let date = new Date();
                let d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();

                calendar = new Calendar(document.getElementById('calendar'), {
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        right: 'dayGridMonth,dayGridWeek,list',
                        center: 'title',
                    },
                    selectable: true,
                    themeSystem: 'bootstrap',
                    events: events,
                    eventClick: function(info) {
                        var _details = $('#event-details-modal');
                        var id = info.event.id;

                        var selectedEvent = events.find(event => event.id === id);

                        if (selectedEvent) {
                            _details.find('#title').text(selectedEvent.title);
                            _details.find('#color').val(selectedEvent.color);
                            _details.find('#start').text(selectedEvent.start);
                            _details.find('#end').text(selectedEvent.end);
                            _details.modal('show');
                        } else {
                            alert("Event is undefined");
                        }
                    },
                    eventDidMount: function(info) {
                        // Do Something after events mounted
                    },
                    editable: true
                });

                calendar.render();

                // Form reset listener
                $('#schedule-form').on('reset', function() {
                    $(this).find('input:hidden').val('');
                    $(this).find('input:visible').first().focus();
                });
            } else {
                console.log("No events received from the server.");
            }
        },
        error: function(error) {
            console.error("Error fetching events:", error);
        }
    });
}

init();