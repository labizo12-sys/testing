<?php 
require "fpdf.php";
include "koneksi.php";
$id2=$_GET['id'];
$waktu2 = $_GET['tgl'];
$waktu = str_replace("-"," ",$waktu2);

class myPDF extends FPDF{
    function header(){
        
    }
	function header2($id2){
		$this->image('kepalaSurat.png',3,6);
		$this->Ln(25);
        $this->SetFont('Arial','B',15);
        $this->Cell(111,10,'SURAT JALAN',0,0,'C');
		$this->Cell(70,10,'',0,0,'C');
		$this->Cell(63,10,'Kepada : ',0,0,'L');
        $this->Ln();
		$tampilkan="select * from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock where d.id_transaksi='$id2';";
		$query_tampilkan=mysql_query($tampilkan);
        if($hasil=mysql_fetch_array($query_tampilkan)){
        $this->Cell(36,10,'',0,0,'C');
        $this->Cell(53, 10,'No : SJP-'.$id2,0,0,'L');

        }
		$this->Cell(92,10,'',0,0,'C');
		$this->Cell(58,10,'Yth. '.$hasil['nama_pembeli'],0,0,'L');
		$this->Ln(10);
		$this->Cell(181,10,'',0,0,'C');
		$this->Cell(63,10,$hasil['alamat_pembeli'],0,0,'L');
		$this->Cell(181,10,'',0,0,'C');
		$this->Cell(63,10,'',0,0,'C');
		$this->Ln();
		$this->SetFont('Times','',12);
		$this->Cell(111,19,'Dengan hormat,',0,0,'C');
		$this->Ln(10);
		$this->Cell(233,19,'Bersama ini kami kirimkan barang - barang tersebut di bawah ini dengan kendaraan ......',0,0,'C');

        $this->Ln(20);
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		$this->Ln();
		$this->image('footer.png',3,205);
    }
    function headerTable(){
		$this->setFillColor(230,230,230);
        $this->SetFont('Times','B',12);
		$this->Cell(63,10,'',0,0,'C');
		
        $this->Cell(50,10,'Nama Barang',1,0,'C',1);
        $this->Cell(30,10,'Jumlah',1,0,'C',1);
        $this->Cell(70,10,'Keterangan',1,0,'C',1);
        $this->Ln();
    }
    function viewTable($id2){
        $this->SetFont('Times','',12);
		$tampilkan="select * from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock where d.id_transaksi='$id2';";
		$query_tampilkan=mysql_query($tampilkan);
        while($hasil=mysql_fetch_array($query_tampilkan)){
			$this->Cell(63,10,'',0,0,'C');
			if($this->GetStringWidth($hasil['jenis_barang']) > 50 && $this->GetStringWidth($hasil['jenis_barang']) < 100){
				$x = $this->GetX();
				$y = $this->GetY();
				$this->MultiCell(50,5,$hasil['jenis_barang'],1,'C',false);
				$this->SetXY($x + 50, $y);
			}
			else if($this->GetStringWidth($hasil['jenis_barang']) > 100){
				$x = $this->GetX();
				$y = $this->GetY();
				$this->MultiCell(50,3,$hasil['jenis_barang'],1,'C',false);
				$this->SetXY($x + 50, $y);
			}
			else{
				$this->Cell(50,10,$hasil['jenis_barang'],1,0,'C');
			}
            $this->Cell(30,10,$hasil['jumlah_pembelian'],1,0,'C');
            $this->Cell(70,10,"",1,0,'L');

            $this->Ln(10);
        }
    }
	function footerTable($waktu){
		
        $this->SetFont('Times','B',12);
		$this->Cell(63,10,'',0,0,'C');
        $this->Cell(50,10,'Mohon bisa diterima dengan baik, Terima kasih.',0,0,'C');
        $this->Cell(70,10,'',0,0,'C');
        $this->Cell(70,10,'Jakarta, ' .$waktu,0,0,'C');
        $this->Ln(10);
		$this->SetFont('Times','B',12);
		$this->Cell(30,10,'',0,0,'C');
        $this->Cell(50,10,'Penerima',0,0,'C');
        $this->Cell(103,10,'',0,0,'C');
        $this->Cell(70,10,'Pengirim', 0,0,'C');
        $this->Ln(20);
		$this->SetFont('Times','B',12);
		$this->Cell(30,10,'',0,0,'C');
        $this->Cell(50,10,'(..............................)',0,0,'C');
        $this->Cell(103,10,'',0,0,'C');
        $this->Cell(70,10,'(..............................)', 0,0,'C');
    }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->header2($id2);

$pdf->headerTable();
$pdf->viewTable($id2);
$pdf->footerTable($waktu);

$pdf->Output();