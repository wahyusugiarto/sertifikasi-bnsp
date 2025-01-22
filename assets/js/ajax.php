<script type="text/javascript">

// fungsi tambah gallery

	$('#form-tambah-gallery').submit(function(e) {
        var error = 0;
        var message = "";

      var data = $(this).serialize();

      var gambar = $("#gambar").val();
      var gambar = gambar.trim();

          if (error == 0) {
            if (gambar.length == 0) {
                error++;
                message = "Gambar tidak boleh kosong.";
            }

        }

      var judul = $("#judul").val();
      var judul = judul.trim();

          if (error == 0) {
            if (judul.length == 0) {
                error++;
                message = "Judul tidak boleh kosong.";
            }

        }

      var asal = $("#asal").val();
      var asal = asal.trim();

          if (error == 0) {
            if (asal.length == 0) {
                error++;
                message = "Lokasi tidak boleh kosong.";
            }

        }

      var tipe = $("#tipe").val();
      var tipe = tipe.trim();

          if (error == 0) {
            if (tipe.length == 0) {
                error++;
                message = "Tipe tidak boleh kosong.";
            }

        }


        if (error == 0) {
            $.ajax({
                method: 'POST',
                beforeSend: function () {
                $("#buka").hide();
                $("#btn_loading").show();
                },
                url: '<?php echo site_url('Master/Galeri/prosesAdd'); ?>',
                type:"post",
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
            }).done(function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == true) {
                    document.getElementById("form-tambah-gallery").reset();
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Success", result.pesan, "success");
                    setTimeout(location.reload.bind(location), 700);
                } else {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Warning", result.pesan, "warning");
                    
                }
            })
            e.preventDefault();
        } else {
            toastr.error(message,'Warning', {timeOut: 5000},toastr.options = {
             "closeButton": true}); 
            return false;
        }
    });


// fungsi update gallery

     $('#form-update-gallery').submit(function(e) {
        var error = 0;
        var message = "";

      var data = $(this).serialize();

      var judul = $("#judul").val();
      var judul = judul.trim();

          if (error == 0) {
            if (judul.length == 0) {
                error++;
                message = "Judul tidak boleh kosong.";
            }

        }

      var asal = $("#asal").val();
      var asal = asal.trim();

          if (error == 0) {
            if (asal.length == 0) {
                error++;
                message = "Lokasi tidak boleh kosong.";
            }

        }

      var tipe = $("#tipe").val();
      var tipe = tipe.trim();

          if (error == 0) {
            if (tipe.length == 0) {
                error++;
                message = "Tipe tidak boleh kosong.";
            }

        }
       
        if (error == 0) {
            $.ajax({
                method: 'POST',
                beforeSend: function () {
                $("#buka").hide();
                $("#btn_loading").show();
                },
                url: '<?php echo site_url('Master/Galeri/prosesUpdate'); ?>',
                type:"post",
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
            }).done(function (data) {
                var result = jQuery.parseJSON(data);
                if (result.status == true) {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Success", result.pesan, "success");
                    setTimeout(location.reload.bind(location), 700);
                } else {
                    $("#buka").show();
                    $("#btn_loading").hide();
                    swal("Warning", result.pesan, "warning");
                }
                 console.log(result);
            })
            e.preventDefault();
        } else {
            toastr.error(message,'Warning', {timeOut: 5000},toastr.options = {
             "closeButton": true}); 
            return false;
        }
    });



</script>