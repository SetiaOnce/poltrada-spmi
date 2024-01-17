jQuery(function($) {
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    $(".whatsapp-button").on("click", function() {
        var text = $(this).attr("data-message");
        var phone = $(this).attr("data-number");
        var message = encodeURIComponent(text);

        if (isMobile.any()) {
            //mobile device
            var whatsapp_API_url = "whatsapp://send";
            $(this).attr('href', whatsapp_API_url + '?phone=' + phone + '&text=' + message);
        } else {
            //desktop
            var whatsapp_API_url = "https://web.whatsapp.com/send";
            $(this).attr('href', whatsapp_API_url + '?phone=' + phone + '&text=' + message);
        }

    });

});