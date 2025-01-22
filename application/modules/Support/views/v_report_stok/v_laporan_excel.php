<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table>
    <tr>
        <td colspan="10" style="text-align: center; vertical-align: middle;">
            <h2><?php echo $title2 ?></h2>
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
            <th align="center">Kode Barang</th>
            <th align="center">Nama Barang</th>
            <th align="center">Kategori</th>
            <th align="center">Stok Terkini</th>
            <th align="center">Stok Masuk</th>
            <th align="center">Stok Keluar</th>
            <th align="center">Tanggal Transaksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($excel)) {
            foreach ($excel as $key => $data) {
        ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $data->kode_barang ?></td>
                    <td><?= $data->nama_brg ?></td>
                    <td><?= $data->kategori ?></td>
                    <td><?= $data->stok ?></td>
                    <td><?= $data->beli ?></td>
                    <td><?= $data->jual ?></td>
                    <td><?= date('d-m-Y', strtotime($data->tanggal)); ?>&nbsp;</td>
                </tr>
            <?php }  ?>
        <?php } else { ?>
            <tr>
                <td colspan="10">Belum Ada Data</td>
            </tr>
        <?php } ?>

    </tbody>
</table>