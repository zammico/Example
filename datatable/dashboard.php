<html>
<?php
include 'php/connection.php';
$queryCar = mysqli_query($connect,"SELECT * FROM car");
$queryCust = mysqli_query($connect,"SELECT * FROM customers");
$queryOrder = mysqli_query($connect,"SELECT * FROM ordercar");
$getRowCar = mysqli_num_rows($queryCar);
$getRowCust = mysqli_num_rows($queryCust);
$getRowOrder = mysqli_num_rows($queryOrder);

?>

<body>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-server"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>All Vehicle</p>
                                            <?php echo $getRowCar; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> <a href="home.php?menu=table" style="color:#a9a9a9;">Updated now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Transaction</p>
                                            <?php echo $getRowOrder; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> <a href="home.php?menu=transaction" style="color:#a9a9a9;">View Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Customers</p>
                                            <?php echo $getRowCust; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-timer"></i> In the last hour
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">New Credit Vehicle</h4>
                            </div>
                            <div class="content">
                                <form method="post" action="">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ID CAR</label>
                                                <select class="form-control border-input" onchange="carDetails(this.value)" name="id_car">
                                                	<?php
                                                		while ($getColumnCar=mysqli_fetch_array($queryCar)) {
                                                			extract($getColumnCar);
                                                			echo "<option value='$carid'>$carid | $name | $brand</option>";
                                                		}

                                                	?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">ID Customers</label>
                                                <select class="form-control border-input" name="custid">
                                                	<?php
                                                		while ($getColumnCust=mysqli_fetch_array($queryCust)) {
                                                			extract($getColumnCust);
                                                			echo "<option value='$custid'>$custid | $firstname $lastname</option>";
                                                		}

                                                	?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Credit Periode</label>
                                                <select class="form-control border-input" name="credit_periode">
                                               		<option value="6">6 Month   | 2%</option>
                                               		<option value="12">12 Month | 3,4%</option>
                                               		<option value="24">24 Month | 4,7%</option>
                                               		<option value="48">48 Month | 5,4%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admin</label>
                                                <input type="text" value="<?php echo $_SESSION['username'] ?>" class="form-control border-input" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd" 
                                        style="border-radius: 0px;" name="order"><span class="ti-shopping-cart"></span> Order</button>
                                     </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>  
                </div>
                <div class="col-lg-4 col-md-5" id="getCar">
                </div>
             </div>
          </div>
</body>
</html>
<script type="text/javascript">
function carDetails(str){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("getCar").innerHTML = xmlhttp.responseText;    
            }
    };
    xmlhttp.open("GET","php/carDetailsAjax.php?q=" +str,true);
    xmlhttp.send();
}
</script>

<?php
if (isset($_POST['order'])) {
date_default_timezone_set("Asia/Jakarta");
$empid = $_SESSION['user'];
$custid = $_POST['custid'];
$carid = $_POST['id_car'];
$orderdate = date("Y-m-d");
$periode = $_POST['credit_periode'];
$credit = "";
$queryGetPrice = mysqli_query($connect,"SELECT * FROM car WHERE carid='$carid'");
$getPrice = mysqli_fetch_array($queryGetPrice);
$price = $getPrice['price'];

$queryGetCustomers = mysqli_query($connect,"SELECT * FROM ordercar WHERE custid = '$custid'");
$getCustomer = mysqli_num_rows($queryGetCustomers);

switch ($periode) {
    case '6':
        $credit = ($price+($price * 0.02))/$periode;
    break;
    case '12':
        $credit = ($price+($price * 0.034))/$periode;
    break;
    case '24':
        $credit = ($price+($price * 0.047))/$periode;
    break;
    case '48':
        $credit = ($price+($price * 0.054))/$periode;
    break;
}
if ($getCustomer>=1) {
echo "
    <script>
        alert('This Customer cannot order again!');
    </script>";
}else{
$insert = mysqli_query($connect,"INSERT INTO ordercar (orderid,empid,custid,carid,orderdate,periode,paymonth)
                        VALUES(NULL,'$empid','$custid','$carid','$orderdate','$periode','$credit')") or die(mysql_error($insert));
echo "
    <script>
        alert('Transaction Succesfull')
    </script>";
    }
}
?>