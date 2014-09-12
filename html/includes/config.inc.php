<?php
// Konfiguracijska skripta redirecting korisnika ,definiranje konstanti i podesen error_handler 
$live = false;
$contact_email = 'system0@net.hr';
define ('BASE_URI', 'C:/Program Files/XAMPP/htdocs/zavrsni_rad/');
define ('BASE_URL', 'localhost/');
define ('PDFS_DIR', BASE_URI . 'pdfs/'); 
define ('MYSQL', BASE_URI . 'mysql.inc.php');
session_start();

function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	global $live, $contact_email;
	$message = "Error se dogodio u skripti '$e_file' na liniji $e_line:\n$e_message\n";
	$message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";
	if (!$live) { 
		echo '<div class="error">' . nl2br($message) . '</div>';
    } else { 
         error_log ($message, 1, $contact_email, 'From:system0@net.hr');
		
		if ($e_number != E_NOTICE) {
			echo '<div class="error">Dogodio se sistemski error.</div>';
		}
	} 
	return true; 
} 
set_error_handler ('my_error_handler');

function redirect_invalid_user($check = 'user_id', $destination = 'index.php', $protocol = 'http://') {
	if (!isset($_SESSION[$check])) {
		$url = $protocol . BASE_URL . $destination; 
		header("Location: $url");
		exit(); 
	}
	
} 