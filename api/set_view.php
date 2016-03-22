<?php
	$post_no = isset( $_POST['post_no'] ) ? $_POST['post_no'] : 0;

	if ( $post_no == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input post no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$view_counter = db_get_value('SELECT view_counter FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'', $link);
	$view_counter ++;

	$sql  = 'UPDATE posts SET';
	$sql .= ' view_counter = \'' . db_sql( $view_counter ) . '\'';
	$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => $view_counter
	);

	echo json_encode( $arrRet );
?>