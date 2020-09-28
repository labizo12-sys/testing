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
		$tampilkan="select * from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock where d.id_transaksi='$id2';";
		$query_tampilkan=mysql_query($tampilkan);
        $this->Cell(270,10,'INVOICE',0,0,'C');
		$this->Ln(10);
		if($hasil=mysql_fetch_array($query_tampilkan)){
			$this->Cell(270, 10,'No : SJP-'.$id2,0,0,'C');

        }
		$this->Ln(10);
		$this->Cell(50,10,'',0,0,'C');
		$this->Cell(63,10,'Kepada : ',0,0,'L');
        $this->Ln();
		
		$this->Cell(50,10,'',0,0,'C');
		$this->Cell(63,10,'Yth. '.$hasil['nama_pembeli'],0,0,'L');
		$this->Ln(10);
		$this->Cell(50,10,'',0,0,'C');
		$this->Cell(63,10,$hasil['alamat_pembeli'],0,0,'L');
		$this->Cell(50,10,'',0,0,'C');
		$this->Cell(63,10,'',0,0,'L');

        $this->Ln(10);
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
        $this->SetFont('Times','B',10);
		$this->Cell(20,10,'',0,0,'C');
        $this->Cell(50,10,'DESCRIPTION',1,0,'C',1);
        $this->Cell(30,10,'WEIGHT',1,0,'C',1);
		$this->Cell(50,10,'JATUH TEMPO',1,0,'C',1);
        $this->Cell(50,10,'UNIT PRICE',1,0,'C',1);
		$this->Cell(50,10,'AMOUNT',1,0,'C',1);
        $this->Ln();
    }
    function viewTable($id2){
		$total=0;
        $this->SetFont('Times','',10);
		$tampilkan="select * from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock where d.id_transaksi = '$id2';";
		$query_tampilkan=mysql_query($tampilkan);
        while($hasil=mysql_fetch_array($query_tampilkan)){
			$this->Cell(20,10,'',0,0,'C');
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
			$this->Cell(50,10,$hasil['jatuh_tempo'],1,0,'C');
			$this->Cell(50,10,number_format($hasil['harga_jual']*1, 2, ',', '.'),1,0,'C');
			$this->Cell(50,10,number_format($hasil['harga_jual']*$hasil['jumlah_pembelian']*1, 2, ',', '.'),1,0,'C');
			$total=$total + 1 * $hasil['harga_jual']*$hasil['jumlah_pembelian'];
            $this->Ln(10);
        }
		$this->Cell(20,10,'',0,0,'C');
		$this->setFillColor(230,230,230);
		$this->Cell(180,10,'Total',1,0,'R',1);
		$this->Cell(50,10,number_format($total*1, 2, ',', '.'),1,0,'C',1);
		$this->Ln(10);
    }
	function footerTable($waktu){
		
        $this->SetFont('Times','B',12);
		$this->Cell(63,10,'',0,0,'C');
        $this->Cell(100,10,'',0,0,'C');
        $this->Cell(70,10,'Jakarta, ' .$waktu,0,0,'C');
        $this->Ln(10);
		$this->SetFont('Times','B',12);
		$this->Cell(30,10,'',0,0,'C');
        $this->Cell(50,10,'REMARKS',0,0,'C');
        $this->Cell(100,10,'',0,0,'C');
        $this->Cell(70,10,'Pembeli', 0,0,'C');
		$this->Ln(10);
		$this->Cell(30,10,'',0,0,'C');
        $this->Cell(50,10,'Metode Pembayaran',0,0,'C');
        $this->Ln(20);
		$this->SetFont('Times','B',12);
		$this->Cell(30,10,'',0,0,'C');
        $this->Cell(153,10,'',0,0,'C');
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