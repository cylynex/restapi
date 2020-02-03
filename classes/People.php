<?php
class People extends Database {
		
	// Read Function - Accepts firstName, lastName as variables.
	function Read() {
		
		$where = "";
		$spot = 0;
		
		// Check for variables
		if ($_GET) { 
			$where = " WHERE ";
						
			if ($_GET['firstName']) {
				$where .= "firstName = '".$_GET['firstName']."'";
				$spot++;
			}
			
			if ($_GET['lastName']) {
				if ($spot > 0) { $where .= " AND "; }
				$where .= "lastName = '".$_GET['lastName']."'";
			}
		}
		
		$response=array();
		$result = $this->Query("SELECT * FROM people $where");
		while($row=mysqli_fetch_array($result)) {
			$response[]=$row;
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	
	// Insert Person - Accepts firstName,lastName as variables
	function Post() {
		//print_r(json_decode(file_get_contents("php://input"), true));
		$data = json_decode(file_get_contents("php://input"), true);
		$firstName = $data['firstName'];
		$lastName = $data['lastName'];
		
		if ($this->Query("INSERT INTO people (firstName, lastName) VALUES ('$firstName', '$lastName') ")) {
			$response = $this->CreateResponse(1,"Person Successfully Added");
		} else {
			$response = $this->CreateResponse(0,"Unable to Add Person");
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
		
	}
	
	
	// Delete Person - Accepts ID as variable
	function Delete($toDelete) {
		$delo = explode("=",$toDelete);
		
		if (is_numeric($delo[1])) {
			$deleteID = $delo[1];
			if ($this->Query("DELETE FROM people WHERE id = '$deleteID' ")) {
				$response = $this->CreateResponse(1,"Person Deleted Successfully.");
			} else {
				$this->CreateResponse(0,"Person Deletion Failed");
			}
		} else {
			$response = $this->CreateResponse(0,"Invalid Input");
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
		
	}
	
	
	function CreateResponse($status,$message) {
		$response = array(
			'status' => $status,
			'statusMessage' => $message
		);
		return $response;
	}
	
}

$people = new People();