jQuery(document).ready(function($){
	var yoast = {
		accordion: function(){
			$('.wp-block-yoast-faq-block').find('.schema-faq-question').click(function(){
				//Expand or collapse this panel
				$(this).nextAll('.schema-faq-answer').eq(0).slideToggle('fast', function(){
					if( $(this).hasClass('collapse') ){
						$(this).removeClass('collapse');
					}
					else{
						$(this).addClass('collapse');
					}
				});
			
				//Hide the other panels
				$(".schema-faq-answer").not( $(this).nextAll('.schema-faq-answer').eq(0) ).slideUp('fast');
			});

			$('.wp-block-yoast-faq-block .schema-faq-question').click(function(){
				$('.wp-block-yoast-faq-block .schema-faq-question').not( $(this) ).removeClass('collapse');
				if( $(this).hasClass('collapse') ){
					$(this).removeClass('collapse');
				}
				else{
					$(this).addClass('collapse');
				}
			});
		}
	};

	yoast.accordion();

	// Cart page quantity plus and minus icon click event
    jQuery('.quantity').each(function() {
		var spinner = jQuery(this),
		input       = spinner.find('input[type="number"]'),
		btnUp       = spinner.find('.quantity-up'),
		btnDown     = spinner.find('.quantity-down'),
		min         = input.attr('min'),
		max         = input.attr('max');

		btnUp.click(function() {
			var oldValue = parseFloat(input.val());
			if (oldValue <= max) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue + 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});

		btnDown.click(function() {
			var oldValue = parseFloat(input.val());
			if (oldValue <= min) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue - 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});

    });	 
});
