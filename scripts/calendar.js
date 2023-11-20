const form = document.getElementById("schedule-form");
const btnEdit = document.getElementById("edit");
const btnDelete = document.getElementById("delete");

function init() {
    getEvents();

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        saveEvent();
    });

    btnEdit.addEventListener("click", function(e) {
        editInformation(e);
    });

    btnDelete.addEventListener("click", function(e) {
        deleteEvent(e);
    });
}

function getEvents() {
    let calendar;
    let Calendar = FullCalendar.Calendar;
    let events = [];

    $.ajax({
        url: "../controllers/calendar.php?op=getEvents",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response && response.length > 0) {
                events = response.map(row => ({
                    id: row.id,
                    title: row.title,
                    description: row.description,
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
                        let _details = $('#event-details-modal');
                        let id = info.event.id;

                        let selectedEvent = events.find(event => event.id === id);

                        if (selectedEvent) {
                            _details.find('#title').text(selectedEvent.title);
                            _details.find('#description').text(selectedEvent.description);
                            _details.find('#color').val(selectedEvent.color);
                            _details.find('#start').text(selectedEvent.start);
                            _details.find('#end').text(selectedEvent.end);
                            _details.find('#edit,#edit').attr('data-id', id)
                            _details.find('#edit,#delete').attr('data-id', id)
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

function saveEvent() {
    let formData = new FormData($("#schedule-form")[0]);
    $.ajax({
        url: "../controllers/calendar.php?op=saveEvent",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            bootbox.alert(response);
            getEvents();
        },
        error: function(xhr) {
            console.log(xhr.statusText + xhr.responseText);
        },
    });
}

function editInformation(e) {
    let id = e.currentTarget.getAttribute('data-id');
    let _form = $('#schedule-form');
    $.ajax({
        url: "../controllers/calendar.php?op=getEvent",
        type: "POST",
        data: { id_event: id },
        success: function(data) {
            let event = JSON.parse(data);
            _form.find('[name="id_event"]').val(event.id_event);
            _form.find('[name="title"]').val(event.title);
            _form.find('[name="description"]').val(event.description);
            _form.find('[name="color"]').val(event.color);
            _form.find('[name="start_datetime"]').val(String(event.start_datetime).replace(" ", "T"));
            _form.find('[name="end_datetime"]').val(String(event.end_datetime).replace(" ", "T"));
            $('#event-details-modal').modal('hide');
            _form.find('[name="title"]').focus();
        }
    });
}

function deleteEvent(e) {
    let id = e.currentTarget.getAttribute('data-id');
    let _form = $('#schedule-form');
    $.ajax({
        url: "../controllers/calendar.php?op=deleteEvent",
        type: "POST",
        data: { id_event: id },
        success: function(response) {
            $('#event-details-modal').modal('hide');
            bootbox.alert(response);
            getEvents();
        }
    });
}

init();