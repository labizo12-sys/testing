<?php 
    session_start();
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
        <li ><a href="inputStock.php">Input Stock</a></li>    
	    <li class="active" ><a href="listStock.php">List Stock</a></li>
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
        	<h2 align="center">List Stock</h2>
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<br>
			<form method="POST"  >
			<label for="pwd">Filter By :</label>
			<Select Name="id" id="id" onchange="showUser(this.value)">
				<option selected="selected">Pilih Filter</option>
				<option value="barang">Nama Barang</option>
				<option value="supplier">Nama Supplier</option>
				<option value="jumlah">Jumlah Stock</option>
				<option value="tanggal">Expired Date</option>
			</Select>
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
            <p>
			
            <table  class="table table-hover">
			
            	<tr bgcolor="#ccffff">
                	<th width="70">No. Surat Jalan</th>
                    <th width="70">Kode Barang</th>
					<th width="70">Jenis Barang</th>
                    <th width="70">Gramasi</th>
                    <th width="70">Stock</th>
					<th width="100">Harga Modal</th>
					<th width="100">Summary Harga Modal</th>
					<th width="70">Margin Keuntungan</th>
					<th width="70">Nama Supplier</th>
					<th width="70">Alamat Supplier</th>
					<th width="100">TGL Masuk</th>
					<th width="100">TGL EXP</th>
					<th width="70">Last Edit By</th>
					<th width="70">Aksi</th>

                </tr>
                <?php
				$tampilkan="select a.id, a.kode_barang, b.jenis_barang, a.gramasi_barang, a.kuantiti_barang, a.harga_modal, a.biaya_operasional ,a.margin_keuntungan, a.nama_supplier, a.alamat_supplier,DATE_FORMAT(a.tanggal_masuk,'%d-%b-%Y') as tanggal_masuk,DATE_FORMAT(a.tanggal_exp,'%d-%b-%Y') as tanggal_exp, a.edit_by ,b.satuan from stock a inner join barang b on a.kode_barang=b.kode_barang  ORDER BY a.tanggal_masuk DESC;";
				if (isset($_POST['sign'])) {
					if($_POST['id']=="barang"){
						$tampilkan="select a.id, a.kode_barang, b.jenis_barang, a.gramasi_barang, a.kuantiti_barang, a.harga_modal, a.biaya_operasional ,a.margin_keuntungan, a.nama_supplier, a.alamat_supplier,DATE_FORMAT(a.tanggal_masuk,'%d-%b-%Y') as tanggal_masuk,DATE_FORMAT(a.tanggal_exp,'%d-%b-%Y') as tanggal_exp, a.edit_by ,b.satuan from stock a inner join barang b on a.kode_barang=b.kode_barang  ORDER BY b.jenis_barang ASC;";
					}
					else if($_POST['id']=="supplier"){
						$tampilkan="select a.id, a.kode_barang, b.jenis_barang, a.gramasi_barang, a.kuantiti_barang, a.harga_modal, a.biaya_operasional ,a.margin_keuntungan, a.nama_supplier, a.alamat_supplier,DATE_FORMAT(a.tanggal_masuk,'%d-%b-%Y') as tanggal_masuk,DATE_FORMAT(a.tanggal_exp,'%d-%b-%Y') as tanggal_exp, a.edit_by  ,b.satuan from stock a inner join barang b on a.kode_barang=b.kode_barang  ORDER BY a.nama_supplier ASC;";
					}
					else if($_POST['id']=="jumlah"){
						$tampilkan="select a.id, a.kode_barang, b.jenis_barang, a.gramasi_barang, a.kuantiti_barang, a.harga_modal, a.biaya_operasional ,a.margin_keuntungan, a.nama_supplier, a.alamat_supplier,DATE_FORMAT(a.tanggal_masuk,'%d-%b-%Y') as tanggal_masuk,DATE_FORMAT(a.tanggal_exp,'%d-%b-%Y') as tanggal_exp, a.edit_by  ,b.satuan from stock a inner join barang b on a.kode_barang=b.kode_barang  ORDER BY a.kuantiti_barang ASC;";
					}
					else{
						$tampilkan="select a.id, a.kode_barang, b.jenis_barang, a.gramasi_barang, a.kuantiti_barang, a.harga_modal, a.biaya_operasional ,a.margin_keuntungan, a.nama_supplier, a.alamat_supplier,DATE_FORMAT(a.tanggal_masuk,'%d-%b-%Y') as tanggal_masuk,DATE_FORMAT(a.tanggal_exp,'%d-%b-%Y') as tanggal_exp, a.edit_by ,b.satuan from stock a inner join barang b on a.kode_barang=b.kode_barang  ORDER BY a.tanggal_exp ASC;";
					}
				}
				
						$query_tampilkan=mysql_query($tampilkan);

						while($hasil=mysql_fetch_array($query_tampilkan))
							{
								$id=$hasil['id'];
								$kode_barang=$hasil['kode_barang'];
								$jenis_barang=$hasil['jenis_barang'];
								$gramasi_barang=$hasil['gramasi_barang'];
								$kuantiti_barang=$hasil['kuantiti_barang'];
								$harga_modal=$hasil['harga_modal'];
								
								$biaya_opr=$hasil['biaya_operasional'];
								$nama_supplier=$hasil['nama_supplier'];
								$alamat_supplier=$hasil['alamat_supplier'];
								$tanggal_exp=$hasil['tanggal_exp'];
								$margin_keuntungan=$hasil['margin_keuntungan'];
								$edit_by=$hasil['edit_by'];
								$satuan = $hasil['satuan'];
								$tanggal_masuk=$hasil['tanggal_masuk'];
								$hpp=$harga_modal*$kuantiti_barang;
								$hpp=number_format($hpp, 2, ',', '.');
								$biaya_opr=number_format($biaya_opr*1, 2, ',', '.');
								$margin_keuntungan=number_format($margin_keuntungan*1, 2, ',', '.');
								$harga_modal=number_format($harga_modal*1, 2, ',', '.');

								
								
								date_default_timezone_set('Asia/Jakarta');
            						$current = strtotime(date("d-M-y"));
                                    $date    = strtotime($tanggal_exp);
                                
                                    $datediff = $date - $current;
                                    $difference = floor($datediff/(60*60*24));
                                    if($difference==0)
                                    {
                                        //hari ini
                                        //merah
                                        echo '
                                        <tr style="color: #ff0000">';
                                    }
                                    else if($difference >= 1 && $difference <= 7)
                                    {
                                        //7 hari sebelum
                                        //kuning
                                        echo '
            					    	<tr style="color: #ff9900">';
                                    }
                                    else
                                    {
                                        //kemarin
                                        //merah
                                        echo '
                                        <tr style="color: #000000">';
                                    }    
                					echo '
						<td align="center">'.$id.'</td>
						<td >'.$kode_barang.'</td>
						<td >'.$jenis_barang.'</td>
						<td >'.$satuan.'</td>
						<td >'.$kuantiti_barang.'</td>
						<td >'.$harga_modal.'</td>
						<td >'.$hpp.'</td>
						<td >'.$margin_keuntungan.'</td>
						<td >'.$nama_supplier.'</td>
						<td >'.$alamat_supplier.'</td>
						<td >'.$tanggal_masuk.'</td>
						<td >'.$tanggal_exp.'</td>
						<td >'.$edit_by.'</td>
						<td><button><a href= updateStock.php?id=', $hasil['id'] ,'&kode_barang=', $kode_barang ,'>Update</a>
						
					</tr>';
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
