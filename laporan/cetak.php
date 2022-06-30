<?php
include "fpdf.php";
include "../function.php";

$pdf = new FPDF();
$pdf -> AddPage();

$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(0,5,'PT . SALAHUDDIN ABADI','0','1','C', false);
$pdf -> SetFont('Arial', 'i', 8);
$pdf -> Cell(0,5,'Alamat : Jl . Tanjakan No.18B Cirebon Jawa Barat', '0','1', 'C', false);
$pdf -> Ln(3);
$pdf -> Cell(190, 0.6, '', '0', '1', 'C',true);
$pdf -> Ln(5);

$pdf -> SetFont('Arial', 'B', 9);
$pdf -> Cell(45,5,'Laporan Data Stock Barang', '0', '1', 'C', false);
$pdf -> Ln(3);

$pdf -> SetFont('Arial', 'B', 7);
$pdf -> Cell(8,6,'No.', 1,0,'C');
$pdf -> Cell(35,6,'Nama Barang',1,0,'C');
$pdf -> Cell(50,6,'Deskripsi',1,0,'C');
$pdf -> Cell(35,6,'Stock', 1,0,'C');
$pdf -> Ln(2);
$no = 0;
$sql = mysqli_query($conn,"select * from  stock order by idbarang");
while($data = mysqli_fetch_array($sql)){
    $no++;
    $pdf -> Ln(4);
    $pdf -> SetFont('Arial','',7);
    $pdf -> Cell(8,4,$no.".",1,0,'C');
    $pdf -> Cell(35,4,$data['namabarang'],1,0,'L');
    $pdf -> Cell(50,4,$data['deskripsi'],1,0,'L');
    $pdf -> Cell(35,4,$data['stock'],1,0,'C');
}
$pdf -> Output();
?>