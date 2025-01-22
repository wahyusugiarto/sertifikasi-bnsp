<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table>
    <tr>
        <td colspan="10" style="text-align: center; vertical-align: middle;">
            <h2>Report Data Pembelian Skymars SHOP</h2>
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
            <th align="center">Tanggal Pembelian</th>
            <th align="center">Kode Pembelian</th>
            <th align="center">Nama Supplier</th>
            <th align="center">Keterangan</th>

            <th align="center">Total Pembelian</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($excel)) {
            foreach ($excel as $key => $data) {
                $total = $total + $data->total;

                $kodeInvoice =  $data->no_beli;
                $ResKeterangan = $this->M_pembelian->selectDetail($kodeInvoice);

                $ket = '';

                foreach ($ResKeterangan as $res) {
                    $ket .= '<li>' . $res->nama_brg . ' - ' . '( ' . $res->jml_brg . ' x ' . $res->harga_brg . ' )</li>';
                }
        ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= date('d-m-Y', strtotime($data->tanggal)); ?>&nbsp;</td>
                    <td><?= $data->no_beli ?></td>
                    <td><?= $data->supplier ?></td>
                    <td><?= $ket ?></td>
                    <td>
                        <center><?= $data->total ?>&nbsp;</center>
                    </td>
                </tr>
            <?php }  ?>
            <tr>
                <td colspan="5">
                    <center>Total Pembelian</center>
                </td>
                <td>
                    <center><?= $total ?></center>
                </td>
            </tr>

        <?php } else { ?>
            <tr>
                <td colspan="5">Belum Ada Data</td>
            </tr>
        <?php } ?>

    </tbody>
</table>