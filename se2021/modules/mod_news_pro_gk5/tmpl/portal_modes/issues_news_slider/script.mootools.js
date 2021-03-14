window.addEvent('domready', function() {
	document.getElements('.gkNspPM-Issues_News_Slider').each(function(module) {
		if(!module.hasClass('active')) {
			module.addClass('active');
		}
	});
});

// EOF