<?php

require ('./includes/config.inc.php');
require (MYSQL);
$o_i= $_SESSION['order_id'];
$z = "UPDATE orders SET open = 'n' WHERE id = '$o_i'"; // uz delete dolje nije potrebno imate ovo, ali je dobro za nadogradnju
$w = mysqli_query($dbc,$z);
$b = "DELETE FROM orders WHERE id = '$o_i'";  // izbrisemo narudzbu korisnika kada se izlogira
$z = mysqli_query($dbc,$b);
redirect_invalid_user();
$_SESSION = array(); 
session_destroy();  // Unistimo sessiu
setcookie (session_name(), '', time()-300); // unisti cookie 
header("Location: index.php"); // posalji na prvu stranicu

?>