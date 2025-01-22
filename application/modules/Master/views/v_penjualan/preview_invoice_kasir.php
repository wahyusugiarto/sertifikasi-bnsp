<?php $this->load->view('_heading/_headerContent') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>template/css/pages/app-invoice.css">

<style>
    #slider {
        margin-left: 0px;
    }

    #btn_loading {
        display: none;
    }
</style>


<section class="invoice-preview-wrapper">
    <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-xl-9 col-md-8 col-12">
            <div class="card invoice-preview-card">
                <div class="card-body invoice-padding pb-0">
                    <!-- Header starts -->
                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                        <div>
                            <h3 class="text-primary invoice-logo"><b>Invoice Pembayaran</b></h3>
                            <h5 class="text-primary invoice-logo"><b>Skymars Shop</b></h5>
                            <p class="card-text mb-25"><i class="fas fa-map-marker-alt"></i> Perum Kahuripan Nirwana BLOK. BA 6 NO. 17 Kab Sidoarjo </p>
                            <p class="card-text mb-0"><i class="fas fa-mobile-alt"></i> / <i class="fab fa-whatsapp"></i> 0822-5726-6733</p>
                        </div>
                        <div class="mt-md-0 mt-2">
                            <h4 class="invoice-title">
                                Invoice
                                <span class="invoice-number"> #<?php echo $dataslider->kode_penjualan; ?></span>
                            </h4>
                            <div class="invoice-date-wrapper">
                                <p>Tanggal :</p>
                                <p style="margin-left:10px;"><?php echo date_indo(date('d-m-Y', strtotime($dataslider->tanggal))); ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- Header ends -->
                </div>

                <hr class="invoice-spacing" />

                <!-- Address and Contact starts -->


                <!-- Invoice Description starts -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="py-1">Barang / Jasa</th>
                                <th class="py-1">Qty</th>
                                <th class="py-1">Harga</th>
                                <th class="py-1">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $data) {
                                $Quantity = $data->qty;
                            ?>
                                <tr class="border-bottom">
                                    <td class="py-1">
                                        <p class="card-text font-weight-bold mb-25"><?php echo $data->name; ?></p>
                                    </td>
                                    <td class="py-1">
                                        <span class="font-weight-bold"><?php echo $Quantity ?></span>
                                    </td>
                                    <td class="py-1">
                                        <span class="font-weight-bold"><?php echo number_format($data->price, 0, ",", "."); ?></span>
                                    </td>
                                    <td class="py-1">
                                        <span class="font-weight-bold"><?php echo number_format($data->subtotal, 0, ",", "."); ?></span>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>

                <div class="card-body invoice-padding pb-0">
                    <div class="row invoice-sales-total-wrapper">
                        <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                            <p class="card-text mb-0">
                                <span class="font-weight-bold">Kasir :</span> <span class="ml-75"><?php echo $dataslider->admin; ?></span>
                            </p>
                        </div>
                        <div class="col-md-5 d-flex justify-content-end order-md-3 order-1">
                            <div class="invoice-total-wrapper">
                                <div class="invoice-total-item">
                                    <p class="invoice-total-title"><b>Total :</b> </p>
                                    <p class="invoice-total-amount" style="margin-left: ;">Rp.<?php echo number_format($dataslider->total, 0, ",", "."); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="invoice-spacing" />
            </div>
        </div>
        <!-- /Invoice -->

        <!-- Invoice Actions -->


        <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">

            <div class="card">

                <?php if ($dataslider->tipe_pembayaran == 'Transfer') { ?>
                    <div class="card-body">
                        <center>
                            <h3 class="text-primary invoice-logo"><b>Bukti TF</b></h3>
                        </center>

                        <?php if ($dataslider->bukti_tf != '') { ?>
                            <div class="product-img">
                                <center><a class="fancybox" href="<?php echo base_url(); ?><?php echo $dataslider->bukti_tf; ?>" data-fancybox-group="gallery" title="'Bukti Tf"><img class="img-thumbnail" src="<?php echo base_url(); ?><?php echo $dataslider->bukti_tf; ?>" width="150px;"></a></center>
                            <?php } else { ?>
                                <center><img id="not-found" style="border-color:white; margin-top:10px; width:200px; height:200px;" src="<?php echo base_url(); ?>assets/tambahan/gambar/empty.png" /></center>
                            <?php }  ?>
                            </div>
                    </div>
                <?php } else { ?>
                <?php } ?>


                <div class="card">
                    <div class="card-body">

                        <a href="<?php echo base_url('print-invoice') . '/' . $dataslider->kode_penjualan ?>" target="_blank">
                            <button class="btn btn-success btn-block mb-75"><i class="fa fa-print"></i> Print</button>
                        </a>

                        <a class="klik ajaxify" href="<?php echo site_url('kasir'); ?>"><button class="btn btn-primary btn-block mb-75">
                                <i class="fa  fa-angle-left"></i> Kembali
                            </button></a>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
</section>