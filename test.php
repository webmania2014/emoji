<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
	<?php
		$timestamp = mktime( 13, 0, 0, 6, 3, 2014 );
		echo $timestamp . '<br>';
		echo date( 'Y-m-d H:i:s', $timestamp );

		echo base64_decode('MTIzNDU2Nzg5');
	?>
		<!--for signup-->
		signup
		<form id = 'signform' name = 'signform' method = post action = 'http://itexprocc.com/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'signup'>
			email:<input type = 'text' id = 'email' name = 'email' value = 'test@hotmail.com'>
			username:<input type = 'text' id = 'uname' name = 'uname' value = 'John'>
			password:<input type = 'text' id = 'passwd' name = 'passwd' value = 'abc'>
			type:<input type = 'text' id = 'type' name = 'type' value = '1'>
			bProfile:<input type = 'text' id = 'bProfile' name = 'bProfile' value = '1'>
			bFB:<input type = 'text' id = 'bFB' name = 'bFB' value = '1'>
			file:<input type = 'file' id = 'profile' name = 'profile'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--for login-->
		login
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'login'>
			email:<input type = 'text' id = 'email' name = 'email' value = 'test5@hotmail.com'>
			passwd:<input type = 'text' id = 'passwd' name = 'passwd' value = 'abc'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--for posting-->
		posting
		<form id = 'loginform' name = 'loginform' method = post action = 'http://itexprocc.com/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'post_img'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			comment:<input type = 'text' id = 'comment' name = 'comment' value = 'this is test comment'>
			file:<input type = 'file' id = 'post_img' name = 'post_img'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--get post lists-->
		get posting
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'get_posts'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			type:<input type = 'text' id = 'type' name = 'type' value = '0'>
			sort:<input type = 'text' id = 'sort' name = 'sort' value = '0'>
			pageno:<input type = 'text' id = 'idx' name = 'idx' value = '1'>
			record:<input type = 'text' id = 'record_per_once' name = 'record_per_once' value = '100'>
			last dt:<input type = 'text' id = 'last_dt' name = 'last_dt' value = ''>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->
	
		<!--publish post-->
		publish posting
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'publish_post'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			post no:<input type = 'text' id = 'post_no' name = 'post_no' value = '11'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--delete post-->
		delete posting
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'del_post'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			post no:<input type = 'text' id = 'post_no' name = 'post_no' value = '2'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--forgot password-->
		delete posting
		<form id = 'loginform' name = 'loginform' method = post action = 'http://itexprocc.com/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'forgot_passwd'>
			email:<input type = 'text' id = 'email' name = 'email' value = '11'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--get friends-->
		get friends
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'get_friends'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			email list:<input type = 'text' id = 'email_list' name = 'email_list' value = '11'>
			pageno:<input type = 'text' id = 'idx' name = 'idx' value = '1'>
			record:<input type = 'text' id = 'record_per_once' name = 'record_per_once' value = '100'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--report-->
		report
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'report_post'>
			post no:<input type = 'text' id = 'post_no' name = 'post_no' value = '11'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--share-->
		share
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'increase_like'>
			post no:<input type = 'text' id = 'post_no' name = 'post_no' value = '11'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--share-->
		Edit Profile
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'edit_profile'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			email:<input type = 'text' id = 'email' name = 'email' value = ''>
			passwd:<input type = 'text' id = 'passwd' name = 'passwd' value = ''>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--share-->
		Repost
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'repost'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			post no:<input type = 'text' id = 'post_no' name = 'post_no' value = '39'>
			comment:<input type = 'text' id = 'comment' name = 'comment' value = 'test'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->

		<!--share-->
		Heart Like
		<form id = 'loginform' name = 'loginform' method = post action = 'http://192.168.0.133/rpi/api/api.php' enctype='multipart/form-data'>
			api type:<input type = 'text' id = 'api_type' name = 'api_type' value = 'heart_like'>
			user no:<input type = 'text' id = 'no' name = 'no' value = '11'>
			post no:<input type = 'text' id = 'post_no' name = 'post_no' value = '5'>
			bLike:<input type = 'text' id = 'bLike' name = 'bLike' value = 'test'>
			<input type = 'submit' value = 'submit'>
		</form>
		<!-------------->
	</body>
</html>