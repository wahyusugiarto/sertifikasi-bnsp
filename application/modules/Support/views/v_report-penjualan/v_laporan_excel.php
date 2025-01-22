<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table>
    <tr>
        <td colspan="10" style="text-align: center; vertical-align: middle;">
            <h2>Report Data Penjualan Skymars SHOP</h2>
        </td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td colspan="10">Filter</td>
    </tr>
    <tr>
        <td></td>
        <td>Tanggal Report<span class="pull right">:</span></td>
        <td colspan="8" style="text-align: left;"><?= ($allDate > 0) ? "Semua Periode" : date('d-m-Y', strtotime($tanggalAwal)) . " - " . date('d-m-Y', strtotime($tanggalAkhir)); ?></td>
    </tr>
</table>
<br><br>
<table border="1" width="80%">
    <thead>
        <tr>
            <th align="center">No</th>
            <th align="center">Tanggal Penjualan</th>
            <th align="center">Kode Penjualan</th>
            <th align="center">Nama Member</th>
            <th align="center">Telp Member</th>
            <th align="center">Keterangan</th>
            <th align="center">Total Pembayaran</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($excel)) {
            foreach ($excel as $key => $data) {
                $total = $total + $data->total;
                $namaMember = $data->nama;

                $kodeInvoice =  $data->kode_penjualan;
                $ResKeterangan = $this->M_penjualan->selectDetail($kodeInvoice);

                $ket = '';
                $totalAsli = '';

                foreach ($ResKeterangan as $res) {
                    $ket .= '<li>' . $res->name . ' - ' . '( ' . $res->qty . ' x ' . $res->price . ' ) = ' . $res->subtotal . '';

                    $totalSubTotal = $totalSubTotal + $res->subtotal;
                    $totalSubTotal2 = $totalSubTotal2 + $res->subtotal2;
                    $untung = $totalSubTotal -  $totalSubTotal2;
                }


                if ($data->nama == '') {
                    $namaMember = '-';
                }

                $noTelp = $data->telp;
                if ($data->telp == '') {
                    $noTelp = '-';
                }
        ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= date('d-m-Y', strtotime($data->tanggal)); ?>&nbsp;</td>
                    <td><?= $data->kode_penjualan ?></td>
                    <td><?= $namaMember ?></td>
                    <td><?= $noTelp ?> &nbsp;</td>
                    <td><?= $ket ?>&nbsp;</td>
                    <td><?= $data->total ?>&nbsp;</td>

                </tr>
            <?php }  ?>
            <tr>
                <td colspan="6">
                    <center><b>Total Penjualan</b>
                    </center>
                </td>
                <td>
                    <b><?= $total ?></b>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <center><b>Total Keuntungan Penjualan ( <?= $total ?> - <?= $totalSubTotal2 ?> )</b></center>
                </td>
                <td>
                    <b><?= $untung ?></b>
                </td>
            </tr>

        <?php } else { ?>
            <tr>
                <td colspan="6">Belum Ada Data</td>
            </tr>
        <?php } ?>
    </tbody>
</table>