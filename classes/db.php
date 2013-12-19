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

		//Many to many-kladd
		private $sql_search = "SELECT orders.id, orders.date, orders.customerID, orders.tiretreadID, orders.tiresizeID, orders.total, orders.comments, orders.deliverydate, orders.userID, orders.lastChange, customers.id AS customer_id, customers.name AS customer_name, customers.phonenumber AS customer_phonenumber, tiretreads.id AS tiretread_id, tiretreads.name AS tiretread_name, tiresizes.id AS tiresize_id, tiresizes.name AS tiresize_name FROM orders LEFT JOIN customers ON customers.id = orders.customerID LEFT JOIN tiretreads ON tiretreads.id = orders.tiretreadID LEFT JOIN tiresizes ON tiresizes.id = orders.tiresizeID";

		private $sql_tiretreads = "select * from tiretreads";
		private $sql_tiresize = "select * from tiresizes";
		private $sql_customers = "select * from customers";

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

		public function search($text) {
			$sth = $this->dbh->query($this->sql_search." WHERE customers.name LIKE '%".$text."%' OR tiresizes.name LIKE '%".$text."%'");
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Search');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
				return $objects;
		}

		public function searchYear($year) {
			$sth = $this->dbh->query($this->sql_search." WHERE deliverydate LIKE '%".$year."'");
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Search');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
				return $objects;
		}


		public function getContact($id) {
			$sql = $this->sql_contacts." where contacts.id = :id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'contacts');
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

		public function search_count($text, $searchstring = null, $contacttypes_id = null, $mailshots_id = null, $activities_id = null) {
			$advsearch = "";
			if($contacttypes_id != null) {
				for ($i=0; $i <= count($contacttypes_id); $i++) {
					if(isset($contacttypes_id['contacttype_'.$i])) {
						$and = ' AND ';
						 if($contacttypes_id['contacttype_'.$i.'_date'] != null || $contacttypes_id['contacttype_'.$i.'_date'] != '') {
							$advsearch .= " contacts_branches_contact_types.date LIKE '%".$contacttypes_id['contacttype_'.$i.'_date']."%'".$and;
						} if($contacttypes_id['contacttype_'.$i.'_branch'] != null) {
							$j = 0;
							$divide = count($contacttypes_id['contacttype_'.$i.'_branch']);
								foreach ($contacttypes_id['contacttype_'.$i.'_branch']	 as $branch_id) {

									$advsearch .= " contacts_branches_contact_types.branch_id = ".$branch_id.$and;
									$j++;
								}
						}		if ($i == (count($contacttypes_id)/3-1) && $activities_id == null && $mailshots_id == null) {
									$and = ' ';
								}
						$advsearch .= " contacts_branches_contact_types.contact_type_id = ".$contacttypes_id['contacttype_'.$i].$and;
					}
				}
			}
			if($mailshots_id != null) {
				for ($i=0; $i <= count($mailshots_id); $i++) {
					if(isset($mailshots_id['mailshot_'.	$i])) {
						$and = ' AND ';
						if ($i == (count($mailshots_id)/2-1) && $activities_id == null) {
							$and = ' ';
						}
						$advsearch .= " contacts_mailshots_branches.mailshot_id = ".$mailshots_id['mailshot_'.$i]." AND contacts_mailshots_branches.branch_id = ".$mailshots_id['mailshot_'.$i.'_branch'].$and;
					}
				}
			}
			if($activities_id != null) {
				for ($i=0; $i <= count($activities_id); $i++) {
					if(isset($activities_id[$i])) {
						$and = ' AND ';
						if ($i == (count($activities_id)-1)) {
							$and = ' ';
						}
						$advsearch .= " contacts_activities.activity_id = ".$activities_id[$i].$and;
					}
				}
			}
			if($advsearch != null){
				$sql = "SELECT DISTINCT COUNT( DISTINCT ".$text.".id) AS ".$text." FROM ".$text." LEFT JOIN contacts_branches_contact_types ON contacts_branches_contact_types.contact_id = contacts.id LEFT JOIN companies ON contacts.company_id = companies.id LEFT JOIN contacts_mailshots_branches ON contacts_mailshots_branches.contact_id = contacts.id LEFT JOIN contacts_activities ON contacts_activities.contact_id = contacts.id WHERE (contacts.first_name LIKE '%".$searchstring."%' OR contacts.last_name LIKE '%".$searchstring."%' OR contacts.email LIKE '%".$searchstring."%' OR companies.title  LIKE '%".$searchstring."%' OR contacts.cell_phone LIKE '%".$searchstring."%') AND (".$advsearch.")";
			} else {
				$sql = "SELECT COUNT(".$text.".id) AS ".$text." FROM ".$text." LEFT JOIN companies ON companies.contact_id = contacts.company_id WHERE contacts.first_name LIKE '%".$searchstring."%' OR contacts.last_name LIKE '%".$searchstring."%' OR contacts.email LIKE '%".$searchstring."%' OR companies.title  LIKE '%".$searchstring."%' OR contacts.cell_phone LIKE '%".$searchstring."%'";
			}

			$sth = $this->dbh->prepare($sql);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'count');
			$sth->execute();

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			if (count($objects) > 0) {
				return $objects[0];
			} else {
				return $sql;
			}
		}

		

		public function advsearch($text, $sort, $ascdesc, $startform, $limit, $contacttypes_id = null, $mailshots_id = null, $activities_id = null) {
			$advsearch = "";
			if($contacttypes_id != null) {
				for ($i=0; $i <= count($contacttypes_id); $i++) {
					if(isset($contacttypes_id['contacttype_'.$i])) {
						$and = ' AND ';
						 if($contacttypes_id['contacttype_'.$i.'_date'] != null || $contacttypes_id['contacttype_'.$i.'_date'] != '') {
							$advsearch .= " contacts_branches_contact_types.date LIKE '%".$contacttypes_id['contacttype_'.$i.'_date']."%'".$and;
						} if($contacttypes_id['contacttype_'.$i.'_branch'] != null) {
							$j = 0;
							$divide = count($contacttypes_id['contacttype_'.$i.'_branch']);
								foreach ($contacttypes_id['contacttype_'.$i.'_branch']	 as $branch_id) {

									$advsearch .= " contacts_branches_contact_types.branch_id = ".$branch_id.$and;
									$j++;
								}
						}		if ($i == (count($contacttypes_id)/3-1) && $activities_id == null && $mailshots_id == null) {
									$and = ' ';
								}
						$advsearch .= " contacts_branches_contact_types.contact_type_id = ".$contacttypes_id['contacttype_'.$i].$and;
					}
				}
			}
			if($mailshots_id != null) {
				for ($i=0; $i <= count($mailshots_id); $i++) {
					if(isset($mailshots_id['mailshot_'.	$i])) {
						$and = ' AND ';
						if ($i == (count($mailshots_id)/2-1) && $activities_id == null) {
							$and = ' ';
						}
						$advsearch .= " contacts_mailshots_branches.mailshot_id = ".$mailshots_id['mailshot_'.$i]." AND contacts_mailshots_branches.branch_id = ".$mailshots_id['mailshot_'.$i.'_branch'].$and;
					}
				}
			}
			if($activities_id != null) {
				for ($i=0; $i <= count($activities_id); $i++) {
					if(isset($activities_id[$i])) {
						$and = ' AND ';
						if ($i == (count($activities_id)-1)) {
							$and = ' ';
						}
						$advsearch .= " contacts_activities.activity_id = ".$activities_id[$i].$and;
					}
				}
			}

			if($contacttypes_id != null  || $activities_id != null  || $mailshots_id != null) {
				$sth = $this->dbh->query($this->sql_search." WHERE (contacts.first_name LIKE '%".$text."%' OR contacts.last_name LIKE '%".$text."%') AND (".$advsearch.") ORDER BY ".$sort." ".$ascdesc." LIMIT ".$startform.", ".$limit);
			} else  {
				$sth = $this->dbh->query($this->sql_search." WHERE contacts.first_name LIKE '%".$text."%' OR contacts.last_name LIKE '%".$text."%' OR contacts.email LIKE '%".$text."%' OR companies.title  LIKE '%".$text."%' OR contacts.cell_phone LIKE '%".$text."%'  ORDER BY ".$sort." ".$ascdesc." LIMIT ".$startform.", ".$limit);
			}
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Contacts');

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

		public function deleteContact($contact_id, $company_id) {
			$sql = "DELETE contacts, companies, contacts_branches_contact_types, contacts_activities, contacts_mailshots_branches, companies_contracts_branches FROM contacts INNER JOIN companies INNER JOIN contacts_branches_contact_types INNER JOIN contacts_activities INNER JOIN contacts_mailshots_branches INNER JOIN companies_contracts_branches WHERE contacts.id = :contact_id AND companies.contact_id = :contact_id AND contacts_branches_contact_types.contact_id = :contact_id AND contacts_activities.contact_id = :contact_id AND contacts_mailshots_branches.contact_id = :contact_id AND companies_contracts_branches.company_id = :company_id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
			$sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
			$sth->execute();

			if ($sth->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}

		
		public function getContract($id) {
      $sql = $this->sql_contracts." WHERE contracts.id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->setFetchMode(PDO::FETCH_CLASS, 'Contracts');
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

	

		public function updateContract($id, $title) {
      $data = array($title, $id);
      $sth = $this->dbh->prepare("UPDATE contracts SET title = ? WHERE id = ?");
      $sth->execute($data);

      if($sth->execute($data)) {
        return true;
      } else {
        return false;
      }
    }

    public function deleteContract($id){
      $sql = "delete FROM contracts WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();

      if ($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }



    public function deleteContactsBranchesContacttypes($contact_id){
      $sql = "";
      if($contact_type_id =! null){
      	$sql = "delete FROM contacts_branches_contact_types WHERE contact_id = :contact_id AND contact_type_id = :contact_type_id";
    	} else {
    		$sql = "delete FROM contacts_branches_contact_types WHERE contact_id = :contact_id";
    	}
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
      $sth->bindParam(':contact_type_id', $contact_type_id, PDO::PARAM_INT);
      $sth->execute();

      if ($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

  


		public function getCompany($id) {
			$sql = $this->sql_companies." where companies.id = :id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'companies');
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

		


		public function showCompanies_contracts_branches($id) {
			$sth = $this->dbh->query($this->sql_companies_contracts_branches." WHERE companies.id = ".$id);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'branches');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;
		}

    public function deleteCompanyContractBranch($contract_id, $company_id) {
    	$sql = "DELETE FROM companies_contracts_branches WHERE company_id = :company_id AND contract_id = :contract_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':contract_id', $contract_id, PDO::PARAM_INT);
      $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
      $sth->execute();

      if($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

     public function deleteCompaniesContractsBranches($company_id, $contract_id){
      $sql = "delete FROM companies_contracts_branches WHERE company_id = :company_id AND contract_id = :contract_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
      $sth->bindParam(':contract_id', $contract_id, PDO::PARAM_INT);
      $sth->execute();

      if ($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

	

		public function getBranch($id) {
      $sql = $this->sql_branches." WHERE branches.id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->setFetchMode(PDO::FETCH_CLASS, 'Branches');
      $sth->execute();

      $objects = array();

      while($obj = $sth->fetch()) {
        $objects[] = $obj;
      }
      if(count($objects) > 0) {
        return $objects[0];
      } else {
        return null;
      }
    }


    public function updateBranch($id, $title) {
      $data = array($title, $id);
      $sth = $this->dbh->prepare("UPDATE branches SET title = ? WHERE id = ?");
      $sth->execute($data);

      if($sth->execute($data)) {
        return true;
      } else {
        return false;
      }
    }

    public function deleteBranch($id) {
      $sql = "DELETE FROM branches WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();

      if ($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }





		//insertIdtoCompany($contract_id, $company_id);
		public function insertIdtoCompany($lastcontract_id, $company_id) {
			$data = array($lastcontract_id,  $company_id);
			$sth = $this->dbh->prepare("UPDATE companies SET contract_id = ? WHERE id = ?");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}
		public function insertContacttoCompany($contact_id, $company_id) {
			$data = array($contact_id,  $company_id);
			$sth = $this->dbh->prepare("UPDATE companies SET contact_id = ? WHERE id = ?");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}
		public function insertIdtoContact($lastcompany_id, $contact_id) {
			$data = array($lastcompany_id, $contact_id);
			$sth = $this->dbh->prepare("UPDATE contacts SET company_id = ? WHERE id = ?");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

			public function insertIdtoContract($lastcompany_id, $contract_id) {
			$data = array($lastcompany_id, $contract_id);
			$sth = $this->dbh->prepare("UPDATE contracts SET company_id = ? WHERE id = ?");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}


		public function getContacttype($id) {
      $sql = $this->sql_contact_types." WHERE contact_types.id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->setFetchMode(PDO::FETCH_CLASS, 'Contacttypes');
      $sth->execute();

      $objects = array();

      while($obj = $sth->fetch()) {
        $objects[] = $obj;
      }
      if(count($objects) > 0) {
        return $objects[0];
      } else {
        return null;
      }
    }


    public function deleteContactBranchContacttype($contact_type_id) {
      $sql = "DELETE FROM contacts_branches_contact_types WHERE contact_type_id = :contact_type_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':contact_type_id', $contact_type_id, PDO::PARAM_INT);
      $sth->execute();

      if($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }



		public function getActivity($id) {
      $sql = $this->sql_activities." WHERE activities.id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->setFetchMode(PDO::FETCH_CLASS, 'Activities');
      $sth->execute();

      $objects = array();

      while($obj = $sth->fetch()) {
        $objects[] = $obj;
      }
      if(count($objects) > 0) {
        return $objects[0];
      } else {
        return null;
      }
    }

		public function createActivity($title, $date, $branch_id) {
			$data = array($title, $date, $branch_id);
			$sth = $this->dbh->prepare("INSERT INTO activities (title, date, branch_id) VALUES (?, ?, ?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

    public function updateActivity($id, $title) {
      $data = array($title, $id);
      $sth = $this->dbh->prepare("UPDATE activities SET title = ? WHERE id = ?");
      $sth->execute($data);

      if($sth->execute($data)) {
        return true;
      } else {
        return false;
      }
    }

    public function deleteActivity($id) {
      $sql = "DELETE FROM activities WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();

      if($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

    public function deleteContactActivity($activity_id) {
      $sql = "DELETE FROM contacts_activities WHERE activity_id = :activity_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
      $sth->execute();

      if($sth->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

		public function getMailshots() {
			$sth = $this->dbh->query("select * from mailshots order by title");
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Mailshots');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;
		}

    public function getMailshot($id) {
      $sql = $this->sql_mailshots." WHERE mailshots.id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->setFetchMode(PDO::FETCH_CLASS, 'Mailshots');
      $sth->execute();

      $objects = array();

      while($obj = $sth->fetch()) {
        $objects[] = $obj;
      }
      if(count($objects) > 0) {
        return $objects[0];
      } else {
        return null;
      }
    }

    public function createMailshot($title){
			$data = array($title);
			$sth = $this->dbh->prepare("INSERT INTO mailshots (title) VALUES (?)");
			$sth->execute($data);

			if($sth->rowCount() > 0) {
				return $this->dbh->lastInsertId();
			} else {
				return null;
			}
		}

    public function updateMailshot($id, $title) {
      $data = array($title, $id);
      $sth = $this->dbh->prepare("UPDATE mailshots SET title = ? WHERE id = ?");
      $sth->execute($data);

      if($sth->execute($data)) {
        return true;
      } else {
        return false;
      }
    }

    public function deleteMailshot($id) {
      $sql = "DELETE FROM mailshots WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();

      if($sth -> rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

		/*public function showMailshots($id) {
			$sql = $this->sql_contacts_mailshots_branches." WHERE contacts_mailshots_branches.contact_id = ".$id;
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'mailshots');
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
		}*/
		public function showMailshots($contact_id) {
			$sth = $this->dbh->query($this->sql_contacts_mailshots_branches." WHERE contacts_mailshots_branches.contact_id = ".$contact_id);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'Mailshots');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
			return $objects;
		}

		public function getContactsBranchesContacttypes() {
			$sth = $this->dbh->query($this->sql_contacts_branches_contacttypes);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'contacts_branches_contacttypes');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
				return $objects;

		}

		public function showContacts_branches_contacttypes($contact_id) {
			$sth = $this->dbh->query($this->sql_contacts_branches_contacttypes." WHERE contacts_branches_contact_types.contact_id = ".$contact_id);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'contacttypes');

			$objects = array();

			while($obj = $sth->fetch()) {
				$objects[] = $obj;
			}
				return $objects;

		}

		public function getContactsExport($id) {
			$sql = $this->sql_contacts." WHERE contacts.id IN (:id)";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->setFetchMode(PDO::FETCH_CLASS, 'ContactsExport');
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

		public function deleteItem($id) {
			$sql = "delete from items where id = :id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->execute();

			if ($sth->rowCount() > 0) {
				return true;
			} else {
				return false;
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
