	<div  class='table-bordered pull-left' style="border-left: 1px solid #DDD;padding: 10px;margin-right: 20px;width: 150px;margin-top: 5px;height: 235px">
     	<div>
     		<a href="{item_url}" target="_blank">
				<img class="img-rounded" src="{item_image}" alt='{item_name}' title='{item_name}' style="max-width: 100px;max-height: 100px;" />
			</a>
     	</div>
     	<div style="height: {name_height};overflow: hidden">
	     	<a href="{item_url}" target="_blank" class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="{item_name}">
	     		{item_name}
	     	</a>
     	</div>
     	<div>
			Price <span class="WebRupee">Rs.</span><span class='main_price'>{item_price}</span>
		</div>
		<div class='author' style="{author_display};height: 22px;overflow:hidden;">
			by <small>{item_author}</small>
		</div>
		<button type="button" onclick='searchThis("{item_name}");return false;' class='btn btn-small btn-info'>Search This!</button>
		<div style="padding-top: 20px;height: 30px">
			<a href='{website_search_url}'>
				<img style="max-width: 100px;max-height: 30px" class="img-rounded" src='{website_url}' alt='{website}' title='{website}'/>
			</a>
		</div>
     </div>