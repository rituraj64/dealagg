<?php
	require_once 'Parser.php';
	require_once 'Parsing.php';
	
	if(isset($_REQUEST['q'])){
		$query = urlencode($_REQUEST['q']);
		
		$parser = new Parser();

		$parsing = new Parsing();
		
		$data = array();
		
		$sites = $parsing->getWebsites();
		foreach($sites as $site){
		
			require_once $site.'.php';
			
			$siteObj = new $site;
			$url = $siteObj->getSearchURL($query);
			$html = $parser->getHtml($url);
			if($html){
				$data1 = $siteObj->getData($html);
			}
			if(empty($data)){
				$data = $data1;
			}else{
				$data = array_merge($data,$data1);
			}
		}
		/*
		$html = '<div>';
		$html .= '<div><img src="'.$image.'"/></div>';
		$html .= '<div>Name:<a href="'.$url.'">'.$name.'</a></div>';
		$html .= '<div>'.$disc_price.'<strike>'.$org_price.'</strike></div>';
		$html .= '</div>';
		echo $html;
		*/
	} 
?>
<html>
<body>

<form action="index.php" method="get">

	Search <input type="text" name='q' />
	<input type='submit' />
</form>


<?php
	if(isset($data)){
?>
<table>
	<tr>
		<td>
			Website
		</td>
		<td>
			Image
		</td>
		<td>
			Product Name
		</td>
		<td>
			Org Price
		</td>
		<td>
			Discount Price
		</td>
	</tr>
	<?php foreach($data as $row){ ?>
	<tr>
		<td>
			<?php echo $row['website']?>
		</td>
		<td>
			<a href="<?php echo $row['url']?>">
				<img src='<?php echo $row['image']?>'  width="100" height="100"/>
			</a>
		</td>
		<td>
			<?php echo $row['name']?>
		</td>
		<td>
			<?php echo $row['org_price']?>
		</td>
		<td>
			<?php echo $row['disc_price']?>
		</td>
	</tr>		
	<?php } ?>
</table>
<?php  
	}
?>

</body>
</html>