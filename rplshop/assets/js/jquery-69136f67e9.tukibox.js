//tuki jquery ext
(function($, undefined){
	var $body;
	var $overlay;
	var $title;
	var $content;
	var $close;
	var boxContent = '<p class="loading">Loading...</p>';
	
	var methods = {
		init: function(options){
			$body = $('body');
			$overlay = $('#tukibox_overlay');
			$title = $overlay.find('.tukibox_title');
			$content = $overlay.find('.tukibox_content');
			$close = $overlay.find('.close');
			$body.on('click', 'a[target="tukibox"]', function(data){
				$this = $(this);
				var url = $this.attr('href');
				if ('#' == url.substr(0,1)) {
					methods['show']($(url), $this.attr('title'));
				} else {
					methods['load'](url, $this.attr('title'));
				}
				return false;
			});
			
			$body.on('submit', 'form[target="tukibox"]', function(data){
				$this = $(this);
				var url = $this.attr('action');
				methods['load'](url, $this.attr('title'), $this.serializeArray());
				return false;
			});
			
			$close.on('click', function(){
				methods['hide']();
				return false;
			});
		},
			
		show : function(boxBody, boxTitle){
			if (boxBody instanceof jQuery) {
				boxBody = boxBody.html();
			}
			
			if (null == boxBody) {
				boxBody = boxContent;
			}
			
			$content.html(boxBody);
			
			if (undefined != boxTitle) {
				$title.html(boxTitle);
			}
			
			$body.addClass('overlay');
			$overlay.removeClass('hide');
			
			return true;
		},
		
		load : function(url, title, data) {
			type = data ? 'POST' : 'GET';
			data = data || {};
			
			//console.log(data, type);
			methods['show'](null, title);
			$.ajax({
				url:  url,
				type: 'post',
				data: data,
				global: false,
				success: function(data){
					$content.html(data);
				}
			});
			return true;
		},
		
		data : function(data)
		{
			var html = '';
			for (var i in data) {
				html += '<input type="hidden" name="' + data[i]['name'] + '" value="' + data[i]['value'] + '" />';
			}
			$content.find('form').append(html);
			return true;
		},
		
		hide : function()
		{
			$body.removeClass('overlay');
			$overlay.addClass('hide');
			return false;
		}
	};
	
	$.tukibox = function(method) {
		if (methods[method]) {
			return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.tukibox');
		}
	};
})(jQuery);
