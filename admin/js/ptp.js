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
							'<div class="col-sm-6 item" data-type="text" data-column="name">'+name+'</div>'+
							'<div class="col-sm-6 item" data-type="number" data-column="points">'+points+'</div>'+
						'</div>'
					);
					$("#new_user_name").val('');
					$("#new_user_points").val('');
				}
			});
		}
	});

	//edit data from existing item
	$('.ptp-list .item').live('click', function(){ 
		$('.ptp-editor').remove(); //remove all existing editor windows
		var id = parseInt($(this).parent().attr('id').replace( /^\D+/g, ''));
		var column = $(this).attr('data-column');
		var type = $(this).attr('data-type');
		var value = $(this).text();
		$('.ptp-list').append(
			'<div class="ptp-editor">'+
				'<input type="'+type+'" value="'+value+'" data-id="'+id+'" data-column="'+column+'">'+
				'<span class="edit save"><i class="material-icons">done</i></span>'+
				'<span class="edit cancel"><i class="material-icons">clear</i></span>'+
				'<span class="edit delete"><i class="material-icons">delete_forever</i></span>'+
			'</div>'
		);
		$('.ptp-editor').css({ top: ($(this).position().top), left: ($(this).position().left) });
		$('.ptp-editor input').focus().setCursorToTextEnd();
		//console.log($(this).parent().attr('id'));
	});

	//add actions to the editor
	$('.ptp-editor .save').live('click', function(){ 
		var input = $('.ptp-editor input');
		var id = input.attr('data-id');
		var column = input.attr('data-column');
		var value = input.val(); //name or points
		$.post(ajaxurl, { 'action': 'update_user', 'id': id, 'column': column, 'value': value }, function(response) { 
			$('.ptp-editor').remove(); //remove editor field
			$('#ptp-userid-' + id).find('[data-column="'+column+'"]').text(value);
			console.log(response);
		});
	});
	$('.ptp-editor .cancel').live('click', function(){ 
		$('.ptp-editor').remove();
	});

	//set cursor to the end
	$.fn.setCursorToTextEnd = function() {
        var $initialVal = this.val();
        this.val($initialVal);
    };
})( jQuery );

function victory(){ alert('victory'); }
