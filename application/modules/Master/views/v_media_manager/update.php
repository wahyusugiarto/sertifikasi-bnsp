<?php $this->load->view('media_manager/multiMediaManger') ?>
<?php $this->load->view('media_manager/singleMediaManger') ?>
<?php $this->load->view('media_manager/singleMediaMangerSecond') ?>

<style type="text/css">
  #btn_loading {
    display: none;
    width: 145%;
  }

  #btn_loading2 {
    display: none;
    width: 200%;
  }
</style>

<section id="basic-horizontal-layouts">
  <!-- style loading -->
  <div class="loading2"></div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Add New Product</h4>
        </div><hr>

        <div class="card-content">
          <div class="card-body">
            <form class="form form-horizontal" id="form-update" method="POST">
              <input type="hidden" name="id" value="<?php echo $brand->id ?>">

              <div class="form-body">
                <div class="row">

                  <div class="col-12">
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Title</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="judul" value="<?php echo $brand->judul ?>">
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 control-label">Single</label>
                      <div class="col-sm-7">
                        <div class="product-images2">
                          <div class="product-img2">
                            <img src="<?php echo $brand->file1 ?>" />
                            <a href="#" class="btn btn-sm btn-danger remove">
                              <span class="fa fa-trash"></span></a>
                            </div>
                            <button id="btn1" type="button" data-toggle="modal" data-target="#media-modal2" class="btn btn-sm btn-danger">
                              Upload Images
                            </button>
                          </div>
                        </div>
                      </div><!-- end .form-group -->

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 control-label">Single Second</label>
                        <div class="col-sm-7">
                          <div class="product-images3">
                            <div class="product-img3">
                              <img src="<?php echo $brand->file2 ?>" />
                              <a href="#" class="btn btn-sm btn-danger remove">
                                <span class="fa fa-trash"></span></a>
                              </div>

                              <button id="btn2" type="button" data-toggle="modal" data-target="#media-modal3" class="btn btn-sm btn-danger">
                                Upload Images
                              </button>
                            </div>
                          </div>

                        </div>

                        <div class="col-md-12"><hr>

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
                </div>
                </div>



                <div class="col-md-5">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Add New Product</h4>
                    </div><hr>

                    <div class="card-content">
                      <div class="card-body">

                        <form id="form-upload" method="POST">
                          <input type="hidden" name="id_pengajuan" value="<?php echo $brand->id ?>">
                          <div class="form-group row">
                            <label for="">Multiple</label>
                            <div class="product-images">
                              <?php if(!empty($mult)){ ?>
                                <?php foreach ($mult as $loop) { ?>
                                  <div class="product-img">
                                    <img src="<?php echo $loop->file ?>" />
                                    <button type="button" data-id="<?php echo $loop->id ?>" class="btn btn-sm btn-danger hapus-loop">
                                      <span class="fa fa-trash"></span></button>
                                    </div>
                                  <?php } } else { ?>

                                    <center><img id="not-found" style="border-color:white; margin-top:10px; width:150px; height:150px;" src="<?php echo base_url(); ?>assets/tambahan/gambar/empty.png" /></center>

                                  <?php }  ?>
                                </div>


                                <div class="clearfix"></div>

                                <button type="button" data-toggle="modal" data-target="#media-modal" class="btn btn-sm btn-danger">
                                  Upload Images
                                </button>
                              </div>

                              <div class="col-md-12"><hr>

                                <div id="buka2"> 
                                  <button name="simpan" type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>

                                <div id="btn_loading2">
                                  <button name="submit" type="submit" class="btn btn-primary btn-flat animated-gradient" disabled>&nbsp;Tunggu..</button>
                                </div>
                              </div>

                              </form>
                            </div>

                          </div>
                        </div> 

                      </div>


</div>
</section>

                    



                    <script type="text/javascript">
    //Proses Controller logic ajax

    $('#form-update').submit(function(e) {
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
          url: '<?php echo site_url('Master/Media_manager/prosesUpdate'); ?>',
          type:"post",
          data:new FormData(this),
          processData:false,
          contentType:false,
          cache:false,
        }).done(function (data) {
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
        e.preventDefault();
      } else {
        toastr.error(message,'Warning', {timeOut: 5000},toastr.options = {
         "closeButton": true}); 
        return false;
      }
    });
  </script>

  <script type="text/javascript">

    $('#form-upload').submit(function(e) {
      var error = 0;
      var message = "";

      var data = $(this).serialize();

      if (error == 0) {
        $.ajax({
          method: 'POST',
          beforeSend: function () {
            $("#buka2").hide();
            $("#btn_loading2").show();
          },
          url: '<?php echo site_url('Master/Media_manager/prosesUploadMultiple'); ?>',
          type:"post",
          data:new FormData(this),
          processData:false,
          contentType:false,
          cache:false,
        }).done(function (data) {
          var result = jQuery.parseJSON(data);
          if (result.status == true) {
            $("#buka2").show();
            $("#btn_loading2").hide();
            swal("Success", result.pesan, "success");
            setTimeout(location.reload.bind(location), 700);
          } else {
            $("#buka2").show();
            $("#btn_loading2").hide();
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




    $(document).on("click",".hapus-loop",function(){
      var id=$(this).attr("data-id");

      swal({
        title:"Delete Gambar ini?",
        text:"Yakin Hapus data ini ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: '#dc1227',
        customClass: ".sweet-alert button",
        closeOnConfirm: false,
        html: true
      },
      function(){
       $(".confirm").attr('disabled', 'disabled');
       $.ajax({
        method: "POST",
        url: "<?php echo base_url('Master/Media_manager/HapusTes'); ?>",
        data: "id=" +id,
        success: function (data) {
          var result = jQuery.parseJSON(data);
          if (result.status == true) {
            $(this).parent('.product-img').fadeOut('100', function(){
              $(this).remove();
            });
            swal("Success", result.pesan, "success");
            setTimeout(location.reload.bind(location), 700);
          } else {
            swal("Warning", result.pesan, "warning");
          }

        }
      });
     });
    });
  </script>


  



