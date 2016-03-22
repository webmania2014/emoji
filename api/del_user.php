<?php
	$uno = isset( $_POST['no'] ) ? $_POST['no'] : '';

	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//delete post
	$sql  = 'DELETE FROM posts WHERE user_no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	//delete repost
	$sql  = 'DELETE FROM repost WHERE user_no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	//delete user
	$sql  = 'DELETE FROM user WHERE no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code'		=> 1,
		'content'	=> 'SUCCESS'
	);

	echo json_encode( $arrRet );
?>