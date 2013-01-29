<?php
	session_start(); 
	date_default_timezone_set('Asia/Calcutta');
	if(isset($_REQUEST['query_id'])){
		$query_id = $_REQUEST['query_id'];
		require_once 'model/Search.php';
		$searchObj = new Search();
		$searchObj->query_id = $query_id;
		$row = $searchObj->read();
		if(isset($row[0])){
			$searchObj->smartAssign($row[0]);
			
			$created_at = $searchObj->created_at;
			
			$_REQUEST['q'] = $searchObj->getQuery();
			$_REQUEST['cat'] = $searchObj->getCategory();
			$_REQUEST['subcat'] = $searchObj->getSubcat();;
			$_REQUEST['cache'] = 1;
			$_REQUEST['silent'] = 1;
			$_REQUEST['url_based'] = 1;
			
			require_once 'find.php';
			$result = $return;
			
			$formattedResult = array();
			foreach($result['data'] as $row){
				if(!isset($formattedResult[$row['website']])){
					$formattedResult[$row['website']] = array();
				}	
				$formattedResult[$row['website']][] = $row;
			}
			$title = 'Lowest Online Price Found For '. $_REQUEST['q'];
			
		}else{
			$error = 'Search Query Doesnt Exist';
		}
	}
?>

<?php require_once 'header.php';?>
 	
      <!-- Jumbotron -->
      <div class="jumbotron">
	   <div class="genie-price genie-width">
      	<?php if(isset($result)){ ?>
      		<script type="text/javascript">
        	$(document).ready(function(){
        		$('#results').html('');
        		$('#results').show();
        		$('#showSuggestion').val(0);
        		<?php
        			$website_data = $searchObj->website_data;
        			$timetaken = $searchObj->time_taken;
        			$website_data = explode('$',$website_data);
        			
        			$websites_order = array();
        			
        			foreach($website_data as $web){
        				$web = explode(':',$web);
        				if(!isset($websites_order[$web[1]])){
        					$websites_order[$web[1]] = array();
        				}
        				$websites_order[$web[1]][] = $web[0];
        			}
        			if(isset($websites_order['RESULT'])){
        				foreach($websites_order['RESULT'] as $site_name){
        					$data = $formattedResult[$site_name]
        		?>
        				makeResultBody(eval(<?php echo json_encode(array('data'=>$data))?>),'',1,1,true,0);
        		<?php
        				}
					}
					if(isset($websites_order['BAD'])){
						foreach($websites_order['BAD'] as $site_name){
							$data = $formattedResult[$site_name]
							?>
					var x = makeResultBody(eval(<?php echo json_encode(array('data'=>$data))?>),'',1,1,true,0);
					if(x){
						makeSmall('<?php echo $site_name;?>');
					}
					<?php
					}
					}
					$sites = $parsing->getWebsites();
					if(isset($websites_order['NORESULT'])){
						foreach($websites_order['NORESULT'] as $site_name){
							foreach($sites as $site){
								require_once 'Sites/'.$site.'.php';
								$siteObj = new $site;
								if($siteObj->getCode() == $site_name){
									$erow = array('site'=>$site_name,'searchurl'=>$siteObj->getSearchURL($_REQUEST['q'],$_REQUEST['cat'],$_REQUEST['subcat']),'logo'=>$siteObj->getLogo());
									$r = array();
									$r[] = $erow;
					?>
					makeEmptyBody(eval(<?php echo json_encode(array('empty_sites'=>$r));?>));
					<?php		
								}
							}
					}
					}
        		?>
        		loadSmallImages();
        		var starttime = new Date().getTime() - <?php echo $timetaken*1000;?>*1;
        		finished();
        		putShareUrl('<?php echo $_REQUEST['query_id']?>');
        		//findPrice();
        	});
        	</script>
        <?php }else{ ?>
        	<!--  <h1>Ask Me!</h1>-->
        	  
        <?php } ?>
		
		

       	
        <div class="genie-frmtext"><h1>FIND cheapest price on single click</h1>
        <p>Price Genie is a realtime online price comparison engine, it finds lowest price of a product for you along with best matching coupon codes available
Gain control of your money and discover countless options</p>
        </div>
        <form class="form-search genie-form" onsubmit="$('#showSuggestion').val(1);findPrice();return false;" style="font-size: 27px">
        		<div class="genie-back">
        		<div class="genie-frmdiv">
        		<span>search</span>
        			<div class="genie-inputbg">
		  		<input type="text" name='q' id='q' class="input-xlarge genie-input" style="font-size: 27px;height: 39px;" value='<?php if(isset($result)){echo $searchObj->getQuery();}else {echo 'Enter Exact Product Name' ;}?>'>
		  	
		  	 	<select id='category' style="font-size: 25px;height:47px;" onchange="$('#subcategory').val('-1');">
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
		  		</div>
		  		<button type="submit" class="btn btn-large btn-danger genie-but"></button>
		  		<div class="genie-clear"></div>
		</div>
		</div>
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
		<div class="alert alert-success" id='share' style="text-align: left;color:black;<?php if(!isset($result)){echo 'display: none';}?>">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Share Results: <input type='text' id='share_url' value='<?php if(isset($result)){echo 'display: none';}?>' style="width: 100%"/>
		</div>
		<div class="alert alert-info" id='summary' style="<?php if(!isset($result)){echo 'display: none';}?>">
				<div class='pull-left' style="width: 25%">
					Total Time Taken: <h4 id='time_taken'></h4>
				</div>
				<div class='pull-left' id='progress' style="width: 50%;display: none;text-align: center">
					<div>
						<span id='progess_per'></span><span id='progess_text'></span>
					</div>
					<div class="progress progress-info progress-striped">
					   <div class="bar" style="width: 0%;"></div>
					</div>
				</div>
				<div class='pull-right'>
					Results As On:
					<input type='hidden' id='max_time' value="0" /> 
					<span class="apply_tooltip" rel="tooltip" data-placement="top" data-original-title="Get Latest Results">
						<span onclick='$("#showSuggestion").val(1);findPrice("",0,1,false);' style="cursor: pointer;" class='icon-refresh'></span>
					</span> 
					<h4 id='time'><?php if(isset($result)) {echo date('Y-m-d h:i:s',$created_at);}?></h4>
				</div>
				<div class='clearfix'></div>
				
		</div>
		</div>
      </div>
	  </div>
       <div class="container genie-width">
      <input type='hidden' id='isSorting' value='0' />
      <input type='hidden' id='query_id' value='0' />
      <input type='hidden' id='showSuggestion' value='1' />
      <input type='hidden' id='avg_best_price' value='0' />
      <input type='hidden' id='other_product_count' value='<?php echo Parsing::DATA_NUM;?>' />
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
	  
      <div id='results' class='table-bordered' style="border-left: 1px solid #DDD;padding: 10px;margin-top: 10px;<?php if(isset($formattedResult) && !empty($formattedResult)){}else{?>display:none<?php }?>">
		     <?php
		     	require_once 'showOutput.php';
		     ?>
	  </div>
	   <div id='bad-results' class='table-bordered' style="border-left: 1px solid #DDD;padding: 10px;margin-top: 10px;display: none;text-align: center">
	   		 <h2>Possibly Wrong Products</h2>
		     <div>
		     	We have detected that the below product maybe not be what your looking for, hence have seperated them. 
		     </div>
		     <div style="text-align: center;padding-left: 10px;">
			     <div id='bad_result_items'>
				     
			     </div>
		     </div>
		    
	  </div>
     

      <!-- Example row of columns -->
<!--     
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

      -->
      <div class="genie-midbg">
	    <div class="genie-leftbg"></div>
	  <div class="genie-midtext">
	  <div class="genie-serch"><span class="genie-img1"></span><span>best way to search</span><span class="genie-img2"></span>
	  </div>
	  <ul>
	  <li>Enter simple and specific product name your looking for or else results wont be accurate
	  </li>
	  <li>The final result page may have some product which your are not looking for, you can 
remove them easliy
	  </li>
	  <li>If the final results are not what your looking for try a better search term or send us 
feedback on the same
	  </li>
	  <li>We support only selected categories right now, so remember to search in those 
categories only
	  </li>
	  
	  </ul>
	  </div>
	  <div class="genie-rghtbg"></div>
	  <div class="genie-clear"></div>
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
		  	<?php /*  ?>
		    <a href="#" data-dismiss="modal" onclick='closeModel(0);return false;' class="btn">Not Sure!</a>
		    <?php */ ?>
		  </div>
		</div>
		
		<div id="fb-root"></div>
		<script type="text/javascript">

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
			//<![CDATA[
				window.fbAsyncInit = function() {
					FB.init({
						appId      : '<?php echo Parser::FB_APPKEY;?>', // App ID
						status     : true, // check login status
						cookie     : true, // enable cookies to allow the server to access the session
						oauth      : true, // enable OAuth 2.0
						xfbml      : true  // parse XFBML
					});
					
				  FB.Canvas.setAutoGrow();
					
				};
				
				// logs the user in the application and facebook
				function login(){
					var query_id = $('#query_id').val();
					if($('#share_url').val().length > 0){
						var basepath='<?php echo Parser::SITE_URL.'facebook.php?redirect='?>'+encodeURL($('#share_url').val());
						if(query_id.length > 0){
							basepath += '&query_id'+query_id;
						}
					}else{
						var basepath='<?php echo Parser::SITE_URL.'facebook.php'?>';
						if(query_id.length > 0){
							basepath += '?query_id'+query_id;
						}
					}
					FB.getLoginStatus(function(r){
						if(r.status === 'connected'){
							window.location.href = basepath;
					 	}else{
							FB.login(function(response) {
								if(response.authResponse) {
										window.location.href = basepath;
								} else {
								  // user is not logged in
								}
						  },{scope:'email'});
						}
				  });
				}
				// logs the user out of the application and facebook
				
				
				// Load the SDK Asynchronously
				(function() {
					var e = document.createElement('script'); e.async = true;
					e.src = document.location.protocol 
					+ '//connect.facebook.net/en_US/all.js';
					document.getElementById('fb-root').appendChild(e);
				}());
				
				//]]>
			</script>
			
	<?php require_once 'footer.php';?>  
  
  <div id='resultBodyTemplate' style="display: none">
  		<?php
  			ob_start();
			require 'templates/resultBody.php';
			$template = ob_get_contents();
			ob_end_clean();
			$template = str_replace('{other_prod}','',$template);
			echo $template;
  		?>
  </div>
  <div id="mainItemTemplate" style="display: none">
  	<?php
  			ob_start();
			require 'templates/mainItem.php';
			$template = ob_get_contents();
			ob_end_clean();
			$template = str_replace('{other_prod}','',$template);
			echo $template;
  		?>
  </div>
  
  <div id='emptyBodyTemplate' style="display: none">
  		<?php require 'templates/emptyBody.php';?>
  </div>
  
  <div id='errorBodyTemplate' style="display: none">
  		<?php require 'templates/errorBody.php';?>
  </div>
  
  <div id='loadingBodyTemplate' style="display: none">
  		<?php require 'templates/loadingBody.php';?>
  </div>
  
  <div id='smallItemTemplate' style="display: none">
  		<?php require 'templates/smallItem.php';?>
  </div>
  <div id='stepItem' id='{step_id}' style="display: none">
  	    <?php require 'templates/stepItem.php';?>
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
  <div id='website_hide_template' style="display: none">
  	<div class="span2 website_hide_box" style="margin-left: 10px;  line-height: 60px;">
  		<!-- 
		<div class="website_hide_remove btn btn-mini btn-important">Remove it!</div> or 
		 -->
		<div class="btn btn-mini btn-success website_hide_let_it_be">This is Correct</div>
	</div>
  </div>
</html>