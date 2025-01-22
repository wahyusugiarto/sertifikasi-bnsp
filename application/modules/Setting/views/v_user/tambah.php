<?php $this->load->view('_heading/_headerContent') ?>

<style>
    #btn_loading {
        display: none;
    }

    .field-icon {
        float: left;
        margin-left: 93%;
        margin-top: -25px;
        position: relative;
        z-index: 2;
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
                    <h4 class="card-title">Add User</h4>
                </div>
                <hr>

                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" id="form-tambah" method="POST">
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-10">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Admin Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="nama" placeholder="Admin Name" name="nama" aria-describedby="sizing-addon2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="email" placeholder="email user" name="email" aria-describedby="sizing-addon2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="username" placeholder="username" name="username" aria-describedby="sizing-addon2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control" id="password-field" placeholder="password" name="password" aria-describedby="sizing-addon2"><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Admin Toko</label>
                                            <div class="col-sm-3">
                                                <select name="id_toko" class="form-control select-bengkel" aria-describedby="sizing-addon2">
                                                    <option></option>
                                                    <?php foreach ($dataToko as $data) { ?>
                                                        <option value="<?php echo $data->id_toko; ?>">
                                                            <?php echo $data->nama; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Grup</label>
                                            <div class="col-sm-3">
                                                <select name="grup_id" id="grup" class="form-control select-group" aria-describedby="sizing-addon2">
                                                    <?php foreach ($datagrup as $data) { ?>
                                                        <option value="<?php echo $data->grup_id; ?>">
                                                            <?php echo $data->nama_grup; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div id="buka">
                                            <button name="simpan" type="submit" class="btn btn-icon btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                            <a class="klik ajaxify" href="<?php echo site_url('user'); ?>"><button class="btn btn-icon btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
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
    function cekemail(a) {
        re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return re.test(a);
    }

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
                beforeSend: function() {},
                url: '<?php echo base_url('save-user'); ?>',
                type: "post",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
            }).done(function(data) {
                var result = jQuery.parseJSON(data);
                if (result.status == true) {
                    document.getElementById("form-tambah").reset();
                    save_berhasil();
                    setTimeout("window.location='<?php echo base_url("add-user"); ?>'", 450);
                } else {
                    swal("Warning", result.pesan, "warning");
                }
            })
        });
    });

    // untuk select2 original
    $(function() {
        $(".select-group").select2({
            placeholder: " -- Pilih Group -- "
        });
    });

    $(function() {
        $(".select-bengkel").select2({
            placeholder: " -- Pilih Toko -- "
        });
    });

    // untuk show hide password
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>