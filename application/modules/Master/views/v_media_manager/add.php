
<?php $this->load->view('media_manager/multiMediaManger') ?>
<?php $this->load->view('media_manager/singleMediaManger') ?>
<?php $this->load->view('media_manager/singleMediaMangerSecond') ?>

<style type="text/css">
  #btn_loading {
    display: none;
    width: 145%;
  }
</style>

<?php $this->load->view('_heading/_headerContent') ?>


<section id="basic-horizontal-layouts">
  <!-- style loading -->
  <div class="loading2"></div>

  <div class="card">

    <div class="row">
      <div class="col-md-12">

        <div class="card-header">
          <h4 class="card-title">Add New Product</h4>
        </div><hr>

        <div class="card-content">
          <div class="card-body">

            <form class=" form form-horizontal" id="form-tambah" method="POST">
              <div class="form-body">
                <div class="row">

                  <div class="col-10">
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Judul</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="judul" placeholder="Judul" name="judul" aria-describedby="sizing-addon2">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Single</label>
                      <div class="col-sm-6">
                        <div class="product-images2">
                        </div>
                        <div class="clearfix"></div>
                        <button id="btn1" type="button" data-toggle="modal" data-target="#media-modal2" class="btn btn-sm btn-danger">
                          Upload Images
                        </button>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Single Second</label>
                      <div class="col-sm-6">
                        <div class="product-images3">
                        </div>


                        <div class="clearfix"></div>

                        <button id="btn2" type="button" data-toggle="modal" data-target="#media-modal3" class="btn btn-sm btn-danger">
                          Upload Images
                        </button>
                      </div>
                    </div>

                    <div class="form-group row">
                     <label for="inputEmail3" class="col-sm-2 control-label">multiple</label>
                     <div class="col-sm-6">
                      <div class="product-images">
                      </div>

                      <div class="clearfix"></div>

                      <button type="button" data-toggle="modal" data-target="#media-modal" class="btn btn-sm btn-danger">
                        Upload Images
                      </button>
                    </div>
                  </div>

                  <div class="col-md-12">

                    <div id="buka"> 
                      <button name="simpan" type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                      <a class="klik ajaxify" href="<?php echo site_url('media-manager'); ?>"><button class="btn btn-warning btn-flat" ><i class="fa fa-arrow-left"></i> Back</button></a>
                    </div>

                    <div id="btn_loading">
                      <button name="submit" type="submit" class="btn btn-primary btn-flat animated-gradient" disabled>&nbsp;Tunggu..</button>
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

    $(document).ready(function(){
      $('#btn1').show();
      $('#btn2').show();
    });

    $('#form-tambah').submit(function(e) {
      var error = 0;
      var message = "";

      var data = $(this).serialize();

      if (error == 0) {
        $.ajax({
          method: 'POST',
          beforeSend: function () {
            $("#buka").hide();
            $("#btn_loading").show();
          },
          url: '<?php echo site_url('Master/Media_manager/prosesAdd'); ?>',
          type:"post",
          data:new FormData(this),
          processData:false,
          contentType:false,
          cache:false,
        }).done(function (data) {
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
        e.preventDefault();
      } else {
        toastr.error(message,'Warning', {timeOut: 5000},toastr.options = {
         "closeButton": true}); 
        return false;
      }
    });


  </script>



  



