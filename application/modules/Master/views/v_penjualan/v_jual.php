<section id="basic-datatable">
  <div class="row">
    <div class="col-3">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Add Barang</h4>
        </div>
        <hr>
        <div class="card-content">
          <div class="card-body">
            <div class="form-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group row"></label>
                    <div class="col-sm-12">
                      <center><button class="btn btn-sm btn-primary" id="fil_brg_jual" type="button"><i class="fa fa-plus"></i> &nbsp;Pilih Produk Barang</button></center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-9">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Informasi</h4>
        </div>
        <hr>
        <div class="card-content">


          <div class="card-body">
            <form class="form form-horizontal" id="form-pembutan-invoice" method="POST">
              <input type="hidden" name="total" value="<?php echo $total; ?>">
              <input type="hidden" class="form-control" id="nama" name="nama">
              <input type="hidden" class="form-control" id="telp" name="telp">

              <div class="form-body">
                <div class="row">

                  <div class="col-12">

                    <div class="form-group row">
                      <div class="col-sm-5">
                        <fieldset class="checkbox">
                          <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" type="checkbox" name="remember" id="chkPassport">
                            <span class="vs-checkbox">
                              <span class="vs-checkbox--check">
                                <i class="vs-icon feather icon-check"></i>
                              </span>
                            </span>
                            <span class="">Customer? </span>
                          </div>
                        </fieldset>
                      </div>
                    </div>


                    <div id="dvPassport" style="display: none">
                      <div class="form-group row">
                        <label class="col-sm-2 control-label">Customer</label>
                        <div class="col-sm-8">
                          <select id="kategori" name="id_user" style="width: 350px;" class="form-control selek-status" aria-describedby="sizing-addon2">
                            <option></option>
                            <?php foreach ($customer as $data) { ?>
                              <option value="<?php echo $data->id_pelanggan; ?>">
                                <?php echo $data->nama; ?> | <?php echo $data->telp; ?>
                              </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      </di>
                    </div>


                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Bayar</label>
                      <div class="col-sm-4">
                        <input type="text" id="bayar" class="form-control" placeholder="Uang yang dibayarkan" required="true" onkeyup="showkembali()">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Kembalian</label>
                      <div class="col-sm-4">
                        <input type="text" id="kembalian" class="form-control" readonly="true">
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="card-header">
                <h4 class="card-title">Informasi Pembelian</h4>
              </div>
              <hr>

              <h5 align="right" id="totalspk">Total Harga : Rp <?php echo number_format($total, 0, ".", "."); ?></h5>

              <table id="table_cart" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="center">Foto Produk</th>
                    <th class="center">Nama Barang</th>
                    <th class="center">Harga Barang</th>
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
                      <td class="center"><?php echo $items->qty; ?> x <?php echo number_format($items->price, 0, ".", "."); ?></td>
                      <td class="center">
                        <button class="btn btn-icon btn-danger del_cart_temp_jual" data-id="<?php echo $items->no; ?>"><i class="fa fa-close"></i> Delete</button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

              <input type="hidden" id="totbayar" name="total" value="<?php echo number_format($total, 0, ".", "."); ?>">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <br>
              <button type="submit" class="btn btn-success"><i class="fa fa-cart-plus"></i> Proses </button>
              <a class="klik ajaxify" href="<?php echo site_url('spk'); ?>"><button class="btn btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Informasi Pembelian</h4>
        </div>
        <hr>
        <div class="card-content">

          <div class="card-body card-dashboard">
            <div class="table-responsive">

              <table id="table-penjualan" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kode Invoice</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Status Print</th>
                    <th style="width:125px;">Action</th>
                  </tr>
                </thead>
                <tbody>
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
  $('#fil_brg_jual').click(function() {
    $('#cr_brg_jual').modal('show');
    cr_brg_jual();
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


  $(document).ready(function() {
    reloadTable();
  });

  function reloadTable() {
    //datatables
    table = $('#table-penjualan').DataTable({
      "processing": true, //Feature control the processing indicator.
      "order": [], //Initial no order.
      "destroy": true,
      oLanguage: {
        "sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
        "sEmptyTable": "No data found in the server",
        sProcessing: "<img src='<?php base_url(); ?>assets/tambahan/gambar/loading.gif' width='25px'>",
        "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman",
        "sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
        "sInfoFiltered": "(difilter dari _MAX_ total data)",
        "sEmptyTable": "<img src='<?php base_url(); ?>assets/tambahan/gambar/empty2.png' width='80px'> <br> <b>Data masih kosong</b>",
        "oPaginate": {
          "sFirst": "Pertama",
          "sPrevious": "Sebelumnya",
          "sNext": "Selanjutnya",
          "sLast": "Terakhir"
        }
      },

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('Master/Kasir/ajaxData') ?>",
        "type": "POST",
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
      }, ],
    });
  };



  $('#bayar').maskMoney({
    thousands: '.',
    decimal: ',',
    precision: 0
  });

  function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');

    for (var i = 0; i < angkarev.length; i++)
      if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';

    return rupiah.split('', rupiah.length - 1).reverse().join('');

  }

  function showkembali() {
    var harga = $('#totbayar').val().replace(".", "");
    var bayar = $('#bayar').val().replace(".", "");
    var kembali = bayar - harga;
    $('#kembalian').val(convertToRupiah(kembali));
  }

  function showEdit(editableObj) {
    $(editableObj).css("background", "#FFF");
  }

  function updatepembelian(editableObj, column, id) {
    $(editableObj).css("background", "#FFF url(<?php echo base_url() ?>assets/tambahan/gambar/loaderIcon.gif) no-repeat right");
    $.ajax({
      url: "<?php echo base_url() ?>Master/Kasir/updatecart",
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


  var input = document.getElementById('nama');
  input.onkeydown = function(event) {
    if (event.which == 8 || event.which == 46) {
      event.preventDefault();
    }
  }
  $('#nama').bind('keypress', function(e) {
    e.preventDefault();
  })

  var input2 = document.getElementById('telp');
  input2.onkeydown = function(event) {
    if (event.which == 8 || event.which == 46) {
      event.preventDefault();
    }
  }
  $('#telp').bind('keypress', function(e) {
    e.preventDefault();
  })

  $('#form-pembutan-invoice').submit(function(e) {
    var error = 0;
    var message = "";
    var data = new FormData(this);

    if (error == 0) {
      swal({
        title: "Yakin Proses Transaksi ?",
        text: "Silahkan cek kembali data produk ",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Iya Proses",
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
          url: '<?php echo site_url('Master/Kasir/SimpanPenjualan'); ?>',
          type: "POST",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
        }).done(function(data) {
          var result = jQuery.parseJSON(data);
          if (result.status == true) {
            swal("Success", result.pesan, "success");
            setTimeout("window.location='<?php echo site_url('kasir'); ?>'", 500);
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
    $(".selek-status").select2({
      placeholder: " -- pilih customer -- "
    });
  });

  $(function() {
    $("#chkPassport").click(function() {
      if ($(this).is(":checked")) {
        $("#dvPassport").show();
        $("#AddPassport").hide();
      } else {
        $("#dvPassport").hide();
        $("#AddPassport").show();
      }
    });
  });


  $(function() {

    $.ajaxSetup({
      type: "POST",
      url: "<?php echo base_url('Master/Kasir/ambilData') ?>",
      cache: false,
    });

    $("#kategori").change(function() {
      var value = $(this).val();
      // console.log(value);
      if (value > 0) {
        $.ajax({
          beforeSend: function() {
            $("#loadingImg").fadeIn();
          },
          data: {
            modul: 'nama',
            id_pelanggan: value
          },
          success: function(respond) {
            console.log(respond);
            $("#nama").val(respond);
          }
        })
      }
    });


    $("#kategori").change(function() {
      var value = $(this).val();
      // console.log(value);
      if (value > 0) {
        $.ajax({
          beforeSend: function() {
            $("#loadingImg").fadeIn();
          },
          data: {
            modul: 'telp',
            id_pelanggan: value
          },
          success: function(respond) {
            console.log(respond);
            $("#telp").val(respond);
          }
        })
      }
    });

  })
</script>