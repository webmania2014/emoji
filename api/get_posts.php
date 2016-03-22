<?php
	$uno	= isset( $_POST['no'] ) ? trim( $_POST['no'] ) : '';
	$type	= isset( $_POST['type'] ) ? trim( $_POST['type'] ) : ''; // 0/space:recent, 1:popular, 2: mine
	$sort	= isset( $_POST['sort'] ) ? trim( $_POST['sort'] ) : ''; // 0/space:recent, 1:top like ...
	$index	= isset( $_POST['idx'] ) ? trim( $_POST['idx'] ) : 1;
	$record	= isset( $_POST['record_per_once'] ) ? trim( $_POST['record_per_once'] ) : '';
	$last_dt= isset( $_POST['last_dt'] ) ? trim( $_POST['last_dt'] ) : '';

	$cur_time = time();

	adjustPurchaseImgList( $cur_time );

	$arrPublishList = array();

	$startno = $index * $record - $record;

	// recent post list
	if ( $type == 0 )
	{
		// at first, check page no(index)
		// get purchased img list quantity
		$purchase_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE ( boost = \'' . db_sql( '1000' ) . '\' OR boost = \'' . db_sql( '50000' ) . '\' ) AND bPublish = 1', $link);
		$got_qty = $index * $record - $record;

		if ( $got_qty > $purchase_qty )
		{
			//calculate position
			$position = $startno - $purchase_qty;

			$sql  = 'SELECT * FROM posts';
			$sql .= ' WHERE 1';
			$sql .= ' AND boost = 0';
			$sql .= ' AND like_qty < 100';
			$sql .= ' AND bPublish = 1';
			$sql .= ' ORDER BY regdate DESC';
			$sql .= ' LIMIT ' . $position . ', ' . $record;
			$query = db_query( $sql, $link );

			while ( $row = mysql_fetch_assoc( $query ) )
				pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
		}
		else
		{
			$where  = ' WHERE 1';
			$where .= ' AND ( boost = 1000 OR boost = 50000 )';
			$where .= ' AND bPublish = 1';
			$where .= ' ORDER BY regdate ASC';
			$where .= ' LIMIT ' . $startno . ', ' . $record;

			$sql  = 'SELECT * FROM posts';
			$sql .= $where;
			$counter = 0;
			$query = db_query( $sql, $link );

			while ( $row = mysql_fetch_assoc( $query ) )
			{
				pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
				$counter ++ ;
			}

			if ( $counter < $record )
			{
				$sql  = 'SELECT * FROM posts';
				$sql .= ' WHERE 1';
				$sql .= ' AND boost = 0';
				$sql .= ' AND like_qty < 100';
				$sql .= ' AND bPublish = 1';
				$sql .= ' ORDER BY regdate DESC';
				$sql .= ' LIMIT 0, ' . ( $record - $counter );
				$query = db_query( $sql, $link );

				while ( $row = mysql_fetch_assoc( $query ) )
					pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
			}
		}
	}
	else if ( $type == 1 ) // popular
	{
		// at first, check page no(index)
		// get purchased img list quantity
		$purchase_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE ( boost = \'' . db_sql( '10000' ) . '\' OR boost = \'' . db_sql( '150000' ) . '\' ) AND bPublish = 1', $link);

		$got_qty = $index * $record - $record;
		if ( $got_qty > $purchase_qty )
		{
			//calculate position
			$position = $startno - $purchase_qty;

			$sql  = 'SELECT * FROM posts';
			$sql .= ' WHERE 1';
			$sql .= ' AND boost = 0';
			$sql .= ' AND like_qty >= 100';
			$sql .= ' AND bPublish = 1';
			$sql .= ' ORDER BY like_qty DESC, regdate DESC';
			$sql .= ' LIMIT ' . $position . ', ' . $record;
			$query = db_query( $sql, $link );

			while ( $row = mysql_fetch_assoc( $query ) )
				pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
		}
		else
		{
			$where  = ' WHERE 1';
			$where .= ' AND ( boost = 10000 OR boost = 150000 )';
			$where .= ' AND bPublish = 1';
			$where .= ' ORDER BY regdate ASC';
			$where .= ' LIMIT ' . $startno . ', ' . $record;

			$sql  = 'SELECT * FROM posts';
			$sql .= $where;
			$counter = 0;
			$query = db_query( $sql, $link );

			while ( $row = mysql_fetch_assoc( $query ) )
			{
				pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
				$counter ++ ;
			}

			if ( $counter < $record )
			{
				$sql  = 'SELECT * FROM posts';
				$sql .= ' WHERE 1';
				$sql .= ' AND boost = 0';
				$sql .= ' AND like_qty >= 100';
				$sql .= ' AND bPublish = 1';
				$sql .= ' ORDER BY like_qty DESC, regdate DESC';
				$sql .= ' LIMIT 0, ' . ( $record - $counter );
				$query = db_query( $sql, $link );

				while ( $row = mysql_fetch_assoc( $query ) )
					pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
			}
		}

	}
	else if ( $type == 2 )
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

		$sql  = 'SELECT * FROM posts';
		$sql .= ' WHERE user_no = \'' . db_sql( $uno ) . '\'';
		$sql .= ' ORDER BY regdate DESC';
		$query = db_query( $sql, $link );
		while ( $row = mysql_fetch_assoc( $query ) )
			pushPublishInfoToArray( $uno, $cur_time, $row, $arrPublishList );
	}
/*
	foreach ( $arrPublishList as $pub_unit )
	{
		//get current view qty
		$view_qty = db_get_value('SELECT view_counter FROM posts WHERE no = \'' . db_sql( $pub_unit['post_no'] ) . '\'', $link);
		$view_qty ++;
		$sql  = 'UPDATE posts SET';
		$sql .= ' view_counter = \'' . db_sql( $view_qty ) . '\'';
		$sql .= ' WHERE no = \'' . db_sql( $pub_unit['post_no'] ) . '\'';
		db_query( $sql, $link );
	}
*/

	$total = 0;
	if ( $type == 0 )
	{
		$purchase_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE boost = 1000 OR boost = 50000', $link);
		$normal_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE like_qty < 100 AND boost = 0', $link);
		$total = $purchase_qty + $normal_qty;
	}
	else if ( $type == 1 )
	{
		$purchase_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE boost = 10000 OR boost = 150000', $link);
		$normal_qty = db_get_value('SELECT COUNT(no) FROM posts WHERE like_qty >= 100 AND boost = 0', $link);
		$total = $purchase_qty + $normal_qty;
	}
	else
	{
		$total = db_get_value('SELECT COUNT(no) FROM posts WHERE user_no = \'' . db_sql( $uno ) . '\'', $link);
	}

	$arrRet = array(
		'code'		=> 1,
		'total'		=> $total,
		'content'	=> $arrPublishList,
		'cur_dt'	=> $cur_time,
		'bLast'		=> ( count( $arrPublishList ) < $record ) ? 1 : 0
	);

	echo json_encode( $arrRet );
?>