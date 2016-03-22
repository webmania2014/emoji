<?php
	$uno	 = isset( $_POST['no'] ) ? $_POST['no'] : '';
	$post_no = isset( $_POST['post_no'] ) ? $_POST['post_no'] : '';

	if ( $post_no == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'There is no user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

/*
	if ( $uno == '' || $uno == 0 )
	{
		// check if exist user no
		$poster = db_get_value('SELECT user_no FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);

		if ( $uno == $poster )
		{
			$arrRet = array(
				'code' => -1,
				'content' => 'You can\'t share your post.'
			);

			echo json_encode( $arrRet );
			exit;
		}
	}
*/
	$like = db_get_value('SELECT like_qty FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
	$like ++;

	$sql  = 'UPDATE posts SET';
	$sql .= ' like_qty = \'' . db_sql( $like ) . '\'';
	$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
	$query = db_query( $sql, $link );

	if ( $like == 15 )
	{
		$user_no = db_get_value('SELECT user_no FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
		$deviceToken = db_get_value('SELECT udid FROM user WHERE no = \'' . db_sql( $user_no ) . '\'', $link);
		$msg = 'Your post is gaining lots of attention! Check it out';

		pushNotification( $deviceToken, $msg );
	}

	$arrRet = array(
		'code' => 1,
		'content' => $like
	);

	echo json_encode( $arrRet );

?>