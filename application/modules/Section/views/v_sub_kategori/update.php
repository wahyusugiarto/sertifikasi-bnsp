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
          <h4 class="card-title">Edit Data Sub Kategori Barang</h4>
        </div>
        <hr>

        <div class="card-content">
          <div class="card-body">
            <form id="form-update" class="form-horizontal" method="POST">
              <input type="hidden" name="id" value="<?php echo $dataslider->id; ?>">

              <div class="form-body">
                <div class="row">

                  <div class="col-10">
                    <div class="form-group row">
                      <label class="col-sm-2 control-label">Kategori Produk</label>
                      <div class="col-sm-2">
                        <select name="kategori" id="kategori" class="form-control selek-status" aria-describedby="sizing-addon2">
                          <?php foreach ($kategori as $data) { ?>
                            <option value="<?php echo $data->id_kategori ?>" <?php if (
                                                                                $data->id_kategori ==
                                                                                $dataslider->kategori
                                                                              ) {
                                                                                echo "selected='selected'";
                                                                              } ?>><?php echo $data->kategori; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama Brand</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="sub_kategori" placeholder="Nama Produk" name="sub_kategori" aria-describedby="sizing-addon2" value="<?php echo $dataslider->sub_kategori; ?>">
                      </div>
                    </div>

                    <div class="col-md-8">
                      <div id="buka">
                        <button name="simpan" type="submit" class="btn btn-icon btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                        <a class="klik ajaxify" href="<?php echo site_url('sub-kategori'); ?>"><button class="btn btn-icon btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
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

  $('#form-update').submit(function(e) {
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

    var sub_kategori = $("#sub_kategori").val();
    var sub_kategori = sub_kategori.trim();

    if (error == 0) {
      if (sub_kategori.length == 0) {
        error++;
        message = "Sub Kategori harus di isi.";
      }
    }

    if (error == 0) {
      swal({
        title: "Update Data ?",
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
          url: '<?php echo site_url('Section/Sub_kategori/prosesUpdate'); ?>',
          type: "post",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
        }).done(function(data) {
          var result = jQuery.parseJSON(data);
          if (result.status == true) {
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

  $(document).ready(function() {
    $('#summernote').summernote({
      height: 150
    });
  });

  // untuk select2 ajak pilih tipe
  $(function() {
    $(".selek-status").select2({
      placeholder: " -- pilih status -- "
    });
  });
</script>