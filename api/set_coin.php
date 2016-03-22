<?php
	$uno	= isset( $_POST['no'] ) ? $_POST['no'] : '';
	$coin	= isset( $_POST['coin'] ) ? $_POST['coin'] : '';

	if ( $uno == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input user no.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	if ( $coin == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input coin quantity.'
		);

		echo json_encode( $arrRet );
		exit;
	}
	
	$sql  = 'UPDATE user SET';
	$sql .= ' coin = \'' . db_sql( $coin ) . '\'';
	$sql .= ' WHERE no = \'' . db_sql( $uno ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Success'
	);

	echo json_encode( $arrRet );
	exit;

?>