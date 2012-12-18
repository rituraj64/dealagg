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
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Downloads</a></li>
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
        <p class="lead">Write the name, model number or any identifier the item you want to buy and our system will try to find the best possible price available online.</p>
        
        
        <form class="form-search" onsubmit="findPrice();return false;">
        	<div class="input-append">
		  		<input type="text" name='q' id='q' class="input-xlarge" style="font-size: 27px;height: 39px;">
		  		<button type="submit" class="btn btn-large btn-danger">Search</button>
		  	</div>
		</form>
		<div id='loading' style="display: none;">
			<img src='img/loading.gif' alt='loading..'/>
		</div>
		<div class="progress progress-info progress-striped" style="display: none">
		  <div class="bar" style="width: 0%;"></div>
		</div>
		<script type="text/javascript">
			function findPrice(){
				$('#loading').show();
				$('#results').hide();
				$('#results').html('');
				var query = $('#q').val();
				var url = 'find.php?q='+query;
				$.getJSON(url,function(data){
					$('#loading').hide();
					var size = data.data.length;
					if(size > 0){
						for(var i=0;i<data.data.length;i++){
							var logo = data.data[i].logo;
							var name = data.data[i].name;
							var price = data.data[i].disc_price;
							var image = data.data[i].image;
							var url = data.data[i].url;
							var website = data.data[i].website;

							if($('#results').find('#'+website).length > 0){
								var html = '<div class="span2 table-bordered" style="border-left: 1px solid #DDD;padding: 10px">';
									html += '<div>';
										html += '<a href="'+url+'" target="_blank"><img width="50px" height="50px" class="img-rounded" src="'+image+'"/></a>';
										html += '<div style="height:40px;overflow:hidden"><a href="'+url+'" target="_blank" class="name" rel="tooltip" data-placement="top" data-original-title="'+name+'" style="height:40px;overflow:hidden">'+name+'</a></div>';
										html += '<div><span class="WebRupee">Rs.</span>'+price+'</div>';
										html += '<div>levenshtein'+data.data[i].levenshtein+'</div>';
										html += '<div>levenshtein_score'+data.data[i].levenshtein_score+'</div>';
										html += '<div>similar_text'+data.data[i].similar_text+'</div>';
										html += '<div>similar_text_per'+data.data[i].similar_text_per+'</div>';
									html += '</div>';
								html += '</div>';
								$('#results').find('#'+website).append(html);
							}else{
								var html = '<div class="row-fluid" id="'+website+'">';
								html += '<div class="span2">';
									html += '<img src="'+logo+'"/>';
								html += '</div>';
								html += '<div class="span2 table-bordered" style="border-left: 1px solid #DDD;padding: 10px">';
									html += '<div>';
										html += '<a href="'+url+'" target="_blank"><img width="50px" height="50px" class="img-rounded" src="'+image+'"/></a>';
										html += '<div style="height:40px;overflow:hidden"><a href="'+url+'" target="_blank" class="name" rel="tooltip" data-placement="top" data-original-title="'+name+'">'+name+'</a></div>';
										html += '<div><span class="WebRupee">Rs.</span>'+price+'</div>';
										html += '<div>levenshtein'+data.data[i].levenshtein+'</div>';
										html += '<div>levenshtein_score'+data.data[i].levenshtein_score+'</div>';
										html += '<div>similar_text'+data.data[i].similar_text+'</div>';
										html += '<div>similar_text_per'+data.data[i].similar_text_per+'</div>';
									html += '</div>';
								html += '</div>';
								html += '</div>';
								$('#results').append(html);
							}	
						}
					}
					$('.name').tooltip()
					$('#results').show();
				});
			}
		</script>
      </div>
      <div id='results' class='table-bordered' style="border-left: 1px solid #DDD;padding: 10px;display: none">
		      
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

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

  </body>
</html>