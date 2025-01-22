<link rel="stylesheet" href="<?php echo base_url(); ?>assets/media_manager/media_manager.css">
<script src="<?php echo base_url(); ?>assets/media_manager/dropzone/dropzone.min.js"></script>


<!-- media modal... -->
<div class="modal fade text-left" id="media-modal3"  aria-hidden="true">
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
					<li class="active nav-item"><a href="#upload3" class="nav-link active" id="halaman_upload3" data-toggle="tab"><i class="fa fa-upload"></i>&nbsp; Upload</a></li>
					<li class="nav-item"><a href="#librayr3" class="nav-link" id="halaman-library3" data-toggle="tab"><i class="fa fa-th"></i>&nbsp; Image Library</a></li>
					<li class="nav-item"><a href="#list-media-librayr3" class="nav-link"  id="halaman-list-library3" data-toggle="tab"><i class="fa fa-list"></i>&nbsp;Image Management Library</a></li>
					<li class="nav-item"><a href="#list-file-librayr3" class="nav-link" id="halaman-list-file-library3" data-toggle="tab"><i class="fa fa-list"></i>&nbsp;File Management Library</a></li>
				</ul>

				<!-- tab panes -->
				<div class="tab-content">

					<div class="tab-pane active fade in" id="upload3">
						<div class="dropzone" id="dropzone3" style="margin-top: 15px; height: 400px;">

							<div class="dz-message" style="margin-top: 100px;">
								<h3 style="margin-bottom: 15px;"> Drop files anywhere to upload</h3>
								<h5 style="margin-bottom: 15px;"> or</h5>
								<button class="upload-media"><i class="fa fa-cloud-upload-alt"></i>&nbsp; Select Files</button>
								<h5 style="margin-bottom: 15px;">Maksimal file upload 5MB</h5>
							</div>

						</div>
					</div>

					<!-- library tab -->
					<div class="tab-pane fade" id="librayr3">
						<div class="search-container posisi" >
							<div class="search-media wrap2" >
								<input type="text" class="search-media" name="search_text3" id="search_text3" placeholder="Search.." name="search"><div class="ex2">&times;</div>
								<button><i class="fa fa-search"></i></button>
							</div>

							<div class="dropdown-media" >
								<select name="tipe3"  id="tipe3" class="form-control" >
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
								<select name="sort3" id="sort3" class="form-control" >
									<option value="">Sort By</option>
									<option value="ASC">Terlama</option>
									<option value="DESC">Terbaru</option>
								</select>
							</div>
						</div>
						<!-- <div class="row"> -->
							<div class="">
								<div id="results2"></div>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="tab-pane fade" id="list-media-librayr3">
							<div class="table-responsive" style="margin-top: 20px;">
								<table id="table5" class="table data-thumb-view" cellspacing="0" width="100%">
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


						<div class="tab-pane fade" id="list-file-librayr3">

							<div class="table-responsive" style="margin-top: 20px;">
								<table id="table6" class="table data-thumb-view" cellspacing="0" width="100%">
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
				<div class="menu-show7">
					<div class="modal-footer">
						<button type="button" id='insert_record' class="btn btn-sm btn-info insert-single2 button-insert3"><i class="fa fa-share-square"></i>&nbsp; Insert</button>
						<button type="button" class="btn btn-sm  btn-secondary" id="uncek2"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
					</div>
				</div>

				<div class="menu-show8">
					<div class="modal-footer">
						<button type="button" id='delete_record5' class="btn btn-sm btn-danger button-hapus3"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
						<button type="button" class="btn btn-sm  btn-secondary" id="uncek-list-data3"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
					</div>
				</div>

				<div class="menu-show9">
					<div class="modal-footer">
						<button type="button" id='delete_record6' class="btn btn-sm btn-danger button-hapus3"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
						<button type="button" class="btn btn-sm  btn-secondary" id="uncek-list-data4"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

<script type="text/javascript">

   Dropzone.autoDiscover = false;
	var foto_upload4= new Dropzone("#dropzone3",{
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
  foto_upload4.on("complete", function(file) {
  foto_upload4.removeFile(file);
  });

	var dropDown5 = document.getElementById("tipe3");
	var dropDown6 = document.getElementById("sort3");

	$(document).ready(function(){
		// load_data5();
		$('.menu-show7').hide();
		$('.menu-show8').hide();
		$('.menu-show9').hide();
		var sort = $("#sort3").val();
		
		function load_data5(query3)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>Master/Media_manager/LoadSingleMediaManager3",
				method:"POST",
				data:{query:query3},
				success:function(data){
					$('#results2').html(data);
					$('.fancybox').fancybox();
					$(document).on("click",".popups3",function(){
						var data3=$(this).attr("data-id");
						var mpopup3 = document.getElementById('popBox3'+data3);
						mpopup3.style.display = "block";

						window.onclick = function(event) {
							if (event.target == mpopup3) {
								mpopup3.style.display = "none";
								$('.button-insert3').prop('disabled', true);
							}
						};
					})
				}
			})
		}

		function load_data6(query3)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>Master/Media_manager/LoadSingleMediaManager4",
				method:"POST",
				data:{query:query3},
				success:function(data){
					$('#results2').html(data);
					$('.fancybox').fancybox();
					$(document).on("click",".popups3",function(){
						var data3=$(this).attr("data-id");
						var mpopup3 = document.getElementById('popBox3'+data3);
						mpopup3.style.display = "block";
						window.onclick = function(event) {
							if (event.target == mpopup3) {
								mpopup3.style.display = "none";
								$('.button-insert3').prop('disabled', true);
							}
						};
					})
				}

			})
		}

		$('#search_text3').keyup(function(){
			var search = $(this).val();
			if(search != '')
			{
				load_data5(search);
			}
			else
			{
				load_data5();
			}
		});

		$('.ex2').click(function () {
			$('.search-media').val("");
			load_data5();
		});


		$("#tipe3").change(function () {
			var value = $(this).val();
			console.log(value);
			if(value != '')
			{
				load_data5(value);
			}
			else
			{
				load_data5();
			}
		});

		$("#sort3").change(function () {
			var value = $(this).val();
			console.log(value);
			if(value != '')
			{
				load_data6(value);
			} else
			{
				load_data5();
			}
		});


		$('.button-insert3').prop('disabled', true);
		$('.button-hapus3').prop('disabled', true);

	  var mediaModal3 = $('#media-modal3'),
      library3 = $('#librayr3'), //tab
      productImagesContainer3 = $('.product-images3'); //container

      library3.on('click','a',function(e){
      	e.preventDefault();

        // single
        var checkbox = $(this).find('input[type=checkbox]');
        var len = $("input[type=checkbox]:checked").length;

        if (len > 0) {
        	$('.button-insert3').prop('disabled', false);
        	$('.insert_check3').prop('checked', false);
        	checkbox.prop('checked', true);

        }  else {
        	$('.button-insert3').prop('disabled', false);
        	checkbox.prop('checked', true);

        }

    });


       $('#btn2').hide();
      //insert button and send images to the form and hidden fields tooo....
      $('.insert-single2').click(function(e){
        //collect checkbox
        var checkboxes3 = library3.find('input[type=checkbox]')

        checkboxes3.each(function(i, el){
        	$('.button-insert3').prop('disabled', false);
        	if(el.checked){
        		var imageId = $(el).parent().data('image-id');
        		var imgSrc3 = $(el).siblings('img').attr('src');
        		var imgVal3 = $(el).siblings('img').attr('alt');
        		var imgTipe3 = $(el).siblings('img').attr('title');

        		var template3 =  '<div class="product-img3">'+
        		'<input type="hidden" name="gambar_single_sc" value="'+ imgSrc3 +'">'+
        		'<input type="hidden" name="gambar_single_sc_tp" value="'+ imgTipe3 +'">'+
        		'<img src="'+ imgSrc3 +'" />'+
        		'<a href="#" class="btn btn-xs btn-danger remove">'+
        		'<span class="fa fa-trash"></span></a>'+
        		'</div>';
        		productImagesContainer3.append(template3);
        		// console.log(imgVal3);
        	}
        });

        //hide modal
        mediaModal3.modal('hide');
        $('.insert_check3').prop('checked', false);
        $('.button-insert3').prop('disabled', true);
        dropDown5.selectedIndex = 0;
        dropDown6.selectedIndex = 0;
        load_data5();
        $('#btn2').hide();
    });

      //remove product images js
      productImagesContainer3.on('click', '.remove', function(e){
      	e.preventDefault();
        //fadeout animation and remove....
        $(this).parent('.product-img3').fadeOut('100', function(){
        	$(this).remove();
        	$('#btn2').show();
        });

    });

      $('#uncek2').click(function(){
      	$('.insert_check3').prop('checked', false);
      	$('.button-insert3').prop('disabled', true); 
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });

      $('#halaman-library3').click(function(){
      	load_data5();
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });

      $('#uncek-list-data3').click(function(){
      	$('.delete_check3').prop('checked', false);
      	$('.button-hapus3').prop('disabled', true);
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });

      $('#uncek-list-data4').click(function(){
      	$('.delete_check3').prop('checked', false);
      	$('.button-hapus3').prop('disabled', true);
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });
  });

$(document).ready(function(){
	$("#halaman_upload3").click(function(){
		$('.button-insert3').prop('disabled', true);
		$('.insert_check3').prop('checked', false);
		$('.delete_check3').prop('checked', false);
		$('.button-hapus3').prop('disabled', true);
		$('.menu-show7').hide();
		$('.menu-show8').hide();
		$('.menu-show9').hide();
	});
});

$(document).ready(function(){
	$("#halaman-library3").click(function(){
		$('.delete_check3').prop('checked', false);
		$('.button-hapus3').prop('disabled', true);
		$('.menu-show7').show();
		$('.menu-show8').hide();
		$('.menu-show9').hide();
	});
});

$(document).ready(function(){
	$("#halaman-list-library3").click(function(){
		$('.button-insert3').prop('disabled', true);
		$('.insert_check3').prop('checked', false);
		$('.delete_check3').prop('checked', false);
		$('.button-hapus3').prop('disabled', true);
		$('.menu-show7').hide();
		$('.menu-show8').show();
		$('.menu-show9').hide();
		reload_table5();
	});
});

$(document).ready(function(){
	$("#halaman-list-file-library3").click(function(){
		$('.button-insert3').prop('disabled', true);
		$('.insert_check3').prop('checked', false);
		$('.delete_check3').prop('checked', false);
		$('.button-hapus3').prop('disabled', true);
		$('.menu-show7').hide();
		$('.menu-show8').hide();
		$('.menu-show9').show();
		reload_table6();
	});
});

function checkcheckbox3(){
   // Total checkboxes
   var length = $('.delete_check3').length;
   // Total checked checkboxes
   var totalchecked = 0;
   $('.delete_check3').each(function(){
   	if($(this).is(':checked')){
   		totalchecked+=1;
   		$('.pencet').fadeIn("slow");
   	} 
   });

   // Checked unchecked checkbox
   if(totalchecked > 0){
   	$('.button-hapus3').prop('disabled', false);
   }else{
   	$('.button-hapus3').prop('disabled', true);
   }
}
</script>

<script type="text/javascript">
	var table5;
	var table6;

	$(document).ready(function() {

    //datatables
    table5 = $('#table5').DataTable({ 
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
        	"url": "<?php echo site_url('Master/Media_manager/ajaxSingleDataManager3')?>",
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
    table6 = $('#table6').DataTable({ 
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
        	"url": "<?php echo site_url('Master/Media_manager/ajaxSingleDataManager4')?>",
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


function reload_table5()
{
  table5.ajax.reload(null,false); //reload datatable ajax 
} 

function reload_table6()
{
   table6.ajax.reload(null,false); //reload datatable ajax 
} 

function gambar_kosong()
{
	swal({
		position: 'top',
		type: 'warning',
		confirmButtonText: "Ok",
		confirmButtonColor: '#dc1227',
		customClass: ".sweet-alert button",
		closeOnConfirm: true,
		title: 'Tidak ada gambar yang dipilih',
		showConfirmButton: true,
	})
}

  // Delete record
  $('#delete_record5').click(function(){

  	var deleteids_arr3 = [];
      // Read all checked checkboxes
      $("input:checkbox[class=delete_check3]:checked").each(function () {
      	deleteids_arr3.push($(this).val());
      });

      // Check checkbox checked or not
      if(deleteids_arr3.length > 0){
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
      			data: {deleteids_arr: deleteids_arr3},
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
      				reload_table5();
      			}
      		});
      	})
      } else {
      	$('.button-hapus3').prop('disabled', true);
      }
  });


  $('#delete_record6').click(function(){

  	var deleteids_arr3 = [];
      // Read all checked checkboxes
      $("input:checkbox[class=delete_check3]:checked").each(function () {
      	deleteids_arr3.push($(this).val());
      });

      // Check checkbox checked or not
      if(deleteids_arr3.length > 0){
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
      			data: {deleteids_arr: deleteids_arr3},
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
      				reload_table6();
      			}
      		});
      	})
      } else {
      	$('.button-hapus3').prop('disabled', true);
      }
  });


  function myFunction3(value) {
  	var copyText3 = document.getElementById("myInput3"+value);
  	copyText3.select();
  	copyText3.setSelectionRange(0, 99999); /*For mobile devices*/
  	document.execCommand("copy");
  	toastr.success(copyText2.value,'Link berhasil di copy', {timeOut: 5000},toastr.options = {
  		"closeButton": true});
  }

  // $(function () {
  // 	$(".select-menu-media").select2({
  // 		placeholder: " -- Tipe File -- "
  // 	});
  // });

</script>