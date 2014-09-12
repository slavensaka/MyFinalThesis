<?php

require ('./includes/config.inc.php');
$page_title = 'Registracija';
include ('./includes/header.html');
require (MYSQL);
$reg_errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $_POST['first_name'])) {
		$fn = mysqli_real_escape_string ($dbc, $_POST['first_name']);
	} else {
		$reg_errors['first_name'] = 'Molim vas unesite svoje ime!';
	}

	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['last_name'])) {
		$ln = mysqli_real_escape_string ($dbc, $_POST['last_name']);
	} else {
		$reg_errors['last_name'] = 'Molim vas unesite svoje prezime!';
	}

	if (preg_match ('/^[A-Z0-9]{2,30}$/i', $_POST['username'])) {
		$u = mysqli_real_escape_string ($dbc, $_POST['username']);
	} else {
		$reg_errors['username'] = 'Molim unesite zeljeni nadimak!';
	}

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		$reg_errors['email'] = 'Molim unesite valjanu email adresu!';
	}

	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			$reg_errors['pass2'] = 'Vasa zaporka nije jednaka prihvacenoj zaporci!';
		}
	} else {
		$reg_errors['pass1'] = 'Molim unesite zaporku!';
	}
	
	if (empty($reg_errors)) { 

		$q = "SELECT email, username FROM users WHERE email='$e' OR username='$u'";
		$r = mysqli_query ($dbc, $q);

		$rows = mysqli_num_rows($r);
		
		if ($rows == 0) { 

			$q = "INSERT INTO users (username, email, pass, first_name, last_name) VALUES ('$u', '$e', '"  .  get_password_hash($p) .  "', '$fn', '$ln')";
			
			$r = mysqli_query ($dbc, $q);

			
			$concat = $fn." ".$ln;
			$z = "INSERT INTO db_cart_example_customer( name, email) VALUES('$concat', '$e')";
			$w = mysqli_query($dbc,$z);
			
			 
	
				$uid = mysqli_insert_id($dbc);

				echo '<h3>Zdravo</h3><p>Hvala vam na registraciji, ako zelite nastaviti ulogirajte se na desnoj strani sa 
			             vasim korisnickim racunom
				</p>';

				echo 'Nadam se da ce vam se svidjeti ova stranica';
						
				// Mail poslan korisniku kada se registrira
				//$body = "Hvala vam na vasoj registraciji na nasoj stranici.";
				//mail($_POST['email'], 'Registracija potvrdena', $body, 'From: system0@net.hr');
				
				include ('./includes/footer.html');
				exit();
		
		} else { 
			
			if ($rows == 2) {
				                          
				$reg_errors['email'] = 'Ova email adresa je vec bila registrirana. Ako ste zaboravili svoju zaporku, upotrijebite link desno da povratite svoju zaporku.';			
				$reg_errors['username'] = 'Vas nadimak je vec registriran. Molim pokusajte ponovno.';			
                                            
			} else { 

				
				$row = mysqli_fetch_array($r, MYSQLI_NUM);
									
				if( ($row[0] == $_POST['email']) && ($row[1] == $_POST['username'])) { // Both match.
				                             
					$reg_errors['email'] = 'Ova email adresa je vec registrirana. Ako ste zaboravili vasu zaporku, upotrijebite link desno da povratite svoju zaporku.';	
					$reg_errors['username'] = 'Vas nadimak je vec registriran. Ako ste zaboravili vasu zaporku, upotrijebite link desno da povratite vasu zaporku.';
				} elseif ($row[0] == $_POST['email']) { 
				                              
					$reg_errors['email'] = 'Ova email adresa je vec registrirana. Ako ste zaboravili vasu zaporku, upotrijebite link na desno da povratite vasu zaporku..';						
				} elseif ($row[1] == $_POST['username']) { 
					$reg_errors['username'] = 'Ovaj nadimak je vec registriran. Molim unesite novi.';			
				}
					                            
			} 
			
		} 
		
	} 

} 

require ('./includes/form_functions.inc.php');
?>

<h3>Registracija</h3>

<p>Samo registrirani korisnici mogu kupovati na ovoj stranici. Upotrijebite obrazac dolje da pocnete registracijski proces. <strong>Sva polja morate ispuniti</strong></p>
<form action="register.php" method="post" accept-charset="utf-8" style="padding-left:100px">

		<p><label for="first_name"><strong>Ime</strong></label><br /><?php create_form_input('first_name', 'text', $reg_errors); ?></p>
		
		<p><label for="last_name"><strong>Prezime</strong></label><br /><?php create_form_input('last_name', 'text', $reg_errors); ?></p>
		
		<p><label for="username"><strong>Nadimak</strong></label><br /><?php create_form_input('username', 'text', $reg_errors); ?> <small>Samo slova i brojevi su dopusteni.</small></p>
		
		<p><label for="email"><strong>Email adresa</strong></label><br /><?php create_form_input('email', 'text', $reg_errors); ?></p>
		
		<p><label for="pass1"><strong>Zaporka</strong></label><br /><?php create_form_input('pass1', 'password', $reg_errors); ?> <small>Mora biti 6 do 20 karaktera, sa barem jednim malim slovom, jednim velikim slovom, i jednim brojem.</small></p>
		<p><label for="pass2"><strong>Potvrdite zaporku</strong></label><br /><?php create_form_input('pass2', 'password', $reg_errors); ?></p>                

		<input type="submit" name="submit_button" value="Registriraj se &rarr;" id="submit_button" class="formbutton" />
	
</form>

<?php 
include ('./includes/footer.html');
?>