<?php
	session_start(); 
	if(isset($_REQUEST['query_id'])){
		$query_id = $_REQUEST['query_id'];
		require_once 'model/Search.php';
		$searchObj = new Search();
		$searchObj->query_id = $query_id;
		$row = $searchObj->read();
		if(isset($row[0])){
			$searchObj->smartAssign($row[0]);
			
			$_REQUEST['q'] = $searchObj->getQuery();
			$_REQUEST['cat'] = $searchObj->getCategory();
			$_REQUEST['subcat'] = $searchObj->getSubcat();;
			$_REQUEST['cache'] = 1;
			$_REQUEST['silent'] = 1;
			
			require_once 'find.php';
			$result = $return;
		}else{
			$error = 'Search Query Doesnt Exist';
		}
	}
?>

<?php require_once 'header.php';?>

      <!-- Jumbotron -->
      <div class="jumbotron">
      	<?php if(isset($result)){ ?>
      		<script type="text/javascript">
        	$(document).ready(function(){
        		processData(eval(<?php echo json_encode($result)?>),'','',0,'',true);
        	});
        	</script>
        <?php }else{ ?>
        	<h1>Ask Me!</h1>
        <?php } ?>
        <form class="form-search" onsubmit="findPrice();return false;" style="font-size: 27px">
        		Find cheapest price for 
		  		<input type="text" name='q' id='q' class="input-xlarge" style="font-size: 27px;height: 39px;" value='<?php if(isset($result)){echo $searchObj->getQuery();} ?>'>
		  		in 
		  	 	<select id='category' style="font-size: 18px;height: 39px;" onchange="$('#subcategory').val('-1');">
		  	 		<option value="-1">Select Category..</option>
		  	 		<?php
		  	 			require_once 'Category.php';
		  	 			$catObj = new Category();
		  	 			$cats = $catObj->getStoreCategory();
		  	 			$i = 0;
		  	 			if(isset($result)){
		  	 				$_SESSION['prev_cat'] = $searchObj->category;
		  	 			}
		  	 			foreach($cats as $key => $cat){
		  	 				if(is_array($cat)){$cat = key($cat);}
		  	 		?>
		  	 			<option value="<?php echo $key;?>" <?php if(isset($_SESSION['prev_cat']) && $_SESSION['prev_cat'] == $key){echo 'selected="selected";';} ?>><?php echo $cat;?></option>
		  	 		<?php $i++;} ?>
		  		</select>
		  		<input type="hidden" id='subcategory' name='subcategory' value='<?php if(isset($result)){echo $searchObj->getSubcat();}else{echo -1;} ?>' />
		  		<button type="submit" class="btn btn-large btn-danger">NOW!</button>
		</form>
		
		 <div id='error_msg' class="alert" <?php if(!isset($error)){echo 'style="display: none';}?>">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Warning!</strong> <span><?php if(isset($error)){echo $error;}?></span>
		</div>
		<div id='loading' style="display: none;">
			<img src='<?php echo Parser::SITE_URL;?>img/loading.gif' alt='loading..' title='loading..'/>
		</div>
		<input id='progress_total' type="hidden"/>
		<input id='progress_done' type="hidden"/>
		<div class="progress progress-info progress-striped" style="display: none">
		  <div class="bar" style="width: 0%;"></div>
		</div>
		<div class="alert alert-success" id='share' style="text-align: left;color:black;display: none">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Share Results: <input type='text' id='share_url' value='' style="width: 100%"/>
		</div>
		<div class="alert alert-info" id='summary' style="text-align: left;color:black;display: none">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				<div class='pull-left'>
					Total Time Taken: <h4 id='time_taken'></h4>
				</div>
				<div class='pull-right'>
					Results As On:
					<input type='hidden' id='max_time' value="0" /> 
					<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="Get Latest Results">
						<span onclick='findPrice("",0,1,false);' style="cursor: pointer;" class='icon-refresh'></span>
					</span> 
					<h4 id='time'></h4>
				</div>
				<div class='clearfix'></div>
		</div>
      </div>
      <div id='step' class='table-bordered' style="border-left: 1px solid #DDD;padding: 10px;margin-top: 10px;display: none">
		     <div>
		     	We have detected your search term is generic, please write an accurate search term to get a better result or 
		     	<span class="label">choose below!</span> from our sugessions.
		     	<br/>
		     	If your search term is correct and you want to <span style="cursor: pointer;" onclick='continueSearch();return false;' class="label label-success">continue click here</span>
		     </div>
		     <div style="text-align: center;padding-left: 10px;">
			     <h2>Are you looking for?</h2>
			     <div id='step_items'>
				     
			     </div>
			      <div class='clearfix'></div>
			     <h2>OR</h2>
			     <button type="button" class='btn btn-large' onclick='continueSearch();return false;'>Continue Search!</button>
		     </div>
		    
	  </div>
	  
      <div id='results' class='table-bordered' style="border-left: 1px solid #DDD;padding: 10px;margin-top: 10px;display:none">
		     
	  </div>
      <hr>

      <!-- Example row of columns -->
      <div class="row-fluid">
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      
      
        <div class="modal hide fade" id='subcategory_model'>
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3>Refine to further improve the results!</h3>
		  </div>
		  <div class="modal-body">
		    <div class="dropdown open">
		      <a class="dropdown-toggle" id="dropdown-sub" style="display: none">
			    Open
			  </a>
			  <ul id='subcat_dropdown_content' class="dropdown-menu" style="position: relative;float: none">
			    
			  </ul>
			</div>
		  </div>
		  <div class="modal-footer">
		    <a href="#" data-dismiss="modal" onclick='closeModel(0);return false;' class="btn">Not Sure!</a>
		  </div>
		</div>
	<?php require_once 'footer.php';?>  
  
  <div id='resultBodyTemplate' style="display: none">
  		<div class="row-fluid clearfix website" id="{website}" style="vertical-align: middle;height: 165px;margin-top:10px">
				<div class="span2" style="line-height: 150px">
					<a href='{website_search_url}' target='_blank'><img src="{website_url}" alt="{website}" title="{website}"/></a>
				</div>
				<div class="popup span4 table-bordered item" style="margin-left:10px;border-left: 1px solid #DDD;text-align: center;height: 100%">
						<input type='hidden' id='item_url' value='{item_url}' />
						<input type='hidden' id='item_name' value='{item_name}' />
						<input type='hidden' id='item_image' value='{item_image}' />
						<input type='hidden' id='item_price' value='{item_price}' />
						<input type='hidden' id='item_author' value='{item_author}' />
						<input type='hidden' id='item_stock' value='{item_stock}' />
						<input type='hidden' id='item_offer' value='{item_offer_org}' />
						<input type='hidden' id='item_shipping' value='{item_shipping_org}' />
					 	<div class="media" style="margin-top: 0px">
							<a class='pull-left' href="{item_url}" target="_blank">
								<img style="width:100px;height:100px;margin:5px" class="img-rounded media-object" src="{item_image}" alt='{item_name}' title='{item_name}'/>
							</a>
							<div class="media-body pull-left" style="width: 175px;text-align:left">
								<div class='pull-left' style="max-height:40px;overflow:hidden">
									<a href="{item_url}" target="_blank" class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="{item_name}">{item_name}</a>
								</div>
								<div class='clearfix'></div>
								<div class='pull-left'>
									Price <span class="WebRupee">Rs.</span><span class='main_price'>{item_price}</span>
								</div>
								<div class='clearfix'></div>
								<div class='pull-left author' style="{author_display}">
									by <small>{item_author}</small>
								</div>
								<div class='clearfix'></div>
								<div class='pull-left' class='stock'>
									<span style="{in_stock_hide}" class="label label-success in_stock">In Stock</span>
									<span style="{out_stock_hide}" class="label label-important out_of_stock">Out Of Stock</span>
									<span style="{no_stock_hide}" class="label no_info">No Info</span>
								</div>
							</div>
						</div>
						<div class='clearfix'></div>
						<hr style="padding: 0px;margin: 0px;margin-top: 5px;"/>
						<div style="font-size:12px;margin: 5px;text-align: left;max-height: 38px;overflow: hidden;float: left;" class='other_info'>
							<div class='offer pull-left' style="{offer_display}">
								Offer: {item_offer}
							</div>
							<div class='clearfix'></div>
							<div class='shipping' style="font-size:12px">
								<div class='pull-left' style="{shipping_display}">
									Shipping: {item_shipping}
								</div>
							</div>
						</div>
				</div>
				<div class="span4" style="margin-left:10px;">
					<div class='row-fluid' id="other_prod">
					</div>
					<div style="padding-top: 10px;"></div>
				</div>
			 	<div class='span2 table-bordered' style="border-left: 1px solid #DDD;margin-left:10px;">
			 		<div style="font-size:12px">
						Coupons:
					</div>
				</div>
			 </div>
  </div>
  
  <div id='emptyBodyTemplate' style="display: none">
  		<div class="row-fluid clearfix website website_loading website_noresult" id="{website}" style="vertical-align: middle;height: 165px;margin-top:10px">
				<div class="span2" style="line-height: 150px">
					<a href='{website_search_url}' target='_blank'><img src="{website_url}" alt="{website}" title="{website}"/></a>
				</div>
				<div class="popup span10 table-bordered" style="line-height:150px;margin-left:10px;border-left: 1px solid #DDD;text-align: center;height: 100%">
					<div class="alert">
					  <strong>Sorry!</strong> No Results Found...
					</div>
				</div>
		</div>
  </div>
  
  <div id='errorBodyTemplate' style="display: none">
  		<div class="row-fluid clearfix website website_loading website_error" id="{website}" style="vertical-align: middle;height: 165px;margin-top:10px">
				<div class="span2" style="line-height: 150px">
					<a href='{website_search_url}' target='_blank'><img src="{website_url}" alt="{website}" title="{website}"/></a>
				</div>
				<div class="popup span10 table-bordered" style="height:150px;overflow:hidden;margin-left:10px;border-left: 1px solid #DDD;text-align: center;height: 100%">
					<div class="alert alert-error">
					  <strong>Error!</strong> {error_message}
					</div>
				</div>
		</div>
  </div>
  
  <div id='loadingBodyTemplate' style="display: none">
  		<div class="row-fluid clearfix website website_loading" id="{website}" style="vertical-align: middle;height: 165px;margin-top:10px">
				<div class="span2" style="line-height: 150px">
					<a href='{website_search_url}' target='_blank'><img src="{website_url}" alt="{website}" title="{website}"/></a>
				</div>
				<div class="popup span10 table-bordered" style="line-height:150px;margin-left:10px;border-left: 1px solid #DDD;text-align: center;height: 100%">
					Fetching Data... <img src='<?php echo Parser::SITE_URL;?>img/preload_small.gif' alt='loading..'/>
				</div>
		</div>
  </div>
  
  <div id='smallItemTemplate' style="display: none">
  		<div class='item' style="margin-left: 5px;">
  			<input type='hidden' id='item_url' value='{item_url}' />
			<input type='hidden' id='item_name' value='{item_name}' />
			<input type='hidden' id='item_image' value='{item_image}' />
			<input type='hidden' id='item_price' value='{item_price}' />
			<input type='hidden' id='item_author' value='{item_author}' />
			<input type='hidden' id='item_stock' value='{item_stock}' />
			<input type='hidden' id='item_offer' value='{item_offer}' />
			<input type='hidden' id='item_shipping' value='{item_shipping}' />
			<div class='table-bordered' style="border-left: 1px solid #DDD;padding: 0px;text-align: center;margin-bottom: 3px;font-size: 12px">
				<div class='pull-left'>
					<a href="{item_url}" target="_blank">
						<input type='hidden' value='{item_img_load_id}' id='lazy' />
						<img class="lazy_load_img img-rounded" src="{item_image}" alt='{item_name}' title='{item_name}' width="50px" height="50px" style="width: 50px;height: 50px;" />
					</a>
				</div>
				<div class='pull-left' style="padding-left: 5px;width: 80%;text-align: left">
					<div>{item_name_html}</div>
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
  </div>
  <div id='stepItem' style="display: none">
  	<div  class='table-bordered pull-left' style="border-left: 1px solid #DDD;padding: 10px;margin-right: 20px;width: 150px;margin-top: 5px;height: 235px">
     	<div>
     		<a href="{item_url}" target="_blank">
				<img class="img-rounded" src="{item_image}" alt='{item_name}' title='{item_name}' style="max-width: 100px;max-height: 100px;" />
			</a>
     	</div>
     	<div style="height: 40px;overflow: hidden">
	     	<a href="{item_url}" target="_blank" class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="{item_name}">
	     		{item_name}
	     	</a>
     	</div>
     	<div>
			Price <span class="WebRupee">Rs.</span><span class='main_price'>{item_price}</span>
		</div>
		<div class='author' style="{author_display}">
			by <small>{item_author}</small>
		</div>
		<button type="button" onclick='searchThis("{item_name}");return false;' class='btn btn-small btn-info'>Search This!</button>
		<div style="padding-top: 20px;height: 30px">
			<a href='{website_search_url}'>
				<img style="max-width: 100px;max-height: 30px" class="img-rounded" src='{website_url}' alt='{website}' title='{website}'/>
			</a>
		</div>
     </div>
  </div>
  <div id='category_data'>
	<?php
		foreach ($cats as $key => $value){
			if(is_array($value)){
	?>	
			<div id='<?php echo $key?>_sub'>
				<?php foreach($value[key($value)] as $k => $v){ ?>
					<input type='hidden' id='<?php echo $k;?>' value='<?php echo $v;?>' />
				<?php } ?>		
			</div>
	<?php			 
			} 
		}
	?>
  </div>
</html>