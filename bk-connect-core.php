<?php
/**
 * Plugin Name: BK Connect Suite & PPB Engine
 * Plugin URI: https://bk-fip.unm.ac.id/
 * Description: Paket Lengkap Sistem Digital Prodi BK / Jurusan PPB FIP UNM: Desain Scholaro, Tipografi, Fixed Header, Filter Dosen & Mutu, Manajemen Akademik, Jadwal Ujian, Berita, Kemahasiswaan, dan Layanan Mahasiswa.
 * Version: 1.2.1
 * Author: Jurusan PPB / BK FIP UNM
 * License: GPL-2.0+
 * Text Domain: bk-connect
 */

if (!defined('ABSPATH')) exit;

/**
 * --------------------------------------------------------------------------
 * WP-STAGING DEV ENVIRONMENT HANDLER (/yamato)
 * --------------------------------------------------------------------------
 */
if (!function_exists('ppb_is_yamato_staging')) {
    function ppb_is_yamato_staging() {
        static $is_staging = null;
        if ($is_staging !== null) return $is_staging;

        $host   = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $req    = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $script = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';

        if (
            strpos($req, '/yamato') !== false ||
            strpos($script, '/yamato') !== false ||
            strpos(__DIR__, 'yamato') !== false ||
            (defined('WPSTG_DEV') && WPSTG_DEV) ||
            defined('WPSTAGING_VERSION') ||
            (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'staging') ||
            (strpos($host, 'bk-fip.unm.ac.id') !== false && (strpos($req, '/yamato') === 0 || strpos($script, '/yamato') === 0 || strpos(__FILE__, 'yamato') !== false))
        ) {
            $is_staging = true;
        } else {
            $is_staging = (strpos(get_option('home', ''), '/yamato') !== false || strpos(get_option('siteurl', ''), '/yamato') !== false);
        }
        return $is_staging;
    }
}

if (!function_exists('ppb_filter_yamato_url')) {
    function ppb_filter_yamato_url($url) {
        if (empty($url) || !ppb_is_yamato_staging()) {
            return $url;
        }

        if (strpos($url, '#') === 0 || strpos($url, 'mailto:') === 0 || strpos($url, 'tel:') === 0 || strpos($url, 'javascript:') === 0) {
            return $url;
        }

        if (strpos($url, '//') === 0 && strpos($url, '//bk-fip.unm.ac.id') === false) {
            return $url;
        }

        $parsed = parse_url($url);
        $host = isset($parsed['host']) ? $parsed['host'] : '';

        if (empty($host) && strpos($url, '/') === 0) {
            if (strpos($url, '/yamato/') === 0 || $url === '/yamato') {
                return $url;
            }
            return '/yamato' . $url;
        }

        $current_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'bk-fip.unm.ac.id';
        if ($host === 'bk-fip.unm.ac.id' || $host === $current_host || empty($host)) {
            $path = isset($parsed['path']) ? $parsed['path'] : '/';
            if (strpos($path, '/yamato/') === 0 || $path === '/yamato') {
                return $url;
            }
            $new_path = '/yamato' . ('/' . ltrim($path, '/'));
            $scheme = isset($parsed['scheme']) ? $parsed['scheme'] . '://' : '//';
            $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
            $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
            $fragment = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';
            return $scheme . $host . $port . $new_path . $query . $fragment;
        }

        return $url;
    }
}

add_filter('home_url', function($url, $path = '', $orig_scheme = null, $blog_id = null) {
    return ppb_filter_yamato_url($url);
}, 99, 4);

add_filter('site_url', function($url, $path = '', $scheme = null, $blog_id = null) {
    return ppb_filter_yamato_url($url);
}, 99, 4);

require_once __DIR__ . '/bk-fonts.php';
require_once __DIR__ . '/ppb-portal-hub.php';
require_once __DIR__ . '/ppb-admin-akademik.php';
require_once __DIR__ . '/ppb-admin-berita.php';
require_once __DIR__ . '/ppb-admin-spotlight.php';
require_once __DIR__ . '/ppb-admin-data.php';
require_once __DIR__ . '/ppb-admin-kemahasiswaan.php';
require_once __DIR__ . '/ppb-admin-layanan.php';
