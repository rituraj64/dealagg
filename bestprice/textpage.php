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
	  
	  <div class="genie-textleft">
	  
	  <ul>
	  
	  <li><a>ABOUT PRICE GENIE</a> </li>
	  <li><a>HOW IT WORKS</a></li>
	  <li><a>TEAM</a></li>
	  <li><a>CONTACT US</a></li>
	  </ul>
	  
	  
	  </div>
	  
	  <div class="genie-textrght">
	  <div class="genie-rgthead"><span class="genie-icon1"></span><span class="gen-rghthdtext">about price genie</span><span class="genie-icon2"></span>
	  </div>
	  </div>
	  <div class="genie-clear"></div>
	  
	  </div>
	  
	  
	  
  	
	<?php require_once 'footer.php';?>  
  
 
  
  
 
	
  
</html>