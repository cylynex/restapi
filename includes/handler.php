<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Get the input.
// TODO filter to avoid injection
$queryString = $_SERVER['QUERY_STRING'];

switch($requestMethod) {
	case "GET":
		$people->Read();
		break;
	case "POST":
		$people->Post();
		break;
	case "DELETE":
		$people->Delete($queryString);
		break;
}
?>