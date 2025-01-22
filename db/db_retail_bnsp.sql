-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 22 Jan 2025 pada 03.42
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_retail_bnsp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `id_toko` int(10) NOT NULL,
  `username` varchar(300) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `grup_id` int(10) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `qrcode_img` varchar(500) NOT NULL,
  `qrcode` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `hidden` varchar(10) NOT NULL,
  `last_created_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `last_update_by` varchar(200) NOT NULL,
  `last_login_user` datetime NOT NULL,
  `cookie` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `id_toko`, `username`, `password`, `email`, `nama`, `grup_id`, `foto`, `qrcode_img`, `qrcode`, `status`, `hidden`, `last_created_date`, `last_update_date`, `created_by`, `last_update_by`, `last_login_user`, `cookie`) VALUES
(1, 1, 'superadmin', 'f5edc17393c11156fba47f2664e75cad', 'admin@gmail.com', 'Admin Anjangsono', 2, 'http://localhost/bengkel/upload/media-upload/channels4_profile.png', '', 'superadmin', 3, '1', '0000-00-00 00:00:00', '2022-11-21 18:39:57', '', 'wahyu', '2022-11-21 19:18:21', ''),
(3, 0, 'wahyu', '32c9e71e866ecdbc93e497482aa6779f', 'wahyupunk10@gmail.com', 'Wahyu Sugiarto', 1, 'http://localhost/bengkel/upload/media-upload/channels4_profile.png', '', 'superadmin2', 3, '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Wahyu Sugiarto', '2025-01-22 09:28:19', 'EIURuRnvrCAnVKbqHYOJyeHOi8McwUGXh3zg75GZ1Ldr3j5kPwaEV2zilbCDTspy'),
(20, 1, 'wahyu', '21232f297a57a5a743894a0e4a801fc3', 'wahyupunk35@yahoo.com', 'Toko Skymars', 5, 'http://localhost/bengkel/upload/media-upload/channels4_profile.png', 'upload/qrcode/d2FoeXUyMDIy.png', 'd2FoeXUyMDIy', 3, '1', '2022-02-04 10:35:28', '2025-01-18 21:17:05', 'Administrator', 'wahyu', '2022-07-27 21:28:31', 'MkN6JbbZhpFlAMhpV4LxOvQg192trIqxiPHzB80yAGHj27orkCBoV3OmaT0lcmYF');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grup`
--

CREATE TABLE `grup` (
  `grup_id` int(10) NOT NULL,
  `nama_grup` varchar(300) NOT NULL,
  `deskripsi` varchar(300) NOT NULL,
  `last_created_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `last_update_by` varchar(200) NOT NULL,
  `can_delete` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `grup`
--

INSERT INTO `grup` (`grup_id`, `nama_grup`, `deskripsi`, `last_created_date`, `last_update_date`, `created_by`, `last_update_by`, `can_delete`) VALUES
(1, 'Super Admin', 'Full  Akses', '0000-00-00 00:00:00', '2025-01-20 14:47:27', '', 'wahyu', 0),
(2, 'Admin', 'Akses Terbatas', '0000-00-00 00:00:00', '2022-11-20 13:00:14', '', 'wahyu', 0),
(5, 'Admin Toko', 'Akses Terbatas', '2020-10-28 15:02:32', '2022-10-24 21:46:40', 'Wahyu Sugiarto', 'wahyu', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_akses`
--

CREATE TABLE `menu_akses` (
  `id_menuakses` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `grup_id` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  `add` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `del` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menu_akses`
--

INSERT INTO `menu_akses` (`id_menuakses`, `id_menu`, `grup_id`, `view`, `add`, `edit`, `del`) VALUES
(5097, 71, 5, 1, 0, 0, 0),
(5098, 1, 5, 1, 0, 0, 0),
(5099, 63, 5, 0, 0, 0, 0),
(5100, 2, 5, 0, 0, 0, 0),
(5101, 64, 5, 0, 0, 0, 0),
(5102, 67, 5, 0, 0, 0, 0),
(5103, 77, 5, 0, 0, 0, 0),
(5104, 78, 5, 0, 0, 0, 0),
(5105, 87, 5, 0, 0, 0, 0),
(5106, 59, 5, 1, 1, 1, 1),
(5107, 73, 5, 1, 1, 1, 1),
(5108, 68, 5, 1, 1, 1, 1),
(5109, 72, 5, 1, 1, 1, 1),
(5110, 74, 5, 1, 1, 1, 1),
(5111, 69, 5, 1, 1, 1, 1),
(5112, 75, 5, 1, 1, 1, 1),
(5113, 70, 5, 0, 0, 0, 0),
(5114, 76, 5, 0, 0, 0, 0),
(5115, 65, 5, 0, 0, 0, 0),
(5116, 4, 5, 0, 0, 0, 0),
(5117, 17, 5, 0, 0, 0, 0),
(5118, 79, 5, 0, 0, 0, 0),
(5119, 89, 5, 0, 0, 0, 0),
(5551, 103, 2, 1, 0, 1, 1),
(5552, 2, 2, 0, 0, 0, 0),
(5553, 100, 2, 1, 0, 0, 0),
(5554, 104, 2, 1, 0, 0, 0),
(5555, 64, 2, 1, 0, 0, 0),
(5556, 98, 2, 1, 1, 1, 1),
(5557, 102, 2, 1, 0, 1, 1),
(5558, 96, 2, 1, 0, 0, 0),
(5559, 1, 2, 1, 0, 0, 0),
(5560, 71, 2, 1, 0, 0, 0),
(5561, 93, 2, 1, 1, 1, 1),
(5562, 99, 2, 1, 1, 1, 1),
(5563, 97, 2, 1, 1, 1, 1),
(5564, 94, 2, 1, 1, 1, 1),
(5565, 101, 2, 1, 1, 1, 1),
(5566, 65, 2, 0, 0, 0, 0),
(5567, 68, 2, 1, 1, 1, 1),
(5568, 95, 2, 1, 1, 1, 1),
(5569, 92, 2, 0, 0, 0, 0),
(5570, 105, 2, 1, 0, 0, 0),
(5571, 106, 2, 1, 0, 0, 0),
(5572, 79, 2, 0, 0, 0, 0),
(5573, 4, 2, 0, 0, 0, 0),
(5574, 17, 2, 0, 0, 0, 0),
(5686, 2, 1, 1, 0, 0, 0),
(5687, 109, 1, 1, 1, 1, 1),
(5688, 71, 1, 1, 0, 0, 0),
(5689, 1, 1, 1, 0, 0, 0),
(5690, 64, 1, 1, 0, 0, 0),
(5691, 104, 1, 1, 0, 0, 0),
(5692, 100, 1, 1, 0, 0, 0),
(5693, 99, 1, 1, 1, 1, 1),
(5694, 93, 1, 1, 1, 1, 1),
(5695, 65, 1, 1, 1, 1, 1),
(5696, 94, 1, 1, 1, 1, 1),
(5697, 95, 1, 1, 1, 1, 1),
(5698, 103, 1, 1, 0, 1, 1),
(5699, 96, 1, 1, 0, 0, 0),
(5700, 110, 1, 1, 0, 0, 0),
(5701, 105, 1, 1, 0, 0, 0),
(5702, 106, 1, 1, 0, 0, 0),
(5703, 79, 1, 1, 1, 1, 1),
(5704, 4, 1, 1, 1, 1, 1),
(5705, 17, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_grup`
--

CREATE TABLE `status_grup` (
  `id_status` int(11) NOT NULL,
  `nama` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_grup`
--

INSERT INTO `status_grup` (`id_status`, `nama`) VALUES
(1, 'Unread'),
(2, 'Read'),
(3, 'Aktif'),
(4, 'Belum Aktif'),
(5, 'Hidden'),
(6, 'Publish'),
(9, 'Batal'),
(11, 'Non aktif'),
(18, 'Booking'),
(19, 'Proses'),
(20, 'Selesai'),
(21, 'Proses Invoice');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sys_counter`
--

CREATE TABLE `sys_counter` (
  `sys_counter_id` bigint(100) NOT NULL,
  `key` varchar(300) NOT NULL,
  `counter` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sys_counter`
--

INSERT INTO `sys_counter` (`sys_counter_id`, `key`, `counter`, `created`, `updated`, `status`) VALUES
(1, 'PCHS-30102022{nn}', 4, '2022-10-30 11:53:49', '2022-10-30 12:06:13', 0),
(2, 'SPK-01112022{nn}', 13, '2022-11-01 16:08:27', '2022-11-01 18:43:22', 0),
(3, 'SLE-04112022{nn}', 17, '2022-11-04 12:23:26', '2022-11-04 15:25:15', 0),
(4, 'PCHS-06112022{nn}', 3, '2022-11-06 12:24:42', '2022-11-06 12:26:29', 0),
(5, 'BK-07112022{nn}', 1, '2022-11-07 21:34:57', '0000-00-00 00:00:00', 0),
(6, 'SPK-17112022{nn}', 1, '2022-11-17 19:00:24', '0000-00-00 00:00:00', 0),
(22, 'SLE-19012025{nn}', 10, '2025-01-19 00:25:14', '2025-01-19 16:59:09', 0),
(24, 'PCHS-19012025{nn}', 2, '2025-01-19 01:17:41', '2025-01-19 11:16:49', 0),
(26, 'SLE-20012025{nn}', 1, '2025-01-20 10:53:51', '0000-00-00 00:00:00', 0),
(27, 'PCHS-21012025{nn}', 1, '2025-01-21 15:26:13', '0000-00-00 00:00:00', 0),
(28, 'SLE-21012025{nn}', 3, '2025-01-21 20:02:39', '2025-01-21 20:55:15', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_pembelian`
--

CREATE TABLE `tbl_detail_pembelian` (
  `no` int(255) NOT NULL,
  `nonota` varchar(300) NOT NULL,
  `id_brg` varchar(300) NOT NULL,
  `nama_brg` varchar(300) NOT NULL,
  `jml_brg` varchar(100) NOT NULL,
  `harga_brg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_detail_pembelian`
--

INSERT INTO `tbl_detail_pembelian` (`no`, `nonota`, `id_brg`, `nama_brg`, `jml_brg`, `harga_brg`) VALUES
(1, 'PCHS-1901202502', '1', 'Pepsodent Action Herbal', '5', '5000'),
(2, 'PCHS-2101202501', '1', 'Pepsodent Action Herbal', '2', '2500'),
(3, 'PCHS-2101202501', '5', 'Gula Piramid Kristal Putih', '2', '8000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_penjualan`
--

CREATE TABLE `tbl_detail_penjualan` (
  `no` int(255) NOT NULL,
  `kode_penjualan` varchar(200) NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(100) NOT NULL,
  `price_buy` int(100) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `subtotal2` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_detail_penjualan`
--

INSERT INTO `tbl_detail_penjualan` (`no`, `kode_penjualan`, `id`, `name`, `qty`, `price`, `price_buy`, `subtotal`, `subtotal2`) VALUES
(1, 'SLE-2101202502', 4, 'Smart Filma Minyak', 1, 13500, 10000, 13500, 10000),
(2, 'SLE-2101202502', 2, 'Shinzui White Herbal', 1, 4000, 2000, 4000, 2000),
(3, 'SLE-2101202502', 3, 'Head & Shoulders', 1, 11500, 8500, 11500, 8500),
(4, 'SLE-2101202503', 5, 'Gula Piramid Kristal Putih', 1, 12000, 8000, 12000, 8000),
(5, 'SLE-2101202503', 6, 'Teh Kotak Leci', 1, 4500, 3000, 4500, 3000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_gambar`
--

CREATE TABLE `tbl_gambar` (
  `id_gambar` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `judul_gambar` varchar(300) NOT NULL,
  `ekstensi` varchar(300) NOT NULL,
  `nama_gambar` varchar(300) NOT NULL,
  `gambar` varchar(300) NOT NULL,
  `token` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_gambar`
--

INSERT INTO `tbl_gambar` (`id_gambar`, `id_toko`, `judul_gambar`, `ekstensi`, `nama_gambar`, `gambar`, `token`, `created_date`, `created_by`) VALUES
(472, 1, 'channels4_profile.png', 'png', 'channels4_profile.png', 'upload/media-upload/channels4_profile.png', '', '2022-11-15', 'Admin Anjangsono'),
(476, 0, '33eb365f0f2a10dc32aff11ea2f48152.jpeg', 'jpeg', '33eb365f0f2a10dc32aff11ea2f48152.jpeg', 'upload/media-upload/33eb365f0f2a10dc32aff11ea2f48152.jpeg', '', '2025-01-19', 'Wahyu Sugiarto'),
(477, 0, '2350a.jpg', 'jpg', '2350a.jpg', 'upload/media-upload/2350a.jpg', '', '2025-01-19', 'Wahyu Sugiarto'),
(478, 0, 'mentho-dingin.jpg', 'jpg', 'mentho-dingin.jpg', 'upload/media-upload/mentho-dingin.jpg', '', '2025-01-19', 'Wahyu Sugiarto'),
(479, 0, 'DSC_0935.jpeg', 'jpeg', 'DSC_0935.jpeg', 'upload/media-upload/DSC_0935.jpeg', '', '2025-01-19', 'Wahyu Sugiarto'),
(480, 0, 'PepsodentHerbalTubePastaGigi1_fcbb07e8-76f6-48bd-a8f9-7f0f1ff346ea_900x900.png', 'png', 'PepsodentHerbalTubePastaGigi1_fcbb07e8-76f6-48bd-a8f9-7f0f1ff346ea_900x900.png', 'upload/media-upload/PepsodentHerbalTubePastaGigi1_fcbb07e8-76f6-48bd-a8f9-7f0f1ff346ea_900x900.png', '', '2025-01-19', 'Wahyu Sugiarto'),
(481, 0, 'TehKotakRasaLychee300ML3_80437c7f-5bf6-47c6-a0d0-e2cecd202e4f_900x900.jpg', 'jpg', 'TehKotakRasaLychee300ML3_80437c7f-5bf6-47c6-a0d0-e2cecd202e4f_900x900.jpg', 'upload/media-upload/TehKotakRasaLychee300ML3_80437c7f-5bf6-47c6-a0d0-e2cecd202e4f_900x900.jpg', '', '2025-01-20', 'Wahyu Sugiarto');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(100) NOT NULL,
  `kategori` varchar(300) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `kategori`) VALUES
(1, 'Pasta Gigi'),
(2, 'Sabun'),
(3, 'Gula'),
(4, 'Minyak'),
(5, 'Sampo'),
(6, 'Minuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kontak`
--

CREATE TABLE `tbl_kontak` (
  `id` int(10) NOT NULL,
  `no_telp` varchar(300) NOT NULL,
  `deskripsi` text NOT NULL,
  `alamat` text NOT NULL,
  `longitude` varchar(500) NOT NULL,
  `latitude` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_kontak`
--

INSERT INTO `tbl_kontak` (`id`, `no_telp`, `deskripsi`, `alamat`, `longitude`, `latitude`) VALUES
(1, '085157475887', 'tes deskripsi', 'Jl. KH. Ahmad Dahlan, Lebo, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61223', '112.5719495', '-7.4400171');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_log_transaksi`
--

CREATE TABLE `tbl_log_transaksi` (
  `id` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `nama_user` varchar(200) NOT NULL,
  `kode_transaksi` varchar(300) NOT NULL,
  `aktivitas` varchar(300) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_log_transaksi`
--

INSERT INTO `tbl_log_transaksi` (`id`, `id_toko`, `nama_user`, `kode_transaksi`, `aktivitas`, `keterangan`, `tanggal`) VALUES
(1, 0, 'Wahyu Sugiarto', 'SLE-2001202501', 'Penjualan', 'penjualan barang kepada customer Wahyu Sugiarto</b> Dengan Nama Barang <b>Teh Kotak Leci sejumlah <b>2</b> Pcs', '2025-01-01 12:51:18'),
(2, 0, 'Wahyu Sugiarto', 'SLE-2001202501', 'Penjualan', 'penjualan barang kepada customer Wahyu Sugiarto</b> Dengan Nama Barang <b>Pepsodent Action Herbal sejumlah <b>2</b> Pcs', '2025-01-22 12:51:43'),
(3, 0, 'Wahyu Sugiarto', 'PCHS-2101202501', 'Pembelian', '<b>Wahyu Sugiarto</b> Telah Melakukan Pembelian Barang di Supplier <b>PT Domino Air </b>Dengan Nama Barang <b>Pepsodent Action Herbal</b> sejumlah <b>2</b> Pcs', '2025-01-21 15:26:13'),
(4, 0, 'Wahyu Sugiarto', 'PCHS-2101202501', 'Pembelian', '<b>Wahyu Sugiarto</b> Telah Melakukan Pembelian Barang di Supplier <b>PT Domino Air </b>Dengan Nama Barang <b>Gula Piramid Kristal Putih</b> sejumlah <b>2</b> Pcs', '2025-01-21 15:26:13'),
(5, 0, 'Wahyu Sugiarto', 'SLE-2101202501', 'Penjualan', 'penjualan barang kepada customer Aghnia Kamilah Nuha</b> Dengan Nama Barang <b>Pepsodent Action Herbal sejumlah <b>2</b> Pcs', '2025-01-21 20:02:39'),
(6, 0, 'Wahyu Sugiarto', 'SLE-2101202501', 'Penjualan', 'penjualan barang kepada customer Aghnia Kamilah Nuha</b> Dengan Nama Barang <b>Shinzui White Herbal sejumlah <b>2</b> Pcs', '2025-01-21 20:02:39'),
(7, 0, 'Wahyu Sugiarto', 'SLE-2101202502', 'Penjualan', 'penjualan barang kepada customer Tsatayana Ulfah</b> Dengan Nama Barang <b>Smart Filma Minyak sejumlah <b>1</b> Pcs', '2025-01-21 20:40:45'),
(8, 0, 'Wahyu Sugiarto', 'SLE-2101202502', 'Penjualan', 'penjualan barang kepada customer Tsatayana Ulfah</b> Dengan Nama Barang <b>Shinzui White Herbal sejumlah <b>1</b> Pcs', '2025-01-21 20:40:45'),
(9, 0, 'Wahyu Sugiarto', 'SLE-2101202502', 'Penjualan', 'penjualan barang kepada customer Tsatayana Ulfah</b> Dengan Nama Barang <b>Head  sejumlah <b>1</b> Pcs', '2025-01-21 20:40:45'),
(10, 0, 'Wahyu Sugiarto', 'SLE-2101202503', 'Penjualan', 'penjualan barang kepada customer Aghnia Kamilah Nuha</b> Dengan Nama Barang <b>Gula Piramid Kristal Putih sejumlah <b>1</b> Pcs', '2025-01-21 20:55:15'),
(11, 0, 'Wahyu Sugiarto', 'SLE-2101202503', 'Penjualan', 'penjualan barang kepada customer Aghnia Kamilah Nuha</b> Dengan Nama Barang <b>Teh Kotak Leci sejumlah <b>1</b> Pcs', '2025-01-21 20:55:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(300) NOT NULL,
  `link` varchar(300) NOT NULL,
  `icon` varchar(300) NOT NULL,
  `parent` int(11) NOT NULL,
  `kode_menu` varchar(100) NOT NULL,
  `menu_file` varchar(100) NOT NULL,
  `urutan` int(11) NOT NULL,
  `last_created_date` datetime NOT NULL,
  `last_update_date` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `last_update_by` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `nama_menu`, `link`, `icon`, `parent`, `kode_menu`, `menu_file`, `urutan`, `last_created_date`, `last_update_date`, `created_by`, `last_update_by`) VALUES
(1, 'Dashboard', 'Dashboard', 'fas fa-tachometer-alt', 0, 'admin', 'view', 1, '2018-04-20 09:17:58', '2022-10-24 15:48:42', '', 'Wahyu Sugiarto'),
(2, 'Setting', '', 'fas fa-wrench', 0, 'setting', 'view', 17, '2018-04-20 09:19:49', '2020-11-30 15:17:48', '', 'Wahyu Sugiarto'),
(4, 'Grup', 'user-grup', 'fas fa-users', 2, 'user-grup', 'view,add,edit,del', 20, '2018-04-20 09:23:34', '2022-09-21 23:13:23', '', 'Wahyu Sugiarto'),
(17, 'Master Admin', 'user', 'fas fa-user', 2, 'user', 'view,add,edit,del', 18, '2018-04-20 10:29:57', '2020-11-30 15:08:03', '', 'Wahyu Sugiarto'),
(64, 'Kategori', '-', 'fas fa-list', 0, 'section-page', 'view', 2, '2019-11-07 14:03:48', '2022-10-27 10:03:27', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(65, 'Kategori Barang', 'kategori', 'far fa-circle', 64, 'kode-kategori', 'view,add,edit,del', 3, '2019-11-07 14:07:26', '2022-10-27 13:28:55', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(71, 'Master Data', '', 'fas fa-database', 0, 'kode-master-data', 'view', 8, '2020-10-28 14:28:24', '2020-11-30 15:15:44', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(79, 'Master Menu', 'menu', 'fas fa-list', 2, 'menu-master', 'view,add,edit,del', 19, '2020-11-22 17:51:27', '2020-11-30 15:06:52', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(93, 'Sub Kategori Barang', 'sub-kategori', 'far fa-circle', 64, 'kode-sub-kategori', 'view,add,edit,del', 4, '2022-10-27 12:24:44', '2022-10-27 13:30:05', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(94, 'Inventory', 'inventory', 'far fa-circle', 64, 'kode-inventory', 'view,add,edit,del', 5, '2022-10-27 15:12:36', '2022-10-27 15:12:36', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(95, 'Pelanggan', 'pelanggan', 'fas fa-user', 71, 'kode-pelanggan', 'view,add,edit,del', 9, '2022-10-28 10:53:45', '2025-01-19 09:11:42', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(96, 'Pembelian', 'pembelian', 'fas fa-shopping-cart', 71, 'kode-pembelian', 'view', 10, '2022-10-28 13:30:10', '2022-11-01 21:07:11', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(99, 'Supplier', 'supplier', 'far fa-circle', 64, 'kode-supplier', 'view,add,edit,del', 6, '2022-10-30 07:51:03', '2022-10-30 07:51:03', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(100, 'History Transaksi', 'log-history', 'fas fa-history', 0, 'kode-log-history', 'view', 16, '2022-10-30 13:03:05', '2022-10-30 13:03:05', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(103, 'Data Penjualan', 'data-penjualan', 'fas fa-shopping-cart', 71, 'kode-penjualan', 'view,edit,del', 11, '2022-11-04 15:20:15', '2022-11-04 15:20:15', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(104, 'Report', '#', 'fas fa-file-excel', 0, 'kode-report-data', 'view', 12, '2022-11-06 10:20:00', '2022-11-06 10:20:00', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(105, 'Report Penjualan', 'report-penjualan', 'far fa-circle', 104, 'report-penjualan', 'view', 13, '2022-11-06 10:21:46', '2022-11-06 10:21:46', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(106, 'Report Pembelian', 'report-pembelian', 'far fa-circle', 104, 'report-pembelian', 'view', 14, '2022-11-06 12:46:54', '2022-11-06 12:46:54', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(109, 'Kasir', 'kasir', 'fas fa-calculator', 0, 'kode-kasir', 'view,add,edit,del', 7, '2025-01-19 09:00:42', '2025-01-19 09:00:42', 'Wahyu Sugiarto', 'Wahyu Sugiarto'),
(110, 'Report Stok', 'report-stok', 'far fa-circle', 104, 'report-stok', 'view', 15, '2025-01-20 11:27:21', '2025-01-20 11:27:21', 'Wahyu Sugiarto', 'Wahyu Sugiarto');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pelanggan`
--

CREATE TABLE `tbl_pelanggan` (
  `id_pelanggan` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `nama` varchar(300) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `created_by` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`id_pelanggan`, `id_toko`, `nama`, `telp`, `alamat`, `created_date`, `updated_date`, `created_by`) VALUES
(1, 1, 'Wahyu Sugiarto', '089675773470', 'Jl.Pakis Gunung 1/68 Surabaya', '2022-10-28', '2025-01-19', ''),
(3, 0, 'Tsatayana Ulfah', '081329970337', 'Perum Alana - Tambak Oso', '2025-01-20', '0000-00-00', ''),
(4, 0, 'Aghnia Kamilah Nuha', '08170787758', 'Perum Alana - Tambak Oso', '2025-01-20', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembelian`
--

CREATE TABLE `tbl_pembelian` (
  `no` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `supplier` varchar(300) NOT NULL,
  `no_beli` varchar(300) NOT NULL,
  `total` int(100) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pembelian`
--

INSERT INTO `tbl_pembelian` (`no`, `id_toko`, `supplier`, `no_beli`, `total`, `tanggal`, `keterangan`) VALUES
(1, 0, 'PT ABC', 'PCHS-1901202502', 25000, '2025-01-19 04:16:49', ''),
(2, 0, 'PT Domino Air', 'PCHS-2101202501', 21000, '2025-01-21 08:26:13', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `no` int(255) NOT NULL,
  `kode_penjualan` varchar(200) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `id_user` int(255) NOT NULL,
  `nama` varchar(300) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `total` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `status_print` varchar(300) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`no`, `kode_penjualan`, `id_toko`, `id_user`, `nama`, `telp`, `admin`, `total`, `status`, `status_print`, `tanggal`) VALUES
(1, 'SLE-2101202502', 0, 3, 'Tsatayana Ulfah', '081329970337', 'Wahyu Sugiarto', 29000, 'Lunas', 'Sudah Print', '2025-01-21 13:40:45'),
(2, 'SLE-2101202503', 0, 4, 'Aghnia Kamilah Nuha', '08170787758', 'Wahyu Sugiarto', 16500, 'Lunas', 'Sudah Print', '2025-01-21 13:55:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(200) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `nama` varchar(500) NOT NULL,
  `kategori` varchar(300) NOT NULL,
  `sub_kategori` varchar(300) NOT NULL,
  `harga_beli` int(100) NOT NULL,
  `harga_jual` int(100) NOT NULL,
  `stok` int(200) NOT NULL,
  `gambar` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `kode_barang`, `id_toko`, `nama`, `kategori`, `sub_kategori`, `harga_beli`, `harga_jual`, `stok`, `gambar`) VALUES
(1, 'BR0001', 0, 'Pepsodent Action Herbal', 'Pasta Gigi', 'Pepsodent', 2500, 3400, 8, 'http://localhost/retail_bnsp/upload/media-upload/PepsodentHerbalTubePastaGigi1_fcbb07e8-76f6-48bd-a8f9-7f0f1ff346ea_900x900.png'),
(2, 'BR0002', 0, 'Shinzui White Herbal', 'Sabun', 'Shinsui', 2000, 4000, 2, 'http://localhost/retail_bnsp/upload/media-upload/DSC_0935.jpeg'),
(3, 'BR0003', 0, 'Head & Shoulders Mentol Dingin', 'Sampo', 'Head & Shoulders', 8500, 11500, 9, 'http://localhost/retail_bnsp/upload/media-upload/mentho-dingin.jpg'),
(4, 'BR0004', 0, 'Smart Filma Minyak', 'Minyak', 'Minyak Goreng Filma', 10000, 13500, 9, 'http://localhost/retail_bnsp/upload/media-upload/2350a.jpg'),
(5, 'BR0005', 0, 'Gula Piramid Kristal Putih', 'Gula', 'Gula Piramid', 8000, 12000, 9, 'http://localhost/retail_bnsp/upload/media-upload/33eb365f0f2a10dc32aff11ea2f48152.jpeg'),
(6, 'BR0006', 0, 'Teh Kotak Leci', 'Minuman', 'Ultra Jaya', 3000, 4500, 7, 'http://localhost/retail_bnsp/upload/media-upload/TehKotakRasaLychee300ML3_80437c7f-5bf6-47c6-a0d0-e2cecd202e4f_900x900.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_so`
--

CREATE TABLE `tbl_so` (
  `id` int(255) NOT NULL,
  `id_brg` int(100) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `nama_brg` varchar(500) NOT NULL,
  `tanggal` date NOT NULL,
  `beli` int(11) NOT NULL,
  `jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_so`
--

INSERT INTO `tbl_so` (`id`, `id_brg`, `id_toko`, `nama_brg`, `tanggal`, `beli`, `jual`) VALUES
(3, 5, 0, 'Ban Goodyear', '2022-10-30', 3, 0),
(4, 4, 0, 'Oli Shell', '2022-10-30', 5, 0),
(5, 5, 0, 'Ban Goodyear', '2022-10-30', 3, 0),
(6, 4, 0, 'Oli Shell', '2022-10-30', 5, 0),
(7, 5, 0, 'Ban Goodyear', '2022-10-30', 2, 0),
(8, 4, 0, 'Oli Shell', '2022-10-30', 2, 0),
(9, 6, 0, 'Aki GS Astra', '2022-10-30', 5, 0),
(12, 6, 0, 'Aki GS Astra', '2022-11-04', 0, 1),
(13, 4, 0, 'Oli Shell', '2022-11-04', 0, 1),
(14, 0, 0, 'Jasa Ganti Oli', '2022-11-04', 0, 1),
(15, 0, 0, 'Jasa Ganti Aki', '2022-11-04', 0, 1),
(16, 6, 0, 'Aki GS Astra', '2022-11-04', 0, 1),
(17, 4, 0, 'Oli Shell', '2022-11-04', 0, 1),
(18, 0, 0, 'Jasa Ganti Oli', '2022-11-04', 0, 1),
(19, 0, 0, 'Jasa Ganti Aki', '2022-11-04', 0, 1),
(20, 5, 0, 'Ban Goodyear', '2022-11-06', 2, 0),
(21, 6, 0, 'Aki GS Astra', '2022-11-06', 4, 0),
(22, 5, 0, 'Ban Goodyear', '2022-11-06', 2, 0),
(23, 6, 0, 'Aki GS Astra', '2022-11-06', 4, 0),
(24, 5, 0, 'Ban Goodyear', '2022-11-06', 2, 0),
(25, 6, 0, 'Aki GS Astra', '2022-11-06', 4, 0),
(26, 6, 0, 'Aki GS Astra', '2025-01-19', 0, 1),
(27, 6, 0, 'Aki GS Astra', '2025-01-19', 0, 1),
(28, 5, 0, 'Ban Goodyear', '2025-01-19', 0, 1),
(29, 4, 0, 'Oli Shell', '2025-01-19', 5, 0),
(36, 1, 0, 'Pepsodent Action Herbal', '2025-01-19', 5, 0),
(47, 5, 0, 'Gula Piramid Kristal', '2025-01-19', 0, 1),
(48, 4, 0, 'Minyak Goreng Filma', '2025-01-19', 0, 1),
(49, 3, 0, 'Head ', '2025-01-19', 0, 1),
(50, 2, 0, 'Shinzui White', '2025-01-19', 0, 1),
(51, 1, 0, 'Pepsodent Action Herbal', '2025-01-19', 0, 1),
(52, 4, 0, 'Minyak Goreng Filma', '2025-01-19', 0, 1),
(53, 6, 0, 'Teh Kotak Leci', '2025-01-20', 0, 2),
(54, 1, 0, 'Pepsodent Action Herbal', '2025-01-20', 0, 2),
(55, 1, 0, 'Pepsodent Action Herbal', '2025-01-21', 2, 0),
(56, 5, 0, 'Gula Piramid Kristal Putih', '2025-01-21', 2, 0),
(57, 1, 0, 'Pepsodent Action Herbal', '2025-01-21', 0, 2),
(58, 2, 0, 'Shinzui White Herbal', '2025-01-21', 0, 2),
(59, 4, 0, 'Smart Filma Minyak', '2025-01-21', 0, 1),
(60, 2, 0, 'Shinzui White Herbal', '2025-01-21', 0, 1),
(61, 3, 0, 'Head ', '2025-01-21', 0, 1),
(62, 5, 0, 'Gula Piramid Kristal Putih', '2025-01-21', 0, 1),
(63, 6, 0, 'Teh Kotak Leci', '2025-01-21', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sub_kategori`
--

CREATE TABLE `tbl_sub_kategori` (
  `id` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `kategori` varchar(200) NOT NULL,
  `sub_kategori` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_sub_kategori`
--

INSERT INTO `tbl_sub_kategori` (`id`, `id_toko`, `kategori`, `sub_kategori`) VALUES
(1, 0, '1', 'Pepsodent'),
(2, 0, '2', 'Shinsui'),
(3, 0, '3', 'Gula Piramid'),
(4, 0, '4', 'Wilmart'),
(5, 0, '5', 'Head & Shoulders'),
(6, 0, '6', 'Ultra Jaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(255) NOT NULL,
  `id_bengkel` int(100) NOT NULL,
  `supplier` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id`, `id_bengkel`, `supplier`) VALUES
(3, 0, 'PT ABC'),
(4, 0, 'PT Domino Air'),
(5, 0, 'Garuda Food'),
(6, 0, 'PT KIMIA FARMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_temp_beli`
--

CREATE TABLE `tbl_temp_beli` (
  `no` int(255) NOT NULL,
  `sess_id` varchar(300) NOT NULL,
  `id` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `gambar` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `qty` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `subtotal` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_temp_penjualan`
--

CREATE TABLE `tbl_temp_penjualan` (
  `no` int(255) NOT NULL,
  `sess_id` varchar(399) NOT NULL,
  `id` int(255) NOT NULL,
  `id_toko` int(100) NOT NULL,
  `name` varchar(300) NOT NULL,
  `gambar` varchar(300) NOT NULL,
  `qty` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `price_buy` int(100) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `subtotal2` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_toko`
--

CREATE TABLE `tbl_toko` (
  `id_toko` int(11) NOT NULL,
  `nama` varchar(300) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_toko`
--

INSERT INTO `tbl_toko` (`id_toko`, `nama`, `alamat`) VALUES
(1, 'Toko Skymars', 'PERUMAHAN KAHURIPAN NIRWANA BLOK. BA 6 NO. 17, Entalsewu, Kec. Buduran, Kabupaten Sidoarjo, Jawa Timur 61252'),
(2, 'Toko Smart Application System', 'RT.O2/RW.01, Sawo, Sawocangkring, Kec. Wonoayu, Kabupaten Sidoarjo, Jawa Timur 51281');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_stok`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_stok` (
`id_stok` int(255)
,`id_brg` int(100)
,`id_toko` int(100)
,`nama_brg` varchar(500)
,`tanggal` date
,`beli` int(11)
,`jual` int(11)
,`kode_barang` varchar(100)
,`kategori` varchar(300)
,`stok` int(200)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_stok`
--
DROP TABLE IF EXISTS `v_stok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok`  AS  select `tbl_so`.`id` AS `id_stok`,`tbl_so`.`id_brg` AS `id_brg`,`tbl_so`.`id_toko` AS `id_toko`,`tbl_so`.`nama_brg` AS `nama_brg`,`tbl_so`.`tanggal` AS `tanggal`,`tbl_so`.`beli` AS `beli`,`tbl_so`.`jual` AS `jual`,`tbl_product`.`kode_barang` AS `kode_barang`,`tbl_product`.`kategori` AS `kategori`,`tbl_product`.`stok` AS `stok` from (`tbl_so` left join `tbl_product` on(`tbl_product`.`id` = `tbl_so`.`id_brg`)) order by `tbl_so`.`id` desc ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`grup_id`);

--
-- Indeks untuk tabel `menu_akses`
--
ALTER TABLE `menu_akses`
  ADD PRIMARY KEY (`id_menuakses`);

--
-- Indeks untuk tabel `status_grup`
--
ALTER TABLE `status_grup`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `sys_counter`
--
ALTER TABLE `sys_counter`
  ADD PRIMARY KEY (`sys_counter_id`);

--
-- Indeks untuk tabel `tbl_detail_pembelian`
--
ALTER TABLE `tbl_detail_pembelian`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tbl_detail_penjualan`
--
ALTER TABLE `tbl_detail_penjualan`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tbl_gambar`
--
ALTER TABLE `tbl_gambar`
  ADD PRIMARY KEY (`id_gambar`);

--
-- Indeks untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tbl_kontak`
--
ALTER TABLE `tbl_kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_log_transaksi`
--
ALTER TABLE `tbl_log_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_so`
--
ALTER TABLE `tbl_so`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_sub_kategori`
--
ALTER TABLE `tbl_sub_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_temp_beli`
--
ALTER TABLE `tbl_temp_beli`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tbl_temp_penjualan`
--
ALTER TABLE `tbl_temp_penjualan`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `tbl_toko`
--
ALTER TABLE `tbl_toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `grup`
--
ALTER TABLE `grup`
  MODIFY `grup_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `menu_akses`
--
ALTER TABLE `menu_akses`
  MODIFY `id_menuakses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5706;

--
-- AUTO_INCREMENT untuk tabel `status_grup`
--
ALTER TABLE `status_grup`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `sys_counter`
--
ALTER TABLE `sys_counter`
  MODIFY `sys_counter_id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_pembelian`
--
ALTER TABLE `tbl_detail_pembelian`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_penjualan`
--
ALTER TABLE `tbl_detail_penjualan`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_gambar`
--
ALTER TABLE `tbl_gambar`
  MODIFY `id_gambar` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=482;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_kontak`
--
ALTER TABLE `tbl_kontak`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_log_transaksi`
--
ALTER TABLE `tbl_log_transaksi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT untuk tabel `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  MODIFY `id_pelanggan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_so`
--
ALTER TABLE `tbl_so`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `tbl_sub_kategori`
--
ALTER TABLE `tbl_sub_kategori`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_temp_beli`
--
ALTER TABLE `tbl_temp_beli`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `tbl_temp_penjualan`
--
ALTER TABLE `tbl_temp_penjualan`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tbl_toko`
--
ALTER TABLE `tbl_toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
