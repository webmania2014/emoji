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

	//check if already exist post
	$check = db_get_value('SELECT COUNT(no) FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
	if ( !$check )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'There is not post.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//check this post is mine.
	$post_user = db_get_value('SELECT user_no FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
	if ( $uno != $post_user )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'This post is not yours.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$img_url = db_get_value('SELECT img_url FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
	//check already exist same url
	$check = db_get_value('SELECT COUNT(no) FROM posts WHERE img_url = \'' . db_sql( $img_url ) . '\'', $link);
	if ( !$check )
	{
		//get file path
		$postInfo = getData('posts', ' WHERE no = \'' . db_sql( $post_no ) . '\'', 'regdate, img_url');
		$year = date('Y', $postInfo['regdate']); $month = date('m', $postInfo['regdate']);
		$cur_path = dirname(__FILE__);
		$base_path = substr( $cur_path, 0, strrpos( $cur_path, '\\' ) );
		$path = $base_path . '/upload/posts/' . $year . '/' . $month . '/' . $postInfo['img_url'];

		if ( file_exists( $path ) )
		{
			unlink( $path );
		}
	}

	$sql  = 'DELETE FROM posts';
	$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Success'
	);

	echo json_encode( $arrRet );
	exit;
?>