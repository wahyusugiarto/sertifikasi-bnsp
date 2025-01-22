<?php $this->load->view('_heading/_headerContent') ?>

<style>
    .select-width {width:310px;}
    #btn_loading {
        display: none;
    }
    #btn_loading2 {
        display: none;
    }

    .menu-panjang
    {
     max-width: 380px;
 }
</style>

<div class="content-body">
    <!-- Basic Horizontal form layout section start -->
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-5 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Menu Order</h4>
                    </div>
                    <hr>
                    <div class="card-content">
                        <div class="card-body" style="margin-top:-20px;">
                            <menu id="nestable-menu">
                                <button type="button" class="btn btn-warning" data-action="expand-all"><i class="fa fa-minus"></i> Expand All</button>
                                <button type="button" class="btn btn-primary" data-action="collapse-all"><i class="fa fa-plus"></i> Collapse All</button>
                            </menu>
                            <div class="dd menu-panjang" id="nestable">
                                <?php
                                $ref = [];
                                $items = [];
                                foreach ($dataMenu as $data) {
                                    $thisRef = &$ref[$data->id_menu];
                                    $thisRef['parent'] = $data->parent;
                                    $thisRef['nama_menu'] = $data->nama_menu;
                                    $thisRef['link'] = $data->link;
                                    $thisRef['id_menu'] = $data->id_menu;
                                    $thisRef['icon'] = $data->icon;
                                    if ($data->parent == 0) {
                                        $items[$data->id_menu] = &$thisRef;
                                    } else {
                                        $ref[$data->parent]['child'][$data->id_menu] = &$thisRef;
                                    }
                                }

                                function get_menu($items, $class = 'dd-list')
                                {
                                    $html = "<ol class=\"" . $class . "\" id=\"menu-id\">";
                                    foreach ($items as $key => $value) {
                                        $html .= '<li class="dd-item dd3-item" data-id="' . $value['id_menu'] . '" >
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content"><i class="' . $value['icon'] . '"></i>&nbsp;&nbsp; <span id="label_show' . $value['id_menu'] . '">' . $value['nama_menu'] . '</span> 
                                        <span class="span-right"><span id="link_show' . $value['id_menu'] . '"></span> &nbsp;&nbsp;' . anchor('edit-menu/' . $value['id_menu'], '<span tooltip="Edit Data"><i class="fa fa-edit"></i></span> ', ' class="ajaxify" ') . ' | 
                                        <a class="del-button" id="' . $value['id_menu'] . '"><span tooltip="Delete Data"><i class="fa fa-trash"></i></span></a></span> 
                                        </div>';
                                        if (array_key_exists('child', $value)) {
                                            $html .= get_menu($value['child'], 'child');
                                        }
                                        $html .= "</li>";
                                    }
                                    $html .= "</ol>";

                                    return $html;
                                }
                                print get_menu($items);

                                ?>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-bottom:20px;">
                            <div id="buka2">          
                                <button name="simpan" type="submit" id="save" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                            <div id='btn_loading2'></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Menu Order</h4>
                    </div>
                    <hr>
                    <div class="card-content">
                      <div class="card-body">
                        <form class="form form-horizontal" id="form-tambah" method="POST">
                            <div class="box-body">
                             <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama Menu</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="nama_menu" placeholder="nama menu" name="nama_menu" aria-describedby="sizing-addon2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">Icon</label>
                                <div class="col-sm-5 wrap">
                                    <input type="text" class="form-control ikonpicker signup-input text-value" id="icon" placeholder="icon menu" name="icon" aria-describedby="sizing-addon2">
                                    <div class="ex">&times;</div>
                                </div>
                            </div><br>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">Link Menu</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="link_menu" placeholder="link menu" name="link" aria-describedby="sizing-addon2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kode Menu</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="kode_menu" placeholder="kode menu" name="kode_menu" aria-describedby="sizing-addon2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Jenis Menu</label>
                                <div class="col-sm-5">
                                    <select name="parent" id="type" class="form-control select-menu" aria-describedby="sizing-addon2">
                                        <option></option>
                                        <option value="0">Menu Utama</option>
                                        <option value="sub-menu">Sub Menu</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="menu-show">
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Sub Menu</label>
                                    <div class="col-sm-5">
                                        <select name="parent" class="form-control select-kategori-menu select-width">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">Urutan</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="urutan_menu" placeholder="urutan" name="urutan" aria-describedby="sizing-addon2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">Menu Available</label>
                                <div class="col-xs-3">
                                    <input type='checkbox' name='menu_file[]' value="view" />&nbsp; View<br>
                                    <input type='checkbox' name='menu_file[]' value="add" />&nbsp; Add<br>
                                    <input type='checkbox' name='menu_file[]' value="edit" />&nbsp; Edit<br>
                                    <input type='checkbox' name='menu_file[]' value="del" />&nbsp; Delete<br>                   
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="col-md-12" style="margin-bottom:15px;">
                            <hr>
                            <div id='btn_loading'></div>
                            <div id="buka"> 
                                <button name="simpan" type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                <input type="hidden" id="nestable-output">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>


<script src="<?= base_url(); ?>assets/plugins/menu/jquery.nestable.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form-tambah').submit(function (e) {
            var data = $(this).serialize();
            var error = 0;
            var message = "";
            if (error == 0) {
                var nama_menu = $("#nama_menu").val();
                var nama_menu = nama_menu.trim();
                if (nama_menu.length == 0) {
                    error++;
                    message = "Nama menu harus di isi.";
                }
            }
            if (error == 0) {
                var icon = $("#icon").val();
                var icon = icon.trim();
                if (icon.length == 0) {
                    error++;
                    message = "Icon harus di isi.";
                }
            }
            if (error == 0) {
                var link_menu = $("#link_menu").val();
                var link_menu = link_menu.trim();
                if (link_menu.length == 0) {
                    error++;
                    message = "Link menu harus di isi.";
                }
            }
            if (error == 0) {
                var kode_menu = $("#kode_menu").val();
                var kode_menu = kode_menu.trim();
                if (kode_menu.length == 0) {
                    error++;
                    message = "Kode menu harus di isi.";
                }
            }
            if (error == 0) {
                var jenis_menu = $("#type").val();
                var jenis_menu = jenis_menu.trim();
                if (jenis_menu.length == 0) {
                    error++;
                    message = "Jenis menu harus di isi.";
                }
            }
            if (error == 0) {
                var urutan_menu = $("#urutan_menu").val();
                var urutan_menu = urutan_menu.trim();
                if (urutan_menu.length == 0) {
                    error++;
                    message = "Urutan menu harus di isi.";
                }
            }
            if (error == 0) {
                $.ajax({
                    method: 'POST',
                    beforeSend: function () {
                        $("#buka").hide();
                        $("#btn_loading").html("<button type='submit' class='btn btn-success btn-flat' disabled><i class='fa fa-refresh fa-spin'></i> &nbsp;Wait..</button>");
                        $("#btn_loading").show();
                    },
                    url: '<?= base_url('save-menu'); ?>',
                    type: "post",
                    data: data,
                }).done(function (data) {
                    var result = jQuery.parseJSON(data);
                    document.getElementById("form-tambah").reset();
                    if (result.status == true) {
                        $("#buka").show();
                        $("#btn_loading").hide();
                        setTimeout(location.reload.bind(location), 700);
                        toastr.success(result.pesan, 'Warning', {timeOut: 5000}, toastr.options = {
                            "closeButton": true});
                    } else {
                        $("#buka").show();
                        $("#btn_loading").hide();
                        toastr.error(result.pesan, 'Warning', {timeOut: 5000}, toastr.options = {
                            "closeButton": true});
                    }
                })
                e.preventDefault();
                
            } else {
                toastr.error(message, 'Warning', {timeOut: 5000}, toastr.options = {
                    "closeButton": true});
                return false;
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.ex').click(function () {
            $('.signup-input').val("");
        });

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target), output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({group: 1}).on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
            action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('.dd').on('change', function () {
            var dataString = {
                data: $("#nestable-output").val(),
            };
            console.log(dataString);
            $.ajax({
                type: "POST",
                url: "<?= base_url('save-sort-menu'); ?>",
                data: dataString,
                cache: false,
                success: function (data) {
                }, error: function (xhr, status, error) {
                    alert(error);
                },
            });
        });

        $("#save").click(function () {
            var dataString = {
                data: $("#nestable-output").val(),
            };
            $.ajax({
                beforeSend: function () {
                    $("#buka2").hide();
                    $("#btn_loading2").html("<button type='submit' class='btn btn-success btn-flat' disabled><i class='fa fa-refresh fa-spin'></i> &nbsp;Wait..</button>");
                    $("#btn_loading2").show();
                },
                type: "POST",
                url: "<?= base_url('save-sort-menu'); ?>",
                data: dataString,
                cache: false,
                success: function (data) {
                    var result = jQuery.parseJSON(data);
                    if (result.status == true) {
                        $("#btn_loading2").hide();
                        $("#buka2").show();
                        setTimeout(location.reload.bind(location), 500);
                        toastr.success(result.pesan, 'Warning', {timeOut: 5000}, toastr.options = {
                            "closeButton": true});
                    } else {
                        $("#btn_loading2").hide();
                        $("#buka2").show();
                        toastr.error(result.pesan, 'Warning', {timeOut: 5000}, toastr.options = {
                            "closeButton": true});
                    }
                }
            });
        });

        $(document).on("click", ".del-button", function () {
            var id = $(this).attr('id');
            console.log(id);
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
            }, function () {
                $(".confirm").attr('disabled', 'disabled');
                $.ajax({
                    method: "POST",
                    url: "<?= base_url('Setting/Menu_evo/prosesDelete'); ?>",
                    data: {id: id},
                    success: function (data) {
                        var result = jQuery.parseJSON(data);
                        if (result.status == true) {
                            $("li[data-id='" + id + "']").remove();
                            swal("Success", result.pesan, "success");
                        } else {
                            swal("Success", result.pesan, "success");
                        }
                    }
                });
            });
        });

        $(function () {
            $('.menu-show').hide();
            $('#type').change(function () {
                if ($('#type').val() == 'sub-menu') {
                    $('.menu-show').show();
                } else {
                    $('.menu-show').hide();
                }
            });
        });

        $('.select-kategori-menu').select2({
            placeholder: 'Pilih Sub Menu',
            allowClear: true,
            ajax: {
                url: "<?= base_url('ajax-menu') ?>",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        cari: params.term
                    };
                },
                processResults: function (data) {
                    var results = [];
                    $.each(data, function (index, item) {
                        results.push({
                            id: item.id_menu,
                            text: item.nama_menu
                        });
                    });
                    return{
                        results: results
                    };
                }
            }
        });

        $('.ikonpicker').iconpicker();
    });

$(function () {
    $(".select-menu").select2({
        placeholder: " -- Pilih Jenis Menu -- "
    });
});

</script>

