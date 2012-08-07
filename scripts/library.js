$(document).ready(function(){
	resources.inputClear('#filter');
	resources.filter('#filter');
});
var resources = {
	//	Clear inputs on focus
	inputClear : function(target) {
		var target = target || 'input';
		$(target).each(function() {
			if( $(this).attr('type') == 'text' || $(this).attr('type') == 'password' || $(this).is('textarea') ) {
				var value = $(this).val();
				$(this).focus(function() {
					if($(this).val() == value) {
						$(this).val('');
					};
				});
				$(this).blur(function() {
					if($(this).val() == '') {
						$(this).val(value);
					};
				});
			}
		});
	},
	filter : function(el) {
		//  Inline search filter
		$(el).keyup(function () {
			var filter = $(this).val(), count = 0;
			$('.linklist li').each(function () {
				if ($(this).text().search(new RegExp(filter, "i")) < 0) {
					$(this).addClass("hidden");
					$('.description').addClass('hidden');
				} else {
					$(this).removeClass("hidden");
					$('.description').removeClass('hidden');
					count++;
				};
			});
		});
	}
}