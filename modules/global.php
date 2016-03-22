<?php
	function random_float ($min,$max,$precision) 
	{
		return round( ( $min + lcg_value() * ( abs( $max-$min ) ) ), $precision);
	}
	
	function getDaySpace ( $curDate, $prevDate ) 
	{
		$oneDay		= 60 * 60 * 24;
		$cur_time	= mktime(0,0,0,substr($curDate,5,2),substr($curDate,8,2),substr($curDate,0,4));
		$prev_time	= mktime(0,0,0,substr($prevDate,5,2),substr($prevDate,8,2),substr($prevDate,0,4));
		$diff		= abs($cur_time - $prev_time) / $oneDay;
	    return $diff + 1;
	}

	function getHourSpace ( $curDate, $prevDate, $bFormat = true ) 
	{
		$oneDay		= 60 * 60;

		if ( !$bFormat )
		{
			$diff = abs( $curDate - $prevDate ) / $oneDay;
			return round( $diff );
		}

		$cur_time	= mktime(substr($curDate,11,2),substr($curDate,14,2),substr($curDate,17,2),substr($curDate,5,2),substr($curDate,8,2),substr($curDate,0,4));
		$prev_time	= mktime(substr($prevDate,11,2),substr($prevDate,14,2),substr($prevDate,17,2),substr($prevDate,5,2),substr($prevDate,8,2),substr($prevDate,0,4));
		$diff		= abs($cur_time - $prev_time) / $oneDay;
	    return round($diff);
	}

	function jsonDecode ( $jsonObj )
	{
		if ( trim( $jsonObj ) == "" ) return array();

		$comment = false;
		$out = '$x=';
   
		for ($i=0; $i<strlen($jsonObj); $i++)
		{
			if (!$comment)
			{
				if ($jsonObj[$i] == '{')        $out .= ' array(';
				else if ($jsonObj[$i] == '}')   $out .= ')';
				else if ($jsonObj[$i] == '[')   $out .= ' array(';
				else if ($jsonObj[$i] == ']')   $out .= ')';
				else if ($jsonObj[$i] == ':')   $out .= '=>';
				else							$out .= $jsonObj[$i];           
			}
			else $out .= $jsonObj[$i];
			if ($jsonObj[$i] == '"')    $comment = !$comment;
		}
	    eval($out.';');
		return $x; 
	}
	
	function fill_options_no_space ( $var, $opt= "", $flag_single = false )
	{
		while (list ($key, $val) = each ($var)) {
			if( $flag_single ) $key = $val;
			if ( $opt != '' && trim($key) == trim($opt) ) {
				echo "<option value='".$key."' selected>".$val."</option>\r\n";
			} else {
				echo "<option value='".$key."' >".$val."</option>\r\n";
			}
		}
	}

	function fill_options ( $var, $opt= "", $default_str="", $flag_single = false )
	{
		echo "<option value='' style='color:silver'>" . $default_str . "</option>\r\n";
		fill_options_no_space ( $var, $opt, $flag_single );
	}

	function fill_radios ( $var, $name, $default_sel="" )
	{
		while (list ($key, $val) = each ($var)) {
			echo "<span style='margin-left:5px;' onclick='javascript:radio_span_box_select( $(this) );'>";
				if ( $default_sel != '' && trim( $default_sel ) == trim( $key ) )
				{
					echo "<input type='radio' id='".$name."' name='".$name."' class='oms-radio validate[required]' value='".$key."' checked='checked'> ".$val." ";
				}
				else
				{
					echo "<input type='radio' id='".$name."' name='".$name."' class='oms-radio validate[required]' value='".$key."'> ".$val." ";
				}
			echo "</span>";
		}
	}

	function make_randome_val()
	{
		$usec = str_replace(' ','', microtime(true));
		$disp_time =  intval ($usec * 10000000 );
		return abs($disp_time);
	}

	function randomString($length) 
	{
		$randomcode = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
						   'A', 'B', 'C', 'd', 'E', 'F', 'G', 'H', 'x', 'J',
						   'K', 'b', 'M', 'N', 'y', 'P', 'r', 'R', 'S', 'T',
						   'u', 'V', 'W', 'X', 'Y', 'Z');
		mt_srand((double)microtime()*1000000);
		for($i=1;$i<=$length;$i++) $Rstring .= $randomcode[mt_rand(1, 36)];
		return $Rstring;
	} 

	function get_parameter ( $para = "", $action = "" ) 
	{
		global $_GET;

		$parameters = '';
		reset ( $_GET );

		while ( list ( $key, $val ) = each ( $_GET ) ) 
		{
			if ( $key == '' ) continue;
			if ( $para != "" ) 
			{
				$oneword = ( explode  ( ',',  $para ) );

				if ( $action != "" && $action == "ONLY" ) 
				{
					if ( in_array ($key, $oneword ) )
					{
						$parameters .= $key."=".$val.'&';
					}
				} 
				else if ( $action == "" || $action == "OTHER") 
				{
					if ( !in_array ($key, $oneword ) )
					{
						$parameters .= $key."=".$val.'&';
					}
				}
			} 
			else 
			{
				$parameters .= $key."=".$val.'&';
			}
		}
		return $parameters;
	}

	function string_cut ( $str, $length ) 
	{
		$str = strip_tags ( $str );

		if ( mb_strlen ( $str, "utf-8" ) > $length ) 
		{
			$str = iconv( "utf-8", "utf-8", mb_substr( $str, 0, $length, "utf-8") ).'..';
		}
		return $str;
	}

	function get_img_file_type ( $srcFile ) 
	{
		$info = getimagesize( $srcFile );

		switch ($info[2]) {
			case 1:
				return "gif"; break;
			case 2:
				return "jpg"; break;
			case 3:
				return "png"; break;
			default:
				return false;
		}
	}

	function get_file_type ( $filename ) 
	{
		$ext = explode ('.', $filename);
		$num = count ( $ext ) - 1;
		return strtolower( $ext[$num] );
	}

	function create_thumbnail_fix_size ( $srcfile, $file, $thumb_width, $thumb_height ) 
	{
		list ( $width, $height, $type, $attr) = getimagesize( $srcfile );

		$x = $thumb_width;
		$y = $thumb_height;

		$img_info = GetImageSize($srcfile);
		$newImg = imagecreatetruecolor($x, $y);
		$src = imagecreatefrom ( $srcfile, $type) ;

		imagecopyresampled ( $newImg, $src, 0, 0, 0, 0, $x, $y, $width, $height);
		ImageInterLace ( $newImg );
		if($img_info[2]==1) ImageGif($newImg, $file);
		else if($img_info[2]==2) ImageJpeg($newImg,$file, 100 );
		else if($img_info[2]==3) ImagePng($newImg, $file);
		else ImageJPEG  ( $newImg, $file, 100 );

		chmod($file,0777);
	}

	function create_thumbnail_ratio ( $srcfile, $file, $thumb_width ) 
	{
		list ( $width, $height, $type, $attr) = getimagesize( $srcfile );

		$x = 0;
		$y = 0;

		if ( $width > $height )
		{
			$x = ceil ( ( $width  - $height ) / 2 );
			$width = $height;
		}
		else if ( $height > $width )
		{
			$y = ceil ( ( $height - $width ) / 2 );
			$height = $width;
		}

		$new_image	= imagecreatetruecolor ( $thumb_width, $thumb_width ) or die ( "이메지생성오유!" );
		$img_info	= GetImageSize($srcfile);
		$extantion	= "JPG";

		if ( $img_info[2] == 2 )		$extantion = "JPG";
		else if ( $img_info[2] == 3 )	$extantion = "PNG";
		else if ( $img_info[2] == 1 )	$extantion = "GIF";

		if ( $extantion == "JPG" )
		{
			$image = @ImageCreateFromJPEG ( $srcfile );
		}
		else if ( $extantion == "PNG" )
		{
			$image = @ImageCreateFromPNG ( $srcfile );
		}
		else if ( $extantion == "GIF" )
		{
			$image = @ImageCreateFromGIF ( $srcfile );
		}

		imagecopyresampled ( $new_image, $image, 0, 0, $x, $y, $thumb_width, $thumb_width, $width, $height );

		if ( $extantion == "JPG" )
		{
			$image = ImageJpeg ( $new_image, $file );
		}
		else if ( $extantion == "PNG" )
		{
			$image = ImagePng ( $new_image, $file );
		}
		else if ( $extantion == "GIF" )
		{
			$image = ImageGif ( $new_image, $file );
		}

		chmod( $file, 0777 );
	}

	function create_thumbnail ( $srcfile, $file, $thumb_width ) 
	{
		list ( $width, $height, $type, $attr) = getimagesize( $srcfile );

		if ( $width < $thumb_width )
		{
			$x = $width;
			$y = $height;
		}
		else
		{
			$x = $thumb_width;
			$y =  $height / ( $width / $thumb_width );

			if ($y > $x) {
				$x = round ( ($thumb_width) * ( $width ) / $height );
				$y = $thumb_width;
			}
		}

		$img_info = GetImageSize($srcfile);
		$newImg = imagecreatetruecolor($x, $y);
		$src = imagecreatefrom ( $srcfile, $type) ;

		imagecopyresampled ( $newImg, $src, 0, 0, 0, 0, $x, $y, $width, $height);
		ImageInterLace ( $newImg );

		if($img_info[2]==1) ImageGif($newImg, $file);
		else if($img_info[2]==2) ImageJpeg($newImg,$file, 100 );
		else if($img_info[2]==3) ImagePng($newImg, $file);
		else ImageJPEG  ( $newImg, $file, 100 );

		chmod($file,0777);
	}

	function imagecreatefrom ( $tmpfile, $info ) 
	{
		switch ($info) {
			case 1:
				$new_img = ImageCreateFromGif($tmpfile);
				break;
			case 2:
				$new_img = ImageCreateFromJPEG($tmpfile);
				break;
			case 3:
				$new_img = ImageCreateFromPNG($tmpfile);
				break;
			default:
				$new_img = ImageCreateFromJPEG($tmpfile);
		}
		return $new_img;
	}

	function getData ( $tableName, $where, $fields ) 
	{
		global $link;

		$arr = array();

		if ( $fields == "*"  )
		{
			$sql		= "select * from ".$tableName." ".$where;
			$query		= db_query( $sql, $link );
			$columns	= mysql_num_fields( $query );
			$row		= mysql_fetch_assoc( $query );

			for($i = 0; $i < $columns; $i++) 
			{
				$field				= mysql_field_name( $query, $i );
				$arr[trim($field)]	= $row[trim($field)];
			}
		}
		else
		{
			$sql	= "select ".$fields." from ".$tableName." ".$where;
			$query	= db_query ( $sql, $link );
			$row	= mysql_fetch_assoc( $query );

			$split	= explode( ",", $fields );
			foreach ( $split as $k => $v )
			{
				$arr[trim($v)] = $row[trim($v)];
			}
		}

		return $arr;
	}

	function getDataByMySQLFunc ( $tableName, $where, $fieldName, $mysqlFunc )
	{
		global $link;

		$sql	= "SELECT ".$mysqlFunc."( ".$fieldName." ) as sp FROM ". $tableName ." ".$where;
		$query	= db_query( $sql, $link );
		$sp		= array_shift ( mysql_fetch_assoc ( $query ) );

		return $sp;
	}

	function sendMail ( $header, $attache = "" )
	{
		global $cfg;

		$mail = new PHPMailer();
		$mail->IsSMTP();								// send via SMTP
		$mail->Host     = 'smtp.live.com';				// SMTP servers
		$mail->SMTPAuth = true;							// turn on SMTP authentication
		$mail->Username = 'alica.podobnik@hotmail.com';	// SMTP user name
		$mail->Password = 'odeskalica1987';				// SMTP	passwd

		if ( $attache != "" )
		{
			$mail->AddAttachment( $attache );				// Attach File
		}

		$mail->From     = $header['from'];
		$mail->FromName = $header['fromName'];
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject  =  $header['subject'];
		$mail->AddAddress( $header['to'], $header['to'] );
		$mail->Body = $header['body'];

		return $mail->Send();
	}

	function adjustPurchaseImgList( $cur_time )
	{
		global $link;

		$sql  = 'SELECT no, boost, regdate FROM posts';
		$sql .= ' WHERE boost > 0';
		$query = db_query( $sql, $link );

		while ( $row = mysql_fetch_assoc( $query ) )
		{
			$hour = getHourSpace ( $cur_time, $row['regdate'], false ); 
			if ( $row['boost'] == '1000' )
			{
				if ( $hour > 1 )
				{
					$r_sql  = 'UPDATE posts SET';
					$r_sql .= ' boost = 0';
					$r_sql .= ' WHERE no = \'' . db_sql( $row['no'] ) . '\'';
					db_query( $r_sql, $link );
				}
			}
			else if ( $row['boost'] == '50000' )
			{
				if ( $hour > 24 )
				{
					$r_sql  = 'UPDATE posts SET';
					$r_sql .= ' boost = 0';
					$r_sql .= ' WHERE no = \'' . db_sql( $row['no'] ) . '\'';
					db_query( $r_sql, $link );
				}
			}
			else if ( $row['boost'] == '10000' )
			{
				if ( $hour > 1 )
				{
					$r_sql  = 'UPDATE posts SET';
					$r_sql .= ' boost = 0';
					$r_sql .= ' WHERE no = \'' . db_sql( $row['no'] ) . '\'';
					db_query( $r_sql, $link );
				}
			}
			else if ( $row['boost'] == '150000' )
			{
				if ( $hour > 24 )
				{
					$r_sql  = 'UPDATE posts SET';
					$r_sql .= ' boost = 0';
					$r_sql .= ' WHERE no = \'' . db_sql( $row['no'] ) . '\'';
					db_query( $r_sql, $link );
				}
			}
		}
	}

	function pushPublishInfoToArray( $uno, $cur_time, $row, &$retArr )
	{
		global $link, $cfg;

		$year = date( 'Y', $row['regdate'] ); $month = date( 'm', $row['regdate'] );

		if ( $row['repost'] == '1' )
		{
			$year = date( 'Y', $row['ori_regdate'] ); $month = date( 'm', $row['ori_regdate'] );
		}

		$user_no	= '';
		$email		= '';
		$uname		= '';

		$check = db_get_value('SELECT COUNT(no) FROM user WHERE no = \'' . db_sql( $row['user_no'] ) . '\'', $link);
		if ( $check )
		{
			$userInfo	= getData('user', ' WHERE no = \'' . db_sql( $row['user_no'] ) . '\'', 'no, uname, email');
			$user_no	= $userInfo['no'];		
			$email		= $userInfo['email'];		
			$uname		= $userInfo['uname'];		
		}

		//get repost quantity for a post
		$repost_qty = db_get_value( 'SELECT COUNT(no) FROM repost WHERE post_no = \'' . db_sql( $row['no'] ) . '\'', $link );

		$url = $cfg['alias'] . '/upload/posts/' . $year . '/' . $month . '/' . $row['img_url'];
		
		$heart_like = 2;
		if ( $uno != '' )
		{
			$check_like = db_get_value('SELECT COUNT(no) FROM heart_like WHERE user_no = \'' . db_sql( $uno ) . '\' AND post_no = \'' . db_sql( $row['no'] ) . '\'', $link);
			if ( $check_like )
				$heart_like = 1;
			else
				$heart_like = 0;
		}

		$origin_no = '';
		if ( $row['repost'] )
		{
			$origin_no = db_get_value( 'SELECT post_no FROM repost WHERE new_no = \'' . db_sql( $row['no'] ) . '\'', $link );
		}

		$retArr[] = array(
			'post_no'			=> $row['no'],
			'user_no'			=> $user_no,
			'user_name'			=> $uname,
			'email'				=> $email,
			'img_url'			=> $url,
			'comment'			=> $row['comment'],
			'like_qty'			=> $row['like_qty'],
			'report_qty'		=> $row['report_qty'],
			'view_counter'		=> $row['view_counter'],
			'is_mine'			=> ( $user_no == $row['user_no'] ) ? 1 : 0,
			'boost'				=> $row['boost'],
			'post_date'			=> $row['regdate_format'],
			'post_dt'			=> $row['regdate'],
			'repost'			=> $row['repost'],
			'origin_post_no'	=> $origin_no,
			'repost_qty'		=> $repost_qty,
			'heart_like'		=> $heart_like,
			'heart_qty'			=> $row['heart_like_qty']
		);				
	}

	function pushNotification( $deviceToken, $msg )
	{
		// Put your private key's passphrase here:
		$passphrase = 'Stickers12345';
//		$passphrase = 'gmlakdqhd';

		// Put your alert message here:
		////////////////////////////////////////////////////////////////////////////////
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', dirname(__FILE__) . '/ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
		{
//			echo "Failed to connect: $err $errstr" . PHP_EOL;
			return -1;
		}

		// Create the payload body
		$body['aps'] = array(
			'badge' => 1,
			'alert' => $msg,
			'sound' => 'default'
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result)
		{
//			echo 'Message not delivered' . PHP_EOL;
			return -1;
		}
		else
		{
//			echo 'Message successfully delivered' . PHP_EOL;
			return 1;
		}

		// Close the connection to the server
		fclose($fp);
	}
?>