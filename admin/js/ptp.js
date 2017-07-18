(function( $ ) {
	'use strict';
	$(document).ready(function(){
		//$.post(ajaxurl, { 'action': 'add_user', 'name': 'Jake', 'points': 9013 }, function(response) { });
		//$.post(ajaxurl, { 'action': 'update_user', 'name': 'Jake', 'points': 9017 }, function(response) { });
		//$.post(ajaxurl, { 'action': 'delete_user', 'name': 'Jake' }, function(response) { });
	});

	//add new user
	$('#add_user').on('click', function(){ 
		var name = $("#new_user_name").val();
		var points = $("#new_user_points").val();
		var id = -1; //generated from mysql
		if (name.length > 0){ //name must have characters
			if (points.length < 1) points = 0;
			$.post(ajaxurl, { 'action': 'add_user', 'name': name, 'points': points }, function(response) { 
				if (parseInt(response) > 0){
					id = response;
					$('.ptp-list').prepend(
						'<div id="ptp-userid-'+id+'" class="row">'+
							'<div class="col-sm-6 item name">'+name+'</div>'+
							'<div class="col-sm-6 item points">'+points+'</div>'+
						'</div>'
					);
					$("#new_user_name").val('');
					$("#new_user_points").val('');
				}
			});
		}
	});

	//edit data from existing item
	$('.ptp-list .item').on('click', function(){ 
		console.log($(this).parent().attr('id'));
	});
})( jQuery );

function victory(){ alert('victory'); }
