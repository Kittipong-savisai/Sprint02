jQuery(document).ready(function() {
	jQuery(document).find('.gkNspPM-EvoNews2').each(function(i, module) {
		module = jQuery(module);
		
		if(!module.hasClass('active')) {
			module.addClass('active');
		}
	});
});

// EOF