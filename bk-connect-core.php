<?php
/**
 * Plugin Name: BK Connect Suite & PPB Engine
 * Plugin URI: https://bk-fip.unm.ac.id/
 * Description: Paket Lengkap Sistem Digital Prodi BK / Jurusan PPB FIP UNM: Desain Scholaro, Tipografi, Fixed Header, Filter Dosen & Mutu, Manajemen Akademik, Jadwal Ujian, Berita, Kemahasiswaan, dan Layanan Mahasiswa.
 * Version: 1.2.2
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
            strpos($host, 'bk-fip.unm.ac.id') !== false ||
            strpos($req, '/yamato') !== false ||
            strpos($script, '/yamato') !== false ||
            strpos(__DIR__, 'yamato') !== false ||
            (defined('WPSTG_DEV') && WPSTG_DEV) ||
            defined('WPSTAGING_VERSION') ||
            (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'staging')
        ) {
            $is_staging = true;
        } else {
            $is_staging = false;
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
            return '/yamato' . ($url === '/' ? '/' : $url);
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

// 1. Force home and siteurl options to include /yamato on staging
add_filter('pre_option_home', function($val) {
    if (ppb_is_yamato_staging()) {
        return 'https://bk-fip.unm.ac.id/yamato';
    }
    return $val;
}, 99);

add_filter('pre_option_siteurl', function($val) {
    if (ppb_is_yamato_staging()) {
        return 'https://bk-fip.unm.ac.id/yamato';
    }
    return $val;
}, 99);

// 2. Filter core WordPress URL builders
add_filter('home_url', function($url, $path = '', $orig_scheme = null, $blog_id = null) {
    return ppb_filter_yamato_url($url);
}, 99, 4);

add_filter('site_url', function($url, $path = '', $scheme = null, $blog_id = null) {
    return ppb_filter_yamato_url($url);
}, 99, 4);

// 3. Prevent wp_redirect from sending visitors to live site without /yamato
add_filter('wp_redirect', function($location, $status = 302) {
    if (ppb_is_yamato_staging()) {
        return ppb_filter_yamato_url($location);
    }
    return $location;
}, 99, 2);

// 4. Filter navigation menu URLs
add_filter('wp_get_nav_menu_items', function($items) {
    if (empty($items) || !is_array($items) || !ppb_is_yamato_staging()) {
        return $items;
    }
    foreach ($items as &$item) {
        if (!empty($item->url)) {
            $item->url = ppb_filter_yamato_url($item->url);
        }
    }
    unset($item);
    return $items;
}, 99);

add_filter('nav_menu_link_attributes', function($atts, $item = null, $args = null, $depth = 0) {
    if (ppb_is_yamato_staging() && !empty($atts['href'])) {
        $atts['href'] = ppb_filter_yamato_url($atts['href']);
    }
    return $atts;
}, 99, 4);

add_filter('page_link', function($url, $post_id = 0, $sample = false) {
    return ppb_filter_yamato_url($url);
}, 99, 3);

add_filter('post_link', function($url, $post = null, $leavename = false) {
    return ppb_filter_yamato_url($url);
}, 99, 3);

add_filter('post_type_link', function($url, $post = null, $leavename = false, $sample = false) {
    return ppb_filter_yamato_url($url);
}, 99, 4);

// 5. Rewrite HTML content links
add_filter('the_content', function($content) {
    if (empty($content) || !ppb_is_yamato_staging()) {
        return $content;
    }

    $content = preg_replace_callback('/href=(["\'])(\/[^"\']*)(\1)/i', function($matches) {
        $quote = $matches[1];
        $href  = $matches[2];
        if (strpos($href, '//') === 0 || strpos($href, '/yamato/') === 0 || $href === '/yamato') {
            return 'href=' . $quote . $href . $quote;
        }
        return 'href=' . $quote . '/yamato' . ($href === '/' ? '/' : $href) . $quote;
    }, $content);

    $content = preg_replace_callback('/href=(["\'])(https?:\/\/bk-fip\.unm\.ac\.id)(\/[^"\']*)?(\1)/i', function($matches) {
        $quote  = $matches[1];
        $domain = $matches[2];
        $path   = isset($matches[3]) ? $matches[3] : '/';
        if (strpos($path, '/yamato/') === 0 || $path === '/yamato') {
            return 'href=' . $quote . $domain . $path . $quote;
        }
        return 'href=' . $quote . $domain . '/yamato' . ($path === '/' ? '/' : $path) . $quote;
    }, $content);

    return $content;
}, 99);

// 6. Staging init safeguards: unconditionally block canonical redirects and ensure permalinks & .htaccess
add_action('template_redirect', function() {
    if (ppb_is_yamato_staging() || strpos($_SERVER['REQUEST_URI'], '/yamato') !== false) {
        remove_action('template_redirect', 'redirect_canonical');
    }
}, 1);

add_filter('redirect_canonical', function($redirect_url, $requested_url) {
    if (
        ppb_is_yamato_staging() ||
        strpos($_SERVER['REQUEST_URI'], '/yamato') !== false ||
        (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'bk-fip.unm.ac.id') !== false)
    ) {
        return false;
    }
    return $redirect_url;
}, 1, 2);

add_action('init', function() {
    if (!ppb_is_yamato_staging() && strpos($_SERVER['REQUEST_URI'], '/yamato') === false) return;

    // Auto-create staging .htaccess in multiple potential paths
    $potential_paths = array();
    if (defined('ABSPATH')) {
        $potential_paths[] = rtrim(ABSPATH, '/') . '/.htaccess';
        $potential_paths[] = rtrim(ABSPATH, '/') . '/yamato/.htaccess';
    }
    if (isset($_SERVER['DOCUMENT_ROOT'])) {
        $potential_paths[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/yamato/.htaccess';
    }

    $rules = "# BEGIN WordPress Staging /yamato\n" .
             "<IfModule mod_rewrite.c>\n" .
             "RewriteEngine On\n" .
             "RewriteBase /yamato/\n" .
             "RewriteRule ^index\\.php$ - [L]\n" .
             "RewriteCond %{REQUEST_FILENAME} !-f\n" .
             "RewriteCond %{REQUEST_FILENAME} !-d\n" .
             "RewriteRule . /yamato/index.php [L]\n" .
             "</IfModule>\n" .
             "# END WordPress Staging /yamato\n";

    foreach ($potential_paths as $p) {
        $dir = dirname($p);
        if (is_dir($dir) && is_writable($dir)) {
            if (!file_exists($p) || strpos(@file_get_contents($p), 'RewriteBase /yamato/') === false) {
                @file_put_contents($p, $rules);
            }
        }
    }

    // Auto-activate post-name permalinks if currently plain
    if (get_option('permalink_structure') === '') {
        global $wp_rewrite;
        if ($wp_rewrite) {
            $wp_rewrite->set_permalink_structure('/%postname%/');
            $wp_rewrite->flush_rules(false);
        }
    }
}, 1);

// 7. Auto-patch and intercept links in WP-Admin as well
add_action('admin_footer', function() {
    if (!ppb_is_yamato_staging()) return;
    ?>
    <script>
    (function() {
        function fixYamatoUrl(url) {
            if (!url) return url;
            if (url.indexOf('#') === 0 || url.indexOf('mailto:') === 0 || url.indexOf('javascript:') === 0) return url;
            if (url.indexOf('://bk-fip.unm.ac.id') !== -1) {
                try {
                    var u = new URL(url);
                    if (u.pathname.indexOf('/yamato/') !== 0 && u.pathname !== '/yamato') {
                        u.pathname = '/yamato' + (u.pathname === '/' ? '/' : u.pathname);
                        return u.toString();
                    }
                } catch(e) {}
            }
            return url;
        }
        function patchAdminLinks() {
            var links = document.querySelectorAll('a[href]');
            for (var i = 0; i < links.length; i++) {
                var raw = links[i].getAttribute('href');
                var fixed = fixYamatoUrl(raw);
                if (fixed !== raw) links[i].setAttribute('href', fixed);
            }
        }
        patchAdminLinks();
        document.addEventListener('click', function(e) {
            var a = e.target.closest('a');
            if (!a) return;
            var href = a.getAttribute('href');
            var fixed = fixYamatoUrl(href);
            if (fixed !== href) {
                e.preventDefault();
                e.stopPropagation();
                window.location.href = fixed;
            }
        }, true);
    })();
    </script>
    <?php
});

require_once __DIR__ . '/bk-fonts.php';
require_once __DIR__ . '/ppb-portal-hub.php';
require_once __DIR__ . '/ppb-admin-akademik.php';
require_once __DIR__ . '/ppb-admin-berita.php';
require_once __DIR__ . '/ppb-admin-spotlight.php';
require_once __DIR__ . '/ppb-admin-data.php';
require_once __DIR__ . '/ppb-admin-kemahasiswaan.php';
require_once __DIR__ . '/ppb-admin-layanan.php';
