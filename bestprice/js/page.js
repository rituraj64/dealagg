$(document).ready(function() {
	$('#genie-chldcat li').css('display', 'none');
	$('#genie-chldcat li:first-child').show();
	$('#genie-chldcat li:eq(1)').css('clear', 'both');
	$('.genie-select').click(function(event) {
		var $target = $(event.target);
		if ($target.closest('.genie-catli').length > 0) {
			if (!$target.closest('.genie-catli').first().hasClass('genie-first')) {
				return;
			}
		}
		console.log('main click');
		if ($('ul#genie-chldcat').hasClass('closed')) {
			$('#genie-chldcat li').show();
			$('ul#genie-chldcat').removeClass('closed');
		} else {
			$('#genie-chldcat li').hide();
			$('ul#genie-chldcat').addClass('closed');
		}
	});
	$('li.genie-catli').click(function() {
		if (!$(this).hasClass('genie-first')) {
			if ($('ul#genie-chldcat').hasClass('closed')) {
				$('#genie-chldcat li').show();
				$('ul#genie-chldcat').removeClass('closed');
			} else {
				console.log('li click');
				$('li.genie-catli').removeClass('discat');
				var catval = $(this).val();
				$('#category').val(catval);
				$("#genie-chldcat li").css('display', 'none');
				$(this).addClass('discat');
				$('ul#genie-chldcat').addClass('closed');
			}
		}
	});
	$('li.genie-catli').hover(function() {
		if (!$(this).hasClass('genie-first')) {
			$('li.genie-catli').removeClass('discat');
			$(this).addClass('discat');
		}
	});
	$(document).keydown(function(event) {
		var $target = $(event.target);
		if (event.keyCode == 38 || event.keyCode == 40) {
			var up = true;
			if (event.keyCode == 40) {
				up = false;
			}
			if ($target.closest('li.genie-catli').length > 0) {
				console.log('li keypress');
				var select = false;
				$('li.genie-catli').each(function() {
					if ($(this).hasClass('discat')) {
						select = $(this);
						return 0;
					}
				});
				if (select) {
					if(down){
						var ele = select.next('li.genie-catli');
						if(ele){
							$('li.genie-catli').removeClass('discat');
							ele.addClass('discat');
						}else{
							$('li.genie-catli').removeClass('discat');
							$('li.genie-catli:eq(1)').addClass('discat');
						}
					}else{
						var ele = select.prev('li.genie-catli');
					}
				}
				event.preventDefault();
			} else if ($target.closest('.genie-select').length > 0) {
				console.log('main press');
				if ($('ul#genie-chldcat').hasClass('closed')) {
					$('#genie-chldcat li').show();
					$('ul#genie-chldcat').removeClass('closed');
				} else {
					var ele = $('li.genie-catli:eq(1)');
					ele.addClass('discat');
					ele.focus();
				}
				event.preventDefault();
			}
		}
	});
	$(document).click(function(event) {
		var $target = $(event.target);
		if ($target.closest('#genie-chldcat,.genie-selicon,.genie-select').length == 0) {
			console.log('hide from here');
			if (!$('ul#genie-chldcat').hasClass('closed')) {
				$("#genie-chldcat li").hide();
				$('ul#genie-chldcat').addClass('closed');
			}
		}
	});
});