<?php
/**
 * Plugin Name: BK Connect Suite & PPB Engine
 * Plugin URI: https://bk-fip.unm.ac.id/
 * Description: Paket Lengkap Sistem Digital Prodi BK / Jurusan PPB FIP UNM: Desain Scholaro, Tipografi, Fixed Header, Filter Dosen & Mutu, Manajemen Akademik, Jadwal Ujian, Berita, Kemahasiswaan, dan Layanan Mahasiswa.
 * Version: 1.2.0
 * Author: Jurusan PPB / BK FIP UNM
 * License: GPL-2.0+
 * Text Domain: bk-connect
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/bk-fonts.php';
require_once __DIR__ . '/ppb-portal-hub.php';
require_once __DIR__ . '/ppb-admin-akademik.php';
require_once __DIR__ . '/ppb-admin-berita.php';
require_once __DIR__ . '/ppb-admin-spotlight.php';
require_once __DIR__ . '/ppb-admin-data.php';
require_once __DIR__ . '/ppb-admin-kemahasiswaan.php';
require_once __DIR__ . '/ppb-admin-layanan.php';
