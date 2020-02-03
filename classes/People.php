<?php
class People extends Database {
		
	function Read() {
		
		$where = "";
		$spot = 0;
		
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
		while($row=mysqli_fetch_array($result))
		{
			$response[]=$row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	
	function Post() {
		//print_r(json_decode(file_get_contents("php://input"), true));
		$data = json_decode(file_get_contents("php://input"), true);
		$firstName = $data['firstName'];
		$lastName = $data['lastName'];
		if ($this->Query("INSERT INTO people (firstName, lastName) VALUES ('$firstName', '$lastName') ")) {
			$response = array(
				'status' => 1,
				'statusMessage' => "Person Successfully Added."
			);
		} else {
			$response = array(
				'status' => 0,
				'statusMessage' => "Unable to add Person."
			);			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
		
	}
	
	
	function Delete($toDelete) {
		if ($this->Query("DELETE FROM people WHERE $toDelete ")) {
			$response = array(
				'status' => 1,
				'statusMessage => "Person Deleted Successfully."'
			);
		} else {
			$response = array(
				'status' => 0,
				'statusMessage => "Person Deletion Failed."'
			);
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
		
	}
	
}

$people = new People();