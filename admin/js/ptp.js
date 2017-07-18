(function( $ ) {
	'use strict';
	$(document).ready(function(){
		//$.post(ajaxurl, { 'action': 'add_user', 'name': 'Jake', 'points': 9013 }, function(response) { });
		//$.post(ajaxurl, { 'action': 'update_user', 'name': 'Jake', 'points': 9017 }, function(response) { });
		//$.post(ajaxurl, { 'action': 'delete_user', 'name': 'Jake' }, function(response) { });
	});
	$('#add_user').on('click', function(){ 
		var name = $("#new_user_name").val();
		var points = $("#new_user_points").val();
		if (name.length > 0){ //name must have characters
			if (points.length < 1) points = 0;
			$.post(ajaxurl, { 'action': 'add_user', 'name': name, 'points': points }, function(response) { 
				if (response == "added"){
					$('.ptp-list').prepend(
						'<div class="row">'+
							'<div class="col-sm-6">'+name+'</div>'+
							'<div class="col-sm-6">'+points+'</div>'+
						'</div>'
					);
					$("#new_user_name").val('');
					$("#new_user_points").val('');
				}
			});
		}
	});
})( jQuery );

function victory(){ alert('victory'); }
