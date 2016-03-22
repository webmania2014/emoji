<?php
	$uno	= isset( $_POST['no'] ) ? $_POST['no'] : '';
	$type	= isset( $_POST['type'] ) ? $_POST['type'] : '';
	
	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $type == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please user type.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	$sql  = 'UPDATE user SET';
	$sql .= ' type = \'' . db_sql( $type ) . '\'';
	$sql .= ' WHERE no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Success'
	);

	echo json_encode( $arrRet );
	exit;
?>