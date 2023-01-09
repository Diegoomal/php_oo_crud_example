<?php 

include_once('init.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(is_null($_POST['submit'])) {		
		echo 'submit error';
	} 

	if($_POST['submit'] == 'insert') {

		if(is_null($_POST['inputInsertFirstName'])) {
			echo 'Input first name null';
		}

		if(is_null($_POST['inputInsertLastName'])) {
			echo 'Input last name null';
		}

		$person = new Person();
		$person->setter_id('');
    	$person->setter_dtRegister('');
		$person->setter_firstName($_POST['inputInsertFirstName']);
		$person->setter_lastName($_POST['inputInsertLastName']);

		(new ControllerPessoa())->insert($person);

	} else if($_POST['submit'] == 'update') {

		if(is_null($_POST['inputUpdateFirstName'])) {
			echo 'Input first name null';
		}

		if(is_null($_POST['inputUpdateLastName'])) {
			echo 'Input last name null';
		}

		$person = new Person();
		$person->setter_id($_POST['inputUpdateHiddenId']);
		$person->setter_dtRegister('');
		$person->setter_firstName($_POST['inputUpdateFirstName']);
		$person->setter_lastName($_POST['inputUpdateLastName']);
		(new ControllerPessoa())->update($person);

	} else if($_POST['submit'] == 'delete') {
		
		$person = new Person();
		$person->setter_id($_POST['inputDeleteHiddenId']);
		$person->setter_dtRegister('');
		$person->setter_firstName('');
		$person->setter_lastName('');

		(new ControllerPessoa())->delete($person);

	} 
	
}

$person = new Person();
$person->setter_id(0);
$controllerPerson = new ControllerPessoa();
$entities = $controllerPerson->read($person);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> List Person </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<style>
		.wrapper{ width: 1000px; margin: 0 auto; }
		table tr td:last-child{ width: 120px; }
	</style>
</head>
<body>

	<!-- Body - List Person -->

	<div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<div class="mt-5 mb-3 clearfix">
						<h2 class="pull-left">Persons Details</h2>
						<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalInsertPerson" id="btnInsertPerson" name="btnInsertPerson" > Add New Person </button>
					</div>

					<table class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Id</th>
								<th scope="col">First</th>
								<th scope="col">Last</th>
								<th scope="col" class="col-md-2">Actions</th>
							</tr>
						</thead>
						<tbody>
							<!-- rows created dinamically -->
						</tbody>
					</table>
    
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Insert Person -->

	<div class="modal fade" id="ModalInsertPerson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<form class="modal-body" action="" method="post" enctype="multipart/form-data" class="form-inline">

					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Insert New Person</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
					<div class="form-group">
						<label for="inputFirstName">First Name</label>
						<input type="text" class="form-control" id="inputInsertFirstName" name="inputInsertFirstName" aria-describedby="firstNameHelp" placeholder="First Name">
						<!-- <small id="firstNameHelp" class="form-text text-muted">First Name</small> -->
					</div>
					
					<div class="form-group">
						<label for="inputLastName">Last Name</label>
						<input type="text" class="form-control" id="inputInsertLastName" name="inputInsertLastName" aria-describedby="lastNameHelp" placeholder="Last Name">
						<!-- <small id="lastNameHelp" class="form-text text-muted">Last Name</small> -->
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary pull-right" id="submit" name="submit" value="insert">Save</button>
					</div>

				</form>

			</div>
		</div>
	</div>

	<!-- Modal Read Person -->

	<div class="modal fade" id="ModalReadPerson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Read Person</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="form-group">
						<label for="inputReadId">Id</label>
						<input type="text" class="form-control" id="inputReadId" name="inputReadId" aria-describedby="firstNameHelp" placeholder="First Name" disabled>
					</div>
					<div class="form-group">
						<label for="inputReadFirstName">First Name</label>
						<input type="text" class="form-control" id="inputReadFirstName" name="inputReadFirstName" aria-describedby="firstNameHelp" placeholder="First Name" disabled>
					</div>
					<div class="form-group">
						<label for="inputReadLastName">Last Name</label>
						<input type="text" class="form-control" id="inputReadLastName" name="inputReadLastName" aria-describedby="lastNameHelp" placeholder="Last Name" disabled>
					</div>					
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Update Person -->

	<div class="modal fade" id="ModalUpdatePerson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<form class="modal-body" action="" method="post" enctype="multipart/form-data" class="form-inline">

					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Update Person</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<input type="hidden" id="inputUpdateHiddenId" name="inputUpdateHiddenId" value="_42_" />
					
					<div class="form-group">
						<label for="inputUpdateFirstName">First Name</label>
						<input type="text" class="form-control" id="inputUpdateFirstName" name="inputUpdateFirstName" aria-describedby="firstNameHelp" placeholder="First Name">
						<!-- <small id="firstNameHelp" class="form-text text-muted">First Name</small> -->
					</div>
					
					<div class="form-group">
						<label for="inputUpdateLastName">Last Name</label>
						<input type="text" class="form-control" id="inputUpdateLastName" name="inputUpdateLastName" aria-describedby="lastNameHelp" placeholder="Last Name">
						<!-- <small id="lastNameHelp" class="form-text text-muted">Last Name</small> -->
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary pull-right" id="submit" name="submit" value="update">Save</button>
					</div>

				</form>

			</div>
		</div>
	</div>

	<!-- Modal Delete Person -->

	<div class="modal fade" id="ModalDeletePerson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<form class="modal-body" action="" method="post" enctype="multipart/form-data" class="form-inline">

					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Delete Person</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
					<input type="hidden" id="inputDeleteHiddenId" name="inputDeleteHiddenId" value="_42_" />

					<div class="form-group">
						<label for="inputDeleteFirstName">First Name</label>
						<input type="text" class="form-control" id="inputDeleteFirstName" name="inputDeleteFirstName" aria-describedby="firstNameHelp" placeholder="First Name" disabled>
						<!-- <small id="firstNameHelp" class="form-text text-muted">First Name</small> -->
					</div>
					
					<div class="form-group">
						<label for="inputDeleteLastName">Last Name</label>
						<input type="text" class="form-control" id="inputDeleteLastName" name="inputDeleteLastName" aria-describedby="lastNameHelp" placeholder="Last Name" disabled>
						<!-- <small id="lastNameHelp" class="form-text text-muted">Last Name</small> -->
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary pull-right" id="submit" name="submit" value="delete">Save</button>
					</div>

				</form>

			</div>
		</div>
	</div>

</body>

<script>

	let entities = null;

	$(document).ready(function() { 

		function empty(str) {
			return (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g,"") === "") ? true : false;
		}

		function printLog(entities) {
			entities.forEach(element => {
				console.log(
					'id: ' + (!empty(element.id) ? element.id : 'NULL')
					+ ' dtRegister: ' + (!empty(element.dtRegister) ? element.dtRegister : 'NULL') 
					+ ' firstName: ' + (!empty(element.firstName) ? element.firstName : 'NULL') 
					+ ' lastName: ' + (!empty(element.lastName) ? element.lastName : 'NULL')
				);
			});
		}

		function bindTableData() {
			entities.forEach((element, index) => {					
				let html_template_row =
					'<tr>' +
						'<th scope="row">' + index + '</th>' +
						'<td>' + element.id + '</td>' +
						'<td>' + element.firstName + '</td>' +
						'<td>' + element.lastName + '</td>' +
						'<td>' + 
							'<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalReadPerson" value="' + element.id + '">' +
								'<i class="bi bi-eye-fill"></i>' +
							'</button>' +
							'<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalUpdatePerson" value="' + element.id + '">' +
								'<i class="bi bi-pencil-square"></i>' +
							'</button>' +
							'<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDeletePerson" value="' + element.id + '">' +
								'<i class="bi bi-trash-fill"></i>' +
							'</button>' + 
						'</td>' +
					'</tr>';
				$('.table').append(html_template_row);
			});
		}

		entities = <?php echo json_encode($entities); ?> ;

		printLog(entities);

		bindTableData();

		$('.btn.btn-primary').on('click', function() {

			$('#inputReadId').val('null');
			$('#inputReadFirstName').val('null');
			$('#inputReadLastName').val('null');

			let person_id = $(this).attr('value');

			let filteredPerson = entities.find(x => x.id === person_id);

			// console.log(
			// 	'::filtro::Read:: ==> '
			// 	+ 'id: ' + (!empty(filteredPerson.id) ? filteredPerson.id : 'NULL')
			// 	+ ' dtRegister: ' + (!empty(filteredPerson.dtRegister) ? filteredPerson.dtRegister : 'NULL') 
			// 	+ ' firstName: ' + (!empty(filteredPerson.firstName) ? filteredPerson.firstName : 'NULL') 
			// 	+ ' lastName: ' + (!empty(filteredPerson.lastName) ? filteredPerson.lastName : 'NULL')
			// );

			$('#inputReadId').val(person_id);
			$('#inputReadFirstName').val(filteredPerson.firstName);
			$('#inputReadLastName').val(filteredPerson.lastName);
			
		});

		$('.btn.btn-success').on('click', function() {

			$('#inputUpdateHiddenId').val('null');
			$('#inputUpdateFirstName').val('null');
			$('#inputUpdateLastName').val('null');

			let person_id = $(this).attr('value');

			let filteredPerson = entities.find(x => x.id === person_id);

			// console.log(
			// 	'::filtro::Update:: ==> '
			// 	+ 'id: ' + (!empty(filteredPerson.id) ? filteredPerson.id : 'NULL')
			// 	+ ' dtRegister: ' + (!empty(filteredPerson.dtRegister) ? filteredPerson.dtRegister : 'NULL') 
			// 	+ ' firstName: ' + (!empty(filteredPerson.firstName) ? filteredPerson.firstName : 'NULL') 
			// 	+ ' lastName: ' + (!empty(filteredPerson.lastName) ? filteredPerson.lastName : 'NULL')
			// );

			$('#inputUpdateHiddenId').val(person_id);
			$('#inputUpdateFirstName').val(filteredPerson.firstName);
			$('#inputUpdateLastName').val(filteredPerson.lastName);

		});

		$('.btn.btn-danger').on('click', function() {

			$('#inputDeleteHiddenId').val('null');
			$('#inputDeleteFirstName').val('null');
			$('#inputDeleteLastName').val('null');

			let person_id = $(this).attr('value');

			let filteredPerson = entities.find(x => x.id === person_id);

			// console.log(
			// 	'::filtro::Delete:: ==> '
			// 	+ 'id: ' + (!empty(filteredPerson.id) ? filteredPerson.id : 'NULL')
			// 	+ ' dtRegister: ' + (!empty(filteredPerson.dtRegister) ? filteredPerson.dtRegister : 'NULL') 
			// 	+ ' firstName: ' + (!empty(filteredPerson.firstName) ? filteredPerson.firstName : 'NULL') 
			// 	+ ' lastName: ' + (!empty(filteredPerson.lastName) ? filteredPerson.lastName : 'NULL')
			// );

			$('#inputDeleteHiddenId').val(person_id);
			$('#inputDeleteFirstName').val(filteredPerson.firstName);
			$('#inputDeleteLastName').val(filteredPerson.lastName);

		});


	});

</script>