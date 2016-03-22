<?php
	$url = 'http://54.69.198.99/api/api.php';
	$data = array(
		'api_type' => 'get_posts',
		'type' => 0,
		'idx' => 1,
		'record_per_once' => 1000
	);

	$ch = curl_init();

	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded") );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );

	// in real life you should use something like:
	// curl_setopt($ch, CURLOPT_POSTFIELDS, 
	//          http_build_query(array('postvar1' => 'value1')));

	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);
	curl_close ($ch);

	if ( $server_output )
	{
		echo $server_output;
	}
	else
	{
		echo 'Curl error:' . curl_error( $ch );
	}
?>