
<?php



require ('./includes/config.inc.php');
require (MYSQL);
require("stock.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$login_errors = array();
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	
} else {	$login_errors['email'] = 'Molimo unesite važeæu e-mail adresu!';
}
if (!empty($_POST['pass'])) {
	$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
} else {
	$login_errors['pass'] = 'Molimo unesite svoju lozinku!';
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
		$login_errors['login'] = 'E-pošte i zaporka se ne podudaraju sa nijednim u bazi podataka.';
	}	
} 
$o = "DELETE FROM current WHERE id=1";
$hi = mysqli_query($dbc,$o);

$z = "INSERT INTO current(email) VALUES('$e')";
$w = mysqli_query($dbc,$z);
}

include ('./includes/header.html');
$prod_conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME, $prod_conn);
?>
<?php

$query_new = "SELECT * FROM stock ORDER BY art_no";
$res_new = mysql_query($query_new);
$row_new = mysql_fetch_assoc($res_new);


$cust_sql = "SELECT id,email FROM current WHERE id = 1";
$cust_result = mysql_query($cust_sql) or die(mysql_error());
$cust = mysql_fetch_object($cust_result);
$_SESSION['custom_num'] = $cust->id;
$_SESSION['email'] = $cust->email;
mysql_free_result($cust_result);



$myCart = new db_stock_cart($_SESSION['custom_num']);



if (isset($_GET['add']) || isset($_GET['product'])) { 
	if ($myCart->check_against_stock($_GET['stock'], 1)) {
		$myCart->handle_cart_row($_GET['art_no'], $_GET['product'], 1, $_GET['price']);
	}
}
$num_rows = $myCart->get_number_of_records();

if (isset($_GET['action']) && $_GET['action'] == "checkout") {
	if ($num_rows > 0) {
		header("Location: ".CHECKOUT); 
	} else {
		$myCart->error = "Vasa kosarica je trenutno prazna!";
	}
}
?>
<h2>Dodavanje Proizvoda u kosaricu</h2>
<h4>Imate dvije opcije dodavanja u kosaricu<br><br>
a. pomocu paypal sucelja  <br>
b. preko stranice</h4>
<p style="color:#FF0000;font-weight:bold;margin:10px 0;"><?php echo $myCart->error; ?></p>
<table width="520" border="0" cellpadding="0" cellspacing="0"<?php echo (mysql_num_rows($res_new) < 5) ? " style=\"margin-bottom:90px;\"" : ""; ?>>
  <tr>
	<th width="150">Slika Knjige</th>
	<th width="300">Naslov</th>
	<th width="200">Cijena</th>
	<th width="0">Na Skladistu</th>
	
	<th style="text-align:center;">&nbsp;</th>
  </tr>
  <?php do { ?>
   <tr>
	<td align="center"><img src="<?php echo($row_new["pic"]); ?>" /><br /></td>
	<td align="center"><b><?php echo $row_new['art_descr']; ?></b></td><br/> 
	<td align="center"><b><?php echo $row_new['price']; ?> Kn</b></td>
	<td align="center"><b><?php echo $row_new['amount']; ?></b></td>
	
	
	<td align="center">
	  <form action="index.php" method="get" style="margin: 0;text-align:center;padding:0;">
	    <input type="hidden" name="stock" value="<?php echo $row_new['amount']; ?>">
        <input type="hidden" name="art_no" value="<?php echo $row_new['art_no']; ?>">
        <input type="hidden" name="product" value="<?php echo $row_new['art_descr']; ?>">
        <input type="hidden" name="price" value="<?php echo $row_new['price']; ?>">
        <input name="add" type="image"  value="submit" src="images/add2cart.gif" alt="Order!" width="100" height="22">
      </form><hr><b>Paypal</b>

<?php
	
	
	if($row_new['id'] == 1) {
	   echo '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="PJQDFPNXNNBSE">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
';
	
	}
	if($row_new['id'] == 2) {
	   echo '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="49E6SVG9WLWWN">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
';
	
	}
	
	if($row_new['id'] == 3) {
	   echo '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="RMDKCJEJ9677E">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
';
	
	}
	if($row_new['id'] == 4) {
	   echo '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="6Q7DKDWC8XRLA">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
';
	  }
	  
	 if($row_new['id'] == 5) {
	   echo '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BC7KZDTNUHEPL">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
';
	  }
	  
	?>
	</td>
  </tr>
  <?php 
  } while ($row_new = mysql_fetch_assoc($res_new)); 
  mysql_free_result($res_new);
  ?>
</table>
<h4>Trenutno imate <b><?php echo $num_rows; ?> jedinstvenih</b> knjiga u vasoj kosarici.</h4>
<br><br>
<?php if (isset($_SESSION['user_id'])) { ?>
	 
<p align="center"><a href="index.php?action=checkout"><img src="images/naplata.gif"></a></p>


<?php } elseif (!isset($_SESSION['user_id'])) {
		echo '<p class="error">Hvala vam na vasem interesu za ovaj sadrzaj, ali morate biti 
prijavljeni kao registrirani korisnik da mogli nastavi do vase kosarice.</p>';
	}
	
require ('./includes/footer.html');
?>