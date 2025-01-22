

//untuk notifikasi berhasil
		
		function save_berhasil()
		{
		swal({
		position: 'top',
		type: 'success',
		title: 'Data saved successfully',
		showConfirmButton: false,
		timer: 1500
		});
		} 
		
		//untuk notifikasi hapus berhasil
		
		function hapus_berhasil()
		{
		swal({
		position: 'top',
		type: 'success',
		title: 'Data has been deleted',
		showConfirmButton: false,
		timer: 1500
		});
		}
		
		//untuk notifikasi gagal
		
		function gagal()
		{
		swal({
		position: 'top',
		type: 'error',
		title: 'Data has been failed save',
		showConfirmButton: false,
		timer: 1000
		});
		} 
		
		//untuk notifikasi peringatan
		
		function peringatan()
		{
		swal({
		position: 'top',
		type: 'warning',
		title: 'Peringatan',
		text: 'No Telp / Username Sudah digunakan Employe lain',
		showConfirmButton: false,
		timer: 2100
		});
		} 

		//untuk notifikasi peringatan
		
		function format()
		{
		swal({
		position: 'top',
		title: 'Peringatan',
		text: 'File tidak sesuai dengan format !!!',
		showConfirmButton: false,
		timer: 1500
		});
		} 
		
		//untuk notifikasi update berhasil
		
		function update_berhasil()
		{
		swal({
		position: 'top',
		type: 'success',
		title: 'Data Berhasil Diupdate',
		showConfirmButton: false,
		timer: 1500
		});
		} 
		
		
		//untuk notifikasi upload berhasil
		
		function upload_berhasil()
		{
		swal({
		position: 'top',
		type: 'success',
		title: 'Data Berhasil Diupload',
		showConfirmButton: false,
		timer: 2500
		});
		} 
		
		
		//untuk live gambar ajax
		
	function fileValidation(){
    var fileInput = document.getElementById('gambar');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    var ukuran = document.getElementById('gambar');
    if(ukuran.files[0].size > 2007200)  // validasi ukuran size file
    {
    // swal("Peringatan", " Maksimal File 2 MB", "warning");
    toastr.error('Maximal File 2 MB','Warning', {timeOut: 5000},toastr.options = {
    "closeButton": true}); 
    ukuran.value = '';
    return false;
    }

    if(!allowedExtensions.exec(filePath)){
    // alert('sorry, enter the image with the format .jpeg/.jpg/.png/.gif only.');
    toastr.error('sorry, enter the image with the format .jpeg |.jpg |.png | only.','Warning', {timeOut: 5000},toastr.options = {
             "closeButton": true}); 
    fileInput.value = '';
    return false;
    }else{
        
    //Image preview
    if (fileInput.files && fileInput.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
    document.getElementById('slider').innerHTML = '<img class="img-thumbnail" src="'+e.target.result+'"/>';
    };
    reader.readAsDataURL(fileInput.files[0]);
		}
		}

    

	}

  function fileValidation2(){
    var fileInput = document.getElementById('video');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.wmv|\.mp4|\.avi|\.mov)$/i;

    // var ukuran = document.getElementById('video');
    // if(ukuran.files[0].size > 2007200)  // validasi ukuran size file
    // {
    // // swal("Peringatan", " Maksimal File 2 MB", "warning");
    // toastr.error('Maximal File 2 MB','Warning', {timeOut: 5000},toastr.options = {
    // "closeButton": true}); 
    // ukuran.value = '';
    // return false;
    // }

    if(!allowedExtensions.exec(filePath)){
    // alert('sorry, enter the image with the format .jpeg/.jpg/.png/.gif only.');
    toastr.error('File must be video format','Warning', {timeOut: 5000},toastr.options = {
             "closeButton": true}); 
    fileInput.value = '';
    return false;
    }else{
        
    //Image preview
    if (fileInput.files && fileInput.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
    document.getElementById('slider').innerHTML = '<img class="img-thumbnail" src="'+e.target.result+'"/>';
    };
    reader.readAsDataURL(fileInput.files[0]);
    }
    }

    

  }
	
	
	
	//untuk live gambar ajax profil
		
	function fileFoto(){
    var fileInput = document.getElementById('foto');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('maaf masukan gambar dengan format .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
			}
		}
	}
	
	
	
	//untuk live gambar ajax produk
		
	function fileProduk(){
    var fileInput = document.getElementById('gambar');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('maaf masukan gambar dengan format .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('produk').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
			}
		}
	}
	
	
	//untuk live gambar detail_produk
		
	function detailproduk(){
    var fileInput = document.getElementById('gambar');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('maaf masukan gambar dengan format .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('detail-produk').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
			}
		}
	}
	

function valid1()
{
     var fileInput =document.getElementById("nota_dinas").value;
     if(fileInput!='')
     {
           var checkfile = fileInput.toLowerCase();
          if (!checkfile.match(/(\.pdf)$/)){ // validasi ekstensi file
              swal("Peringatan", "File harus format .pdf", "warning");
               document.getElementById("nota_dinas").value = '';
              return false;
           }
            var ukuran = document.getElementById("nota_dinas"); 
            if(ukuran.files[0].size > 10007200)  // validasi ukuran size file
            {
             swal("Peringatan", " Maksimal 10 MB", "warning");
       		   ukuran.value = '';
             return false;
             }
             return true;
      }
}


function valid2()
{
     var fileInput =document.getElementById("draft").value;
     if(fileInput!='')
     {
           var checkfile = fileInput.toLowerCase();
          if (!checkfile.match(/(\.doc|\.docx|\.zip|\.rar|\.xls|\.xlsx)$/)){ // validasi ekstensi file
              swal("Peringatan", "File harus format .docx / .zip / .xls", "warning");
               document.getElementById("draft").value = '';
              return false;
           }
            var ukuran = document.getElementById("draft"); 
            if(ukuran.files[0].size > 10007200)  // validasi ukuran size file
            {
             swal("Peringatan", " Maksimal 10 MB", "warning");
       		 ukuran.value = '';
             return false;
             }
             return true;
      }
}


function valid3()
{
     var fileInput =document.getElementById("telaah").value;
     if(fileInput!='')
     {
           var checkfile = fileInput.toLowerCase();
          if (!checkfile.match(/(\.doc|\.docx)$/)){ // validasi ekstensi file
              swal("Peringatan", "File harus format .docx", "warning");
               document.getElementById("telaah").value = '';
              return false;
           }
            var ukuran = document.getElementById("telaah"); 
            if(ukuran.files[0].size > 10007200)  // validasi ukuran size file
            {
             swal("Peringatan", " Maksimal 10MB", "warning");
       		 ukuran.value = '';
             return false;
             }
             return true;
      }
}


function valid4()
{
     var fileInput =document.getElementById("sri").value;
     if(fileInput!='')
     {
           var checkfile = fileInput.toLowerCase();
          if (!checkfile.match(/(\.pdf)$/)){ // validasi ekstensi file
              swal("Peringatan", "File harus format .pdf", "warning");
               document.getElementById("sri").value = '';
              return false;
           }
            var ukuran = document.getElementById("sri"); 
            if(ukuran.files[0].size > 10007200)  // validasi ukuran size file
            {
             swal("Peringatan", " Maksimal 10 MB", "warning");
       		 ukuran.value = '';
             return false;
             }
             return true;
      }
}

function valid5()
{
     var fileInput =document.getElementById("file_proposal").value;
     if(fileInput!='')
     {
           var checkfile = fileInput.toLowerCase();
           if (!checkfile.match(/(\.pdf)$/)){ // validasi ekstensi file
              swal("Peringatan", "File harus format .pdf", "warning");
               document.getElementById("file_proposal").value = '';
              return false;
           }
            var ukuran = document.getElementById("file_proposal"); 
            if(ukuran.files[0].size > 10007200)  // validasi ukuran size file
            {
           swal("Peringatan", " Maksimal 10 MB", "warning");
           ukuran.value = '';
             return false;
             }
             return true;
      }
}


 

