<?php
	$uno		= isset( $_POST['no'] ) ? $_POST['no'] : '';
	$email		= isset( $_POST['email'] ) ? trim( $_POST['email'] ) : '';
	$passwd		= isset( $_POST['passwd'] ) ? trim( $_POST['passwd'] ) : '';
	$bProfile	= isset( $_POST['bProfile'] ) ? trim( $_POST['bProfile'] ) : 0;

	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $email == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input email address.'
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

	//check if already exist same email address .
	$ori_email = db_get_value('SELECT email FROM user WHERE no = \'' . db_sql( $uno ) . '\'', $link);

	if ( $ori_email != $email )
	{
		$chk_exist = db_get_value('SELECT COUNT(no) FROM user WHERE email = \'' . db_sql( $email ) . '\'', $link);

		if ( $chk_exist )
		{
			$arrRet = array(
				'code' => 0,
				'content' => 'Already exist same email address.'
			);

			echo json_encode( $arrRet );
			exit;
		}
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
				$ori_regdate = db_get_value('SELECT regdate FROM user WHERE no = \'' . db_sql( $uno ) . '\'', $link);
				$folder = '../upload/profile/' . date('Y', $ori_regdate) . '/' . date('m', $ori_regdate);

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

	$sql  = 'UPDATE user SET';
	$sql .= '  email = \'' . db_sql( $email ) . '\'';
	$sql .= ', passwd = \'' . db_sql( base64_encode( $passwd ) ) . '\'';
	if ( $bProfile == 1 )
	{
		$sql .= ', bProfile = \'' . db_sql( $bProfile ) . '\'';
		$sql .= ', profile_thumb = \'' . db_sql( $thumb ) . '\'';
		$sql .= ', profile_full = \'' . db_sql( $full ) . '\'';
	}
	$sql .= ' WHERE no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code'		=> 1,
		'content'	=> 'SUCCESS'
	);

	echo json_encode( $arrRet );
?>