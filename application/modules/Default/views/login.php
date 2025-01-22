<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | Skymars SHOP </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/vendors/css/vendors.min.css">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/bootstrap-extended.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/colors.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/components.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/themes/dark-layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/themes/semi-dark-layout.css">

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/css/pages/authentication.css">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/template/assets/css/style.css">
  <!-- END: Custom CSS-->

  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.css">
  <script src="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/toastr/toastr.css">
</head>

<style>
  .field-icon {
    float: left;
    margin-left: 90%;
    margin-top: -26px;
    font-size: 16px;
    position: relative;
    z-index: 2;
    color: #ccc;
  }

  .login-page {
    background: url(<?php echo base_url(); ?>assets/tambahan/gambar/login-background-custom.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .gap-login {
    margin-top: 8px;
  }
</style>


<body class="login-page vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
  <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="row flexbox-container">
          <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-1 mb-0">
              <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                  <img style="width:100%;" src="<?php echo base_url(); ?>/template/images/pages/register.jpg">
                </div>
                <div class="col-lg-6 col-12 p-0">
                  <div class="card rounded-1 mb-0 px-2">
                    <div class="card-title" style="margin-top:10px;">
                      <center><img src="<?php echo base_url(); ?>assets/tambahan/gambar/skymars.png" width="100px;" /></center>
                      <h2 class="mb-0">
                        <center><b>Skymars Shop</b></center>
                      </h2>
                    </div>
                    <h6 class="mb-0">
                      <center>silahkan login dahulu</center>
                    </h6>
                    <div class="card-header">
                    </div>
                    <!--      <p class="px-2">Silahkan login.</p> -->
                    <div class="card-content gap-login">
                      <div class="card-body pt-1">
                        <form action="<?php echo base_url('Default/Auth/login2'); ?>" method="POST" id="FormLogin">
                          <input type="hidden" name="<?= get_csrf_name(); ?>" value="<?= get_csrf_token(); ?>" />

                          <fieldset class="form-label-group form-group position-relative has-icon-left">
                            <input type="text" class="form-control signup-input" id="username" placeholder="Username" name="username">
                            <div class="form-control-position">
                              <i class="feather icon-user"></i>
                            </div>
                            <label for="user-name">Username</label>
                          </fieldset>

                          <fieldset class="form-label-group position-relative has-icon-left">
                            <input class="form-control" name="password" type="password" id="password-field" placeholder="Password">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <div class="form-control-position">
                              <i class="feather icon-lock"></i>
                            </div>
                            <label for="user-password">Password</label>
                          </fieldset>

                          <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="text-left">
                              <fieldset class="checkbox">
                                <div class="vs-checkbox-con vs-checkbox-primary">
                                  <input type="checkbox" type="checkbox" name="remember" id="remember">
                                  <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                      <i class="vs-icon feather icon-check"></i>
                                    </span>
                                  </span>
                                  <span class="">Remember me</span>
                                </div>
                              </fieldset>
                            </div>
                            <div id='btn_loading'></div>
                            <div id="hilang">
                              <button type="submit" class="btn btn-primary float-right btn-inline">
                                <i class="fa fa-lock" aria-hidden="true"></i> &nbsp;Login
                              </button>
                            </div>
                            <div id="buka">
                              <button type="submit" class="btn btn-primary float-right btn-inline"><i class="fa fa-unlock" aria-hidden="true"></i> &nbsp;Login</button>
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

      </div>
    </div>
  </div>


  <script type="text/javascript">
    $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    $(function() {
      $("#buka").hide();
      $('#FormLogin').submit(function(e) {

        e.preventDefault();
        var error = 0;
        var message = "";

        if (error == 0) {
          var username = $("#username").val();
          var username = username.trim();
          if (username.length == 0) {
            error++;
            message = "Username wajib di isi.";
          }
        }

        if (error == 0) {
          var password = $("#password-field").val();
          var password = password.trim();
          if (password.length == 0) {
            error++;
            message = "Password wajib di isi.";
          }
        }

        if (error == 0) {
          $.ajax({
            beforeSend: function() {
              $("#buka").hide();
              $("#hilang").hide();
              $("#btn_loading").html("<button type='submit' class='btn btn-primary float-right btn-inline klik' disabled><i class='fa fa-refresh fa-spin'></i> &nbsp;Wait..</button>");
              $("#btn_loading").show();
            },
            url: $(this).attr('action'),
            type: "POST",
            cache: false,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(json) {
              if (json.status == true) {
                $("#btn_loading").hide();
                $("#buka").show();
                toastr.success(json.pesan, 'Success', {
                  timeOut: 5000
                }, toastr.options = {
                  "closeButton": true
                });
                window.location = json.url_home;
              } else {
                $("#btn_loading").hide();
                $("#hilang").show();
                toastr.error(json.pesan, 'Warning', {
                  timeOut: 5000
                }, toastr.options = {
                  "closeButton": true
                });
              }
            }
          });
        } else {
          toastr.error(message, 'Warning', {
            timeOut: 5000
          }, toastr.options = {
            "closeButton": true
          });
        }
      });
    });
  </script>

  <script src="<?php echo base_url(); ?>/template/vendors/js/vendors.min.js"></script>
  <script src="<?php echo base_url(); ?>/template/js/core/app-menu.js"></script>
  <script src="<?php echo base_url(); ?>/template/js/core/app.js"></script>
  <script src="<?php echo base_url(); ?>/template/js/scripts/components.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/toastr/toastr.js"></script>


</body>

</html>