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
                            <div class="dd menu-panjang" id="nestable" style="margin-bottom:5px;">
                                <?php
                                $ref = [];
                                $items = [];
                                foreach ($dataMenu3 as $data) {
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
                                        <span class="span-right"><span id="link_show' . $value['id_menu'] . '"></span> &nbsp;&nbsp;' . anchor('edit-menu/' . $value['id_menu'], '<span tooltip="Edit Data"><i class="fa fa-edit"></i></span> ', ' class="ajaxify" ') . '</span> 
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
                                <button name="simpan" type="submit" id="save2" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
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
                        <form class="form form-horizontal" id="form-update" method="POST">
                            <input type="hidden" name="id_menu" value="<?php echo $dataMenu->id_menu; ?>">
                            <input type="hidden" name="last_update_by" value="<?php echo $userdata->nama; ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Nama Menu</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" placeholder="nama menu" name="nama_menu" aria-describedby="sizing-addon2" value="<?php echo $dataMenu->nama_menu; ?>">
                                            </div>
                                        </div>  
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Icon</label>
                                            <div class="col-sm-5 wrap">
                                                <input type="text" class="form-control ikonpicker signup-input text-value" placeholder="icon menu" name="icon" aria-describedby="sizing-addon2" value="<?php echo $dataMenu->icon; ?>">
                                                <div class="ex">&times;</div>
                                            </div>    
                                        </div><br>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Link Menu</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" placeholder="link menu" name="link" aria-describedby="sizing-addon2" value="<?php echo $dataMenu->link; ?>">
                                            </div>
                                        </div>  
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 control-label">kode Menu</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" placeholder="kode menu" name="kode_menu" aria-describedby="sizing-addon2" value="<?php echo $dataMenu->kode_menu; ?>">
                                            </div>
                                        </div>  
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Jenis Menu</label>
                                            <div class="col-sm-5">
                                                <select name="parent" class="form-control select-menu" aria-describedby="sizing-addon2">
                                                    <option value="0">Menu Utama</option>
                                                    <option disabled="disabled">------------ SUB MENU FROM ------------</option>
                                                    <?php foreach ($dataMenu2 as $data) { ?>
                                                        <option value="<?php echo $data->id_menu; ?>"<?php echo ($data->id_menu == $dataMenu->parent) ? 'selected' : ''; ?>>
                                                            <?php echo $data->nama_menu; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Urutan</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" placeholder="urutan" name="urutan" aria-describedby="sizing-addon2" value="<?php echo $dataMenu->urutan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Menu Available</label>
                                            <div class="col-xs-3">
                                                <?php $menu = explode(",", $dataMenu->menu_file); ?>
                                                <input type='checkbox' name='menu_file[]' value="view" <?php
                                                foreach ($menu as $value) {
                                                    echo ('view' == $value) ? 'checked' : '';
                                                }

                                            ?> /> &nbsp;View<br>
                                            <input type='checkbox' name='menu_file[]' value="add" <?php
                                            foreach ($menu as $value) {
                                                echo ('add' == $value) ? 'checked' : '';
                                            }

                                        ?> /> &nbsp;Add<br>
                                        <input type='checkbox' name='menu_file[]' value="edit" <?php
                                        foreach ($menu as $value) {
                                            echo ('edit' == $value) ? 'checked' : '';
                                        }

                                    ?> /> &nbsp;Edit<br>
                                    <input type='checkbox' name='menu_file[]' value="del" <?php
                                    foreach ($menu as $value) {
                                        echo ('del' == $value) ? 'checked' : '';
                                    }

                                ?> /> &nbsp;Delete<br>                    
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="col-md-12" style="margin-bottom:15px;">
                        <hr>
                        <div id='btn_loading'></div>
                        <div id="buka"> 
                            <button name="simpan" type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Update</button>
                            <input type="hidden" id="nestable-output">
                            <a class="klik ajaxify" href="<?php echo site_url('menu'); ?>"><button class="btn btn-warning btn-flat" ><i class="fa fa-arrow-left"></i> Back</button></a>
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
        $('.ex').click(function () {
            $('.signup-input').val("");
        });
    });
</script>
<script>
    $(document).ready(function () {
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target), output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({group: 1}).on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target), action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#form-update').submit(function (e) {
            var data = $(this).serialize();
            $.ajax({
                method: 'POST',
                beforeSend: function () {
                    $("#buka").hide();
                    $("#btn_loading").html("<button type='submit' class='btn btn-success btn-flat' disabled><i class='fa fa-refresh fa-spin'></i> &nbsp;Wait..</button>");
                    $("#btn_loading").show();
                },
                url: '<?php echo base_url('update-menu') . '/' . $dataMenu->id_menu; ?>',
                data: data,
            }).done(function (data) {
                var result = jQuery.parseJSON(data);
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
        });

        $('.dd').on('change', function () {
            var dataString = {
                data: $("#nestable-output").val(),
            };
//            console.log(dataString);
$.ajax({
    type: "POST",
    url: "<?php echo base_url('save-sort-menu'); ?>",
    data: dataString,
    cache: false,
    success: function (data) {
    }, error: function (xhr, status, error) {
        alert(error);
    },
});
});

        $("#save2").click(function () {
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
        
    });
</script>
<script type="text/javascript">
    // untuk select2 ajak pilih menu
    $(document).ready(function () {
        $(".select-menu").select2({
            placeholder: " -- Pilih Jenis Menu -- "
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ikonpicker').iconpicker();
    });
</script>
