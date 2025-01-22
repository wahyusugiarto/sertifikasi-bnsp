<?php $this->load->view('_heading/_headerContent') ?>


<style>
    #report {
        max-width: 1200px;
        height: 330px;
        margin: 0 auto
    }
</style>

<section id="basic-datatable">

    <div class="box">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Data Report Stok</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">


                            <!-- /.box-header -->
                            <div class="box-body">

                                <div class="search-form" style="margin-bottom: 20px;">
                                    <div class="form-group ">
                                        <label class="control-label">Filter</label>
                                    </div>
                                    <form method="post" id="myform" action="<?= base_url('export-stok'); ?>">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="row" style=" padding-top: 8px; padding-bottom: 5px;">
                                                    <label class="col-md-2 control-label">Tanggal Report</label>


                                                    <div class="col-md-3">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon-search1"> <i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control datepicker" value="<?= date('01-m-Y'); ?>" readonly>&nbsp;
                                                        </div>
                                                    </div>

                                                    <span style="margin-top:10px ;"> s/d </span>

                                                    <div class="col-md-3">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon-search1"> <i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control datepicker" value="<?= date('t-m-Y'); ?>" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"></label>
                                                    <div class="col-sm-6">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" id="all_date" name="all_date" value="1" />&nbsp; Semua Tanggal
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button name="button_filter" id="button_filter" style="margin-top: 13px" type="button" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Tampilkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <table id="table" class=" table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th align="center">No</th>
                                        <th align="center">Kode Barang</th>
                                        <th align="center">Nama Barang</th>
                                        <th align="center">Kategori</th>
                                        <th align="center">Tanggal Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

</section>


<script>
    var table;

    function reloadTable() {
        $('#button_download').remove();
        $('.box-footer').append('<button name="button_download" id="button_download" style="margin-top: 13px" type="submit" class="btn btn-primary btn-flat"><i class="fa fa-download"></i> Download</button>');
        var status = $("#status").val();
        var tanggal_awal = $("#tanggal_awal").val();
        var tanggal_akhir = $("#tanggal_akhir").val();
        var all_date = 0;
        if (document.getElementById("all_date").checked == true) {
            all_date = 1;
        }
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            //  "scrollX": true,
            "destroy": true,
            "order": [], //Initial no order.
            oLanguage: {
                "sProcessing": "<img src='<?php base_url(); ?>assets/tambahan/gambar/loading.gif' width='25px'>",
                "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman",
                "sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
                "sInfoFiltered": "(difilter dari _MAX_ total data)",
                "sEmptyTable": "Tidak ada data transaksi",
                "sInfoPostFix": "",
                "sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
                "sPaginationType": "simple_numbers",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya",
                    "sLast": "Terakhir"
                }
            },
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= base_url('ajax-report-stok') ?>",
                "type": "POST",
                data: {
                    tanggal_awal: tanggal_awal,
                    tanggal_akhir: tanggal_akhir,
                    all_date: all_date
                },
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }, ],
        });
    }

    $("#button_filter").click(function() {
        var elementExists = document.getElementById("button_download");
        if (elementExists != null) {
            table.destroy();
        }
        reloadTable();
    });

    $(function() {
        $(".datepicker").pickadate({
            orientation: "left",
            autoclose: !0,
            format: 'dd-mm-yyyy'
        });
    });
</script>