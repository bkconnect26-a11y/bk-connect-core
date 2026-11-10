<?php
/**
 * Module: PPB FIP UNM - Manajemen Data Dosen & Dokumen Mutu
 * Description: Modul WP Admin untuk pengelolaan Data Dosen dan Dokumen Mutu (Link Google Drive) tanpa menyentuh kode HTML atau Elementor.
 * Author: Jurusan PPB FIP UNM
 */

if (!defined('ABSPATH')) exit;

/* ========================================================================== */
/* 1. REGISTRASI CUSTOM POST TYPE: DOSEN (ppb_dosen)                          */
/* ========================================================================== */
if (!function_exists('ppb_register_cpt_dosen')) {
function ppb_register_cpt_dosen() {
    $labels = [
        'name'               => 'Data Dosen',
        'singular_name'      => 'Dosen',
        'menu_name'          => 'Data Dosen',
        'name_admin_bar'     => 'Dosen',
        'add_new'            => 'Tambah Dosen Baru',
        'add_new_item'       => 'Tambah Dosen Baru',
        'new_item'           => 'Dosen Baru',
        'edit_item'          => 'Edit Data Dosen',
        'view_item'          => 'Lihat Dosen',
        'all_items'          => 'Semua Dosen',
        'search_items'       => 'Cari Dosen',
        'not_found'          => 'Tidak ada data dosen.',
        'not_found_in_trash' => 'Tidak ada dosen di tempat sampah.'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => ['title', 'page-attributes'],
    ];

    register_post_type('ppb_dosen', $args);
}
}
add_action('init', 'ppb_register_cpt_dosen');

/* ========================================================================== */
/* 2. REGISTRASI CUSTOM POST TYPE: DOKUMEN MUTU (ppb_dokumen)                 */
/* ========================================================================== */
if (!function_exists('ppb_register_cpt_dokumen')) {
function ppb_register_cpt_dokumen() {
    $labels = [
        'name'               => 'Dokumen Mutu',
        'singular_name'      => 'Dokumen',
        'menu_name'          => 'Dokumen Mutu',
        'name_admin_bar'     => 'Dokumen Mutu',
        'add_new'            => 'Tambah Dokumen',
        'add_new_item'       => 'Tambah Dokumen Baru',
        'new_item'           => 'Dokumen Baru',
        'edit_item'          => 'Edit Dokumen',
        'view_item'          => 'Lihat Dokumen',
        'all_items'          => 'Semua Dokumen',
        'search_items'       => 'Cari Dokumen',
        'not_found'          => 'Tidak ada dokumen.',
        'not_found_in_trash' => 'Tidak ada dokumen di tempat sampah.'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => ['title', 'page-attributes'],
    ];

    register_post_type('ppb_dokumen', $args);
}
}
add_action('init', 'ppb_register_cpt_dokumen');

/* ========================================================================== */
/* 3. META BOX: DATA DOSEN                                                    */
/* ========================================================================== */
if (!function_exists('ppb_dosen_add_meta_box')) {
function ppb_dosen_add_meta_box() {
    add_meta_box(
        'ppb_dosen_meta_box',
        'Informasi Lengkap Dosen & Tenaga Pengajar',
        'ppb_dosen_render_meta_box',
        'ppb_dosen',
        'normal',
        'high'
    );
}
}
add_action('add_meta_boxes', 'ppb_dosen_add_meta_box');

if (!function_exists('ppb_dosen_render_meta_box')) {
function ppb_dosen_render_meta_box($post) {
    wp_nonce_field('ppb_dosen_save_meta', 'ppb_dosen_meta_nonce');

    $nip         = get_post_meta($post->ID, '_ppb_dosen_nip', true);
    $kategori    = get_post_meta($post->ID, '_ppb_dosen_kategori', true) ?: 'LEKTOR';
    $jabatan     = get_post_meta($post->ID, '_ppb_dosen_jabatan', true);
    $inisial     = get_post_meta($post->ID, '_ppb_dosen_inisial', true);
    $kepakaran   = get_post_meta($post->ID, '_ppb_dosen_kepakaran', true);
    $sinta_url   = get_post_meta($post->ID, '_ppb_dosen_sinta_url', true) ?: 'https://sinta.kemdiktisaintek.go.id/';
    ?>
    <style>
        .ppb-form-row { margin-bottom: 18px; }
        .ppb-form-row label { display: block; font-weight: 600; margin-bottom: 6px; color: #1e293b; font-size: 13px; }
        .ppb-form-row input[type="text"],
        .ppb-form-row input[type="url"],
        .ppb-form-row select,
        .ppb-form-row textarea { width: 100%; max-width: 700px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px; }
        .ppb-form-hint { display: block; font-size: 11.5px; color: #64748b; margin-top: 4px; }
        .ppb-badge-preview { display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; margin-top: 4px; }
    </style>

    <div class="ppb-form-row">
        <label for="ppb_dosen_nip">Nomor Induk Pegawai (NIP):</label>
        <input type="text" id="ppb_dosen_nip" name="ppb_dosen_nip" value="<?php echo esc_attr($nip); ?>" placeholder="Contoh: 19720817 200212 1 001">
        <span class="ppb-form-hint">Format NIP 18 digit dengan spasi yang rapi.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dosen_kategori">Kategori / Pangkat Akademik (Badge):</label>
        <select id="ppb_dosen_kategori" name="ppb_dosen_kategori">
            <option value="GURU BESAR" <?php selected($kategori, 'GURU BESAR'); ?>>GURU BESAR</option>
            <option value="KETUA JURUSAN" <?php selected($kategori, 'KETUA JURUSAN'); ?>>KETUA JURUSAN</option>
            <option value="SEKRETARIS JURUSAN" <?php selected($kategori, 'SEKRETARIS JURUSAN'); ?>>SEKRETARIS JURUSAN</option>
            <option value="LEKTOR KEPALA" <?php selected($kategori, 'LEKTOR KEPALA'); ?>>LEKTOR KEPALA</option>
            <option value="LEKTOR" <?php selected($kategori, 'LEKTOR'); ?>>LEKTOR</option>
            <option value="ASISTEN AHLI" <?php selected($kategori, 'ASISTEN AHLI'); ?>>ASISTEN AHLI</option>
            <option value="TENAGA KEPENDIDIKAN" <?php selected($kategori, 'TENAGA KEPENDIDIKAN'); ?>>TENAGA KEPENDIDIKAN</option>
        </select>
        <span class="ppb-form-hint">Badge warna penanda kategori dosen di atas kartu profil.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dosen_jabatan">Jabatan Struktural / Bidang Keahlian Pokok:</label>
        <input type="text" id="ppb_dosen_jabatan" name="ppb_dosen_jabatan" value="<?php echo esc_attr($jabatan); ?>" placeholder="Contoh: Dekan FIP UNM · Guru Besar BK atau Dosen Bidang Bimbingan Belajar">
        <span class="ppb-form-hint">Teks jabatan atau keterangan yang tampil di bawah nama dosen.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dosen_inisial">Inisial Avatar (2 Huruf):</label>
        <input type="text" id="ppb_dosen_inisial" name="ppb_dosen_inisial" value="<?php echo esc_attr($inisial); ?>" placeholder="Contoh: AS (Biarkan kosong untuk otomatis dari nama)">
        <span class="ppb-form-hint">Inisial huruf pada lingkaran emas avatar dosen.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dosen_kepakaran">Bidang Kepakaran (Pisahkan dengan tanda koma):</label>
        <textarea id="ppb_dosen_kepakaran" name="ppb_dosen_kepakaran" rows="2" placeholder="Contoh: Psikometri & Asesmen, Konseling Multikultural, Manajemen BK"><?php echo esc_textarea($kepakaran); ?></textarea>
        <span class="ppb-form-hint">Setiap kepakaran yang dipisahkan koma akan otomatis dibuatkan tombol chip di kartu.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dosen_sinta_url">Tautan Profil SINTA / Google Scholar / Dikti:</label>
        <input type="url" id="ppb_dosen_sinta_url" name="ppb_dosen_sinta_url" value="<?php echo esc_url($sinta_url); ?>" placeholder="https://sinta.kemdiktisaintek.go.id/authors/detail?id=...">
        <span class="ppb-form-hint">Link publikasi ilmiah dosen yang terbuka di tab baru saat tombol diklik.</span>
    </div>
    <?php
}
}

if (!function_exists('ppb_dosen_save_meta')) {
function ppb_dosen_save_meta($post_id) {
    if (!isset($_POST['ppb_dosen_meta_nonce']) || !wp_verify_nonce($_POST['ppb_dosen_meta_nonce'], 'ppb_dosen_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['ppb_dosen_nip'])) {
        update_post_meta($post_id, '_ppb_dosen_nip', sanitize_text_field($_POST['ppb_dosen_nip']));
    }
    if (isset($_POST['ppb_dosen_kategori'])) {
        update_post_meta($post_id, '_ppb_dosen_kategori', sanitize_text_field($_POST['ppb_dosen_kategori']));
    }
    if (isset($_POST['ppb_dosen_jabatan'])) {
        update_post_meta($post_id, '_ppb_dosen_jabatan', sanitize_text_field($_POST['ppb_dosen_jabatan']));
    }
    if (isset($_POST['ppb_dosen_inisial'])) {
        $ini = sanitize_text_field($_POST['ppb_dosen_inisial']);
        if (empty($ini)) {
            // Auto generate dari nama post_title
            $title = get_the_title($post_id);
            $words = explode(' ', trim($title));
            $ini = '';
            foreach ($words as $w) {
                $w = trim($w);
                if (!empty($w) && !in_array(strtolower($w), ['dr.', 'prof.', 'drs.', 'dra.', 'ir.', 'm.pd.', 's.pd.', 'm.si.', 'ph.d.', 'kons.'])) {
                    $ini .= strtoupper(substr($w, 0, 1));
                    if (strlen($ini) >= 2) break;
                }
            }
            if (empty($ini)) $ini = 'BK';
        }
        update_post_meta($post_id, '_ppb_dosen_inisial', strtoupper(substr($ini, 0, 3)));
    }
    if (isset($_POST['ppb_dosen_kepakaran'])) {
        update_post_meta($post_id, '_ppb_dosen_kepakaran', sanitize_textarea_field($_POST['ppb_dosen_kepakaran']));
    }
    if (isset($_POST['ppb_dosen_sinta_url'])) {
        update_post_meta($post_id, '_ppb_dosen_sinta_url', esc_url_raw($_POST['ppb_dosen_sinta_url']));
    }

    // Auto purge Elementor cache untuk Post 25
    delete_post_meta(25, '_elementor_element_cache');
    delete_post_meta(25, '_elementor_css');
}
}
add_action('save_post_ppb_dosen', 'ppb_dosen_save_meta');

/* ========================================================================== */
/* 4. META BOX: DOKUMEN MUTU (LINK GOOGLE DRIVE)                              */
/* ========================================================================== */
if (!function_exists('ppb_dokumen_add_meta_box')) {
function ppb_dokumen_add_meta_box() {
    add_meta_box(
        'ppb_dokumen_meta_box',
        'Informasi Dokumen & Link Berkas Google Drive',
        'ppb_dokumen_render_meta_box',
        'ppb_dokumen',
        'normal',
        'high'
    );
}
}
add_action('add_meta_boxes', 'ppb_dokumen_add_meta_box');

if (!function_exists('ppb_dokumen_render_meta_box')) {
function ppb_dokumen_render_meta_box($post) {
    wp_nonce_field('ppb_dokumen_save_meta', 'ppb_dokumen_meta_nonce');

    $drive_link   = get_post_meta($post->ID, '_ppb_dokumen_link', true);
    $kategori     = get_post_meta($post->ID, '_ppb_dokumen_kategori', true) ?: 'renstra';
    $nomor_sk     = get_post_meta($post->ID, '_ppb_dokumen_nomor', true);
    $tahun        = get_post_meta($post->ID, '_ppb_dokumen_tahun', true) ?: date('Y');
    $pengesah     = get_post_meta($post->ID, '_ppb_dokumen_pengesah', true);
    $size         = get_post_meta($post->ID, '_ppb_dokumen_size', true) ?: 'PDF';
    $deskripsi    = get_post_meta($post->ID, '_ppb_dokumen_deskripsi', true);
    ?>
    <style>
        .ppb-callout { background: #E8F0EA; border-left: 4px solid #0D3B22; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; color: #1e293b; }
        .ppb-callout strong { color: #0D3B22; }
    </style>

    <div class="ppb-callout">
        <strong>💡 Panduan Input Link Google Drive:</strong><br>
        Buka file di Google Drive &rarr; Klik kanan <strong>Bagikan (Share)</strong> &rarr; Setel ke <em>"Siapa saja yang memiliki link sebagai Pelihat (Viewer)"</em> &rarr; <strong>Salin Link</strong> dan tempelkan pada kolom di bawah.
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_link"><strong style="color:#0D3B22;">Tautan Berkas (Link Google Drive):</strong></label>
        <input type="url" id="ppb_dokumen_link" name="ppb_dokumen_link" value="<?php echo esc_url($drive_link); ?>" placeholder="https://drive.google.com/file/d/XXXXXX/view?usp=sharing" style="border: 2px solid #0D3B22; background: #fff;">
        <span class="ppb-form-hint">Tautan resmi Google Drive atau URL berkas dokumen PDF.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_kategori">Kategori Dokumen:</label>
        <select id="ppb_dokumen_kategori" name="ppb_dokumen_kategori">
            <option value="renstra" <?php selected($kategori, 'renstra'); ?>>Rencana Strategis (Renstra)</option>
            <option value="renop" <?php selected($kategori, 'renop'); ?>>Rencana Operasional (Renop)</option>
            <option value="sk_senat" <?php selected($kategori, 'sk_senat'); ?>>SK Senat Fakultas</option>
            <option value="pedoman_penilaian" <?php selected($kategori, 'pedoman_penilaian'); ?>>Pedoman Penilaian / Kurikulum OBE</option>
            <option value="sk_mahasiswa_aktif" <?php selected($kategori, 'sk_mahasiswa_aktif'); ?>>SK Mahasiswa Aktif Rektorat</option>
            <option value="perlindungan_mahasiswa" <?php selected($kategori, 'perlindungan_mahasiswa'); ?>>SOP Perlindungan Mahasiswa &amp; PPKS</option>
            <option value="akreditasi" <?php selected($kategori, 'akreditasi'); ?>>Sertifikat / Dokumen Akreditasi</option>
            <option value="lainnya" <?php selected($kategori, 'lainnya'); ?>>Dokumen &amp; Kebijakan Lainnya</option>
        </select>
        <span class="ppb-form-hint">Kategori untuk filter tab interaktif pada halaman Dokumen Mutu.</span>
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_nomor">Nomor Dokumen / SK Resmi:</label>
        <input type="text" id="ppb_dokumen_nomor" name="ppb_dokumen_nomor" value="<?php echo esc_attr($nomor_sk); ?>" placeholder="Contoh: RENSTRA-BK/UN36.2/2024 atau SK-SENAT/UN36.2/08/2024">
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_tahun">Tahun Dokumen / Penetapan:</label>
        <input type="text" id="ppb_dokumen_tahun" name="ppb_dokumen_tahun" value="<?php echo esc_attr($tahun); ?>" placeholder="Contoh: 2025" style="max-width: 150px;">
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_pengesah">Instansi / Pejabat yang Mengesahkan:</label>
        <input type="text" id="ppb_dokumen_pengesah" name="ppb_dokumen_pengesah" value="<?php echo esc_attr($pengesah); ?>" placeholder="Contoh: Dekan Fakultas Ilmu Pendidikan & Senat Fakultas">
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_size">Ukuran File / Format:</label>
        <input type="text" id="ppb_dokumen_size" name="ppb_dokumen_size" value="<?php echo esc_attr($size); ?>" placeholder="Contoh: 4.5 MB" style="max-width: 150px;">
    </div>

    <div class="ppb-form-row">
        <label for="ppb_dokumen_deskripsi">Deskripsi Singkat / Ringkasan Dokumen:</label>
        <textarea id="ppb_dokumen_deskripsi" name="ppb_dokumen_deskripsi" rows="3" placeholder="Ringkasan poin utama dokumen atau dasar hukum penetapan..."><?php echo esc_textarea($deskripsi); ?></textarea>
    </div>
    <?php
}
}

if (!function_exists('ppb_dokumen_save_meta')) {
function ppb_dokumen_save_meta($post_id) {
    if (!isset($_POST['ppb_dokumen_meta_nonce']) || !wp_verify_nonce($_POST['ppb_dokumen_meta_nonce'], 'ppb_dokumen_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['ppb_dokumen_link'])) {
        update_post_meta($post_id, '_ppb_dokumen_link', esc_url_raw($_POST['ppb_dokumen_link']));
    }
    if (isset($_POST['ppb_dokumen_kategori'])) {
        update_post_meta($post_id, '_ppb_dokumen_kategori', sanitize_text_field($_POST['ppb_dokumen_kategori']));
    }
    if (isset($_POST['ppb_dokumen_nomor'])) {
        update_post_meta($post_id, '_ppb_dokumen_nomor', sanitize_text_field($_POST['ppb_dokumen_nomor']));
    }
    if (isset($_POST['ppb_dokumen_tahun'])) {
        update_post_meta($post_id, '_ppb_dokumen_tahun', sanitize_text_field($_POST['ppb_dokumen_tahun']));
    }
    if (isset($_POST['ppb_dokumen_pengesah'])) {
        update_post_meta($post_id, '_ppb_dokumen_pengesah', sanitize_text_field($_POST['ppb_dokumen_pengesah']));
    }
    if (isset($_POST['ppb_dokumen_size'])) {
        update_post_meta($post_id, '_ppb_dokumen_size', sanitize_text_field($_POST['ppb_dokumen_size']));
    }
    if (isset($_POST['ppb_dokumen_deskripsi'])) {
        update_post_meta($post_id, '_ppb_dokumen_deskripsi', sanitize_textarea_field($_POST['ppb_dokumen_deskripsi']));
    }

    // Auto purge Elementor cache untuk Post 27
    delete_post_meta(27, '_elementor_element_cache');
    delete_post_meta(27, '_elementor_css');
}
}
add_action('save_post_ppb_dokumen', 'ppb_dokumen_save_meta');

/* ========================================================================== */
/* 5. KOLOM DAFTAR TABEL WP ADMIN                                             */
/* ========================================================================== */
// Kolom Dosen
add_filter('manage_ppb_dosen_posts_columns', function($columns) {
    $new = [];
    $new['cb']         = $columns['cb'];
    $new['inisial']    = 'Inisial';
    $new['title']      = 'Nama Dosen & Gelar';
    $new['nip']        = 'NIP';
    $new['kategori']   = 'Kategori';
    $new['jabatan']    = 'Jabatan';
    $new['kepakaran']  = 'Kepakaran';
    $new['sinta']      = 'Profil SINTA';
    $new['menu_order'] = 'Urutan';
    return $new;
});

add_action('manage_ppb_dosen_posts_custom_column', function($column, $post_id) {
    switch ($column) {
        case 'inisial':
            $ini = get_post_meta($post_id, '_ppb_dosen_inisial', true) ?: 'BK';
            echo '<div style="width:34px;height:34px;border-radius:10px;background:#0D3B22;color:#F5B82E;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;">' . esc_html($ini) . '</div>';
            break;
        case 'nip':
            echo '<code>' . esc_html(get_post_meta($post_id, '_ppb_dosen_nip', true) ?: '-') . '</code>';
            break;
        case 'kategori':
            $kat = get_post_meta($post_id, '_ppb_dosen_kategori', true) ?: 'LEKTOR';
            echo '<span style="background:#E8F0EA;color:#0D3B22;font-size:10px;font-weight:700;padding:2px 8px;border-radius:9999px;">' . esc_html($kat) . '</span>';
            break;
        case 'jabatan':
            echo esc_html(get_post_meta($post_id, '_ppb_dosen_jabatan', true) ?: '-');
            break;
        case 'kepakaran':
            $kep = get_post_meta($post_id, '_ppb_dosen_kepakaran', true);
            if ($kep) {
                $tags = array_map('trim', explode(',', $kep));
                foreach ($tags as $t) {
                    echo '<span style="background:#FAF8F5;border:1px solid #E2E8F0;font-size:10px;padding:1px 6px;border-radius:4px;margin-right:3px;display:inline-block;margin-bottom:2px;">' . esc_html($t) . '</span>';
                }
            } else {
                echo '-';
            }
            break;
        case 'sinta':
            $url = get_post_meta($post_id, '_ppb_dosen_sinta_url', true);
            if ($url) {
                echo '<a href="' . esc_url($url) . '" target="_blank" style="font-weight:600;color:#0D3B22;">Buka SINTA ↗</a>';
            } else {
                echo '-';
            }
            break;
        case 'menu_order':
            $post = get_post($post_id);
            echo esc_html($post->menu_order);
            break;
    }
}, 10, 2);

// Kolom Dokumen
add_filter('manage_ppb_dokumen_posts_columns', function($columns) {
    $new = [];
    $new['cb']         = $columns['cb'];
    $new['title']      = 'Judul Dokumen';
    $new['kategori']   = 'Kategori';
    $new['nomor']      = 'Nomor SK';
    $new['tahun']      = 'Tahun';
    $new['pengesah']   = 'Pengesah';
    $new['link_drive'] = 'Link Google Drive';
    $new['menu_order'] = 'Urutan';
    return $new;
});

add_action('manage_ppb_dokumen_posts_custom_column', function($column, $post_id) {
    switch ($column) {
        case 'kategori':
            $kat = get_post_meta($post_id, '_ppb_dokumen_kategori', true) ?: 'renstra';
            echo '<span style="background:#0D3B22;color:#F5B82E;font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:6px;text-transform:uppercase;">' . esc_html($kat) . '</span>';
            break;
        case 'nomor':
            echo '<code>' . esc_html(get_post_meta($post_id, '_ppb_dokumen_nomor', true) ?: '-') . '</code>';
            break;
        case 'tahun':
            echo esc_html(get_post_meta($post_id, '_ppb_dokumen_tahun', true) ?: '-');
            break;
        case 'pengesah':
            echo esc_html(get_post_meta($post_id, '_ppb_dokumen_pengesah', true) ?: '-');
            break;
        case 'link_drive':
            $link = get_post_meta($post_id, '_ppb_dokumen_link', true);
            if ($link) {
                echo '<a href="' . esc_url($link) . '" target="_blank" style="background:#E8F0EA;color:#0D3B22;padding:4px 10px;border-radius:6px;text-decoration:none;font-weight:700;font-size:11px;display:inline-flex;align-items:center;gap:4px;">Buka Drive ↗</a>';
            } else {
                echo '<span style="color:#ef4444;font-size:11px;">Belum Diisi</span>';
            }
            break;
        case 'menu_order':
            $post = get_post($post_id);
            echo esc_html($post->menu_order);
            break;
    }
}, 10, 2);

/* ========================================================================== */
/* 6. ENGINE FRONTEND SHORTCODES: [ppb_dosen_roster] & [ppb_dokumen_grid]    */
/* ========================================================================== */

// SHORTCODE DOSEN
if (!function_exists('ppb_shortcode_dosen_roster')) {
function ppb_shortcode_dosen_roster() {
    $query = new WP_Query([
        'post_type'      => 'ppb_dosen',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ]);

    if (!$query->have_posts()) {
        return '<div style="padding:40px;text-align:center;font-size:14px;color:#6B7280;font-family:\'Poppins\',sans-serif;">Belum ada data dosen yang ditambahkan di WP Admin.</div>';
    }

    $all_dosen = [];
    $all_tags  = [];

    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $title = get_the_title();
        $nip = get_post_meta($id, '_ppb_dosen_nip', true);
        $kategori = get_post_meta($id, '_ppb_dosen_kategori', true) ?: 'LEKTOR';
        $jabatan = get_post_meta($id, '_ppb_dosen_jabatan', true);
        $inisial = get_post_meta($id, '_ppb_dosen_inisial', true) ?: 'BK';
        $kepakaran_raw = get_post_meta($id, '_ppb_dosen_kepakaran', true);
        $sinta_url = get_post_meta($id, '_ppb_dosen_sinta_url', true) ?: 'https://sinta.kemdiktisaintek.go.id/';

        $kepakaran = [];
        if ($kepakaran_raw) {
            $parts = explode(',', $kepakaran_raw);
            foreach ($parts as $p) {
                $p = trim($p);
                if (!empty($p)) {
                    $kepakaran[] = $p;
                    $all_tags[$p] = true;
                }
            }
        }

        // Badge styling
        $badge_bg = '#E8F0EA';
        $badge_color = '#0D3B22';
        if ($kategori === 'GURU BESAR') {
            $badge_bg = '#FEF3C7';
            $badge_color = '#92400E';
        } elseif ($kategori === 'KETUA JURUSAN') {
            $badge_bg = '#E8F0EA';
            $badge_color = '#0D3B22';
        } elseif ($kategori === 'LEKTOR KEPALA') {
            $badge_bg = '#E0E7FF';
            $badge_color = '#3730A3';
        } elseif ($kategori === 'LEKTOR') {
            $badge_bg = '#E0F2FE';
            $badge_color = '#0369A1';
        }

        $all_dosen[] = [
            'id' => $id,
            'nama' => $title,
            'nip' => $nip,
            'kategori' => $kategori,
            'badge_bg' => $badge_bg,
            'badge_color' => $badge_color,
            'jabatan' => $jabatan,
            'inisial' => $inisial,
            'kepakaran' => $kepakaran,
            'sinta_url' => $sinta_url,
        ];
    }
    wp_reset_postdata();

    // Render HTML
    ob_start();
    ?>
    <section style="padding:0 var(--bk-edge-pad, 1rem) 40px;box-sizing:border-box;font-family:'Poppins',sans-serif;">
        <div style="max-width:100%;width:100%;margin:0 auto;">
            <!-- Filter Bar -->
            <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:20px;padding:14px 18px;margin-bottom:28px;box-shadow:0 4px 16px -6px rgba(13,59,34,0.06);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div style="font-size:12px;font-weight:700;color:#0D3B22;display:flex;align-items:center;gap:6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    <span>Filter Kepakaran:</span>
                </div>
                <div style="display:flex;align-items:center;gap:8px;overflow-x:auto;padding-bottom:2px;" class="no-scrollbar" id="bk-chip-filters">
                    <button type="button" class="bk-chip-btn active" data-tag="semua" style="border:none;background:#0D3B22;color:#F5B82E;font-size:11.5px;font-weight:700;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;">Semua Kepakaran</button>
                    <?php 
                    $popular_tags = ['Psikometri', 'Multikultural', 'Cybercounseling', 'Karier', 'Teori', 'Evaluasi'];
                    foreach ($popular_tags as $pt) : ?>
                        <button type="button" class="bk-chip-btn" data-tag="<?php echo esc_attr($pt); ?>" style="border:none;background:#FAF8F5;color:#4B5563;font-size:11.5px;font-weight:600;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;border:1px solid #E5E7EB;"><?php echo esc_html($pt); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Grid Roster Dosen -->
            <div id="bk-dosen-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:20px;">
                <?php foreach ($all_dosen as $d) : 
                    $searchable = strtolower($d['nama'] . ' ' . $d['nip'] . ' ' . $d['jabatan'] . ' ' . implode(' ', $d['kepakaran']));
                ?>
                <div class="bk-dosen-card-item" data-text="<?php echo esc_attr($searchable); ?>" style="background:#ffffff;border:1px solid #D4E3D8;border-radius:22px;padding:22px;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 6px 18px -8px rgba(13,59,34,0.06);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 24px -8px rgba(13,59,34,0.12)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 18px -8px rgba(13,59,34,0.06)'">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                            <div style="width:44px;height:44px;border-radius:14px;background:#0D3B22;color:#F5B82E;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;font-family:'Fraunces',Georgia,serif;">
                                <?php echo esc_html($d['inisial']); ?>
                            </div>
                            <span style="font-size:9.5px;font-weight:800;background:<?php echo $d['badge_bg']; ?>;color:<?php echo $d['badge_color']; ?>;padding:3px 8px;border-radius:9999px;letter-spacing:0.04em;">
                                <?php echo esc_html($d['kategori']); ?>
                            </span>
                        </div>

                        <h3 style="font-family:'Fraunces',Georgia,serif;font-size:16px;font-weight:700;color:#111827;line-height:1.3;margin:0 0 3px 0;">
                            <?php echo esc_html($d['nama']); ?>
                        </h3>
                        <p style="font-size:11.5px;color:#0D3B22;font-weight:600;margin:0 0 4px 0;"><?php echo esc_html($d['jabatan']); ?></p>
                        <p style="font-family:'IBM Plex Mono',monospace;font-size:10.5px;color:#6B7280;margin:0 0 12px 0;">NIP. <?php echo esc_html($d['nip']); ?></p>

                        <?php if (!empty($d['kepakaran'])) : ?>
                        <div style="border-top:1px solid #F3F4F6;padding-top:10px;margin-bottom:12px;">
                            <span style="font-size:10px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.06em;display:block;margin-bottom:6px;">Kepakaran:</span>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                <?php foreach ($d['kepakaran'] as $kep) : ?>
                                    <span style="font-size:10.5px;background:#FAF8F5;border:1px solid #E5E7EB;color:#374151;padding:2px 7px;border-radius:6px;"><?php echo esc_html($kep); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div style="border-top:1px solid #F3F4F6;padding-top:12px;">
                        <a href="<?php echo esc_url($d['sinta_url']); ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:6px;font-size:11.5px;font-weight:700;color:#0D3B22;text-decoration:none;padding:5px 10px;background:#E8F0EA;border-radius:8px;transition:all 0.2s;" onmouseover="this.style.background='#0D3B22';this.style.color='#F5B82E'" onmouseout="this.style.background='#E8F0EA';this.style.color='#0D3B22'">
                            <span>Profil SINTA / Publikasi</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Script Live Search & Filter -->
        <script>
        (function(){
            const input = document.getElementById("bk-dosen-search-input");
            const countInfo = document.getElementById("bk-dosen-count-info");
            const chips = document.querySelectorAll("#bk-chip-filters .bk-chip-btn");
            const cards = document.querySelectorAll("#bk-dosen-grid .bk-dosen-card-item");
            let activeTag = "semua";

            function filterDosen() {
                const query = (input ? input.value : "").toLowerCase().trim();
                let visibleCount = 0;

                cards.forEach(card => {
                    const text = card.getAttribute("data-text") || "";
                    const matchQuery = !query || text.includes(query);
                    const matchTag = (activeTag === "semua") || text.includes(activeTag.toLowerCase());

                    if (matchQuery && matchTag) {
                        card.style.display = "flex";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                });

                if (countInfo) {
                    if (query || activeTag !== "semua") {
                        countInfo.innerHTML = "Ditemukan <strong style='color:#F5B82E;'>" + visibleCount + "</strong> dosen yang sesuai filter";
                    } else {
                        countInfo.innerHTML = "Menampilkan seluruh " + cards.length + " dosen dan tenaga pengajar Jurusan PPB";
                    }
                }
            }

            if (input) {
                input.addEventListener("input", filterDosen);
            }

            chips.forEach(chip => {
                chip.addEventListener("click", function(){
                    chips.forEach(c => {
                        c.style.background = "#FAF8F5";
                        c.style.color = "#4B5563";
                        c.classList.remove("active");
                    });
                    this.style.background = "#0D3B22";
                    this.style.color = "#F5B82E";
                    this.classList.add("active");
                    activeTag = this.getAttribute("data-tag") || "semua";
                    filterDosen();
                });
            });
        })();
        </script>
    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_dosen_roster', 'ppb_shortcode_dosen_roster');

// SHORTCODE DOKUMEN MUTU
if (!function_exists('ppb_shortcode_dokumen_grid')) {
function ppb_shortcode_dokumen_grid() {
    $query = new WP_Query([
        'post_type'      => 'ppb_dokumen',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    ]);

    if (!$query->have_posts()) {
        return '<div style="padding:40px;text-align:center;font-size:14px;color:#6B7280;font-family:\'Poppins\',sans-serif;">Belum ada dokumen mutu yang ditambahkan di WP Admin.</div>';
    }

    $all_dok = [];
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $all_dok[] = [
            'id' => $id,
            'judul' => get_the_title(),
            'link' => get_post_meta($id, '_ppb_dokumen_link', true) ?: '#',
            'kategori' => get_post_meta($id, '_ppb_dokumen_kategori', true) ?: 'renstra',
            'nomor' => get_post_meta($id, '_ppb_dokumen_nomor', true),
            'tahun' => get_post_meta($id, '_ppb_dokumen_tahun', true) ?: '2025',
            'pengesah' => get_post_meta($id, '_ppb_dokumen_pengesah', true),
            'size' => get_post_meta($id, '_ppb_dokumen_size', true) ?: 'PDF',
            'desc' => get_post_meta($id, '_ppb_dokumen_deskripsi', true),
        ];
    }
    wp_reset_postdata();

    $cat_labels = [
        'renstra' => 'Renstra',
        'renop' => 'Renop',
        'sk_senat' => 'SK Senat',
        'pedoman_penilaian' => 'Pedoman Penilaian',
        'sk_mahasiswa_aktif' => 'SK Mahasiswa Aktif',
        'perlindungan_mahasiswa' => 'SOP Perlindungan',
        'akreditasi' => 'Akreditasi',
        'lainnya' => 'Lainnya',
    ];

    ob_start();
    ?>
    <section style="padding:0 var(--bk-edge-pad, 1rem) 40px;box-sizing:border-box;font-family:'Poppins',sans-serif;">
        <div style="max-width:100%;width:100%;margin:0 auto;">
            <!-- Category Tabs Bar -->
            <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:20px;padding:12px 16px;margin-bottom:28px;box-shadow:0 4px 16px -6px rgba(13,59,34,0.06);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div style="display:flex;align-items:center;gap:6px;overflow-x:auto;padding-bottom:2px;" class="no-scrollbar" id="bk-doc-cat-tabs">
                    <button type="button" class="bk-doc-tab-btn active" data-cat="semua" style="border:none;background:#0D3B22;color:#F5B82E;font-size:11.5px;font-weight:700;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;">Semua Dokumen</button>
                    <button type="button" class="bk-doc-tab-btn" data-cat="renstra" style="border:none;background:#FAF8F5;color:#4B5563;font-size:11.5px;font-weight:600;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;border:1px solid #E5E7EB;">Renstra &amp; Renop</button>
                    <button type="button" class="bk-doc-tab-btn" data-cat="sk_senat" style="border:none;background:#FAF8F5;color:#4B5563;font-size:11.5px;font-weight:600;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;border:1px solid #E5E7EB;">SK Senat &amp; Tata Kelola</button>
                    <button type="button" class="bk-doc-tab-btn" data-cat="pedoman_penilaian" style="border:none;background:#FAF8F5;color:#4B5563;font-size:11.5px;font-weight:600;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;border:1px solid #E5E7EB;">Pedoman OBE</button>
                    <button type="button" class="bk-doc-tab-btn" data-cat="sk_mahasiswa_aktif" style="border:none;background:#FAF8F5;color:#4B5563;font-size:11.5px;font-weight:600;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;border:1px solid #E5E7EB;">SK Mahasiswa Aktif</button>
                    <button type="button" class="bk-doc-tab-btn" data-cat="perlindungan_mahasiswa" style="border:none;background:#FAF8F5;color:#4B5563;font-size:11.5px;font-weight:600;padding:6px 14px;border-radius:9999px;cursor:pointer;font-family:'Poppins',sans-serif;white-space:nowrap;border:1px solid #E5E7EB;">SOP Perlindungan &amp; PPKS</button>
                </div>
                <div style="font-size:12px;color:#6B7280;font-weight:600;" id="bk-doc-count-info">
                    Total: <strong style="color:#0D3B22;"><?php echo count($all_dok); ?></strong> dokumen tersedia
                </div>
            </div>

            <!-- Grid Dokumen -->
            <div id="bk-dokumen-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(340px, 1fr));gap:20px;">
                <?php foreach ($all_dok as $d) : 
                    $cat_name = $cat_labels[$d['kategori']] ?? ucfirst($d['kategori']);
                ?>
                <div class="bk-doc-card-item" data-cat="<?php echo esc_attr($d['kategori']); ?>" style="background:#ffffff;border:1px solid #D4E3D8;border-radius:24px;padding:24px;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 6px 18px -8px rgba(13,59,34,0.06);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 24px -8px rgba(13,59,34,0.12)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 18px -8px rgba(13,59,34,0.06)'">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px;">
                            <span style="font-size:10px;font-weight:700;background:#E8F0EA;color:#0D3B22;padding:3px 9px;border-radius:9999px;text-transform:uppercase;">
                                <?php echo esc_html($cat_name); ?>
                            </span>
                            <span style="font-size:11px;font-weight:600;color:#6B7280;">Tahun <?php echo esc_html($d['tahun']); ?></span>
                        </div>

                        <h3 style="font-family:'Fraunces',Georgia,serif;font-size:16px;font-weight:600;color:#111827;line-height:1.35;margin:0 0 10px 0;">
                            <?php echo esc_html($d['judul']); ?>
                        </h3>

                        <?php if (!empty($d['nomor'])) : ?>
                        <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#0D3B22;background:#FAF8F5;border:1px solid #E5E7EB;padding:4px 8px;border-radius:6px;display:inline-block;margin-bottom:10px;">
                            <?php echo esc_html($d['nomor']); ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($d['pengesah'])) : ?>
                        <p style="font-size:11.5px;color:#6B7280;margin:0 0 8px 0;">
                            Pengesah: <strong style="color:#374151;"><?php echo esc_html($d['pengesah']); ?></strong>
                        </p>
                        <?php endif; ?>

                        <?php if (!empty($d['desc'])) : ?>
                        <p style="font-size:12px;color:#4B5563;line-height:1.6;margin:0 0 14px 0;text-align:justify;">
                            <?php echo esc_html($d['desc']); ?>
                        </p>
                        <?php endif; ?>
                    </div>

                    <div style="border-top:1px solid #F3F4F6;padding-top:14px;display:flex;align-items:center;justify-content:space-between;gap:10px;">
                        <span style="font-size:11px;color:#9CA3AF;font-weight:500;">
                            Ukuran: <?php echo esc_html($d['size']); ?>
                        </span>
                        <a href="<?php echo esc_url($d['link']); ?>" target="_blank" rel="noopener" class="bk-doc-btn" style="display:inline-flex;align-items:center;gap:6px;background:#0D3B22;color:#F5B82E;font-size:12px;font-weight:700;padding:8px 16px;border-radius:9999px;text-decoration:none;transition:all 0.2s;box-shadow:0 3px 8px rgba(13,59,34,0.18);" onmouseover="this.style.background='#185333'" onmouseout="this.style.background='#0D3B22'">
                            <span>Unduh Dokumen PDF</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Script Filter Tabs Dokumen -->
        <script>
        (function(){
            const tabs = document.querySelectorAll("#bk-doc-cat-tabs .bk-doc-tab-btn");
            const cards = document.querySelectorAll("#bk-dokumen-grid .bk-doc-card-item");
            const countInfo = document.getElementById("bk-doc-count-info");

            tabs.forEach(tab => {
                tab.addEventListener("click", function(){
                    tabs.forEach(t => {
                        t.style.background = "#FAF8F5";
                        t.style.color = "#4B5563";
                        t.classList.remove("active");
                    });
                    this.style.background = "#0D3B22";
                    this.style.color = "#F5B82E";
                    this.classList.add("active");

                    const cat = this.getAttribute("data-cat");
                    let visible = 0;

                    cards.forEach(card => {
                        const cardCat = card.getAttribute("data-cat");
                        let match = (cat === "semua");
                        if (cat === "renstra" && (cardCat === "renstra" || cardCat === "renop")) match = true;
                        if (cat === cardCat) match = true;

                        if (match) {
                            card.style.display = "flex";
                            visible++;
                        } else {
                            card.style.display = "none";
                        }
                    });

                    if (countInfo) {
                        countInfo.innerHTML = "Total: <strong style='color:#0D3B22;'>" + visible + "</strong> dokumen";
                    }
                });
            });
        })();
        </script>
    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_dokumen_grid', 'ppb_shortcode_dokumen_grid');

// Pastikan Shortcode diproses di dalam widget HTML Elementor
add_filter('elementor/widget/render_content', function($content, $widget) {
    if ($widget->get_name() === 'html') {
        return do_shortcode($content);
    }
    return $content;
}, 10, 2);
