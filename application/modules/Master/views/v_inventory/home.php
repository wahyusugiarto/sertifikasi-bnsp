<?php $this->load->view('_heading/_headerContent') ?>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Inventory Produk</h4>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard">
            <div class="table-responsive">
              <?php if ($accessAdd > 0) { ?>
                <a class="klik ajaxify" href="<?php echo site_url('add-inventory'); ?>"><button class="btn btn-icon btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Add Data</button></a>
              <?php } ?>
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Thumbnail</th>
                    <th>Judul Barang / Produk</th>
                    <th>Kategori Barang</th>
                    <th>Brand</th>
                    <th>Stok Terkini</th>
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
        "url": "<?php echo site_url('Master/Inventory/ajax_list') ?>",
        "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
      }, ],

    });

  });


  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
  }

  $(document).on("click", ".hapus-inventory", function() {
    var id = $(this).attr("data-id");

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
          url: "<?php echo base_url('Master/Inventory/hapus'); ?>",
          data: "id=" + id,
          success: function(data) {
            var result = jQuery.parseJSON(data);
            if (result.status == true) {
              $("tr[data-id='" + id + "']").fadeOut("fast", function() {
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
</script>