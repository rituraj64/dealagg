var previousData = [];
var previousText = [];
var dropdown_display_size = 5;
var lastfuncid = '';
var returnVal = [];

var ajax = false;
var facebookajax = false;

function generateAutoHtml(id) {
	var el = document.getElementById(id);
	var arr = [];
	var attr = '';
	for ( var i = 0, attrs = el.attributes, l = attrs.length; i < l; i++) {
		arr[attrs.item(i).nodeName] = attrs.item(i).nodeValue;
	}
	var html = "<ul class='autocomplete_ul'>";
	html += "<li class='autocomplete_icon'>&nbsp;</li>";
	// html += "<li class='autocomplete_li_selected'><p class='selected'>IIT
	// Delhi <span class='selected'>&#215;</span></p></li>";
	html += "<li class='autocomplete_li'>";
	html += '<input id="' + id + '" type="text"/>';
	html += "</li></ul>";
	$('#' + id).replaceWith(html);
	for ( var key in arr) {
		if (key == 'type' || key == 'loop') {
			continue;
		}
		if (!arr[key] || arr[key].length == 0) {
			continue;
		}
		// document.getElementById(id).key = arr[key];
		$('#' + id).attr(key, arr[key]);

	}
	inputFocusBlur();
}

function initAutoComplete(id, func) {
	var addClass = '';
	if ($('#' + id).hasClass('auto_loaded')) {
		return;
	}
	$('#' + id).addClass('auto_loaded');
	generateAutoHtml(id);
	$('#' + id).attr('autocomplete', 'off');
	if ($('#' + id).hasClass('shortbar')) {
		$('#' + id).closest('ul.autocomplete_ul').addClass('shortbox');
		var width = parseInt($('#' + id).width()) - parseInt($('#' + id).css('paddingLeft').replace(/[^-\d\.]/g, ''));
		var w = getWidthValue(id);
		if (w) {
			width = w;
			$('#' + id).closest('ul.autocomplete_ul').attr('style', $('#' + id).closest('ul.autocomplete_ul') + ';width:' + width + 'px !important;');
		} else {
			$('#' + id).closest('ul.autocomplete_ul').css('width', width);
		}
		$('#' + id).closest('ul.autocomplete_ul').attr('style', $('#' + id).closest('ul.autocomplete_ul').attr('style') + ' ' + 'margin-bottom: 0px !important');
		addClass = 'processbar';
	}
	if ($('#' + id).hasClass('longbar')) {
		$('#' + id).closest('ul.autocomplete_ul').addClass('longbox');
		var width = parseInt($('#' + id).width()) - parseInt($('#' + id).css('paddingLeft').replace(/[^-\d\.]/g, ''));
		var w = getWidthValue(id);
		if (w) {
			width = w;
			$('#' + id).closest('ul.autocomplete_ul').attr('style', $('#' + id).closest('ul.autocomplete_ul').attr('style') + ';width:' + width + 'px !important;');
		}
		$('#' + id).closest('ul.autocomplete_ul').attr('style', $('#' + id).closest('ul.autocomplete_ul').attr('style') + ' ' + 'margin-bottom: 0px !important');
		addClass = 'longprocessbar';
	}

	if ($('#' + id).siblings('#suggestions-auto-com').length <= 0) {
		if ($('#' + id).hasClass('longbar')) {
			$('#' + id).parent('li').after('<li class="autocomplete_li_sug"><div id="suggestions-auto-com" class="longdropdown"></div></li>');
			$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").css('width', $('#' + id).closest('ul.autocomplete_ul').width());
			$('#' + id).css('width', $('#' + id).closest('ul.autocomplete_ul').width() - 25);
		} else {
			$('#' + id).parent('li').after('<li class="autocomplete_li_sug"><div id="suggestions-auto-com" class="shortdropdown"></div></li>');
			$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").css('width', $('#' + id).closest('ul.autocomplete_ul').width() + 4);
			$('#' + id).css('width', $('#' + id).closest('ul.autocomplete_ul').width() - 25);
		}
	}
	resetInputWidth(id);
	$('#' + id).live('blur', function(evt) {
		if (!$(this).hasClass('noaddnew')) {
			// var vfunc = getReturnFunc(id);
			// if(vfunc){
			// var inputVal = window[vfunc]();
			// if((inputVal.length == 0 || inputVal == -1) &&
			// $(this).val().length > 0){
			// updateValue(false,id,$(this).val(),-1,true);
			// }
			// }
			var inputVal = returnVal[id];
			if (inputVal && (inputVal.length == 0 || inputVal == -1) && $(this).val().length > 0) {
				updateValue(false, id, $(this).val(), -1, true);
			}
		}
	});
	$('#' + id).live('keydown', function(evt) {
		var entities = $(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata');

		if (evt.keyCode == '40') { // down
			if (entities.length <= 0) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata').first().addClass('active');
			}
			var active = getActiveEntity(entities);
			active = parseInt(active) + 1;
			if (active >= entities.length) {
				active = 0;
				entities.hide();
				for ( var j = 0; j < dropdown_display_size; j++) {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('#' + j + "_entity").show();
				}
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata-add').show();
			}
			if ($('#' + active + "_entity")) {
				entities.removeClass('active');
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('#' + active + "_entity").addClass('active');
			}

			var entity = false;
			entities.each(function() {
				var entity1 = $(this);
				if (!entity && entity1.is(":visible") && !entity1.hasClass('formatdata-add')) {
					entity = entity1;
				}
			});
			if (!entity) {
				return;
			}
			var e_id = entity.attr('id');
			entity_index = e_id.substr(0, e_id.indexOf('_'), e_id) * 1;
			if (active >= entity_index + dropdown_display_size) {
				if (!entity.hasClass('formatdata-add')) {
					entity.hide();
				}
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('#' + active + "_entity").show();
			}

			entity = false;
			entities.each(function() {
				var entity1 = $(this);
				if (!entity && entity1.is(":visible") && !entity1.hasClass('formatdata-add')) {
					entity = entity1;
				}
			});
			e_id = entity.attr('id');
			entity_index = e_id.substr(0, e_id.indexOf('_'), id) * 1;
			if (entity_index == 0) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').hide();
			} else {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').show();
				if (entity_index > 1) {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').find('span').html(entity_index + " more items left");
				} else {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').find('span').html(entity_index + " more item left");
				}
			}

			entity = false;
			entities.each(function() {
				var entity1 = $(this);
				if (entity1.is(":visible") && !entity1.hasClass('formatdata-add')) {
					entity = entity1;
				}
			});
			e_id = entity.attr('id');
			entity_index = e_id.substr(0, e_id.indexOf('_'), e_id) * 1;
			var offset = 2;
			if ($('#' + id).hasClass('noaddnew')) {
				offset = 1;
			}
			if (entity_index >= entities.length - offset) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').hide();
			} else {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').show();
				var diff = entities.length - entity_index - offset;
				if (diff > 1) {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').find('span').html(diff + " more items left");
				} else {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').find('span').html(diff + " more item left");
				}
			}
			evt.preventDefault();

		} else if (evt.keyCode == '38') { // up

			if (entities.length <= 0) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata').first().addClass('active');
			}
			var active = getActiveEntity(entities);
			active = parseInt(active) - 1;
			if (active <= -1) {
				active = entities.length - 1;
				entities.hide();
				for ( var j = active; j >= active - dropdown_display_size; j--) {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('#' + j + "_entity").show();
				}

			}
			if ($('#' + active + "_entity")) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children().removeClass('active');
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('#' + active + "_entity").addClass('active');
			}
			var entity = false;
			if (!$('#' + active + "_entity").is(':visible')) {
				$('#' + active + "_entity").show();
				entities.each(function() {
					var entity1 = $(this);
					if (entity1.is(":visible") && !entity1.hasClass('formatdata-add')) {
						entity = entity1;
					}
				});
				entity.hide();
			}

			entity = false;
			entities.each(function() {
				var entity1 = $(this);
				if (!entity && entity1.is(":visible") && !entity1.hasClass('formatdata-add')) {
					entity = entity1;
				}
			});
			if (!entity) {
				return;
			}
			e_id = entity.attr('id');
			entity_index = e_id.substr(0, e_id.indexOf('_'), e_id) * 1;
			if (entity_index == 0) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').hide();
			} else {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').show();
				if (entity_index > 1) {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').find('span').html(entity_index + " more items left");
				} else {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.up_box').find('span').html(entity_index + " more item left");
				}

			}

			entity = false;
			entities.each(function() {
				var entity1 = $(this);
				if (entity1.is(":visible") && !entity1.hasClass('formatdata-add')) {
					entity = entity1;
				}
			});
			e_id = entity.attr('id');
			entity_index = e_id.substr(0, e_id.indexOf('_'), e_id) * 1;
			var offset = 2;
			if ($('#' + id).hasClass('noaddnew')) {
				offset = 1;
			}
			if (entity_index >= entities.length - offset) {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').hide();
			} else {
				$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').show();
				var diff = entities.length - entity_index - offset;
				if (diff > 1) {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').find('span').html(diff + " more items left");
				} else {
					$(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.down_box').find('span').html(diff + " more item left");
				}
			}
			evt.preventDefault();

		} else if (evt.keyCode == '39') {
			// right
		} else if (evt.keyCode == '37') {
			// left
		} else if (evt.keyCode == '13') {
			// enter
			var entity = $(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.active');
			if (entity.length > 0) {
				selectEntity(entity.first());
			} else {
				closeAutocomplete(id);
			}
		} else if (evt.keyCode == '32') {
			// space
		} else if (evt.keyCode == '9') {
			// tab
			var entity = $(this).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.active');
			if (entity.length > 0) {
				selectEntity(entity.first());
			} else {
				closeAutocomplete(id);
			}
		} else if (evt.keyCode == '8') {
			if ($('#' + id).parent().siblings('.autocomplete_li_selected').length > 0) {
				if ($('#' + id).parent().siblings('.autocomplete_li_selected').last().hasClass('autocomplete_li_selected_active')) {
					$('#' + id).parent().siblings('.autocomplete_li_selected').last().remove();
				} else {
					$('#' + id).parent().siblings('.autocomplete_li_selected').last().addClass('autocomplete_li_selected_active');
				}
			}
		}

	});
	$('#' + id).live('keydown', function(evt) {
		resetInputWidth(id);
	});
	$('#' + id).live('focus', function(evt) {
		resetInputWidth(id);
		$('.autocomplete_li_selected').each(function() {
			$(this).removeClass('autocomplete_li_selected_active');
		});

	});
	$('#' + id).live('blur', function(evt) {
		resetInputWidth(id);
	});
	$('#' + id).live('click', function(evt) {
		resetInputWidth(id);
	});
	$('#' + id).live('keyup', function(evt) {
		if (evt.keyCode == 9 || evt.keyCode == 13) {
			return;
		}
		var val = $('#' + id).val();
		var change = true;

		var trigger = getTrigger(id);
		val = getTriggerValue(val, trigger);

		if (previousText[id] !== undefined && previousText[id] == val) {
			change = false;
		}
		previousText[id] = val;

		var threshhold = 1;
		if ($('#' + id).hasClass('selfmatch')) {
			threshhold = 0;
		}

		if (change) {
			if (val.length > threshhold) {
				$('#' + id).closest('.autocomplete_ul').addClass(addClass);
				if (previousData[id] !== undefined) {
					var data = previousData[id];
					if (data[val] !== undefined) {
						lastfuncid = id;
						if (facebookajax) {
							facebookajax.abort();
						}
						if (ajax) {
							ajax.abort();
						}
						updateAuto(previousData[id][val], true);
					} else {
						lastfuncid = id;
						if (facebookajax) {
							facebookajax.abort();
						}
						if (ajax) {
							ajax.abort();
						}
						window[func](val);
					}
				} else {
					lastfuncid = id;
					if (facebookajax) {
						facebookajax.abort();
					}
					if (ajax) {
						ajax.abort();
					}
					window[func](val);
				}
			} else {
				closeAutocomplete(id);
			}
		}
	});

	// var css = 'border-bottom-right-radius:none
	// !important;border-bottom-left-radius:none
	// !important;-webkit-border-bottom-right-radius:none
	// !important;-webkit-border-bottom-left-radius:none
	// !important;-moz-border-radius-bottomright: none
	// !important;-moz-border-radius-bottomleft: none !important;'
	// $('#' + id).attr('style', $('#' + id).attr('style') + '; ' + css);
}
function updateAuto(json, cache) {
	var id = lastfuncid;
	if ($('#' + id).closest('.autocomplete_ul').hasClass('shortbox')) {
		$('#' + id).closest('.autocomplete_ul').removeClass('processbar');
	} else {
		$('#' + id).closest('.autocomplete_ul').removeClass('longprocessbar');
	}
	updateValue(false, id);
	var i = 0;
	var appendData = '';
	if (json == undefined) {
		json = [];
	}
	if (json != null || json.length == 0) {
		var val = $('#' + id).val();
		var trigger = getTrigger(id);
		val = getTriggerValue(val, trigger);
		val = $.trim(val);
		if (cache === undefined) {
			if ($('#' + id).hasClass('selfmatch')) {
				json = sortData(json, val, id);
			}
		}
		if (previousData[id] !== undefined) {
			previousData[id][val] = json;
		} else {
			previousData[id] = [];
			previousData[id][val] = json;
		}
		if ($('#' + id).hasClass('longbar')) {
			appendData += '<div style="display:none" class="up_box up_box_long"><span>1 more item left</span></div>';
		} else {
			appendData += '<div style="display:none" class="up_box up_box_short"><span>1 more item left</span></div>';
		}
		appendData += '<div class="clear"></div>';
		var boxClass = '';
		$.each(json, function(index, dataval) {
			if (!dataval.key) {
				dataval.key = '';
			}
			var cont = true;
			$('#' + id).parent().siblings('.autocomplete_li_selected').each(function() {
				if ($(this).find('#key').val() == dataval.key) {
					cont = false;
				}
			});
			if (cont) {
				boxClass = '';
				if (!dataval.longtext && !dataval.img) {
					boxClass = 'box-empty';
				}
				if (i >= dropdown_display_size) {
					appendData += '<div style="display:none" class="formatdata" id="' + (i++) + '_entity"><div class="box ' + boxClass + '">';
				} else {
					appendData += '<div class="formatdata" id="' + (i++) + '_entity"><div class="box ' + boxClass + '">';
				}
				appendData += '<input type="hidden" class="' + id + '" id="key" value="' + dataval.key + '">';
				if (dataval.img) {
					appendData += '<img class="img" src="' + dataval.img + '" alt="no-image" width="30" hegith="30">';
				}
				appendData += '<div class="textbox"><span class="text divstylespan">' + dataval.text + '</span>';
				if (dataval.longtext) {
					appendData += '<span class="longtext divstylespan">' + dataval.longtext + '</span>';
				}
				appendData += '</div>';
				appendData += '</div><div class="clear"></div></div>';
			}
		});
		if (i <= 2 && i > 0 && getAutoType(id) == 'facebook' && !$('#' + id).hasClass('noaddnew')) {
			appendData += '<div class="fb_noitem"><span class="auto_facebook_loading">Searching Facebook</span></div>';
		}
		if (i > dropdown_display_size) {
			var diff = i - dropdown_display_size;
			if (diff > 1) {
				if ($('#' + id).hasClass('longbar')) {
					appendData += '<div class="down_box down_box_long"><span>' + diff + ' more items left</span></div>';
				} else {
					appendData += '<div class="down_box down_box_short"><span>' + diff + ' more items left</span></div>';
				}
			} else {
				if ($('#' + id).hasClass('longbar')) {
					appendData += '<div class="down_box down_box_long"><span>' + diff + ' more item left</span></div>';
				} else {
					appendData += '<div class="down_box down_box_short"><span>' + diff + ' more item left</span></div>';
				}
			}
			appendData += '<div class="clear"></div>';
		} else {
			if ($('#' + id).hasClass('longbar')) {
				appendData += '<div style="display:none" class="down_box down_box_long"><span>1 more item left</span></div>';
			} else {
				appendData += '<div style="display:none" class="down_box down_box_short"><span>1 more item left</span></div>';
			}

			appendData += '<div class="clear"></div>';
		}
		if (i <= 2) {
			var noitem_class = '';
			var fb_html = '';
			if (getAutoType(id) == 'facebook' && !$('#' + id).hasClass('noaddnew')) {
				fb_html = '<span class="auto_facebook_loading">Searching Facebook</span>';
				noitem_class += ' noitem_facebook';
				var baseurl = $('#auto_baseurl').val();
				facebookajax = $.getJSON(baseurl + '../../social/ck.php?term=' + val, function(data) {
					$('.auto_facebook_loading').hide();
					$('.fb_noitem').remove();
					facebookUpdateAuto(data);
				});
			}
			if ($('#' + id).hasClass('longbar')) {
				noitem_class += ' noitem_short';
			} else {
				noitem_class += ' noitem_long';
			}
			if (i == 0) {
				appendData += '<div class="noitem ' + noitem_class + '"><span>No Items Found</span>' + fb_html + '</div>';
			}
		}

	}
	var dispVal = $('#' + id).val();
	if (dispVal.length >= 28) {
		dispVal = dispVal.substr(0, 25) + "...";
	}
	if (!$('#' + id).hasClass('noaddnew')) {
		appendData += '<div class="formatdata formatdata-add" id="' + (i++) + '_entity"><div class="box addbox">';
		appendData += '<input type="hidden" class="' + id + '" id="key" value="-1">';
		appendData += '<div class="left-textbox"><span class="text icon-plus"></span><span class="text-addnew">Add New</span><span class="text-value">' + dispVal + '</span></div>';
		appendData += '<div class="clear"></div></div>';
	}

	$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").html(appendData);
	$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").children('.formatdata').first().addClass('active');
	$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").show();

	var entity1 = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata').not('.formatdata-add');
	if (entity1.length == 1) {
		if ($('#' + id).hasClass('noaddnew')) {
			if (!$('#' + id).hasClass('noautofill')) {
				selectEntity(entity1.first());
			}
		} else {
			// updateValue(entity1.first());
		}
	} else if (entity1.length == 0) {
		var entity2 = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata-add');
		if (entity2.length == 1) {
			updateValue(entity2.first());
		}
	}
}

function facebookUpdateAuto(json, cache) {
	var id = lastfuncid;
	var i = 0;
	var appendData = '';
	if (json != null || json.length == 0) {
		var val = $('#' + id).val();
		var trigger = getTrigger(id);
		val = getTriggerValue(val, trigger);
		val = $.trim(val);
		if (cache === undefined) {
			if ($('#' + id).hasClass('selfmatch')) {
				json = sortData(json, val, id);
			}
		}
		/*
		 * if(previousData[id] !== undefined){ previousData[id][val] = json;
		 * }else{ previousData[id] = []; previousData[id][val] = json; }
		 */
		i = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.formatdata').not('.formatdata-add').length;
		if (json.length > 0) {
			appendData += '<div class="clear"></div>';
		}
		var boxClass = '';
		$.each(json, function(index, dataval) {
			boxClass = '';
			if (!dataval.longtext && !dataval.img) {
				boxClass = 'box-empty';
			}
			if (i >= dropdown_display_size) {
				appendData += '<div style="display:none" class="formatdata autotype_facebook" id="' + (i++) + '_entity"><div class="box ' + boxClass + '">';
			} else {
				appendData += '<div class="formatdata autotype_facebook" id="' + (i++) + '_entity"><div class="box ' + boxClass + '">';
			}
			if (!dataval.key) {
				dataval.key = '';
			}
			appendData += '<input type="hidden" class="' + id + '" id="key" value="' + dataval.key + '">';
			if (dataval.img) {
				appendData += '<img class="img" src="' + dataval.img + '" alt="" width="30" hegith="30">';
			}
			appendData += '<div class="textbox"><span class="text divstylespan">' + dataval.text + '</span>';
			if (dataval.longtext) {
				appendData += '<span class="longtext divstylespan">' + dataval.longtext + '</span>';
			}
			appendData += '<span class="autotype_facebook_img"></span></div>';
			appendData += '</div><div class="clear"></div></div>';
		});

	}
	if (appendData.length > 0) {
		if ($('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.formatdata').not('.formatdata-add').length > 0) {
			$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.formatdata').not('.formatdata-add').last().after(appendData);
		} else {
			$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.down_box').before(appendData);
		}
		$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.noitem').hide();

		var entity = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.formatdata').not('.formatdata-add').last();
		var id1 = entity.attr('id');
		entity_active = id1.substr(0, id1.indexOf('_'), id1) * 1;
		entity_active = parseInt(entity_active) + 1;

		$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.formatdata-add').attr('id', entity_active + '_entity');

		if (i > dropdown_display_size) {
			var diff = i - dropdown_display_size;
			var ele = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.down_box').first().children('span');
			if (diff > 1) {
				ele.html(diff + ' more items left');
			} else {
				ele.html(diff + ' more item left');
			}
			$('#' + id).parent('li').siblings('.autocomplete_li_sug').children("#suggestions-auto-com").find('.down_box').first().show();
		}

		var entity1 = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata').not('.formatdata-add');
		if (entity1.length == 0) {
			var entity2 = $('#' + id).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').children('.formatdata-add');
			if (entity2.length == 1) {
				updateValue(entity2.first());
			}
		}
	}
}

$(document).ready(function() {
	scanAuto();
	inputFocusBlur();
	$('.autocomplete_ul').live('click', function(event) {
		var target = $(event.target);
		if (target.hasClass('autocomplete_ul')) {
			target.find('input').focus();
		}
	});
	$('.autocomplete_li_selected').live('click', function() {
		if ($(this).hasClass('autocomplete_li_selected_active')) {
			$(this).removeClass('autocomplete_li_selected_active');
			$('.autocomplete_li_selected').closest('ul').find('input').focus();
		} else {
			$(this).addClass('autocomplete_li_selected_active');
			$('.autocomplete_li_selected').closest('ul').find('input').blur();
		}
	});
	$('.autocomplete_li_selected span.selected').live('click', function() {
		var val = $(this).closest('.autocomplete_li_selected').find('#key').val();
		var text = $(this).closest('.autocomplete_li_selected').find('.text').html();
		var id = $(this).closest('.autocomplete_li_selected').find('#autoid').val();
		var func = getMultiRemove(id);
		if (func) {
			window[func](val, text);
		}
		$(this).closest('.autocomplete_li_selected').remove();
		$('#' + id).focus();
	});
	$('.formatdata').live('hover', function() {
		var entities = $(this).parent('#suggestions-auto-com').children();
		entities.removeClass('active');
		$(this).addClass('active');
	});
	$('.formatdata').live('click', function() {
		selectEntity($(this));
	});
	$(document).click(function(event) {
		var $target = $(event.target);
		if ($target.closest('#suggestions-auto-com').length == 1) {
			return;
		}
		if ($target.hasClass('shortbox') || $target.hasClass('longbox')) {
			return;
		}
		closeAutocomplete('');
	});

});

var sort_val = '';
function sortData(json, val, id) {
	var sort = [];
	var index = -1;
	var i = 0;
	$.each(json, function(index, data) {
		var cont = true;
		$('#' + id).parent().siblings('.autocomplete_li_selected').each(function() {
			if ($(this).find('#key').val() == data.key) {
				cont = false;
			}
		});
		if (cont) {
			if (data.text.toLowerCase().indexOf(val.toLowerCase()) >= 0) {
				sort[i] = data;
				i++;
			}
		}
	});
	sort_val = val;
	sort = sort.sort(json_sort);
	return sort;
}

function json_sort(a, b) {
	var index1 = a.text.indexOf(sort_val);
	var index2 = b.text.indexOf(sort_val);
	return (index1 > index2);
}

function updateValue(entity, id1, text1, val1, isSelected) {
	var id = '';
	var val = '';
	var text = '';
	var img = '';
	var longtext = '';
	if (id1 && id1.length > 0) {
		id = id1;
	}
	if (text1 && text1.length > 0) {
		text = text1;
	}
	if ((val1 && val1.length > 0) || val1 == -1) {
		val = val1;
	}
	if (entity == undefined || !entity) {
	} else if (entity.hasClass('formatdata-add')) {
		id = entity.find('#key').attr('class');
		val = -1;
		text = $('#' + id).val();
	} else {
		text = entity.find('.text').html();
		if (entity.find('.longtext').length > 0) {
			longtext = entity.find('.longtext').html();
		}
		if (entity.find('.img').length > 0) {
			img = entity.find('.img').attr('src');
		}
		val = entity.find('#key').val();
		id = entity.find('#key').attr('class');
	}
	var trigger = getTrigger(id);
	if (trigger) {
		text = $('#' + id).val().substr(0, $('#' + id).val().indexOf(trigger)) + trigger + text;
	}
	if (!val || val.length == 0 || val != -1) {
		val = text;
	}
	var valueFunc = getValueFunc(id);
	returnVal[id] = val;
	if (valueFunc) {
		window[valueFunc](text, val, longtext, img, isSelected);
	} else {
		var name = $('#' + id).attr('name');
		name += '_auto';
		if ($('#' + id).siblings('input[name="' + name + '"]').length > 0) {
			$('#' + id).siblings('input[name="' + name + '"]').val(val);
		} else {
			var html = '<input type="hidden" name="' + name + '" value="' + val + '" />';
			$('#' + id).after(html);
		}
	}
}
function selectEntity(entity) {
	var id = '';
	var val = '';
	var text = '';
	var img = '';
	var longtext = '';
	if (entity.hasClass('formatdata-add')) {
		id = entity.find('#key').attr('class');
		val = -1;
		text = $('#' + id).val();
	} else {
		text = entity.find('.text').html();
		val = entity.find('#key').val();
		id = entity.find('#key').attr('class');
		if (entity.find('.longtext').length > 0) {
			longtext = entity.find('.longtext').html();
		}
		if (entity.find('.img').length > 0) {
			img = entity.find('.img').attr('src');
		}
	}
	var trigger = getTrigger(id);
	if (trigger) {
		text = $('#' + id).val().substr(0, $('#' + id).val().indexOf(trigger)) + trigger + text;
	}
	if (!val || val.length == 0) {
		val = text;
	}
	if (text.length > 0) {
		if ($('#' + id).hasClass('multiselect')) {
			var html = "<li class='autocomplete_li_selected'><input type='hidden' id='autoid' value='" + id + "' /><input type='hidden' id='key' value='" + val + "' /><p class='selected'><span class='text'>" + text + "</span><span class='selected'>&#215;</span></p></li>";
			$('#' + id).parent().before(html);
			$('#' + id).val('');
			$('#' + id).focus();
		} else {
			entity.closest('.autocomplete_li_sug').siblings('.autocomplete_li').children('#' + id).val(text);
		}
	}
	var valueFunc = getValueFunc(id);
	returnVal[id] = val;
	if (valueFunc) {
		window[valueFunc](text, val, longtext, img, true);
	} else {
		var name = $('#' + id).attr('name');
		name += '_auto';
		if ($('#' + id).siblings('input[name="' + name + '"]').length > 0) {
			$('#' + id).siblings('input[name="' + name + '"]').val(val);
		} else {
			var html = '<input type="hidden" name="' + name + '" value="' + val + '" />';
			$('#' + id).after(html);
		}
	}
	closeAutocomplete(id);
}
function getActiveEntity(entities) {
	var entity_active = -1;
	entities.each(function() {
		var entity = $(this);
		if (entity.hasClass('active')) {
			var id = entity.attr('id');
			entity_active = id.substr(0, id.indexOf('_'), id) * 1;
			return;
		}
	});
	return entity_active;
}
function closeAutocomplete(id) {
	if (id.length == 0) {
		$('.shortbox,.longbox').each(function() {
			if ($(this).find('input[type=text]').length > 0 && $(this).find('input[type=text]').attr('id').length > 0) {
				closeAutocomplete($(this).find('input[type=text]').attr('id'));
			}
		});
	}
	var addClass = '';
	if ($('#' + id).hasClass('shortbar')) {
		addClass = 'processbar';
	}
	if ($('#' + id).hasClass('longbar')) {
		addClass = 'longprocessbar';
	}
	$('#' + id).removeClass(addClass);
	if ($('#' + id).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').length > 0) {
		$('#' + id).parent('li').siblings('.autocomplete_li_sug').children('#suggestions-auto-com').hide();
	}
}

function getMultiRemove(id) {
	var id_class = $('#' + id).attr('class');
	var trigger = false;
	if (id_class.indexOf('multiremove[') >= 0) {
		var index_start = id_class.indexOf('multiremove[') + 'multiremove['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		trigger = id_class.substr(index_start, index_end);
	}
	return trigger;
}
function getAutoType(id) {
	var id_class = $('#' + id).attr('class');
	var trigger = false;
	if (id_class.indexOf('autotype[') >= 0) {
		var index_start = id_class.indexOf('autotype[') + 'autotype['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		trigger = id_class.substr(index_start, index_end);
	}
	return trigger;
}
function getReturnFunc(id) {
	var id_class = $('#' + id).attr('class');
	var trigger = false;
	if (id_class.indexOf('return[') >= 0) {
		var index_start = id_class.indexOf('return[') + 'return['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		trigger = id_class.substr(index_start, index_end);
	}
	return trigger;
}
function getTrigger(id) {
	var id_class = $('#' + id).attr('class');
	var trigger = false;
	if (id_class.indexOf('trigger[') >= 0) {
		var index_start = id_class.indexOf('trigger[') + 'trigger['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		trigger = id_class.substr(index_start, index_end);
	}
	return trigger;
}

function getValueFunc(id) {
	var id_class = $('#' + id).attr('class');
	var func = false;
	if (id_class.indexOf('value[') >= 0) {
		var index_start = id_class.indexOf('value[') + 'value['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		func = id_class.substr(index_start, index_end);
	}
	return func;
}
function getTriggerValue(val, trigger) {
	if (trigger) {
		if (val.indexOf(trigger) == -1) {
			return '';
		} else {
			val = val.substr(val.indexOf(trigger) + 1, val.length);
		}
	}
	val = $.trim(val);
	return val;
}

function getFuncValue(id) {
	var id_class = $('#' + id).attr('class');
	var func = false;
	if (id_class.indexOf('func[') >= 0) {
		var index_start = id_class.indexOf('func[') + 'func['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		func = id_class.substr(index_start, index_end);
	}
	return func;
}
function getWidthValue(id) {
	var id_class = $('#' + id).attr('class');
	var func = false;
	if (id_class.indexOf('width[') >= 0) {
		var index_start = id_class.indexOf('width[') + 'width['.length;
		var index_end = id_class.indexOf(']', index_start) - index_start;
		func = id_class.substr(index_start, index_end);
	}
	return func;
}

function scanAuto() {
	var id = '', func = '';
	$('.autocomplete').not('.auto_loaded').each(function() {
		id = $(this).attr('id');
		func = getFuncValue(id);
		if (func) {
			initAutoComplete(id, func);
		}
	});
}
function resetInputWidth(id, override) {
	if (override) {

	} else {
		if (!$('#' + id).hasClass('multiselect')) {
			return;
		}
	}

	var width = ($('#' + id).val().length * 7) + 30;
	$('#' + id).css('width', width);
	var style = $('#' + id).attr('style');
	style = style.replace('width: ' + width + 'px;', 'width: ' + width + 'px !important;');
	$('#' + id).attr('style', style);
	$('#' + id).attr('style', $('#' + id).attr('style') + ' ' + 'padding-left: 5px !important');
}
function fineWithAuto(entity) {
	if (entity.attr('id')) {
		var id = entity.attr('id');
		if ($('#' + id).parent().siblings('.autocomplete_li_selected').length > 0) {
			return false;
		} else {
			return true;
		}
	}
}

function inputFocusBlur() {
	// blur,focus section of input box
	jQuery('.textinput').each(function() {
		jQuery(this).addClass('changedeactivetxtcolor');
		var def = jQuery(this).attr('alt');
		if (jQuery(this).val().length == 0) {
			jQuery(this).val(def);
		}

		jQuery(this).live('focus', function() {
			jQuery(this).removeClass('changedeactivetxtcolor');
			jQuery(this).addClass('changeactivetxtcolor');
			if (fineWithAuto(jQuery(this))) {
				var def = jQuery(this).attr('alt');
				if (jQuery(this).val() == def) {
					jQuery(this).val('');
				}
			}

		});

		jQuery(this).live('blur', function() {
			if (fineWithAuto(jQuery(this))) {
				var def = jQuery(this).attr('alt');
				if (jQuery(this).val().length == 0) {
					jQuery(this).val(def);
					jQuery(this).removeClass('changeactivetxtcolor');
					jQuery(this).addClass('changedeactivetxtcolor');
				} else if (jQuery(this).val() != def) {
					jQuery(this).removeClass('changedeactivetxtcolor');
					jQuery(this).addClass('changeactivetxtcolor');
				}
				if (jQuery(this).attr('id')) {
					resetInputWidth(jQuery(this).attr('id'));
				}
			}
		});

	});

}