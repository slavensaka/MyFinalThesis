<?php 
$login_errors = array();
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	
} else {	$login_errors['email'] = 'Molim da unesete ispravnu email adresu';
}
if (!empty($_POST['pass'])) {
	$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
} else {
	$login_errors['pass'] = 'Unesite svoju lozinku!';
}	
if (empty($login_errors)) {
	$q = "SELECT id, username, type FROM users WHERE(email='$e' AND pass='"  .  get_password_hash($p) .  "')";		
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) == 1) { 
		$row = mysqli_fetch_array ($r, MYSQLI_NUM); 				
		if ($row[2] == 'admin') {
			session_regenerate_id(true);
			$_SESSION['user_admin'] = true;
		}				
		$_SESSION['user_id'] = $row[0];
		$_SESSION['username'] = $row[1];		
				
	} else { 
		$login_errors['login'] = 'Email adresa i lozinka nisu pronadeni u nasoj bazi';
	}	
} 
if($_SERVER['REQUEST_URI'] == 'index.php') {
//echo 'HERE I AM';   Potrebno za debugiranje skripte 
   header("Location: index.php");
} 
if($_SERVER['REQUEST_URI'] == 'checkout.php'){
header("Location:checkout.php");
}