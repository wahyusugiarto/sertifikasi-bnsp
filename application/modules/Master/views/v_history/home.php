<?php $this->load->view('_heading/_headerContent') ?>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><i class="fa fa-history"></i> Log History Transaksi</h4>
        </div>
        <div class="card-content">
         <div class="card-body card-dashboard">
          <div class="table-responsive">
            <?php if ($accessAdd > 0) { ?>
              <a class="klik ajaxify" href="<?php echo site_url('add-pelanggan'); ?>"><button class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Add Pelanggan</button></a>
            <?php } ?>
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
             <thead>
               <tr>
                 <th>#</th>
                 <th>Kode Transaksi</th>
                 <th>Nama User</th>
                 <th>Aktivitas</th>
                 <th>Keterangan</th>
                 <th width="100px;">Tanggal</th>
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
        "processing": true, //Feature control the processing indicator.
        "order": [], //Initial no order.
        "destroy": true,
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
          "url": "<?php echo site_url('Master/Log_history/ajax_list')?>",
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


</script>

