<?php
$prev_web = array();
$fullHtml = '';
if(isset($formattedResult) && !empty($formattedResult)){
	$item_id = 1;
	foreach($formattedResult as $website => $rows){
		ob_start();
		require 'templates/resultBody.php';
		$template = ob_get_contents();
		ob_end_clean();
		$template = str_replace('{website}',$website,$template);
		$index = 0;
		$fullSmallItem = '';
		foreach($rows as $row){
			if(!isset($row['author'])){
				$row['author'] = '';
			}
			if(!isset($row['stock'])){
				$row['stock'] = 0;
			}
			if(!isset($row['offer'])){
				$row['offer'] = '';
			}
			if(!isset($row['shipping'])){
				$row['shipping'] = '';
			}
			if(!isset($row['coupon'])){
				$row['coupon'] = '';
			}
			if($index == 0){
				$template = str_replace('{website}',$row['website'],$template);
				$template = str_replace('{website_search_url}',$row['searchurl'],$template);
				$template = str_replace('{website_url}',$row['logo'],$template);
				$template = str_replace('{coupon}',$row['coupon'],$template);
				ob_start();
				require 'templates/mainItem.php';
				$mainItem = ob_get_contents();
				ob_end_clean();
				$mainItem = str_replace('{item_id}',$item_id++,$mainItem);
				$mainItem = str_replace('{item_url}',$row['url'],$mainItem);
				$mainItem = str_replace('{item_name}',$row['name'],$mainItem);
				$mainItem = str_replace('{item_image}',$row['image'],$mainItem);
				$mainItem = str_replace('{item_price}',$row['disc_price'],$mainItem);
				$mainItem = str_replace('{item_author}',$row['author'],$mainItem);
				$mainItem = str_replace('{item_stock}',$row['stock'],$mainItem);
				$mainItem = str_replace('{item_offer_org}',$row['offer'],$mainItem);
				$mainItem = str_replace('{item_shipping_org}',$row['shipping'],$mainItem);

				$mainItem = str_replace('{in_stock_hide}','display:none',$mainItem);
				$mainItem = str_replace('{out_stock_hide}','display:none',$mainItem);
				$mainItem = str_replace('{no_stock_hide}','',$mainItem);

				$mainItem = str_replace('{offer_display}','',$mainItem);
				$mainItem = str_replace('{item_shipping}',$row['shipping'],$mainItem);
				$mainItem = str_replace('{shipping_display}','',$mainItem);
				$mainItem = str_replace('{item_offer}',$row['offer'],$mainItem);
			}else{
				ob_start();
				require 'templates/smallItem.php';
				$smallItem = ob_get_contents();
				ob_end_clean();
				$smallItem = str_replace('{item_id}',$item_id++,$smallItem);
				$smallItem = str_replace('{item_url}',$row['url'],$smallItem);
				$smallItem = str_replace('{item_name}',$row['name'],$smallItem);
				$smallItem = str_replace('{item_name_html}',$row['name'],$smallItem);
				$smallItem = str_replace('{item_image}',$row['image'],$smallItem);
				$smallItem = str_replace('{item_price}',$row['disc_price'],$smallItem);
				$smallItem = str_replace('{item_author}',$row['author'],$smallItem);
				$smallItem = str_replace('{item_stock}',$row['stock'],$smallItem);
				$smallItem = str_replace('{item_offer_org}',$row['offer'],$smallItem);
				$smallItem = str_replace('{item_shipping_org}',$row['shipping'],$smallItem);

				$smallItem = str_replace('{in_stock_hide}','display:none',$smallItem);
				$smallItem = str_replace('{out_stock_hide}','display:none',$smallItem);
				$smallItem = str_replace('{no_stock_hide}','',$smallItem);

				$smallItem = str_replace('{offer_display}','',$smallItem);
				$smallItem = str_replace('{item_shipping}',$row['shipping'],$smallItem);
				$smallItem = str_replace('{shipping_display}','',$smallItem);
				$smallItem = str_replace('{item_offer}',$row['offer'],$smallItem);
				$fullSmallItem .= $smallItem;
			}
			$index++;
		}
		$template = str_replace('{main_item_html}',$mainItem,$template);
		$template = str_replace('{other_prod}',$fullSmallItem,$template);
		$fullHtml .= $template;
	}
}
echo $fullHtml;
?>