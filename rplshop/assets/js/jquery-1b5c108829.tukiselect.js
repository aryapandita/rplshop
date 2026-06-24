//tuki jquery plugins
(function($, undefined){
	$.fn.extend({
		tukiselect: function () {
			$this = this;
			$this.each(function(){
				var $div = $(this);
				var $a = $div.find('a');
				var $span = $div.children('h6');
				var $input = $div.children('input');
				
				$a.click(function(e){
					var curVal = $input.val();
					var $this = $(this);
					var label = $this.html();
					var val = $this.attr('href').substr(1);
					if (val != curVal) {
						$span.html(label);
						$input.val(val);
						$div.trigger('change');
					}
					$div.trigger('blur');
					$div.removeClass('hover');
					//e.stopPropagation();

					if (undefined != $div.attr('autosubmit')) {
						$this.closest('form').submit();
					}

					return false;
				});
				
				$div.click(function(e){
					$this.removeClass('hover');
					$div.addClass('hover');
					$div.trigger('focus');
					e.stopPropagation();
				});
			});
			
			$('body').click(function(){
				$this.removeClass('hover');
			});
			
			return false;
		},
		
		//tukiselect val method
		tsVal : function()
		{
			var $this = this;
			var $input = $this.children('input');
			if (arguments.length == 0) {
				return $input.val();
			}
			var val = arguments[0];
			$this.each(function(){
				var $div = $(this);
				var $span = $div.children('h6');
				var $input = $div.children('input');
				var label = $div.find('a[href="#'+val+'"]').html();
				$span.html(label);
				$input.val(val);
			});
			return $this;
		}
	});
})(jQuery);