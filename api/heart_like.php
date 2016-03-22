<?php
	$uno		= isset( $_POST['no'] ) ? trim( $_POST['no'] ) : '';
	$post_no	= isset( $_POST['post_no'] ) ? trim( $_POST['post_no'] ) : '';
	$bLike		= isset( $_POST['bLike'] ) ? trim( $_POST['bLike'] ) : '';

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

	if ( $post_no == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input post no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $bLike == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input bLike.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//get heart_like_qty
	$heart_like_qty = db_get_value('SELECT heart_like_qty FROM posts WHERE no = \'' . db_sql( $post_no ) . '\'');
	
	if ( $bLike == 1 )
	{
		//check already exist heart_like table
		$check = db_get_value('SELECT COUNT(no) FROM heart_like WHERE user_no = \'' . db_sql( $uno ) . '\' AND post_no = \'' . db_sql( $post_no ) . '\'', $link);
		if ( !$check )
		{
			$heart_like_qty ++;

			$sql  = 'UPDATE posts SET';
			$sql .= ' heart_like_qty = \'' . db_sql( $heart_like_qty ) . '\'';
			$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
			$query = db_query( $sql, $link );
		
			if ( $uno != '' )
			{
				$check = db_get_value('SELECT COUNT(no) FROM heart_like WHERE user_no = \'' . db_sql( $uno ) . '\' AND post_no = \'' . db_sql( $post_no ) . '\'', $link);
				if ( !$check )
				{
					$sql  = 'INSERT INTO heart_like SET';
					$sql .= '  user_no = \'' . db_sql( $uno ) . '\'';
					$sql .= ', post_no = \'' . db_sql( $post_no ) . '\'';
					$query = db_query( $sql, $link );
				}
			}
		}
	}
	else if ( $bLike == -1 )
	{
		$heart_like_qty --;

		if ( $heart_like_qty > 0 )
		{
			$sql  = 'UPDATE posts SET';
			$sql .= ' heart_like_qty = \'' . db_sql( $heart_like_qty ) . '\'';
			$sql .= ' WHERE no = \'' . db_sql( $post_no ) . '\'';
			$query = db_query( $sql, $link );

			if ( $uno != '' )
			{
				$sql  = 'DELETE FROM heart_like';
				$sql .= ' WHERE user_no = \'' . db_sql( $uno ) . '\'';
				$sql .= ' AND post_no = \'' . db_sql( $post_no ) . '\'';
				$query = db_query( $sql, $link );
			}
		}
	}
	else if ( $bLike == 0 )
	{
		if ( $uno == '' )
		{
			$arrRet = array(
				'code' => -1,
				'content' => 'Please input user no.'
			);

			echo json_encode( $arrRet );
			exit;
		}
		
		//check if already exist same record in heart_like
		$check = db_get_value('SELECT COUNT(no) FROM heart_like WHERE user_no = \'' . db_sql( $uno ) . '\' AND post_no = \'' . db_sql( $post_no ) . '\'', $link);
		if ( !$check )
		{
			$sql  = 'INSERT INTO heart_like SET';
			$sql .= '  user_no = \'' . db_sql( $uno ) . '\'';
			$sql .= ', post_no = \'' . db_sql( $post_no ) . '\'';
			$query = db_query( $sql, $link );
		}
	}

	$arrRet = array(
		'code' => 1,
		'content' => 'Success'
	);

	echo json_encode( $arrRet );
?>