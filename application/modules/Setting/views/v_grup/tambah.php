<?php $this->load->view('_heading/_headerContent') ?>

<style>
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
                    <h4 class="card-title">Add User Grup</h4>
                </div>
                <hr>

                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" id="form-tambah" method="POST">
                            <input type="hidden" name="created_by" value="<?php echo $userdata->nama; ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Grup</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="nama grup" name="nama_grup" aria-describedby="sizing-addon2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="deskripsi singkat" name="deskripsi" aria-describedby="sizing-addon2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="buka">
                                            <button name="simpan" type="submit" class="btn btn-icon btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                            <a class="klik ajaxify" href="<?php echo site_url('user-grup'); ?>"><button class="btn btn-icon btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
                                        </div>
                                    </div>
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
    $('#form-tambah').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
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
            $(".confirm").attr('disabled', 'disabled');
            $.ajax({
                beforeSend: function() {
                    $("#buka").hide();
                    $("#btn_loading").show();
                },
                url: '<?php echo base_url('save-grup'); ?>',
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
                    save_berhasil();
                    setTimeout("window.location='<?php echo base_url("add-grup"); ?>'", 450);
                } else {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Warning", result.pesan, "warning");
                }
            })
        });
    });
</script>