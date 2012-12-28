<?php
	session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Find Cheapest Price</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://cdn.webrupee.com/font">
    <script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript" src='js/ajax.js'></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="bootstrap/ico/favicon.png">
                                   
	 
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="muted">Project name</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="#">Coupons</a></li>
                <li><a href="sites.php">Sites</a></li>
                <li><a href="#">Recent Searches</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>

      <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>Ask Me!</h1>
        <!-- 
        <p class="lead">Write the name, model number or any identifier the item you want to buy and our system will try to find the best possible price available online.</p>
         -->
        <form class="form-search" onsubmit="findPrice();return false;" style="font-size: 27px">
        		Find cheapest price for 
		  		<input type="text" name='q' id='q' class="input-xlarge" style="font-size: 27px;height: 39px;">
		  		in 
		  	 	<select id='category' style="font-size: 18px;height: 39px;" onchange="$('#subcategory').val('-1');">
		  	 		<option value="-1">Select Category..</option>
		  	 		<?php
		  	 			require_once 'Category.php';
		  	 			$catObj = new Category();
		  	 			$cats = $catObj->getStoreCategory();
		  	 			$i = 0;
		  	 			foreach($cats as $key => $cat){
		  	 				if(is_array($cat)){$cat = key($cat);}
		  	 		?>
		  	 			<option value="<?php echo $key;?>" <?php if(isset($_SESSION['prev_cat']) && $_SESSION['prev_cat'] == $key){echo 'selected="selected";';} ?>><?php echo $cat;?></option>
		  	 		<?php $i++;} ?>
		  		</select>
		  		<input type="hidden" id='subcategory' name='subcategory' value='-1' />
		  		<button type="submit" class="btn btn-large btn-danger">NOW!</button>
		</form>
		
		 <div id='error_msg' class="alert" style="display: none">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Warning!</strong> <span></span>
		</div>
		<div id='loading' style="display: none;">
			<img src='img/loading.gif' alt='loading..'/>
		</div>
		<input id='progress_total' type="hidden"/>
		<input id='progress_done' type="hidden"/>
		<div class="progress progress-info progress-striped" style="display: none">
		  <div class="bar" style="width: 0%;"></div>
		</div>
		<div class="alert alert-info" id='summary' style="text-align: left;color:black;display: none">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				<div class='pull-left'>
					Total Time Taken: <h4 id='time_taken'>65sec</h4>
				</div>
				<div class='pull-right'>
					Results As On:
					<input type='hidden' id='max_time' value="0" /> 
					<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="Get Latest Results">
						<span onclick='findPrice("",0,false);' style="cursor: pointer;" class='icon-refresh'></span>
					</span> 
					<h4 id='time'></h4>
				</div>
				<div class='clearfix'></div>
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

      <div class="footer">
        <p>&copy; Company 2012</p>
      </div>
      
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

    </div> <!-- /container -->
  </body>
  
  
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
  		<div class="row-fluid clearfix website website_loading" id="{website}" style="vertical-align: middle;height: 165px;margin-top:10px">
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
  		<div class="row-fluid clearfix website website_loading" id="{website}" style="vertical-align: middle;height: 165px;margin-top:10px">
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
					Fetching Data... <img src='img/preload_small.gif' alt='loading..'/>
				</div>
		</div>
  </div>
  
  <div id='smallItemTemplate' style="display: none">
  		<div class='span3 item' style="margin-left: 5px;">
  			<input type='hidden' id='item_url' value='{item_url}' />
			<input type='hidden' id='item_name' value='{item_name}' />
			<input type='hidden' id='item_image' value='{item_image}' />
			<input type='hidden' id='item_price' value='{item_price}' />
			<input type='hidden' id='item_author' value='{item_author}' />
			<input type='hidden' id='item_stock' value='{item_stock}' />
			<input type='hidden' id='item_offer' value='{item_offer}' />
			<input type='hidden' id='item_shipping' value='{item_shipping}' />
			<div class='table-bordered' style="border-left: 1px solid #DDD;padding: 5px;text-align: center;">
				<a href="{item_url}" target="_blank">
					<input type='hidden' value='{item_img_load_id}' id='lazy' />
					<img class="lazy_load_img img-rounded" src="{item_image}" alt='{item_name}' title='{item_name}'/>
				</a>
				<a class='detail-popup popup btn btn-mini {stock_color}' style="line-height: 14px" rel="popover" data-placement="right" data-html='true' data-trigger='click' data-content="{item_details}" data-original-title="{item_name}">Details</a>
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