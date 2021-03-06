/**
 * Created by air on 16/9/9.
 */


$(function () {

    $("#submit").click(function () {
        var content = $("textarea[name=content]").val();
        var name = $("input[name=name]").val();
        var mobile = $("input[name=mobile]").val();

        if (content == undefined || content == "") {
            message("心愿不能为空");
        } else if (name == undefined || name == "") {
            message("姓名不能为空");
        } else if (mobile == undefined || mobile == "" || !/^1[3,5,8,7]\d{9}$/.exec(mobile)) {
            message("请填写正确的手机号");
        } else {

            var k = $("meta[name=csrf-param]").attr("content");
            var v = $("meta[name=csrf-token]").attr("content");
            var param = {
                name: name,
                mobile: mobile,
                content: content
            };
            param[k] = v;
            $.post($("#submit").data("url"), param, function (res) {
                if (res.code != 1) {
                    message(res.msg);
                } else {
                    location.href = res.data.redirect_uri
                }
            }, 'json');
        }
        return false;
    });


    var page = 1;
    var type = 'star';
    var tabContainer = $("#tab-container");
    var wishList = $("#wish-list");

    function getStarList() {
        $("#more").show();
        $.get(wishList.data('url'), {page: page, type: 'star'}, function (res) {
            if (res.data.length < 20) {
                $("#more").hide();
            } else {
                $("#more").show();
            }

            $.map(res.data, function (item) {
                var html = '<div class="item">' +
                    '<div class="left">' +
                    '<div class="title">' +
                    '<span class="name">' + item.name +
                    '</span><span class="mobile">' + item.mobile +
                    '</span>' +
                    '</div>' +
                    '<div class="content">' +
                    item.content +
                    '</div>' +
                    '</div>' +
                    '<div class="right" data-id="' + item.id +
                    '"><span class="good"></span><span class="num">' + item.star +
                    '</span></div>' +
                    '</div>';

                $("#more").before(html);
            });

        }, 'json');
    }

    function getNewList() {
        $("#more").show();
        $.get(wishList.data('url'), {page: page, type: 'new'}, function (res) {
            if (res.data.length < 20) {
                $("#more").hide();
            } else {
                $("#more").show();
            }


            $.map(res.data, function (item) {
                var html = '<div class="item">' +
                    '<div class="left">' +
                    '<div class="title">' +
                    '<span class="name">' + item.name +
                    '</span><span class="mobile">' + item.mobile +
                    '</span>' +
                    '</div>' +
                    '<div class="content">' +
                    item.content +
                    '</div>' +
                    '</div>' +
                    '<div class="right" data-id="' + item.id +
                    '"><span class="good"></span><span class="num">' + item.star +
                    '</span></div>' +
                    '</div>';

                $("#more").before(html);
            });
        }, 'json');
    }

    wishList.on('click', '#more', function () {
        if (type == 'star') {
            page++;
            getStarList();
        } else if (type == 'new') {
            page++;
            getNewList();
        }
    });

    if (wishList) {
        getStarList();

        wishList.on("click", ".right", function () {
            var self = $(this);
            var k = $("meta[name=csrf-param]").attr("content");
            var v = $("meta[name=csrf-token]").attr("content");
            var param = {
                id: self.data('id')
            };
            param[k] = v;
            $.post(wishList.data('star-url'), param, function (res) {
                if (res.code == 1) {
                    self.find('.num').text(parseInt(self.find('.num').text()) + 1);
                } else {
                    message(res.msg);
                }
            }, 'json');
        });
    }


    $(".num-counter").click(function () {
        var self = $(this);
        var param = {
            id: self.data('id')
        };
        param[$("meta[name=csrf-param]").attr("content")] = $("meta[name=csrf-token]").attr("content");
        $.post(self.data('star-url'), param, function (res) {
            if (res.code == 1) {
                self.find('.num').text(parseInt(self.find('.num').text()) + 1);
            } else {
                message(res.msg);
            }
        }, 'json');
    });

    if (tabContainer) {
        tabContainer.on("click", '.tab', function (res) {
            var self = $(this);
            tabContainer.find(".tab").removeClass('active');
            self.addClass("active");

            if (wishList) {
                wishList.empty();

                type = self.data('type');
                if (self.data('type') == 'star') {
                    page = 1;
                    wishList.append('<div class="more" id="more">加载更多</div>');
                    getStarList();
                } else if (self.data('type') == 'new') {
                    page = 1;
                    wishList.append('<div class="more" id="more">加载更多</div>');
                    getNewList();
                }
            }
        })
    }

    $(".activity-rule").click(function () {

        var rule_html = $('<div class="rule-content"></div>');
        rule_html.append('<p>＊活动期间，每个微信号都有1次许愿机会，并每天有3次机会对留言心愿进行点赞，也可以给自己的心愿点赞哦；</p>');
        rule_html.append('<p>＊点击 “我的心愿”，留言许下自己的心愿；</p> ');
        rule_html.append('<p>＊愿望是美好的，我们会对每个心愿附上祝福，含恶意、不雅的许愿内容我们不接纳，未接纳心愿的用户可以重新许愿；</p>');
        rule_html.append('<p>＊留言还有机会在以灯光投映的形式出现在昆城广场；</p>');
        rule_html.append('<p>＊活动时间为9月15日-10月16日，最终选出票数前十的心愿，送出精美礼品一份；</p>');
        rule_html.append('<p>＊获奖者可凭本人有效身份证件至询问处领取礼品；</p>');
        rule_html.append('<p>＊活动最终解释权归昆城广场所有！</p>');
        rule_html.append('<div class="rule-logo"></div>');
        dialog("活动规则", rule_html);
    });

    //$('.redirect-back').click(function () {
    //    history.go(-1);
    //})

    $("#share-button").click(function () {
        $(".share-overflow").toggle();
    })
    $(".share-overflow").click(function () {
        $(".share-overflow").hide();
    });


    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var fromkol = getParameterByName('fromkol');
    $.ajax({
        url: "http://218.244.145.245/mlog.php?campaign_id=kunchengxuyuan&fromkol=" + fromkol,

        // The name of the callback parameter, as specified by the YQL service
        jsonp: "callback",

        // Tell jQuery we're expecting JSONP
        dataType: "jsonp",

        // Tell YQL what we want and that we want JSON
        data: {},

        // Work with the response
        success: function (response) {
        },
        error: function (response) {
        },
    });

    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    $("*[data-target=statistics]").click(function () {
        var self = $(this);

        var fromkol = getParameterByName('fromkol');
        $.ajax({
            url: "/index/statistics",

            type: 'POST',

            // The name of the callback parameter, as specified by the YQL service
            //jsonp: "callback",

            // Tell jQuery we're expecting JSONP
            //dataType: "jsonp",

            // Tell YQL what we want and that we want JSON
            data: {
                fromkol: fromkol,
                email: "",
                CZ_activity_name: self.data("id"),
                CZ_created: new Date().Format("yyyy-MM-dd hh:mm:ss"),
                openid: $("meta[name=openid]").attr("content"),
                name: $("meta[name=name]").attr("content"),
                mobile: $("meta[name=mobile]").attr("content")
            },

            // Work with the response
            success: function (response) {
            },
            error: function (response) {
            },
        });
    })
});