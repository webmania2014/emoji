<?php
	$modulePath = '../modules';
	require_once( $modulePath . '/module_index.php' );
	
	$deviceToken = '03bb6220ed51fe8046203ac54c7ad54ad939860f2397c749f688c03c09892766';
	$msg = 'This is test msg';
	echo pushNotification( $deviceToken, $msg ) . '=======';
?>