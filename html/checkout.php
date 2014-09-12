<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include ('./includes/login.inc.php');
}
include ('./includes/header.html');
require("stock.php");

function create_form_field($formelement, $label = "", $db_value = "", $length = 25) {
    $form_field = ($label != "") ? "<label for=\"".$formelement."\">".$label."</label>\n" : "";
    $form_field .= "  <input name=\"".$formelement."\" type=\"text\" size=\"".$length."\" value=\"";
    if (isset($_REQUEST[$formelement])) {
        $form_field .= $_REQUEST[$formelement];
    } elseif (isset($db_value) && !isset($_REQUEST[$formelement])) {
        $form_field .= $db_value;
    } else {
        $form_field .= "";
    }
    $form_field .= "\">\n";
    return $form_field;
}

function create_text_area($formelement, $label = "", $db_value = "", $rows = 5, $cols = 20) {
    $form_field = ($label != "") ? "  <label for=\"".$formelement."\">".$label."</label>\n" : "";
    $form_field .= "  <textarea name=\"".$formelement."\" cols=\"".$cols."\" rows=\"".$rows."\">";
    if (isset($_REQUEST[$formelement])) {
        $form_field .= $_REQUEST[$formelement];
    } elseif (isset($db_value) && !isset($_REQUEST[$formelement])) {
        $form_field .= $db_value;
    } else {
        $form_field .= "";
    }
    $form_field .= "</textarea>\n";
    return $form_field;
}

$cust_no = $_SESSION['custom_num'];

$cust_email = $_SESSION['email'];
// echo $cust_email;  Za debugiranje - trazenje gresaka


$myCheckout = new db_stock_cart($_SESSION['custom_num']);


if (isset($_GET['action']) && $_GET['action'] == "cancel") {
	$myCheckout->cancel_order();
}

if (isset($_GET['add']) && $_GET['add'] == "Update") { 
	if ($myCheckout->check_against_stock($_GET['stock'], $_GET['quantity'])) {
		$myCheckout->update_row($_GET['row_id'], $_GET['quantity']);
	}
}

if (isset($_GET['submit'])) {


	$myCheckout->update_shipment($_GET['address'], $_GET['postal_code'], $_GET['place'], $_GET['country']);
	if ($_GET['submit'] == "Order now!") {
		
		$address = $_GET['address'] ;
		$postal_code = $_GET['postal_code'];
		$place = $_GET['place'];
		$country = $_GET['country'];
		//echo 'tekst';      Za debugiranje - trazenje gresaka
	$sql = sprintf("UPDATE users SET address = '$address', postal_code = '$postal_code', 
                    place = '$place', country = '$country'  WHERE order_id = %s ", $_SESSION['order_id'] );
			$q= mysql_query($sql);
			
header( "Location:delivery.php" );
 
		
		
		
	} 
}



if (!$myCheckout->check_return_shipment()) {

	$cust_conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
	mysql_select_db(DB_NAME, $cust_conn);
	
	$cust_sql = sprintf("SELECT * FROM users,current WHERE current.email=users.email");
	$cust_result = mysql_query($cust_sql) or die(mysql_error());
	$cust_obj = mysql_fetch_object($cust_result);
	$myCheckout->username = $cust_obj->username;
	$myCheckout->email = $cust_obj->email;
	$myCheckout->first_name = $cust_obj->first_name;
	$myCheckout->last_name = $cust_obj->last_name;
	
	mysql_free_result($cust_result);
	$myCheckout->insert_new_shipment();		
} else {
	$myCheckout->set_shipment_data();
}

$myCheckout->show_ordered_rows();
$search_in = $myCheckout->get_order_num_string();

$query_stock = sprintf("SELECT art_no, amount AS on_stock FROM stock WHERE art_no IN (%s) ORDER BY art_no", $search_in);
$res_stock = mysql_query($query_stock);
if(mysql_fetch_assoc($res_stock)) {
while ($stock = mysql_fetch_assoc($res_stock)) {
	$stock_array[$stock['art_no']] = $stock['on_stock'];
}} else {
   header("Location:index.php"); 
}
if (isset($_SESSION['user_id'])) {
		
?>

<h2>Pregled Vase Kosarice </h2>
<h4>Azurirajte svoju narudzbu ili nastavite kupovati.</h4>
<p style="color:#FF0000;font-weight:bold;margin:10px 0;"><?php echo $myCheckout->error; ?></p>
<?php if ($myCheckout->get_number_of_records() > 0) { ?>
<h3 style="width:480px;"><span style="float:right;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=cancel">Ponistiti sve!</a></span>Vasa Kosarica:</h3>
<table>
  <tr>
    <th width="100">Serijski broj</th>
    <th width="300">Naslov knjige</th>
	<th width="75">Cijena</th>
    <th width="75">Kolicina</th>
	<th>Azuriranje</th>
  </tr>
  <?php foreach ($myCheckout->order_array as $val) { ?>
  <tr>
    <td align="center"><?php echo $val['product_id']; ?></td>
	<td align="center"><?php echo $val['product_name']; ?></td>
	<td align="center"><?php echo $myCheckout->format_value($val['price']); ?></td>
	<td align="center"><?php echo $myCheckout->format_value($val['price'] * $val['quantity']); ?></td>

	
<? //echo $_SESSION['order_id'];  Za debugiranje - trazenje gresaka ?>
	
	
	
	
	<td>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
	    <input type="hidden" name="row_id" value="<?php echo $val['id']; ?>">
		<input type="hidden" name="stock" value="<?php echo $stock_array[$val['product_id']]; ?>">
	    <input type="text" name="quantity" size="5" value="<?php echo $val['quantity']; ?>">
	    <input  type="submit" name="add" value="Update">
      </form>
	</td>
  </tr>
  <?php } // end foreach p ?>
</table>
<h3>&nbsp; Ukupna vrijednost ove kosarice: <b><?php echo $myCheckout->format_value($myCheckout->show_total_value()); ?></b></h3><br>

<h4>Kopija ove narudzbe ce biti poslana na email adresu: <b><?php echo $cust_email; ?></b></h4><hr>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" style="width:480px;">
  <?php

$items = mysql_query("SELECT * FROM users,current WHERE current.email=users.email");
if($item = mysql_fetch_array($items))
	{
  
  
  
  
  
  $its=$_SESSION['order_id']; 
  $i = mysql_query("SELECT * FROM users WHERE users.order_id = '$its'");
  
  $it = mysql_fetch_array($i);
  
  if( $it['address'] === 'NON' || $it['address'] ==='' ) {
  ?>
  
  
   
 <?
  echo 'Ispunite potrebne podatke:<br><br>';
  echo create_form_field("first_name", "Ime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;", $item['first_name'], 30)."<br><br>";
  echo create_form_field("last_name", "Prezime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $item['last_name'], 30)."<br><br>";
  echo create_form_field("email", "Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $item['email'], 30)."<br><br>";
  echo create_form_field("username", "Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$item['username'])."<br><br>";
  echo create_form_field("address", "Adresa:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" )."<br><br>";
  echo create_form_field("postal_code", "Postanski broj:")."<br><br>";
  echo create_form_field("place", "Grad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")."<br><br>";
  echo create_form_field("country", "Drzava:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","Hrvatska")."<br><br>";
 ?><p>
  <input type="hidden" name="order_id" value=<?php echo($_SESSION['order_id']); ?>" />
 
  <input type="submit" name="submit" value="Order now!">
  </p>
</form>
<?php
} else {
   ?>
   
   
  
   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" style="width:480px;"> 
   <?  echo '<br><h4>Vase podatke za kupovinu vec imamo, mozete nastaviti. </h4> <br><br> '; ?>
   <input type="hidden" name="first_name" value="<?php echo($item["first_name"]); ?>" />
   <input type="hidden" name="last_name" value="<?php echo($item["last_name"]); ?>" />
   <input type="hidden" name="email" value="<?php echo($item["email"]); ?>" />
   <input type="hidden" name="username" value="<?php echo($item["username"]); ?>" />
   <input type="hidden" name="address" value="<?php echo($item["address"]); ?>" />
   <input type="hidden" name="postal_code" value="<?php echo($item["postal_code"]); ?>" />
   <input type="hidden" name="place" value="<?php echo($item["place"]); ?>" />
   <input type="hidden" name="country" value="<?php echo($item["country"]); ?>" />
   <input type="hidden" name="order_id" value=<?php echo($_SESSION['order_id']); ?>" />
   <p><input type="submit" name="submit" value="Order now!"></p>
   </form>
   
   
   <?
   
  }
 ?> <form action="index.php">
   <input type="submit" name="submit" value="&lt;&lt; Nastavite kupovati!">
   </form>
 <? }
  
?>
  








<?php } // end if cart nije prazan ?>
</body>
</html>



<?php
mysql_free_result($res_stock);
} elseif (!isset($_SESSION['user_id'])) {
		echo '<p class="error">Hvala vam na vasem interesu za ovaj sadrzaj, ali morate biti 
              prijavljeni kao registrirani korisnik da mogli nastaviti.</p>';
	}
require ('./includes/config1.inc.php');
require (MYSQL);
require ('./includes/footer.html');
?>
