;(function($) {	
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

		// search toogle class
		jQuery(".header-search-icon-below").click(function(){
			jQuery(".header-search-icon-below").toggleClass("close");
			jQuery(".header-search-below").toggleClass("active-search");
			jQuery(".site-header-style-1").toggleClass("active-search");
		});

		// search toogle class
		jQuery(".closs-s-bar").click(function(){
			jQuery(".header-search-below").removeClass("active-search");
			jQuery(".site-header-style-1").removeClass("active-search");
		});

		// order comment toogle class
		jQuery("#order_comments_field").click(function(){
			jQuery("#order_comments_field").toggleClass("open");
		});

		// order comment toogle class
		jQuery("#ship-to-different-address :checkbox").on('click', function(){
		    jQuery("#order_review").toggleClass("ship-a-open");
		});

		// scroll to top and menu fixed
		$(window).scroll(function() {    
		    var scroll = $(window).scrollTop();

		    if ( scroll >= 115 ) {
		        $(".sticky_header_placeholder").addClass("fixed");
		    } else {
		        $(".sticky_header_placeholder").removeClass("fixed");
		    }
		});

		$(document).on('click', '[data-lightbox]', lity);
	});

}(jQuery));
