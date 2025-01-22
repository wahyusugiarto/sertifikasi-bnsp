<?php $this->load->view('_heading/_headerContent') ?>

<style>
  #visitor {
    margin-top: 10px;
    max-width: 100%;
    height: 330px;
  }
</style>

<div class="content-body">

  <div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header d-flex align-items-start pb-0">
          <div>
            <h2 class="text-bold-700 mb-0 putar"><?php echo $pelanggan ?></h2>
            <p>Data Pelanggan</p>
          </div>
          <div class="avatar bg-rgba-primary p-50 m-0">
            <div class="avatar-content">
              <i class="feather icon-users text-primary font-medium-5"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header d-flex align-items-start pb-0">
          <div>
            <h2 class="text-bold-700 mb-0 putar"><?php echo $inventory ?></h2>
            <p>Data Inventory</p>
          </div>
          <div class="avatar bg-rgba-primary p-50 m-0">
            <div class="avatar-content">
              <i class="feather icon-briefcase text-primary font-medium-5"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header d-flex align-items-start pb-0">
          <div>
            <h2 class="text-bold-700 mb-0 putar"><?php echo $penjualan ?></h2>
            <p>Jumlah Order</p>
          </div>
          <div class="avatar bg-rgba-primary p-50 m-0">
            <div class="avatar-content">
              <i class="feather icon-navigation text-primary font-medium-5"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <div class="card-header d-flex align-items-start pb-0">
          <div>
            <h2 class="text-bold-700 mb-0 ">Rp. <span class="putar"><?php echo $transaksi->total; ?></span></h2>
            <p>Total Transaksi Per Hari</p>
          </div>
          <div class="avatar bg-rgba-primary p-50 m-0">
            <div class="avatar-content">
              <i class="feather icon-file-text text-primary font-medium-5"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- highchart -->
  <script src="<?php echo base_url(); ?>assets/plugins/highchart/highcharts.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/highchart/modules/exporting.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/highchart/modules/offline-exporting.js"></script>


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0"><i class="fa fa-chart-area" aria-hidden="true"></i>Transaksi Penjualan</h4>
        </div>
        <div class="card-content">
          <div class="container">
            <div id="visitor"></div>
            <?php
            if (!empty($graph)) {
              foreach ($graph as $data) {
                $tanggal[] = date('d-m-Y', strtotime($data->tanggal));
                $data1[] = (float) $data->total;
              }
            } else {
              echo "Belum Ada data yang masuk<br><br>";
            }
            ?>

            <script>
              jQuery(function() {
                new Highcharts.Chart({
                  chart: {
                    renderTo: 'visitor',
                    type: 'column',
                  },
                  credits: {
                    enabled: false
                  },
                  title: {
                    text: 'Data Penjualan',
                    x: -20
                  },
                  xAxis: {
                    categories: <?php echo json_encode($tanggal); ?>
                  },
                  yAxis: {
                    title: {
                      text: 'Jumlah Data Penjualan'
                    }
                  },
                  tooltip: {
                    formatter: function() {
                      return 'Total <b> Rp.' + Highcharts.numberFormat(this.y, 0) + '</b>';
                    }
                  },
                  series: [{
                    name: 'Data penjualan',
                    data: <?php echo json_encode($data1); ?>
                  }, ]
                });
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  <?= $this->session->flashdata('messageAlert'); ?>
</script>


<script>
  // Animasi angka bergerak dashboard

  $('.putar').each(function() {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).text()
    }, {
      duration: 1000,
      easing: 'swing',
      step: function(now) {
        $(this).text(Math.ceil(now));
      }
    });
  });
</script>