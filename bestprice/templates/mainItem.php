<div class="popup span4 table-bordered item item_main" id='{item_id}' style="margin-left:10px;border-left: 1px solid #DDD;text-align: center;height: 100%">
	<input type='hidden' id='item_url' value='{item_url}' />
	<input type='hidden' id='item_name' class='item_name' value='{item_name}' />
	<input type='hidden' id='item_image' value='{item_image}' />
	<input type='hidden' id='item_price' value='{item_price}' />
	<input type='hidden' id='item_author' value='{item_author}' />
	<input type='hidden' id='item_stock' value='{item_stock}' />
	<input type='hidden' id='item_offer' value='{item_offer_org}' />
	<input type='hidden' id='item_shipping' value='{item_shipping_org}' />
	<input type='hidden' id='has_product' value='{has_product}' />
 	<div class="media" style="margin-top: 0px">
		<a class='pull-left' href="{item_url}" target="_blank">
			<img style="width:50px;height:50px;margin:5px" class="img-rounded media-object" src="{item_image}" alt='{item_name}' title='{item_name}'/>
		</a>
		<div class="media-body pull-left" style="width: 217px;text-align:left">
			<div class='pull-left' style="max-height:60px;overflow:hidden">
				<a href="{item_url}" target="_blank" class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="{item_name}">{item_name}</a>
			</div>
			<div class='clearfix'></div>
			<div class='pull-left'>
				Price <span class="WebRupee">Rs.</span><span class='main_price'>{item_price}</span>
			</div>
			<div class='clearfix'></div>
			<div class='pull-left' class='stock'>
				<span style="{in_stock_hide}" class="label label-success in_stock">In Stock</span>
				<span style="{out_stock_hide}" class="label label-important out_of_stock">Out Of Stock</span>
				<span style="{no_stock_hide}" class="label no_info">No Info</span>
			</div>
			<div class='pull-left author' style="{author_display}">
				by <small>{item_author}</small>
			</div>
		</div>
	</div>
	<div class='clearfix'></div>
	<!--
	<hr style="padding: 0px;margin: 0px;margin-top: 5px;"/>
	-->
</div>