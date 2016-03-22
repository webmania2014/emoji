<?php
	$modulePath = '../modules';
	require_once( $modulePath . '/phpseclib/Math/BigInteger.php' );
	require_once( $modulePath . '/phpseclib/Crypt/RSA.php' );
	require_once( $modulePath . '/module_index.php' );

	$email = isset( $_POST['email'] ) ? $_POST['email'] : '';

	if ( $email == '' )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Please input email address.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//check if exist same email address.
	$check = db_get_value('SELECT COUNT(no) FROM user WHERE email = \'' . db_sql( $email ) . '\'', $link);
	if ( !$check )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'There is not email address in this system.'
		);

		echo json_encode( $arrRet );
		exit;
	}

	//generate new password.
	$new_passwd = uniqid();

	//send mail 
	$message = "Did you forget your password ? <br>Your new password is " . $new_passwd . "<br>Thank you.";
	$header = array();
	$header['from'] = 'admin@54.69.198.99.com';
	$header['fromName'] = 'Stickers Support team';
	$header['to'] = $email;
	$header['subject'] = 'Did you forget your password ?';
	$header['body'] = $message;

	$ret = sendMail( $header );

	if ( !$ret )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Failed to send mail.'
		);

		echo json_encode( $arrRet );
		exit;
	}
	///////////
/*
	$key = new Crypt_RSA();
	//$key->setPassword('whatever');
	$key->loadKey(file_get_contents('Stickers.pem'));

	$ssh = new Net_SSH2( '54.69.198.99', 22 );
	if ( !$ssh->login( 'ubuntu', $key ) )
	{
		$arrRet = array(
			'code' => -1,
			'content' => 'Failed'
		);

		echo json_encode( $arrRet );
		exit;
	}	

	$command = 'echo -e "Did you forget your password? \\nYour password is ' . $new_passwd . '\\nThank you." | mail -s "Forgot your password?" ' . $email . ' -aFrom:StickersSupportTeam';
	$ssh->exec( $command );
*/
	$sql  = 'UPDATE user SET ';
	$sql .= ' passwd = \'' . db_sql( base64_encode( $new_passwd ) ) . '\'';
	$sql .= ' WHERE email = \'' . db_sql( $email ) . '\'';
	$query = db_query( $sql, $link );

	$arrRet = array(
		'code' => 1,
		'content' => 'Success'
	);

	echo json_encode( $arrRet );
?>