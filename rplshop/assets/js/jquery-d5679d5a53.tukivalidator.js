//tuki jquery plugins
(function($, undefined){	
	var methods = {
		//调用$form.validate();
		init: function(options) {
			var $form = this;
			var valid = true;
			
			$form.find('.tukifield').each(function(idx){
				var $field = $(this);
				//如果从未执行过检查
				if (undefined === $field.data('checkStatus')) {
					methods.check.call($field);
				}
				//判断结果
				if (! $field.data('checkStatus')) valid = false;
			});
			
			return valid;
		},
		
		//执行检查
		check: function() {
			var $field = this;

			var fieldName = $field.attr('name');
			var fieldValue = $field.val();
			var fieldTag = $field[0].tagName;
			var fieldType = $field.attr('type');
			var required = $field.attr('required');
			
			//console.log(fieldName, fieldValue, fieldTag, fieldType, required);
			
			var checkStatus = true;
			var checkMessage = '';

			//required && type
			if (required) {
				if (fieldValue) {
					switch(fieldName) {
						case 'money':
							if (/^[1-9][0-9]*(?:\.[0-9]{1,2})?$/i.test(fieldValue)) {
							
							} else {
								checkStatus = false;
								checkMessage = 'Is not a valid price.';
							}
							break;
						case 'email':
							if (/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(fieldValue)) {
							
							} else {
								checkStatus = false;
								checkMessage = 'Please enter a valid email address.';
							}
							break;
						case 'mobile':
							if (fieldValue) {
								if (/^\d*$/.test(fieldValue)) {
									
								} else {
									checkStatus = false;
									checkMessage = 'Please enter only phone numbers.';
								}
								
								if (fieldValue.length < 6 || fieldValue.length > 12) {
									checkStatus = false;
									checkMessage = 'Please enter 6-12 digit phone number (area code + phone number excluding country code).';
								}
								
							} else {
								checkStatus = false;
								checkMessage = 'Please enter a phone number.';
							}
							
							break;
						case 'zipcode':
							if (/^\d{6}$/.test(fieldValue)) {
							
							} else {
								checkStatus = false;
								checkMessage = 'Is not a valid Zip Code.';
							}
							break;
					}
				} else {
					checkStatus = false;
					checkMessage = Please_fill_out_this_field;
				}
			}
			
			//equal
			var equal_to = $field.attr('equal');
			if (checkStatus && equal_to && fieldValue != $('#'+equal_to).val()) {
				checkStatus = false;
				checkMessage = Please_enter_the_same_value_again;
			}
			
			//min
			if (checkStatus && $field.attr('min') != undefined) {
				var min = parseFloat($field.attr('min'));
				if (parseFloat(fieldValue) < min) {
					checkStatus = false;
					checkMessage = 'Please enter a value greater than or equal to ' + min;
				}
			}
			
			//max
			if (checkStatus && $field.attr('max') != undefined) {
				var max = parseFloat($field.attr('max'));
				if (parseFloat(fieldValue) > max) {
					checkStatus = false;
					checkMessage = 'Please enter a value less than or equal to  ' + max;
				}
			}
		
			//max
			var minlength = $field.attr('minlength');
			if (checkStatus && minlength && minlength > fieldValue.cnLength()) {
				checkStatus = false;
				checkMessage = 'Please enter at least '+minlength+' characters.';
			}
			
			//min max
			var maxlength = $field.attr('maxlength');
			if (checkStatus && maxlength && maxlength < fieldValue.cnLength()) {
				checkStatus = false;
				checkMessage = 'Please enter no more than '+maxlength+' characters.';
			}
			
			//remote 网速慢的时候不等待验证结果即提交
			if (checkStatus) {
				var remote = $field.attr('remote');
				if (remote) {
					$field.addClass('input-loading');
					$.ajax({
						//async: false,
						type: "GET",
						url: remote,
						global: false,
						data: fieldName + '=' + fieldValue,
						dataType : 'json',
						success: function(data){
							$field.removeClass('input-loading');
							if (data.code > 0) {
								methods.hideMessage.call($field);
							} else {
								methods.showMessage.call($field, data.message);
							}
						}
					});
				}
			}
			
			//add function
			if (checkStatus) {
				var funcName = $field.attr('func');
				if (funcName) {
					eval(funcName + '.call(this)');
				} else {
					methods.hideMessage.call(this);
				}
			} else {
				methods.showMessage.call(this, checkMessage);
			}
			
			//始终返回true, check status 检查data数据
			return $field.data('checkStatus');
		},
		
		//hide check info on success
		hideMessage: function() {			
			var $this = $(this);
			var $tip = $this.next('i.tukivalidator-alert');
			$this.data('checkStatus', true);
			if ($tip instanceof jQuery) clearTimeout($tip.addClass('dn').data('timer'));
			
			if ($this.hasClass('input-loading')) {
				$this.removeClass('input-border-red').removeClass('input-border-green');
				//message = 'querying...';
			} else {
				$this.removeClass('input-border-red').addClass('input-border-green');
				//message = 'pass';
			}
		},
		
		//show check info on error
		showMessage: function(message) {
			var $this = $(this), $tip;
			$this.data('checkStatus', false);
			$this.parent('.tukiselect').removeClass('input-border-green').addClass('input-border-red');
			$this.removeClass('input-border-green').addClass('input-border-red');
			
			if ($this.parent('.tukifield_wrapper').length) {
				$tip = $this.next('i.tukivalidator-alert');
				if ($tip instanceof jQuery) clearTimeout($tip.data('timer'));
				$tip.removeClass('dn').html(message);
			} else {
				var $wrapper = $('<span class="di psr tukifield_wrapper"/>').html($this.clone(true));
				$tip = $('<i class="tukivalidator-alert"/>').html(message);
				$this.replaceWith($wrapper);
				$wrapper.append($tip);
			}
			
			$tip.data('timer', setTimeout(function(){$tip.addClass('dn');}, 3000));
			
			/*
			<span class="di psr tukifield_wrapper">
			<input type="text" class="text w200" />
			<i class="tukivalidator-alert dn">123123</i>
			</span>
			*/
		}
	};
	
	$.fn.tukivalidator = function(method) {
		if (methods[method]) {
			return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.tukivalidator');
		}
	};
	
	//global init
	$.tukivalidator = function(options) {
		$(document).on('focus', '.tukifield', function(){
			var $field = $(this);
			var $tip = $field.next('.tip');
			if (undefined == $field.data('tip')) {
				$field.data('tip', $tip.html());
			} else {
				$field.data('check_info', $tip.html());
				$tip.removeClass('tips-error').html($field.data('tip')).show();
			}
		});
		
		$(document).on('blur', '.tukifield', function(){
				return methods.check.call($(this));
		});
		
		$(document).on('change', '.tukifield', function(){
			//return methods.check.call($(this));
		});
	};
})(jQuery);