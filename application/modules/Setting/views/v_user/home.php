<?php $this->load->view('_heading/_headerContent') ?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data User</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <?php if ($accessAdd > 0) { ?>
                                <a class="klik ajaxify" href="<?php echo site_url('add-user'); ?>"><button class="btn btn-icon btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Add Data</button></a>
                            <?php } ?>
                            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thumbnail</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    //untuk load data table ajax	
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({
            "aLengthMenu": [
                [10, 50, 75, 100, 150, -1],
                [10, 50, 75, 100, 150, "All"]
            ],
            "bSort": true,
            "destroy": true,
            "pageLength": 10,
            "processing": true, //Feature control the processing indicator.
            "order": [], //Initial no order.
            oLanguage: {
                "sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
                "sEmptyTable": "No data found in the server",
                sProcessing: "<img src='<?php base_url(); ?>assets/tambahan/gambar/loading.gif' width='25px'>",
                "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman",
                "sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
                "sInfoFiltered": "(difilter dari _MAX_ total data)",
                "sEmptyTable": "Tidak ada data di server",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya",
                    "sLast": "Terakhir"
                }
            },
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('ajax-user') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }, ],
            // "initComplete": function (settings, json) {
            //     $('.row').css('margin-right', '0px');
            //     $('.row').css('margin-left', '0px');
            // },
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    $(document).on("click", ".hapus-user", function() {
        var id = $(this).attr("data-id");
        swal({
            title: "Deleted Data?",
            text: "Are you sure deleted this data ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: '#dc1227',
            customClass: ".sweet-alert button",
            closeOnConfirm: false,
            html: true
        }, function() {
            $(".confirm").attr('disabled', 'disabled');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('delete-user'); ?>",
                data: "id=" + id,
                success: function(data) {
                    var result = jQuery.parseJSON(data);
                    if (result.status == true) {
                        $("tr[data-id='" + id + "']").fadeOut("fast", function() {
                            $(this).remove();
                        });
                        hapus_berhasil();
                        setTimeout("window.location='<?php echo base_url("user"); ?>'", 450);
                    } else {
                        swal("Warning", result.pesan, "warning");
                    }
                    reload_table();
                }
            });
        });
    });
</script>