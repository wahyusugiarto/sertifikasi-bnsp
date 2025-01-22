<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Pencarian Barang</h4>
        </div>
        <hr>
        <div class="card-content">

          <div class="card-body">
            <form class="form form-horizontal" id="form-pembelian-tunai" method="POST">

              <div class="form-body">
                <div class="row">

                  <div class="col-10">

                    <div class="form-group row">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Cari Barang </label>
                      <div class="col-sm-5">

                        <button class="btn btn-sm btn-primary" id="fil_brg_beli" type="button"><i class="fa fa-plus"></i> Cari Barang</button>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 control-label">Supplier ( Dipilih saat pembayaran tunai )</label>
                      <div class="col-sm-3">

                        <select name="supplier" id="supplier" class="form-control selek-supplier" aria-describedby="sizing-addon2">
                          <option></option>
                          <?php
                          foreach ($supplier as $data) {
                          ?>
                            <option value="<?php echo $data->supplier; ?>">
                              <?php echo $data->supplier; ?>
                            </option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <input type="hidden" name="total" value="<?php echo $total; ?>">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <br>
              <button type="submit" class="btn btn-success"><i class="fa fa-location-arrow"></i> Bayar Tunai</button>
              <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_kredit"><i class="fa fa-location-arrow"></i> Bayar Kredit</button> -->
            </form>
          </div>
        </div>
      </div>
    </div>



    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Pembelian Barang</h4>
        </div>
        <hr>
        <div class="card-content">

          <div class="card-body card-dashboard">
            <div class="table-responsive">

              <h5 align="right" id="totalbeli">Total Pembelian : Rp <?php echo number_format($total, 0, ".", "."); ?></h5>

              <table id="table_cart" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="center">Foto Produk</th>
                    <th class="center">Nama Barang</th>
                    <th class="center">Harga Barang</th>
                    <th class="center">Jumlah Beli</th>
                    <th class="center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $nomor = 1;
                  foreach ($cart as $items) { ?>
                    <tr>
                      <td class="center"><img class=" img-thumbnail" width="70px;" src="<?php echo $items->gambar; ?>"></td>
                      <td class="center"><?php echo $items->name; ?></td>
                      <td class="center"><?php echo number_format($items->price, 0, ".", "."); ?></td>
                      <td contenteditable="true" onBlur="updatepembelian(this,'qty','<?php echo $items->id; ?>')" onClick="showEdit(this);"><?php echo $items->qty; ?></td>
                      <td>
                        <button class="btn btn-icon btn-danger del_cart_pembelian" data-id="<?php echo $items->no; ?>"><i class="fa fa-close"></i> Delete</button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</section>

<script type="text/javascript">
  $('#fil_brg_beli').click(function() {
    $('#cr-brg_beli').modal('show');
    cr_brg_beli();
  });
</script>

<script type="text/javascript">
  var table_cart;
  $(document).ready(function() {
    //datatables
    table_cart = $('#table_cart').DataTable({
      "aLengthMenu": [
        [10, 50, 75, 100, 150, -1],
        [10, 50, 75, 100, 150, "All"]
      ],
      "pageLength": 10,
      "processing": true, //Feature control the processing indicator.
      oLanguage: {
        "sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
        sProcessing: "<img src='<?php base_url(); ?>assets/tambahan/gambar/loading.gif' width='25px'>",
        "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman",
        "sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
        "sInfoFiltered": "(difilter dari _MAX_ total data)",
        "sEmptyTable": "<img src='<?php base_url(); ?>assets/tambahan/gambar/empty2.png' width='80px'> <br> <b>Belum ada produk</b>",
        "oPaginate": {
          "sFirst": "Pertama",
          "sPrevious": "Sebelumnya",
          "sNext": "Selanjutnya",
          "sLast": "Terakhir"
        },
      },
    });
  });


  function showEdit(editableObj) {
    $(editableObj).css("background", "#FFF");
  }

  function updatepembelian(editableObj, column, id) {
    $(editableObj).css("background", "#FFF url(<?php echo base_url() ?>assets/tambahan/gambar/loaderIcon.gif) no-repeat right");
    $.ajax({
      url: "<?php echo base_url() ?>Master/Pembelian/updatecart",
      type: "POST",
      data: 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id +
        '&<?php echo $this->security->get_csrf_token_name(); ?>=' + '<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        $(editableObj).css("background", "#FDFDFD"),
          refresh_beli();
      }
    });
  }
</script>

<script type="text/javascript">
  //Proses Controller logic ajax

  $('#form-pembelian-tunai').submit(function(e) {
    var error = 0;
    var message = "";
    var data = new FormData(this);

    var supplier = $("#supplier").val();
    var supplier = supplier.trim();

    if (error == 0) {
      if (supplier.length == 0) {
        error++;
        message = "supplier harus di isi.";
      }
    }

    if (error == 0) {
      swal({
        title: "Melakukan Pembelian ?",
        text: "Yakin melakukan transaksi pembelian barang ini ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Iya Beli",
        confirmButtonColor: '#dc1227',
        customClass: ".sweet-alert button",
        closeOnConfirm: false,
        html: true
      }, function() {

        $.ajax({
          method: 'POST',
          beforeSend: function() {
            swal({
              imageUrl: "<?= base_url(); ?>assets/tambahan/gambar/ajax-loader.gif",
              title: "Proses",
              text: "Tunggu sebentar",
              showConfirmButton: false,
              allowOutsideClick: false
            });
          },
          url: '<?php echo site_url('Master/Pembelian/buyProduct'); ?>',
          type: "POST",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
        }).done(function(data) {
          var result = jQuery.parseJSON(data);
          if (result.status == true) {
            swal("Success", result.pesan, "success");
            refresh_beli();
          } else {
            swal("Warning", result.pesan, "warning");

          }
        })
      });
      e.preventDefault();
    } else {
      toastr.error(message, 'Warning', {
        timeOut: 5000
      }, toastr.options = {
        "closeButton": true
      });
      return false;
    }
  });

  // untuk select2 ajak pilih tipe
  $(function() {
    $(".selek-supplier").select2({
      placeholder: " -- pilih supplier -- "
    });
  });
</script>