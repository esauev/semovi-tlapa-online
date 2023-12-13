<?php
namespace Core;
defined("APPPATH") OR die("Access denied");

class Controller{
    
	public function __construct(){
		$AUTH_USER = '4dminRcS1#.m';
		$AUTH_PASS = 'Rs541M3s$as';
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		$credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

		$notAuthenticated = (
			!$credentials ||
			$_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
			$_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
		);

		if ($notAuthenticated) {
			header('HTTP/1.1 401 Authorization Required');
			header('WWW-Authenticate: Basic realm="Access denied"');
			exit;
		}
	}
}
