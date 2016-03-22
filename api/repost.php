<?php
	$uno		= isset( $_POST['no'] ) ? trim( $_POST['no'] ) : '';
	$post_no	= isset( $_POST['post_no'] ) ? trim( $_POST['post_no'] ) : '';
	$comment	= isset( $_POST['comment'] ) ? trim( $_POST['comment'] ) : '';

	$regdate	= time();

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

	//check already repost this post
	$check = db_get_value('SELECT COUNT(no) FROM repost WHERE user_no = \'' . db_sql( $uno ) . '\' AND post_no = \'' . db_sql( $post_no ) . '\'', $link);
	if ( !$check )
	{
		$postInfo = getData( 'posts', ' WHERE no = \'' . db_sql( $post_no ) . '\'', 'regdate, ori_regdate, img_url, repost' );

		$sql  = 'INSERT INTO posts SET';
		$sql .= '  user_no = \'' . db_sql( $uno ) . '\'';
		$sql .= ', img_url = \'' . db_sql( $postInfo['img_url'] ) . '\'';
		$sql .= ', comment = \'' . db_sql( $comment ) . '\'';
		$sql .= ', bPublish = 1';
		$sql .= ', regdate = \'' . db_sql( $regdate ) . '\'';
		$sql .= ', regdate_format = \'' . db_sql( date('Y-m-d H:i:s', $regdate) ) . '\'';
		if ( !$postInfo['repost'] )
			$sql .= ', ori_regdate = \'' . db_sql( $postInfo['regdate'] ) . '\'';
		else
			$sql .= ', ori_regdate = \'' . db_sql( $postInfo['ori_regdate'] ) . '\'';
		$sql .= ', repost = 1';
		$query = db_query( $sql, $link );

		$sql  = 'INSERT INTO repost SET';
		$sql .= '  user_no = \'' . db_sql( $uno ) . '\'';
		$sql .= ', post_no = \'' . db_sql( $post_no ) . '\'';
		$sql .= ', new_no = \'' . db_sql( mysql_insert_id() ) . '\'';
		$sql .= ', regdate = \'' . db_sql( time() ) . '\'';
		$query = db_query( $sql, $link );

		$arrRet = array(
			'code' => 1,
			'content' => 'Success posting image.'
		);

		echo json_encode( $arrRet );
	}
	else
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Already exist repost.'
		);

		echo json_encode( $arrRet );
	}
?>