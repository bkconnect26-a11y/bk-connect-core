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

/* ========================================================================== */
/* 5. SHORTCODE: LAYANAN PERSURATAN MAHASISWA & FORMAT NOMOR SURAT RESMI      */
/* ========================================================================== */
if (!function_exists('ppb_shortcode_layanan_persuratan')) {
function ppb_shortcode_layanan_persuratan($atts = []) {
    ob_start();
    ?>
    <section class="ppb-persuratan-wrapper" style="font-family:'Poppins',sans-serif;color:#1F2937;margin:30px 0;">
        
        <!-- Header & Aturan Kode Nomor Surat Resmi -->
        <div style="background:#0D3B22;color:#ffffff;border-radius:20px;padding:30px;margin-bottom:35px;box-shadow:0 10px 25px rgba(13,59,34,0.15);position:relative;overflow:hidden;">
            <div style="position:relative;z-index:2;">
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,184,46,0.2);color:#F5B82E;padding:4px 14px;border-radius:999px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;border:1px solid rgba(245,184,46,0.35);">
                    <span>Standar Tata Kelola Dokumen &amp; Persuratan</span>
                </div>
                <h2 style="font-family:'Fraunces',Georgia,serif;font-size:clamp(22px, 3vw, 30px);color:#ffffff;margin:0 0 10px;font-weight:600;">
                    Layanan Persuratan &amp; Standar Format Nomor Surat Resmi
                </h2>
                <p style="color:rgba(255,255,255,0.85);font-size:14px;max-width:760px;margin:0 0 20px;line-height:1.6;">
                    Setiap surat keterangan dan rekomendasi akademik yang diterbitkan oleh Program Studi Bimbingan dan Konseling / Jurusan PPB FIP UNM wajib mencantumkan kode klasifikasi arsip dan nomor registrasi surat resmi Universitas Negeri Makassar.
                </p>

                <!-- Box Kode Penomoran Resmi -->
                <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:14px;padding:16px 20px;">
                    <div style="font-size:12px;font-weight:700;color:#F5B82E;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">
                        Rumus Kode Penomoran Surat Resmi UNM:
                    </div>
                    <div style="font-family:monospace;font-size:clamp(13px, 2.5vw, 17px);color:#ffffff;font-weight:700;background:rgba(0,0,0,0.25);padding:10px 16px;border-radius:8px;border-left:4px solid #F5B82E;margin-bottom:8px;">
                        B / [Nomor Urut Surat] / UN36.1 / [Kode Hal] / [Tahun Berjalan]
                    </div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);display:flex;flex-wrap:wrap;gap:12px;line-height:1.4;">
                        <span>&bull; <strong>UN36.1</strong>: Kode Fakultas Ilmu Pendidikan UNM</span>
                        <span>&bull; <strong>PP</strong>: Pendidikan &amp; Pengajaran</span>
                        <span>&bull; <strong>PT</strong>: Penelitian &amp; Riset</span>
                        <span>&bull; <strong>KM</strong>: Kemahasiswaan &amp; Magang</span>
                        <span>&bull; <strong>LL</strong>: Layanan Laboratorium</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Jenis Layanan Persuratan -->
        <h3 style="font-family:'Fraunces',Georgia,serif;font-size:22px;color:#0D3B22;margin:0 0 20px;">
            Katalog Dokumen &amp; Jenis Layanan Persuratan
        </h3>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;margin-bottom:40px;">
            
            <!-- 1. Surat Keterangan Aktif Kuliah -->
            <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                        <span style="background:#E8F0EA;color:#0D3B22;font-size:11px;font-weight:700;padding:3px 10px;border-radius:6px;">Kode: PP</span>
                        <span style="font-family:monospace;font-size:11px;color:#6B7280;">B/.../UN36.1/PP/2026</span>
                    </div>
                    <h4 style="font-size:17px;font-weight:700;color:#0D3B22;margin:0 0 8px;">Surat Keterangan Aktif Kuliah</h4>
                    <p style="font-size:13px;color:#4B5563;line-height:1.5;margin:0 0 14px;">
                        Dibutuhkan untuk pengurusan tunjangan gaji orang tua, BPJS Kesehatan, dan pengajuan beasiswa eksternal.
                    </p>
                    <div style="font-size:12px;background:#FAF8F5;padding:10px 12px;border-radius:8px;border:1px dashed #D4E3D8;margin-bottom:16px;">
                        <strong style="color:#0D3B22;">Syarat Pengajuan:</strong>
                        <ul style="margin:4px 0 0;padding-left:18px;color:#6B7280;line-height:1.5;">
                            <li>KRS semester berjalan (sudah tervalidasi PA)</li>
                            <li>KTM / Slip Pembayaran UKT terbaru</li>
                        </ul>
                    </div>
                </div>
                <div style="display:flex;gap:8px;">
                    <a href="https://bk-connect-fipunm.vercel.app/sipadu" target="_blank" rel="noopener" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:12.5px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Ajukan Online &rarr;</a>
                    <a href="#" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:12px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Template</a>
                </div>
            </div>

            <!-- 2. Surat Izin Observasi / Penelitian -->
            <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                        <span style="background:#E8F0EA;color:#0D3B22;font-size:11px;font-weight:700;padding:3px 10px;border-radius:6px;">Kode: PT</span>
                        <span style="font-family:monospace;font-size:11px;color:#6B7280;">B/.../UN36.1/PT/2026</span>
                    </div>
                    <h4 style="font-size:17px;font-weight:700;color:#0D3B22;margin:0 0 8px;">Surat Izin Penelitian &amp; Observasi Skripsi</h4>
                    <p style="font-size:13px;color:#4B5563;line-height:1.5;margin:0 0 14px;">
                        Surat permohonan izin riset atau pengambilan data di sekolah mitra, instansi, atau komunitas.
                    </p>
                    <div style="font-size:12px;background:#FAF8F5;padding:10px 12px;border-radius:8px;border:1px dashed #D4E3D8;margin-bottom:16px;">
                        <strong style="color:#0D3B22;">Syarat Pengajuan:</strong>
                        <ul style="margin:4px 0 0;padding-left:18px;color:#6B7280;line-height:1.5;">
                            <li>Persetujuan Judul &amp; Tanda Tangan Pembimbing</li>
                            <li>Identitas lengkap lokasi &amp; kepala sekolah sasaran</li>
                        </ul>
                    </div>
                </div>
                <div style="display:flex;gap:8px;">
                    <a href="https://bk-connect-fipunm.vercel.app/sipadu" target="_blank" rel="noopener" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:12.5px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Ajukan Online &rarr;</a>
                    <a href="#" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:12px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Template</a>
                </div>
            </div>

            <!-- 3. Surat Pengantar Magang / MBKM -->
            <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                        <span style="background:#E8F0EA;color:#0D3B22;font-size:11px;font-weight:700;padding:3px 10px;border-radius:6px;">Kode: KM</span>
                        <span style="font-family:monospace;font-size:11px;color:#6B7280;">B/.../UN36.1/KM/2026</span>
                    </div>
                    <h4 style="font-size:17px;font-weight:700;color:#0D3B22;margin:0 0 8px;">Surat Pengantar Magang / MBKM</h4>
                    <p style="font-size:13px;color:#4B5563;line-height:1.5;margin:0 0 14px;">
                        Pengantar resmi pelaksanaan Praktik Pengalaman Lapangan (PPL), Magang Industri, atau Kampus Mengajar.
                    </p>
                    <div style="font-size:12px;background:#FAF8F5;padding:10px 12px;border-radius:8px;border:1px dashed #D4E3D8;margin-bottom:16px;">
                        <strong style="color:#0D3B22;">Syarat Pengajuan:</strong>
                        <ul style="margin:4px 0 0;padding-left:18px;color:#6B7280;line-height:1.5;">
                            <li>Surat Penerimaan dari Mitra / LoA MBKM</li>
                            <li>Konfirmasi Dosen Pembimbing Lapangan (DPL)</li>
                        </ul>
                    </div>
                </div>
                <div style="display:flex;gap:8px;">
                    <a href="https://bk-connect-fipunm.vercel.app/sipadu" target="_blank" rel="noopener" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:12.5px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Ajukan Online &rarr;</a>
                    <a href="#" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:12px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Template</a>
                </div>
            </div>

            <!-- 4. Surat Keterangan Bebas Laboratorium -->
            <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                        <span style="background:#E8F0EA;color:#0D3B22;font-size:11px;font-weight:700;padding:3px 10px;border-radius:6px;">Kode: LL</span>
                        <span style="font-family:monospace;font-size:11px;color:#6B7280;">B/.../UN36.1.7/LL/2026</span>
                    </div>
                    <h4 style="font-size:17px;font-weight:700;color:#0D3B22;margin:0 0 8px;">Surat Bebas Laboratorium &amp; Inventaris</h4>
                    <p style="font-size:13px;color:#4B5563;line-height:1.5;margin:0 0 14px;">
                        Syarat wajib yudisium dan bebas pinjaman instrumen tes psikologi/alat asesmen laboratorium BK.
                    </p>
                    <div style="font-size:12px;background:#FAF8F5;padding:10px 12px;border-radius:8px;border:1px dashed #D4E3D8;margin-bottom:16px;">
                        <strong style="color:#0D3B22;">Syarat Pengajuan:</strong>
                        <ul style="margin:4px 0 0;padding-left:18px;color:#6B7280;line-height:1.5;">
                            <li>Verifikasi status pengembalian alat oleh Pranata Lab</li>
                            <li>Bebas tanggungan modul dan instrumen konseling</li>
                        </ul>
                    </div>
                </div>
                <div style="display:flex;gap:8px;">
                    <a href="<?php echo esc_url(home_url('/lab-bk/inventaris/')); ?>" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:12.5px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Cek Inventaris &rarr;</a>
                    <a href="#" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:12px;font-weight:600;padding:9px 12px;border-radius:8px;text-decoration:none;">Template</a>
                </div>
            </div>

        </div>

        <!-- Alur 3 Langkah Pengajuan Persuratan -->
        <div style="background:#F0F6F2;border:1.5px solid #D4E3D8;border-radius:18px;padding:26px;">
            <h4 style="font-family:'Fraunces',Georgia,serif;font-size:18px;color:#0D3B22;margin:0 0 16px;">
                Alur Pengajuan &amp; Validasi Nomor Surat Resmi (3 Langkah)
            </h4>
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:20px;">
                <div style="background:#ffffff;padding:18px;border-radius:12px;border:1px solid #E2E8F0;">
                    <span style="font-weight:800;color:#F5B82E;font-size:24px;display:block;line-height:1;margin-bottom:8px;">01</span>
                    <strong style="font-size:14px;color:#0D3B22;display:block;margin-bottom:4px;">Pengisian Formulir Online</strong>
                    <p style="font-size:12.5px;color:#6B7280;margin:0;line-height:1.5;">Mahasiswa mengisi formulir di portal persuratan dengan melampirkan berkas persyaratan.</p>
                </div>
                <div style="background:#ffffff;padding:18px;border-radius:12px;border:1px solid #E2E8F0;">
                    <span style="font-weight:800;color:#F5B82E;font-size:24px;display:block;line-height:1;margin-bottom:8px;">02</span>
                    <strong style="font-size:14px;color:#0D3B22;display:block;margin-bottom:4px;">Penomoran Resmi Prodi</strong>
                    <p style="font-size:12.5px;color:#6B7280;margin:0;line-height:1.5;">Staf Tata Usaha memverifikasi syarat dan menerbitkan nomor surat resmi sesuai buku registrasi.</p>
                </div>
                <div style="background:#ffffff;padding:18px;border-radius:12px;border:1px solid #E2E8F0;">
                    <span style="font-weight:800;color:#F5B82E;font-size:24px;display:block;line-height:1;margin-bottom:8px;">03</span>
                    <strong style="font-size:14px;color:#0D3B22;display:block;margin-bottom:4px;">Tanda Tangan &amp; Unduh Surat</strong>
                    <p style="font-size:12.5px;color:#6B7280;margin:0;line-height:1.5;">Surat ditandatangani Ketua Jurusan/Dekan (TTE) dan dikirimkan langsung ke email mahasiswa.</p>
                </div>
            </div>
        </div>

    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_layanan_persuratan', 'ppb_shortcode_layanan_persuratan');

/* ========================================================================== */
/* 6. SHORTCODE: MODUL LABORATORIUM BK (KEGIATAN, LOMBA, & TAUTAN PORTAL)     */
/* ========================================================================== */
if (!function_exists('ppb_shortcode_lab_portals')) {
function ppb_shortcode_lab_portals($atts = []) {
    ob_start();
    ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;margin:30px 0;">
        
        <!-- Portal 1: BK Connect -->
        <div style="background:linear-gradient(135deg, #0D3B22 0%, #155734 100%);color:#ffffff;border-radius:18px;padding:24px;box-shadow:0 8px 24px rgba(13,59,34,0.15);position:relative;">
            <div style="display:inline-block;background:rgba(245,184,46,0.2);color:#F5B82E;font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;text-transform:uppercase;margin-bottom:10px;">Portal Digital</div>
            <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#ffffff;margin:0 0 6px;">BK Connect Suite</h3>
            <p style="font-size:13px;color:rgba(255,255,255,0.8);line-height:1.5;margin:0 0 18px;">
                Sistem informasi terintegrasi untuk asesmen psikologis digital, bimbingan akademik, dan manajemen konseling mahasiswa.
            </p>
            <a href="https://bk-connect-fipunm.vercel.app/" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:6px;background:#F5B82E;color:#0D3B22;font-size:13px;font-weight:700;padding:10px 18px;border-radius:10px;text-decoration:none;">
                <span>Masuk BK Connect</span> &rarr;
            </a>
        </div>

        <!-- Portal 2: Peer Support Network -->
        <div style="background:linear-gradient(135deg, #1E3A8A 0%, #2563EB 100%);color:#ffffff;border-radius:18px;padding:24px;box-shadow:0 8px 24px rgba(30,58,138,0.15);position:relative;">
            <div style="display:inline-block;background:rgba(255,255,255,0.2);color:#ffffff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;text-transform:uppercase;margin-bottom:10px;">Konseling Sebaya</div>
            <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#ffffff;margin:0 0 6px;">Peersupport BK UNM</h3>
            <p style="font-size:13px;color:rgba(255,255,255,0.8);line-height:1.5;margin:0 0 18px;">
                Ruang aman konseling sebaya mahasiswa BK UNM untuk konsultasi kesehatan mental, adaptasi kampus, dan persahabatan positif.
            </p>
            <a href="https://peersupport-bk.unm.ac.id/" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:6px;background:#ffffff;color:#1E3A8A;font-size:13px;font-weight:700;padding:10px 18px;border-radius:10px;text-decoration:none;">
                <span>Akses Peersupport</span> &rarr;
            </a>
        </div>

        <!-- Portal 3: Web Laboratorium BK -->
        <div style="background:linear-gradient(135deg, #7C2D12 0%, #B45309 100%);color:#ffffff;border-radius:18px;padding:24px;box-shadow:0 8px 24px rgba(124,45,18,0.15);position:relative;">
            <div style="display:inline-block;background:rgba(255,255,255,0.2);color:#ffffff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;text-transform:uppercase;margin-bottom:10px;">Sub-Portal Lab</div>
            <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#ffffff;margin:0 0 6px;">Web Lab BK &amp; Alat</h3>
            <p style="font-size:13px;color:rgba(255,255,255,0.8);line-height:1.5;margin:0 0 18px;">
                Katalog digital alat tes psikologi, jadwal pemakaian ruang konseling individual/kelompok, dan panduan praktikum.
            </p>
            <a href="<?php echo esc_url(home_url('/lab-bk/inventaris/')); ?>" style="display:inline-flex;align-items:center;gap:6px;background:#ffffff;color:#7C2D12;font-size:13px;font-weight:700;padding:10px 18px;border-radius:10px;text-decoration:none;">
                <span>Cek Inventaris Lab</span> &rarr;
            </a>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_lab_portals', 'ppb_shortcode_lab_portals');

if (!function_exists('ppb_shortcode_lab_kegiatan')) {
function ppb_shortcode_lab_kegiatan($atts = []) {
    ob_start();
    $kegiatan = [
        [
            'judul' => 'Praktikum Micro-Counseling & Simulasi Konseling Individual',
            'periode' => 'Semester Gasal & Genap 2024/2025',
            'deskripsi' => 'Pelatihan intensif keterampilan dasar komunikasi konseling, attending, empathy, dan teknik intervensi kognitif-behavioral di ruang one-way mirror Lab BK.',
            'peserta' => 'Mahasiswa Angkatan 2022 & 2023',
            'status' => 'Rutin Berkelanjutan'
        ],
        [
            'judul' => 'Workshop Administrasi & Skoring Tes Psikologi Terstandar',
            'periode' => 'Oktober – November 2024',
            'deskripsi' => 'Pelatihan penggunaan instrumen tes bakat, minat, inteligensi (DAT, RMIB, IST) serta tes inventori kepribadian untuk asesmen BK sekolah.',
            'peserta' => '65 Mahasiswa Lab BK',
            'status' => 'Selesai Dilaksanakan'
        ],
        [
            'judul' => 'Program Duta Peer Counselor & Sahabat Sebaya Kampus',
            'periode' => 'Maret – Juni 2024',
            'deskripsi' => 'Kaderisasi mahasiswa konselor sebaya untuk memberikan pertolongan pertama psikologis (Psychological First Aid) bagi civitas akademika UNM.',
            'peserta' => '40 Mahasiswa Peer Counselor',
            'status' => 'Aktif Berjalan'
        ],
        [
            'judul' => 'Pengembangan Media BK Digital & Virtual Reality Therapy',
            'periode' => 'Agustus 2024',
            'deskripsi' => 'Eksperimen inovasi pemanfaatan media interaktif dan simulasi relaksasi berbasis teknologi digital di Laboratorium BK FIP UNM.',
            'peserta' => 'Tim Pengembang Lab BK',
            'status' => 'Tahap Uji Coba'
        ]
    ];
    ?>
    <div style="margin:25px 0;">
        <h3 style="font-family:'Fraunces',Georgia,serif;font-size:22px;color:#0D3B22;margin:0 0 16px;">
            Kegiatan &amp; Praktikum Mahasiswa Laboratorium BK
        </h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;">
            <?php foreach ($kegiatan as $kg) : ?>
                <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <span style="font-size:11px;font-weight:700;background:#E8F0EA;color:#0D3B22;padding:3px 10px;border-radius:6px;"><?php echo esc_html($kg['status']); ?></span>
                        <span style="font-size:12px;color:#6B7280;font-weight:500;"><?php echo esc_html($kg['periode']); ?></span>
                    </div>
                    <h4 style="font-size:16px;font-weight:700;color:#0D3B22;margin:0 0 8px;line-height:1.4;"><?php echo esc_html($kg['judul']); ?></h4>
                    <p style="font-size:13px;color:#4B5563;line-height:1.6;margin:0 0 12px;"><?php echo esc_html($kg['deskripsi']); ?></p>
                    <div style="font-size:12px;color:#0D3B22;font-weight:600;display:flex;align-items:center;gap:6px;">
                        <span>👥 Sasaran: <?php echo esc_html($kg['peserta']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_lab_kegiatan', 'ppb_shortcode_lab_kegiatan');

if (!function_exists('ppb_shortcode_lab_lomba')) {
function ppb_shortcode_lab_lomba($atts = []) {
    ob_start();
    $lomba = [
        [
            'nama' => 'Lomba Media Bimbingan dan Konseling Nasional (LMBKN) 2024',
            'penyelenggara' => 'Laboratorium BK &amp; Himpunan Mahasiswa BK FIP UNM',
            'kategori' => 'Tingkat Nasional',
            'prestasi' => 'Penyelenggara &amp; Juara 1 Kategori Media Interaktif Digital',
            'lingkup' => 'Non-Akademik / Kreativitas Inovatif'
        ],
        [
            'nama' => 'Kompetisi Video Simulasi Konseling Kreatif 2023',
            'penyelenggara' => 'Asosiasi Bimbingan dan Konseling Indonesia (ABKIN)',
            'kategori' => 'Tingkat Nasional',
            'prestasi' => 'Juara 2 Kategori Simulasi Konseling Kelompok',
            'lingkup' => 'Keterampilan Konseling Terapan'
        ],
        [
            'nama' => 'Festival Cipta Puisi &amp; Poster Edukasi Mental Health 2024',
            'penyelenggara' => 'Laboratorium BK FIP UNM',
            'kategori' => 'Tingkat Universitas / Regional',
            'prestasi' => 'Penyelenggara &amp; Publikasi 50 Karya Terbaik',
            'lingkup' => 'Seni &amp; Promosi Kesehatan Mental'
        ]
    ];
    ?>
    <div style="margin:25px 0;">
        <h3 style="font-family:'Fraunces',Georgia,serif;font-size:22px;color:#0D3B22;margin:0 0 16px;">
            Informasi Lomba Non-Akademik Mahasiswa Lab BK
        </h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;">
            <?php foreach ($lomba as $lb) : ?>
                <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <span style="font-size:11px;font-weight:700;background:#FEF3C7;color:#92400E;padding:3px 10px;border-radius:6px;"><?php echo esc_html($lb['kategori']); ?></span>
                        <span style="font-size:11px;color:#6B7280;"><?php echo esc_html($lb['lingkup']); ?></span>
                    </div>
                    <h4 style="font-size:16px;font-weight:700;color:#0D3B22;margin:0 0 8px;line-height:1.4;"><?php echo esc_html($lb['nama']); ?></h4>
                    <p style="font-size:12.5px;color:#4B5563;margin:0 0 10px;">
                        <strong>Penyelenggara:</strong> <?php echo wp_kses_post($lb['penyelenggara']); ?>
                    </p>
                    <div style="font-size:12.5px;background:#FAF8F5;border:1px solid #E2E8F0;padding:8px 12px;border-radius:8px;color:#0D3B22;font-weight:600;">
                        🏆 Capaian: <?php echo esc_html($lb['prestasi']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_lab_lomba', 'ppb_shortcode_lab_lomba');
