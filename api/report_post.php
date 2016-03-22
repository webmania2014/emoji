<?php
	$post_no = isset( $_POST['post_no'] ) ? $_POST['post_no'] : '';

	if ( $post_no == '' || $post_no == 0 )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'There is no post no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//get report_count ...
	$report_qty = db_get_value( 'SELECT report_qty FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link );

	//check report count is over than 3.
	$will_count = $report_qty + 1;

	if ( $will_count >= 3 )
	{
		//get file path
		$postInfo = getData('posts', ' WHERE no = \'' . db_sql( $post_no ) . '\'', 'user_no, regdate, img_url');
		$year = date('Y', $postInfo['regdate']); $month = date('m', $postInfo['regdate']);
		$cur_path = dirname(__FILE__);
		$base_path = substr( $cur_path, 0, strrpos( $cur_path, '/' ) );
		$path = $base_path . '/upload/posts/' . $year . '/' . $month . '/' . $postInfo['img_url'];

		if ( file_exists( $path ) )
		{
			unlink( $path );
		}
		
		$sql  = 'DELETE FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'';
		$query = db_query( $sql, $link );

		//will integrate push notification.
		$deviceToken = db_get_value('SELECT udid FROM user WHERE no = \'' . db_sql( $postInfo['user_no'] ) . '\'', $link);
		$msg = 'Your post was deleted from our system because of numerous reports from others. Please remember to post nice things on Stickers.';

		pushNotification( $deviceToken, $msg );
	}
	else
	{
		$sql  = 'UPDATE posts SET ';
		$sql .= ' report_qty = \'' . db_sql( $will_count ) . '\'';
		$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
		$query = db_query( $sql, $link );
	}

	$arrRet = array(
		'code' => 1,
		'content' => 'SUCCESS'
	);

	echo json_encode( $arrRet );
?>