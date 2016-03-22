<?php
	$email		= isset( $_POST['email'] )		? trim( $_POST['email'] ) : '';
	$uname		= isset( $_POST['uname'] )		? trim( $_POST['uname'] ) : '';
	$passwd		= isset( $_POST['passwd'] )		? $_POST['passwd'] : '';
	$type		= isset( $_POST['type'] )		? trim( $_POST['type'] ) : '';
	$bProfile	= isset( $_POST['bProfile'] )	? trim( $_POST['bProfile'] ) : 0;
	$bFB		= isset( $_POST['bFB'] )		? trim( $_POST['bFB'] ) : 0;
	$udid		= isset( $_POST['udid'] )		? trim( $_POST['udid'] ) : '';

	if ( $email == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input email address.'
		);

		echo json_encode( $arrRet );
		exit;
	}
	
	if ( $uname == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user name.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $passwd == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input password.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $type == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user type.'
		);

		echo json_encode( $arrRet );
		exit;
	}
/*
	if ( $udid == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input udid.'
		);

		echo json_encode( $arrRet );
		exit;
	}
*/
	//check fb account, if this is fb account, don't register and login will be success
	if ( $bFB == 1 )
	{
		//check already exist fb account
		$check = db_get_value('SELECT COUNT(no) FROM user WHERE email = \'' . db_sql( $email ) . '\'', $link);
		if ( $check )
		{
			$userInfo = getData('user', ' WHERE email = \'' . db_sql( $email ) . '\'', '*');

			if ( isset( $userInfo['passwd'] ) )
				unset( $userInfo['passwd'] );

			$year	= date('Y', $userInfo['regdate']);
			$month	= date('m', $userInfo['regdate']);
			$day	= date('d', $userInfo['regdate']);
			$uploadPath = '/upload/profile/' . $year . '/' . $month;

			//check if already exist profile image
			if ( !empty( $userInfo['profile_full'] ) )
				$userInfo['profile_full'] = $cfg['alias'] . $uploadPath . '/' . $userInfo['profile_full'];

			if ( !empty( $userInfo['profile_thumb'] ) )
				$userInfo['profile_thumb'] = $cfg['alias'] . $uploadPath . '/' . $userInfo['profile_thumb'];

			if ( isset( $userInfo['regdate'] ) )
				unset( $userInfo['regdate'] );

			//get post quantity
			$post_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE user_no = \'' . db_sql( $userInfo['no'] ) . '\'', $link);

			$userInfo['post_qty'] = $post_qty;

			$arrRet = array(
				'code' => 2,
				'content' => $userInfo
			);

			echo json_encode( $arrRet );
			exit;
		}
	}

	// check if already same email address
	$check = db_get_value('SELECT COUNT(no) FROM user WHERE email = \'' . db_sql( $email ) . '\'', $link);
	if ( $check )
	{
		$arrRet = array(
			'code' => 0,
			'content' => 'Duplicated email address.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$thumb = '';
	$full = '';
	if ( $bProfile == 1 )
	{
		// if bProfile is 1, upload profile picture and produce snapshot image.
		$valid_exts = array('jpeg', 'jpg', 'png', 'gif');

		if ( $_FILES['profile']['error'] <= 0 )
		{
			$ext = strtolower(pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION));
			if (in_array($ext, $valid_exts)) 
			{
				$folder = '../upload/profile/' . date('Y') . '/' . date('m');

				if ( !file_exists( $folder ) )
				{
					if ( !mkdir( $folder, 0777, true ) )
					{
						$arrRet = array(
							'code' => -1,
							'content' => 'Failed to create upload folder.'
						);
						echo json_encode( $arrRet );
						exit;
					}
				}

				$filename	= $_FILES['profile']['tmp_name'];
				$uid		= uniqid();
				$save_name  = $uid . '.' . $ext;
				$path		= $folder . '/' . $save_name;
				$thumb_path	= $folder . '/' . $uid . '_thumb.' . $ext;

				//==========================create thumbnail============================//
				$size = getimagesize($_FILES['profile']['tmp_name']);

				$x = 0; $y = 0; $w = $size[0]; $h = $size[1];
				$nw = 200; $nh = 200;

				$data = file_get_contents($_FILES['profile']['tmp_name']);
				$vImg = imagecreatefromstring($data);
				$dstImg = imagecreatetruecolor($nw, $nh);
				imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
				imagejpeg($dstImg, $thumb_path);
				imagedestroy($dstImg);

				$thumb = $uid . '_thumb.' . $ext;
				//=======================================================================//
				
				if ( !move_uploaded_file ( $filename, $path ) )
				{
					$arrRet = array(
						'code' => -1,
						'content' => 'Profile image upload failed.'
					);
					echo json_encode( $arrRet );
					exit;
				}
				else
				{
					$full = $save_name;
				}
			}
			else
			{
				$arrRet = array(
					'code' => -1,
					'content' => 'Profile image extension error. this extension is ' . $ext
				);

				echo json_encode( $arrRet );
				exit;
			}
		}
		else
		{
			$arrRet = array(
				'code' => -1,
				'content' => 'Profile image upload failed.(error occured)'
			);

			echo json_encode( $arrRet );
			exit;
		}
	}

	$sql  = 'INSERT INTO user SET ';
	$sql .= '  email = \'' . db_sql( $email ) . '\'';
	$sql .= ', uname = \'' . db_sql( $uname ) . '\'';
	$sql .= ', passwd = \'' . db_sql( base64_encode( $passwd ) ) . '\'';
	$sql .= ', type = \'' . db_sql( $type ) . '\'';
	$sql .= ', coin = \'' . db_sql( 100 ) . '\'';
	$sql .= ', bProfile = \'' . db_sql( $bProfile ) . '\'';
	$sql .= ', profile_thumb = \'' . db_sql( $thumb ) . '\'';
	$sql .= ', profile_full = \'' . db_sql( $full ) . '\'';
	$sql .= ', bFB = \'' . db_sql( $bFB ) . '\'';
	$sql .= ', udid = \'' . db_sql( $udid ) . '\'';
	$sql .= ', regdate = \'' . db_sql( time() ) . '\'';
	$sql .= ', regdate_format = \'' . db_sql( date('Y-m-d') ) . '\'';
	$query = db_query( $sql, $link );

	$no = mysql_insert_id();

	$arrRet = array(
		'code' => 1,
		'content' => $no
	);

	echo json_encode( $arrRet );
?>