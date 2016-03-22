<?php
	$uno		= isset( $_POST['no'] ) ? $_POST['no'] : '';
	$email_list = isset( $_POST['email_list'] ) ? trim( $_POST['email_list'] ) : '';
	$index		= isset( $_POST['idx'] ) ? trim( $_POST['idx'] ) : 1;
	$record		= isset( $_POST['record_per_once'] ) ? trim( $_POST['record_per_once'] ) : '';

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

	if ( $email_list == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input email list.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $record == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input record quantity per once request.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$arrEmail = json_decode( $email_list );
	$removeArr = array();
	$where = ' WHERE 1';
	foreach ( $arrEmail as $email )
	{
		//check if exist this email in system
		$check = db_get_value('SELECT COUNT(no) FROM user WHERE email = \'' . db_sql( $email ) . '\'', $link);
		if ( !$check ) continue;

		$where .= ' AND email != \'' . db_sql( $email ) . '\'';
	}

	$sql  = 'SELECT COUNT(no) FROM user';
	$sql .= $where;
	$totalRecord = db_get_value( $sql, $link );

	$startno = $index * $record - $record;
	$sql  = 'SELECT no, email, uname, profile_thumb, profile_full, bFB, regdate FROM user';
	$sql .= $where;
	$sql .= ' ORDER BY regdate ASC';
	$sql .= ' LIMIT ' . $startno . ', ' . $record;
	$query = db_query( $sql, $link );

	$arrInfo = array();
	while ( $row = mysql_fetch_assoc( $query ) )
	{
		$year = date( 'Y', $row['regdate'] ); $month = date( 'm', $row['regdate'] );
		$path = $cfg['alias'] . '/upload/profile/' . $year . '/' . $month;

		$thumb	= ( $row['profile_thumb'] == '' ) ? '' : $path . '/' . $row['profile_thumb'];
		$full	= ( $row['profile_full'] == '' ) ? '' : $path . '/' . $row['profile_full'];

		$arrInfo[] = array(
			'no'			=> $row['no'],
			'email'			=> $row['email'],
			'uname'			=> $row['uname'],
			'profile_thumb' => $thumb,
			'profile_full'	=> $full,
			'bFB'			=> $row['bFB'],
		);
	}

	$arrRet = array(
		'code'		=> 1,
		'total'		=> $totalRecord,
		'content'	=> $arrInfo
	);

	echo json_encode( $arrRet );
?>