<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "Default/Auth";
$route['404_override'] = 'Default/Not_found';
$route['login'] = 'Default/Auth';
$route['logout'] = 'Auth/logout';
$route['log-sign'] = 'Default/Auth';

$route['media-manager'] = 'Master/Media_manager/index';

/*   route modul profile */
$route['profile'] = 'Setting/Profile/index';

/*   route modul dashboard  */
$route['dashboard'] = 'Dashboard/index';

/*   route modul menu  */
$route['menu']             = 'Setting/Menu_evo/index';
$route['icon']             = 'Setting/Menu_evo/icon';
$route['edit-menu/(:any)'] = 'Setting/Menu_evo/edit/$1';

/*   route modul user  */
$route['user']             = 'Setting/User/index';
$route['add-user']         = 'Setting/User/add';
$route['edit-user/(:any)'] = 'Setting/User/edit/$1';

/*   route modul grup  */
$route['user-grup']        = 'Setting/Grup/index';
$route['add-grup']         = 'Setting/Grup/add';
$route['edit-grup/(:any)'] = 'Setting/Grup/edit/$1';

/*    route modul Akses  */
$route['hak-akses/(:any)'] = 'Setting/Akses/hak_akses/$1';

/*   route modul section about us  */
$route['kategori']             = 'Section/Kategori/index';
$route['add-kategori']         = 'Section/Kategori/add';
$route['edit-kategori/(:any)'] = 'Section/Kategori/edit/$1';

/*   route modul section about us  */
$route['supplier']             = 'Section/Supplier/index';
$route['add-supplier']         = 'Section/Supplier/add';
$route['edit-supplier/(:any)'] = 'Section/Supplier/edit/$1';

$route['kasir']  = 'Master/Kasir/index';
$route['data-penjualan']  = 'Master/Penjualan/index';
$route['preview-invoice/(:any)'] = 'Master/Penjualan/Preview/$1';
$route['preview-invoice_kasir/(:any)'] = 'Master/Kasir/Preview/$1';
$route['print-invoice/(:any)'] = 'Master/Penjualan/Print/$1';

/*   route modul section about us  */
$route['sub-kategori']             = 'Section/Sub_kategori/index';
$route['add-sub-kategori']         = 'Section/Sub_kategori/add';
$route['edit-sub-kategori/(:any)'] = 'Section/Sub_kategori/edit/$1';

/*   route modul section about us  */
$route['inventory']             = 'Master/Inventory/index';
$route['add-inventory']         = 'Master/Inventory/add';
$route['edit-inventory/(:any)'] = 'Master/Inventory/edit/$1';

/*   route modul section about us  */
$route['log-history']             = 'Master/Log_history/index';

/*   route modul slider  */
$route['pelanggan'] = 'Master/Pelanggan/index';
$route['add-pelanggan'] = 'Master/Pelanggan/add';
$route['edit-pelanggan/(:any)'] = 'Master/Pelanggan/edit/$1';


/*   route modul pembelian  */
$route['pembelian'] = 'Master/Pembelian/index';

/*   route modul report penjualan  */
$route['report-penjualan'] = 'Support/Report_penjualan/index';
$route['ajax-report-penjualan'] = 'Support/Report_penjualan/ajaxReport';
$route['export-penjualan'] = 'Support/Report_penjualan/exportExcel';

/*   route modul report pembelian  */
$route['report-pembelian'] = 'Support/Report_pembelian/index';
$route['ajax-report-pembelian'] = 'Support/Report_pembelian/ajaxReport';
$route['export-pembelian'] = 'Support/Report_pembelian/exportExcel';

/*   route modul report stok  */
$route['report-stok']      = 'Support/Report_stok/index';
$route['ajax-report-stok'] = 'Support/Report_stok/ajaxReport';
$route['export-stok']      = 'Support/Report_stok/exportExcel';

/*   route modul slider  */
$route['automatic-crud'] = 'Crud/index';

/*   route modul user  */
$route['user'] = 'Setting/User/index';
$route['ajax-user'] = 'Setting/User/ajax_list';
$route['add-user'] = 'Setting/User/add';
$route['save-user'] = 'Setting/User/prosesAdd';
$route['edit-user/(:any)'] = 'Setting/User/Edit/$1';
$route['update-user/(:any)'] = 'Setting/User/prosesUpdate/$1';
$route['delete-user'] = 'Setting/User/prosesDelete';

/*   route modul menu  */
$route['menu'] = 'Setting/Menu_evo/index';
$route['ajax-menu'] = 'Setting/Menu_evo/menu_ajax';
$route['save-menu'] = 'Setting/Menu_evo/prosesTambah';
$route['save-sort-menu'] = 'Setting/Menu_evo/saveSort';
$route['icon'] = 'Setting/Menu_evo/icon';
$route['edit-menu/(:any)'] = 'Setting/Menu_evo/edit/$1';
$route['update-menu/(:any)'] = 'Setting/Menu_evo/prosesUpdate/$1';
$route['delete-menu'] = 'Setting/Menu_evo/prosesDelete';

/*   route modul grup  */
$route['user-grup'] = 'Setting/Grup/index';
$route['add-grup'] = 'Setting/Grup/add';
$route['save-grup'] = 'Setting/Grup/prosesTambah';
$route['edit-grup/(:any)'] = 'Setting/Grup/edit/$1';
$route['update-grup/(:any)'] = 'Setting/Grup/prosesUpdate/$1';
$route['delete-grup'] = 'Setting/Grup/prosesDelete';

/*    route modul Akses  */
$route['hak-akses/(:any)'] = 'Setting/Akses/hak_akses/$1';
$route['update-hak-akses/(:any)'] = 'Setting/Akses/update_hak_akses/$1';

/*   route modul manual stok  */
$route['manual-stok']         = 'Master/Manual_stok/index';
$route['add-manual-stok']     = 'Master/Manual_stok/add';
