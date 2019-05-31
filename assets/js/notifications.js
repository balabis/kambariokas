var $ = require('jquery');

ajaxCall();
setInterval(ajaxCall, 20000);

function ajaxCall() {
    var notificationRoute = $('#notifications').data('notification_route');

    $.post(notificationRoute, function(response){
        if (response.length === 0) {
            if (document.getElementById('notification-bell').classList.contains('text-danger')) {
                document.getElementById('notification-bell').classList.remove('text-danger');
            }
            if (document.getElementById('no-notifications').classList.contains('d-none')) {
                document.getElementById('no-notifications').classList.remove('d-none');
            }
        } else {
            if (! document.getElementById('notification-bell').classList.contains('text-danger')) {
                document.getElementById('notification-bell').classList.add('text-danger');
            }
            if (! document.getElementById('no-notifications').classList.contains('d-none')) {
                document.getElementById('no-notifications').classList.add('d-none');
            }
        }

        response.forEach(notification => {
            createNotificationForm(notification);
        })
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

    document.getElementById('notification-list').innerHTML = '';
    document.getElementById('notification-list').appendChild(form);
}