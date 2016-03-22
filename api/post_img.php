<?php
	$uno		= isset( $_POST['no'] ) ? trim( $_POST['no'] ) : 0;
	$comment	= isset( $_POST['comment'] ) ? trim( $_POST['comment'] ) : '';
	$bPub		= isset( $_POST['bPub'] ) ? trim( $_POST['bPub'] ) : 0;
	$boost		= isset( $_POST['boost'] ) ? trim( $_POST['boost'] ) : 0;
	$regdate	= time();
	$year = date('Y', $regdate); $month = date('m', $regdate);

/*
	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}
*/
/*
	//check if exist user no
	$check = db_get_value('SELECT COUNT(no) FROM user WHERE no = \'' . db_sql( $uno ) . '\'', $link);
	if ( !$check )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'There is no user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}
*/
	//upload image
	$url = '';
	if ( $_FILES['post_img']['error'] <= 0 )
	{
		$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
		$ext = strtolower( pathinfo($_FILES['post_img']['name'], PATHINFO_EXTENSION ) );
		if (in_array($ext, $valid_exts)) 
		{
			$folder = '../upload/posts/' . $year . '/' . $month;

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

			$filename	= $_FILES['post_img']['tmp_name'];
			$uid		= uniqid();
			$save_name  = $uid . '.' . $ext;
			$path		= $folder . '/' . $save_name;
			
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
				$url = $save_name;
			}
		}
		else
		{
			$arrRet = array(
				'code' => -1,
				'content' => 'Profile image extension error.'
			);

			echo json_encode( $arrRet );
			exit;
		}
	}
	else
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'File upload failed.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$sql  = 'INSERT INTO posts SET ';
	$sql .= '  user_no = \'' . db_sql( $uno ) . '\'';
	$sql .= ', img_url = \'' . db_sql( $url ) . '\'';
	$sql .= ', comment = \'' . db_sql( $comment ) . '\'';
	$sql .= ', bPublish = \'' . db_sql( $bPub ) . '\'';
	$sql .= ', boost = \'' . db_sql( $boost ) . '\'';
	$sql .= ', regdate = \'' . db_sql( $regdate ) . '\'';
	$sql .= ', regdate_format = \'' . db_sql( date('Y-m-d H:i:s', $regdate) ) . '\'';
	$sql .= ', repost = 0';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Success posting image.'
	);

	echo json_encode( $arrRet );
?>