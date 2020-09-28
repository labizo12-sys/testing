<?php 
    session_start();
    include "koneksi.php";
	$username=$_SESSION['login'];
	
	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
	
	$tampilkan="select * from users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);	
	date_default_timezone_set('Asia/Jakarta');
    $waktu2 = date("d-M-Y");
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
	
	if (isset($_GET['tidak'])) {
		//echo "masuk tidak successfully";
		Header("location:listPenjualan.php?pesan=Tambah");
		
	}
	
	if (isset($_GET['iya'])) {
		$id=$_GET['id'];
		$tampilkan="select * from penjualan where id_penjualan = '$id';";
		$query_tampilkan=mysql_query($tampilkan);
		$hasil=mysql_fetch_array($query_tampilkan);
		$id_stock = $hasil['id_stock'];
		$kode_barang =$hasil['kode_barang'];
		$id_penjualan = $hasil['id_penjualan'];
		$qty_jual = $hasil['kuantiti_barang'];
		
		$tampilkan2="select * from stock where id_stock = '$id_stock' and kode_barang = '$kode_barang';";
		$query_tampilkan2=mysql_query($tampilkan2);
		$hasil2=mysql_fetch_array($query_tampilkan2);
		$qty_stock = $hasil2['kuantiti_barang'];
		$update_qty = $qty_jual+$qty_stock;
		$update = "update stock set kuantiti_barang='$update_qty' where id_stock = '$id_stock' and kode_barang = '$kode_barang';";
		$update_query = mysql_query($update);
		
		$sql = "DELETE FROM penjualan where id_penjualan = '$id';";
		if (mysql_query($sql) == TRUE) {
		  //echo "Record deleted successfully";
		  Header("location:listPenjualan.php?pesan=Delete Berhasil");
		} else {
		  echo "Error deleting record: " . $conn->error;
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
  <?php 
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$tampilkan="select * from penjualan where id_penjualan = '$id';";
		$query_tampilkan=mysql_query($tampilkan);
		$hasil=mysql_fetch_array($query_tampilkan);
		$id_stock = $hasil['id_stock'];
		$nama_pembeli=$hasil['nama_pembeli'];
		$kode_barang =$hasil['kode_barang'];
		$id_penjualan = $hasil['id_penjualan'];
		$qty_jual = $hasil['kuantiti_barang'];
		
		$tampilkan2="select * from stock where id_stock = '$id_stock' and kode_barang = '$kode_barang';";
		$query_tampilkan2=mysql_query($tampilkan2);
		$hasil2=mysql_fetch_array($query_tampilkan2);
		$qty_stock = $hasil2['kuantiti_barang'];
	}
  ?>
	  <form>
		<input hidden type="text" id="id" name="id" value="<?php echo "$id"?>" required readonly></br>
		Apakah Yakin ingin menghapus Penjualan berikut ? 
		<br/>
		Nama Pembeli = <?php echo $nama_pembeli; ?>
		<br/>
		Kode Barang = <?php echo $kode_barang; ?>
		</br>	
		Jumlah Barang yang dibeli = <?php echo $qty_jual; ?>
		</br>
		<button type="submit" name="iya" value = "iya">Iya</button>			
		<button type="submit" name="tidak" value = "tidak">Tidak</button></br>
	</form>
  </div>
</nav>

</body>
</html>