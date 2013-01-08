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
			
			$_REQUEST['q'] = $searchObj->getQuery();
			$_REQUEST['cat'] = $searchObj->getCategory();
			$_REQUEST['subcat'] = $searchObj->getSubcat();;
			$_REQUEST['cache'] = 1;
			$_REQUEST['silent'] = 1;
			
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
      	<?php if(isset($result)){ ?>
      		<script type="text/javascript">
        	$(document).ready(function(){
        		$('#results').html('');
        		$('#results').show();
        		$('#showSuggestion').val(0);
        		//processData(eval(<?php echo json_encode($result)?>),'',1,1,true,0);
        		findPrice();
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
		<div class="alert alert-success" id='share' style="text-align: left;color:black;display: none">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Share Results: <input type='text' id='share_url' value='' style="width: 100%"/>
		</div>
		<div class="alert alert-info" id='summary'>
			<!-- 
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 -->
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
						<span onclick='findPrice("",0,1,false);' style="cursor: pointer;" class='icon-refresh'></span>
					</span> 
					<h4 id='time'></h4>
				</div>
				<div class='clearfix'></div>
		</div>
      </div>
      <input type='hidden' id='isSorting' value='0' />
      <input type='hidden' id='showSuggestion' value='1' />
      <input type='hidden' id='avg_best_price' value='0' />
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
  	<?php require 'templates/mainItem.php';?>
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