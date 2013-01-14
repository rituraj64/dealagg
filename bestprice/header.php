<?php require_once 'Parsing.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){echo $title.' | PriceGenie.in';}else{echo 'Find Cheapest Price | PriceGenie.in';}?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PriceGenie.in is a real time price comparison engine, to find lowest online price for any product. It product real time information on coupon codes, stock status and other offers.">
    <meta name="author" content="Manish Prakash | Excellence Technologies.">
    <!-- Le styles -->
    <link href="<?php echo Parser::SITE_URL;?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Parser::SITE_URL;?>style.css" rel="stylesheet">
    <link href="<?php echo Parser::SITE_URL;?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://cdn.webrupee.com/font">
    <script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script src="<?php echo Parser::SITE_URL;?>bootstrap/js/bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript" src='<?php echo Parser::SITE_URL;?>js/ajax.js'></script>
	<script type="text/javascript" src='<?php echo Parser::SITE_URL;?>js/jquery.scrollTo-1.4.3.1-min.js'></script>

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
        <h3 class="muted">Price Genie <small>(beta)</small></h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li class="active"><a href="<?php echo Parser::SITE_URL;?>index.php">Home</a></li>
                <li><a href="#">Coupons</a></li>
                <li><a href="<?php echo Parser::SITE_URL;?>sites.php">Sites</a></li>
                <li><a href="<?php echo Parser::SITE_URL;?>recent.php">Recent Searches</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>
 <input type='hidden' id='site_url' value="<?php echo Parser::SITE_URL;?>"/>
 <input type='hidden' id='ajax_url' value="<?php echo Parser::AJAX_URL;?>"/>