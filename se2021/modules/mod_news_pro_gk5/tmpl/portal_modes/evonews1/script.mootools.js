window.addEvent('domready', function() {
	document.getElements('.gkNspPM-EvoNews1').each(function(module) {
		if(!module.hasClass('active')) {
			module.addClass('active');
		}
	});
});

// EOF