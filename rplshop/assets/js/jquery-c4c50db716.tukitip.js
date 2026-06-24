//tuki jquery ext
(function($, undefined){
    var $body;
    var $tip;
    var t;
    var tipContent = 'loading...';

    var methods = {
        init: function(){
            $body = $('body');
            $tip = $('#tukitip');

            //ajax global loading
            //ajaxStart()请求开始执行的函数
            $body.ajaxStart(function(){methods['loading']();});
            $body.ajaxStop(function(){methods['hide']('ajaxStop');});

            return true;
        },

        success : function(message, isClose){
            clearTimeout(t);
            $tip.removeClass('hide').addClass('popup_notify').removeClass('popup_alert').html(message);
            if (isClose > 1) {
                $tip.append('<a href="#" class="close">close</a>');
                $('#tukitip .close').click(function(){
                    $tip.addClass('hide').removeClass('popup_notify').removeClass('popup_alert').html(tipContent);
                    return false;
                });
            } else {
                t = setTimeout(methods['hide'], 3000);
            }
            return true;
        },

        error : function(message, isClose){
            clearTimeout(t);
            $tip.removeClass('hide').addClass('popup_alert').removeClass('popup_notify').html(message);
            if (isClose > 1) {
                $tip.append('<a href="#" class="close">close</a>');
                $('#tukitip .close').click(function(){
                    $tip.addClass('hide').removeClass('popup_notify').removeClass('popup_alert').html(tipContent);
                    return false;
                });
            } else {
                t = setTimeout(methods['hide'], 3000);
            }
            return true;
        },

        show : function(message) {
            clearTimeout(t);
            $tip.removeClass('hide').html(message);
        },

        loading : function(message) {
            clearTimeout(t);
            $tip.removeClass('hide').removeClass('popup_notify').removeClass('popup_alert').html(tipContent);
        },

        hide : function(from)
        {
            if ('ajaxStop' == from && tipContent != $tip.html()) {

            } else {
                $tip.addClass('hide').removeClass('popup_notify').removeClass('popup_alert').html(tipContent);
            }
            return true;
        }
    };

    $.tukitip = function(method) {
        if (methods[method]) {
            return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' +  method + ' does not exist on jQuery.tukitip');
        }
    };

})(jQuery);
