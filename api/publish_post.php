<?php
	$uno		= isset( $_POST['no'] ) ? $_POST['no'] : '';
	$post_no	= isset( $_POST['post_no'] ) ? $_POST['post_no'] : '';

	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

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

	if ( $post_no == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input post no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//check if exist publish no
	$check = db_get_value('SELECT COUNT(no) FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
	if ( !$check )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'There is not No ' . $post_no
		);

		echo json_encode( $arrRet );
		exit;
	}

	$bPublish = db_get_value('SELECT bPublish FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);

	$sql  = 'UPDATE posts SET';
	$sql .= ' bPublish = \'' . db_sql( !$bPublish ) . '\'';
	$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Success'
	);

	echo json_encode( $arrRet );
?>