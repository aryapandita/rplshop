//tuki jquery plugins
(function($){
	$.fn.extend({
		tukimenu: function()
		{
			var $li = $(this);
			var $a = $li.children('a');
			var $menu = $a.next();
			
			$('li.tukimenu > a.hover').removeClass('hover').nextAll('section').removeClass('show');
			$a.addClass('hover');
			$menu.addClass('show');
		}
	});
	
	$.extend({
		//tukimenu
		tukimenu : function(options)
		{
			//click menu
			$(document).on('click', 'li.tukimenu > a', function(){
				var $a = $(this);
				var $menu = $a.next('.menu');
				var url = $a.attr('href');
				if ('#' == url.substr(0, 1)) {
					if ($a.hasClass('hover')) {
						$a.removeClass('hover');
						$menu.removeClass('show');
					} else {
						//close other menu
						$('li.tukimenu > a.hover').removeClass('hover').nextAll('section').removeClass('show');
						
						$a.addClass('hover');
						$menu.addClass('show');
					}
					
					return false;
				}
				
				return true;
			});
			
			//close at click
			$(document).click(function(e){
				var $menu = $(e.target).closest('.tukimenu');
				if ($menu.length == 0) {
					$('li.tukimenu > a.hover').removeClass('hover').nextAll('section').removeClass('show');
				}
			});
			
			//hover menu
			$(document).on('mouseover', 'li.tukimenu > a', function(){
				var $a = $(this);
				var $menu = $a.next('.menu');
				var url = $a.attr('href');
				if ('#' != url.substr(0, 1)) {
					$('li.tukimenu > a.hover').removeClass('hover').nextAll('section').removeClass('show');
					
					$a.addClass('hover');
					$menu.addClass('show');
				}
				
				return true;
			});
			
			$(document).on('mouseout', 'li.tukimenu > a', function(){
				var $a = $(this);
				var $menu = $a.next('section');
				var url = $a.attr('href');
				if ('#' != url.substr(0, 1)) {
					$a.removeClass('hover');
					$menu.removeClass('show');
				}
				
				return true;
			});
			
			$(document).on('mouseover', 'li.tukimenu > section', function(){
				var $menu = $(this);
				var $a = $menu.prev('a');
				var url = $a.attr('href');
				if ('#' != url.substr(0, 1)) {
					$a.addClass('hover');
					$menu.addClass('show');
				}

				return true;
			});
			
			$(document).on('mouseout', 'li.tukimenu > section', function(){
				var $menu = $(this);
				var $a = $menu.prev('a');
				var url = $a.attr('href');
				if ('#' != url.substr(0, 1)) {
					$a.removeClass('hover');
					$menu.removeClass('show');
				}
				
				return true;
			});
		}
	});
})(jQuery);