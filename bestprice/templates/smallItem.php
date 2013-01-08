<div class='item item_small' id='{item_id}' style="margin-left: 5px;">
  			<input type='hidden' id='item_url' value='{item_url}' />
			<input type='hidden' id='item_name' class='item_name' value='{item_name}' />
			<input type='hidden' id='item_image' value='{item_img_load_id}' />
			<input type='hidden' id='item_price' value='{item_price}' />
			<input type='hidden' id='item_author' value='{item_author}' />
			<input type='hidden' id='item_stock' value='{item_stock}' />
			<input type='hidden' id='item_offer' value='{item_offer}' />
			<input type='hidden' id='item_shipping' value='{item_shipping}' />
	<div class='table-bordered' style="border-left: 1px solid #DDD;padding: 0px;text-align: center;margin-bottom: 3px;font-size: 12px;height: 50px;overflow: hidden;">
		<div class='pull-left'>
			<a href="{item_url}" target="_blank">
				<input type='hidden' value='{item_img_load_id}' id='lazy' />
				<img class="lazy_load_img img-rounded" src="{item_image}" alt='{item_name}' title='{item_name}' width="50px" height="50px" style="width: 50px;height: 50px;" />
			</a>
		</div>
		<div class='pull-left' style="padding-left: 5px;width: 80%;text-align: left">
			<div style="height: 22px;overflow: hidden">{item_name_html}</div>
			<div class="clearfix"></div>
			<div>
				<div class='pull-left'>
					Price <span class="WebRupee">Rs.</span><span class='main_price'>{item_price}</span>
				</div>
				<div class='pull-right'>
					<a class='detail-popup popup btn btn-mini {stock_color}' style="line-height: 14px" rel="popover" data-placement="right" data-html='true' data-trigger='click' data-content="{item_details}" data-original-title="{item_name}">Details</a>
				</div>
			</div>
		</div>				
		<div class="clearfix"></div>
	</div>
</div>