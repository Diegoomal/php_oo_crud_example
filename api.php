<?php

include_once('init.php');

/*   
Chamada:
http://127.0.0.1:81/engsoft/api.php/?class=person
http://127.0.0.1:81/engsoft/api.php/?class=person&operation=read

http://127.0.0.1:81/engsoft/api/person/insert
http://127.0.0.1:81/engsoft/api/person/update/1
http://127.0.0.1:81/engsoft/api/person/delete/1
http://127.0.0.1:81/engsoft/api/person/read
http://127.0.0.1:81/engsoft/api/person/read/1
*/

header("Content-Type:application/json");

function response($status, $status_message, $data) {
	header("HTTP/1.1 ".$status);	
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	echo json_encode($response);
}

function get_id_from_url() {
	$uri = $_SERVER['REQUEST_URI'];
	$uri_array = explode( "/", $uri );
	$aux = end($uri_array);
	return is_numeric($aux) ? $aux : '0';
}

function create_person_obj() {
	$person = new Person();
	$person->setter_id( get_id_from_url() );
	$person->setter_firstName( 	!empty($_GET['first_name']) 	? $_GET['first_name'] 	: '' );
	$person->setter_lastName( 	!empty($_GET['last_name']) 		? $_GET['last_name'] 	: '' );
	$person->setter_dtRegister( !empty($_GET['dt_register']) 	? $_GET['dt_register'] 	: '' );
	return $person;
}

$result = null;
$facade = new Facade();

if($_GET['class'] == 'person') {
	
	if($_GET['operation'] == 'insert') {
		$person = create_person_obj();
		$result = $facade->insert( $person );
		if(!empty($result->getter_msg())) { response(400, $result->getter_msg(), NULL); }
		response(200, "Operation in Data Base SUCCESS", json_encode( NULL ) );
	} else if($_GET['operation'] == 'update') {
		$person = create_person_obj();
		$result = $facade->update( $person );
		if(!empty($result->getter_msg())) { response(400, $result->getter_msg(), NULL); }
		response(200, "Operation in Data Base SUCCESS", json_encode( NULL ) );
	} else if($_GET['operation'] == 'delete') {
		$person = create_person_obj();
		$result = $facade->delete( $person );
		if(!empty($result->getter_msg())) { response(400, $result->getter_msg(), NULL); }
		response(200, "Operation in Data Base SUCCESS", json_encode( NULL ) );
	} else if($_GET['operation'] == 'read') {
		$person = create_person_obj();
		$result = $facade->read( $person );
		if(!empty($result->getter_msg())) { response(400, $result->getter_msg(), NULL); }
		response(200, "Operation in Data Base SUCCESS", json_encode( $result->getter_entities()[0] ) );
	}

} else {
	response(200, "Class Not Found", NULL);
}



// $sAux = 'class: ' . $_GET['class'] 
// 	. ' - operation: ' . $_GET['operation'] 
// 	. ' - id: ' . $_GET['id'] 
// 	. ' - first_name: ' . $_GET['first_name'] 
// 	. ' - last_name: ' . $_GET['last_name'] 
// 	. ' - dt_register: ' . $_GET['dt_register'];

// var_dump($sAux);



?>