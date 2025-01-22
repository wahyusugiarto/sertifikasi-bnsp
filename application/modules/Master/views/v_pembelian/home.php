<?php $this->load->view('_heading/_headerContent') ?>


<div id="view_beli">
</div>

<div class="modal fade" id="cr-brg_beli" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">&nbsp; Cari Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <div id="v_beli"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function cr_brg_beli() //cari barang ketika pembelian
  {
    $.ajax({
      url: "<?php echo base_url(); ?>Master/Pembelian/searchBrg",
      method: "GET",
      success: function(data) {
        $('#v_beli').html(data);
      }
    });
  }
</script>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<script type="text/javascript">
  $(document).on("click", ".del_cart_pembelian", function() {
    var no = $(this).attr("data-id");

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
          url: "<?php echo base_url('Master/Pembelian/del_cart'); ?>",
          data: "no=" + no,
          success: function(data) {
            var result = jQuery.parseJSON(data);
            if (result.status == true) {
              $("tr[data-id='" + no + "']").fadeOut("fast", function() {
                $(this).remove();
              });
              refresh_beli();
              swal("Success", result.pesan, "success");
            } else {
              swal("Warning", result.pesan, "warning");
            }
          }
        });
      });
  });

  function fetch_beli() {
    $.ajax({
      url: "<?php echo base_url(); ?>Master/Pembelian/view_beli",
      method: "GET",
      success: function(data) {
        $('#view_beli').html(data);
      }
    });
  }
  fetch_beli();

  function refresh_beli() {
    $.ajax({
      url: "<?php echo base_url(); ?>Master/Pembelian/view_beli",
      method: "GET",
      success: function(data) {
        $('#view_beli').html(data);
      }
    });
  }

  function add_beli(nomor) {

    var error = 0;
    var message = "";


    var imgs = $('#img_thumb_' + nomor).val();
    var kd_brg = $('#cr_kd_brg_' + nomor).val();
    var nama = $('#cr_nama_brg_' + nomor).val();
    var harga = $('#cr_hrg_brg_' + nomor).val();
    var jumlah_beli = $('#cr_qty_' + nomor).val();

    var jumlah_beli = jumlah_beli.trim();

    if (error == 0) {
      if (jumlah_beli.length == 0) {
        error++;
        message = "jumlah beli harus di isi.";
      }
    }

    if (error == 0) {
      if (jumlah_beli == '0') {
        error++;
        message = "jumlah minimum harus 1 tidak boleh 0 .";
      }
    }

    if (error == 0) {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() ?>Master/Pembelian/add_cart",
        data: 'kd_brg=' + kd_brg + '&gambar=' + imgs + '&nama=' + nama + '&harga=' + harga + '&qty=' + jumlah_beli +
          '&<?php echo $this->security->get_csrf_token_name(); ?>=' + '<?php echo $this->security->get_csrf_hash(); ?>',
        success: function(data) {
          refresh_beli();
          $('#cr-brg_beli').modal('hide');
        }
      });
    } else {
      toastr.error(message, 'Warning', {
        timeOut: 5000
      }, toastr.options = {
        "closeButton": true
      });
      return false;
    }
  }
</script>