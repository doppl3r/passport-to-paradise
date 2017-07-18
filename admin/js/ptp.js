(function( $ ) {
	'use strict';
	$(document).ready(function(){
		//$.post(ajaxurl, { 'action': 'add_user', 'name': 'Jake', 'points': 9013 }, function(response) { });
		//$.post(ajaxurl, { 'action': 'update_user', 'name': 'Jake', 'points': 9017 }, function(response) { });
		//$.post(ajaxurl, { 'action': 'delete_user', 'name': 'Jake' }, function(response) { });
	});

	//add new user
	$('#add_user').on('click', function(){ 
		$('.ptp-editor').remove(); //remove all existing editor windows
		var name = $("#new_user_name").val();
		var points = $("#new_user_points").val();
		var id = -1; //generated from mysql
		if (name.length > 0 && points <= 2147483647){ //name must have characters
			if (points.length < 1) points = 0;
			$.post(ajaxurl, { 'action': 'add_user', 'name': name, 'points': points }, function(response) { 
				if (parseInt(response) > 0){
					id = response;
					$('.ptp-list').append(
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
		$('.ptp-editor').remove(); //remove all existing editor windows
		//create input form
		var type = $(this).attr('data-type');
		var value = $(this).text();
		$('.ptp-list').append('<div class="ptp-editor"><input type="'+type+'" value="'+value+'"></div>');
		$('.ptp-editor').css({ top: ($(this).position().top), left: ($(this).position().left) });
		$('.ptp-editor input').focus().setCursorToTextEnd();
		//console.log($(this).parent().attr('id'));
	});

	//set cursor to the end
	$.fn.setCursorToTextEnd = function() {
        var $initialVal = this.val();
        this.val($initialVal);
    };
})( jQuery );

function victory(){ alert('victory'); }
