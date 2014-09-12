<?php
require("classes.php");
// potrebno za kontroliranje kolicine (amount) 

class db_stock_cart extends db_cart {

	
	function db_stock_cart($customer_no = 0) {
		$conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME, $conn);
		$this->error = "&nbsp;";
		if (!isset($_SESSION['checked_cart'])) {
			$_SESSION['checked_cart'] = false;
			header("Location: ".PROD_IDX);
			exit;
		}
		if (!isset($_SESSION['order_id'])) {
			$this->get_order($customer_no);
			$this->remove_old_orders(true); 
			if ($customer_no == 0) { 
				$_SESSION['checked_cart'] = true; 
			}
		}
	}
	
	function stock_msg($num, $extra_info = "") {
		$msg = array();
		$msg[1] = "Unesena vrijednost veca je od dostupnih iznosa kolicine.";
		$msg[2] = "Ima ".$extra_info." knjiga prodanih nakon vase zadnje posjete, knjige su uklonjene.";
		$msg[3] = "Zato sto je kolicina niza od vase zadnje narudzbe, kolicina ".$extra_info." knjiga je promjenjena.";
		$msg[4] = "<br>Na kraju cijene promjena su procesirane.";
		return $msg[$num];
	}

	function check_against_stock($stock_val, $amount) {
		if ($amount <= $stock_val) {
			return true;
		} else {
			$this->error = $this->stock_msg(1);
			return false;
		}
	}
 
	function get_value_for_row($art_id) {
		$sql = sprintf("SELECT id, price, quantity FROM %s WHERE product_id = '%s' AND order_id = %d", ORDER_ROWS, $art_id, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			$data['id'] = mysql_result($result, 0, "id");
			$data['price'] = mysql_result($result, 0, "price");
			$data['quantity'] = mysql_result($result, 0, "quantity");
			return $data;
		} else {
			$this->error = $this->messages(1);
			return;
		}
	}

	function proces_old_order($new_price, $new_stock, $for_product) {
		$old_data = $this->get_value_for_row($for_product);
		if ($new_stock == 0) {
			$sql = sprintf("DELETE FROM %s WHERE id = %d", ORDER_ROWS, $old_data['id']);
			if (mysql_query($sql)) {
				$_SESSION['deleted']++;
			} else {
				$this->error = $this->messages(1);
			}
		} elseif ($new_stock < $old_data['quantity']) {
			$sql = sprintf("UPDATE %s SET quantity = %d, price = %f WHERE id = %d", ORDER_ROWS, $new_stock, $new_price, $old_data['id']);
			if (mysql_query($sql)) {
				$_SESSION['updated']++;
			} else {
				$this->error = $this->messages(1);
			}
		} else {
			$sql = sprintf("UPDATE %s SET price = %f WHERE id = %d", ORDER_ROWS, $new_price, $old_data['id']);
			if (mysql_query($sql)) {
				$_SESSION['updated']++;
			} else {
				$this->error = $this->messages(1);
			}
		}
	}

	function update_stock_values($ext_prod_array) {
		if (is_array($ext_prod_array)) {
			$_SESSION['deleted'] = 0;
			$_SESSION['updated'] = 0;
			foreach ($ext_prod_array as $val) {
				$stock_val = $val['new_stock'];
				$price_val = $val['new_price'];
				$prod_val = $val['prod_id'];
				$this->proces_old_order($price_val, $stock_val, $prod_val);
			}
			$this->error = ($_SESSION['deleted'] > 0) ? $this->stock_msg(2, $_SESSION['deleted']) : "";
			$this->error .= ($_SESSION['deleted'] > 0 && $_SESSION['updated'] > 0) ? "<br>" : "";
			$this->error .= ($_SESSION['updated'] > 0) ? $this->stock_msg(3, $_SESSION['updated']) : "";
			$this->error .= $this->stock_msg(4);
			$_SESSION['checked_cart'] = true;
		} else {
			$_SESSION['checked_cart'] = true;
		}
	}

	function get_order_num_string() {
		$str = "";
		$this->show_ordered_rows();
		foreach ($this->order_array as $val) {
			$str .= "'".$val['product_id']."', ";
		}
		$str = rtrim($str, ", ");
		return $str;
	}
}
?>