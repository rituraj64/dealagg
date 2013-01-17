<?php require_once 'header.php';?>


<?php
	require_once 'Parsing.php';
	$parsing = new Parsing();
	$sites = $parsing->getWebsites();
	foreach($sites as $site){
		require_once 'Sites/'.$site.'.php';
		$siteObj = new $site;
?>
	<div class="row-fluid clearfix website" id="<?php echo $siteObj->getCode()?>" style="vertical-align: middle;margin-top:10px;position: relative;">
		<div class="span2" style="line-height: 100px">
			<a href='<?php echo $siteObj->getWebsiteUrl();?>' target='_blank'><img src="<?php echo $siteObj->getLogo();?>" alt="<?php echo $siteObj->getCode()?>" title="<?php echo $siteObj->getCode()?>"/></a>
		</div>
		<div class="span10 other_info_parent">
				<?php if(isset($_REQUEST['site'])){ ?>
				<div class='row-fluid'>
						<?php 
							$data = $siteObj->findBestCoupon();
							$i = 0;
							foreach($data as $row){
						?>		
								<div id='<?php echo  $row['id'];?>' class='table-bordered pull-left' style="margin-left:10px;border-left: 1px solid #DDD;width:200px">
								<?php			
								$title ='';
								if($row['discount_type'] == 'percentage'){
									$title .= $row['discount'].'% off ';
								}else{
									$title .= '<span class="WebRupee">Rs.</span>'.$row['discount'].' off';
								}
								if(!empty($row['categories'])){
									$title .= ' on '.$row['categories'];
								}
								if($row['active_from'] != 0){
									$title .= ' From '. $row['active_from'];
								}
								if($row['active_to'] != 0){
									$title .= ' To '. $row['active_to'];
								}
								?>
									<div><?php echo $title;?></div>
									<?php if(!empty($row['product'])){ ?>
										<div>Only For Product <?php echo $row['product'];?></div>
									<?php } ?>
									<div>
										COUPON CODE: <b><?php echo $row['coupon_code']?></b>
									</div>
								</div>
						<?php 
						$i++;
						if($i>2){
							break;
							}
						}
						?>
				</div>
				<?php } else { ?>
				
					<div class='table-bordered pull-left' style="margin-left:10px;border-left: 1px solid #DDD">
						<?php echo $siteObj->findBestCoupon();?>
					</div>
				<?php } ?>
		</div>
 	</div>
	
<?php		
	}

?>

<?php require_once 'footer.php';?>