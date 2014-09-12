<?php

DEFINE ('DB_U', 'root');
DEFINE ('DB_P', '0');
DEFINE ('DB_H', 'localhost');
DEFINE ('DB_N', 'baza');
$dbc = mysqli_connect (DB_H, DB_U, DB_P, DB_N);
mysqli_set_charset($dbc, 'utf8');
function escape_data ($data) { 
    global $dbc;
	if (get_magic_quotes_gpc()) $data = stripslashes($data);
	return mysqli_real_escape_string ($dbc, trim ($data));
	}
function get_password_hash($password) {
	global $dbc;
	return mysqli_real_escape_string ($dbc, hash_hmac('sha256', $password, 'c#haRl891', true));
	} 

