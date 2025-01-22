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
          <h4 class="card-title">Add Data Manual Stok</h4>
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
                      <label class="col-sm-2 control-label">Tipe</label>
                      <div class="col-sm-3">
                        <select name="tipe" class="form-control selek-tipe" aria-describedby="sizing-addon2">
                          <option></option>
                          <option value="tambah">Tambah Stok</option>
                          <option value="kurang">Kurangi Stok</option>

                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 control-label">Produk</label>
                      <div class="col-sm-8">
                        <select name="id_barang" style="width: 350px;" class="form-control selek-produk" aria-describedby="sizing-addon2">
                          <option></option>
                          <?php foreach ($produk as $data) { ?>
                            <option value="<?php echo $data->id; ?>">
                              <?php echo $data->kode_barang; ?> | <?php echo $data->nama; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Kuantitas</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="Kuantitas Stok" name="qty" aria-describedby="sizing-addon2" onkeypress="return hanyaAngka(event)">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Catatan</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="catatan"></textarea>
                      </div>
                    </div>


                    <div class="col-md-12">
                      <div id="buka">
                        <button name="simpan" type="submit" class="btn btn-icon btn-icon btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                        <a class="klik ajaxify" href="<?php echo site_url('manual-stok'); ?>"><button class="btn btn-icon btn-icon btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
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
          url: '<?php echo site_url('Master/Manual_stok/prosesTambah'); ?>',
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

  $(function() {
    $(".selek-produk").select2({
      placeholder: " -- pilih produk -- "
    });
  });


  $(function() {
    $(".selek-tipe").select2({
      placeholder: " -- pilih tipe -- "
    });
  });

  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }
</script>