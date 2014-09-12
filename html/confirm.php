<?php 
require("stock.php");


include ('./includes/header.html');
define ('BASE_URI', 'C:/xampp/htdocs/zavrsni_rad/');
define ('BASE_URL', 'localhost/zavrsni_rad/html/');
define ('PDFS_DIR', BASE_URI . 'pdfs/'); 
define ('MYSQL', BASE_URI . 'mysql.inc.php');
error_reporting(0);
require (MYSQL);
$termin=$_POST['order_params']['delivery_term_id'] ;
if($_SESSION['order_id']) {
$order_id=$_SESSION['order_id'];
$q = "INSERT INTO delivery(order_id,time) VALUES ('$order_id','$termin')";
$r = mysqli_query ($dbc, $q);
} 

$myConfirm = new db_stock_cart($_SESSION['custom_num']);

?>

<h2>
Narudzba ce biti poslana korisniku:</h2>
<p>
<?php

$items = mysql_query("SELECT * FROM users,current WHERE current.email=users.email");
if($item = mysql_fetch_array($items))
	{
	echo '<br/>';
	echo '<b><i>'.$item['first_name'].' '.$item['last_name'].'</b></i>';
	echo '<b><br>Na Adresu:</b><i>'.' '.$item['address'].'</i>';
	echo '<b><br>Termin Dostave:</b> '; 
    $sys=$_POST['order_params']['delivery_term_id'] ;
    echo '<i>'.$sys.'</i>';
	echo '<b><br>Mjesto:</b><i> '.$item['place'].', '.$item['country'].'</i>';
	echo '<br/>';
	echo '<b>Postanski broj:</b><i> '.$item['postal_code'].'</i>';
	echo '<br/>';
	echo '<b>Email:</b><i> '.$item['email'].'</i>';
	
	echo '<br/>';
	echo '<b>Username:</b><i> '.$item['username'].'</i>';
	echo '<br/>';
	echo '<b>Order Id:</b><i> '.$item['order_id'].'<small></i>  <b>(id vase naruzbe)</b></small>';
	echo '<br/>';
	echo '<br/>';
 
	



?>

</p>
<?php echo ($myConfirm->ship_msg != "") ? "<p><b>The message:</b><br>".nl2br($myConfirm->ship_msg)."</p>" : ""; ?>
<!--<p><a href="./<?php// echo PROD_IDX; ?>"> <img src="kupovati.gif"> </a></p>
-->
 
 <form action="payment.php" method="get" >

        <input type="hidden" name="order_id" value="<?php echo $item['order_id']; ?>">
      
       <input name="" type="submit"  value="Dalje">
      </form>


</body>
</html>

<?

}
require ('./includes/footer.html');
?>