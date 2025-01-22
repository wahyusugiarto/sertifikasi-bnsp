 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/media_manager/media_manager.css">
 <script src="<?php echo base_url(); ?>assets/media_manager/dropzone/dropzone.min.js"></script>

 <style type="text/css">
 	table.dataTable {
 		border: 2px solid white; 
 	}
 </style>



 <div class="modal fade text-left" id="media-modal2"  aria-hidden="true">
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
 					<li class="active nav-item"><a href="#upload2" class="nav-link active" id="halaman_upload2" data-toggle="tab"><i class="fa fa-upload"></i>&nbsp; Upload</a></li>
 					<li class="nav-item"><a href="#librayr2" class="nav-link" id="halaman-library2" data-toggle="tab"><i class="fa fa-th"></i>&nbsp; Image Library</a></li>
 					<li class="nav-item"><a href="#list-media-librayr2" class="nav-link"  id="halaman-list-library2" data-toggle="tab"><i class="fa fa-list"></i>&nbsp;Image Management Library</a></li>
 					<li class="nav-item"><a href="#list-file-librayr2" class="nav-link" id="halaman-list-file-library2" data-toggle="tab"><i class="fa fa-list"></i>&nbsp;File Management Library</a></li>
 				</ul>

 				<!-- tab panes -->
 				<div class="tab-content">

 					<div class="tab-pane active fade in" id="upload2">
 						<div class="dropzone" id="dropzone2" style="margin-top: 15px; height: 400px;">
 							<div class="dz-message" style="margin-top: 100px;">
 								<h3 style="margin-bottom: 15px;"> Drop files anywhere to upload</h3>
 								<h5 style="margin-bottom: 15px;"> or</h5>
 								<button class="upload-media"><i class="fa fa-cloud-upload-alt"></i>&nbsp; Select Files</button>
 								<h5 style="margin-bottom: 15px;">Maksimal file upload 5MB</h5>
 							</div>

 						</div>
 					</div>

 					<!-- library tab -->
 					<div class="tab-pane fade" id="librayr2">
 						<div class="search-container posisi" >
 							<div class="search-media wrap2" >
 								<input type="text" class="search-media" name="search_text2" id="search_text2" placeholder="Search.." name="search"><div class="ex2">&times;</div>
 								<button><i class="fa fa-search"></i></button>
 							</div>

 							<div class="dropdown-media" >
 								<select name="tipe2"  id="tipe2" class="form-control" >
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
 								<select name="sort2" id="sort2" class="form-control" >
 									<option value="">Sort By</option>
 									<option value="ASC">Terlama</option>
 									<option value="DESC">Terbaru</option>
 								</select>
 							</div>
 						</div>
 						<!-- <div class="row"> -->
 							<div class="">
 								<div id="results"></div>
 							</div>
 							<div class="clearfix"></div>
 						</div>


 						<div class="tab-pane fade" id="list-media-librayr2">
 							<div class="table-responsive" style="margin-top: 20px;">
 								<table id="table_md_1" class="table data-thumb-view" cellspacing="0" width="100%">
 									<thead style="background-color:white;">
 										<tr>
 											<th></th>
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


 						<div class="tab-pane fade" id="list-file-librayr2">

 							<div class="table-responsive" style="margin-top: 20px;">
 								<table id="table_md_2" class="table data-thumb-view" cellspacing="0" width="100%">
 									<thead>
 										<tr>
 											<th></th>
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
 				<div class="menu-show4">
 					<div class="modal-footer">
 						<button type="button" id='insert_record' class="btn btn-sm btn-info insert-single button-insert2"><i class="fa fa-share-square"></i>&nbsp; Insert</button>
 						<button type="button" class="btn btn-sm  btn-secondary" id="uncek2"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
 					</div>
 				</div>

 				<div class="menu-show5">
 					<div class="modal-footer">
 						<button type="button" id='delete_record3' class="btn btn-sm btn-danger button-hapus2"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
 						<button type="button" class="btn btn-sm  btn-secondary" id="uncek-list-data3"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
 					</div>
 				</div>

 				<div class="menu-show6">
 					<div class="modal-footer">
 						<button type="button" id='delete_record4' class="btn btn-sm btn-danger button-hapus2"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
 						<button type="button" class="btn btn-sm  btn-secondary" id="uncek-list-data4"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>

 	<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

 	<script type="text/javascript">

 	Dropzone.autoDiscover = false;
 	var foto_upload2= new Dropzone("#dropzone2",{
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
  foto_upload2.on("complete", function(file) {
  	foto_upload2.removeFile(file);
  });

  var dropDown3 = document.getElementById("tipe2");
  var dropDown4 = document.getElementById("sort2");

  $(document).ready(function(){
		// load_data3();
		$('.menu-show4').hide();
		$('.menu-show5').hide();
		$('.menu-show6').hide();
		var sort = $("#sort2").val();
		
		function load_data3(query2)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>Master/Media_manager/LoadSingleMediaManager",
				method:"POST",
				data:{query:query2},
				success:function(data){
					$('#results').html(data);
					$('.fancybox').fancybox();
					$(document).on("click",".popups2",function(){
						var data2=$(this).attr("data-id");
						var mpopup2 = document.getElementById('popBox2'+data2);
						mpopup2.style.display = "block";
						window.onclick = function(event) {
							if (event.target == mpopup2) {
								mpopup2.style.display = "none";
								$('.button-insert2').prop('disabled', true);
							}
						};
					})
				}
			})
		}

		function load_data4(query2)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>Master/Media_manager/LoadSingleMediaManager2",
				method:"POST",
				data:{query:query2},
				success:function(data){
					$('#results').html(data);
					$('.fancybox').fancybox();
					$(document).on("click",".popups2",function(){
						var data2=$(this).attr("data-id");
						var mpopup2 = document.getElementById('popBox2'+data2);
						mpopup2.style.display = "block";
						window.onclick = function(event) {
							if (event.target == mpopup2) {
								mpopup2.style.display = "none";
								$('.button-insert2').prop('disabled', true);
							}
						};
					})
				}

			})
		}

		$('#search_text2').keyup(function(){
			var search = $(this).val();
			if(search != '')
			{
				load_data3(search);
			}
			else
			{
				load_data3();
			}
		});

		$('.ex2').click(function () {
			$('.search-media').val("");
			load_data3();
		});


		$("#tipe2").change(function () {
			var value = $(this).val();
			console.log(value);
			if(value != '')
			{
				load_data3(value);
			}
			else
			{
				load_data3();
			}
		});

		$("#sort2").change(function () {
			var value = $(this).val();
			console.log(value);
			if(value != '')
			{
				load_data4(value);
			} else
			{
				load_data3();
			}
		});


		$('.button-insert2').prop('disabled', true);
		$('.button-hapus2').prop('disabled', true);

		var mediaModal2 = $('#media-modal2'),
      library2 = $('#librayr2'), //tab
      productImagesContainer2 = $('.product-images2'); //container

      library2.on('click','a',function(e){
      	e.preventDefault();

        // single
        var checkbox = $(this).find('input[type=checkbox]');
        var len = $("input[type=checkbox]:checked").length;

        if (len > 0) {
        	$('.button-insert2').prop('disabled', false);
        	$('.insert_check2').prop('checked', false);
        	checkbox.prop('checked', true);

        }  else {
        	$('.button-insert2').prop('disabled', false);
        	checkbox.prop('checked', true);

        }

    });

      $('#btn1').hide();
      //insert button and send images to the form and hidden fields tooo....
      $('.insert-single').click(function(e){
        //collect checkbox
        var checkboxes2 = library2.find('input[type=checkbox]')

        checkboxes2.each(function(i, el){
        	$('.button-insert2').prop('disabled', false);
        	if(el.checked){
        		var imageId = $(el).parent().data('image-id');
        		var imgSrc2 = $(el).siblings('img').attr('src');
        		var imgVal2 = $(el).siblings('img').attr('alt');
        		var imgTipe2 = $(el).siblings('img').attr('title');

        		var template2 =  '<div class="product-img2">'+
        		'<input type="hidden" name="gambar_single" value="'+ imgSrc2 +'">'+
        		'<input type="hidden" name="gambar_single_tp" value="'+ imgTipe2 +'">'+
        		'<img src="'+ imgSrc2 +'" />'+
        		'<a href="#" class="btn btn-sm btn-danger remove">'+
        		'<span class="fa fa-trash"></span></a>'+
        		'</div>';
        		productImagesContainer2.append(template2);
        		// console.log(imgVal2);

        	}
        });

        //hide modal
        mediaModal2.modal('hide');
        $('.insert_check2').prop('checked', false);
        $('.button-insert2').prop('disabled', true);
        dropDown3.selectedIndex = 0;
        dropDown4.selectedIndex = 0;
        $('#btn1').hide();
        load_data_md_1();
    });

      //remove product images js
      productImagesContainer2.on('click', '.remove', function(e){
      	e.preventDefault();
        //fadeout animation and remove....
        $(this).parent('.product-img2').fadeOut('100', function(){
        	$(this).remove();
        	$('#btn1').show();
        });

    });

      $('#uncek2').click(function(){
      	$('.insert_check2').prop('checked', false);
      	$('.button-insert2').prop('disabled', true); 
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });

      $('#halaman-library2').click(function(){
      	load_data3();
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });

      $('#uncek-list-data3').click(function(){
      	$('.delete_check2').prop('checked', false);
      	$('.button-hapus2').prop('disabled', true);
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });

      $('#uncek-list-data4').click(function(){
      	$('.delete_check2').prop('checked', false);
      	$('.button-hapus2').prop('disabled', true);
      	dropDown3.selectedIndex = 0;
      	dropDown4.selectedIndex = 0;
      });
  });

 $(document).ready(function(){
 	$("#halaman_upload2").click(function(){
 		$('.button-insert2').prop('disabled', true);
 		$('.insert_check2').prop('checked', false);
 		$('.delete_check2').prop('checked', false);
 		$('.button-hapus2').prop('disabled', true);
 		$('.menu-show4').hide();
 		$('.menu-show5').hide();
 		$('.menu-show6').hide();
 	});
 });

 $(document).ready(function(){
 	$("#halaman-library2").click(function(){
 		$('.delete_check2').prop('checked', false);
 		$('.button-hapus2').prop('disabled', true);
 		$('.menu-show4').show();
 		$('.menu-show5').hide();
 		$('.menu-show6').hide();
 	});
 });

 $(document).ready(function(){
 	$("#halaman-list-library2").click(function(){
 		$('.button-insert2').prop('disabled', true);
 		$('.insert_check2').prop('checked', false);
 		$('.delete_check2').prop('checked', false);
 		$('.button-hapus2').prop('disabled', true);
 		$('.menu-show4').hide();
 		$('.menu-show5').show();
 		$('.menu-show6').hide();
 		reload_table_md_1();
 	});
 });

 $(document).ready(function(){
 	$("#halaman-list-file-library2").click(function(){
 		$('.button-insert2').prop('disabled', true);
 		$('.insert_check2').prop('checked', false);
 		$('.delete_check2').prop('checked', false);
 		$('.button-hapus2').prop('disabled', true);
 		$('.menu-show4').hide();
 		$('.menu-show5').hide();
 		$('.menu-show6').show();
 		reload_table_md_2();
 	});
 });

 function checkcheckbox2(){
   // Total checkboxes
   var length = $('.delete_check2').length;
   // Total checked checkboxes
   var totalchecked = 0;
   $('.delete_check2').each(function(){
   	if($(this).is(':checked')){
   		totalchecked+=1;
   		$('.pencet').fadeIn("slow");
   	} 
   });

   // Checked unchecked checkbox
   if(totalchecked > 0){
   	$('.button-hapus2').prop('disabled', false);
   }else{
   	$('.button-hapus2').prop('disabled', true);
   }
}
</script>

<script type="text/javascript">
	var table_md_1;
	var table_md_2;

	$(document).ready(function() {

    //datatables
    table_md_1 = $('#table_md_1').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
		"destroy": true,
        "bSort": false,
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
        	"url": "<?php echo site_url('Master/Media_manager/ajaxSingleDataManager')?>",
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
    table_md_2 = $('#table_md_2').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
		"destroy": true,
        "bSort": false,
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
        	"url": "<?php echo site_url('Master/Media_manager/ajaxSingleDataManager2')?>",
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


function reload_table_md_1()
{
  table_md_1.ajax.reload(null,false); //reload datatable ajax 
} 

function reload_table_md_2()
{
   table_md_2.ajax.reload(null,false); //reload datatable ajax 
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
  $('#delete_record3').click(function(){

  	var deleteids_arr2 = [];
      // Read all checked checkboxes
      $("input:checkbox[class=delete_check2]:checked").each(function () {
      	deleteids_arr2.push($(this).val());
      });

      // Check checkbox checked or not
      if(deleteids_arr2.length > 0){
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
      			data: {deleteids_arr: deleteids_arr2},
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
      				reload_table_md_1();
      			}
      		});
      	})
      } else {
      	$('.button-hapus2').prop('disabled', true);
      }
  });


  $('#delete_record4').click(function(){

  	var deleteids_arr2 = [];
      // Read all checked checkboxes
      $("input:checkbox[class=delete_check2]:checked").each(function () {
      	deleteids_arr2.push($(this).val());
      });

      // Check checkbox checked or not
      if(deleteids_arr2.length > 0){
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
      			data: {deleteids_arr: deleteids_arr2},
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
      				reload_table_md_4();
      			}
      		});
      	})
      } else {
      	$('.button-hapus2').prop('disabled', true);
      }
  });


  function myFunction2(value) {
  	var copyText2 = document.getElementById("myInput2"+value);
  	copyText2.select();
  	copyText2.setSelectionRange(0, 99999); /*For mobile devices*/
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