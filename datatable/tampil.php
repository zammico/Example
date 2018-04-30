<html>
<head>
<title>Tampil</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<style type="text/css">
	body
	{
	    font-family: Optima, ‘Lucida Grande’, ‘Lucida Sans Unicode’, Verdana, Helvetica, Arial, sans-serif;

	}

	body .btn{
	    border-radius: 0;
	    width: 25%;
	}

	body .table{
	    text-align: center;
	    font-size: 15px;
	}

	thead{
	    font-style: bold !important;
	}
</style>
</head>

<body>
<div id="myNavbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
				 <span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a href="#" class="navbar-brand">Admin Panel</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#barang">Barang</a></li>
			</ul>
		</div>
	</div>
</div>

<div id="barang" class="container" style="margin-top: 5%;">
	<div id="inputModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-title" align="center">
					<h2>INSERT DATA NEW CAR</h2>
				</div>
				<div class="modal-body">
					<input type="text" class="form-control ins" placeholder="Name" id="nameCar" value="Karasu"><br>
					<input type="text" class="form-control ins" placeholder="Brand" id="brandCar" value="White Karasu"><br>
					<input type="text" class="form-control ins" placeholder="Type" id="typeCar" value="magnet"><br>
					<input type="text" class="form-control ins" placeholder="Color" id="colorCar" value="white"><br>
					<input type="text" class="form-control ins" placeholder="Price" id="priceCar" value="5000000"><br>
					<input type="hidden" id="rowId" val="0">
				</div>
				<div class="modal-footer">
					<input type="button" value="Save" id="submitForm" class="btn btn-success" onClick="uploadData('addnew');">
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading"><strong><h2>Data Barang</h2></strong></div>
  		<div class="panel-body">
			<div class="row">
				<div class="col-md-10 col-md-offset-1" align="center">
					<button class="btn btn-success" style="float :right; margin-bottom: 2%;" id="addnew"><span class="glyphicon glyphicon-file"></span> Add New Car</button><br><br><br>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<td>ID</td>
								<td>Name</td>
								<td>Brand</td>
								<td>Type</td>
								<td>Color</td>
								<td>Price</td>
								<td>OPTIONS</td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#addnew').on('click', function(){
			$('#inputModal').modal('show');
		});
		displayData(0,50);
	});

	function displayData(start,limit){
		$.ajax({
			url: 'ajax.php',
			method: 'POST',
			dataType: 'text',
			data: {
				key: 'getData',
				start: start,
				limit: limit
			}, success: function (response) {
				if(response != 'limitMax'){
					$('tbody').append(response);
					start += limit;
					displayData(start,limit);
				}else {
					$(".table").DataTable();
				}
			}
		});
	}

	function uploadData(data){
		var name  = $('#nameCar');
		var brand = $('#brandCar');
		var type  = $('#typeCar');
		var color = $('#colorCar');
		var price = $('#priceCar');
		if(cekInsert(name) && cekInsert(brand) && cekInsert(type) && cekInsert(color) && cekInsert(price)){
			$.ajax({
				url: 'ajax.php',
				method: 'POST',
				dataType: 'text',
				data: {
					key: data,
					name: name.val(),
					brand: brand.val(),
					type: type.val(),
					color: color.val(),
					price: price.val()
				}, success: function (response) {
					//alert(response);
					$(".table").DataTable().destroy();
					$('tbody').empty();
					$("#inputModal").modal('hide');
					$('#inputModal').on('hidden.bs.modal', function(){
					    $('.ins').val("");
					});
					displayData(0,50);
				}
			});
		}
	}

	function edit(row){
		$.ajax({
			url: 'ajax.php',
			method: 'POST',
			dataType: 'json',
			data: {
				key: 'selectRow',
				data: row
			}, success: function (response) {
				$('#rowId').val(response.id);
				$('#nameCar').val(response.name);
				$('#brandCar').val(response.brand);
				$('#typeCar').val(response.type);
				$('#colorCar').val(response.color);
				$('#priceCar').val(response.price);
				$('#inputModal').modal('show');
				$('#submitForm').attr('value', 'Update').attr('onclick',"updateRow('update')");
			}
		});
	}

	function updateRow(update){
		var row   = $('#rowId');
		var name  = $('#nameCar');
		var brand = $('#brandCar');
		var type  = $('#typeCar');
		var color = $('#colorCar');
		var price = $('#priceCar');
		if(cekInsert(name) && cekInsert(brand) && cekInsert(type) && cekInsert(color) && cekInsert(price)){
			$.ajax({
				url: 'ajax.php',
				method: 'POST',
				dataType: 'text',
				data: {
					key: update,
					row: row.val(),
					name: name.val(),
					brand: brand.val(),
					type: type.val(),
					color: color.val(),
					price: price.val()
				}, success: function (response) {
					//alert(response);
					$(".table").DataTable().destroy();
					$('tbody').empty();
					$("#inputModal").modal('hide');
					$('#inputModal').on('hidden.bs.modal', function(){
					    $('.ins').val("");
					});
					displayData(0,50);
				}
			});
		}
	}

	function dels(row){
		$.ajax({
			url: 'ajax.php',
			method: 'POST',
			dataType: 'text',
			data: {
				key: 'delete',
				data: row
			}, success: function (response) {
				//alert(response);
				$(".table").DataTable().destroy();
				$('tbody').empty();
				displayData(0,50);
			}
		});
	}

	function cekInsert(input){
		if(input.val() == ''){
			input.css('border', '1px solid red');
			return false;
		} else {
			input.css('border', '');
			return true;
		}
	}
</script>
</body>
</html>