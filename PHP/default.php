<?php
define('SITE_URL', 'http://localhost/gitkraken/teamessential/');
    $DB_HOST= "localhost";
	$DB_USER="raUser";
	$DB_PASSWORD="67qUfDFLA72Kujkz";
	$DB_NAME= "FedUni_RA_Register";
	function login($username) {
	$_SESSION['username'] = $username;
}
	function logged_in_user() {
	return $_SESSION['username'];
}


	function loginName($name)
	{
		$_SESSION['name']=$name;
	}
	function getName() {
	return $_SESSION['name'];
}
	function loginEmail($email)
	{
		$_SESSION['email']=$email;
	}
	function getEmail() {
	return $_SESSION['email'];
}
	function is_logged_in() 
	{
		return isset($_SESSION['username']);
	}
	function logout() 
	{
		unset($_SESSION['username']);
		unset($_SESSION['name']);
		unset($_SESSION['email']);
		unset($_SESSION['perm']);
		unset($_SESSION['work']);
	}
	function setPermission($perm)
	{
		$_SESSION['perm']=$perm;
	}
	function getPermission()
	{
		return $_SESSION['perm'];
	}
	function setWork($work)
	{
		$_SESSION['work']=$work;
	}
	function getWork()
	{
		return $_SESSION['work'];
	}
		function setValid($val)
	{
		$_SESSION['valid']=$val;
	}
	function getValid()
	{
		return $_SESSION['valid'];
	}
?>