<?php 
// db connection
if (!defined("DB_SERVER")) define("DB_SERVER", "localhost");
if (!defined("DB_NAME")) define("DB_NAME", "baza");
if (!defined("DB_USER")) define ("DB_USER", "root");
if (!defined("DB_PASSWORD")) define ("DB_PASSWORD", "sys");

// db tables 
define("ORDERS", "orders");
define("ORDER_ROWS", "rows");
define("SHIP_ADDRESS", "shipment");

// cart "globals"
define("CURRENCY", "Kn"); //  "€", "$", "£" or "¥"
define("INCL_VAT", false);
define("VAT_VALUE", 0); 
define("SITE_MASTER", "Web Sucelje"); 
define("SITE_MASTER_MAIL", "system0@net.hr");
define("MAIL_ENCODING", "iso-8859-1"); 
define("DATE_FORMAT", "d-m-Y");
define("RECOVER_ORDER", false); 
define("VALID_UNTIL", 7 * 86400); 


$use_stock = true;

	$catalog = "index.php";
	$checkput = "checkout.php";
	$confirm = "confirm.php";


define("PROD_IDX", $catalog); 
define("CHECKOUT", $checkput);
define("CONFIRM", $confirm); 
?>