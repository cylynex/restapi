<?php
class People extends Database {
		
	// Read Function - Accepts firstName, lastName as variables
	function Read() {
		
		$where = "";
		$spot = 0;
		
		// Check for variables
		if ($_GET) { 
			$where = " WHERE ";
			foreach ($_GET AS $key => $val) {
				$spot++;
				if ($spot > 1) { $where .= " AND "; }
				$where .= " $key = '$val' "; 
			}
		}
		
		$response=array();
		$result = $this->Query("SELECT * FROM people $where");
		while($row=mysqli_fetch_array($result)) {
			$response[]=$row;
		}
		
		// Output
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
		if ($this->Query("DELETE FROM people WHERE $toDelete ")) {
			$this->CreateResponse(1,"Person Deleted Successfully.");
		} else {
			$this->CreateResponse(0,"Person Deleteion Failed");
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