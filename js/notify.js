function showNotification() {

    if (!Notification) {
        $('body').appendChild(document.createTextNode('Desktop notifications not available in your browser. Try Chromium.'));
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        $.ajax({
            url: "notification.php",
            type: "POST",
            success: function(data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.result == true) {
                    var data_notif = data.notif;
                    for (var i = data_notif.length - 1; i >= 0; i--) {
                        var theurl = data_notif[i]['url'];
                        var notification = new Notification(data_notif[i]['title'], {
                            icon: data_notif[i]['icon'],
                            body: data_notif[i]['msg'],
                        });
                        notification.onclick = function() {
                            window.open(theurl);
                            notification.close();
                        };
                        setTimeout(function() {
                            notification.close();
                        }, 5000);
                    };
                } else {}
            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }

};

$(document).ready(function() {
    showNotification();
});