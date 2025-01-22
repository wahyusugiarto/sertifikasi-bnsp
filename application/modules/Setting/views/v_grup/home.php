<?php $this->load->view('_heading/_headerContent') ?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Grup Akses</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <?php if ($accessAdd > 0) { ?>
                                <a class="klik ajaxify" href="<?php echo site_url('add-grup'); ?>"><button class="btn btn-icon btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Add Data</button></a>
                            <?php } ?>
                            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Grup</th>
                                        <th>Modul Kategori</th>
                                        <th>Menu Akses</th>
                                        <th>Deskripsi</th>
                                        <th style="width:200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataWarna as $key => $data) {
                                        $loop = $data->grup_id;
                                        $dataakses = $this->M_grup->akses_grup($loop);

                                    ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $data->nama_grup; ?></td>
                                            <td>
                                                <?php
                                                foreach ($dataakses as $data1) {
                                                    if ($data1->view == 1) {
                                                        echo '' . $data1->menuparent . '<br>';
                                                    }
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                foreach ($dataakses as $data1) {
                                                    if ($data1->view == 1) {
                                                        echo '<li>' . $data1->nama_menu . '</li>';
                                                    }
                                                }

                                                ?>
                                            </td>
                                            <td><?php echo $data->deskripsi; ?></td>

                                            <td>
                                                <a class="ajaxify" href="<?php echo base_url('edit-grup') . '/' . $data->grup_id ?>"><button class="btn btn-icon btn-primary"><i class="fa fa-edit"></i> </button></a>
                                                <a class="ajaxify" href="<?php echo base_url('hak-akses') . '/' . $data->grup_id ?>"><button class="btn btn-icon btn-success"><i class="fa fa-cogs"></i> </button></a>
                                                <button class="btn btn-icon btn-danger hapus-grup" data-id="<?php echo $data->grup_id; ?>"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
            "bSort": false,
            "destroy": true,
            "pageLength": 10,
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
                },
            },
            // "initComplete": function (settings, json) {
            //     $('.row').css('margin-right', '0px');
            //     $('.row').css('margin-left', '0px');
            // },
        });
    });

    $(document).on("click", ".hapus-grup", function() {
        var grup_id = $(this).attr("data-id");
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
                url: "<?php echo base_url('delete-grup'); ?>",
                data: "grup_id=" + grup_id,
                success: function(data) {
                    var result = jQuery.parseJSON(data);
                    if (result.status == true) {
                        $("tr[data-id='" + grup_id + "']").fadeOut("fast", function() {
                            $(this).remove();
                        });
                        hapus_berhasil();
                        setTimeout("window.location='<?php echo base_url("user-grup"); ?>'", 450);
                    } else {
                        swal("Warning", result.pesan, "warning");
                    }
                }
            });
        });
    });
</script>