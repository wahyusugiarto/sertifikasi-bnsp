<?php $this->load->view('_heading/_headerContent') ?>

<style>
  #slider {
    margin-left: 0px;
  }


  #btn_loading {
    display: none;
  }
</style>


<section id="basic-horizontal-layouts">
  <!-- style loading -->
  <div class="loading2"></div>
  <!-- -->

  <div class="card">

    <div class="row">
      <div class="col-md-12">

        <div class="card-header">
          <h4 class="card-title">Add Data Kategori Barang</h4>
        </div>
        <hr>

        <div class="card-content">
          <div class="card-body">

            <form class="form form-horizontal" id="form-tambah" method="POST">
              <input type="hidden" name="created_by" value="<?php echo $userdata->nama; ?>">

              <div class="form-body">
                <div class="row">

                  <div class="col-10">

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama Kategori Barang</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="kategori" placeholder="Judul Kategori" name="kategori" aria-describedby="sizing-addon2">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div id="buka">
                        <button name="simpan" type="submit" class="btn btn-icon btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                        <a class="klik ajaxify" href="<?php echo site_url('kategori'); ?>"><button class="btn btn-icon btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
                      </div>

                      <div id="btn_loading">
                        <button name="submit" type="submit" class="btn btn-primary btn-flat animated-gradient">&nbsp;Tunggu..</button>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
        <!-- /.box -->

      </div>
      <!-- /.row -->
    </div>
  </div>

</section>


<script type="text/javascript">
  //Proses Controller logic ajax

  $(document).ready(function() {
    $('#btn1').show();
  });

  $('#form-tambah').submit(function(e) {
    var error = 0;
    var message = "";
    var data = new FormData(this);

    var kategori = $("#kategori").val();
    var kategori = kategori.trim();

    if (error == 0) {
      if (kategori.length == 0) {
        error++;
        message = "Kategori harus di isi.";
      }
    }

    if (error == 0) {
      swal({
        title: "Simpan Data?",
        text: "Apakah Anda Yakin?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
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
          url: '<?php echo site_url('Section/Kategori/prosesTambah'); ?>',
          type: "post",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
        }).done(function(data) {
          var result = jQuery.parseJSON(data);
          if (result.status == true) {
            document.getElementById("form-tambah").reset();
            $("#buka").show();
            $("#btn_loading").hide();
            swal("Success", result.pesan, "success");
            setTimeout(location.reload.bind(location), 700);
          } else {
            $("#buka").show();
            $("#btn_loading").hide();
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
      placeholder: " -- pilih status -- "
    });
  });
</script>