window.addEvent('domready', function() {
	document.getElements('.gkNspPM-Blend_Coffee_Menu').each(function(module) {
		if(!module.hasClass('active')) {
			module.addClass('active');
		}
	});
});

// EOF