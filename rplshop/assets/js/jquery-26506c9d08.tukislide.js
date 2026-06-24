//tuki jquery ext
(function($, undefined){
	var methods = {
		init : function(options) {
			var settings = $.extend({
			      'sec'          : 5
			    }, options);
			
			var $this = $(this);
			var $ul = $this.find('ul');
			var $ol = $this.find('ol');
			
			var timer;

			$ol.find('a').on('click', function(){
				showSlide($(this).parent('li').index());
				return false;
			});
			
			function showSlide(idx)
			{
				if (undefined != timer) clearTimeout(timer);
				$ul.children().eq(idx).fadeIn().siblings().fadeOut();
				$ol.children().eq(idx).addClass('current').siblings('.current').removeClass('current');
				if ($ul.children().eq(++idx).length == 0) idx = 0;
				timer = setTimeout(function(){
					showSlide(idx);
				}, settings.sec * 1000);
				return true;
			}
			
			showSlide(0);
			
			return true;
		},
	};
	
	$.fn.tukislide = function(method) {
		// Method calling logic
		if (methods[method]) {
			return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.tukislide');
		}
	};
})(jQuery);
