<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     include ('./includes/login.inc.php');
  }
require ('./includes/config.inc.php');
require (MYSQL);
include ('./includes/header.html');

if (isset($_SESSION['user_id'])) {
if(isset($_GET['kolicina'])) {
if($_GET['kolicina'] == 'Promijeni Kolicinu') {

$a_n = $_GET['art_no'];
$a = $_GET['amount'];
$s = "UPDATE stock SET amount='$a' WHERE art_no = '$a_n' "; 
$w = mysqli_query ($dbc, $s);
echo "<p>Nova kolicina je dodana za zadani serijski broj</p>";
 
     }
}
 
$q = "SELECT art_no,art_descr,amount FROM stock";
$r = mysqli_query ($dbc, $q);
		
		
while($o = mysqli_fetch_array($r)) {	?>
	<table>
      <tr>
        <th>Serijski broj</th>
        <th>Naslov knjige</th>
	    <th>Kolicina</th>
      </tr>		
      <tr>
        <td><?php echo $o['art_no']; ?></td>
	    <td><?php echo $o['art_descr']; ?></td>
	    <td align="right"><?php echo $o['amount']; ?></td>
	  </tr>
   </table>
 
 <? } ?>
 
 <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" accept-charset="utf-8">
	
	<fieldset>
	    <legend>Ispunite kako biste promijenili kolicinu knjige na skladistu:</legend>	
	    
		<p><strong>Serijski broj</strong></label><br />
		<input type="text" name="art_no" /><small>  trebamo serijski broj </small><br/></p>
		<p><strong>Nova kolicina na skladistu</strong><br/>
		<input type="text" name="amount" /><small>   upisite novu kolicinu</small></p>
	    <p><input type="submit" name="kolicina" value="Promijeni Kolicinu"  /></p>	
	</fieldset>
</form> 
 
 
<?
} elseif (!isset($_SESSION['user_id'])) {
		echo '<p class="error">Hvala vam na vasem interesu za ovaj sadrzaj, ali morate biti 
              prijavljeni kao registrirani korisnik da mogli nastaviti.</p>';
}

require ('./includes/footer.html');
?>