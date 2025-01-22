<link rel="stylesheet" href="<?php echo base_url(); ?>template/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>template/css/pages/app-invoice-print.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/eksternal/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/icon-picker/fontawesome5/css/all.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/icon-picker/fontawesome-iconpicker.css">

<style>
    #slider {
        margin-left: 0px;
    }

    #btn_loading {
        display: none;
    }
</style>

<section class="invoice-preview-wrapper">
    <div class="invoice-print p-3">
        <div class="d-flex justify-content-between flex-md-row flex-column pb-2">
            <div>
                <div>
                    <h3 class="text-primary invoice-logo"><b>Invoice Pembayaran</b></h3>
                    <h5 class="text-primary invoice-logo"><b>Skymars Shop</b></h5>
                    <p class="card-text mb-25"><i class="fas fa-map-marker-alt"></i> Perum Kahuripan Nirwana BLOK. BA 6 NO. 17 Kab Sidoarjo </p>
                    <p class="card-text mb-0"><i class="fas fa-mobile-alt"></i> / <i class="fab fa-whatsapp"></i> 0822-5726-6733</p>
                </div>
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

        <div class="row">
            <div class="card-body invoice-padding pb-0">
                <div class="row invoice-sales-total-wrapper">
                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                        <p class="card-text mb-0">
                            <span class="font-weight-bold">Kasir :</span> <span class="ml-75"><?php echo $dataslider->admin; ?></span>
                        </p>
                    </div>
                    <div class="col-md-5 d-flex justify-content-end order-md-1 ">
                        <div class="invoice-total-wrapper">
                            <div class="invoice-total-item">
                                <p class="invoice-total-title">Total : </p>
                                <p class="invoice-total-amount" style="margin-right: 50px ;">Rp.<?php echo number_format($dataslider->total, 0, ",", "."); ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <hr class="my-2" />

        <div class="row">
            <div class="col-12">
                <li>Terima kasih telah belanja di toko kami</li>
                <li><b>Gratis pembelian jika anda tidak di berikan invoice / struk pembelian</b> </li>
            </div>
        </div>
    </div>
</section>

<script>
    window.print();
</script>