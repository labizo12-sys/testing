<?php 
    session_start();
    include "koneksi.php";
	$username=$_SESSION['login'];
	$tampilkan="select * from users where username='$username'";
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
	$penjualan="";
	$pembelian="";
	$bersih="";
	$kotor="";
	$tanggal_awal="";
	$tanggal_akhir="";
	$gaji="";
	$media="";
	$atk="";
	$lain="";
	$sewa="";
	if (isset($_POST['count'])) {
		include "koneksi.php";
		$penjualan="0";
		$pembelian="0";
		$tanggal_awal=$_POST['tanggal_awal'];
		$tanggal_akhir=$_POST['tanggal_akhir'];
		$gaji=$_POST['gaji'];
		$media=$_POST['media'];
		$atk=$_POST['atk'];
		$lain=$_POST['lain'];
		$sewa=$_POST['sewa'];
		
		$tampilkan="select * from penjualan where tanggal_jual between '$tanggal_awal' AND '$tanggal_akhir';";
		$query_tampilkan=mysql_query($tampilkan);
		while($hasil=mysql_fetch_array($query_tampilkan)){
			$penjualan=$penjualan + 1 * $hasil['harga_total_pembelian'];
		}
		$tampilkan2="select * from stock where tanggal_masuk between '$tanggal_awal' AND '$tanggal_akhir';";
		$query_tampilkan2=mysql_query($tampilkan2);
		while($hasil2=mysql_fetch_array($query_tampilkan2)){
			$pembelian=$pembelian + $hasil2['modal_total'];
		}
		$kotor= $penjualan - $pembelian;
		$bersih = $kotor - $gaji - $sewa - $media - $atk - $lain;
		$penjualan=number_format($penjualan, 2, ',', '.');
		$pembelian=number_format($pembelian, 2, ',', '.');
		$kotor=number_format($kotor, 2, ',', '.');
		$bersih=number_format($bersih, 2, ',', '.');
		}
	if (isset($_POST['print'])) {
		$penjualan=$_POST['penjualan'];;
		$pembelian=$_POST['pembelian'];
		$bersih=$_POST['bersih'];
		$kotor=$_POST['kotor'];
		$tanggal_awal=$_POST['tanggal_awal'];
		$tanggal_akhir=$_POST['tanggal_akhir'];
		$gaji=$_POST['gaji'];
		$media=$_POST['media'];
		$atk=$_POST['atk'];
		$lain=$_POST['lain'];
		$sewa=$_POST['sewa'];
		$sewa=number_format($sewa, 2, ',', '.');
		$lain=number_format($lain, 2, ',', '.');
		$atk=number_format($atk, 2, ',', '.');
		$media=number_format($media, 2, ',', '.');
		$gaji=number_format($gaji, 2, ',', '.');
		require "fpdf.php";
		include "koneksi.php";

		class myPDF extends FPDF{
			
			function header(){
				$this->image('kepalaSurat.png',3,6);
				$this->Ln(40);
			}
			function header2($tanggal_awal,$tanggal_akhir){
				$this->SetFont('Arial','B',15);
				$this->Cell(270,10,'Laporan Laba Rugi '.$tanggal_awal.' sampai '.$tanggal_akhir,0,0,'C');
				$this->Ln(20);
			}
			function footer(){
				$this->SetY(-15);
				$this->SetFont('Arial','',8);
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
				$this->Ln();
				$this->image('footer.png',3,205);
			}
			function headerTable($penjualan, $pembelian, $kotor, $bersih, $gaji, $sewa, $media, $atk, $lain){
				
				$this->SetFont('Times','',12);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Total Penjualan : ',1,0,'C');
				$this->Cell(50,10,$penjualan,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Total Pembelian : ',1,0,'C');
				$this->Cell(50,10,$pembelian,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->setFillColor(230,230,230);
				$this->SetFont('Times','B',12);
				$this->Cell(45,10,'',0,0,'C');
				if($kotor>=0){
				$this->SetTextColor(8,194,8);
				$this->Cell(50,10,'Laba Kotor : ',1,0,'C',1);
				}
				else{
				$this->SetTextColor(194,8,8);
				$this->Cell(50,10,'Rugi Kotor : ',1,0,'C',1);
				}		
				$this->Cell(50,10,$kotor,1,0,'R',1);
				$this->SetTextColor(0,0,0);				
				$this->Ln(10);
				$this->SetFont('Times','',12);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Biaya Gaji : ',1,0,'C');
				$this->Cell(50,10,$gaji,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Biaya Sewa : ',1,0,'C');
				$this->Cell(50,10,$sewa,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Biaya Media : ',1,0,'C');
				$this->Cell(50,10,$media,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Biaya ATK : ',1,0,'C');
				$this->Cell(50,10,$atk,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->Cell(45,10,'',0,0,'C');
				$this->Cell(50,10,'Biaya Lain - lain : ',1,0,'C');
				$this->Cell(50,10,$lain,1,0,'R');
				$this->Ln(10);
				$this->Cell(40,10,'',0,0,'C');
				$this->setFillColor(230,230,230);
				$this->SetFont('Times','B',12);
				$this->Cell(45,10,'',0,0,'R');
				if($bersih>=0){
				$this->SetTextColor(8,194,8);
				$this->Cell(50,10,'Laba Besih : ',1,0,'C',1);
				}
				else{
				$this->SetTextColor(194,8,8);
				$this->Cell(50,10,'Rugi Besih : ',1,0,'C',1);
				}
				$this->Cell(50,10,$bersih,1,0,'R',1);
				$this->SetTextColor(0,0,0);	
				$this->Ln();
			}
			function viewTable(){
				$this->Ln(10);
			}
			
		}

		$pdf = new myPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage('L','A4',0);
		$pdf->header2($tanggal_awal,$tanggal_akhir);

		$pdf->headerTable($penjualan, $pembelian, $kotor, $bersih, $gaji, $sewa, $media, $atk, $lain);
		$pdf->viewTable();

		$pdf->Output();
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
  <script>
				window.onscroll = function() {myFunction()};

				var navbar = document.getElementById("navbar");
				var sticky = navbar.offsetTop;

				function myFunction() {
				  if (window.pageYOffset >= sticky) {
					navbar.classList.add("sticky")
				  } else {
					navbar.classList.remove("sticky");
				  }
				}
</script>
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
	    <li class="active"><a href="laporan.php">Laporan Laba Rugi</a></li>	
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
				<h2 align="center">Laporan Laba Rugi</h1>
            <p id="profile-name" class="profile-name-card"></p>
            <form method="POST" >
			
								
								
				</Select><br>
				<label for="pwd">Periode:</label>
                <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="<?php echo $tanggal_awal; ?>" placeholder="tanggal masuk" required>			
				<label for="pwd"> Sampai </label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="<?php echo $tanggal_akhir; ?>" placeholder="tanggal exp" required></br>	
                <label for="name1">Total Penjualan:</label>
                <input type="text" id="penjualan" name="penjualan" class="form-control" value="<?php echo $penjualan; ?>" readonly></br>
				<label for="text">Total Pembelian:</label>
				<input type="text" id="pembelian" name="pembelian" class="form-control" value="<?php echo $pembelian; ?>" readonly></br>	
				<label for="pwd">Laba Kotor:</label>
                <input type="text" id="kotor" name="kotor" class="form-control" value="<?php echo $kotor; ?>" readonly></br>
				<label for="pwd">Biaya Gaji:</label>
                <input type="number" id="gaji" name="gaji" class="form-control" value="<?php echo $gaji; ?>" placeholder="Biaya Gaji" required></br>			
				<label for="pwd">Biaya Sewa:</label>
                <input type="number" id="sewa" name="sewa" class="form-control" value="<?php echo $sewa; ?>" placeholder="Biaya Sewa" required></br>					
				<label for="pwd">Biaya Media:</label>
                <input type="number" id="media" name="media" class="form-control" value="<?php echo $media; ?>" placeholder="Biaya Media" required></br>
				<label for="pwd">Biaya ATK:</label>
                <input type="number" id="atk" name="atk" class="form-control" value="<?php echo $atk; ?>" placeholder="Biaya ATK" required></br>
				<label for="pwd">Biaya Lain-lain:</label>
                <input type="number" id="lain" name="lain" class="form-control" value="<?php echo $lain; ?>" placeholder="Biaya Lain-lain" required></br>					
				<label for="pwd">Laba Bersih:</label>
                <input type="text" id="bersih" name="bersih" class="form-control" value="<?php echo $bersih; ?>" readonly></br>						
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="count">Hitung</button></br>				
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" formtarget="_blank" name="print">Print</button></br>
        </form>
				</div>

		</div>
		</div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>
