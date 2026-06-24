jQuery.extend({
    popup: function(body, title) {
        popup_box(body, title);
        return jQuery;
    },

    closePopup: function() {
        close_popup_box();
        return jQuery;
    },

    popupDelete: function(message) {
        popup_delete(message);
        return jQuery;
    },

    alert: function(message) {
        popup_alert(message);
        return jQuery;
    },

    notify: function(message, redirectUrl = '') {
        popup_notify(message, redirectUrl);
        return jQuery;
    },

    redirect: function(href) {
        location.href = href;
        return jQuery;
    },

    delayRedirect: function(href) {
        setTimeout(function () {
            location.href = href;
            return jQuery;
        }, 3000);
    },

    refresh: function() {
        location.reload();
        return jQuery;
    },

    reload: function() {
        location.reload();
        return jQuery;
    },

    postform: function(uri, postfields) {
        $tip.removeClass('hide');
        jQuery.post(uri, postfields, function(data){
            if (tipTimer == undefined) $tip.addClass('hide');
            processResponse([], data);
        }, 'json');

        return jQuery;
    },

    log: function(content) {
        console.log(content);
    },

    iframe: function(url, w, h, c) {
        // popup_box('<div class="iframe_wrp"><iframe width="'+w+'" height="'+h+'" frameborder="0" src="'+url+'"></iframe></div>');
        var html = '<div class="tukibox_content_prepaid_frame"><div class="inner"><a class="btw close" color="theme"><span icon-only="close">close</span></a><iframe class="tukibox_prepaid_iframe" src="' + url + '"></iframe></div></div>';
        popup_box(html);
        return jQuery;
    },

    open: function(href) {
        window.open(href, '_blank');
        return jQuery;
    },

    targetAlert: function(id, message) {
        targetAlert(id, message);
        return jQuery;
    },

    removeLoading: function() {
        removeLoading();
        return jQuery;
    },
});

jQuery.fn.extend({
    //设置select的选项
    setOptions: function(options, selected) {
        var $this = this;
        $this.empty();
        for (var key in options) {
            if (key == selected)
                $this.append('<option value="'+key+'" selected>'+options[key]+'</option>');
            else
                $this.append('<option value="'+key+'">'+options[key]+'</option>');
        }

        return this;
    },

    top: function() {
        var node = $(this);
        while(node.parent().length) {
            node = node.parent();
        }
        return node;
    },
    refresh_new: function() {
        location.reload();
    },

    smsCon: function (Operation_code, message, dataurl, repeat) {
        var $this = this;
        var error_tips = $('#sms_error_tips');
        var code_input = $("#sms_verify_code");
        var verify_btn = $("#sms_verify_btw");
        var code_body = $("#sms_code_body");

        //不同的code不同的操作
        if (Operation_code == 1) {
            $this.addClass('disabled');
            error_tips.removeClass('alert').addClass('success').text(message);
            var text = $this.children().text();
            var secends = 60;

            var t = setInterval(function () {
                if (--secends < 0) {
                    clearInterval(t);
                    $this.removeClass('disabled').children().text('Send Code');
                    code_input.attr('placeholder', 'Enter Verification Code').next().removeClass('incorrect');
                } else {
                    $this.children().text('Resend Code ' + ' ' + secends);
                }
                if (secends < 57) {
                    verify_btn.removeClass('disabled').show();
                    code_input.show();
                }
            }, 1000);
            return false;
        } else if (Operation_code == -1) {
            error_tips.removeClass('success').addClass('alert').text(message);
            verify_btn.addClass('disabled').hide();
            code_input.hide();
            code_body.hide();
            return false;
        } else if (Operation_code == -2) {
            $this.addClass('disabled');
            error_tips.removeClass('success').addClass('alert').text(message);
            var text = $this.children().text();
            var secends = 60;

            if (repeat != 1) {
                var t = setInterval(function () {
                    if (--secends < 0) {
                        clearInterval(t);
                        $this.removeClass('disabled').children().text('Send Code');
                        code_input.attr('placeholder', 'Enter Verification Code').next().removeClass('incorrect');
                    } else {
                        $this.children().text('Resend Code ' + ' ' + secends);
                    }
                    if (secends < 57) {
                        verify_btn.removeClass('disabled').show();
                        code_input.show();
                    }
                }, 1000);
            }
            return false;
        } else if (Operation_code == -7) {
            $this.addClass('disabled');
            var message = '<a href=\"' + dataurl + '\">' + message + '</a>';
            error_tips.removeClass('success').addClass('alert').html(message);
            verify_btn.addClass('disabled').hide();
            code_input.hide();
            code_body.hide();
            return false;
        }
        return this;
    },

    call_sms: function (Operation_code, message) {
        if (Operation_code == 1) {
            $('#sms_error_tips').removeClass('alert').addClass('success').text(message);
            $("#sms_wrp").remove();
        } else {
            $('#sms_error_tips').removeClass('success').addClass('alert').text(message);
        }
        return this;
    },
});

Date.prototype.format = function(format) //author: meizz
{
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(), //day
        "h+" : this.getHours(), //hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3), //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
        (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)if(new RegExp("("+ k +")").test(format))
        format = format.replace(RegExp.$1,
            RegExp.$1.length==1 ? o[k] :
                ("00"+ o[k]).substr((""+ o[k]).length));
    return format;
}

Number.prototype.moneyFormat = function()
{
    var num = this;
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if(cents < 10) cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
    money = (((sign) ? '' : '-') + num + '.' + cents);

    return money;
};