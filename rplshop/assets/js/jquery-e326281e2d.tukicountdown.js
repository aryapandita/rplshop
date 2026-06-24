/**
 * 倒计时(Jquery插件)
 *
 * @author Johnson
 * @version Tuesday Novermber 22th, 2011
 
 * 在footer中有一句$('.class_name').tukicountdown(); 所以任意位置只需要给元素加上指定class，即拥有此特效
 * 支持1-4个元素个数，比如没有days，hours，但只能从左到右去除元素
 **/
(function($, undefined){
	var $counters = new Array();
	var interval = [60, 60, 24];
	
	function countdown($counter, index)
	{
		num = parseInt($counter.eq(index).text());
		if (num--) {
			$counter.eq(index).text(index ? new Array(2 - num.toString().length + 1).join('0') + num : num);
		} else {
			$counter.eq(index).text(interval[$counter.size() - index - 1] - 1);
			if (index--) countdown($counter, index);
		}
	}
	
	$.fn.tukicountdown = function() {
		this.each(function(index, counter){$counters[index] = $(counter).find('i');});
		setInterval(function() {
			for (var i in $counters) {
				countdown($counters[i], $counters[i].size() - 1)
			}
		}, 1000);
	};
})(jQuery);
