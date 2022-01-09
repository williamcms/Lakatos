<?php
$whitelist = array('127.0.0.1','::1','localhost',);

if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
	$_SERVER['DOCUMENT_ROOT'] = 'C:\wamp64\www\projetos\jrx_eventos\\';
}

spl_autoload_register(function($className) {
	$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
	include_once $_SERVER['DOCUMENT_ROOT'] . $className . '.php';
	//include_once $className . '.php';
});