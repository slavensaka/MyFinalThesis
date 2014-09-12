<?php
require("stock.php");
require ('./includes/config1.inc.php');
require (MYSQL);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include ('./includes/login.inc.php');
}
include ('./includes/header.html');

if (isset($_SESSION['user_id'])) {

if(isset($_GET['kraj'])){
if($_GET['kraj'] == 'Zavrsite') {


?>

 <? } 
 }


 $myConfirm = new db_stock_cart($_SESSION['custom_num']);

if ($myConfirm->get_number_of_records() == 0) header("Location: ".PROD_IDX); // uputi korisnika nazad ako vise nema narudbi

$myConfirm->show_ordered_rows();

$myConfirm->set_shipment_data();


$sql_errors = 0;
foreach ($myConfirm->order_array as $val) {
	$update_stock = sprintf("UPDATE stock SET amount = amount - %d, last_buy = NOW() WHERE art_no = '%s'", $val['quantity'], $val['product_id']);
	if (!mysql_query($update_stock)) {
		$sql_errors++;
	}
}
if ($sql_errors == 0) {
	$myConfirm->close_order();
} else {
	$myConfirm->error = $myConfirm->messages(1);
}
?>
 
<h2>Vasa Narudzba </h2>
<p>Mozete vidjeti svoje podatke i kolicinu knjiga koje ste narucili.</p>
<p style="color:#FF0000;font-weight:bold;margin:10px 0;"><?php echo $myConfirm->error; ?></p>

<table>
  <tr>
    <th width="100">Serijski broj</th>
    <th width="300">Naslov Knjige</th>
	<th width="75">Kolicina</th>
	<th width="75">Cijena</th>
	<th width="75">Iznos</th>
  </tr>
  <?php foreach ($myConfirm->order_array as $val) { ?>
  <tr>
    <td><?php echo $val['product_id']; ?></td>
	<td><?php echo $val['product_name']; ?></td>
	<td align="center"><?php echo $val['quantity']; ?></td>
	<td align="right"><?php echo $myConfirm->format_value($val['price']); ?></td>
	<td align="right"><?php echo $myConfirm->format_value($val['price'] * $val['quantity']); ?></td>
  </tr>
  <?php } // end foreach loop ?>
</table>
 
 
 
 <h4>Narudzba ce biti poslana korisniku:</h4>
<p>
<?php

$items = mysql_query("SELECT * FROM users,current WHERE current.email=users.email");
if($item = mysql_fetch_array($items))
	{
	
	
	
	

	
	
	
	
	
	
	echo '<br/>';
	echo '<b>Adresa:</b><i> '.$item['address'].'</i>';
	
	echo '<br/>';
	echo '<b>Ime:</b><i> '.$item['first_name'].'</i>';
	
	echo '<br/>';
	echo '<b>Prezime:</b><i> '.$item['last_name'].'</i>';
	
	echo '<br/>';
	echo '<b>Grad:</b><i> '.$item['place'].'</i>';
	
	echo '<br/>';
	echo '<b>Drzava:</b><i> '.$item['country'].'</i>';
	
	echo '<br/>';
	echo '<b>Email:</b><i> '.$item['email'].'</i>';
	
	echo '<br/>';
	echo '<b>Username:</b><i> '.$item['username'].'</i>';
	
	echo '<br/>';
	echo '<b>Postanski broj:</b><i> '.$item['postal_code'].'</i>';
	
	echo '<br/>';
	echo '<b>Order Id:</b><i> '.$item['order_id'].'</i>';
	
	echo '<br/>';
	}
	$o = $_GET['order_id'];
 $i1 = mysql_query("SELECT * FROM delivery,orders,payment WHERE delivery.order_id='$o' AND orders.id='$o' AND payment.order_id='$o'");

if($item = mysql_fetch_array($i1)) {

	echo '<b>Nacin i vrijeme dostave:</b><i> '.$item['time'].'</i>';
	echo '<br/>';
	
	echo '<b>Vrijeme primanja narudzbe:</b><i> '.$item['processed_on'].'</i>';
	echo '<br/>';
	
	echo '<b>Nacin placanja:</b><i> '.$item['tip'].'</i>';
	echo '<br/>';
	
	if($item['broj']){
	echo '<hr><b>Vrsta kartice:</b><i> '.$item['kartica'].'</i>';
	echo '<br/>';

	echo '<b>Broj kartice:</b><i> '.$item['broj'].'</i>';
	echo '<br/>';

	echo '<b>Kontrolni broj:</b><i> '.$item['kontr_br'].'</i>';
	echo '<br/>';

	echo '<b>Vrijeme Isteka Vase Kartice:</b><i> '.$item['mjesec_isteka'].' Mjeseca : '.'20'.$item['godina_isteka'].' Godine</i>';
	echo '<br/>';



	echo '<br/><hr><br>';
	
	} else { 
	echo '<hr><br><b>Nacin placanja:</b><i> '.$item['placanje'].'</i>';
	
	echo '<br/><br><hr><br>';
}

 
 
 }


?>



 <form action="index.php">
   <input type="submit" name="submit" value="&lt;&lt; Nastavite kupovati!">
   </form>






<?
} elseif (!isset($_SESSION['user_id'])) {
		echo '<p class="error">Hvala vam na vasem interesu za ovaj sadrzaj, ali morate biti 
              prijavljeni kao registrirani korisnik da mogli nastaviti.</p>';
	}

require ('./includes/footer.html');
?>