<?php
	$modulePath = '../modules';
	require_once( $modulePath . '/module_index.php' );

	$api_type = isset( $_POST['api_type'] ) ? $_POST['api_type'] : '';

	if ( $api_type == '')
	{
		$ret = array(  
			'code' => -1,
			'content' => 'Please input api type.'
		);
		
		echo json_encode( $ret );
		exit;
	}

	$api_file = './' . $api_type . '.php';

	if ( !file_exists( $api_file ) )
	{
		$ret = array(  
			'code' => -1,
			'content' => 'Invalid api type.'
		);
		
		echo json_encode( $ret );
		exit;
	}

	require_once( $api_file );
?>