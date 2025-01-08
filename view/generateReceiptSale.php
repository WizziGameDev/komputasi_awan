<?php
session_start();
require_once './fpdf/fpdf.php';
require_once "../repository/connection.php";

$connection = getConnection();

// Ambil sale_id dari URL
$sale_id = $_GET['sale_id'] ?? null;

if (!$sale_id) {
    echo("Sale ID is required.");
    exit();
}

// Query untuk mengambil data sale, termasuk customer_name dan tgl_sale
$query_sale = "SELECT * FROM sale WHERE id = ?";
$statement_sale = $connection->prepare($query_sale);
$statement_sale->execute([$sale_id]);
$sale = $statement_sale->fetch();

// Jika data sale tidak ditemukan
if (!$sale) {
    echo('Sale not found.');
    exit();
}

// Query untuk mengambil detail barang dari sale_id, termasuk nama item menggunakan JOIN
$query_details = "
    SELECT ds.id, ds.sale_id, ds.item_id, ds.quantity, ds.price, ds.total_price, i.name AS item_name, i.size AS item_size
    FROM detail_sale ds
    JOIN item i ON ds.item_id = i.id
    WHERE ds.sale_id = ?";

$statement_details = $connection->prepare($query_details);
$statement_details->execute([$sale_id]);
$details = $statement_details->fetchAll();

// Jika data detail barang tidak ditemukan
if (!$details) {
    echo('Sale details not found.');
    exit();
}

// Generate PDF
$pdf = new FPDF('P', 'mm', array(80, 120)); // Mengatur ukuran kertas untuk struk
$pdf->AddPage();
$pdf->SetFont('Arial', '', 7);

// Header toko
$pdf->Cell(0, 4, 'TOP SHOES', 0, 1, 'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Ln(1);

// Informasi toko
$pdf->Cell(0, 0, 'Jl. Demuk, Kalangan, Kec. Ngunut, Kabupaten Tulungagung,', 0, 1, 'C');
$pdf->Cell(0, 4, 'Jawa Timur 66292', 0, 1, 'C');

// Nama customer
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(0, 2, $sale['customer_name'], 0, 1, 'C');

// Tanggal Transaksi
$pdf->Cell(0, 3, '===============================================', 0, 1, 'C');
$pdf->Cell(0, 3, 'RECEIPT', 0, 1, 'C');
$pdf->Cell(0, 3, '===============================================', 0, 1, 'C');
$pdf->Ln(1);

// Header kolom: Nama, Jumlah, Harga, Total
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(20, 4, 'Nama', 0, 0, 'L');
$pdf->Cell(5, 4, 'Jumlah', 0, 0, 'C');
$pdf->Cell(18, 4, 'Harga/S', 0, 0, 'R');
$pdf->Cell(17, 4, 'Sub Total', 0, 1, 'R');
$pdf->Ln(1);

// Daftar barang
$total_price = 0;
foreach ($details as $detail) {
    $pdf->SetFont('Arial', '', 6);
    // Menampilkan Nama, Jumlah, Harga, dan Total
    $pdf->Cell(20, 4, $detail['item_name'] . ' / ' . $detail['item_size'], 0, 0, 'L'); // Nama Item
    $pdf->Cell(5, 4, $detail['quantity'], 0, 0, 'C'); // Jumlah
    $pdf->Cell(18, 4, number_format($detail['price'], 2), 0, 0, 'R'); // Harga per item
    $pdf->Cell(17, 4, number_format($detail['total_price'], 2), 0, 1, 'R'); // Total harga
    $total_price += $detail['total_price'];
}

$pdf->Ln(1);

// Garis pemisah
$pdf->Cell(0, 3, '===============================================', 0, 1, 'C');

// Total
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(40, 4, 'TOTAL', 0, 0, 'L');
$pdf->Cell(20, 4, number_format($total_price, 2), 0, 1, 'R');
$pdf->Ln(2);

// Buat Jarak
if ($pdf->GetY() < 85) {
    $pdf->Ln( 85 - $pdf->GetY());
}

// Footer
$pdf->Cell(0, 4, 'Thank You!', 0, 1, 'C');
$pdf->Cell(0, 4, 'Have good day, and see you next time.', 0, 1, 'C');
$pdf->Ln(2);

// Waktu transaksi
$pdf->Cell(0, 4, $sale['tgl_sale'], 0, 1, 'C');

// Output PDF
$pdf->Output('D', 'sale_' . $sale_id . '.pdf'); // 'D' untuk unduhan langsung tanpa menyimpan

// Clear session cart
unset($_SESSION['cart']);
?>
