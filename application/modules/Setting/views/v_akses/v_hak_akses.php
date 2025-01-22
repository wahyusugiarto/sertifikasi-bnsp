<?php $this->load->view('_heading/_headerContent') ?>


<style>
    #btn_loading {
        display: none;
    }

    .container2 {
        display: block;
        position: relative;
        padding-left: 10px;
        margin-left: 20px;
        margin-bottom: 0px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container2 input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        border-radius: 10px;
        background-color: #d4d2d2;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container2 input:checked~.checkmark {
        background-color: #28a745;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container2 input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container2 .checkmark:after {
        left: 7px;
        top: 4px;
        width: 7px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .font-data {
        font-family: Futura, Trebuchet MS, Arial, sans-serif;
        color: red;
        font-size: 13px;
    }
</style>

<div class="card">
    <div class="row">
        <div class="col-md-12">

            <div class="card-header">
                <h4 class="card-title">Konfigurasi Hak Akses</h4>
            </div>
            <hr>

            <div class="card-content">
                <div class="card-body">
                    <form id="form-update" method="post">
                        <table id="table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width='5%'>
                                        <center>#</center>
                                    </th>
                                    <th width='1%'>ICON</th>
                                    <th width='30%'>MENU DASHBOARD</th>
                                    <th width='20%'>SUB MENU</th>
                                    <th width='7%'>
                                        <center>READ</center>
                                    </th>
                                    <th width='7%'>
                                        <center>CREATE</center>
                                    </th>
                                    <th width='7%'>
                                        <center>EDIT</center>
                                    </th>
                                    <th width='7%'>
                                        <center>DELETE</center>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1;
                                foreach ($privilege as $row) {
                                    $view_pos = strpos($row->menu_file, "iew");
                                    $view = ($row->view == 1 and $view_pos != 0) ? 'checked=checked' : '';
                                    $viewavail = ($view_pos != 0) ? '' : 'disabled=disabled';

                                    $add_pos = strpos($row->menu_file, "dd");
                                    $add = ($row->add == 1 and $add_pos != 0) ? 'checked=checked' : '';
                                    $addavail = ($add_pos != 0) ? '' : 'disabled=disabled';

                                    $edit_pos = strpos($row->menu_file, "dit");
                                    $edit = ($row->edit == 1 and $edit_pos != 0) ? 'checked=checked' : '';
                                    $editavail = ($edit_pos != 0) ? '' : 'disabled=disabled';

                                    $del_pos = strpos($row->menu_file, "el");
                                    $del = ($row->del == 1 and $del_pos != 0) ? 'checked=checked' : '';
                                    $delavail = ($del_pos != 0) ? '' : 'disabled=disabled';

                                    echo "
                            <tr class='odd gradeX'>
                            <input type='hidden' name='id_menu[]' value=$row->menus />
                            <input type='hidden' name='grup_id' />
                            
                            <td><center>$no</center></td>
                            <td><i class='" . $row->icon . " menubar-icon-kecil '></i></td> 
                            <td>$row->nama_menu</td>	
                            <td><b>$row->menuparent</b></td>
                            <td class='center'><center><label class='container2'><input type='checkbox' class='check-item' value='1' name='view[$row->menus]' $view $viewavail /><span class='checkmark'></span></label></center></td>
                            <td class='center'><center><label class='container2'><input type='checkbox' class='flat-red value='1' name='add[$row->menus]' $add $addavail /><span class='checkmark'></span></label></center></td>
                            <td class='center'><center><label class='container2'><input type='checkbox' class='flat-red value='1' name='edit[$row->menus]' $edit $editavail /><span class='checkmark'></span></label></center></td>
                            <td class='center'><center><label class='container2'><input type='checkbox' class='flat-red value='1' name='del[$row->menus]' $del $delavail /><span class='checkmark'></span></label></center></td></tr>";
                                    $no++;
                                } ?>
                            </tbody>

                        </table>
                        <div class="col-md-12">
                            <hr>
                            <div id="buka">
                                <button name="simpan" type="submit" class="btn btn-icon btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                <a class="klik ajaxify" href="<?php echo site_url('user-grup'); ?>"><button class="btn btn-icon btn-warning btn-flat"><i class="fa fa-arrow-left"></i> Back</button></a>
                            </div>

                            <div id="btn_loading" style="width:130%">
                                <button name="submit" type="submit" class="btn btn-primary btn-flat animated-gradient" disabled> &nbsp;Tunggu..</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    //Proses update ajax
    $(document).ready(function() {
        $('#form-update').submit(function(e) {
            var token = "<?php echo $grup_id; ?>";
            console.log(token);
            $.ajax({
                url: "<?php echo base_url('update-hak-akses') ?>/" + token,
                type: "POST",
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
                    swal("Success", result.pesan, "success");
                    setTimeout("window.location='<?php echo base_url('user-grup'); ?>'", 450);
                } else {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Warning", result.pesan, "warning");
                }
            })
            e.preventDefault();
        })
    });

    //untuk load data table ajax 
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "aLengthMenu": [
                [50, 75, 100, 150, -1],
                [50, 75, 100, 150, "All"]
            ],
            "pageLength": 50,
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
            }
        });
    });
</script>