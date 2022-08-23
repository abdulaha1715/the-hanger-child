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

	// search toogle class
	jQuery(".header-search-icon-below").click(function(){
		jQuery(".header-search-icon-below").toggleClass("close");
		jQuery(".header-search-below").toggleClass("active-search");
	});

	// order comment toogle class
	jQuery("#order_comments_field").click(function(){
		jQuery("#order_comments_field").toggleClass("open");
	});

	// order comment toogle class
	jQuery("#ship-to-different-address :checkbox").on('click', function(){
	    jQuery("#order_review").toggleClass("ship-a-open");
	});
});

	var sticky = document.getElementsByClassName("sticky_header_placeholder");

	var offset = sticky.offsetTop();

	jQuery(window).scroll(function() {

	    if ( jQuery('body').scrollTop() > offset){
	        jQuery('.sticky_header_placeholder').addClass('fixed');
	    } else {
	        jQuery('.sticky_header_placeholder').removeClass('fixed');
	    } 

	});
