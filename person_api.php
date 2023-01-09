<?php

/*
Chamada:
http://127.0.0.1:81/engsoft/person_api.php/?class=person&operation=insert
http://127.0.0.1:81/engsoft/person_api.php/?class=person&operation=update
http://127.0.0.1:81/engsoft/person_api.php/?class=person&operation=delete
http://127.0.0.1:81/engsoft/person_api.php/?class=person&operation=read
*/

include_once('init.php');

header("Content-Type:application/json");

function response($status, $status_message, $data) {
	header("HTTP/1.1 ".$status);	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	echo json_encode($response);
}

if(empty($_GET['class']) || empty($_GET['operation'])) {
	response(400, "Invalid Request", NULL);
} else {
   if($_GET['class'] == 'person') {
      operations_person(new Facade());
   } else if (false) { 
      // ... other class ... 
   }else {
      response(200, "Class Not Found", NULL);
   }
}

function operations_person($facade) {
   $person = new Person();

   $person->setter_id(1);
   $person->setter_firstName('Diego');
   $person->setter_lastName('Maldonado');
   
   // $person->setter_id(2);
   // $person->setter_firstName('Nicholas');
   // $person->setter_lastName('Pallermo');
   
   if($_GET['operation'] == 'insert') {
      $result = $facade->insert( $person );
      if(!empty($result->getter_msg())) {
         response(400, $result->getter_msg(), NULL);
      } else {
         response(200, "Data Inserted in Data Base", NULL);
      }
   } else if($_GET['operation'] == 'update') {
      $result = $facade->update( $person );
      if(!empty($result->getter_msg())) {
         response(400, $result->getter_msg(), NULL);
      } else {
         response(200, "Data Updated in Data Base", NULL);
      }
   } else if($_GET['operation'] == 'delete') {
      $person->setter_id(0);
      $result = $facade->delete( $person );
      if(!empty($result->getter_msg())) {
         response(400, $result->getter_msg(), NULL);
      } else {
         response(200, "Data Deleted in Data Base", NULL);
      }
   } else if($_GET['operation'] == 'read') {         
      $result = $facade->read( $person );
      if(!empty($result->getter_msg())) {
         response(400, $result->getter_msg(), NULL);
      } else {         
         response(200, "Data Readed in Data Base", json_encode( $result->getter_entities() ) );
         // response(200, "Data Readed in Data Base", json_encode( $result->getter_entities()[0] ) );
         // response(200, "Data Readed in Data Base", json_encode( $result->getter_entities()[0][0] ) );

         // http_response_code(200);
         // $product_arr = array(
         //    "id" =>  '$product->id',
         //    "name" => '$product->name',
         //    "description" => '$product->description',
         //    "price" => '$product->price',
         //    "category_id" => '$product->category_id',
         //    "category_name" => '$product->category_name'
         // );
         // echo json_encode($product_arr);

         // echo json_encode(
         //   array("message" => "No products found.")
         // );
      }
   }
}

?>