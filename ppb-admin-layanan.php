<?php
/**
 * Module: PPB Admin Layanan & Lab BK Suite
 * Description: Modul WP-Admin khusus untuk mengelola Template Dokumen Resmi (CPT), Inventaris Alat Lab BK (CPT), Alur Prosedur SOP (CPT), Pengaturan Layanan & Perlindungan Mahasiswa, serta Shortcodes Scholaro Design System.
 * Version: 1.0.0
 * Author: Jurusan PPB FIP UNM
 */

if (!defined('ABSPATH')) exit;

/* ========================================================================== */
/* 1. REGISTRASI CPT: PPB_TEMPLATE_DOK (Template Dokumen Resmi)               */
/* ========================================================================== */
if (!function_exists('ppb_register_cpt_template_dok')) {
function ppb_register_cpt_template_dok() {
    $labels = [
        'name'               => 'Template Dokumen',
        'singular_name'      => 'Template Dokumen',
        'menu_name'          => 'Template Dokumen',
        'name_admin_bar'     => 'Template Dokumen',
        'add_new'            => 'Tambah Template Baru',
        'add_new_item'       => 'Tambah Template Baru',
        'new_item'           => 'Template Baru',
        'edit_item'          => 'Edit Template',
        'view_item'          => 'Lihat Template',
        'all_items'          => 'Semua Template Dokumen',
        'search_items'       => 'Cari Template Dokumen',
        'not_found'          => 'Belum ada data template dokumen.',
        'not_found_in_trash' => 'Tidak ada template di kotak sampah.'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'template-dokumen'],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 26,
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => ['title'],
        'show_in_rest'       => false,
    ];

    register_post_type('ppb_template_dok', $args);
}
}
add_action('init', 'ppb_register_cpt_template_dok');

/* ========================================================================== */
/* 2. REGISTRASI CPT: PPB_INVENTARIS_LAB (Inventaris Alat Lab BK)             */
/* ========================================================================== */
if (!function_exists('ppb_register_cpt_inventaris_lab')) {
function ppb_register_cpt_inventaris_lab() {
    $labels = [
        'name'               => 'Inventaris Alat Lab',
        'singular_name'      => 'Inventaris Lab',
        'menu_name'          => 'Inventaris Lab BK',
        'name_admin_bar'     => 'Inventaris Lab BK',
        'add_new'            => 'Tambah Alat/Instrumen',
        'add_new_item'       => 'Tambah Alat/Instrumen Baru',
        'new_item'           => 'Alat Baru',
        'edit_item'          => 'Edit Alat/Instrumen',
        'view_item'          => 'Lihat Alat',
        'all_items'          => 'Semua Inventaris Alat Lab',
        'search_items'       => 'Cari Alat/Instrumen',
        'not_found'          => 'Belum ada data inventaris alat.',
        'not_found_in_trash' => 'Tidak ada alat di kotak sampah.'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'inventaris-lab'],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 27,
        'menu_icon'          => 'dashicons-forms',
        'supports'           => ['title'],
        'show_in_rest'       => false,
    ];

    register_post_type('ppb_inventaris_lab', $args);
}
}
add_action('init', 'ppb_register_cpt_inventaris_lab');

/* ========================================================================== */
/* 3. REGISTRASI CPT: PPB_ALUR_SOP (Alur Prosedur SOP Layanan)                */
/* ========================================================================== */
if (!function_exists('ppb_register_cpt_alur_sop')) {
function ppb_register_cpt_alur_sop() {
    $labels = [
        'name'               => 'Alur SOP Layanan',
        'singular_name'      => 'Alur SOP Layanan',
        'menu_name'          => 'Alur SOP Layanan',
        'name_admin_bar'     => 'Alur SOP Layanan',
        'add_new'            => 'Tambah Alur Baru',
        'add_new_item'       => 'Tambah Alur Layanan Baru',
        'new_item'           => 'Alur Baru',
        'edit_item'          => 'Edit Alur Layanan',
        'view_item'          => 'Lihat Alur',
        'all_items'          => 'Semua Alur SOP Layanan',
        'search_items'       => 'Cari Alur Layanan',
        'not_found'          => 'Belum ada data alur layanan.',
        'not_found_in_trash' => 'Tidak ada alur di kotak sampah.'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'alur-sop'],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 28,
        'menu_icon'          => 'dashicons-randomize',
        'supports'           => ['title'],
        'show_in_rest'       => false,
    ];

    register_post_type('ppb_alur_sop', $args);
}
}
add_action('init', 'ppb_register_cpt_alur_sop');

/* ========================================================================== */
/* 4. META BOXES UNTUK TEMPLATE DOKUMEN                                       */
/* ========================================================================== */
if (!function_exists('ppb_add_template_dok_meta_box')) {
function ppb_add_template_dok_meta_box() {
    add_meta_box(
        'ppb_template_dok_meta',
        '📄 Rincian Berkas Template Resmi',
        'ppb_template_dok_render_meta_box',
        'ppb_template_dok',
        'normal',
        'high'
    );
}
}
add_action('add_meta_boxes', 'ppb_add_template_dok_meta_box');

if (!function_exists('ppb_template_dok_render_meta_box')) {
function ppb_template_dok_render_meta_box($post) {
    wp_nonce_field('ppb_template_dok_save_nonce', 'ppb_template_dok_nonce');
    $kategori     = get_post_meta($post->ID, '_ppb_tpl_kategori', true) ?: 'skripsi';
    $format_file  = get_post_meta($post->ID, '_ppb_tpl_format_file', true) ?: 'DOCX';
    $ukuran_kb    = get_post_meta($post->ID, '_ppb_tpl_ukuran_kb', true) ?: '250';
    $nomor_revisi = get_post_meta($post->ID, '_ppb_tpl_nomor_revisi', true) ?: 'REV-2026/A';
    $file_link    = get_post_meta($post->ID, '_ppb_tpl_file_link', true) ?: '';
    $deskripsi    = get_post_meta($post->ID, '_ppb_tpl_deskripsi', true) ?: '';
    ?>
    <style>
        .ppb-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .ppb-form-group { display: flex; flex-direction: column; }
        .ppb-form-group label { font-weight: 600; margin-bottom: 5px; color: #1e293b; font-size: 13px; }
        .ppb-form-group input, .ppb-form-group select, .ppb-form-group textarea { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; }
        .ppb-form-group small { color: #64748b; margin-top: 4px; font-size: 11px; }
    </style>
    <div class="ppb-form-grid">
        <div class="ppb-form-group">
            <label for="ppb_tpl_kategori">Kategori Dokumen</label>
            <select name="ppb_tpl_kategori" id="ppb_tpl_kategori">
                <option value="skripsi" <?php selected($kategori, 'skripsi'); ?>>Tugas Akhir / Skripsi</option>
                <option value="izin_penelitian" <?php selected($kategori, 'izin_penelitian'); ?>>Izin Penelitian & Observasi</option>
                <option value="bebas_lab" <?php selected($kategori, 'bebas_lab'); ?>>Bebas Laboratorium</option>
                <option value="peninjauan_ukt" <?php selected($kategori, 'peninjauan_ukt'); ?>>Peninjauan & Penyesuaian UKT</option>
                <option value="akademik_umum" <?php selected($kategori, 'akademik_umum'); ?>>PPL, Magang & Akademik Umum</option>
            </select>
        </div>
        <div class="ppb-form-group">
            <label for="ppb_tpl_format_file">Format Berkas</label>
            <select name="ppb_tpl_format_file" id="ppb_tpl_format_file">
                <option value="DOCX" <?php selected($format_file, 'DOCX'); ?>>Microsoft Word (.docx)</option>
                <option value="PDF" <?php selected($format_file, 'PDF'); ?>>Adobe PDF (.pdf)</option>
                <option value="XLSX" <?php selected($format_file, 'XLSX'); ?>>Microsoft Excel (.xlsx)</option>
            </select>
        </div>
        <div class="ppb-form-group">
            <label for="ppb_tpl_ukuran_kb">Estimasi Ukuran File (KB)</label>
            <input type="number" name="ppb_tpl_ukuran_kb" id="ppb_tpl_ukuran_kb" value="<?php echo esc_attr($ukuran_kb); ?>">
        </div>
        <div class="ppb-form-group">
            <label for="ppb_tpl_nomor_revisi">Kode / Nomor Revisi</label>
            <input type="text" name="ppb_tpl_nomor_revisi" id="ppb_tpl_nomor_revisi" value="<?php echo esc_attr($nomor_revisi); ?>" placeholder="REV-2026/A">
        </div>
    </div>
    <div class="ppb-form-group" style="margin-bottom: 15px;">
        <label for="ppb_tpl_file_link">Tautan Google Drive / Unduhan Dokumen Resmi</label>
        <input type="url" name="ppb_tpl_file_link" id="ppb_tpl_file_link" value="<?php echo esc_attr($file_link); ?>" placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
        <small>Tautan Google Drive atau link file resmi untuk dilihat dan diunduh mahasiswa.</small>
    </div>
    <div class="ppb-form-group">
        <label for="ppb_tpl_deskripsi">Deskripsi & Petunjuk Penggunaan Template</label>
        <textarea name="ppb_tpl_deskripsi" id="ppb_tpl_deskripsi" rows="3"><?php echo esc_textarea($deskripsi); ?></textarea>
    </div>
    <?php
}
}

if (!function_exists('ppb_template_dok_save_meta_box')) {
function ppb_template_dok_save_meta_box($post_id) {
    if (!isset($_POST['ppb_template_dok_nonce']) || !wp_verify_nonce($_POST['ppb_template_dok_nonce'], 'ppb_template_dok_save_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = [
        'ppb_tpl_kategori'     => '_ppb_tpl_kategori',
        'ppb_tpl_format_file'  => '_ppb_tpl_format_file',
        'ppb_tpl_ukuran_kb'    => '_ppb_tpl_ukuran_kb',
        'ppb_tpl_nomor_revisi' => '_ppb_tpl_nomor_revisi',
        'ppb_tpl_file_link'    => '_ppb_tpl_file_link',
        'ppb_tpl_deskripsi'    => '_ppb_tpl_deskripsi',
    ];

    foreach ($fields as $key => $meta_key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$key]));
        }
    }
}
}
add_action('save_post_ppb_template_dok', 'ppb_template_dok_save_meta_box');

/* ========================================================================== */
/* 5. META BOXES UNTUK INVENTARIS ALAT LAB BK                                 */
/* ========================================================================== */
if (!function_exists('ppb_add_inventaris_lab_meta_box')) {
function ppb_add_inventaris_lab_meta_box() {
    add_meta_box(
        'ppb_inventaris_lab_meta',
        '🧪 Rincian Alat / Instrumen Laboratorium BK',
        'ppb_inventaris_lab_render_meta_box',
        'ppb_inventaris_lab',
        'normal',
        'high'
    );
}
}
add_action('add_meta_boxes', 'ppb_add_inventaris_lab_meta_box');

if (!function_exists('ppb_inventaris_lab_render_meta_box')) {
function ppb_inventaris_lab_render_meta_box($post) {
    wp_nonce_field('ppb_inventaris_lab_save_nonce', 'ppb_inventaris_lab_nonce');
    $kode_alat     = get_post_meta($post->ID, '_ppb_inv_kode_alat', true) ?: 'TES-001';
    $kategori      = get_post_meta($post->ID, '_ppb_inv_kategori', true) ?: 'tes_psikologi';
    $spesifikasi   = get_post_meta($post->ID, '_ppb_inv_spesifikasi', true) ?: '';
    $jumlah_unit   = get_post_meta($post->ID, '_ppb_inv_jumlah_unit', true) ?: '1';
    $kondisi       = get_post_meta($post->ID, '_ppb_inv_kondisi', true) ?: 'baik';
    $lokasi        = get_post_meta($post->ID, '_ppb_inv_lokasi', true) ?: 'Lemari Asesmen Lab BK';
    $manual_link   = get_post_meta($post->ID, '_ppb_inv_manual_link', true) ?: '';
    $foto_link     = get_post_meta($post->ID, '_ppb_inv_foto_link', true) ?: '';
    $keterangan    = get_post_meta($post->ID, '_ppb_inv_keterangan', true) ?: '';
    ?>
    <div class="ppb-form-grid">
        <div class="ppb-form-group">
            <label for="ppb_inv_kode_alat">Kode Registrasi Alat</label>
            <input type="text" name="ppb_inv_kode_alat" id="ppb_inv_kode_alat" value="<?php echo esc_attr($kode_alat); ?>" placeholder="TES-INT-CFIT3">
        </div>
        <div class="ppb-form-group">
            <label for="ppb_inv_kategori">Kategori Alat / Fasilitas</label>
            <select name="ppb_inv_kategori" id="ppb_inv_kategori">
                <option value="tes_psikologi" <?php selected($kategori, 'tes_psikologi'); ?>>Tes Psikologi Baku (Bakat, Minat, Inteligensi)</option>
                <option value="instrumen_non_tes" <?php selected($kategori, 'instrumen_non_tes'); ?>>Instrumen Non-Tes (AUM, DCM, ITP)</option>
                <option value="fasilitas_mikrokonseling" <?php selected($kategori, 'fasilitas_mikrokonseling'); ?>>Fasilitas Mikrokonseling & Observasi</option>
                <option value="perangkat_digital" <?php selected($kategori, 'perangkat_digital'); ?>>Perangkat Digital & Skoring</option>
            </select>
        </div>
        <div class="ppb-form-group">
            <label for="ppb_inv_jumlah_unit">Jumlah Unit / Ketersediaan</label>
            <input type="number" name="ppb_inv_jumlah_unit" id="ppb_inv_jumlah_unit" value="<?php echo esc_attr($jumlah_unit); ?>" min="1">
        </div>
        <div class="ppb-form-group">
            <label for="ppb_inv_kondisi">Kondisi Alat</label>
            <select name="ppb_inv_kondisi" id="ppb_inv_kondisi">
                <option value="baik" <?php selected($kondisi, 'baik'); ?>>Baik / Siap Pakai</option>
                <option value="perlu_kalibrasi" <?php selected($kondisi, 'perlu_kalibrasi'); ?>>Perlu Kalibrasi / Penggantian Buku</option>
                <option value="pemeliharaan" <?php selected($kondisi, 'pemeliharaan'); ?>>Dalam Pemeliharaan</option>
            </select>
        </div>
        <div class="ppb-form-group" style="grid-column: 1 / -1;">
            <label for="ppb_inv_lokasi">Lokasi Penyimpanan di Laboratorium</label>
            <input type="text" name="ppb_inv_lokasi" id="ppb_inv_lokasi" value="<?php echo esc_attr($lokasi); ?>" placeholder="Lemari Asesmen A-01 Lab BK FIP UNM">
        </div>
        <div class="ppb-form-group" style="grid-column: 1 / -1;">
            <label for="ppb_inv_spesifikasi">Spesifikasi Kelengkapan Alat</label>
            <input type="text" name="ppb_inv_spesifikasi" id="ppb_inv_spesifikasi" value="<?php echo esc_attr($spesifikasi); ?>" placeholder="Buku Soal, Lembar Jawaban, Kunci Transparan, Norma Baku Indonesia">
        </div>
        <div class="ppb-form-group">
            <label for="ppb_inv_manual_link">Link Manual Book / SOP Alat (Google Drive)</label>
            <input type="url" name="ppb_inv_manual_link" id="ppb_inv_manual_link" value="<?php echo esc_attr($manual_link); ?>" placeholder="https://drive.google.com/file/d/...">
        </div>
        <div class="ppb-form-group">
            <label for="ppb_inv_foto_link">Link Foto Alat (Google Drive / URL Gambar)</label>
            <input type="url" name="ppb_inv_foto_link" id="ppb_inv_foto_link" value="<?php echo esc_attr($foto_link); ?>" placeholder="https://drive.google.com/file/d/...">
        </div>
        <div class="ppb-form-group" style="grid-column: 1 / -1;">
            <label for="ppb_inv_keterangan">Keterangan / Catatan Peminjaman</label>
            <textarea name="ppb_inv_keterangan" id="ppb_inv_keterangan" rows="2"><?php echo esc_textarea($keterangan); ?></textarea>
        </div>
    </div>
    <?php
}
}

if (!function_exists('ppb_inventaris_lab_save_meta_box')) {
function ppb_inventaris_lab_save_meta_box($post_id) {
    if (!isset($_POST['ppb_inventaris_lab_nonce']) || !wp_verify_nonce($_POST['ppb_inventaris_lab_nonce'], 'ppb_inventaris_lab_save_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = [
        'ppb_inv_kode_alat'   => '_ppb_inv_kode_alat',
        'ppb_inv_kategori'    => '_ppb_inv_kategori',
        'ppb_inv_spesifikasi' => '_ppb_inv_spesifikasi',
        'ppb_inv_jumlah_unit' => '_ppb_inv_jumlah_unit',
        'ppb_inv_kondisi'     => '_ppb_inv_kondisi',
        'ppb_inv_lokasi'      => '_ppb_inv_lokasi',
        'ppb_inv_manual_link' => '_ppb_inv_manual_link',
        'ppb_inv_foto_link'   => '_ppb_inv_foto_link',
        'ppb_inv_keterangan'  => '_ppb_inv_keterangan',
    ];

    foreach ($fields as $key => $meta_key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$key]));
        }
    }
}
}
add_action('save_post_ppb_inventaris_lab', 'ppb_inventaris_lab_save_meta_box');

/* ========================================================================== */
/* 6. PENGATURAN UMUM LAYANAN & LAB BK                                        */
/* ========================================================================== */
if (!function_exists('ppb_register_layanan_settings_menu')) {
function ppb_register_layanan_settings_menu() {
    add_submenu_page(
        'edit.php?post_type=ppb_template_dok',
        'Pengaturan Layanan & Lab BK',
        'Pengaturan Layanan',
        'manage_options',
        'ppb-layanan-settings',
        'ppb_render_layanan_settings_page'
    );
}
}
// Handled by ppb-portal-hub
// add_action('admin_menu', 'ppb_register_layanan_settings_menu');

if (!function_exists('ppb_render_layanan_settings_page')) {
function ppb_render_layanan_settings_page() {
    if (isset($_POST['ppb_save_layanan_options'])) {
        check_admin_referer('ppb_save_layanan_nonce');
        $opts = [
            'ppb_layanan_wa_hotline',
            'ppb_layanan_jam_operasional',
            'ppb_layanan_lokasi_lab',
            'ppb_layanan_sop_perlindungan_link',
            'ppb_layanan_sipadu_url',
            'ppb_layanan_survei_url'
        ];
        foreach ($opts as $opt) {
            if (isset($_POST[$opt])) {
                update_option($opt, sanitize_text_field($_POST[$opt]));
            }
        }
        echo '<div class="updated"><p>Pengaturan Layanan & Lab BK berhasil disimpan!</p></div>';
    }

    $wa_hotline       = get_option('ppb_layanan_wa_hotline', '6281242338988');
    $jam_operasional  = get_option('ppb_layanan_jam_operasional', 'Senin – Jumat, 08.00 – 16.00 WITA');
    $lokasi_lab       = get_option('ppb_layanan_lokasi_lab', 'Gedung Laboratorium BK, FIP UNM Kampus Gunungsari Makassar');
    $sop_perlindungan = get_option('ppb_layanan_sop_perlindungan_link', 'https://drive.google.com/file/d/1_SOP_Perlindungan_Mahasiswa_BK/view?usp=sharing');
    $sipadu_url       = get_option('ppb_layanan_sipadu_url', 'https://bk-connect-fipunm.vercel.app/sipadu');
    $survei_url       = get_option('ppb_layanan_survei_url', home_url('/layanan/survei/'));
    ?>
    <div class="wrap">
        <h1 style="font-family:'Fraunces',serif;color:#0D3B22;margin-bottom:20px;">⚙️ Pengaturan Pusat Layanan & Laboratorium BK</h1>
        <form method="post" action="" style="max-width:850px;background:#fff;padding:25px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.06);">
            <?php wp_nonce_field('ppb_save_layanan_nonce'); ?>
            
            <h3 style="margin-top:0;color:#0D3B22;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">Hotline & Operasional Lab BK</h3>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="ppb_layanan_wa_hotline">Nomor WhatsApp Konselor Siaga</label></th>
                    <td>
                        <input type="text" name="ppb_layanan_wa_hotline" id="ppb_layanan_wa_hotline" value="<?php echo esc_attr($wa_hotline); ?>" class="regular-text">
                        <p class="description">Format internasional tanpa simbol (contoh: 6281242338988). Digunakan untuk tombol hotline konseling cepat.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ppb_layanan_jam_operasional">Jam Layanan Terbuka</label></th>
                    <td>
                        <input type="text" name="ppb_layanan_jam_operasional" id="ppb_layanan_jam_operasional" value="<?php echo esc_attr($jam_operasional); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ppb_layanan_lokasi_lab">Lokasi Fisik Laboratorium</label></th>
                    <td>
                        <input type="text" name="ppb_layanan_lokasi_lab" id="ppb_layanan_lokasi_lab" value="<?php echo esc_attr($lokasi_lab); ?>" class="large-text">
                    </td>
                </tr>
            </table>

            <h3 style="margin-top:25px;color:#0D3B22;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">Integrasi Portal & Dokumen Regulasi</h3>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="ppb_layanan_sipadu_url">URL Portal SI-PADU BK</label></th>
                    <td>
                        <input type="url" name="ppb_layanan_sipadu_url" id="ppb_layanan_sipadu_url" value="<?php echo esc_attr($sipadu_url); ?>" class="large-text">
                        <p class="description">Tautan portal eksternal SI-PADU BK FIP UNM.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ppb_layanan_sop_perlindungan_link">Link Dokumen SOP Perlindungan Mahasiswa</label></th>
                    <td>
                        <input type="url" name="ppb_layanan_sop_perlindungan_link" id="ppb_layanan_sop_perlindungan_link" value="<?php echo esc_attr($sop_perlindungan); ?>" class="large-text">
                        <p class="description">Tautan Google Drive resmi untuk dokumen SOP Perlindungan Mahasiswa Standar 13 LAMDIK.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ppb_layanan_survei_url">Tautan Survei Kepuasan Mahasiswa</label></th>
                    <td>
                        <input type="url" name="ppb_layanan_survei_url" id="ppb_layanan_survei_url" value="<?php echo esc_attr($survei_url); ?>" class="large-text">
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" name="ppb_save_layanan_options" class="button button-primary" value="Simpan Pengaturan Layanan" style="background:#0D3B22;border-color:#0D3B22;">
            </p>
        </form>
    </div>
    <?php
}
}
