window.addEvent('domready', function() {
	document.getElements('.gkNspPM-EvoNews2').each(function(module) {
		if(!module.hasClass('active')) {
			module.addClass('active');
		}
	});
});

// EOF