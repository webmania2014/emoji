<?php
	$email	= isset( $_POST['email'] )	? trim( $_POST['email'] ) : '';
	$passwd = isset( $_POST['passwd'] ) ? $_POST['passwd'] : '';
	$udid	= isset( $_POST['udid'] ) ? $_POST['udid'] : '';

	if ( $email == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input email address.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $email == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input password.'
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

	//check if same password
	$db_passwd = db_get_value('SELECT passwd FROM user WHERE email = \'' . db_sql( $email ) . '\'', $link);

	if ( base64_encode( $passwd ) != $db_passwd )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Invalid password.'
		);

		echo json_encode( $arrRet );
		exit;
	}

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

	if ( $udid != '' )
	{
		//update udid
		$sql  = 'UPDATE user SET ';
		$sql .= ' udid = \'' . db_sql( $udid ) . '\'';
		$sql .= ' WHERE no = \'' . db_sql( $userInfo['no'] ) . '\'';
		$query = db_query( $sql, $link );
	}

	$arrRet = array(
		'code'		=> 1,
		'content'	=> $userInfo
	);

	echo json_encode( $arrRet );
?>