<?php
	ini_set('session.cookie_domain', '.pricegenie.in');
	session_set_cookie_params(0, '/', '.pricegenie.in');
	session_start();
	if(isset($_REQUEST[session_name()]) && $_REQUEST[session_name()] != session_id()){
		$request_id = $_REQUEST[session_name()];
		session_id($request_id);
	}
	require_once 'Parsing.php';
	
?>

<?php require_once 'header.php';?>

</div>
 	  <div class="genie-text genie-width">
      <div class="genie-texthead">
	  <h1>EVERYTHING GENIE</h1>
	  </div>
	  
	  <div class="genie-textpage">
	  
	 <?php include_once 'leftside.php';?>
	  
	  <div class="genie-textrght">
	  <div class="genie-rgthead"><span class="genie-icon1"></span><span class="gen-rghthdtext">contact genie</span><span class="genie-icon2"></span>
	  </div>
	  <div class="genie-paradivrght">
	  <div class="genie-pararghtxt">
	  <p>
	  The Genie has traveled from sea-to-sea, granting wishes to all of those who have come in contact with him. In his travels the Genie has noticed one troubling thing - Nobody lets you find the cheapest price on single click. Where's the best place to find the cheapest mobile, camera, accesories and books online? Who has the best coupon code available? Most importantly, who delivers to my place without extra charge? Hence, the quest to create <b>pricegenie.in</b> began.
	  </p>
	   <p>
	  The goal of Price Genie first and foremost is to create a realtime online price comparison engine. It finds lowest price of a product for you, along with best matching coupon codes available. It is to free your time and gain control of your money by discovering countless options, so you can focus on bigger and better things! The Genie knows how hard it is to place orders online sometime, whether it's because you are unfamiliar with the website where you can find the lowest price of the product, you have to place a large order and need to look for best matching coupon for discounts, or you sift through irrelevant search results and compile/ compare information. So why not let our <b>personal assistants "Genie" </b> do it for you - quicker and more efficiently? The Genie will help you find exactly what you want to buy and put every product, every store, every sale, coupon and discount, right at your fingertips. No matter what it is you are looking for, you can quickly find the <b>lowest price</b>, the <b>best deal</b>, the <b>perfect gift </b>, or that hard to find item. Price Genie crawls the entire Web and with its search technology helps shoppers discover everything that online shopping or local shopping has to offer. Over millions of products from more than lakhs of stores online are currently accessible through Price Genie.
	  </p>
	  
	  </div>
	  <div class="genie-listpara">
	  <p class="genie-plist">We make shopping more efficient, enabling shoppers to find sales, online coupons, all within a single user experience. </p>
	  
	  <ul>
	  <li>
	  <h1>Complete selection of Products -</h1>
	  <p> Mobiles, Mobile Accessories, Cameras, Camera Accessories and Books.</p>
	  </li>
	   <li>
	  <h1> Lowest Prices -</h1>
	  <p> Lowest price for a product, determined from all the merchants carrying that item</p>
	  </li>
	   <li>
	  <h1>Best Matching Coupons -</h1>
	  <p>Sales, coupons and discounts being offered by retailers, right while one is shopping</p>
	  </li>
	  
	  <li>
	  <h1>Exact Products -</h1>
	  <p>Type of the product or the exact product one is looking for, along with hard-to-find items, or that unique and rare find</p>
	  </li>
	  </ul>
	  
	  </div>
	  
	  <p class="genie-pbotext">At Price Genie we're committed to continually improving our site and your shopping experience. We welcome <span>feedback</span> from both shoppers and merchants.</p>
	  
	</div>
	  </div>
	  <div class="genie-clear"></div>
	  </div>
	    
	  </div>
	  
	  
	  
  	
	<?php require_once 'footer.php';?>  
  
 
  
  
 
	
  
</html>