<?php 
    session_start();
    date_default_timezone_set('Asia/Jakarta');
	$waktu = date("Y-m-d H:i:s");
    include "koneksi.php";
	$username=$_SESSION['login'];
	$tampilkan="select * from users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);
	if($hasil=mysql_fetch_array($query_tampilkan)){
		if($username=="manager"){
		    $fullname=$hasil['username'];
		}
		else{
		    Header("location:http://sps-food.com/?pesan=login");
		}
	}
	else{
	    Header("location:http://sps-food.com/?pesan=login");
	}
	$pesan="";
	if (isset($_POST['sign'])) {
	include "koneksi.php";
	$id=$_POST['id'];
	$jenis_barang=$_POST['jenis_barang'];
    $satuan=$_POST['satuan'];

    $tampilkan="select * from barang where kode_barang = '$id' or jenis_barang = '$jenis_barang';";
	$query_tampilkan=mysql_query($tampilkan);
    if(!$hasil=mysql_fetch_array($query_tampilkan))
    	{
    			$insert ="insert into barang values('$id','$jenis_barang','$satuan');";
    			$insert_query = mysql_query($insert);
    					if($insert_query){
    					    
    					    $insert ="insert into audit_trial (user, waktu, activity) values('$fullname','$waktu','inputBarang');";
    	                    $insert_query = mysql_query($insert);
    	                    /*header("location:inputStock.php?pesan=Tambah");
    	                    echo '<script type="text/javascript">alert("'.$id.','.$jenis_barang.'")</script>';*/
    	                    $message= "Berhasil menambahkan Data Barang $id, $jenis_barang, $satuan";
    	                    $_SESSION['message']=$message;
                            header("location:inputStock.php?pesan=Tambah");
    					}
    					else{
    						$message = "Masukan Jenis/Kode Barang yang berbeda";
                            echo "<script type='text/javascript'>alert('$message');</script>";
    						
    					}
    	}
    else
    	{
    	   $pesan="salah";
    	}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SPS Food</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color:MintCream;">
<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="logokecil.png" height="35" width="200"></a>
    </div>
    <ul class="nav navbar-nav">
        <li class="active" ><a href="inputBarang.php">Input Jenis Barang</a></li>
      <li ><a href="inputStock.php">Input Stock</a></li>    
	    <li ><a href="listStock.php">List Stock</a></li>
        <li ><a href="inputPenjualan.php">Input Penjualan</a></li>	
        <li ><a href="listPenjualan.php">List Penjualan</a></li>
	    <li ><a href="laporan.php">Laporan Laba Rugi</a></li>
	    <li ><a href="summary.php">Summary Penjualan</a></li>
	    <li ><a href="listRecord.php">List Record</a></li>  
	    <li ><a href="creatUser.php">Create User</a></li>

    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><?php echo ' '.$fullname;?>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="editprofil.php" <span class="glyphicon glyphicon-edit"></span> ManageAccount</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp&nbsp&nbspSign Out</a></li>
          
        </ul>
      </li>
	  
    </ul>
  </div>
</nav>

<div id="content">
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<div class="row " >
				<div class="col-md-4" ></div>
				<div class="col-md-4" style="background-color:AliceBlue;">
				<h2 align="center">Input Jenis Barang</h1>
            <p id="profile-name" class="profile-name-card"></p>
            <form method="POST" >
                <label for="name1">Kode Barang:</label>
                <input type="text" id="id" name="id" class="form-control" placeholder="Kode Barang" required></br>
				<label for="pwd">Jenis Barang:</label>
                <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" placeholder="Jenis Barang" required></br>
                <label for="name1">Satuan Barang:</label>
                <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Gramasi" required></br>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="sign">Save</button></br>
				<?php
				
				if($pesan=="salah"){
					//echo "Wrong password or email. Try again or click Forgot password to reset it";
					echo '
					<div class="alert alert-danger">
					<strong>Gagal!</strong>';
							echo " Nama barang atau kode barang sudah ada!";
							echo '</div>'	;
				}
				?>
        </form>
				</div>

		</div>
		</div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>