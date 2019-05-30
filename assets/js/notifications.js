var $ = require('jquery');

const ajaxCall = function () {
    var notificationRoute = $('#notifications').data('notification_route');

    var deleteNotificationRoute = $('#notifications').data('delete_notification_route');
    console.log(notificationRoute, deleteNotificationRoute);
    $.post(notificationRoute, function(response){
        response.forEach(notification => {
            console.log(notification);

            var form = document.createElement("form");
            form.setAttribute('method',"post");
            form.setAttribute('action', deleteNotificationRoute );

            var input = document.createElement("input"); //input element, text
            input.setAttribute('type',"hidden");
            input.setAttribute('name',"notificationId");
            input.setAttribute('value', notification.notification.id );

            var button = document.createElement("button"); //input element, Submit button
            button.setAttribute('type',"submit");
            button.setAttribute('class',"dropdown-item");

            var buttonText = document.createTextNode(notification.notification.subject + ' - ' + notification.notification.message);
            button.appendChild(buttonText);
            form.appendChild(input);
            form.appendChild(button);

            document.getElementById('notification-list').innerHTML = '';
            document.getElementById('notification-list').appendChild(form);
        })
    })
};

setInterval(ajaxCall, 5000);




