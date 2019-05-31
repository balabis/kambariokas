var $ = require('jquery');

ajaxCall();
setInterval(ajaxCall, 20000);

function ajaxCall() {
    var notificationRoute = $('#notifications').data('notification_route');

    $.post(notificationRoute, function(response){
        if (response.length === 0) {
            if ($('#notification-bell').hasClass('text-danger')) {
                $('#notification-bell').removeClass('text-danger');
            }
            if ($('#no-notifications').hasClass('d-none')) {
                $('#no-notifications').removeClass('d-none');
            }
        } else {
            if (! $('#notification-bell').hasClass('text-danger')) {
                $('#notification-bell').addClass('text-danger');
            }
            if (! $('#no-notifications').hasClass('d-none')) {
                $('#no-notifications').addClass('d-none');
            }
        }
        document.getElementById('notification-list').innerHTML = '';


        response.forEach(notification => {
            document.getElementById('notification-list').appendChild(createNotificationForm(notification));
        });
    })
}

function createNotificationForm (notification) {
    var deleteNotificationRoute = $('#notifications').data('delete_notification_route');

    var form = document.createElement("form");
    form.setAttribute('method',"post");
    form.setAttribute('action', deleteNotificationRoute );

    var input = document.createElement("input");
    input.setAttribute('type',"hidden");
    input.setAttribute('name',"notificationId");
    input.setAttribute('value', notification.notification.id );

    var button = document.createElement("button");
    button.setAttribute('type',"submit");
    button.setAttribute('class',"dropdown-item");

    var buttonText = document.createTextNode(notification.notification.subject + ' - ' + notification.notification.message);
    button.appendChild(buttonText);
    form.appendChild(input);
    form.appendChild(button);

    return form;
}