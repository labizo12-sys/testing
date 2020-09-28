<?php 
    session_start();
    date_default_timezone_set('Asia/Jakarta');
	$waktu = date("Y-m-d H:i:s");
	include "koneksi.php";
	$username=$_SESSION['login'];
	$tampilkan="select * from users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);
	if($hasil=mysql_fetch_array($query_tampilkan)){
		$fullname=$hasil['username'];
	}
	else{
		Header("location:index.php?pesan=login");
	}
	
	if (isset($_POST['sign'])) {
	include "koneksi.php";
	$id=$_POST['id'];
	$kode_barang= $_POST['kode_barang'];
	$kuantiti_barang=$_POST['kuantiti_barang'];
	$harga_modal=$_POST['harga_modal'];
	$margin_keuntungan=$_POST['margin_keuntungan'];

			$insert ="update stock set kuantiti_barang='$kuantiti_barang',harga_modal='$harga_modal',margin_keuntungan='$margin_keuntungan', edit_by = '$fullname' where id='$id' AND kode_barang='$kode_barang' ;";
			$insert_query = mysql_query($insert);
					if($insert_query){
					    $insert ="insert into audit_trial (user, waktu, activity) values('$fullname','$waktu','updateStock');";
	                    $insert_query = mysql_query($insert);
						Header("location:listStock.php?pesan=Tambah");
					}
					else{
						//Header("location:index.php?pesan=Tambah user gagal $insert");
					}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sps Food</title>
  <meta charset="utf-8">
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

	  <li  class="active"><a href="inputStock.php">Update Stock</a></li>
	  <li ><a href="listStock.php">List Stock</a></li>	
 
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

<?php
	$id2=$_GET['id'];
	$kode_barang2 = $_GET['kode_barang'];
	
	$tampilkan="select a.id, a.kode_barang, b.jenis_barang, a.gramasi_barang, a.kuantiti_barang, a.harga_modal,a.margin_keuntungan, a.nama_supplier, a.alamat_supplier,a.tanggal_masuk,a.tanggal_exp from stock a inner join barang b on a.kode_barang=b.kode_barang where id='$id2' and a.kode_barang ='$kode_barang2' ORDER BY tanggal_exp ASC;";
	$query_tampilkan=mysql_query($tampilkan);
	
	if($hasil=mysql_fetch_array($query_tampilkan)){
	$id=$hasil['id'];
	$kode_barang=$hasil['kode_barang'];
	$jenis_barang=$hasil['jenis_barang'];
	$gramasi_barang=$hasil['gramasi_barang'];
	$kuantiti_barang=$hasil['kuantiti_barang'];
	$harga_modal=$hasil['harga_modal'];
	$nama_supplier=$hasil['nama_supplier'];
	$alamat_supplier=$hasil['alamat_supplier'];
	$tanggal_exp=$hasil['tanggal_exp'];
	$margin_keuntungan=$hasil['margin_keuntungan'];
	$tanggal_masuk=$hasil['tanggal_masuk'];
	}

?>

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
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
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
				
					$tampilkan="Select * from barang";
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
                <input type="text" id="id" name="id" class="form-control" placeholder="No Surat Jalan" value="<?php echo "$id"?>" required readonly></br>
				<label for="pwd">Jenis Barang:</label>
                <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" placeholder="No Surat Jalan" value="<?php echo "$jenis_barang"?>" required readonly></br>
				<label for="text">Kode Barang:</label>
				<input type="text" id="kode_barang" name="kode_barang" class="form-control" value="<?php echo "$kode_barang"?>" placeceholder="kode_barang"  readonly></br>				
				<label for="pwd">Kuantiti Barang:</label>
                <input type="number" id="kuantiti_barang" name="kuantiti_barang" class="form-control" placeholder="kuantiti barang" value="<?php echo "$kuantiti_barang"?>" required></br>			
				<label for="pwd">Gramasi Barang:</label>
                <input type="text" id="gramasi_barang" name="gramasi_barang" class="form-control" placeholder="Gramasi barang" value="<?php echo "$gramasi_barang"?>" required readonly></br>					
				<label for="pwd">Harga Modal:</label>
                <input type="number" id="harga_modal" name="harga_modal" class="form-control" placeholder="harga modal" value="<?php echo "$harga_modal"?>" required ></br>
				<label for="pwd">Margin Keuntungan:</label>
                <input type="number" id="margin_keuntungan" name="margin_keuntungan" class="form-control" placeholder="margin keuntungan" value="<?php echo "$margin_keuntungan"?>" required></br>					
				<label for="pwd">Nama Supplier:</label>
                <input type="text" id="nama_supplier" name="nama_supplier" class="form-control" placeholder="nama supplier" value="<?php echo "$nama_supplier"?>" required readonly></br>				
				<label for="pwd">Alamat Supplier:</label>
                <input type="text" id="alamat_supplier" name="alamat_supplier" class="form-control" placeholder="alamat supplier" value="<?php echo "$alamat_supplier"?>" required readonly></br>				
				<label for="pwd">Tanggal Masuk:</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" placeholder="tanggal masuk" value="<?php echo "$tanggal_masuk"?>" required readonly></br>				
				<label for="pwd">Tanggal exp:</label>
                <input type="date" id="tanggal_exp" name="tanggal_exp" class="form-control" placeholder="tanggal exp" value="<?php echo "$tanggal_exp"?>" required readonly></br>								
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="sign">Save</button></br>
        </form>
				</div>

		</div>
		</div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>
