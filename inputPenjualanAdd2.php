<?php 
    session_start();
    include "koneksi.php";
	$username=$_SESSION['login'];
	date_default_timezone_set('Asia/Jakarta');
	$waktu = date("Y-m-d H:i:s");
	$waktu2 = date("Y-m-d");
	$sequence = strval($_GET['pesan']);
	$tampilkan="select * from users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);
	if($hasil=mysql_fetch_array($query_tampilkan)){
		$fullname=$hasil['username'];
	}
	else{
		Header("location:http://sps-food.com/?pesan=login");
	}
	$tampilkan="Select * from sequence";
	$query_tampilkan=mysql_query($tampilkan);
	if ($data = mysql_fetch_array($query_tampilkan))
	{
		$id_jual=$data['id_penjualan'];

	}
	if (isset($_POST['sign'])) {
	include "koneksi.php";
	$tampilkan="Select * from sequence";
	$query_tampilkan=mysql_query($tampilkan);
	if ($data = mysql_fetch_array($query_tampilkan))
	{
		$id_jual=$data['id_penjualan'];

	}
	$id_jual1=$id_jual+1;
	$sequence1=$sequence + 1;
	$insert ="update sequence set id_penjualan='$id_jual1';";
	$insert_query = mysql_query($insert);
	if($insert_query){
					
	$id=$_POST['id'];
		$nama_pembeli=$_POST['nama_pembeli'];
		$alamat_pembeli=$_POST['alamat_pembeli'];
		$kode_barang=$_POST['kode_barang'];
		$jenis_barang=$_POST['jenis_barang'];
		$gramasi_barang=$_POST['gramasi_barang'];
		$kuantiti_barang=$_POST['kuantiti_barang'];
		$harga_modal=$_POST['harga_modal'];
		$transport = $_POST['transport'];
		$jne = $_POST['jne'];
		$komisi = $_POST['komisi'];
		$tanggal_exp=$_POST['tanggal_exp'];
		$margin_keuntungan=$_POST['margin_keuntungan'];
		$harga_jual=$_POST['harga_jual'];
		$jumlah_pembelian=$_POST['jumlah_pembelian'];
		$total_harga_pembelian=$harga_jual * $jumlah_pembelian+$transport+$jne+$komisi;
		$jatuh_tempo=$_POST['jatuh_tempo'];
		$update_stok=$kuantiti_barang - $jumlah_pembelian;

		$insert ="insert into penjualan values('$id_jual','$nama_pembeli','$alamat_pembeli','$kode_barang','$gramasi_barang','$kuantiti_barang','$harga_modal','$transport', '$jne', '$komisi' ,'$margin_keuntungan', '$harga_jual', '$jumlah_pembelian', '$total_harga_pembelian', '$jatuh_tempo', '$id', '$fullname','$waktu2');";
		$insert_query = mysql_query($insert);
			if($insert_query){
			    $update = "UPDATE stock SET kuantiti_barang= '$update_stok' WHERE id_stock='$id';";
				$insert_query = mysql_query($update);
			    
				$insert ="insert into audit_trial (user, waktu, activity) values('$fullname','$waktu','inputPenjualan');";
				$insert_query = mysql_query($insert);
				$insert2 ="insert into transaksi values('$sequence','$id_jual');";
				$insert_query2 = mysql_query($insert2);
				if($insert_query2){
				Header("location:savePDF2.php?pesan=$sequence");
				}
				else{
					Header("location:inputPenjualanAdd2.php?pesan=Tambah transaksi gagal $insert_query2");
				}
			}
			else{
				Header("location:inputPenjualanAdd2.php?pesan=Tambah Penjualan gagal $insert");
			}
		}
		else{
				Header("location:listPenjualan2.php?pesan=Gagal sequence");

		}
	}
	if (isset($_POST['add'])) {
	include "koneksi.php";
	$sequence1=$sequence+1;
	$id_jual1=$id_jual+1;
	$insert ="update sequence set id_penjualan='$id_jual1';";
	$insert_query = mysql_query($insert);
	if($insert_query){
					
		$id=$_POST['id'];
		$nama_pembeli=$_POST['nama_pembeli'];
		$alamat_pembeli=$_POST['alamat_pembeli'];
		$kode_barang=$_POST['kode_barang'];
		$jenis_barang=$_POST['jenis_barang'];
		$gramasi_barang=$_POST['gramasi_barang'];
		$kuantiti_barang=$_POST['kuantiti_barang'];
		$harga_modal=$_POST['harga_modal'];
		$transport = $_POST['transport'];
		$jne = $_POST['jne'];
		$komisi = $_POST['komisi'];
		$tanggal_exp=$_POST['tanggal_exp'];
		$margin_keuntungan=$_POST['margin_keuntungan'];
		$harga_jual=$_POST['harga_jual'];
		$jumlah_pembelian=$_POST['jumlah_pembelian'];
		$total_harga_pembelian=$harga_jual * $jumlah_pembelian+$transport+$jne+$komisi;
		$jatuh_tempo=$_POST['jatuh_tempo'];
        $update_stok=$kuantiti_barang - $jumlah_pembelian;
        
		$insert ="insert into penjualan values('$id_jual','$nama_pembeli','$alamat_pembeli','$kode_barang','$gramasi_barang','$kuantiti_barang','$harga_modal','$transport', '$jne', '$komisi' ,'$margin_keuntungan', '$harga_jual', '$jumlah_pembelian', '$total_harga_pembelian', '$jatuh_tempo', '$id', '$fullname','$waktu2');";
		$insert_query = mysql_query($insert);
			if($insert_query){
			    $update = "UPDATE stock SET kuantiti_barang= '$update_stok' WHERE id_stock='$id';";
				$insert_query = mysql_query($update);
			    
				$insert ="insert into audit_trial (user, waktu, activity) values('$fullname','$waktu','inputPenjualan');";
	            $insert_query = mysql_query($insert);
				
				$insert2 ="insert into transaksi values('$sequence','$id_jual');";
				$insert_query2 = mysql_query($insert2);
				if($insert_query2){
				Header("location:inputPenjualanAdd2.php?pesan=$sequence");
				}
				else{
					Header("location:inputPenjualan2.php?pesan=Tambah transaksi gagal $insert_query2");
				}
			}
			else{
				Header("location:inputPenjualan2.php?pesan=Tambah Penjualan gagal $insert");
			}
		}
		else{
				Header("location:listPenjualan2.php?pesan=Gagal sequence");

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
        <li class="active"><a href="inputPenjualan2.php">Input Penjualan</a></li>
        <li ><a href="listPenjualan2.php">List Penjualan</a></li>
	    <li ><a href="summary2.php">Summary</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><?php echo ' '.$fullname;?>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="editprofil2.php" <span class="glyphicon glyphicon-edit"></span> ManageAccount</a></li>
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
		return;
	} else { 
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			var obj = JSON.parse(this.responseText.substr(1, this.responseText.length - 2));
			if (this.readyState == 4 && this.status == 200) {
				var x=obj.harga_modal;
				var y=obj.kuantiti_barang;
				var z=obj.margin_keuntungan;
				if(obj.harga_satuan != null){
					var w=obj.harga_satuan;
				}
				else{
					var w = 0;
				}
				document.getElementById("kode_barang").value = obj.kode_barang;
				document.getElementById("jenis_barang").value = obj.jenis_barang;
				document.getElementById("gramasi_barang").value = obj.gramasi_barang;
				document.getElementById("kuantiti_barang").value = obj.kuantiti_barang;
				document.getElementById("tanggal_exp").value = obj.tanggal_exp;
				document.getElementById("harga_modal").value = obj.harga_modal;
				document.getElementById("harga_satuan").value = obj.harga_satuan;
			}
		};
		xmlhttp.open("GET","detailStock.php?q="+str,true);
		xmlhttp.send();
	}
}

function showUser2(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
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
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getPenjualan.php?q="+str,true);
        xmlhttp.send();
    }
}

function fetch_select(str)
{
	 if (str == "") {
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
                document.getElementById("id").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","barangPilih.php?q="+str,true);
        xmlhttp.send();
    }
}

function myFunction(val) {
		var x=document.getElementById("harga_jual").value;
	var y=document.getElementById("kuantiti_barang").value;
	var z=document.getElementById("margin_keuntungan").value;
	var w=document.getElementById("harga_modal").value;
	var a=document.getElementById("komisi").value;
	var b=document.getElementById("jne").value;
	var c=document.getElementById("transport").value;
	
	document.getElementById("total_harga_pembelian").value = val*x+(1*a)+(1*b)+(1*c);
    
    document.getElementById("jumlah_pembelian").max = y;
};

function hargajual(val){
    var x=document.getElementById("harga_modal").value;
	document.getElementById("harga_jual").value = (x*1)+(val*1);
	
};


function check(input) {
    const maxValue = parseInt(input.getAttribute('max'), 10);
    const currentValue = parseInt(input.value, 10);
    if (currentValue > maxValue) {
        input.setCustomValidity(`Input melebihi batas stok ! Stok =  ${maxValue}`);
        document.getElementById("jumlah_pembelian").value = "";
    }
};
 </script>
<div id="content">
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<?php 
			        $id = '';
					$jenis_barang= '';
					$gramasi_barang= 0;
					
					$kuantiti_barang= 0;
					$max= 0;
					$margin_keuntungan= 0;
					$tanggal_exp= '';
					$harga_modal= 0;
					
					$harga_satuan=0;
					
					
					$harga_jual= $harga_modal + $margin_keuntungan;
						
			?>
			<div class="row " >
				<div class="col-md-4" ></div>
				<div class="col-md-4" style="background-color:AliceBlue;">
				<h2 align="center">Input Penjualan</h1>
            <p id="profile-name" class="profile-name-card"></p>
            <form method="POST" >
				
				<label for="pwd">Barang : </label>: <Select Name="new_select" id="new_select" onchange=" showUser2(this.value);fetch_select(this.value);">
				<?php
					$tampilkan="Select * from barang";
					$query_tampilkan=mysql_query($tampilkan);
					echo "<option selected=".selected.">Pilih Barang</option>";
					while ($data = mysql_fetch_array($query_tampilkan))
					{

						echo "<option >".$data['jenis_barang']."</option>";
					}
				
				?>
                </Select><br>
				 <div id="txtHint"><b>Person info will be listed here...</b></div>
				<label for="pwd">No. Surat Jalan:</label>: <Select Name="id" id="id" onchange="showUser(this.value)">
				 </Select><br>
				<label for="pwd">Nama Pembeli:</label>
                <input type="text" id="nama_pembeli" name="nama_pembeli" class="form-control" placeholder="nama_pembeli" required></br>
				<label for="pwd">Alamat Pembeli:</label>
                <input type="text" id="alamat_pembeli" name="alamat_pembeli" class="form-control" placeholder="alamat_pembeli" required></br>
				<label for="pwd">Kode Barang:</label>
                <input type="text" id="kode_barang" name="kode_barang" class="form-control" value="<?php echo "$id"?>" placeholder="kode_barang" readonly></br>
				<label for="pwd">Jenis Barang:</label>
                <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" value="<?php echo "$jenis_barang"?>" placeholder="jenis_barang" readonly></br>
				<label for="pwd">Gramasi Barang:</label>
                <input type="text" id="gramasi_barang" name="gramasi_barang" class="form-control" value="<?php echo "$gramasi_barang"?>" placeholder="gramasi_barang" readonly></br>				
				<label for="pwd">Stock Barang:</label>
                <input type="number" id="kuantiti_barang" name="kuantiti_barang" class="form-control" value="<?php echo "$kuantiti_barang"?>" placeholder="kuantiti_barang" readonly></br>				
				<label for="pwd">Tanggal exp:</label>
                <input type="date" id="tanggal_exp" name="tanggal_exp" class="form-control" value="<?php echo "$tanggal_exp"?>" placeholder="tanggal_exp" readonly></br>					
				<input type="hidden" id="harga_satuan" name="harga_satuan" class="form-control" value="<?php echo "$harga_satuan"?>" placeholder="harga_modal" readonly required>
				<label for="pwd">Margin Keuntungan:</label>
				<input type="number" id="margin_keuntungan" name="margin_keuntungan" class="form-control" step=".01" onchange="hargajual(this.value)" placeholder="margin_keuntungan"></br>
				<input type="hidden" id="harga_modal" name="harga_modal" class="form-control" value="<?php echo "$harga_modal"?>" placeholder="harga_modal" readonly required>
				<label for="pwd">Harga Jual:</label>
                <input type="text" id="harga_jual" name="harga_jual" class="form-control" value="<?php echo "$harga_jual"?>" placeholder="harga_jual" readonly required></br>
				<label for="pwd">Biaya transport :</label>
                <input type="number" id="transport" name="transport" class="form-control" placeholder="Biata_Transport"></br>
				<label for="pwd">Biaya JNE:</label>
                <input type="number" id="jne" name="jne" class="form-control" placeholder="Biaya_JNE"></br>
				<label for="pwd">Biaya komisi :</label>
                <input type="number" id="komisi" name="komisi" class="form-control" placeholder="Biaya_Komisi"></br>
                <label for="pwd">Jumlah Pembelian:</label>
                <input  type="number" id="jumlah_pembelian" name="jumlah_pembelian" class="form-control" step=".01" placeholder="jumlah_pembelian" onchange="max();" onkeyup="myFunction(this.value)" oninvalid="check(this)" oninput="setCustomValidity('')"></br>
				<label for="pwd">Total Harga Pembelian:</label>
                <input type="number" id="total_harga_pembelian" name="total_harga_pembelian" class="form-control" placeholder="total_harga_pembelian" readonly></br>
				<label for="pwd">Jatuh Tempo:</label>
                <input type="date" id="jatuh_tempo" name="jatuh_tempo" class="form-control" placeholder="jatuh_tempo" required></br>
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="add">Add</button></br>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="sign">Save</button></br>
        </form>
				</div>

		</div>
		</div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>