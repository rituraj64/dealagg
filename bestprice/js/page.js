function follow(){
	var islog = $('#islogged').val();
	if(islog == 1){
		login(1);
	}else{
		var url = $('#site_url').val() + 'follow.php?query_id='+$('#query_id').val();
		$.getJSON(function(url, function(data) {
			
		});
	}
}
$(document).ready(function() {
	$('#genie-chldcat li').hide();
	$('#genie-chldcat li:first-child').show();
	$('#genie-chldcat li:eq(1)').css('clear', 'both');
	$('.genie-select').click(function(event) {
		var $target = $(event.target);
		if ($target.closest('.genie-catli').length > 0) {
			if (!$target.closest('.genie-catli').first().hasClass('genie-first')) {
				return;
			}
		}
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
				$('li.genie-catli').removeClass('discat');
				var catval = $(this).val();
				$('#category').val(catval);
				$("#genie-chldcat li").hide();
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
			if ($target.closest('.genie-select').length > 0) {

				if ($('ul#genie-chldcat').hasClass('closed')) {
					$('#genie-chldcat li').show();
					$('ul#genie-chldcat').removeClass('closed');
				} else {
					var select = false;
					$('li.genie-catli').each(function() {
						if ($(this).hasClass('discat')) {
							select = $(this);
							return 0;
						}
					});

					if (select) {
						if (up) {
							var ele = select.prev('li.genie-catli');
							if (ele.length > 0 && !ele.hasClass('genie-first')) {
								$('li.genie-catli').removeClass('discat');
								ele.addClass('discat');
							} else {
								$('li.genie-catli').removeClass('discat');
								$('li.genie-catli').last().addClass('discat');
							}
						} else {
							var ele = select.next('li.genie-catli');
							if (ele.length > 0) {
								$('li.genie-catli').removeClass('discat');
								ele.addClass('discat');
							} else {
								$('li.genie-catli').removeClass('discat');
								$('li.genie-catli:eq(1)').addClass('discat');
							}
						}
					}
				}
				event.preventDefault();
			}
		} else if (event.keyCode == 13 || event.keyCode == 9) {
			if ($target.closest('.genie-select').length > 0) {
				if (!$('ul#genie-chldcat').hasClass('closed')) {
					var select = false;
					$('li.genie-catli').each(function() {
						if ($(this).hasClass('discat')) {
							select = $(this);
							return 0;
						}
					});

					if (select) {
						var catval = select.val();
						$('#category').val(catval);
						event.preventDefault();
					}
					$("#genie-chldcat li").hide();
					$('ul#genie-chldcat').addClass('closed');
				}
			}
		} else if (isAlpha(event.keyCode)) {
			if ($target.closest('.genie-select').length > 0) {
				var key = String.fromCharCode(event.keyCode);
				if (key) {
					if ($('ul#genie-chldcat').hasClass('closed')) {
						$("#genie-chldcat li").show();
						$('ul#genie-chldcat').removeClass('closed');
					}
					$('li.genie-catli').each(function() {
						if (!$(this).hasClass('genie-first')) {
							if ($(this).text().toLowerCase().charAt(1) == key.toLowerCase()) {
								$('li.genie-catli').removeClass('discat');
								$(this).addClass('discat');
								event.preventDefault();
								return 0;
							}

						}
					});
				}

			}
		}
	});
	$(document).click(function(event) {
		var $target = $(event.target);
		if ($target.closest('#genie-chldcat,.genie-selicon,.genie-select').length == 0) {
			if (!$('ul#genie-chldcat').hasClass('closed')) {
				var select = false;
				$('li.genie-catli').each(function() {
					if ($(this).hasClass('discat')) {
						select = $(this);
						return 0;
					}
				});

				if (select) {
					var catval = select.val();
					$('#category').val(catval);
					event.preventDefault();
				}

				$("#genie-chldcat li").hide();
				$('ul#genie-chldcat').addClass('closed');
			}
		}
	});
});
function isAlpha(keyCode) {
	return ((keyCode >= 65 && keyCode <= 90) || keyCode == 8 || keyCode == 32 || keyCode == 190)
}
var brands = new Array();
brands[brands.length] = 'airtyme';
brands[brands.length] = 'alcatel';
brands[brands.length] = 'blackberry';
brands[brands.length] = 'byond';
brands[brands.length] = 'celkon';
brands[brands.length] = 'htc';
brands[brands.length] = 'huawei';
brands[brands.length] = 'idea';
brands[brands.length] = 'intex';
brands[brands.length] = 'karbonn';
brands[brands.length] = 'lg';
brands[brands.length] = 'lava';
brands[brands.length] = 'micromax';
brands[brands.length] = 'mitashi';
brands[brands.length] = 'motorola';
brands[brands.length] = 'nokia';
brands[brands.length] = 'salora';
brands[brands.length] = 'samsung';
brands[brands.length] = 'sansui';
brands[brands.length] = 'sony';
brands[brands.length] = 'sony ericsson';
brands[brands.length] = 'spice';
brands[brands.length] = 'videocon';
brands[brands.length] = 'xolo';
brands[brands.length] = 'zte';
brands[brands.length] = 'iball';
brands[brands.length] = 'aiptek';
brands[brands.length] = 'benq';
brands[brands.length] = 'canon';
brands[brands.length] = 'casio';
brands[brands.length] = 'fujifilm';
brands[brands.length] = 'jvc';
brands[brands.length] = 'nikon';
brands[brands.length] = 'olyumpus';
brands[brands.length] = 'panasonic';
brands[brands.length] = 'poloroid';
brands[brands.length] = 'rollei';
brands[brands.length] = 'samsung';
brands[brands.length] = 'sony';
brands[brands.length] = 'wespro';
brands[brands.length] = 'asus';
brands[brands.length] = 'dell';
brands[brands.length] = 'fujitsu';
brands[brands.length] = 'hp';
brands[brands.length] = 'lenovo';
brands[brands.length] = 'toshiba';
brands[brands.length] = 'acer';
brands[brands.length] = 'hcl';
brands[brands.length] = 'lg';
brands[brands.length] = 'wipro';
brands[brands.length] = 'apple';
brands[brands.length] = 'micromax';
brands[brands.length] = 'sandisk';