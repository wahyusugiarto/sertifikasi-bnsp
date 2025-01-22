
<?php $this->load->view('media_manager/singleMediaManger') ?>
<?php $this->load->view('_heading/_headerContent') ?>

<style>

  #slider
  {
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
          <h4 class="card-title">Add Inventory</h4>
        </div><hr>

        <div class="card-content">
          <div class="card-body">

            <form class="form form-horizontal" id="form-tambah" method="POST">
             <input type="hidden" name="created_by" value="<?php echo $userdata->nama; ?>">

             <div class="form-body">
              <div class="row">

                <div class="col-10">

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 control-label">Gambar Produk</label>
                    <div class="col-sm-6">
                      <div class="product-images2">
                      </div>
                      <div class="clearfix"></div>
                      <button id="btn1" type="button" data-toggle="modal" data-target="#media-modal2" class="btn btn-sm btn-danger"><i class="fa fa-upload"></i>&nbsp;
                        Upload Images
                      </button>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Produk</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="nama" placeholder="Nama Produk" name="nama" aria-describedby="sizing-addon2">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 control-label">Kategori Produk</label>
                    <div class="col-sm-3">
                      <select id="kategori" class="form-control selek-status" aria-describedby="sizing-addon2">
                        <option></option>
                        <?php foreach ($kategori as $data) { ?>
                          <option value="<?php echo $data->id_kategori; ?>">
                            <?php echo $data->kategori; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div id="loadingImg">
                     <img src="<?php echo base_url()."assets/" ?>tambahan/gambar/loading-bubble.gif">
                     <p class="font-loading">Proccessing Data</font></p>
                   </div>

                 <input type="hidden" class="form-control"  name="kategori" id="res_kategori" aria-describedby="sizing-addon2">

                 <div class="form-group row">
                  <label class="col-sm-2 control-label">Kategori Sub Produk</label>
                  <div class="col-sm-3">
                    <select name="sub_kategori" id="res_sub_kategori" class="form-control selek-sub-status" aria-describedby="sizing-addon2">
                      <option></option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 control-label">Harga Beli</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="currency1" placeholder="Harga Beli" name="harga_beli" aria-describedby="sizing-addon2">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 control-label">Harga Jual</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="currency2" placeholder="Harga Jual" name="harga_jual" id="currency1" aria-describedby="sizing-addon2">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 control-label">Stok Awal</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="stok" placeholder="Stok" name="stok" id="stok" aria-describedby="sizing-addon2">
                  </div>
                </div>

                <div class="col-md-12">
                  <div id="buka"> 
                    <button name="simpan" type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                    <a class="klik ajaxify" href="<?php echo site_url('inventory'); ?>"><button class="btn btn-warning btn-flat" ><i class="fa fa-arrow-left"></i> Back</button></a>
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

    $(document).ready(function(){
      $('#btn1').show();
    });

    $('#form-tambah').submit(function(e) {
      var error = 0;
      var message = "";
      var data = new FormData(this);

      var nama = $("#nama").val();
      var nama = nama.trim();

      if (error == 0) {
        if (nama.length == 0) {
          error++;
          message = "Nama Produk harus di isi.";
        }
      }

      var kategori = $("#kategori").val();
      var kategori = kategori.trim();

      if (error == 0) {
        if (kategori.length == 0) {
          error++;
          message = "Kategori Produk harus di isi.";
        }
      }

      var sub_kategori = $("#res_sub_kategori").val();
      var sub_kategori = sub_kategori.trim();

      if (error == 0) {
        if (sub_kategori.length == 0) {
          error++;
          message = "Sub Kategori Produk harus di isi.";
        }
      }

      var currency1 = $("#currency1").val();
      var currency1 = currency1.trim();

      if (error == 0) {
        if (currency1.length == 0) {
          error++;
          message = "Harga Beli Produk harus di isi.";
        }
      }

      var currency2 = $("#currency2").val();
      var currency2 = currency2.trim();

      if (error == 0) {
        if (currency2.length == 0) {
          error++;
          message = "Harga Jual Produk harus di isi.";
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
        }, function () {

          $.ajax({
            method: 'POST',
            beforeSend: function () {
              swal({
                imageUrl: "<?= base_url(); ?>assets/tambahan/gambar/ajax-loader.gif",
                title: "Proses",
                text: "Tunggu sebentar",
                showConfirmButton: false,
                allowOutsideClick: false
              });
            },
            url: '<?php echo site_url('Master/Inventory/prosesTambah'); ?>',
            type:"post",
            data: data,
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
        });
        e.preventDefault();
      } else {
        toastr.error(message,'Warning', {timeOut: 5000},toastr.options = {
         "closeButton": true}); 
        return false;
      }
    });

    // untuk select2 ajak pilih tipe
    $(function () 
    {
      $(".selek-status").select2({
        placeholder: " -- pilih kategori -- "
      });
    });

    // untuk select2 ajak pilih tipe
    $(function () 
    {
      $(".selek-sub-status").select2({
        placeholder: " -- pilih sub kategori -- "
      });
    });

  </script>

  <script type="text/javascript">
    $(function(){
      $("#loadingImg").hide();
      $("#loadingImg2").hide();

      $.ajaxSetup({
        type:"POST",
        url: "<?php echo base_url('Master/Inventory/ambilData') ?>",
        cache: false,
      });

    // custom untuk input

    $("#kategori").change(function(){
      var value=$(this).val();
      // console.log(value);
      if(value>0){
        $.ajax({
          beforeSend: function (){
            $("#loadingImg").fadeIn();
          },
          data:{modul:'kategori',id_kategori:value},
          success: function(respond){
            $("#res_kategori").val(respond);
            $("#loadingImg").fadeOut();  
            // console.log(respond);
          }
        })
      }
    });

    $("#kategori").change(function(){
      var value=$(this).val();
      // console.log(value);
      if(value>0){
        $.ajax({
          beforeSend: function (){
            $("#loadingImg").fadeIn();
          },
          data:{modul:'sub_kategori',id_kategori:value},
          success: function(respond){
            $("#res_sub_kategori").html(respond);
            $("#loadingImg").fadeOut();  
            // console.log(respond);
          }
        })
      }
    });
    
  })
</script>





