<?php
	$uno = isset( $_POST['user_no'] ) ? $_POST['user_no'] : '';
	$udid = isset( $_POST['udid'] ) ? $_POST['udid'] : '';

	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $udid == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input udid.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$sql  = 'UPDATE user SET';
	$sql .= ' udid = \'' . db_sql( $udid ) . '\'';
	$sql .= ' WHERE no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'SUCCESS'
	);

	echo json_encode( $arrRet );
?>