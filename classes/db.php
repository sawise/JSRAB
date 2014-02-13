<?php
	class Db{
		private $dbh = null;

		public function __construct() {
			try {
				$this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				} catch(PDOException $e) {
					echo $e->getMessage();
			}
		}


		//private $sql_search = "SELECT DISTINCT contacts.id, contacts.first_name, contacts.last_name, contacts.email, contacts.cell_phone, contacts.work_phone,  companies.title AS companies_title, contacts.contact_person, contacts.notes, companies.id AS companies_id, companies.title AS companies_title, companies.alt_title AS companies_alt_title, companies.url AS companies_url, companies.email AS companies_email, companies.contact_id AS companies_contact_id, companies.billed AS companies_billed, companies.total AS companies_total, companies.reference AS companies_reference, companies.visit_address AS companies_visit_address, companies.visit_zip_code AS companies_visit_zip_code, companies.visit_city AS companies_visit_city, companies.mail_address AS companies_mail_address, companies.mail_zip_code AS companies_mail_zip_code, companies.mail_city AS companies_mail_city, companies.billing_address AS companies_billing_address, companies.billing_zip_code AS companies_billing_zip_code, companies.billing_city AS companies_billing_city FROM contacts LEFT JOIN contacts_branches_contact_types ON contacts_branches_contact_types.contact_id = contacts.id LEFT JOIN companies ON contacts.company_id = companies.id LEFT JOIN contacts_mailshots_branches ON contacts_mailshots_branches.contact_id = contacts.id LEFT JOIN contacts_activities ON contacts_activities.contact_id = contacts.id";

		private $sql_search = "SELECT orders.id, orders.date, orders.customerID, orders.tiretreadID, orders.tiresizeID, orders.total, orders.comments, orders.deliverydate, orders.userID, orders.lastChange, customers.id AS customer_id, customers.name AS customer_name, customers.phonenumber AS customer_phonenumber, tiretreads.id AS tiretread_id, tiretreads.name AS tiretread_name, tiresizes.id AS tiresize_id, tiresizes.name AS tiresize_name, users.username AS username FROM orders LEFT JOIN customers ON customers.id = orders.customerID LEFT JOIN tiretreads ON tiretreads.id = orders.tiretreadID LEFT JOIN tiresizes ON tiresizes.id = orders.tiresizeID LEFT JOIN users ON orders.userID = users.id";

		private $users_sql = "select * from users";
		private $sql_tiretreads = "select * from tiretreads";
		private $sql_tiresize = "select * from tiresizes";
		private $sql_customers = "select * from customers";

		public function deleteOrder($id){
	      $sql = "delete FROM orders WHERE id = :id";
	      $sth = $this->dbh->prepare($sql);
	      $sth->bindParam(':id', $id, PDO::PARAM_INT);
	      $sth->execute();

	      if ($sth->rowCount() > 0) {
	        return true;
	      } else {
	        return false;
	      }
	    }

	    public function deleteUser($id){
	      $sql = "delete FROM users WHERE id = :id";
	      $sth = $this->dbh->prepare($sql);
	      $sth->bindParam(':id', $id, PDO::PARAM_INT);
	      $sth->execute();

	      if ($sth->rowCount() > 0) {
	        return true;
	      } else {
	        return false;
	      }
	    }

	    public function deleteTiretread($id){
	      $sql = "delete FROM tiretreads WHERE id = :id";
	      $sth = $this->dbh->prepare($sql);
	      $sth->bindParam(':id', $id, PDO::PARAM_INT);
	      $sth->execute();

	      if ($sth->rowCount() > 0) {
	        return true;
	      } else {
	        return false;
	      }
	    }

	    public function deleteTiresize($id){
	      $sql = "delete FROM tiresizes WHERE id = :id";
	      $sth = $this->dbh->prepare($sql);
	      $sth->bindParam(':id', $id, PDO::PARAM_INT);
	      $sth->execute();

	      if ($sth->rowCount() > 0) {
	        return true;
	      } else {
	        return false;
	      }
	    }

	    public function deleteCustomer($id){
	      $sql = "delete FROM customers WHERE id = :id";
	      $sth = $this->dbh->prepare($sql);
	      $sth->bindParam(':id', $id, PDO::PARAM_INT);
	      $sth->execute();

	      if ($sth->rowCount() > 0) {
	        return true;
	      } else {
	        return false;
	      }
	    }

	    public function updateUser($id, $username, $password){
	      $data = array($password, $username, $id);
	      $sth = $this->dbh->prepare("UPDATE users SET password = ?, username = ? WHERE id = ?");
	      $sth->execute($data);

	      if($sth->execute($data)) {
	        return true;
	      } else {
	        //return false;
	        return "UPDATE users SET password = ".$password.", SET username = ".$username." WHERE id = ".$id;
	      }
	    }

		public function getUsername($username) {
			$sql = $this->users_sql." WHERE username = :username";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':username', $username, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}

		public function getUsers() {
			$sth = $this->dbh->query($this->users_sql);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;

		}

		public function getUser($id) {
			$sql = $this->users_sql." WHERE id = :id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}
		
		public function getPassword($password) {
			$sql = $this->users_sql." WHERE password = :password";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':password', $password, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Users');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}
		

		public function getCustomers() {
			$sth = $this->dbh->query($this->sql_customers);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Customers');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;

		}

		public function getTiretreads() {
			$sth = $this->dbh->query($this->sql_tiretreads);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Tirethreads');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;

		}

		public function getTiresize() {
			$sth = $this->dbh->query($this->sql_tiresize);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Tiresize');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;
		}

		public function getOrder($id) {
			$sql = $this->sql_search." WHERE orders.id = :id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Search');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}  

			    

		public function search_count($text, $tiresize, $tirethread, $datestart, $dateend) {
			$sqlquery = '';
			
			$adv = '';
			if(is_numeric($tiresize)){
				$adv .= 'tiresizes.id = '.$tiresize;
			}
			if(is_numeric($tirethread)){
				if(is_numeric($tiresize)){
					$adv .= ' AND tiretreads.id = '.$tirethread;
				} else {
					$adv .= 'tiretreads.id = '.$tirethread;
				}
				
			}
			if($datestart != 'nodate' && $dateend != 'nodate'){
				if(is_numeric($tirethread) || is_numeric($tiresize)){
					$adv .= ' AND orders.deliverydate >=\''.$datestart.'\' AND orders.deliverydate<=\''.$dateend.'\'';	
				} else {
					$adv = 'orders.deliverydate >=\''.$datestart.'\' AND orders.deliverydate<=\''.$dateend.'\'';	
				}
			}

			if(preg_match('/id_/', $text)){
				$id = explode("_", $text);
				$sqlquery = $this->sql_search." WHERE orders.id = ".$id[1];
			} else if($adv != '') {
				$sqlquery = $this->sql_search." WHERE (customers.name LIKE '%".$text."%' OR orders.comments LIKE '%".$text."%') AND (".$adv.")";	
			} else {
				$sqlquery = $this->sql_search." WHERE customers.name LIKE '%".$text."%' OR orders.comments LIKE '%".$text."%'";	
			}
			
			$sth = $this->dbh->query($sqlquery);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Ordercount');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			
			return count($objects);
		}

		public function search($text, $tiresize, $tirethread, $datestart, $dateend, $sortby, $descasc, $startform ,$limit) {
			$sqlquery = '';
			$adv = '';
			if(is_numeric($tiresize)){
				$adv .= 'tiresizes.id = '.$tiresize;
			}
			if(is_numeric($tirethread)){
				if(is_numeric($tiresize)){
					$adv .= ' AND tiretreads.id = '.$tirethread;
				} else {
					$adv .= 'tiretreads.id = '.$tirethread;
				}
			}
			if($datestart != 'nodate' && $dateend != 'nodate'){
				if(is_numeric($tirethread) || is_numeric($tiresize)){
					$adv .= ' AND orders.deliverydate >=\''.$datestart.'\' AND orders.deliverydate<=\''.$dateend.'\'';	
				} else {
					$adv .= 'orders.deliverydate >=\''.$datestart.'\' AND orders.deliverydate<=\''.$dateend.'\'';	
				}
			}

			if(preg_match('/id_/', $text)){
				$id = explode("_", $text);
				$sqlquery = $this->sql_search." WHERE orders.id = ".$id[1]." ORDER BY ".$sortby." ".$descasc." LIMIT ".$startform.", ".$limit;
			} else if($adv != '') {
				$sqlquery = $this->sql_search." WHERE (customers.name LIKE '%".$text."%' OR orders.comments LIKE '%".$text."%') AND (".$adv.")  ORDER BY ".$sortby." ".$descasc." LIMIT ".$startform.", ".$limit;	
			} else {
				$sqlquery = $this->sql_search." WHERE customers.name LIKE '%".$text."%' OR orders.comments LIKE '%".$text."%' ORDER BY ".$sortby." ".$descasc." LIMIT ".$startform.", ".$limit;	
			}
			$sth = $this->dbh->query($sqlquery);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Search');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			//return $this->sql_search." WHERE (customers.name LIKE '%".$text."%' OR orders.comments LIKE '%".$text."%') ".$adv."  ORDER BY ".$sortby." ".$descasc." LIMIT ".$startform.", ".$limit;	
				return $objects;
		}

		public function searchYear_count($year, $week) {
			
			
			$sth = $this->dbh->query($this->sql_search." WHERE YEAR(deliverydate) = ".$year." AND WEEK(deliverydate)+1 = ".$week);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Ordercount');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			
			return count($objects);
		}

		public function searchYear($year, $week, $sortby, $descasc, $startform ,$limit) {
			$sth = $this->dbh->query($this->sql_search." WHERE YEAR(deliverydate) = ".$year." AND WEEK(deliverydate)+1 = ".$week."  ORDER BY ".$sortby." ".$descasc." LIMIT ".$startform.", ".$limit);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Search');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
				return $objects;
		}

		public function updateContact($id, $firstname, $lastname, $email, $mobile, $workphone, $contactperson, $notes) {
			$data = array($firstname, $lastname, $email, $mobile, $workphone, $contactperson, $notes, $id);
			$sth = $this->dbh->prepare("UPDATE contacts SET first_name = ?, last_name = ?, email = ?, cell_phone = ?, work_phone = ?, contact_person = ?, notes = ? WHERE id = ?");
			$sth->execute($data);

			if($sth->execute($data)) {
				return true;
			} else {
				return false;
			}
		}

		public function createTiretread($name){
			$data = array($name);
			$sth = $this->dbh->prepare("INSERT INTO tiretreads (name) VALUES (?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

		public function createUser($username, $password){
			$data = array($username, $password);
			$sth = $this->dbh->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

		public function createCustomer($name, $phonenumber = null){
			$data = array($name, $phonenumber);
			$sth = $this->dbh->prepare("INSERT INTO customers (name, phonenumber) VALUES (?,?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

		public function createTireSize($name){
			$data = array($name);
			$sth = $this->dbh->prepare("INSERT INTO tiresizes (name) VALUES (?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

		public function createOrder($customerID, $tiretreadID, $tiresizeID, $total, $comments, $deliverydate, $userID,$lastChange){
			$data = array($customerID, $tiretreadID, $tiresizeID, $total, $comments, $deliverydate, $userID,$lastChange);
			$sth = $this->dbh->prepare("INSERT INTO orders (customerID, tiretreadID, tiresizeID, total, comments, deliverydate, userID,lastChange) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

	
		public function updateOrder($id, $date, $customerID, $tiretreadID, $tiresizeID, $total, $comments, $deliverydate, $userID,$lastChange){
      $data = array($date, $customerID, $tiretreadID, $tiresizeID, $total, $comments, $deliverydate, $userID,$lastChange, $id);
      $sth = $this->dbh->prepare("UPDATE orders SET date = ?, customerID = ?, tiretreadID = ?, tiresizeID = ?, total = ?, comments = ?, deliverydate = ?, userID = ?, lastChange = ? WHERE id = ?");
      $sth->execute($data);

      if($sth->execute($data)) {
        return true;
      } else {
        return false;
      }
    }

		public function query($sql, $class_name) {
			$sth = $this->dbh->query($sql);
			$sth->setFetchMode(PDO::FETCH_CLASS, $class_name);

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}

			return $objects;
		}

		public function get($id, $table_name, $class_name, $sql = null) {
			if ($sql == null) {
				$sql = "SELECT * FROM $table_name WHERE id = $id LIMIT 1";
			}

			$sth = $this->dbh->query($sql);
			$sth->setFetchMode(PDO::FETCH_CLASS, $class_name);

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}

			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return null;
			}
		}

		public function __destruct() {
			$this->dbh = null;
		}

		//http://webcheatsheet.com/PHP/get_current_page_url.php
		public function currentPageURL() {
			$pageURL = $_SERVER['QUERY_STRING'];
			return $pageURL;
		}
	}

?>
