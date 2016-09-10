/**
 * Created by air on 14/11/11.
 */
function message(message) {
    var _body = $('<div class="success-box" id="success-box">\
    <div class="hd" id="content"></div>\
    </div>');

    _body.find("#content").html(message);

    $.fancybox(_body, {
        transitionIn: 'fade',
        helpers: {
            title: {
                type: 'inside'
            }//,
            //overlay : {
            //    closeClick : true
            //}
        }
    });
}

function dialog(title, message) {
    var _body = $('<div class="dialog-box">\
    <div class="title" id="title"></div>\
    <div class="content" id="content"></div>\
    </div>');

    _body.find("#content").html(message);
    _body.find("#title").html(title);

    $.fancybox(_body, {
        tpl: {
            wrap: '<div class="fancybox-wrap fancybox-wrap-dialog" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
        },
        transitionIn: 'fade',
        helpers: {
            title: {
                type: 'inside'
            }//,
            //overlay : {
            //    closeClick : true
            //}
        }
    });
}

function toast(e) {
    var b = $("body");
    var c = "";
    if (document.getElementById("toast-out-border")) {
        var d = $("#toast-out-border");
        d.empty();
        c += "<div class='toast-border'>";
        c += "<div class=toast-content>" + e + "</div>";
        c += "</div>";
        d.append(c);
        d.fadeIn(500);
        d.delay(1000);
        d.fadeOut(500)
    } else {
        c += "<div id='toast-out-border' style='display: none;'>";
        c += "<div class='toast-border'>";
        c += "<div class=toast-content>" + e + "</div>";
        c += "</div>";
        c += "</div>";
        b.append(c);
        var a = $("#toast-out-border");
        a.fadeIn(500);
        a.delay(1000);
        a.fadeOut(500)
    }
}

function handleResponse(res) {
    if (res.code == '11000') {
        var _message = "";
        $.each(res.result, function (index, element) {
            _message += "<p>" + element + "</p>";
        });
        if (_message == '') {
            message(res.reason);
        } else {
            message(_message);
        }
        return false;
    } else if (res.code != '10000') {
        message(res.reason);
        return false;
    } else {
        return true;
    }
}