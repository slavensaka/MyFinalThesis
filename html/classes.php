<?php
// klasa preko koje je raðen zavrsni rad 
// potrebne funkcije za e-prodaju, sucelje za prodaju
require("config.php");
if (!session_id()) session_start();
error_reporting(E_ALL);
class db_cart {
	
	var $error;
	var $customer;
	var $curr_product;
	
	var $ship_id;
	var $ship_name;
	var $ship_address;
	var $ship_pc;
	var $ship_city;
	var $ship_country; 
	var $ship_msg;
	
	var $order_array = array();
	
	
	// constructor ...
	function db_cart($customer_no = 0) {
		$conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME, $conn);
		$this->error = "&nbsp;";
		if (!isset($_SESSION['order_id'])) {
			$this->get_order($customer_no);
			$this->remove_old_orders(true);
		}
	}
	
	function messages($number) {
		$msg = array();

		$msg[1] = "Nepoznati error u bazi podataka.";
		$msg[2] = "Nepoznati aplikacijski error.";
		$msg[1] = "Nepoznati error u bazi, ali je narudzba poslana preko emaila.";
		
		            
		$msg[11] = "Knjiga je dodana u vasu kosaricu.";
		$msg[12] = "Azuriran je narudzbeni niz u vasoj kosarici.";
		$msg[13] = "Ne moze se dodat/azurirat vrijednost.";
		$msg[14] = "Dodaj neku knjgu u vasu kosaricu...";
		$msg[15] = "Uklonjeno je narudzbeni niz iz vase kosarice.";
		
		              
		$msg[21] = "Isporuka adresa je uspjesno izmjenjena.";
		$msg[22] = "Vasa narudzba je procesirana, kopija narudzbe ce biti poslana na vas email.";		
		
		$msg[51] = "Narudzba postana via ".$_SERVER['HTTP_HOST']." na ".date(DATE_FORMAT);
		$msg[52] = "Pozdrav,\r\n\r\n narucili se ovaj proizvod:\r\n\r\n";
		$msg[53] = "\r\nPotpuna kolicina je: ".$this->format_value($this->show_total_value(), false);
		$msg[53] .= (INCL_VAT) ? " (incl. VAT)" : "";
		
		$msg[55] = "\r\n\r\n_______________________________________\r\nkind regards\r\n".SITE_MASTER."\r\n\r\n";
		
		$msg[56] = sprintf("\t%-10s  %-30s  %-20s  %-12s\r\n", "Quantity", "Description", "Art. no.", "Single price"); 
		$msg[57] = "Narudzba poslana / narucena od:\r\n";
		$msg[57] .= $this->ship_name."\r\n".$this->ship_address."\r\n".$this->ship_pc." ".$this->ship_city."\r\n".$this->ship_country;
		$msg[58] = ($this->ship_msg != "") ? "\r\n\r\nMessage:\r\n".$this->ship_msg."\r\n" : ""; 
		return $msg[$number];
	}
	
	function send_admin_mail() {
	  
	}
	
	function remove_old_orders($remove_only_zeros = true) {
		if (RECOVER_ORDER) {
			$sql = sprintf("DELETE FROM %s WHERE open = 'y' AND  order_date < (NOW() - %d)", ORDERS, VALID_UNTIL * 86400);
		} 
	}
	
	function get_order($customer) {
		$sql_check = sprintf("SELECT id FROM %s WHERE customer = %d AND open = 'y'", ORDERS, $customer);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $customer != 0) {
				$_SESSION['order_id'] = mysql_result($res_check, 0, "id");
			} else {
				$sql_new = sprintf("INSERT INTO %s (customer, order_date) VALUES (%d, NOW())", ORDERS, $customer);
				if (mysql_query($sql_new)) {
					$_SESSION['order_id'] = mysql_insert_id(); 
				} else {
					$this->error = $this->messages(1);
				}
			}
		} else {
			$this->error = $this->messages(1);
		}
	}
	
	function check_existing_row($product) {
		$sql = sprintf("SELECT id FROM %s WHERE order_id = %d AND product_id = '%s'", ORDER_ROWS, $_SESSION['order_id'], $product);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) == 1) {
				$this->curr_product = mysql_result($result, 0, "id");
				return "old";
			} else {
				return "new";
			}
		} else {
			return "error";
		}	
	}
	
	function insert_row($prod_id, $prod_name, $quantity, $price, $vat_amount = VAT_VALUE) {
		$sql = sprintf("INSERT INTO %s (order_id, product_id, product_name, price, quantity) VALUES (%d, '%s', '%s', %f, %d)", ORDER_ROWS, $_SESSION['order_id'], $prod_id, $prod_name, $price, $quantity);
		if (mysql_query($sql)) {
			$this->error = $this->messages(11);
		} else {
			$this->error = $this->messages(1);
		}	
	}
	
	function update_row($row_id, $quantity, $replace = "yes") {
		if ($quantity == 0) {
			$this->delete_row($row_id);
		} else {
			$new_quant = ($replace == "no") ? "quantity + ".$quantity : $quantity;
			$sql = sprintf("UPDATE %s SET quantity = %s WHERE id = %d AND order_id = %d", ORDER_ROWS, $new_quant, $row_id, $_SESSION['order_id']);
			if (mysql_query($sql)) {
				$this->error = $this->messages(12);
			} else {
				$this->error = $this->messages(1);
			}
		}
	}
	
	function delete_row($row_id) {
		$sql = sprintf("DELETE FROM %s WHERE id = %d AND order_id = %d", ORDER_ROWS, $row_id, $_SESSION['order_id']);
		if (mysql_query($sql)) {
			$this->error = $this->messages(15);
		} else {
			$this->error = $this->messages(1);
		}	
	}
	
	function handle_cart_row($prod_id, $prod_name, $quantity, $price, $replace = "no", $vat_amount = VAT_VALUE) {
		$check_row = $this->check_existing_row($prod_id);
		if ($check_row == "old") {
			$this->update_row($this->curr_product, $quantity, $replace);
		} elseif ($check_row == "new") {
			$this->insert_row($prod_id, $prod_name, $quantity, $price, $vat_amount);
		} else {
			$this->error = $this->messages(13);
		}
	}
	
	function get_number_of_records() {
		$sql = sprintf("SELECT COUNT(*) AS num FROM %s AS r, %s AS ord WHERE ord.id = r.order_id AND ord.id = %d AND ord.open = 'y'", ORDER_ROWS, ORDERS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			return mysql_result($result, 0, "num");
		} else {
			$this->error = $this->messages(1);
			return;
		}
	}
	
	function show_ordered_rows() {
		$sql = sprintf("SELECT r.id, r.product_id, r.product_name, r.price, r.vat_perc, r.quantity FROM %s AS r, %s AS ord WHERE ord.id = r.order_id AND ord.id = %d AND ord.open = 'y'", ORDER_ROWS, ORDERS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->order_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
	}
	
	function show_total_value() {
		$sql = sprintf("SELECT SUM(quantity * price) AS total FROM %s WHERE order_id = %d", ORDER_ROWS, $_SESSION['order_id']);
		if (!$result = mysql_query($sql)) {
			$this->error = $this->messages(1);
			return;
		} else {
			$total_amount = mysql_result($result, 0, "total");
			mysql_free_result($result);
			return $total_amount;
		}
	}
	
	
	function check_return_shipment() {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE order_id = %d", SHIP_ADDRESS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			if (mysql_result($result, 0, "test") == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			$this->error = $this->messages(1);
			return false; 
		}
	}
	
	function set_shipment_data() {
		if (!$this->check_return_shipment()) { 
			$this->insert_new_shipment();
		}
		$sql = sprintf("SELECT * FROM %s WHERE order_id = %d", SHIP_ADDRESS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			$obj = mysql_fetch_object($result);
			$this->username = $obj->username;
			$this->email = $obj->email;
			$this->first_name = $obj->first_name;
			$this->last_name= $obj->last_name;
		
		} else {
			$this->error = $this->messages(1);
		}
	}
	
	function insert_new_shipment() {
		$sql = sprintf("INSERT INTO %s (order_id, username, email, first_name, last_name) VALUES (%d, %s, %s, %s, %s)",
			SHIP_ADDRESS, 
			$_SESSION['order_id'],
			$this->prepare_string_value($this->username), 
			$this->prepare_string_value($this->email), 
			$this->prepare_string_value($this->first_name), 
			$this->prepare_string_value($this->last_name) 
			);
		
$sys1 = mysql_query("SELECT email FROM current WHERE id=1");
if($q = mysql_fetch_array($sys1)) {

$email1 = $q["email"];

		
		$sys = sprintf("UPDATE users SET order_id = %d WHERE users.email ='$email1' ", $_SESSION['order_id']);		
		
		$q = mysql_query($sys);
              
		if (!mysql_query($sql)) {
			$this->error = $this->messages(1);
		}
	}
}
	
	function update_shipment($address, $postal_code, $place, $country) {
		
			$sql = sprintf("INSERT INTO users VALUES  address = %s, postal_code = %s, place = %s, country = %s  WHERE current.email = users.email", 
				 
				
				$this->prepare_string_value($address),
				$this->prepare_string_value($postal_code),
				$this->prepare_string_value($place),
				$this->prepare_string_value($country)
				);
				echo $address;
			if (mysql_query($sql)) {
				$this->error = $this->messages(21);
			} else {
				$this->error = $this->messages(1);
			}
			
	}
	
	function cancel_order() {
		$err_level = 0;
		if (!mysql_query(sprintf("DELETE FROM %s WHERE order_id = %d", SHIP_ADDRESS, $_SESSION['order_id']))) $err_level++;
		if (!mysql_query(sprintf("DELETE FROM %s WHERE order_id = %d", ORDER_ROWS, $_SESSION['order_id']))) $err_level++;
		if (!mysql_query(sprintf("DELETE FROM %s WHERE id = %d", ORDERS, $_SESSION['order_id']))) $err_level++;
		if ($err_level > 0) {
			$this->error = $this->messages(1);
		} else {
			unset($_SESSION['order_id']);
			header("Location: ".PROD_IDX);
		}	
	}
	
	function check_out($mailto, $show_address = true) {
		$this->set_shipment_data();
		if ($this->mail_order($mailto, $show_address)) {
			header("Location: ".CONFIRM);
		} else {
			$this->error = $this->messages(2);
		}
	}
	function mail_order($to, $show_shipment) { 
		$header = "From: \"".SITE_MASTER."\" <".SITE_MASTER_MAIL.">\r\n";
		$header .= "Cc: ".SITE_MASTER_MAIL."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/plain; charset=\"".MAIL_ENCODING."\"\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n";
		$subject =  $this->messages(51); 
		$body = $this->messages(52); 
		$this->show_ordered_rows(); 
		
		$body .= $this->messages(56); 
		foreach ($this->order_array as $val) {
			$body .= sprintf("\t%-10s  %-30s  %-20s  %-12s\r\n", $val['quantity'], $val['product_name'], $val['product_id'], $this->format_value($val['price'], false));
		}
		$body .= $this->messages(53); 
		$body .= $this->messages(54);
		$body .= ($show_shipment) ? $this->messages(57) : ""; 
		$body .= $this->messages(58); 
		$body .= $this->messages(55); 
		if (mail($to, $subject, $body, $header)) {
			return true;
		} else {
			return false;
		}
	}
	function close_order() {
		$sql = sprintf("UPDATE %s SET processed_on = NOW(), open = 'n' WHERE id = %d", ORDERS, $_SESSION['order_id']);
		if (mysql_query($sql)) {
			$this->error = $this->messages(22);
			unset($_SESSION['order_id']);
		} else {
			$this->error = $this->messages(1);
		}
	}
	
	function format_value($value, $encoding = true) {
		if ($encoding) {
			$curr = (ord(CURRENCY) == "128") ? "&#8364;" : htmlentities(CURRENCY);
		} else {
			$curr= CURRENCY;
		}
		$formatted = number_format($value, 2, ",", ".")." ".$curr;
		return $formatted;
	}
	
	function prepare_string_value($value) {
		$new_value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;
		$new_value = ($value != "") ? "'".trim($value)."'" : "''";
		return $new_value;
	}

}
?>