<?php
require 'config.php';
include $view;
$lihat = new view($config);
$toko = $lihat->toko();
$paramtr = $_GET['transaksi_id'];
$hsl = $lihat->penjualan($paramtr);
$hsltrans = $lihat->detail_transaksi($paramtr);

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function bulet($angka)
{
    $hasil_bulet = "Rp " . number_format($angka, 2, '', '.');
    return $hasil_bulet;
}
?>

<style type="text/css">
    body {
        font-family: Arial, sans-serif;
        font-size: 10px; /* Adjust font size as needed */
    }

    table {
        border-collapse: collapse;
        table-layout: fixed; /* Fixed layout to ensure equal column width */
    }

    th,
    td {
        /*border: 1px solid #000;*/
        padding: 3px; /* Adjust the padding as needed */
        text-align: left;
        word-wrap: break-word; /* Allow long text to wrap */
    }

    th {
        background-color: #f2f2f2;
    }
</style>
<html>

<head>
    <title>Print</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>

<body>
    <!-- <script>
        window.print();
    </script> -->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                Financial Report<br>
                <?php echo date("j F Y G:i"); ?><br>
                <br>
                    <?php 
                    $cash = $lihat -> financial_cash();
                    $credit = $lihat -> financial_credit();
                    $debit = $lihat -> financial_debit();
                    $disc = $lihat -> financial_disc();
                    $hasil = $lihat -> financial_today();
						foreach($hasil as $isi){ 
							$jum_sub_total += $isi['sub_total'];
							$jum_diskon += $isi['diskon'];
							$jum_jumlah += $isi['jumlah'];
							$jum_bayar += $isi['bayar'];
							$jum_kembali += $isi['kembali'];
							$jum_kuantitas += $isi['kuantitas'];
						}
                    ?>
                <div>
                        <table style="width: 280; font-size: 11px;">
                            <tr style="border-top : 1px double; black;" >
                                <td>Desc</td>
                                <td>Amount</td>
                                <td>Qty</td>
                            </tr>
                            <tr style="border-bottom : 1px double; black;">
                            	<td colspan="3"></td>
                            </tr>
                            <tr>
                                <td>Gross Sales</td>
                                <td><?= rupiah($jum_sub_total); ?></td>
                                <td><?= $jum_kuantitas; ?></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>- <?= rupiah($disc['sub_total']); ?></td>
                                <td><?= $disc['qty']; ?></td>
                            </tr>
                            <tr>
                                <td>Net Sales</td>
                                <td><?= rupiah($jum_jumlah); ?></td>
                                <td><?= $jum_kuantitas; ?></td>
                            </tr>
                            <tr>
                                <td>Credit</td>
                                <td><?= rupiah($credit['sub_total']); ?></td>
                                <td><?= $credit['qty']; ?></td>
                            </tr>
                            <tr>
                                <td>Debit</td>
                                <td><?= rupiah($debit['sub_total']); ?></td>
                                <td><?= $debit['qty']; ?></td>
                            </tr>
                            <tr>
                                <td>Cash</td>
                                <td><?= rupiah($cash['sub_total']); ?></td>
                                <td><?= $cash['qty']; ?></td>
                            </tr>
                        </table>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>
