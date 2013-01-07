<html>
<head>

<link rel="stylesheet" type="text/css" href="css/jquery.fancybox1.css"></link>

</head>

<body>

	<form method="post" action="couponParse.php">
		<table>
			<tr>
				<td><label>Unique ID</label></td>
				<td><input type="text" name="uniq_id" id="uniq_id"></input></td>
				<td><span id="uniq_idErr"></span></td>
			</tr>
			<tr>
				<td><label>Coupon Code</label></td>
				<td><input type="text" name="coupon_code" id="coupon_code"></input></td>
				<td><span id="coupon_codeErr"></span></td>
			</tr>
			<tr>
				<td><label>Coupon Type</label></td>
				<td><input type="text" name="coupon_type" id="coupon_type"></input></td>
				<td><span id="coupon_typeErr"></span></td>
			</tr>
			<tr>
				<td><label>Deal URL</label></td>
				<td><input type="text" name="deal_url" id="deal_url"></input></td>
				<td><span id="deal_urlErr"></span></td>
			</tr>
			<tr>
				<td><label>Title</label></td>
				<td><input type="text" name="title" id="title"></input></td>
				
				<td><span id="titleErr"></span></td>
			</tr>
			<tr>
				<td><label>Website</label></td>
				<td><input type="text" name="website" id="website"></input></td>
				<td><span id="websiteErr"></span></td>
			</tr>
			<tr>
				<td><label>Description</label></td>
				<td>
					<textarea rows="10" cols="30" name="desc" id="desc"></textarea>
				</td>
				<td><span id="descErr"></span></td>
			</tr>
			<tr>
				<td><label>Success</label></td>
				<td><input type="text" name="success" id="success"></input></td>
				<td><span id="successErr"></span></td>
			</tr>
			<tr>
				<td><label>Code</label></td>
				<td><input type="text" name="code" id="code"></input></td>
				<td><span id="codeErr"></span></td>
			</tr>
			<tr>
				<td><label>Status</label></td>
				<td>
					<select id="status" name="status">
						<option value="0">Read</option>
						<option value="1">Ignore</option>
					</select>
				</td>
				<td><span id="statusErr"></span></td>
			</tr>
			<tr>
				<td colspan="3"><input type="submit" name="submit_coupon_parse" id="submit_coupon_parse" value="Submit"></input></td>
			</tr>
		</table>
	
	</form>
</body>
</html>