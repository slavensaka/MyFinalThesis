<?php

require ('./includes/config.inc.php');

redirect_invalid_user();

$page_title = 'Promijenite vasu lozinku';
include ('./includes/header.html');

require (MYSQL);

$pass_errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['current'])) {
		$current = mysqli_real_escape_string ($dbc, $_POST['current']);
	} else {
		$pass_errors['current'] = 'Molim vas unesite svoju lozinku!';
	}
	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			$pass_errors['pass2'] = 'Vasa lozinka nije nadena u bazi podataka!';
		}
	} else {
		$pass_errors['pass1'] = 'Molim unesite ispravnu lozinku!';
	}
	
	if (empty($pass_errors)) { 
		$q = "SELECT id FROM users WHERE pass='"  .  get_password_hash($current) .  "' AND id={$_SESSION['user_id']}";	
		$r = mysqli_query ($dbc, $q);
		if (mysqli_num_rows($r) == 1) { 
			$q = "UPDATE users SET pass='"  .  get_password_hash($p) .  "' WHERE id={$_SESSION['user_id']} LIMIT 1";	
			if ($r = mysqli_query ($dbc, $q)) { 
				echo '<h3>Vasa lozinka je promjenjena.</h3>';
				include ('./includes/footer.html');
				exit();

			} else { 

				trigger_error('Vasa lozinka nije mogli biti promjenjena zbog sistemskog errora.'); 

			}

		} else {
			
			$pass_errors['current'] = 'Vasa trenutna lozinka je netocna';
			
		} 

	} 
	
} 


require ('./includes/form_functions.inc.php');
?><h3>Promijenite vasu lozinku</h3>
<p>Upotrijebite obrazac ispod da promjenite svoju lozinku.</p>
<form action="change_password.php" method="post" accept-charset="utf-8">
	<p><label for="pass1"><strong>Trenutna lozinka</strong></label><br /><?php create_form_input('current', 'password', $pass_errors); ?></p>
	<p><label for="pass1"><strong>Nova lozinka</strong></label><br /><?php create_form_input('pass1', 'password', $pass_errors); ?> <small>Mora biti izmedu 6 do 20 karaktera dugacka, sa barem jednim malim slovom, jednim velikim slovom, i jednim brojem.</small></p>
	<p><label for="pass2"><strong>Potvrdite novu lozinku</strong></label><br /><?php create_form_input('pass2', 'password', $pass_errors); ?></p>
	<input type="submit" name="submit_button" value="Change &rarr;" id="submit_button" class="formbutton" />
</form>

<?php 
include ('./includes/footer.html');
?>