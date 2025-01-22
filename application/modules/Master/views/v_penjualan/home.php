<?php $this->load->view('_heading/_headerContent') ?>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Penjualan</h4>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard">
            <div class="table-responsive">

              <div class="gap"></div>
              <label class="control-label">Filter</label>

              <div class="form-group row">
                <div class="col-md-12">
                  <div class="row" style=" padding-top: 8px; padding-bottom: 5px;">
                    <label class="col-md-2 control-label">Tanggal</label>


                    <div class="col-md-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon-search1"> <i class="fa fa-calendar"></i></span>
                        </div>
                        <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control datepicker" value="<?= date('01-m-Y'); ?>" readonly>&nbsp;
                      </div>
                    </div>

                    <span style="margin-top:10px ;"> s/d </span>

                    <div class="col-md-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon-search1"> <i class="fa fa-calendar"></i></span>
                        </div>
                        <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control datepicker" value="<?= date('t-m-Y'); ?>" readonly="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="all_date" name="all_date" value="1" />&nbsp; Semua Tanggal
                      </label>
                    </div>

                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button name="button_filter" id="button_filter" style="margin-top: 13px" type="button" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Tampilkan</button>
              </div>

              <div class="gap"></div>

              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
  //untuk load data table ajax	

  var save_method; //for save method string
  var table;

  $(document).ready(function() {
    reloadTable();
  });

  function reloadTable() {
    var tanggal_awal = $("#tanggal_awal").val();
    var tanggal_akhir = $("#tanggal_akhir").val();
    var all_date = 0;
    if (document.getElementById("all_date").checked == true) {
      all_date = 1;
    }

    //datatables
    table = $('#table').DataTable({
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
        "sEmptyTable": "Tidak ada data di server",
        "oPaginate": {
          "sFirst": "Pertama",
          "sPrevious": "Sebelumnya",
          "sNext": "Selanjutnya",
          "sLast": "Terakhir"
        }
      },

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('Master/Penjualan/ajax_list') ?>",
        "type": "POST",
        data: {
          tanggal_awal: tanggal_awal,
          tanggal_akhir: tanggal_akhir,
          all_date: all_date
        },
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
      }, ],

    });

  };

  $("#button_filter").click(function() {
    table.destroy();
    reloadTable();
  });

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
  }

  $(document).on("click", ".hapus-penjualan", function() {
    var kode_penjualan = $(this).attr("data-id");

    swal({
        title: "Hapus Data?",
        text: "Yakin anda akan menghapus data ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        confirmButtonColor: '#dc1227',
        customClass: ".sweet-alert button",
        closeOnConfirm: false,
        html: true
      },
      function() {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: "<?php echo base_url('Master/Penjualan/hapus'); ?>",
          data: "kode_penjualan=" + kode_penjualan,
          success: function(data) {
            var result = jQuery.parseJSON(data);
            if (result.status == true) {
              $("tr[data-id='" + kode_penjualan + "']").fadeOut("fast", function() {
                $(this).remove();
              });
              swal("Success", result.pesan, "success");
            } else {
              swal("Warning", result.pesan, "warning");
            }
            reload_table();
          }
        });
      });
  });

  $(function() {
    $(".datepicker").pickadate({
      orientation: "left",
      autoclose: !0,
      format: 'dd-mm-yyyy'
    });
  });
</script>