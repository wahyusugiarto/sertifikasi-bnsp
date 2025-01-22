<?php
$this->load->view('_heading/_headerContent');
$this->load->view('media_manager/singleMediaMangerMd');
$foto_user = $this->session->userdata('foto');
$nama_user = $this->session->userdata('nama');
?>

<style type="text/css">
    #slider {
        margin-left: -2%;
    }

    #btn_loading {
        display: none;
        width: 1250px;
    }

    #btn_loading2 {
        display: none;
        width: 1250px;
    }
</style>
<!-- style loading -->
<div class="loading2"></div>

<div class="content-body">
    <!-- account setting page start -->
    <section id="page-account-settings">
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                            <i class="feather icon-globe mr-50 font-medium-3"></i>
                            General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                            <i class="feather icon-lock mr-50 font-medium-3"></i>
                            Change Password
                        </a>
                    </li>
                </ul>
            </div>
            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                    <form class="form-horizontal" id="form-update" method="POST">
                                        <div class="media">

                                            <div class="product-images2">
                                                <a href="<?php echo $dataslider->gambar ?>" target="blank">
                                                    <div class="product-img2">
                                                        <img class="img-thumbnail" src="<?php echo $this->session->userdata('foto') ?>" />
                                                        <a href="#" class="btn btn-sm btn-danger remove">
                                                            <span class="fa fa-trash"></span></a>
                                                    </div>
                                                </a>
                                            </div>


                                            <div class="media-body mt-75">
                                                <button id="btn1" type="button" data-toggle="modal" data-target="#media-modal2" class="btn btn-sm btn-danger"><i class="fa fa-upload"></i>&nbsp;
                                                    Upload Images
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                        <input type="hidden" class="form-control" placeholder="Name" name="id" value="<?php echo $this->session->userdata('id') ?>">
                                        <input type="hidden" name="last_update_by" value="<?php echo $this->session->userdata('nama') ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-username">Username</label>
                                                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="<?php echo $this->session->userdata('username'); ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-name">Name</label>
                                                        <input type="text" class="form-control" placeholder="Name" id="nama" name="nama" value="<?php echo $this->session->userdata('nama') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-name">Level</label>
                                                        <?php
                                                        foreach ($datagrup as $data) {
                                                            $level = $this->session->userdata('grup_id');
                                                            if ($data->grup_id == $level) {

                                                        ?>
                                                                <input type="text" class="form-control" value="<?php echo $data->nama_grup; ?>" readonly>
                                                        <?php
                                                            }
                                                        } ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-name">Status</label>
                                                        <?php
                                                        foreach ($dataStatus as $data) {
                                                            $status = $this->session->userdata('status');
                                                            if ($data->id_status == $status) {

                                                        ?>
                                                                <p class="form-control-static"><?php echo $data->nama; ?></p>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div id="buka">
                                                    <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                        changes</button>
                                                    <button type="reset" class="btn btn-outline-warning">Cancel</button>
                                                </div>

                                                <div id="btn_loading" style="max-width:300%;">
                                                    <button name="submit" type="submit" class="btn btn-primary btn-flat animated-gradient">&nbsp;Tunggu..</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                    <form class="form-horizontal" id="form-update-pass" method="POST">
                                        <input type="hidden" class="form-control" placeholder="Name" name="id" value="<?php echo $this->session->userdata('id') ?>">
                                        <input type="hidden" name="last_update_by" value="<?php echo $this->session->userdata('nama') ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-old-password">Old Password</label>
                                                        <input type="password" class="form-control" placeholder="Password Lama" name="passLama">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-new-password">New Password</label>
                                                        <input type="password" class="form-control" placeholder="Password Baru" name="passBaru">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-retype-new-password">Retype New
                                                            Password</label>
                                                        <input type="password" class="form-control" placeholder="Konfirmasi Password" name="passKonf">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div id="buka2">
                                                    <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                        changes</button>
                                                    <button type="reset" class="btn btn-outline-warning">Cancel</button>
                                                </div>

                                                <div id="btn_loading2" style="max-width:300%;">
                                                    <button name="submit" type="submit" class="btn btn-primary btn-flat animated-gradient">&nbsp;Tunggu..</button>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- account setting page end -->

</div>

<script type="text/javascript">


    //Proses update ajax
    $(document).ready(function() {
        $('#form-update').submit(function(e) {
            $.ajax({
                url: '<?php echo base_url('Setting/Profile/update'); ?>',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#buka").hide();
                    $("#btn_loading").show();
                },
            }).done(function(data) {
                var result = jQuery.parseJSON(data);
                if (result.status == true) {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    setTimeout(location.reload.bind(location), 500);
                    swal("Success", result.pesan, "success");
                } else {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Warning", result.pesan, "warning");
                }
            })
            e.preventDefault();
        })
    });

    //Proses update password ajax
    $(document).ready(function() {
        $('#form-update-pass').submit(function(e) {
            $.ajax({
                url: '<?php echo base_url('Setting/Profile/ubah_password'); ?>',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#buka2").hide();
                    $("#btn_loading2").show();
                },
            }).done(function(data) {
                var result = jQuery.parseJSON(data);
                if (result.status == true) {
                    $("#buka2").show();
                    $("#btn_loading2").hide();
                    setTimeout(location.reload.bind(location), 500);
                    swal("Success", result.pesan, "success");
                } else {
                    $("#buka2").show();
                    $("#btn_loading2").hide();
                    swal("Warning", result.pesan, "warning");
                }
            })
            e.preventDefault();
        })
    });
</script>