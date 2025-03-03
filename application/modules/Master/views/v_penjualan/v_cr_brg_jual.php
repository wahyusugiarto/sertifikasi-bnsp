<table id="table" class="table" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Gambar</th>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Kategori</th>
			<th>Merek</th>
			<th width="100px">Harga Produk</th>
			<th>Stok Terkini</th>
			<th>Jml Beli</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		<?php $no = 1;
		foreach ($barang as $b) {
			if ($b->stok > 0) {
				$button = '<td><button type="button" class="btn btn-sm btn-primary" onclick="add_jual(' . $b->id . ')"><i class="fa fa-plus"></i> Tambah</button></td>';
			} else {
				$button = '<td><button type="button" class="btn btn-sm btn-danger" disabled><i class="fa fa-ban"></i> Stok kosong</button></td>';
			}

		?>
			<tr>
				<td class="center"><?php echo $no++; ?>
					<input type="hidden" id="cr_kd_brg_<?php echo $b->id; ?>" value="<?php echo $b->id; ?>">
					<input type="hidden" id="img_thumb_<?php echo $b->id; ?>" value="<?php echo $b->gambar; ?>">
					<input type="hidden" id="stok_<?php echo $b->id; ?>" value="<?php echo $b->stok; ?>">
				</td>
				</td>
				<input type="hidden" id="brg_buy_<?php echo $b->id; ?>" value="<?php echo number_format($b->harga_beli, 0, ".", "."); ?>""></td>
				<td><img class=" img-thumbnail" width="70px;" src="<?php echo $b->gambar; ?>"></td>
				<td><?php echo $b->kode_barang; ?></td>
				<td><?php echo $b->nama; ?><input style="border: 0" readonly="true" type="hidden" id="cr_nama_brg_<?php echo $b->id; ?>" value="<?php echo $b->nama; ?>"></td>
				<td><?php echo $b->kategori; ?></td>
				<td><?php echo $b->sub_kategori; ?></td>
				<td><input style="border: 0; width: 100px;" readonly="true" id="cr_hrg_brg_<?php echo $b->id; ?>" value="<?php echo number_format($b->harga_jual, 0, ".", "."); ?>" size="5"> </td>
				<td><?php echo $b->stok; ?></td>
				<td><input type="number" class="form-control" style="width: 80px;" name="qty" id="cr_qty_<?php echo $b->id; ?>"></td>
				<?php echo $button; ?>
			</tr>
		<?php  } ?>
	</tbody>
</table>

<script type="text/javascript">
	//untuk load data table ajax	
	var save_method; //for save method string
	var table;

	$(document).ready(function() {
		//datatables
		table = $('#table').DataTable({
			"aLengthMenu": [
				[10, 50, 75, 100, 150, -1],
				[10, 50, 75, 100, 150, "All"]
			],
			"bSort": false,
			// "scrollX": true,
			"pageLength": 10,
			oLanguage: {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
				"sEmptyTable": "No data found in the server",
				sProcessing: "<img src='<?php base_url(); ?>assets/tambahan/gambar/loading.gif' width='25px'>",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman",
				"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				"sInfoFiltered": "(difilter dari _MAX_ total data)",
				"sEmptyTable": "Belum ada data produk",
				"oPaginate": {
					"sFirst": "Pertama",
					"sPrevious": "Sebelumnya",
					"sNext": "Selanjutnya",
					"sLast": "Terakhir"
				},
			},
		});
	});
</script>