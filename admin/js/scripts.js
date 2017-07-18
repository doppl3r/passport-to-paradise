(function( $ ) {
	'use strict';
	$( window ).load(function() {
        //alert('hey');
	});
	$(document).ready(function(){
		$.post(ajaxurl, { 'action': 'add_user', 'name': 'Jake', 'points': 9013 }, function(response) { });
		$.post(ajaxurl, { 'action': 'update_user', 'name': 'Jake', 'points': 9017 }, function(response) { });
		$.post(ajaxurl, { 'action': 'delete_user', 'name': 'Jake' }, function(response) { });
	});
})( jQuery );
