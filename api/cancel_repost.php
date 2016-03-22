<?php
	$uno		= isset( $_POST['no'] ) ? trim( $_POST['no'] ) : '';
	$post_no	= isset( $_POST['post_no'] ) ? trim( $_POST['post_no'] ) : '';

	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
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

	$new_no = db_get_value('SELECT new_no FROM repost WHERE user_no = \'' . db_sql( $uno ) . '\' AND post_no = \'' . db_sql( $post_no ) . '\'', $link);

	$sql  = 'DELETE FROM posts WHERE no = \'' . db_sql( $new_no ) . '\'';
	$query = db_query( $sql, $link );

	$sql  = 'DELETE FROM repost';
	$sql .= ' WHERE user_no = \'' . db_sql( $uno ) . '\'';
	$sql .= ' AND post_no = \'' . db_sql( $post_no ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Canceled repost.'
	);

	echo json_encode( $arrRet );
?>