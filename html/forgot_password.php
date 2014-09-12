<?php

require ('./includes/config.inc.php');
$page_title = 'Zaboravili ste vasu zaporku?';
include ('./includes/header.html');
require (MYSQL);
$pass_errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

		$q = 'SELECT id FROM users WHERE email="'.  mysqli_real_escape_string ($dbc, $_POST['email']) . '"';
		$r = mysqli_query ($dbc, $q);
		
		if (mysqli_num_rows($r) == 1) { 
			list($uid) = mysqli_fetch_array ($r, MYSQLI_NUM); 
		} else { 
			$pass_errors['email'] = 'Zadana email adresa ne slaze sa onim u arhivi!';
		}		
	} else { 
		$pass_errors['email'] = 'Molim unesite vazecu email adresu!';
	} 
	if (empty($pass_errors)) { 

		$p = substr(md5(uniqid(rand(), true)), 15, 15);
		$q = "UPDATE users SET pass='" .  get_password_hash($p) . "' WHERE id=$uid LIMIT 1";
		$r = mysqli_query ($dbc, $q);
		
		if (mysqli_affected_rows($dbc) == 1) { 
			$body = "Vasa sifra za logiranje na web sucelje za prodaju je privremeno promjenjena '$p'. 
			Molim da se logirate pomocu te zaporke i ove email adrese. Tada mozete promjeniti vasu sifru
			na nesto poznatije.";
			mail ($_POST['email'], 'Vasa privremena lozinka.', $body, 'From: system0@net.hr');
			echo '<h3>Vasa sifra je promjenjena.</h3><p>Primit cete novu, privremenu 
			zaporku emailom. Nakon sto ste se logirali sa novom sifrom, mozete ju promjeniti.</p>';
			include ('./includes/footer.html');
			exit();
		} else { 	
			trigger_error('Vasa zaporka se nije mogla promjeniti zbog sistemskog errora.'); 
		}
	} 
} 
require ('./includes/form_functions.inc.php');
?>

    <h3>Promjena vase lozinke</h3>
    <p>Unesite svoju email adresu, pa cemo resetirati vasu lozinku.</p> 
<form action="forgot_password.php" method="post" accept-charset="utf-8">
	<p><label for="email"><strong>Email Adresa</strong></label><br />
	<?php create_form_input('email', 'text', $pass_errors); ?></p>
	<input type="submit" name="submit_button" value="Reset &rarr;" id="submit_button" class="formbutton" />
</form>

<?php 
include ('./includes/footer.html');
?>