//数据类型原型定义
String.prototype.cnLength = function()
{
    var arr=this.match(/[^\x00-\xff]/ig);
    return this.length+(arr==null?0:arr.length);
};

String.prototype.trim = function()
{
    return this.replace(/(^\s*)|(\s*$)/g, "");  
};

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

Number.prototype.hour2day = function()
{
	var hours = this;
	hours = Math.ceil(hours);
	var days = Math.floor(hours / 24);
	
	hours = hours - 24 * days;
	if (hours > 0) hours = hours + ' hours';
	days = days > 0 ?  days + (days > 1 ? ' days' : ' day') : '';
	if (hours > 0) hours = hours + ' hours';

	return days == '' ? hours : days + ' ' + hours;
};

function hour2day(hours)
{
	hours = Math.ceil(hours);
	var days = Math.floor(hours / 24);
	hours = hours - 24 * days;
	
	days = days > 0 ?  days + (days > 1 ? ' days' : ' day') : '';
	hours = hours > 0 ? (hours == 1 ? '1 hours' : hours + ' hours') : '';
	if (days != '') hours = ' ' + hours;

	return days + hours;
};

Number.prototype.number2string = function()
{
	var number = this;
	string = '';
	if (number >= 1000000000) {
		floor1 = Math.floor(number / 10000000) / 100;
		number = number - floor1 * 1000000000;
		string = string + floor1 + 'b';
	} else if (number >= 1000000) {
		floor2 = Math.floor(number / 10000) / 100;
		number = number - floor2 * 1000000;
		string = string + floor2 + 'm';
	} else if (number >= 1000) {
		floor3 = Math.floor(number / 10) / 100;
		number = number - floor3 * 1000;
		string = string + floor3 + 'k';
	} else if (number > 0) {
		string = string + number;
	} else {
		string = '0';
	}
	return string;
};

function safeConsoleLog()
{
  if((window == window.top) && window.console && console.log) {
    console.log( Array.prototype.slice.call(arguments) );
  }
}

function numberFormat (number, decimals, dec_point, thousands_sep)
{
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function moneyFormat(number, currencyCode)
{
	number = numberFormat(number, 2);
	return clientData.currencyList[currencyCode].format.replace('$m', number);
}

function number2string(number)
{
	string = '';
	if (number >= 1000000000) {
		floor1 = Math.floor(number / 10000000) / 100;
		number = number - floor1 * 1000000000;
		string = string + floor1 + 'b';
	} else if (number >= 1000000) {
		floor2 = Math.floor(number / 10000) / 100;
		number = number - floor2 * 1000000;
		string = string + floor2 + 'm';
	} else if (number >= 1000) {
		floor3 = Math.floor(number / 10) / 100;
		number = number - floor3 * 1000;
		string = string + floor3 + 'k';
	} else if (number > 0) {
		string = string + number;
	} else {
		string = '0';
	}
	return string;
};

function debug(debugInfo)
{
	if (undefined == debugInfo) {
		return false;
	} else {
		console.group('--');
		for (var i in debugInfo) {
			if ('info' == debugInfo.level) {
				console.info(debugInfo[i].message);
			} else if ('debug' == debugInfo.level) {
				console.debug(debugInfo[i].message);
			} else if ('warn' == debugInfo.level) {
				console.warn(debugInfo[i].message);
			} else if ('error' == debugInfo.level) {
				console.error(debugInfo[i].message);
			} else {
				console.log(debugInfo[i].message);
			}
		}
		console.groupEnd();
	}
}

/*
 * 全局函数
 */

//重新加载select的options
function reloadSelect(obj, name, url)
{
	$select = $(obj).siblings('select[name="' + name + '"]');
	$select.html('<option value="0">loading...</option>');
	url += '&' + obj.name + '=' + obj.value;
	$.getJSON(url, function(data){
		debug(data.debugInfo)
		var options = '<option value="0">-</option>';
		for(var typeId in data.typePairs) {
			if (typeof(data.typePairs[typeId]) == 'object' && typeof(data.typePairs[typeId]) != 'undefined' && typeof(data.typePairs[typeId]) != null) {
				options += '<optgroup label="' + typeId + '">';
				for(var typeId_key in data.typePairs[typeId]){
					for(var k in data.typePairs[typeId][typeId_key]){
						options += '<option value="' + k + '">' + data.typePairs[typeId][typeId_key][k] + '</option>';
					}
				}
				options += '</optgroup>';
			} else {
				options += '<option value="' + typeId + '">' + data.typePairs[typeId] + '</option>';
			}
		}
		$select.html(options);
	});
}

function lockPanel()
{
	//$.get($(this).attr('href'));
	$('#overlay').append($('#login_box').clone(true)).removeClass('dn');
	return false;
}

//notificaiton for chrome and safari
function notify(title, body, icon) {
	if (window.webkitNotifications.checkPermission() == 0) { // 0 is PERMISSION_ALLOWED
		var popup = window.webkitNotifications.createNotification(icon, title, body);
		popup.ondisplay = function(event) {
	        setTimeout(function() {
	            event.currentTarget.cancel();
	        }, 3 * 1000);
	    };
		popup.show();
	} else {
		window.webkitNotifications.requestPermission(function(){
			var popup = window.webkitNotifications.createNotification(title, body, icon);
			popup.ondisplay = function(event) {
		        setTimeout(function() {
		            event.currentTarget.cancel();
		        }, 3 * 1000);
		    };
			popup.show();
		});
	}
}

function url2id(url)
{
    if (undefined != url) {
        url = url.replace(/\?/g, '_qm_');
        url = url.replace(/&/g, '_amp_');
        url = url.replace(/=/g, '_es_');
        url = url.replace(/\//g, '_slash_');
    }
    return url;
}



