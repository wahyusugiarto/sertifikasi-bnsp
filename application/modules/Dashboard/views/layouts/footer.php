</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
</div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2024<a class="text-bold-800 grey darken-2" href="https://www.skymarsdigital.com/" target="_blank">Skymars Digital,</a>All rights Reserved - Develop By Wahyu Sugiarto</span><span class="float-md-right d-none d-md-block">Aplikasi Versi 1.0<i class="fa fa-desktop"></i></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>

<script src="<?php echo base_url(); ?>template/js/core/app-menu.js"></script>
<script src="<?php echo base_url(); ?>template/js/core/app.js"></script>
<script src="<?php echo base_url(); ?>template/js/scripts/components.js"></script>
<script src="<?php echo base_url(); ?>template/js/scripts/datatables/datatable.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/scripts/forms/select/form-select2.js"></script>
<script src="<?php echo base_url(); ?>template/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>template/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
<script src="<?php echo base_url(); ?>template/vendors/js/pickers/pickadate/picker.js"></script>
<script src="<?php echo base_url(); ?>template/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="<?php echo base_url(); ?>template/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-summernote/summernote.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ajax.js"></script>
<script src='<?php echo base_url(); ?>assets/publik/js/jquery.fancybox.js'></script>
<script src="<?php echo base_url(); ?>assets/toastr/toastr.js"></script>
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/icon-picker/fontawesome-iconpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.maskMoney.js"></script>


<div id="loadingAjak"></div>
<script type="text/javascript">
    //klik loading ajax
    $(document).ready(function() {
        $('.klik').click(function() {
            var url = $(this).attr('href');
            $("#loading2").show().html("<img src='<?php base_url(); ?>assets/tambahan/gambar/loaders.gif' height='130'> ");
            $('#loadingAjak').show();
            $.ajax({
                complete: function() {
                    $("#loading2").hide();
                    $('#loadingAjak').hide();
                }
            });
            return true;
        });
    });
    // handle ajax link dengan konten
    var base_url = '<?= base_url(); ?>';
    var ajaxify = [null, null, null];


    $('.navigation').on('click', ' li > a.ajaxify', function(e) {
        var ele = $(this);
        function_ajaxify(e, ele);
    });

    $('.content-wrapper').on('click', 'a.ajaxify', function(e) {
        var ele = $(this);
        function_ajaxify(e, ele);
    });

    $('.dropdown-menu-right').on('click', 'a.ajaxify', function(e) {
        var ele = $(this);
        function_ajaxify(e, ele);
    });

    $('.nav-item').on('click', 'a.ajaxify', function(e) {
        var ele = $(this);
        function_ajaxify(e, ele);
    });


    // loading ajax
    $.ajaxSetup({
        beforeSend: function(xhr) {
            $("#loading2").show().html("<img src='<?php base_url(); ?>assets/tambahan/gambar/loaders.gif' height='130'> ");
            $('#loadingAjak').show();
        },
        complete: function() {
            $("#loading2").hide();
            $('#loadingAjak').hide();
        },
        error: function() {
            $("#loading2").hide();
            $('#loadingAjak').hide();
        }
    });
    // load konten ajax
    var function_ajaxify = function(e, ele) {
        e.preventDefault();
        var url = $(ele).attr("href");
        //var pageContent = $('.page-content');
        var pageContentBody = $('.content-wrapper');
        if (url != ajaxify[2]) {
            ajaxify.push(url);
            history.pushState(null, null, url);
        }
        ajaxify = ajaxify.slice(-3, 5);
        $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {
                status_link: 'ajax'
            },
            dataType: "html",
            success: function(res) {
                if (res.search("content-login") > 0) {
                    window.location = base_url + 'login';
                } else {
                    pageContentBody.html(res);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: 'error/error_404',
                    data: {
                        url: ajaxify[1],
                        url1: ajaxify[2]
                    },
                    dataType: "html",
                    success: function(res) {
                        if (res == 'out') {
                            window.location = base_url + 'login';
                        } else {
                            //hide_loading_bar();
                            pageContentBody.html(res);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        //hide_loading_bar();
                    }
                });
            }
        });
    }

    $("#filter_year").change(function() {
        $.ajax({
            url: '<?php echo base_url('change-year'); ?>',
            method: 'POST',
            data: {
                year: $(this).val()
            },
            success: function(data) {
                var result = jQuery.parseJSON(data);
                setTimeout(location.reload.bind(location), 450);
            },
        });
    });

    $('.format_currency').keyup(function() {
        this.value = formatRupiah(this.value);
    });

    function formatRupiah(bilangan, prefix) {
        var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function fileValidationPdf(size, labelsize) {
        $('.upload-pdf').change(function() {
            var fileInput = $(this).val();
            if (fileInput != '') {
                var checkfile = fileInput.toLowerCase();
                if (!checkfile.match(/(\.pdf)$/)) { // validasi ekstensi file
                    toastr.error('Maaf, Format file harus pdf.', 'Warning', {
                        timeOut: 5000
                    }, toastr.options = {
                        "closeButton": true
                    });
                    $(this).val('');
                    return false;
                }
                if (this.files[0].size > size) { // validasi ukuran size file
                    toastr.error('Maximal File ' + labelsize, 'Warning', {
                        timeOut: 5000
                    }, toastr.options = {
                        "closeButton": true
                    });
                    $(this).val('');
                    return false;
                }
                return true;
            }
        });
    }

    function fileValidationImage(size, labelsize) {
        $('.upload-image').change(function() {
            var fileInput = $(this).val();
            if (fileInput != '') {
                var checkfile = fileInput.toLowerCase();
                if (!checkfile.match(/(\.jpg|\.jpeg|\.png|\.gif)$/)) { // validasi ekstensi file
                    toastr.error('Maaf, Format file harus .jpeg |.jpg |.png | only.', 'Warning', {
                        timeOut: 5000
                    }, toastr.options = {
                        "closeButton": true
                    });
                    $(this).val('');
                    return false;
                }
                if (this.files[0].size > size) { // validasi ukuran size file
                    toastr.error('Maximal File ' + labelsize, 'Warning', {
                        timeOut: 5000
                    }, toastr.options = {
                        "closeButton": true
                    });
                    $(this).val('');
                    return false;
                }
                return true;
            }
        });
    }
</script>

</html>