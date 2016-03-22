<?php
	session_start();
	$cfg = array();

	define( 'ADMIN_RECORD_PER_PAGE', 15 );
	define( 'RECORD_PER_BLOCK', 10 );

	if( $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.0.133' )
	{
		$cfg['DBHost']					= 'localhost';
		$cfg['DBUser']					= 'root';
		$cfg['DBPasswd']				= '';
		$cfg['DBName']					= 'rpi_db';
		$cfg['alias']					= 'http://192.168.0.133/rpi';
	}
	else
	{
		$cfg['DBHost']					= 'localhost';
		$cfg['DBUser']					= 'itexproc_panda';
		$cfg['DBPasswd']				= 'stickersroot';
		$cfg['DBName']					= 'stickers_main';
		$cfg['alias']					= 'http://cressida.websitewelcome.com';
	}
?>
