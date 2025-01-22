<!DOCTYPE html>
<html>

<head>
  <title>Dashboard | Skymars SHOP </title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/publik/frontend/images/logo-login-white.png">
  <!-- meta -->

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <!-- BEGIN: Vendor CSS-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/tambahan.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/vendors/css/vendors.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/vendors/css/pickers/pickadate/pickadate.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/vendors/css/plugins/forms/pickers/form-pickadate.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/vendors/css/extensions/tether-theme-arrows.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/vendors/css/extensions/tether.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/vendors/css/extensions/shepherd-theme-default.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">

  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/bootstrap-extended.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/colors.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/components.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/themes/dark-layout.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/themes/semi-dark-layout.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/themes/semi-dark-layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/pages/data-list-view.css">

  <!-- css -->

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/pages/card-analytics.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/plugins/tour/tour.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/vendors/css/tables/datatable/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/vendors/css/forms/select/select2.min.css">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/assets/css/style.css">
  <!-- END: Custom CSS-->

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/eksternal/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/icon-picker/fontawesome5/css/all.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/icon-picker/fontawesome-iconpicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/eksternal/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-summernote/summernote.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/toastr/toastr.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetAlert.min2.js"></script>
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo base_url(); ?>template/vendors/js/vendors.min.js"></script>



  <style type="text/css">
    .menubar-icon {
      font-size: 30px;
    }

    .menu-panjang {
      width: 400px;
    }

    @media (max-width: 768px) {
      .menu-panjang {
        width: 350px;
      }
    }

    .menubar-icon-kecil {
      font-size: 20px;
      color: #28a745;
    }

    .animated-gradient {
      background: linear-gradient(-45deg, #007cba 28%, #006395 0, #006395 72%, #007cba 0);
      width: 10%;
      background-size: 200% auto;
      background-position: 0 100%;
      border-color: #007cba;
      animation: gradient 1s infinite;
      animation-fill-mode: forwards;
      animation-timing-function: linear;
    }

    @keyframes gradient {
      0% {
        background-position: 0 0;
      }

      100% {
        background-position: -200% 0;
      }
    }

    .merah {
      color: red;
    }


    .thumb1 {
      background: url(blah.jpg) 50% 50% no-repeat;
      /* 50% 50% centers image in div */
      width: 150px;
      height: 150px;
    }


    /* Important part */
    .modal-dialog {
      overflow-y: initial !important
    }

    .modal-body {
      height: 485px;
      overflow-y: auto;
    }

    .jarak-pop {
      margin-left: -10px;
    }

    .pdf {
      color: red;
    }


    @media only screen and (min-width: 800px) {
      .table-responsive {
        overflow: hidden;
      }
    }


    .control-sidebar {
      .tab-content {
        height: calc(100vh - 135px);
        overflow-y: scroll;
        overflow-x: hidden;
      }
    }

    @media (min-width: 768px) {
      .control-sidebar {
        .tab-content {
          height: calc(100vh - 85px);
        }
      }
    }

    /* START TOOLTIP STYLES */
    [tooltip] {
      position: relative;
      /* opinion 1 */
    }

    /* Applies to all tooltips */
    [tooltip]::before,
    [tooltip]::after {
      text-transform: none;
      /* opinion 2 */
      font-size: .9em;
      /* opinion 3 */
      line-height: 1;
      user-select: none;
      pointer-events: none;
      position: absolute;
      display: none;
      opacity: 0;
    }

    [tooltip]::before {
      content: '';
      border: 5px solid transparent;
      /* opinion 4 */
      z-index: 1001;
      /* absurdity 1 */
    }

    [tooltip]::after {
      content: attr(tooltip);
      /* magic! */

      /* most of the rest of this is opinion */
      font-family: Helvetica, sans-serif;
      text-align: center;

      /* 
    Let the content set the size of the tooltips 
    but this will also keep them from being obnoxious
    */
      min-width: 3em;
      max-width: 21em;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      padding: 1ch 1.5ch;
      border-radius: .3ch;
      box-shadow: 0 1em 2em -.5em rgba(0, 0, 0, 0.35);
      background: #333;
      color: #fff;
      z-index: 1000;
      /* absurdity 2 */
    }

    /* Make the tooltips respond to hover */
    [tooltip]:hover::before,
    [tooltip]:hover::after {
      display: block;
    }

    /* don't show empty tooltips */
    [tooltip='']::before,
    [tooltip='']::after {
      display: none !important;
    }

    /* FLOW: UP */
    [tooltip]:not([flow])::before,
    [tooltip][flow^="up"]::before {
      bottom: 150%;
      border-bottom-width: 0;
      border-top-color: #333;
    }

    [tooltip]:not([flow])::after,
    [tooltip][flow^="up"]::after {
      bottom: calc(150% + 5px);
    }

    [tooltip]:not([flow])::before,
    [tooltip]:not([flow])::after,
    [tooltip][flow^="up"]::before,
    [tooltip][flow^="up"]::after {
      left: 50%;
      transform: translate(-50%, -.5em);
    }

    /* KEYFRAMES */
    @keyframes tooltips-vert {
      to {
        opacity: .9;
        transform: translate(-50%, 0);
      }
    }

    @keyframes tooltips-horz {
      to {
        opacity: .9;
        transform: translate(0, -50%);
      }
    }

    /* FX All The Things */
    [tooltip]:not([flow]):hover::before,
    [tooltip]:not([flow]):hover::after,
    [tooltip][flow^="up"]:hover::before,
    [tooltip][flow^="up"]:hover::after,
    [tooltip][flow^="down"]:hover::before,
    [tooltip][flow^="down"]:hover::after {
      animation: tooltips-vert 300ms ease-out forwards;
    }

    [tooltip][flow^="left"]:hover::before,
    [tooltip][flow^="left"]:hover::after,
    [tooltip][flow^="right"]:hover::before,
    [tooltip][flow^="right"]:hover::after {
      animation: tooltips-horz 300ms ease-out forwards;
    }

    .login-page {
      background: url(<?php echo base_url(); ?>assets/tambahan/gambar/bg-transparant.png);
      background-position: center;
      background-repeat: no-repeat;
      /* background-size: cover; */
    }
  </style>

</head>

<body class="login-page vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

  <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="navbar-collapse" id="navbar-mobile">
          <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav">
              <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
              <li class="nav-item d-none d-lg-block"><a class="nav-link klik ajaxify" href="<?php echo site_url('inventory'); ?>" data-toggle="tooltip" data-placement="top" title="Inventory"><i class="ficon feather icon-database"></i></a></li>
              <li class="nav-item d-none d-lg-block"><a class="nav-link klik ajaxify" href="<?php echo site_url('pelanggan'); ?>" data-toggle="tooltip" data-placement="top" title="Pelanggan"><i class="ficon feather icon-user"></i></a></li>
              <li class="nav-item d-none d-lg-block"><a class="nav-link klik ajaxify" href="<?php echo site_url('supplier'); ?>" data-toggle="tooltip" data-placement="top" title="Supplier"><i class="ficon feather icon-users"></i></a></li>
            </ul>
          </div>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"><?php echo $this->session->userdata('nama') ?></span><span class="user-status">Available</span></div><span><img class="round" src="<?php echo $this->session->userdata('foto') ?>" alt="avatar" height="40" width="40"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right"><a class="ajaxify klik dropdown-item " href="<?php echo site_url('profile'); ?>"><i class="feather icon-user"></i> Edit Profile</a>
                <div class="dropdown-divider"></div><a class="dropdown-item logout" href="#"><i class="feather icon-power"></i> Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- sidebar -->
  <div id="loading2"></div>
  <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto"><a class="navbar-brand klik ajaxify" href="<?php echo site_url('Dashboard'); ?>">
            <h2 class="brand-text mb-0">Skymars</h2>
          </a></li>
        <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
      </ul>
    </div>


    <div class="shadow-bottom"></div>
    <!-- Sidebar Menu -->
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

        <!-- menu sidebar list-->

        <?php
        $this->load->model('M_sidebar');
        $menu = $this->M_sidebar->left_menu();
        if ($menu->num_rows() > 0) {
          foreach ($menu->result() as $row) {
            $menu_child = $this->M_sidebar->left_menu_child($row->id_menu);
            $active = ($this->uri->segment(1) == $row->link) ? 'active' : '';
            $open = ($this->uri->segment(1) == $row->link) ? 'open' : '';
            $access = $this->M_sidebar->access('view', $row->kode_menu);

            // jika view 1 (tampilkan menu)

            if ($access->menuview == 1) {
              if ($menu_child->num_rows() > 0) {
                echo "<li class='nav-item'>
          <a href='javascript:;'><i class='" . $row->icon . "'></i>
          <span class='menu-title'>&nbsp;" . $row->nama_menu . "</span>
          <span class='pull-right-container " . $open . "'></span>
          </a>";


                // untuk sub menu dropdownya
                echo "<ul class='menu-conten ajaxify'>";
                if ($menu_child->num_rows() > 0) {
                  foreach ($menu_child->result() as $obj) {
                    $access_child = $this->M_sidebar->access('view', $obj->kode_menu);
                    if ($access_child->menuview == 1) {
                      echo "<li><a class='ajaxify' href='" . site_url($obj->link) . "'>
               <i class='" . $obj->icon . "'></i>
               <span class='menu-title'>&nbsp;" . $obj->nama_menu . "</span>
               </a></li>";
                    }
                  }
                }
                echo "</ul></li>";
              } else {
                echo "
        <li class = '" . $active . "'>
        <a class='ajaxify' href='" . site_url($row->link) . "'>
        <i class='" . $row->icon . "'></i>
        <span class='title'>&nbsp;" . $row->nama_menu . "</span>
        </a></li>";
              }
            }
          }
        }
        ?>
      </ul>
    </div>
    <!-- /.sidebar-menu -->
    <!-- /.sidebar -->
  </div>

  <script>
    $('.main-menu-content  a').click(function() {
      // Remove all class active and display none
      $(".main-menu-content  .active").removeClass("active");
      $(".main-menu-content  .treeview-menu.menu-open").css("display", "none");
      $(".main-menu-content  .treeview-menu.menu-open").removeClass("menu-open");

    });
  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      <script type="text/javascript">
        $(".logout").click(function(event) {
          swal({
              title: "Keluar ?",
              text: " Ingin keluar Administrator ?",
              type: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes",
              confirmButtonColor: '#dc1227',
              customClass: ".sweet-alert button",
              closeOnConfirm: false,
              html: true
            },
            function() {
              $.ajax({
                type: "POST",
                url: "<?php echo site_url('Default/Auth/logout'); ?>",
                beforeSend: function() {
                  swal({
                    imageUrl: "<?= base_url(); ?>assets/tambahan/gambar/ajax-loader.gif",
                    title: "Proses",
                    text: "Tunggu sebentar",
                    showConfirmButton: false,
                    allowOutsideClick: false
                  });
                },
                success: function(data) {
                  swal({
                    type: 'success',
                    title: 'Keluar',
                    text: 'Anda Telah Keluar ',
                    showConfirmButton: false,
                    allowOutsideClick: false
                  });
                  setTimeout("window.location='<?= base_url("login"); ?>'", 900);
                }
              });
              event.preventDefault();
            });
        });
      </script>