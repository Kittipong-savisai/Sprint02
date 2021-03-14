jQuery(document).ready(function() {
	jQuery(document).find('.gkNspPM-Issues_News_Slider').each(function(i, module) {
		module = jQuery(module);

		if(!module.hasClass('active')) {
			module.addClass('active');
		}
	});
});

// EOF