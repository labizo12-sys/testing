<?php 
    session_start();
    include "koneksi.php";
	$username=$_SESSION['login'];
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
	$sum="";
	$tanggal_akhir="";
	$tanggal_awal="";
	$nama_pembeli="";
	$nama_barang="";
?>
<script type="text/javascript">
function getValue(x) {
  if(x.value == 'pembeli'){
    document.getElementById("yourfield").style.display = 'block'; // you need a identifier for changes
    document.getElementById("yourfield2").style.display = 'none'; // you need a identifier for changes
  }
  else{
	document.getElementById("yourfield").style.display = 'none'; // you need a identifier for changes
    document.getElementById("yourfield2").style.display = 'block';  // you need a identifier for changes
  }
}
</script>
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
        <li ><a href="inputStock.php">Input Stock</a></li>    
	    <li ><a href="listStock.php">List Stock</a></li>
        <li ><a href="inputPenjualan.php">Input Penjualan</a></li>	
        <li ><a href="listPenjualan.php">List Penjualan</a></li>
	    <li ><a href="laporan.php">Laporan Laba Rugi</a></li>
	    <li class="active" ><a href="summary.php">Summary Penjualan</a></li>
	    <li ><a href="listRecord.php">List Record</a></li>  
	    <li ><a href="creatUser.php">Create User</a></li>
		

    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><?php echo ' '."$fullname";?>
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
        	<h2 align="center">Summary Penjualan</h2>
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<br>
			<form method="POST"  >
			<label for="pwd">Summary By :</label>
			<Select Name="id" id="id" value="<?php echo $sum; ?>" onChange="getValue(this)">
				<option value="barang">Summary Barang</option>
				<option value="pembeli">Summary Pembeli</option>
			</Select>
			<div id="yourfield" style="display:none;"> 

			<label for="pwd">Nama Pembeli:</label>: <Select Name="nama_pembeli" id="nama_pembeli" value="<?php echo $nama_pembeli; ?>">
				<?php
					$tampilkan="Select distinct nama_pembeli from penjualan order by nama_pembeli";
					$query_tampilkan=mysql_query($tampilkan);
					while ($data = mysql_fetch_array($query_tampilkan))
					{

						echo "<option >".$data['nama_pembeli']."</option>";
					}

				?>
			</Select><br>
			</div>
			<div id="yourfield2" style="display:block;"> 
			<label for="pwd">Jenis Barang:</label>: <Select Name="nama_barang" id="nama_barang" value="<?php echo $nama_barang; ?>">
								
				<?php
					$tampilkan="Select * from barang order by jenis_barang";
					$query_tampilkan=mysql_query($tampilkan);
					while ($data = mysql_fetch_array($query_tampilkan))
					{

						echo "<option >".$data['jenis_barang']."</option>";
					}

				?>
								
								
			</Select><br>
			</div>
			<label for="pwd">Periode:</label>
			<input type="date" style="width:160px;" id="tanggal_awal" name="tanggal_awal" class="form-control" value="<?php echo $tanggal_awal; ?>" placeholder="tanggal masuk" required>			
			<label for="pwd"> Sampai </label>
            <input type="date" style="width:160px;" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="<?php echo $tanggal_akhir; ?>" placeholder="tanggal exp" required></br>	
			<button type="submit" name="sign">Sort</button></br>
			</form>
			</div>
			<div id="content2">
			<?php 
			if(isset($_GET["pesan"])){
			$pesan= $_GET["pesan"];
			//echo $pesan;
				if($pesan=="berhasil"){
					//echo "Upload Success";
					echo '
								<div class="alert alert-success">
								<strong>Success!</strong>';
						echo " Upload Success";
						echo '</div>'	;
				}
				else if($pesan=="gagal"){
					//echo "Upload Failed";
					echo '
					<div class="alert alert-danger">
					<strong>Failed!</strong>';
							echo " Upload Failed";
							echo '</div>'	;
				}
				else if($pesan=="berhasil2"){
					//echo "Upload Success";
					echo '
								<div class="alert alert-success">
								<strong>Success!</strong>';
						echo " Download Success";
						echo '</div>'	;
				}	
				
				
			}
			
		
			?>
			
			
            
                <?php
				if (isset($_POST['sign'])) {
					echo '
					<p>
			
					<table  class="table table-hover">
			
					<tr bgcolor="#ccffff">
					<th width="30">No. Surat Penjualan</th>
                    <th width="150">Nama Pembeli</th>
                    <th width="100">Alamat Pembeli</th>
                    <th width="70">Kode Barang</th>
                    <th width="70">Jenis Barang</th>
					<th width="70">Gramasi</th>
					<th width="70">Harga Jual</th>
					<th width="70">Biaya Transport</th>
					<th width="70">Biaya JNE</th>
					<th width="70">Biaya Komisi</th>
					<th width="150">Kuantiti Penjualan</th>
					<th width="150">Harga Total Penjualan</th>
                </tr>
					';
					$tanggal_awal=$_POST['tanggal_awal'];
					$tanggal_akhir=$_POST['tanggal_akhir'];
					$sum=$_POST['id'];
					if($sum=="barang"){
						$nama_barang=$_POST['nama_barang'];
						$tampilkan="select * from transaksi c join penjualan a on c.id_penjualan= a.id_penjualan join barang b on a.kode_barang = b.kode_barang  where b.jenis_barang='$nama_barang' and tanggal_jual between '$tanggal_awal' AND '$tanggal_akhir' ORDER BY b.jenis_barang ASC;";
					}
					else if($sum=="pembeli"){
						$nama_pembeli=$_POST['nama_pembeli'];
						$tampilkan="select * from transaksi c join penjualan a on c.id_penjualan= a.id_penjualan join barang b on a.kode_barang = b.kode_barang  where a.nama_pembeli='$nama_pembeli' and tanggal_jual between '$tanggal_awal' AND '$tanggal_akhir' ORDER BY b.jenis_barang ASC;";
					}
					$query_tampilkan=mysql_query($tampilkan);
						$temp = 0;
						$temp2= "";
						while($hasil=mysql_fetch_array($query_tampilkan))
						{
								$id_transaksi=$hasil['id_transaksi'];
								$nama_pembeli2=$hasil['nama_pembeli'];
								$alamat_pembeli=$hasil['alamat_pembeli'];
								$kode_barang=$hasil['kode_barang'];
								$jenis_barang=$hasil['jenis_barang'];
								$gramasi_barang=$hasil['satuan'];
								$harga_jual=$hasil['harga_jual'] - ($hasil['biaya_transport']/$hasil['jumlah_pembelian']+$hasil['biaya_jne']/$hasil['jumlah_pembelian']+$hasil['biaya_komisi']/$hasil['jumlah_pembelian']);
								$biaya_transport=$hasil['biaya_transport']/$hasil['jumlah_pembelian'];
								$biaya_jne=$hasil['biaya_jne']/$hasil['jumlah_pembelian'];
								$biaya_komisi=$hasil['biaya_komisi']/$hasil['jumlah_pembelian'];
								$jumlah_pembelian=$hasil['jumlah_pembelian'];
								$harga_total_pembelian=$hasil['harga_total_pembelian'];
								$temp = $temp + $jumlah_pembelian*1;
								$temp2 = $jenis_barang;
								$harga_jual=number_format($harga_jual*1, 2, ',', '.');
								$harga_total_pembelian=number_format($hasil['harga_jual']*$hasil['jumlah_pembelian']*1, 2, ',', '.');
								echo '
									<tr >	
									<td align="center">SJP - '.$id_transaksi.'</td>						
									<td >'.$nama_pembeli2.'</td>
									<td >'.$alamat_pembeli.'</td>
									<td >'.$kode_barang.'</td>
									<td >'.$jenis_barang.'</td>
									<td >'.$gramasi_barang.'</td>
									<td >'.$harga_jual.'</td>
									<td >'.$biaya_transport.'</td>
									<td >'.$biaya_jne.'</td>
									<td >'.$biaya_komisi.'</td>
									<td >'.$jumlah_pembelian.'</td>
									<td >'.$harga_total_pembelian.'</td>
									<td>
									</tr>';
								
							}
					if($sum=="barang"){
					echo '</br><p><b>Total Penjualan '.$temp2.' = '.$temp.'</b></p>';
				}
				}
				
				
				
				?>
				<script>
				window.onscroll = function() {myFunction()};

				var navbar = document.getElementById("navbar");
				var content = document.getElementById("content");
				var sticky = content.offsetTop;
				var sticky2 = navbar.offsetTop;

				function myFunction() {
				  if (window.pageYOffset >= sticky2) {
					navbar.classList.add("sticky2")
				  } else {
					navbar.classList.remove("sticky2");
				  }
				}
				</script>
            </table>
		
            </p>
        </div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>