(function( $ ) {
	'use strict';
	$(document).ready(function(){
		
	});

	//add new user
	$('#add_user').on('click', function(){ 
		$('.ptp-editor').remove(); //remove all existing editor windows
		var name = $("#new_user_name").val();
		var points = $("#new_user_points").val();
		var id = -1; //generated from mysql
		if (name.length > 0 && points <= 2147483647){ //name must have characters
			if (points.length < 1) points = 0;
			if ($(this).hasClass('loading') == false){
				$(this).addClass('loading');
				$.post(ajaxurl, { 'action': 'add_user', 'name': name, 'points': points }, function(response) { 
					$('#add_user').removeClass('loading');
					if (parseInt(response) > 0){
						id = response;
						$('.ptp-list').append(
							'<div id="ptp-userid-'+id+'" class="row">'+
								'<div class="col-sm-6 item" data-type="text" data-column="name">'+name+'</div>'+
								'<div class="col-sm-6 item" data-type="number" data-column="points">'+points+'</div>'+
							'</div>'
						);
						//add goal icon class
						if ((name.toLowerCase()).indexOf('#goal') !== -1) $('#ptp-userid-'+id).find('[data-column="name"]').addClass("goal");
						$("#new_user_name").val('').focus();
						$("#new_user_points").val('');
					}
				});
			}
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
				'<span class="loader"></span>'+
				'<span class="edit save"><i class="material-icons">done</i></span>'+
				'<span class="edit cancel"><i class="material-icons">clear</i></span>'+
				'<span class="edit delete"><i class="material-icons">delete_forever</i></span>'+
			'</div>'
		);
		$('.ptp-editor').css({ top: ($(this).position().top), left: ($(this).position().left) });
		$('.ptp-editor input').focus().setCursorToTextEnd();
		$('.ptp-editor input').enterKey(function(){ $('.ptp-editor .save').click(); });
	});

	//save edit changes
	$('.ptp-editor .save').live('click', function(){ 
		var input = $('.ptp-editor input');
		var id = input.attr('data-id');
		var column = input.attr('data-column');
		var value = input.val(); //name or points
		$('.ptp-editor').addClass('loading'); //show loading symbol
		$.post(ajaxurl, { 'action': 'update_user', 'id': id, 'column': column, 'value': value }, function(response) { 
			$('.ptp-editor').remove(); //remove editor field
			$('#ptp-userid-' + id).find('[data-column="'+column+'"]').text(value);
			//add or remove goal icon class
			if (column == "name"){
				if ((value.toLowerCase()).indexOf('#goal') !== -1) $('#ptp-userid-'+id).find('[data-column="name"]').addClass("goal");
				else $('#ptp-userid-'+id).find('[data-column="name"]').removeClass("goal");
			}
		});
	});

	//cancel edit changes
	$('.ptp-editor .cancel').live('click', function(){ 
		$('.ptp-editor').remove();
	});

	//add delete action to the editor
	$('.ptp-editor .delete').live('click', function(){ 
		var input = $('.ptp-editor input');
		var id = input.attr('data-id');
		$('.ptp-editor').addClass('loading'); //show loading symbol
		$.post(ajaxurl, { 'action': 'delete_user', 'id': id }, function(response) { 
			$('.ptp-editor').remove(); //remove editor field
			$('#ptp-userid-' + id).remove();
		});
	});

	//remove editor if window resized
	$(window).on('resize',function(){ if (isMobile() == false) $('.ptp-editor').remove(); });

	//set cursor to the end
	$.fn.setCursorToTextEnd = function() {
        var $initialVal = this.val();
        this.val($initialVal);
	};
	
	//bind enter key
	$.fn.enterKey = function (fnc) {
		return this.each(function () {
			$(this).keypress(function (ev) {
				var keycode = (ev.keyCode ? ev.keyCode : ev.which);
				if (keycode == '13') { fnc.call(this, ev); }
			})
		})
	}

	//check if mobile device
	function isMobile() {
		return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
	}
})( jQuery );

function victory(){ alert('victory'); }
