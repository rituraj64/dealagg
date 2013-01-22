<div class="row-fluid clearfix website" id="{website}" style="vertical-align: middle;height: 100px;margin-top:10px;position: relative;">
	<div class="span2" style="text-align: center">
		<a style="line-height: 75px" href='{website_search_url}' target='_blank'><img src="{website_url}" alt="{website}" title="{website}"/></a>
		<button class='btn btn-mini remove_website_btn'>Remove This!</button>
		<small id='time_taken'></small>
	</div>
	{main_item_html}
	<div class="span4 other_info_parent table-bordered" style="margin-left:10px;border-left: 1px solid #DDD;height: 100%;overflow-y:auto">
		<div class='other_info' style="font-size:11px;text-align: left;float: left;margin-left:5px;line-height: 15px">
			<div class="pull-left product_loading" style="display: none;font-size:12ppx">
				Getting Info
				<img src="<?php echo Parser::SITE_URL;?>img/preload_small.gif">
			</div>
			<div class='clearfix'></div>
			<div class='offer pull-left' style="{offer_display}">
				Offer: {item_offer}
			</div>
			<div class='clearfix'></div>
			<div class='shipping pull-left' style="{shipping_display}">
						Shipping: {item_shipping}
			</div>
			<div class='clearfix'></div>
			<div class='shipping_cost pull-left' style="display: none">
					
			</div>
			<div class='clearfix'></div>
			<div class='shipping_time pull-left' style="display: none">
					
			</div>
			<div class='clearfix'></div>
			<div class='warrenty pull-left' style="display: none">
					
			</div>
			<div class='clearfix'></div>
			<div class='attr pull-left' style="display: none">
				
			</div>
		</div>
		<div class='clearfix'></div>
		<div style="font-size:11px;margin-left:5px;line-height: 15px">
			<b>Coupons:</b> {coupons}
		</div>		
	</div>
 	<div class='span3 table-bordered last-div' style="border-left: 1px solid #DDD;margin-left:10px;width:260px;height: 100%">
 		<div style="text-align: left;float: left"  id="other_prod">
			{other_prod}
		</div>
	</div>
 </div>