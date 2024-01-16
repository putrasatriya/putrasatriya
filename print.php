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
        /*transform: scale(0.85);*/
        /*transform-origin: 0 0;*/
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
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
    <script>
        window.print();
    </script>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <center>
                    <img src="assets/img/bnw.png" width="46px">
                    <p><?php echo "Gerai Dagadu" ?><br>Yogyakarta, <?php echo date("j F Y G:i"); ?><br>No Transaksi : <?php echo $_GET['transaksi_id']; ?></p>
                </center>
                PENGUSAHA KENA PAJAK<br>
                Nama : PT. Aseli Dagadu Djokdja<br>
                Alamat : Gedongkuning Selatan No.128 Yogyakarta<br>
                NPWP : 01.852.147.6-541.000<br>
                Kasir : <?php echo $_GET['nama_kasir']; ?><br>
                <table style="width: 100%; font-size: 10px;"> <!-- Adjust font size as needed -->
                    <tr style="border-bottom: 1px solid black;">
                        <th style="text-align: center;">Detail Barang</th>
                        <th style="text-align: center;">Subtotal</th>
                    </tr>
                    <?php 
                    $no = 0;
                    $isi_barang = array();
                    foreach ($hsl as $isi) {
                        $isi_barang[] = $isi['kode_barang'];
                         ?>
                        <tr>
                            <td><?php echo $isi['saldo'] * -1; ?>Pcs &nbsp;&nbsp;@<?php echo rupiah($isi['harga_satuan']); ?><br>(<?php echo $isi['kode_barang']; ?>) <?php echo $isi['produk']; ?> </td>
                            <td style="text-align: center;"><?php echo rupiah($isi['harga_satuan'] * $isi['saldo'] * -1); ?>
                                <?php
                            $paramvcr = $_GET['transaksi_id'];
                            $jumlahpcr = $lihat->count_pocerDinota($paramvcr);
                            $vouchers = $lihat->getVoucherDinota($paramvcr);
                            $discountbrandArr = array();

                            if ($jumlahpcr > 0) {
                                    foreach ($vouchers as $poucher) {
                                        $discountbrandArr[] = $poucher['brand'];
                                    }       
                            }

                            foreach($discountbrandArr as $dbar){
                                // foreach($isi_barang as $ib){
                                    $diskonbrand = $lihat->pocerbrand($isi['kode_barang'],$dbar);
                                    $length = count($diskonbrand);
                                foreach ($diskonbrand as $dbr) {
                                    foreach ($vouchers as $poucher) {
                                                $parambrand = $poucher['brand'];
                                                $ketbrand = $poucher['kode_voucher'];
                                                if ($dbar == $parambrand && strpos($ketbrand, "9420") === false) {
                                                     echo "<br><i> Disc (-".rupiah($poucher['nominal']).")</i>";
                                                    $discountAmount = $poucher['nominal'];
                                                    }
                                            }
                                    }
                                    for ($i = 0; $i < $length; $i++) {
                                        if($discountTipe == 'persen'){
                                            $totalPrice -= (($discountAmount*$isi['jumlah'])*$totalPrice/100); // Apply discount percent
                                            }
                                        else{
                                            $totalPrice -= $discountAmount*$isi['jumlah'];
                                            }
                                    }
                                // }
                            }
                            ?>

                            </td>
                        </tr>
                    <?php
                    $no++;
                    } 
                    ?>
                                                <?php
                            // $paramvcr = $_GET['transaksi_id'];
                            // $jumlahpcr = $lihat->count_pocerDinota($paramvcr);
                            // $vouchers = $lihat->getVoucherDinota($paramvcr);
                            // $discountbrandArr = array();

                            // if ($jumlahpcr > 0) {
                            //         foreach ($vouchers as $poucher) {
                            //             $discountbrandArr[] = $poucher['brand'];
                            //         }       
                            // }

                            // foreach($discountbrandArr as $dbar){
                            //     foreach($isi_barang as $ib){
                            //         $diskonbrand = $lihat->pocerbrand($ib,$dbar);
                            //         $length = count($diskonbrand);
                            //     foreach ($diskonbrand as $dbr) {
                            //         foreach ($vouchers as $poucher) {
                            //                     $parambrand = $poucher['brand'];
                            //                     if ($dbar == $parambrand) {
                            //                          echo $poucher['nominal']."<br>";
                            //                         $discountAmount = $poucher['nominal'];
                            //                         }
                            //                 }
                            //         }
                            //         for ($i = 0; $i < $length; $i++) {
                            //             if($discountTipe == 'persen'){
                            //                 $totalPrice -= (($discountAmount*$isi['jumlah'])*$totalPrice/100); // Apply discount percent
                            //                 }
                            //             else{
                            //                 $totalPrice -= $discountAmount*$isi['jumlah'];
                            //                 }
                            //         }
                            //     }
                            // }
                            ?>
                    <tr style="border-bottom: 1px solid black;">
                            </tr>
                </table>
                <div  style="margin-top: -35px;">
                    <?php $no = 0;
                    foreach ($hsltrans as $isitrans) { ?>
                        <table style="width: 100%; font-size: 10px;">
                            <tr style="border-bottom: 1px">
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td style="text-align: center;"><?php echo rupiah($isitrans['sub_total']); ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid black;">
                                <td>Diskon</td>
                                <td style="text-align: center;"><?php echo "-".rupiah($isitrans['diskon']); ?></td>
                            </tr>
                            <tr>
                                <td><b>Total</b></td>
                                <td style="text-align: center;font-weight: bold;"><?php echo rupiah($isitrans['jumlah']); ?></td>
                            </tr>
                            <tr>
                                <!-- fungsi tampil tipe bayar -->
                                <?php
                                $ttp = $isitrans['tipe_pembayaran'];
                                if ($ttp == 1) {
                                    $tp = "CASH";
                                }else if($ttp == 2){
                                    $tp = "CREDIT CARD";
                                }else{
                                    $tp = "DEBIT CARD / QRIS";
                                }
                                ?>
                                <td>Bayar</td>
                                <td style="text-align: center;"><?php echo rupiah($isitrans['bayar']); ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid black;">
                                <td><b>Kembali</b></td>
                                <td style="text-align: center;font-weight: bold;"><?php echo rupiah($isitrans['kembali']); ?></td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td> Harga Termasuk PPN, Rincian : </td>
                            </tr>
                            <?php
                            $dpp = (100/111) * $isitrans['bayar'];
                            $ppn = (11/111) * $isitrans['bayar'];
                            ?>
                            <tr>
                                <td>DPP</td>
                                <td style="text-align: center;"><?php echo rupiah($dpp); ?></td>
                            </tr>
                            <tr>
                                <td>PPN</td>
                                <td style="text-align: center;"><?php echo rupiah($ppn); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan : 
                                    <br>[<?=$tp; ?>]
                                    <br><?=$isitrans['keterangan']; ?></td>
                            </tr>
                        </table>
                    <?php } ?>
                <!-- </div> -->
                <div class="clearfix"></div>
                <center>
                    <p>*Barang Promo tidak dapat ditukar.*</p>
                    <p>** Smart, Smile, Djokdja **<br>Developed By Kerjonline Freelance Team</p>
                </center>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>
