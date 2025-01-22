<link rel="stylesheet" href="<?php echo base_url(); ?>assets/media_manager/media_manager.css">
<script src="<?php echo base_url(); ?>assets/media_manager/dropzone/dropzone.min.js"></script>


<!-- media modal... -->
<div class="modal fade text-left" id="media-modal"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">                
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">&nbsp; Media Manager</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		
			<div class="modal-body">
				<!-- nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active nav-item"><a href="#upload" class="nav-link active" id="halaman_upload" data-toggle="tab"><i class="fa fa-upload"></i>&nbsp; Upload</a></li>
					<li class="nav-item"><a href="#librayr" class="nav-link"  id="halaman-library" data-toggle="tab"><i class="fa fa-th"></i>&nbsp; Image Library</a></li>
					<li class="nav-item"><a href="#list-media-librayr" class="nav-link"  id="halaman-list-library" data-toggle="tab"><i class="fa fa-list"></i>&nbsp;Image Management Library</a></li>
					<li class="nav-item"><a href="#list-file-librayr" class="nav-link"  id="halaman-list-file-library" data-toggle="tab"><i class="fa fa-list"></i>&nbsp;File Management Library</a></li>
				</ul>

				<!-- tab panes -->
				<div class="tab-content">

					<div class="tab-pane active fade in" id="upload">
						<div class="dropzone" style="margin-top: 15px; height: 400px;">

							<div class="dz-message" style="margin-top: 100px;">
								<h3 style="margin-bottom: 15px;"> Drop files anywhere to upload</h3>
								<h5 style="margin-bottom: 15px;"> or</h5>
								<button class="upload-media"><i class="fa fa-cloud-upload-alt"></i>&nbsp; Select Files</button>
								<h5 style="margin-bottom: 15px;">Maksimal file upload 5MB</h5>
							</div>

						</div>
					</div>

					<!-- library tab -->
					<div class="tab-pane fade" id="librayr">
						<div class="search-container posisi" >
							<div class="search-media wrap2" >
								<input type="text" class="search-media" name="search_text" id="search_text" placeholder="Search.." name="search"><div class="ex2">&times;</div>
								<button><i class="fa fa-search"></i></button>
							</div>

							<div class="dropdown-media" >
								<select name="tipe"  id="tipe" class="form-control" >
									<option value="">Type</option>
									<option value="jpg">jpg</option>
									<option value="png">png</option>
									<option value="doc">docx</option>
									<option value="pdf">pdf</option>
									<option value="ppt">ppt</option>
									<option value="mp3">mp3</option>
									<option value="mp4">mp4</option>
								</select>
							</div>

							<div class="dropdown-media-sort" >
								<select name="sort" id="sort" class="form-control" >
									<option value="">Sort By</option>
									<option value="ASC">Terlama</option>
									<option value="DESC">Terbaru</option>
								</select>
							</div>

						</div>
						<!-- <div class="row"> -->
							<div class="">
								<div id="result"></div>

							</div>
							<div class="clearfix"></div>
						</div>

						<div class="tab-pane fade" id="list-media-librayr">

							<div class="table-responsive" style="margin-top: 20px;">
								<table id="table" class="table data-thumb-view" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Thumbnail</th>
											<th>Judul</th>
											<th width="200px;">Ukuran File</th>
											<th>Ekstensi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>

						</div>


						<div class="tab-pane fade" id="list-file-librayr">

							<div class="table-responsive" style="margin-top: 20px;">
								<table id="table2" class="table data-thumb-view" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Thumbnail</th>
											<th>Judul</th>
											<th width="200px;">Ukuran File</th>
											<th>Ekstensi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>

						</div>

					</div>
				</div>
				<div class="menu-show">
					<div class="modal-footer">
						<button type="button" id='insert_record' class="btn btn-sm btn-info insert button-insert"><i class="fa fa-share-square"></i>&nbsp; Insert</button>
						<button type="button" class="btn btn-sm  btn-secondary" id="uncek"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
					</div>
				</div>

				<div class="menu-show2">
					<div class="modal-footer">
						<button type="button" id='delete_record' class="btn btn-sm btn-danger button-hapus"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
						<button type="button" class="btn btn-sm  btn-secondary" id="uncek-list-data"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
					</div>
				</div>

				<div class="menu-show3">
					<div class="modal-footer">
						<button type="button" id='delete_record2' class="btn btn-sm btn-danger button-hapus"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
						<button type="button" class="btn btn-sm  btn-secondary" id="uncek-list-data2"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>



	<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

	<script type="text/javascript">

		Dropzone.autoDiscover = false;

		var foto_upload= new Dropzone(".dropzone",{
		url: "<?php echo base_url('Master/Media_manager/UploadMediaManager') ?>",
		method:"post",
    // acceptedFiles:"image/*",
    acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.mp3,.mp4,.mkv,.avi",
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks:true,
  }
  );

  //Event ketika Memulai mengupload
  foto_upload.on("complete", function(file) {
  	foto_upload.removeFile(file);
  });

  var dropDown = document.getElementById("tipe");
  var dropDown2 = document.getElementById("sort");

  $(document).ready(function(){
		// load_data();
		$('.menu-show').hide();
		$('.menu-show2').hide();
		$('.menu-show3').hide();
		var sort = $("#sort").val();
		console.log(sort);
		function load_data(query)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>Master/Media_manager/LoadMediaManager",
				method:"POST",
				data:{query:query},
				success:function(data){
					$('#result').html(data);
					$('.fancybox').fancybox();
					$(document).on("click",".popups",function(){
						var data=$(this).attr("data-id");
						var mpopup = document.getElementById('mpopupBox'+data);
						mpopup.style.display = "block";
						window.onclick = function(event) {
							if (event.target == mpopup) {
								mpopup.style.display = "none";
							}
						};
					})

				}
			})
		}

		function load_data2(query)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>Master/Media_manager/LoadMediaManager2",
				method:"POST",
				data:{query:query},
				success:function(data){
					$('#result').html(data);
					$('.fancybox').fancybox();
					$(document).on("click",".popups",function(){
						var data=$(this).attr("data-id");
						var mpopup = document.getElementById('mpopupBox'+data);
						mpopup.style.display = "block";
						window.onclick = function(event) {
							if (event.target == mpopup) {
								mpopup.style.display = "none";
							}
						};
					})
				}

			})
		}


		$('#search_text').keyup(function(){
			var search = $(this).val();
			if(search != '')
			{
				load_data(search);
			}
			else
			{
				load_data();
			}
		});

		$('.ex2').click(function () {
			$('.search-media').val("");
			load_data();
		});


		$("#tipe").change(function () {
			var value = $(this).val();
			console.log(value);
			if(value != '')
			{
				load_data(value);
			}
			else
			{
				load_data();
			}
		});

		$("#sort").change(function () {
			var value = $(this).val();
			console.log(value);
			if(value != '')
			{
				load_data2(value);
			} else
			{
				load_data();
			}
		});


		$('.button-insert').prop('disabled', true);
		$('.button-hapus').prop('disabled', true);
		var mediaModal = $('#media-modal'),
      library = $('#librayr'), //tab
      productImagesContainer = $('.product-images'); //container

      library.on('click','a',function(e){
      	e.preventDefault();

        // multiple
        var checkbox = $(this).find('input[type=checkbox]');
        if(!checkbox.is(':checked')){
        	checkbox.prop('checked', true);
        }else{
        	checkbox.prop('checked', false);
        }

        var len = $("input[type=checkbox]:checked").length;
        if (len > 0) {
        	$('.button-insert').prop('disabled', false);
        } else {
        	$('.button-insert').prop('disabled', true);
        }

      });

      $('#not-found').show();
      //insert button and send images to the form and hidden fields tooo....
      $('.insert').click(function(e){
        //collect checkbox
        var checkboxes = library.find('input[type=checkbox]')

        checkboxes.each(function(i, el){
          // $('.button-insert').prop('disabled', false);
          if(el.checked){
          	var imageId = $(el).parent().data('image-id');
          	var imgSrc = $(el).siblings('img').attr('src');
          	var imgVal = $(el).siblings('img').attr('alt');
          	var imgTipe = $(el).siblings('img').attr('title');

          	var template =  '<div class="product-img">'+
          	'<input type="hidden" name="gambar_multi[]" value="'+ imgVal +'">'+
          	'<input type="hidden" name="gambar_multi_tp" value="'+ imgTipe +'">'+
          	'<img src="'+ imgSrc +'" />'+
          	'<a href="#" class="btn btn-sm btn-danger remove">'+
          	'<span class="fa fa-trash"></span></a>'+
          	'</div>';
          	productImagesContainer.append(template);
          	// console.log(imgVal);
          }

        });

        //hide modal
        mediaModal.modal('hide');
        $('.insert_check').prop('checked', false);
        $('.button-insert').prop('disabled', true);
        dropDown.selectedIndex = 0;
        dropDown2.selectedIndex = 0;
        $('#not-found').hide();
        // load_data();
      });

      //remove product images js
      productImagesContainer.on('click', '.remove', function(e){
      	e.preventDefault();
        //fadeout animation and remove....
        $(this).parent('.product-img').fadeOut('100', function(){
        $(this).remove();
        $('#not-found').show();
        });
      });


      $('#uncek').click(function(){
      	$('.insert_check').prop('checked', false);
      	$('.button-insert').prop('disabled', true); 
      	dropDown.selectedIndex = 0;
      	dropDown2.selectedIndex = 0;
      });

      $('#halaman-library').click(function(){
      	load_data();
      	dropDown.selectedIndex = 0;
      	dropDown2.selectedIndex = 0;
      });


      $('#uncek-list-data').click(function(){
      	$('.delete_check').prop('checked', false);
      	$('.button-hapus').prop('disabled', true);
      	dropDown.selectedIndex = 0;
      	dropDown2.selectedIndex = 0;
      });

      $('#uncek-list-data2').click(function(){
      	$('.delete_check').prop('checked', false);
      	$('.button-hapus').prop('disabled', true);
      	dropDown.selectedIndex = 0;
      	dropDown2.selectedIndex = 0;
      });

    });

$(document).ready(function(){
	$("#halaman_upload").click(function(){
		$('.button-insert').prop('disabled', true);
		$('.insert_check').prop('checked', false);
		$('.delete_check').prop('checked', false);
		$('.button-hapus').prop('disabled', true);
		$('.menu-show').hide();
		$('.menu-show2').hide();
		$('.menu-show3').hide();
	});
});

$(document).ready(function(){
	$("#halaman-library").click(function(){
		$('.delete_check').prop('checked', false);
		$('.button-hapus').prop('disabled', true);
		$('.menu-show').show();
		$('.menu-show2').hide();
		$('.menu-show3').hide();
	});
});

$(document).ready(function(){
	$("#halaman-list-library").click(function(){
		$('.button-insert').prop('disabled', true);
		$('.insert_check').prop('checked', false);
		$('.delete_check').prop('checked', false);
		$('.button-hapus').prop('disabled', true);
		$('.menu-show').hide();
		$('.menu-show2').show();
		$('.menu-show3').hide();
		reload_table();
	});
});

$(document).ready(function(){
	$("#halaman-list-file-library").click(function(){
		$('.button-insert').prop('disabled', true);
		$('.insert_check').prop('checked', false);
		$('.delete_check').prop('checked', false);
		$('.button-hapus').prop('disabled', true);
		$('.menu-show').hide();
		$('.menu-show2').hide();
		$('.menu-show3').show();
		reload_table2();
	});
});

function checkcheckbox(){
   // Total checkboxes
   var length = $('.delete_check').length;
   // Total checked checkboxes
   var totalchecked = 0;
   $('.delete_check').each(function(){
   	if($(this).is(':checked')){
   		totalchecked+=1;
   		$('.pencet').fadeIn("slow");
   	} 
   });

   // Checked unchecked checkbox
   if(totalchecked > 0){
   	$('.button-hapus').prop('disabled', false);
   }else{
   	$('.button-hapus').prop('disabled', true);
   }
 }

</script>




<script type="text/javascript">
	var save_method; 
	var table;
	var table2;

	$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "bSort": false,
		"destroy": true,
        //  "scrollX": true,
        oLanguage: {
        	"sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
        	"sEmptyTable": "No data found in the server",
        	sProcessing: "<img src='<?php base_url();?>assets/tambahan/gambar/loading.gif' width='25px'>",
        	"sLengthMenu":"_MENU_ &nbsp;&nbsp;Data Per Halaman",
        	"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
        	"sInfoFiltered": "(difilter dari _MAX_ total data)",
        	"sEmptyTable": "Tidak ada data di server", 
        	"oPaginate": {
        		"sFirst":    "Pertama",
        		"sPrevious": "Sebelumnya",
        		"sNext":     "Selanjutnya",
        		"sLast":     "Terakhir"
        	}
        },

        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('Master/Media_manager/ajaxDataManager')?>",
        	"type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
          },
          ],

        });

  });


	$(document).ready(function() {

    //datatables
    table2 = $('#table2').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "bSort": false,
		"destroy": true,
        //  "scrollX": true,
        oLanguage: {
        	"sSearch": "<i class='fa fa-search fa-fw'></i> Cari : ",
        	"sEmptyTable": "No data found in the server",
        	sProcessing: "<img src='<?php base_url();?>assets/tambahan/gambar/loading.gif' width='25px'>",
        	"sLengthMenu":"_MENU_ &nbsp;&nbsp;Data Per Halaman",
        	"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
        	"sInfoFiltered": "(difilter dari _MAX_ total data)",
        	"sEmptyTable": "Tidak ada data di server", 
        	"oPaginate": {
        		"sFirst":    "Pertama",
        		"sPrevious": "Sebelumnya",
        		"sNext":     "Selanjutnya",
        		"sLast":     "Terakhir"
        	}
        },

        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('Master/Media_manager/ajaxDataManager2')?>",
        	"type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
          },
          ],

        });

  });


	function reload_table()
	{
    table.ajax.reload(null,false); //reload datatable ajax 
  }

  function reload_table2()
  {
    table2.ajax.reload(null,false); //reload datatable ajax 
  }

  function data_kosong()
  {
  	swal({
  		position: 'top',
  		type: 'warning',
  		confirmButtonText: "Ok",
  		confirmButtonColor: '#dc1227',
  		customClass: ".sweet-alert button",
  		closeOnConfirm: true,
  		title: 'Tidak ada data yang dihapus',
  		showConfirmButton: true,
  	})
  }

  // Delete record
  $('#delete_record').click(function(){

  	var deleteids_arr = [];
      // Read all checked checkboxes
      $("input:checkbox[class=delete_check]:checked").each(function () {
      	deleteids_arr.push($(this).val());
      });

      // Check checkbox checked or not
      if(deleteids_arr.length > 0){
      	swal({
      		title:"Hapus Data?",
      		text:"Yakin anda akan menghapus data ini ?",
      		type: "warning",
      		showCancelButton: true,
      		confirmButtonText: "Hapus",
      		confirmButtonColor: '#dc1227',
      		customClass: ".sweet-alert button",
      		closeOnConfirm: false,
      		html: true
      	},
      	function(){
      		$.ajax({
      			url: '<?php echo base_url('Master/Media_manager/HapusMedia'); ?>',
      			type: 'post',
      			data: {deleteids_arr: deleteids_arr},
      			beforeSend: function () {
      				swal({
      					imageUrl: "<?= base_url(); ?>assets/tambahan/gambar/ajax-loader.gif",
      					title: "Proses",
      					text: "Tunggu sebentar",
      					showConfirmButton: false,
      					allowOutsideClick: false
      				});
      			},
      			success: function (data) {
      				var result = jQuery.parseJSON(data);
      				if (result.status == true) {
      					swal("Success", result.pesan, "success");
      				} else {
      					swal("Warning", result.pesan, "warning");
      				}
      				reload_table();
      			}
      		});
      	})
      } else {
      	$('.button-hapus').prop('disabled', true);
      }
    });


  $('#delete_record2').click(function(){

  	var deleteids_arr = [];
      // Read all checked checkboxes
      $("input:checkbox[class=delete_check]:checked").each(function () {
      	deleteids_arr.push($(this).val());
      });

      // Check checkbox checked or not
      if(deleteids_arr.length > 0){
      	swal({
      		title:"Hapus Data?",
      		text:"Yakin anda akan menghapus data ini ?",
      		type: "warning",
      		showCancelButton: true,
      		confirmButtonText: "Hapus",
      		confirmButtonColor: '#dc1227',
      		customClass: ".sweet-alert button",
      		closeOnConfirm: false,
      		html: true
      	},
      	function(){
      		$.ajax({
      			url: '<?php echo base_url('Master/Media_manager/HapusMedia'); ?>',
      			type: 'post',
      			data: {deleteids_arr: deleteids_arr},
      			beforeSend: function () {
      				swal({
      					imageUrl: "<?= base_url(); ?>assets/tambahan/gambar/ajax-loader.gif",
      					title: "Proses",
      					text: "Tunggu sebentar",
      					showConfirmButton: false,
      					allowOutsideClick: false
      				});
      			},
      			success: function (data) {
      				var result = jQuery.parseJSON(data);
      				if (result.status == true) {
      					swal("Success", result.pesan, "success");
      				} else {
      					swal("Warning", result.pesan, "warning");
      				}
      				reload_table2();
      			}
      		});
      	})
      } else {
      	$('.button-hapus').prop('disabled', true);
      }
    });


  function myFunction(value) {
  	var copyText = document.getElementById("myInput"+value);
  	copyText.select();
  	copyText.setSelectionRange(0, 99999); /*For mobile devices*/
  	document.execCommand("copy");
  	toastr.success(copyText.value,'Link berhasil di copy', {timeOut: 5000},toastr.options = {
  		"closeButton": true});
  }

  // $(function () {
  // 	$(".select-menu-media").select2({
  // 		placeholder: " -- Tipe File -- "
  // 	});
  // });

</script>