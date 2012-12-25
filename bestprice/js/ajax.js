$(document).ready(function() {
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
});
function hideError() {
	$('#error_msg').hide();
}
var timeout = false;
var starttime = 0;
function findPrice(site,cache) {
	
	if(cache === undefined){
		cache = 1;
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
	if (site && site.length > 0) {
		var url = 'find.php?q=' + query + '&cat=' + category + "&site=" + site + "&cache="+cache;
	} else {
		$('#loading').show();
		$('#results').hide();
		$('#results').html('');
		$('.progress').hide();
		$('.progress').children('.bar').first().attr('style', 'width:0%');
		$('#progress_total').val(0);
		$('#progress_done').val(0);
		$('#summary').find('#max_time').val(0)
		$('#summary').find('#time_taken').html('');
		$('#summary').find('#time').html('');
		$('#summary').hide();
		starttime = new Date().getTime();
		var url = 'find.php?q=' + query + '&cat=' + category+ "&cache="+cache;
	}
	$.getJSON(url, function(data) {
		$('#loading').hide();
		if (site && site.length > 0) {
			var psize = $('#progress_total').val();
			var pcur = $('#progress_done').val() * 1;
			pcur++;
			$('#progress_done').val(pcur);
			var per = Math.ceil((pcur / psize) * 100);
			$('.progress').children('.bar').first().attr('style', 'width: ' + per + '%');
			$('#results').find('#' + site).next('hr').remove();
			$('#results').find('#' + site).remove();
			
			var max_time = $('#summary').find('#max_time').val();
			if(data.result_number_time > max_time){
				max_time = data.result_number_time;
				$('#summary').find('#time').html(data.result_time);
			}
			
			if (psize == pcur) {
				$('.progress').hide();
				$('.progress').children('.bar').first().attr('style', 'width:0%');
				$('#progress_total').val(0);
				$('#progress_done').val(0);
				
				var t = new Date().getTime() - starttime;
				t = Math.ceil(t/1000);
				$('#summary').find('#time_taken').html(t + "sec");
				$('#summary').show();
			}
		}

		var lazyimage = 'img/preload_small.gif';
		var size = data.data.length;
		if (size > 0) {
			for ( var i = 0; i < data.data.length; i++) {
				var logo = data.data[i].logo;
				var name = data.data[i].name;
				var price = data.data[i].disc_price;
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
				

				if ($('#results').find('#' + website).length > 0) {
					var html = $('#smallItemTemplate').html();
					html = html.replace(/{website}/g, website);
					html = html.replace(/{website_url}/g, logo);
					html = html.replace(/{item_url}/g, url);
					
					html = html.replace(/{item_img_load_id}/g, image);
					html = html.replace(/{item_image}/g, lazyimage);
					html = html.replace(/{item_name}/g, name);
					html = html.replace(/{item_price}/g, price);
					html = html.replace(/{item_author}/g, author);
					html = html.replace(/{item_shipping}/g, shipping);
					html = html.replace(/{item_offer}/g, offer);

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
					html = html.replace(/{stock_color}/g, stock_color);
					html = html.replace(/{item_details}/g, item_details);
					$('#results').find('#' + website).find('#other_prod').prepend(html);
				} else {
					var html = $('#resultBodyTemplate').html();
					html = html.replace(/{website}/g, website);
					html = html.replace(/{website_url}/g, logo);
					html = html.replace(/{item_url}/g, url);
					html = html.replace(/{item_image}/g, image);
					html = html.replace(/{item_name}/g, name);
					html = html.replace(/{item_price}/g, price);
					html = html.replace(/{website_search_url}/g, data.data[i].searchurl);
					html = html.replace(/{item_offer_org}/g, offer);
					html = html.replace(/{item_shipping_org}/g, shipping);
					
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
						var author2 = offer.substring(0, 37) + '...';
						author = '<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="' + offer + '">' + author2 + '</span>';
					}
					html = html.replace(/{item_author}/g, author);

					if (offer.length == 0) {
						html = html.replace(/{offer_display}/g, 'display:none');
					}else{
						html = html.replace(/{offer_display}/g, '');
					}
					if (author.length == 0) {
						html = html.replace(/{author_display}/g, 'display:none');
					}else{
						html = html.replace(/{author_display}/g, '');
					}
					if (shipping.length == 0) {
						html = html.replace(/{shipping_display}/g, 'display:none');
					}else{
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
					
					var websites_actual = 0;
					var last_actu_website = false;
					$('#results').find('.website').each(function(){
						if ($(this).hasClass('website_loading')) {

						}else{
							last_actu_website = $(this);
							websites_actual++;
						}
					});
					if (websites_actual == 0) {
						$('#results').prepend(html);
					} else {
						var done = false;
						var websites = $('#results').find('.website');
						websites.each(function() {
							if ($(this).hasClass('website_loading')) {

							} else {
								if (!done) {
									var web_price = $(this).find('.main_price').html() * 1;
									if (price.length > 0) {
										if (price < web_price) {
											html += '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>';
											$(this).before(html);
											done = true;
										}
									}
								}
							}
						});
						if (!done) {
							html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
							if(last_actu_website){
								last_actu_website.after(html);
							}else{
								websites.last().after(html);
							}
						}
					}
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
				$('#results').find('.website').each(function(){
					if ($(this).hasClass('website_loading')) {

					}else{
						last_actu_website = $(this);
						websites_actual++;
					}
				});
				if (websites_actual > 0) {
					html = '<hr style="padding: 0px;margin: 0px;margin-top: 10px;"/>' + html;
					if(last_actu_website){
						last_actu_website.after(html);
					}else{
						websites.last().after(html);
					}
				} else {
					$('#results').prepend(html);
				}
			}
		}
		size = data.ajax_parse.length;
		if (site && site.length > 0) {
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
					findPrice(website,cache);
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
				$('.progress').show();
			}else{
				var t = new Date().getTime() - starttime;
				t = Math.ceil(t/1000);
				$('#summary').find('#time_taken').html(t + "sec");
				$('#summary').find('#time').html(data.result_time);
				$('#summary').show();
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
		
		$('.apply_tooltip').tooltip();
		$('.popup').popover();
		$('#results').show();
		setTimeout('loadSmallImages();',2000);
	});
}

function loadSmallImages(){
	var i = 0;
	$('.lazy_load_img').each(function(){
		$(this).attr('src',$(this).siblings('input#lazy').val());
		$(this).attr('width','50px');
		$(this).attr('height','50px');
		$(this).attr('style',$(this).attr('style')+"width: 50px;height: 50px;")
		$(this).removeClass('lazy_load_img');
		i++;
		if(i > 10){
			setTimeout('loadSmallImages();',2000);
			return false;
		}
	});
}
function copyItem(website,id1,id2){
	
}