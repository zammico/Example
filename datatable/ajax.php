<?php
if(isset($_POST['key'])){
  		define("LOGIN",TRUE);
  		include "php/connection.php";
  		if($_POST['key']=='addnew'){
  			$name =  mysqli_escape_string($connect,$_POST['name']);
  			$brand = mysqli_escape_string($connect,$_POST['brand']);
  			$type = mysqli_escape_string($connect,$_POST['type']);
        $color = mysqli_escape_string($connect,$_POST['color']);
        $price = mysqli_escape_string($connect,$_POST['price']);
  			$hasilquery = mysqli_query($connect,"INSERT INTO car(name,brand,type,color,price) VALUES ('$name','$brand','$type','$color','$price')");
  			exit('Data Barang Has Been Inserted');
  		}
  		if($_POST['key']=='getData'){
  			$start = mysqli_escape_string($connect,$_POST['start']);
  			$limit = mysqli_escape_string($connect,$_POST['limit']);
  			$hasilquery = mysqli_query($connect,"SELECT * FROM car LIMIT $start, $limit");
  			if(mysqli_num_rows($hasilquery)>0){
  				$response = "";
  				while($data = mysqli_fetch_array($hasilquery)){
  					$response .= '
  						<tr>
  							<td>'.$data['carid'].'</td>
  							<td>'.$data['name'].'</td>
  							<td>'.$data['brand'].'</td>
  							<td>'.$data['type'].'</td>
                <td>'.$data['color'].'</td>
                <td>'.$data['price'].'</td>
  							<td>
  							<button class="btn btn-primary" onclick="edit('.$data['carid'].')" style="width:70px;border-radius:5px;"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
  							<button class="btn btn-danger" onclick="dels('.$data['carid'].')" style="width:80px;border-radius:5px;"><span class="glyphicon glyphicon-trash"></span></span> Drop</button>
  							</td>
  						</tr>

  					';
  				}
  				exit($response);
  			}else {
  				exit('limitMax');
  			}
  			exit('Data Barang Has Been Inserted');
  		}
  		if($_POST['key']=='selectRow'){
  			$id = mysqli_escape_string($connect,$_POST['data']);
  			$hasilquery = mysqli_query($connect,"SELECT * FROM car WHERE carid = $id");
  			if(mysqli_num_rows($hasilquery)>0){
  				$data = mysqli_fetch_array($hasilquery);
  				$temp = array(
  					'id' => $data['carid'],
  					'name' => $data['name'],
  					'brand' => $data['brand'],
  					'type' => $data['type'],
            'color' => $data['color'],
            'price' => $data['price']
  				);
  				exit(json_encode($temp));
  			}
  		}
  		if($_POST['key']=='update'){
  			$id = mysqli_escape_string($connect,$_POST['row']);
  			$name =  mysqli_escape_string($connect,$_POST['name']);
  			$brand = mysqli_escape_string($connect,$_POST['brand']);
  			$type = mysqli_escape_string($connect,$_POST['type']);
        $color = mysqli_escape_string($connect,$_POST['color']);
        $price = mysqli_escape_string($connect,$_POST['price']);
  			$hasilquery = mysqli_query($connect,"UPDATE car SET name='$name',brand='$brand',type='$type',color='$color',price=$price WHERE carid=$id");
  			exit('Data Barang Has Been Updated for row - '.$id);
  		}
  		if($_POST['key']=='delete'){
  			$id = mysqli_escape_string($connect,$_POST['data']);
  			$hasilquery = mysqli_query($connect,"DELETE FROM car WHERE carid=$id");
  			exit('Data Barang Has Been Updated for row - '.$id);
  		}
  		mysqli_close($connect);
  	}
?> 