<?php 
    session_start();
    include "koneksi.php";
	$username=$_SESSION['login'];
	date_default_timezone_set('Asia/Jakarta');
	$sequence = strval($_GET['pesan']);
	$waktu = date("Y-m-d H:i:s");
	$tampilkan="select * from users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);
	if($hasil=mysql_fetch_array($query_tampilkan)){
		$fullname=$hasil['username'];
	}
	else{
		Header("location:http://sps-food.com/?pesan=login");
	}
	
	
	if (isset($_POST['sign'])) {
	include "koneksi.php";
	
	$id=$_POST['id'];
	$kode_barang=$_POST['kode_barang'];
	$gramasi_barang='0';
	$kuantiti_barang=$_POST['kuantiti_barang'];
	$harga_modal=$_POST['harga_modal'];
	$biaya_opr = $_POST['biaya_opr'];
	$nama_supplier=$_POST['nama_supplier'];
	$alamat_supplier=$_POST['alamat_supplier'];
	$tanggal_masuk=$_POST['tanggal_masuk'];
	$tanggal_exp=$_POST['tanggal_exp'];
	$margin_keuntungan='0';
	$id_jual = $id .' '. $kode_barang;
	$harga_satuan = $harga_modal/$kuantiti_barang; 
	
	$insert ="insert into stock values('$id','$kode_barang','$id_jual','$gramasi_barang','$kuantiti_barang','$harga_modal','$biaya_opr','$nama_supplier','$alamat_supplier','$tanggal_masuk','$tanggal_exp','$margin_keuntungan','$fullname','$harga_satuan');";
	$insert_query = mysql_query($insert);
			if($insert_query){
			    $insert ="insert into audit_trial (user, waktu, activity,detil) values('$fullname','$waktu','InputStock','input');";
	            $insert_query = mysql_query($insert);
				Header("location:listStock.php?pesan=Tambah");
			}
			else{
				Header("location:inputStock.php?pesan=Tambah Stock gagal $insert");
			}
	}
	
	if (isset($_POST['add'])) {
	include "koneksi.php";
	
	$id=$_POST['id'];
	$kode_barang=$_POST['kode_barang'];
	$gramasi_barang='0';
	$kuantiti_barang=$_POST['kuantiti_barang'];
	$harga_modal=$_POST['harga_modal'];
	$biaya_opr = $_POST['biaya_opr'];
	$nama_supplier=$_POST['nama_supplier'];
	$alamat_supplier=$_POST['alamat_supplier'];
	$tanggal_masuk=$_POST['tanggal_masuk'];
	$tanggal_exp=$_POST['tanggal_exp'];
	$margin_keuntungan='0';
	$id_jual = $id .' '. $kode_barang;
	$harga_satuan = $harga_modal/$kuantiti_barang; 
	
	$insert ="insert into stock values('$id','$kode_barang','$id_jual','$gramasi_barang','$kuantiti_barang','$harga_modal','$biaya_opr','$nama_supplier','$alamat_supplier','$tanggal_masuk','$tanggal_exp','$margin_keuntungan','$fullname','$harga_satuan');";
	$insert_query = mysql_query($insert);
			if($insert_query){
			    $insert ="insert into audit_trial (user, waktu, activity,detil) values('$fullname','$waktu','InputStock','input');";
	            $insert_query = mysql_query($insert);
				Header("location:inputStockAdd.php?pesan=$id");
			}
			else{
				Header("location:inputStock.php?pesan=Tambah Stock gagal $insert");
			}

	}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sps Food</title>
  
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
        <li ><a href="inputBarang.php">Input Jenis Barang</a></li>
        <li class="active"><a href="inputStock.php">Input Stock</a></li>    
	    <li ><a href="listStock.php">List Stock</a></li>
        <li ><a href="inputPenjualan.php">Input Penjualan</a></li>	
        <li ><a href="listPenjualan.php">List Penjualan</a></li>
	    <li ><a href="laporan.php">Laporan Laba Rugi</a></li>  
	    <li ><a href="listRecord.php">List Record</a></li>  
	    <li ><a href="creatUser.php">Create User</a></li>
	    <li ><a href="summary.php">Summary</a></li>
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
<script>
  function strip(html)
{
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}
function showUser(str) {
	if (str == "") {
		document.getElementById("kode_barang").value = "121";
		return;
	} else { 
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("kode_barang").value = strip(this.responseText);
			}
		};
		xmlhttp.open("GET","getuser.php?q="+str,true);
		xmlhttp.send();
	}
}
 </script>

<div id="content">
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<?php 
				include "koneksi.php";
				$tampilkan="Select * from barang order by jenis_barang";
				$query_tampilkan=mysql_query($tampilkan);
			
				if ($data = mysql_fetch_array($query_tampilkan))
				{
				$kode= $data['kode_barang'];
				}
							
			?>
			<div class="row " >
				<div class="col-md-4" ></div>
				<div class="col-md-4" style="background-color:AliceBlue;">
				<h2 align="center">Input Stock</h1>
            <p id="profile-name" class="profile-name-card"></p>
            <form method="POST" >
                <label for="name1">No. Surat Jalan:</label>
                <input type="text" id="id" name="id" class="form-control" value="<?php echo "$sequence"?>" placeholder="No Surat Jalan" readonly></br>
				<label for="pwd">Jenis Barang:</label>: <Select Name="jenis_barang" id="jenis_barang" onchange="showUser(this.value)">
								
								<?php
									$tampilkan="Select * from barang order by jenis_barang";
									$query_tampilkan=mysql_query($tampilkan);
									while ($data = mysql_fetch_array($query_tampilkan))
									{

										echo "<option >".$data['jenis_barang']."</option>";
									}
				
								?>
								
								
								</Select><br>
				<label for="text">Kode Barang:</label>
				<input type="text" id="kode_barang" name="kode_barang" class="form-control" value="<?php echo "$kode"?>" placeceholder="kode_barang"  readonly></br>				
				<label for="pwd">Kuantiti Barang:</label>
                <input type="number" id="kuantiti_barang" name="kuantiti_barang" class="form-control" placeholder="kuantiti barang" required></br>			
				<!--<label for="pwd">Gramasi Barang:</label>
                <input type="text" id="gramasi_barang" name="gramasi_barang" class="form-control" placeholder="Gramasi barang" required></br>-->		
				<label for="pwd">Harga Modal:</label>
                <input type="number" id="harga_modal" name="harga_modal" class="form-control" placeholder="harga modal" step=".01" required></br>
				<!--<label for="pwd">Biaya Operasional:</label>
                <input type="number" id="biaya_opr" name="biaya_opr" class="form-control" placeholder="biaya Operasional" required></br>-->
				<!--<label for="pwd">Margin Keuntungan:</label>-->
                <input type="hidden" id="margin_keuntungan" name="margin_keuntungan" class="form-control" placeholder="margin keuntungan" required></br>					
				<label for="pwd">Nama Supplier:</label>
                <input type="text" id="nama_supplier" name="nama_supplier" class="form-control" placeholder="nama supplier" required></br>				
				<label for="pwd">Alamat Supplier:</label>
                <input type="text" id="alamat_supplier" name="alamat_supplier" class="form-control" placeholder="alamat supplier" required></br>				
				<label for="pwd">Tanggal Masuk:</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" placeholder="tanggal masuk" required></br>				
				<label for="pwd">Tanggal exp:</label>
                <input type="date" id="tanggal_exp" name="tanggal_exp" class="form-control" placeholder="tanggal exp" required></br>	
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="add">Add</button></br>				
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="sign">Save</button></br>
        </form>
				</div>

		</div>
		</div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>
