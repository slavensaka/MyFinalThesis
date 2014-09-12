<?php
require ('./includes/config.inc.php');
redirect_invalid_user('user_admin');
$page_title = 'dodavanje knjige';
include ('./includes/header.html');
require(MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	
	if (!empty($_POST['art_descr'])) {
	
		$t = mysqli_real_escape_string($dbc, strip_tags($_POST['art_descr']));
	} else {
		echo  ' Molim unesite naslov knjige!';
	}
	if (!empty($_POST['price'])) {
		$d = mysqli_real_escape_string($dbc, strip_tags($_POST['price']));
	} else {
		echo ' Molim unesite cijenu proizvoda!';
	}
	$descr=$_POST['art_descr'];
	$amount=$_POST['amount'];
	$price=$_POST['price'];
	$num=$_POST['art_no'];
	$pic=$_POST['pic'];
		
	
		$q = "INSERT INTO stock (art_descr, amount, price, art_no, pic) VALUES ('$descr', '$amount', '$price', '$num', '$pic')";
		$r = mysqli_query ($dbc, $q);
		
		if (mysqli_affected_rows($dbc) == 1) { 
			
			echo '<h4>Knjiga je dodana!</h4>';
							
		} else { 
			trigger_error('Knjige se nije mogla dodati zbog sistemskog errora.');

		}	
	}
 
require ('includes/form_functions.inc.php');
?>

        <h3>Dodajte knjigu u skladiste</h3>
<form enctype="multipart/form-data" action="add_book.php" method="post" accept-charset="utf-8">
	
	<fieldset><legend>Ispunite obrazac kako biste dodali knjigu na stranicu:</legend>	
	    
		<p><strong>Naslov Knjige</strong></label><br />
		<input type="text" name="art_descr" /><br/></p>
		<p><strong>Na skladistu kolicina</strong><br/>
		<input type="text" name="amount" /></p>
		<p><label for="price"><strong>Cijena knjige </strong></label><br />
		<input type="text" name="price" /><small> u kunama</small><br/></p>
		<p><strong>Serijski broj proizvoda (6 broja)</strong><br />
		<input type="text" name="art_no" /><br/></p>
		<p><label for="pic"><strong>Slika (sa nekog image hosting servera) </strong></label><br />
		<input type="text" name="pic"  /><small> jpeg, gif i bmp tip slika</small><br/></p>
	    <p><input type="submit" name="submit_button" value="Dodajte knjigu" id="submit_button" class="formbutton" /></p>	
	</fieldset>
</form> 

<?php 
include ('./includes/footer.html');
?>