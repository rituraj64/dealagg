var offsetTop = 0;
$(document).ready(function() {
	offsetTop = $('#summary').offset().top;
	$(window).scroll(function() {
		if ($('#summary').hasClass('finished')) {

		} else {
			var dis = offsetTop - $(window).scrollTop();
			if (dis <= 0) {
				if (!$('#summary').hasClass('summary_float'))
					$('#summary').addClass('summary_float');
			} else {
				if ($('#summary').hasClass('summary_float'))
					$('#summary').removeClass('summary_float');
			}
		}
	});

	$('.apply_tooltip').tooltip();
	$('.popup').popover();
	$('.detail-popup').live('click', function() {
		if (!$(this).hasClass('clicked')) {
			$(this).html('Close');
			$(this).addClass('clicked');
		} else {
			$(this).html('Details');
			$(this).removeClass('clicked');
		}
	});
	$('.website_hide_let_it_be').live('click', function() {
		var website = $(this).parents('.website').first().attr('id');
		makeBig(website);
	});
	$('.website_hide_remove').live('click', function() {
		$(this).parents('.website').first().remove();
	});
});
function hideError() {
	$('#error_msg').hide();
}
var timeout = false;
var starttime = new Date().getTime();
var ajaxReq = new Array();
var item_id_count = 0;
function closeModel(subcat) {
	$('#subcategory').val(subcat);
	$('#subcategory_model').modal('toggle');
	$('.modal-backdrop').remove();
	findPrice("", 1, 1, false);
}
function findPrice(site, cache, trust, changeSubCat, searchThis) {

	if (trust == undefined) {
		trust = 1;
	}
	if (trust == undefined) {
		trust = 0;
	}
	if (cache === undefined) {
		cache = 1;
	}
	if (changeSubCat == undefined) {
		changeSubCat = true;
	}

	$('.jumbotron').children('h1').remove();

	if ($('#category').val() == -1) {
		$('#error_msg').find('span').html('Select a category for accurate results!');
		$('#error_msg').show();
		setTimeout('hideError()', 2000);
		return;
	}
	if ($('#q').val().length == 0) {
		$('#error_msg').find('span').html('Please write the product name!');
		$('#error_msg').show();
		setTimeout('hideError()', 2000);
		return;
	}

	var query = $('#q').val();
	var category = $('#category').val();
	var subcat = $('#subcategory').val();
	if ($('#category_data').children('#' + category + "_sub").length > 0) {
		if (subcat * 1 <= 0) {
			var html2 = '';
			$('#category_data').children('#' + category + "_sub").children().each(function() {
				html2 += '<li><a tabindex="-1" href="#" onclick="closeModel(\'' + $(this).attr('id') + '\');return false;">' + $(this).val() + '</a></li>';
			});
			$('#subcat_dropdown_content').html(html2);
			// $('#dropdown-sub').dropdown('toggle');
			$('#subcategory_model').modal('show');
			return;
		}
	}
	if (site && site.length > 0) {
		var url = $('#ajax_url').val().replace('site', site) + 'find.php?q=' + query + '&cat=' + category + "&site=" + site + "&cache=" + cache + "&subcat=" + subcat + "&callback=?";
	} else {
		// reset all here on first button click
		$('#loading').show();
		$('#results').hide();
		$('#results').html('');
		$('#step').hide();
		$('#step_items').html('');
		// $('#progress').hide();
		$('#progress').find('.bar').first().attr('style', 'width:0%');
		$('#progess_text').html('Starting...');
		$('#progress_total').val(0);
		$('#progress_done').val(0);
		$('#summary').find('#max_time').val(0)
		$('#summary').find('#time_taken').html('');
		$('#summary').find('#time').html('');
		$('#summary').show();
		$('#share').hide();
		$('#share_url').val('');
		$('#avg_best_price').val(0);
		prev_highest_score = '';
		prev_highest_score_value = 0;
		item_id_count = 0;
		untrusted = new Array();
		$('#bad-results').hide();
		$('#bad_result_items').html('');
		if (changeSubCat == 1) {
			$('#subcategory').val(-1);
		}
		var aj = 0;
		for (aj = 0; aj < ajaxReq.length; aj++) {
			if (ajaxReq[aj]) {
				ajaxReq[aj].abort();
			}
		}
		$('#summary').removeClass('finished')
		if (searchThis == 0) { // called from searchThis
			$('#showSuggestion').val(1);
		}
		ajaxReq = new Array();
		starttime = new Date().getTime();
		var url = $('#site_url').val() + 'find.php?q=' + query + '&cat=' + category + "&cache=" + cache + "&subcat=" + subcat;
	}
	// if (trust == 5) {
	// url += '&trust=1';
	// }
	ajaxReq[ajaxReq.length] = $.getJSON(url, function(data) {
		processData(data, site, cache, trust, changeSubCat, 0, searchThis);
	});
}

function processData(data, site, cache, trust, changeSubCat, preloaded, searchThis) {

	if (preloaded == undefined) {
		preloaded = false;
	}

	if (site && site.length > 0) {
		$('#progess_text').html('Processing Data From ' + site);
	} else {
		$('#progess_text').html('Processing Data');
	}

	if (data.query_id && data.query_id.length > 0) {
		var q = $('#q').val();
		q = q.replace(/[^a-zA-Z0-9]/g, "-");
		var share_url = $('#site_url').val() + 'search/lowest-price-of-' + q + '/' + data.query_id;
		if (history) {
			history.pushState('Price Genie', '', share_url);
		}
		$('#share_url').val(share_url);
	}

	$('#loading').hide();
	if (site && site.length > 0) {
		var psize = $('#progress_total').val();
		var pcur = $('#progress_done').val() * 1;
		pcur++;
		$('#progress_done').val(pcur);
		var per = Math.ceil((pcur / psize) * 100);
		$('#progress').find('.bar').first().attr('style', 'width: ' + per + '%');
		$('#results').find('#' + site).next('hr').remove();
		$('#results').find('#' + site).remove();

		var max_time = $('#summary').find('#max_time').val();
		if (data.result_number_time > max_time) {
			max_time = data.result_number_time;
			$('#summary').find('#time').html(data.result_time);
		}

		if (psize == pcur) {
			// $('#progress').hide();
			// $('#progress').children('.bar').first().attr('style',
			// 'width:0%');
			$('#progress_total').val(0);
			$('#progress_done').val(0);
			finished();

			var t = new Date().getTime() - starttime;
			t = Math.ceil(t / 1000);
			$('#summary').find('#time_taken').html(t + "sec");
			$('#summary').show();
		}
	}

	var lazyimage = $('#site_url').val() + 'img/preload_small.gif';
	var size = data.data.length;
	if (size > 0) {
		for ( var i = 0; i < data.data.length; i++) {
			var logo = data.data[i].logo;
			var name = data.data[i].name;
			var price = data.data[i].disc_price;
			if (price.length == 0) {
				price = '-NA-';
			}
			var image = data.data[i].image;
			var url = data.data[i].url;
			var website = data.data[i].website;
			var author = "";
			var shipping = '';
			var stock = 0;
			var offer = '';
			if (data.data[i].author) {
				author = data.data[i].author;
			}
			if (data.data[i].shipping) {
				shipping = data.data[i].shipping;
			}
			if (data.data[i].stock) {
				stock = data.data[i].stock;
			}
			if (data.data[i].offer) {
				offer = data.data[i].offer;
			}
			item_id_count++;

			if ($('#results').find('#' + website).length > 0) {
				var html = createSmallItem(url, item_id_count, image, lazyimage, name, price, author, shipping, offer, stock);
				$('#results').find('#' + website).find('#other_prod').append(html);

			} else {
				var html = createMain(website, logo, url, item_id_count, image, lazyimage, name, price, author, shipping, offer, stock, data.data[i].searchurl);

				var websites_actual = 0;
				var last_actu_website = false;
				$('#results').find('.website').each(function() {
					if ($(this).hasClass('website_loading')) {

					} else {
						last_actu_website = $(this);
						websites_actual++;
					}
				});
				if (websites_actual == 0) {
					$('#results').prepend(html);
				} else {
					var done = false;
					if (price != '-NA-') {
						var websites = $('#results').find('.website');
						websites.each(function() {
							if ($(this).hasClass('website_loading')) {

							} else {
								if (!done) {
									var web_price = $(this).children('.item_main').children('#item_price').val();
									if (web_price == '-NA-') {
										web_price = 99999999999;
									}
									web_price = web_price * 1;
									price = price * 1;
									if (price < web_price) {
										html += '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>';
										$(this).before(html);
										done = true;
										console.log(website + " before " + $(this).attr('id') + " with price " + price);
									}
								}
							}
						});
					}
					if (!done) {
						html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
						if (last_actu_website) {
							last_actu_website.after(html);
						} else {
							websites.last().after(html);
						}
						console.log(website + " at last with price " + price);
					}
				}
			}
		}
	}

	size = data.ajax_parse.length;
	if (site && site.length > 0) {
	} else {
		if (preloaded && preloaded == 1) {
			for ( var k = 0; k < size; k++) {
				data.empty_sites[data.empty_sites.length] = data.ajax_parse[k];
			}
			data.ajax_parse = new Array();
			var t = new Date().getTime() - starttime;
			t = Math.ceil(t / 1000);
			$('#summary').find('#time_taken').html(t + "sec");
			$('#summary').find('#time').html(data.result_time);
			$('#summary').show();
		} else {
			if (size > 0) {
				for ( var k = 0; k < size; k++) {
					var website = data.ajax_parse[k].site;
					var searchurl = data.ajax_parse[k].searchurl;
					var logo = data.ajax_parse[k].logo;
					var html = $('#loadingBodyTemplate').html();
					html = html.replace(/{website}/g, website);
					html = html.replace(/{website_search_url}/g, searchurl);
					html = html.replace(/{website_url}/g, logo);
					findPrice(website, cache, 1);
					var websites = $('#results').find('.website');
					if (websites.length > 0) {
						html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
						websites.last().after(html);
					} else {
						$('#results').prepend(html);
					}
				}
				$('#progress_total').val(size);
				$('#progress_done').val(0);
				$('#progress').show();
			} else {
				var t = new Date().getTime() - starttime;
				t = Math.ceil(t / 1000);
				$('#summary').find('#time_taken').html(t + "sec");
				$('#summary').find('#time').html(data.result_time);
				$('#summary').show();
			}
		}
	}
	size = data.empty_sites.length;
	if (size > 0) {
		for ( var j = 0; j < data.empty_sites.length; j++) {
			var website = data.empty_sites[j].site;
			var searchurl = data.empty_sites[j].searchurl;
			var logo = data.empty_sites[j].logo;
			var html = $('#emptyBodyTemplate').html();
			html = html.replace(/{website}/g, website);
			html = html.replace(/{website_search_url}/g, searchurl);
			html = html.replace(/{website_url}/g, logo);
			var websites_actual = 0;
			var last_actu_website = false;
			$('#results').find('.website').each(function() {
				if ($(this).hasClass('website_loading')) {

				} else {
					last_actu_website = $(this);
					websites_actual++;
				}
			});
			if (websites_actual > 0) {
				html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
				if (last_actu_website) {
					last_actu_website.after(html);
				} else {
					websites.last().after(html);
				}
			} else {
				$('#results').prepend(html);
			}
		}
	}

	size = data.error_sites.length;
	if (size > 0) {
		for ( var l = 0; l < size; l++) {
			var website = data.error_sites[l].site;
			var searchurl = data.error_sites[l].searchurl;
			var logo = data.error_sites[l].logo;
			var html = $('#errorBodyTemplate').html();
			html = html.replace(/{website}/g, website);
			html = html.replace(/{website_search_url}/g, searchurl);
			html = html.replace(/{website_url}/g, logo);
			html = html.replace(/{error_message}/g, data.error_sites[l].message);
			var websites = $('#results').find('.website');

			if (websites.length > 0) {
				html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
				websites.last().after(html);
			} else {
				$('#results').prepend(html);
			}
		}
	}

	size = data.untrusted.length;
	if (size > 0) {
		var psize = $('#progress_total').val() * 1;
		$('#progress_total').val(psize + size);
		for ( var m = 0; m < size; m++) {
			var len = untrusted.length
			untrusted[len] = new Array();
			untrusted[len]['site'] = data.untrusted[m].site;
			untrusted[len]['searchurl'] = data.untrusted[m].searchurl;
			untrusted[len]['logo'] = data.untrusted[m].logo;
		}
	}
	if (data.data.length > 0) {
		queueSortResult(0, site);
	}

	var showResult = false;
	// there are sites in ajax parse, so ajax has been called or each ajax is
	// still loading and has not finished.
	// only after calcResult() results should be shown

	// check price variation
	size = data.ajax_parse.length;
	if (trust == 1) {
		$('#results').show();
		// trust == 0 only when untrusted sites are parsed during
		// continueSearch() or preloaded results are shown
		if (site && site.length > 0) {
			// this mean its an individual ajax request
			// so we need to check if all ajax requests have completed
			var len = 0;
			$('#results').children('.website_loading').each(function() {
				if ($(this).hasClass('website_error') || $(this).hasClass('website_noresult')) {

				} else {
					len++;
				}
			})
			if (len == 0) {
				queueCalcResult();
			}
		} else {
			if (size == 0) {
				// this means, this is the first search request and all trusted
				// site
				// data is here. from php caching
				// since ajax_parse = 0 no more ajax data is comming so we can
				// calculate the price variation
				queueCalcResult();
				/*
				 * var min_price =
				 * $('#results').children('.website:first').children('.span4:first').children('#item_price').val();
				 * var max_price =
				 * $('#results').children('.website:last').children('.span4:first').children('#item_price').val();
				 * 
				 * var variation = Math.ceil(((max_price - min_price) /
				 * min_price) * 100);
				 */
			}
		}
	} else {
		showResult = true;

	}

	$('.apply_tooltip').tooltip();
	$('.popup').popover();
	/*
	 * if (showResult) { continueSearch(); } else { }
	 */
	setTimeout('loadSmallImages();', 2000);
}

var untrusted = new Array();

function continueSearch() {
	$('#progess_text').html('Continuing Search');
	$('#share').show(); // show url now, since all results will come now
	$('#results').show();
	$('#step').hide();
	var size = untrusted.length;
	if (size > 0) {
		for ( var m = 0; m < size; m++) {
			var website = untrusted[m]['site'];
			var searchurl = untrusted[m]['searchurl'];
			var logo = untrusted[m]['logo'];
			var html = $('#loadingBodyTemplate').html();
			html = html.replace(/{website}/g, website);
			html = html.replace(/{website_search_url}/g, searchurl);
			html = html.replace(/{website_url}/g, logo);
			findPrice(website, 1, 0);
			// here trust = 0 since all untrusted sites only come here
			var websites = $('#results').find('.website');
			if (websites.length > 0) {
				html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
				websites.last().after(html);
			} else {
				$('#results').prepend(html);
			}
		}
		untrusted = new Array();
	} else {
		finished();
	}
}
function searchThis($text) {
	$('#q').val($text);
	$('#showSuggestion').val(0);
	findPrice('', '', 1, false, 1);
}
var queueCalc = 0;
function queueCalcResult() {
	queueCalc = 1;
}

function calcResult() {
	queueCalc = 0;
	console.log('Calc Result Called');
	$('#progess_text').html('Filtering Data..');
	var pricesArr = new Array();
	$('#results').children('.website').each(function() {
		if ($(this).hasClass('website_error')) {
		} else if ($(this).hasClass('website_noresult')) {
			no_result++;
		} else {
			total_sites++;
			pricesArr[pricesArr.length] = $(this).children('.span4:first').children('#item_price').val();
		}
	});

	var i = 0;

	var init_price = 0;
	var diff_sites = 0;

	var no_result = 0;
	var total_sites = 0;

	/*
	 * $('#results').children('.website').each(function() { if
	 * ($(this).hasClass('website_error')) { } else if
	 * ($(this).hasClass('website_noresult')) { no_result++; } else {
	 * total_sites++; if (init_price == 0) { init_price =
	 * $(this).children('.span4:first').children('#item_price').val(); } else {
	 * new_price =
	 * $(this).children('.span4:first').children('#item_price').val(); variation =
	 * Math.ceil(((new_price - init_price) / init_price) * 100); if (variation >
	 * 10) { diff_sites++; } init_price = new_price; } } });
	 */
	var pricesArr = new Array();
	$('#results').children('.website').each(function() {
		if ($(this).hasClass('website_error')) {
		} else if ($(this).hasClass('website_noresult')) {
			no_result++;
		} else {
			total_sites++;
			pricesArr[pricesArr.length] = $(this).children('.item_main').children('#item_price').val();
		}
	});

	var avg = 0;
	var prev_price = 0;
	var entries = 0;

	var prev_entries = 0;
	var prev_avg = 0;
	for (i = 0; i < pricesArr.length; i++) {
		if (pricesArr[i] != '-NA-') {
			if (prev_price == 0) {
				avg = pricesArr[i];
				prev_price = pricesArr[i];
				entries = 1;
			} else {

				var variation = Math.abs(Math.ceil(((pricesArr[i] - prev_price) / pricesArr[i]) * 100));
				if (variation > 30) {
					console.log(variation + " avg calc variation detected");
					if (entries > prev_entries) {
						prev_entries = entries;
						prev_avg = avg;
					}
					avg = pricesArr[i] * 1;
					prev_price = pricesArr[i] * 1;
					entries = 1;
				} else {
					avg = (avg * 1 + pricesArr[i] * 1) / 2;
					prev_price = pricesArr[i];
					entries++;
				}
			}
		}
	}
	if (entries > prev_entries) {
		prev_entries = entries;
		prev_avg = avg;
	}
	avg = prev_avg;
	entries = prev_entries;
	console.log('Avg Price Found to be ' + avg + " with entries " + entries);

	if (entries < Math.ceil(total_sites / 2)) {
		entries = 0;
		avg = 0;
		for (i = 0; i < pricesArr.length; i++) {
			if (pricesArr[i] != '-NA-') {
				entries++;
				avg += pricesArr[i] * 1;
			}
		}
		avg = avg / entries;
		console.log('Normal Avg Price Found to be ' + avg);
	}
	$('#avg_best_price').val(avg);

	var fine = true;
	if ($('#showSuggestion').val() == 0) {
		console.log('show sugessions are disabled');
	} else {

		var search = getComparableString($('#q').val());

		// first try to detected suggesion based on name itself, escpeically
		// will work for book

		var data = new Array();
		$('#results').children('.website').each(function() {
			if ($(this).hasClass('website_error')) {
			} else if ($(this).hasClass('website_noresult')) {
			} else {
				var name = $(this).children('.item_main').children('#item_name').val();
				if (name.length > 0) {
					var row = new Array();
					row['score'] = 0;
					row['name'] = name;
					data[data.length] = row;
					i++;
				}
			}
		});

		// var replace = ('&amp;'=>'and','&'=>'and');
		for ( var i = 0; i < data.length; i++) {
			for ( var j = i; j < data.length; j++) {
				if (i == j) {
					continue;
				}
				var $name1 = data[i]['name'];
				var $name2 = data[j]['name'];
				$name1 = getComparableString($name1);
				$name2 = getComparableString($name2);
				// console.log($name1+"xxx"+$name2);
				if ($name1 == $name2 || $name1.indexOf($name2) != -1 || $name2.indexOf($name1) != -1) {
					// console.log('match');
					data[i]['score']++;
					data[j]['score']++;
				}
			}
		}
		// console.log(data);
		var highest_score = 0;
		var highest_score_name = '';
		for ( var i = 0; i < data.length; i++) {
			if (data[i]['score'] > highest_score || highest_score == 0) {
				highest_score = data[i]['score'];
				highest_score_name = data[i]['name'];
			}
		}

		if (highest_score > Math.ceil(total_sites * .6)) {
			fine = true;
			console.log('No Need to show suggesions because of same name ' + highest_score_name + " with entries " + highest_score + " and total sites " + total_sites);
		} else {

			// find suggesstion based on price

			var out = 0;

			/*
			 * var avg = 0; for (i = 0; i < pricesArr.length; i++) { avg +=
			 * (pricesArr[i]*1); } avg = avg / pricesArr.length;
			 * console.log('avg' + avg); for (i = 0; i < pricesArr.length; i++) {
			 * var variation = Math.abs(Math.ceil(((pricesArr[i] - avg) / avg) *
			 * 100));
			 * 
			 * console.log(pricesArr[i] + " variation is " + variation) }
			 */
			for (i = 0; i < pricesArr.length; i++) {
				out = 0;
				for (j = 0; j < pricesArr.length; j++) {
					if (i == j) {
						continue;
					}

					var a = 0;
					var b = 0;
					if (pricesArr[i] > pricesArr[j]) {
						a = pricesArr[i];
						b = pricesArr[j];
					} else {
						a = pricesArr[j];
						b = pricesArr[i];
					}
					var variation = Math.abs(Math.ceil(((a - b) / a) * 100));
					if ($('#category').val() == 9) { // books
						if (variation > 40) {
							out++;
						}
					} else {
						if (variation > 20) {
							out++;
						}
					}
					console.log(pricesArr[i] + ' compare ' + pricesArr[j] + " variation is more than 20% at " + variation)
				}
				if (out > Math.ceil(pricesArr.length / 2)) {
					console.log('site ' + i + ' is out with number' + out);
					diff_sites++;
				}
			}
			console.log('Total different sites is ' + diff_sites + ' and total sitse ' + total_sites);
			if (no_result >= Math.floor($('#results').children('.website').length / 2)) {
				fine = false; // product not found in more than 50% sites.
			} else {
				console.log(total_sites + ' tatal sites and correct sites ' + (total_sites - diff_sites) + " <= " + Math.ceil(total_sites * .5));
				if ((total_sites - diff_sites) < Math.ceil(total_sites * .5)) { // its
					// better
					// if
					// its
					// less
					// sensitive
					fine = false;
				} else {
					fine = true;
				}
			}
		}
	}
	if (!fine) {
		showStep();
	} else {
		continueSearch();
	}
}
function finished() {
	if (sortTimeout == false && $('#progress_done').val() == 0) {
		$('#progess_text').html('Finished');
		$('#summary').removeClass('summary_float');
		$('#summary').addClass('finished');
	}
	console.log('finished' + sortTimeout + "xx" + $('#progress_done').val());
}

var sortQueue = 0;
var sortTimeout = false;
function queueSortResult(timer, site) {
	if (timer) {
		var now = new Date().getTime();
		var diff = now - sortQueue;
		console.log('called from timer with diff: ' + diff);
		if (diff >= 1000) {
			if (!queueCalc) {
				sortTimeout = false;
			}
			sortResult();
			sortQueue = new Date().getTime();
			if (queueCalc) {
				sortTimeout = false;
				calcResult(); // run calc result only after sorting is done
			}
		} else {
			clearTimeout(sortTimeout);
			sortTimeout = setTimeout('queueSortResult(1)', 1000);
		}
	} else {
		if (!site || site == undefined) {
			site = '';
		}
		console.log('called from website ' + site);
		sortQueue = new Date().getTime();
		clearTimeout(sortTimeout);
		sortTimeout = setTimeout('queueSortResult(1)', 1000);
	}
}
function sortResult() {
	$('#progess_text').html('Sorting Results..');
	console.log('sorting called' + $('#isSorting').val());

	if ($('#isSorting').val() == 1) {
		console.log('sorting returned');
		queueSortResult();
		return;
	}

	$('#isSorting').val(1)
	isSorting = true;
	var data = new Array();
	$('#results').children('.website').each(function() {
		if ($(this).hasClass('website_error')) {
		} else if ($(this).hasClass('website_noresult')) {
		} else {
			var website = $(this).attr('id');
			var score = 4; // right now 4 items are there
			var i = 0;

			var avg = $('#avg_best_price').val() * 1;
			if (avg > 0) {
				var priceweb = $(this).children('.item_main').children('#item_price').val();
				if (priceweb == '-NA-') {
					priceweb = 99999999999;
				}
				priceweb = priceweb * 1;
				if (priceweb > 0) {
					var a = 0;
					var b = 0;
					if (avg > priceweb) {
						a = avg;
						b = priceweb;
					} else {
						b = avg;
						a = priceweb;
					}
					var variation = Math.abs(Math.ceil(((a - b) / b) * 100));
					if (variation > 40) {
						makeSmall(website);
						console.log('MakeSmall: Variation Found a ' + a + " b " + b + " = " + variation);
					} else {
						console.log('MakeSmall False: Variation Found a ' + a + " b " + b + " = " + variation);
					}
				}
			}

			$(this).find('.item_name').each(function() {
				var row = new Array();
				// row['score'] = score - i;
				if ($(this).val().length > 0) {
					row['score'] = 0;
					row['name'] = $(this).val();
					data[data.length] = row;
					i++;
				}
			});
		}
	});

	// var replace = ('&amp;'=>'and','&'=>'and');
	for ( var i = 0; i < data.length; i++) {
		for ( var j = i; j < data.length; j++) {
			if (i == j) {
				continue;
			}
			var $name1 = data[i]['name'];
			var $name2 = data[j]['name'];
			$name1 = getComparableString($name1);
			$name2 = getComparableString($name2);
			// console.log($name1+"xxx"+$name2);
			if ($name1 == $name2 || $name1.indexOf($name2) != -1 || $name2.indexOf($name1) != -1) {
				// console.log('match');
				data[i]['score']++;
				data[j]['score']++;
			}
		}
	}
	// console.log(data);
	var highest_score = 0;
	var highest_score_name = '';
	for ( var i = 0; i < data.length; i++) {
		if (data[i]['score'] > highest_score || highest_score == 0) {
			highest_score = data[i]['score'];
			highest_score_name = data[i]['name'];
		}
	}
	prev_highest_score = highest_score_name;
	prev_highest_score_value = highest_score;
	console.log(highest_score_name + " Is Highest Scorer");

	highest_score_name = getComparableString(highest_score_name);

	var v1 = 0;
	var v2 = 0;
	$('#results').children('.website').each(function() {
		if ($(this).hasClass('website_error')) {
		} else if ($(this).hasClass('website_noresult')) {
		} else {
			if ($(this).children('.item_main').children('#item_name').length > 0) {
				var main_id = $(this).children('.item_main').attr('id');
				var name1 = $(this).children('.item_main').children('#item_name').val();

				name1 = getComparableString(name1);

				var website = $(this).attr('id');

				var has_copy = false;
				var small_id = 0;
				var small_price = 0;

				var priceweb = $(this).children('.item_main').children('#item_price').val();
				if (priceweb == '-NA-') {
					priceweb = 99999999999;
				}
				priceweb = priceweb * 1;
				// console.log('main name' + name1);
				if (name1 != highest_score_name) {
					$(this).find('.item_small').each(function() {
						name1 = $(this).children('#item_name').val();
						name1 = getComparableString(name1);

						var price1 = $(this).children('#item_price').val();
						if (price1 == '-NA-') {
							price1 = 99999999999;
						}
						price1 = price1 * 1;

						// console.log('small name' + name1);
						if (name1 == highest_score_name || name1.indexOf(highest_score_name) != -1 || highest_score_name.indexOf(name1) != -1) {
							var avg = $('#avg_best_price').val() * 1;
							if (small_price != 0) {
								if (small_price > price1) {
									if (avg > 0) {
										v1 = Math.abs(Math.ceil(((small_price - avg) / avg) * 100));
										v2 = Math.abs(Math.ceil(((price1 - avg) / avg) * 100));

										console.log('make small inside varation ' + v1 + 'and ' + v2);

										if (v2 < 20 || v2 < v1) {
											small_price = price1;
											small_id = $(this).attr('id');
											has_copy = true;
										}
									} else {
										small_price = price1;
										small_id = $(this).attr('id');
										has_copy = true;
									}
								}
							} else {
								if (avg > 0) {
									v1 = Math.abs(Math.ceil(((price1 - avg) / avg) * 100));
									console.log('make small inside varation ' + v1);
									if (v1 < 20) {
										small_price = price1;
										small_id = $(this).attr('id');
										has_copy = true;
									}
								} else {
									small_price = price1;
									small_id = $(this).attr('id');
									has_copy = true;
								}
							}
						}
					});

					if (has_copy) {
						console.log('copied item ' + main_id + " => " + small_id + " in website " + website + ' from price M: ' + priceweb + " to S:" + small_price);
						copyItem(main_id, small_id);

						var back = true; // need to parse to top
						if (priceweb > small_price) {
							back = true;
						} else {
							back = false;
						}

						if (back) {
							var put_before_website = '';
							var website_ele = $('#' + website);
							while (website_ele.prevAll('.website:first').length > 0) {
								website_ele = website_ele.prevAll('.website:first');
								if (website_ele.hasClass('website_error')) {
								} else if (website_ele.hasClass('website_noresult')) {
								} else {
									if (website_ele.children('.item_main').children('#item_name').length > 0) {
										var prices_new_small = website_ele.children('.item_main').children('#item_price').val();
										if (prices_new_small == '-NA-') {
											prices_new_small = 99999999999;
										}
										prices_new_small = prices_new_small * 1;
										// console.log('small price ' +
										// small_price + " main price " +
										// prices_new_small + " checking sp <
										// mp");
										if (small_price < prices_new_small) {
											put_before_website = website_ele.attr('id');
										}
									}
								}
							}
							if (put_before_website.length > 0) {
								console.log('Put ' + website + ' before ' + put_before_website);
								$(this).next('hr').first().remove(); // remove
								// the hr
								var html = $(this).outerHTML();
								html += '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>';
								$('#' + website).remove();
								$('#' + put_before_website).before(html);
							} else {
								console.log('Didnt change position');
							}
						} else {
							var put_after_website = '';
							var website_ele = $('#' + website);
							while (website_ele.nextAll('.website:first').length > 0) {
								website_ele = website_ele.nextAll('.website:first');
								if (website_ele.hasClass('website_error')) {
								} else if (website_ele.hasClass('website_noresult')) {
								} else {
									if (website_ele.children('.item_main').children('#item_name').length > 0) {
										var prices_new_small = website_ele.children('.item_main').children('#item_price').val();
										if (prices_new_small == '-NA-') {
											prices_new_small = 99999999999;
										}
										prices_new_small = prices_new_small * 1;
										// console.log('small price ' +
										// small_price + " main price " +
										// prices_new_small + " checking sp >
										// mp");
										if (small_price > prices_new_small) {
											put_after_website = website_ele.attr('id');
										}
									}
								}
							}
							if (put_after_website.length > 0) {
								console.log('Put ' + website + ' after ' + put_after_website);
								$(this).next('hr').first().remove(); // remove
								// hr
								var html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + $(this).outerHTML();
								$('#' + website).remove();
								$('#' + put_after_website).after(html);
							} else {
								console.log('Didnt change position');
							}
						}
					}
				}
			}

		}
	});

	$('.apply_tooltip').tooltip();
	$('.popup').popover();
	$('#isSorting').val(0)
	console.log('sorting finish');
	finished();
}
var prev_highest_score = '';
var prev_highest_score_value = 0;
function showStep() {
	$('#progess_text').html('Showing Suggestions');
	$('#results').hide();
	$('#step_items').html('');
	var i = 0;
	$('#results').children('.website').each(function() {
		if ($(this).hasClass('website_error')) {
		} else if ($(this).hasClass('website_noresult')) {
		} else {
			var website = $(this).attr('id');
			var logo = $(this).children('.span2:first').children('a').children('img').attr('src');
			var website_search_url = $(this).children('.span2:first').children('a').attr('href');

			var url = $(this).children('.span4:first').children('#item_url').val();
			var image = $(this).children('.span4:first').children('#item_image').val();
			var name = $(this).children('.span4:first').children('#item_name').val();
			var price = $(this).children('.span4:first').children('#item_price').val() * 1;
			var author = $(this).children('.span4:first').children('#item_author').val();
			var offer = '';
			var shipping = '';

			var html = $('#stepItem').html();
			html = html.replace(/{website}/g, website);
			html = html.replace(/{website_url}/g, logo);
			html = html.replace(/{item_url}/g, url);
			html = html.replace(/{item_image}/g, image);
			html = html.replace(/{item_name}/g, name);
			html = html.replace(/{item_price}/g, price);
			html = html.replace(/{website_search_url}/g, website_search_url);
			html = html.replace(/{item_offer_org}/g, offer);
			html = html.replace(/{item_shipping_org}/g, shipping);
			html = html.replace(/{step_id}/g, 'step_' + i);

			html = html.replace(/{item_author}/g, author);

			if (author.length == 0) {
				html = html.replace(/{name_height}/g, '40px');
				html = html.replace(/{author_display}/g, 'display:none');
			} else {
				html = html.replace(/{name_height}/g, '22px');
				html = html.replace(/{author_display}/g, '');
			}
			$('#step_items').append(html);
			i++;
		}
	});
	$('#step').show();
}

function loadSmallImages() {
	var i = 0;
	$('.lazy_load_img').each(function() {
		if (!$(this).hasClass('no-resize')) {
			$(this).attr('width', '50px');
			$(this).attr('height', '50px');
			$(this).attr('style', $(this).attr('style') + ";width: 50px;height: 50px;")
		}
		$(this).attr('src', $(this).siblings('input#lazy').val());
		$(this).removeClass('lazy_load_img');
		i++;
		if (i > 10) {
			setTimeout('loadSmallImages();', 2000);
			return false;
		}
	});
}
function copyItem(item1_id, item2_id) {
	if (item1_id == item2_id) {
		return;
	}
	var item1 = $('#' + item1_id);
	var item2 = $('#' + item2_id);

	var item_url1 = item1.children('#item_url').val();
	var item_name1 = item1.children('#item_name').val();
	var item_image1 = item1.children('#item_image').val();
	var item_price1 = item1.children('#item_price').val();
	var item_author1 = item1.children('#item_author').val();
	var item_stock1 = item1.children('#item_stock').val();
	var item_offer1 = item1.children('#item_offer').val();
	var item_shipping1 = item1.children('#item_shipping').val();

	var item_url2 = item2.children('#item_url').val();
	var item_name2 = item2.children('#item_name').val();
	var item_image2 = item2.children('#item_image').val();
	var item_price2 = item2.children('#item_price').val();
	var item_author2 = item2.children('#item_author').val();
	var item_stock2 = item2.children('#item_stock').val();
	var item_offer2 = item2.children('#item_offer').val();
	var item_shipping2 = item2.children('#item_shipping').val();

	if (item1.hasClass('item_main')) {
		if (item2.hasClass('item_small')) {
			var new_item1_html = createMainItem(item_url2, item2_id, item_image2, '', item_name2, item_price2, item_author2, item_shipping2, item_offer2, item_stock2);
			var new_item2_html = createSmallItem(item_url1, item1_id, item_image1, '', item_name1, item_price1, item_author1, item_shipping1, item_offer1, item_stock1);
		} else {
			var new_item1_html = createMainItem(item_url1, item1_id, item_image1, '', item_name1, item_price1, item_author1, item_shipping1, item_offer1, item_stock1);
			var new_item2_html = createMainItem(item_url2, item2_id, item_image2, '', item_name2, item_price2, item_author2, item_shipping2, item_offer2, item_stock2);
		}
	} else {
		if (item2.hasClass('item_small')) {
			var new_item1_html = createSmallItem(item_url1, item1_id, item_image1, '', item_name1, item_price1, item_author1, item_shipping1, item_offer1, item_stock1);
			var new_item2_html = createSmallItem(item_url2, item2_id, item_image2, '', item_name2, item_price2, item_author2, item_shipping2, item_offer2, item_stock2);
		} else {
			var new_item1_html = createSmallItem(item_url2, item2_id, item_image2, '', item_name2, item_price2, item_author2, item_shipping2, item_offer2, item_stock2);
			var new_item2_html = createMainItem(item_url1, item1_id, item_image1, '', item_name1, item_price1, item_author1, item_shipping1, item_offer1, item_stock1);
		}
	}
	item1.replaceWith(new_item1_html);
	item2.replaceWith(new_item2_html);
}
function createSmallItem(url, item_id_count, image, lazyimage, name, price, author, shipping, offer, stock) {
	var html = $('#smallItemTemplate').html();
	html = html.replace(/{item_url}/g, url);
	html = html.replace(/{item_id}/g, item_id_count);
	if (lazyimage.length == 0) {
		lazyimage = image;
	}

	html = html.replace(/{item_img_load_id}/g, image);
	html = html.replace(/{item_image}/g, lazyimage);
	html = html.replace(/{item_name}/g, name);
	html = html.replace(/{item_price}/g, price);
	html = html.replace(/{item_author}/g, author);
	html = html.replace(/{item_shipping}/g, shipping);
	html = html.replace(/{item_offer}/g, offer);
	html = html.replace(/{item_stock}/g, stock);

	var item_details = "Price: <span class='WebRupee'></span>" + price + "<br/>";
	if (author.length > 0) {
		item_details += 'Author: by ' + author + '<br/>';
	}
	if (shipping.length > 0) {
		item_details += 'Shipping:' + offer + '<br/>';
	}
	if (offer.length > 0) {
		item_details += 'Offer:' + offer + '<br/>';
	}
	var stock_color = 'btn-success';
	if (stock == 0 || stock.length == 0) {
		item_details += 'Stock: No Info' + '<br/>';
		stock_color = '';
	} else if (stock == 1) {
		item_details += 'Stock: In Stock' + '<br/>';
		stock_color = 'btn-success';
	} else {
		item_details += 'Stock: Out of Stock' + '<br/>';
		stock_color = 'btn-danger';
	}

	var item_name_html = name;
	if (!name || name == undefined) {
		name = '';
	}
	if (name.length > 37) {
		var item_name_html = item_name_html.substring(0, 37 - 3) + '...';
		item_name_html = '<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="' + name + '">' + item_name_html + '</span>';
	}
	html = html.replace(/{item_name_html}/g, item_name_html);

	html = html.replace(/{stock_color}/g, stock_color);
	html = html.replace(/{item_details}/g, item_details);
	return html;
}
function createMain(website, logo, url, item_id_count, image, lazyimage, name, price, author, shipping, offer, stock, searchurl) {
	var html2 = $('#resultBodyTemplate').html();
	html2 = html2.replace(/{website}/g, website);
	html2 = html2.replace(/{website_url}/g, logo);
	html2 = html2.replace(/{website_search_url}/g, searchurl);

	var html = createMainItem(url, item_id_count, image, lazyimage, name, price, author, shipping, offer, stock);
	html2 = html2.replace(/{main_item_html}/g, html);

	return html2;
}
function createMainItem(url, item_id_count, image, lazyimage, name, price, author, shipping, offer, stock) {
	var html = $('#mainItemTemplate').html();
	html = html.replace(/{item_url}/g, url);
	html = html.replace(/{item_image}/g, image);
	html = html.replace(/{item_name}/g, name);
	html = html.replace(/{item_price}/g, price);
	html = html.replace(/{item_offer_org}/g, offer);
	html = html.replace(/{item_shipping_org}/g, shipping);
	html = html.replace(/{item_id}/g, item_id_count);
	html = html.replace(/{item_stock}/g, stock);

	var ship_len = 120;
	if (offer.length != 0) {
		ship_len = 60;
	}
	if (shipping.length > ship_len) {
		var shipping2 = shipping.substring(0, ship_len - 3) + '...';
		shipping = '<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="' + shipping + '">' + shipping2 + '</span>';
	}
	var of_len = 120;
	if (offer.length != 0) {
		of_len = 60;
	}
	if (offer.length > of_len) {
		var offer2 = offer.substring(0, of_len - 3) + '...';
		offer = '<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="' + offer + '">' + offer2 + '</span>';
	}
	html = html.replace(/{item_shipping}/g, shipping);
	html = html.replace(/{item_offer}/g, offer);
	if (author.length > 40) {
		var author2 = author.substring(0, 37) + '...';
		author = '<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="' + author + '">' + author2 + '</span>';
	}
	html = html.replace(/{item_author}/g, author);

	if (offer.length == 0) {
		html = html.replace(/{offer_display}/g, 'display:none');
	} else {
		html = html.replace(/{offer_display}/g, '');
	}
	if (author.length == 0) {
		html = html.replace(/{author_display}/g, 'display:none');
	} else {
		html = html.replace(/{author_display}/g, '');
	}
	if (shipping.length == 0) {
		html = html.replace(/{shipping_display}/g, 'display:none');
	} else {
		html = html.replace(/{shipping_display}/g, '');
	}
	if (stock == 0 || stock.length == 0) {
		html = html.replace(/{in_stock_hide}/g, 'display:none');
		html = html.replace(/{out_stock_hide}/g, 'display:none');
		html = html.replace(/{no_stock_hide}/g, '');
	} else if (stock == 1) {
		html = html.replace(/{in_stock_hide}/g, '');
		html = html.replace(/{out_stock_hide}/g, 'display:none');
		html = html.replace(/{no_stock_hide}/g, 'display:none');
	} else {
		html = html.replace(/{in_stock_hide}/g, 'display:none');
		html = html.replace(/{out_stock_hide}/g, '');
		html = html.replace(/{no_stock_hide}/g, 'display:none');
	}
	return html;
}

function makeSmall(website) {
	if ($('#' + website).hasClass('website_small')) {
		return;
	}
	$('#' + website).children('.span4:last').hide();
	$('#' + website).children('.span2:last').hide();
	$('#' + website).children('.item_main').children('hr').hide();
	$('#' + website).children('.item_main').children('.other_info').hide();
	$('#' + website).children('.item_main').removeClass('span4');
	$('#' + website).children('.item_main').addClass('span8');
	$('#' + website).children('.span2').css('line-height', '22px');
	var small_price = $('#' + website).children('.item_main').children('#item_price').val();
	if (small_price == '-NA-') {
		small_price = 99999999999;
	}
	small_price = small_price * 1;
	var img = $('#' + website).children('.item_main').children('.media').find('img');
	img.addClass('no-resize');
	img.height('50px');
	img.width('50px');
	$('#' + website).children('.item_main').children('.media').children('.media-body').width('380px');
	$('#' + website).children('.item_main').children('.media').children('.media-body').children('.pull-left:first').css('max-height', '22px');
	var index = 0;
	$('#' + website).children('.item_main').children('.media').children('.media-body').children('.clearfix').each(function() {
		if (index > 0) {
			$(this).removeClass('clearfix');
			$(this).addClass('clearfix-tog');
		}
		index++;
	});
	$('#' + website).height('60px');
	$('#' + website).children('.span2:first').find('img').first().height('40px');
	// $('#' + website).css('margin-top', '0px');
	var template = $('#website_hide_template').html();
	$('#' + website).children('.span8').after(template);
	$('#' + website).addClass('website_small');

	var html = $('#' + website).outerHTML();
	$('#' + website).next('hr').first().remove(); // remove
	$('#' + website).remove();

	if ($('#bad_result_items').children('.website').length > 0) {
		var last_website = '';
		$('#bad_result_items').children('.website').each(function() {
			var bad_price = $(this).children('.item_main').children('#item_price').val();
			if (bad_price == '-NA-') {
				bad_price = 99999999999;
			}
			bad_price = bad_price * 1;
			if (small_price > bad_price) {
				last_website = $(this).attr('id');
			} else {
				return 0;
			}
		});
		if (last_website.length == 0) {
			html += '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>';
			$('#bad_result_items').prepend(html);
		} else {
			html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
			$('#' + last_website).after(html);
		}
	} else {
		$('#bad_result_items').append(html);
	}
	$('#bad-results').show();
}
function makeBig(website) {
	$('#' + website).children('.span4:last').show();
	$('#' + website).children('.span2:last').show();
	$('#' + website).children('.item_main').children('hr').show();
	$('#' + website).children('.item_main').children('.other_info').show();
	$('#' + website).children('.item_main').removeClass('span8');
	$('#' + website).children('.item_main').addClass('span4');
	$('#' + website).children('.span2:first').css('line-height', '150px');
	var img = $('#' + website).children('.item_main').children('.media').find('img');
	img.height('100px');
	img.width('100px');
	var big_price = $('#' + website).children('.item_main').children('#item_price').val();
	if (big_price == '-NA-') {
		big_price = 99999999999;
	}
	big_price = big_price * 1;
	$('#' + website).children('.item_main').children('.media').children('.media-body').width('175px');
	$('#' + website).children('.item_main').children('.media').children('.media-body').children('.pull-left:first').css('max-height', '40px');
	$('#' + website).children('.item_main').children('.media').children('.media-body').children('.clearfix-tog').each(function() {
		$(this).removeClass('clearfix-tog');
		$(this).addClass('clearfix');
	});
	$('#' + website).height('165px');
	// $('#' + website).css('margin-top', '10px');
	$('#' + website).children('.website_hide_box').remove();

	var html = $('#' + website).outerHTML();
	$('#' + website).prev('hr').first().remove(); // remove
	$('#' + website).remove();

	var last_website = '';
	var websites = $('#results').find('.website');
	websites.each(function() {
		if ($(this).hasClass('website_loading')) {

		} else {
			var web_price = $(this).children('.item_main').children('#item_price').val();
			if (web_price == '-NA-') {
				web_price = 99999999999;
			}
			web_price = web_price * 1;
			if (big_price > web_price) {
				last_website = $(this).attr('id');
			} else {
				return 0;
			}
		}

	});
	if (last_website.length > 0) {
		html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
		$('#' + last_website).after(html);
	} else {
		$('#results').prepend(html + '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>');
	}
	$.scrollTo('#' + website);

}

function getComparableString(str) {
	str = str.replace('&amp;', 'and');
	str = str.replace('&', 'and');
	str = str.replace('III', '3');
	str = str.replace('II', '2');
	str = str.replace('IV', '4');
	str = str.toLowerCase();
	return str;
}
jQuery.fn.outerHTML = function(s) {
	return s ? this.before(s).remove() : jQuery("<p>").append(this.eq(0).clone()).html();
};