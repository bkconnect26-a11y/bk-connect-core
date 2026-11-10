<?php
/**
 * Module: PPB FIP UNM - Manajemen Akademik & Jadwal Ujian
 * Description: Modul WP Admin untuk pengelolaan Jadwal Seminar & Ujian Skripsi serta konfigurasi Tautan Dokumen Kurikulum tanpa menyentuh kode HTML atau Elementor.
 * Author: Jurusan PPB FIP UNM
 */

if (!defined('ABSPATH')) exit;

/* ========================================================================== */
/* 1. REGISTRASI CUSTOM POST TYPE: JADWAL SEMINAR & UJIAN (ppb_jadwal)        */
/* ========================================================================== */
if (!function_exists('ppb_register_cpt_jadwal')) {
function ppb_register_cpt_jadwal() {
    $labels = [
        'name'               => 'Jadwal Seminar & Ujian',
        'singular_name'      => 'Jadwal Ujian',
        'menu_name'          => 'Jadwal Ujian',
        'name_admin_bar'     => 'Jadwal Ujian',
        'add_new'            => 'Tambah Sesi Baru',
        'add_new_item'       => 'Tambah Jadwal Seminar / Ujian Baru',
        'new_item'           => 'Jadwal Baru',
        'edit_item'          => 'Edit Jadwal Seminar / Ujian',
        'view_item'          => 'Lihat Jadwal',
        'all_items'          => 'Semua Jadwal',
        'search_items'       => 'Cari Jadwal (Nama / NIM / Judul)',
        'not_found'          => 'Belum ada jadwal seminar atau ujian.',
        'not_found_in_trash' => 'Tidak ada jadwal di tempat sampah.'
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
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => ['title'], // Judul otomatis disimpan sebagai Nama Mahasiswa - Jenis Ujian
    ];

    register_post_type('ppb_jadwal', $args);
}
}
add_action('init', 'ppb_register_cpt_jadwal');

/* ========================================================================== */
/* 2. META BOX: DETAIL JADWAL SEMINAR & UJIAN                                 */
/* ========================================================================== */
if (!function_exists('ppb_jadwal_add_meta_box')) {
function ppb_jadwal_add_meta_box() {
    add_meta_box(
        'ppb_jadwal_meta_box',
        'Detail Pelaksanaan Seminar & Ujian Skripsi',
        'ppb_jadwal_render_meta_box',
        'ppb_jadwal',
        'normal',
        'high'
    );
}
}
add_action('add_meta_boxes', 'ppb_jadwal_add_meta_box');

if (!function_exists('ppb_jadwal_render_meta_box')) {
function ppb_jadwal_render_meta_box($post) {
    wp_nonce_field('ppb_jadwal_save_meta', 'ppb_jadwal_meta_nonce');

    $jenis_ujian      = get_post_meta($post->ID, '_ppb_jenis_ujian', true) ?: 'seminar_proposal';
    $status           = get_post_meta($post->ID, '_ppb_status', true) ?: 'terjadwal';
    $nama_mahasiswa   = get_post_meta($post->ID, '_ppb_nama_mahasiswa', true);
    $nim              = get_post_meta($post->ID, '_ppb_nim', true);
    $angkatan         = get_post_meta($post->ID, '_ppb_angkatan', true) ?: '2022';
    $judul_penelitian = get_post_meta($post->ID, '_ppb_judul_penelitian', true);
    $tanggal          = get_post_meta($post->ID, '_ppb_tanggal', true);
    $jam_mulai        = get_post_meta($post->ID, '_ppb_jam_mulai', true) ?: '08:30';
    $jam_selesai      = get_post_meta($post->ID, '_ppb_jam_selesai', true) ?: '10:00';
    $ruangan          = get_post_meta($post->ID, '_ppb_ruangan', true) ?: 'Ruang Sidang FIP UNM Lt. 2 (Offline)';
    $link_daring      = get_post_meta($post->ID, '_ppb_link_daring', true);
    $pembimbing_1     = get_post_meta($post->ID, '_ppb_pembimbing_1', true);
    $pembimbing_2     = get_post_meta($post->ID, '_ppb_pembimbing_2', true);
    $penguji_1        = get_post_meta($post->ID, '_ppb_penguji_1', true);
    $penguji_2        = get_post_meta($post->ID, '_ppb_penguji_2', true);
    ?>
    <style>
        .ppb-jadwal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .ppb-jadwal-full { grid-column: span 2; }
        .ppb-jadwal-field label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e293b; font-size: 13px; }
        .ppb-jadwal-field input, .ppb-jadwal-field select, .ppb-jadwal-field textarea {
            width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; background: #fff;
        }
        .ppb-jadwal-field input:focus, .ppb-jadwal-field select:focus, .ppb-jadwal-field textarea:focus {
            border-color: #0D3B22; outline: none; box-shadow: 0 0 0 2px rgba(13,59,34,0.15);
        }
        .ppb-badge-guide { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px; margin-top: 10px; font-size: 12px; color: #64748b; }
    </style>

    <div class="ppb-jadwal-grid">
        <div class="ppb-jadwal-field">
            <label for="ppb_jenis_ujian">🎓 Tahapan Seminar / Ujian:</label>
            <select name="ppb_jenis_ujian" id="ppb_jenis_ujian" required>
                <option value="seminar_proposal" <?php selected($jenis_ujian, 'seminar_proposal'); ?>>Seminar Proposal (Sempro)</option>
                <option value="seminar_hasil" <?php selected($jenis_ujian, 'seminar_hasil'); ?>>Seminar Hasil Penelitian (Semhas)</option>
                <option value="ujian_skripsi" <?php selected($jenis_ujian, 'ujian_skripsi'); ?>>Ujian Skripsi (Ujian Tutup / Sarjana)</option>
            </select>
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_status">⚡ Status Pelaksanaan:</label>
            <select name="ppb_status" id="ppb_status" required>
                <option value="terjadwal" <?php selected($status, 'terjadwal'); ?>>🟢 Terjadwal (Akan Datang)</option>
                <option value="sedang_berlangsung" <?php selected($status, 'sedang_berlangsung'); ?>>🔴 Sedang Berlangsung (Live)</option>
                <option value="selesai" <?php selected($status, 'selesai'); ?>>⚪ Selesai (Arsip)</option>
            </select>
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_nama_mahasiswa">👤 Nama Lengkap Mahasiswa:</label>
            <input type="text" name="ppb_nama_mahasiswa" id="ppb_nama_mahasiswa" value="<?php echo esc_attr($nama_mahasiswa); ?>" placeholder="Contoh: Nurul Aulia Rahmah" required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_nim">🔢 Nomor Induk Mahasiswa (NIM):</label>
            <input type="text" name="ppb_nim" id="ppb_nim" value="<?php echo esc_attr($nim); ?>" placeholder="Contoh: 220401501012" required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_angkatan">📅 Angkatan Masuk:</label>
            <input type="number" name="ppb_angkatan" id="ppb_angkatan" value="<?php echo esc_attr($angkatan); ?>" placeholder="2022" />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_tanggal">🗓️ Tanggal Ujian:</label>
            <input type="date" name="ppb_tanggal" id="ppb_tanggal" value="<?php echo esc_attr($tanggal); ?>" required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_jam_mulai">⏰ Waktu Mulai (WITA):</label>
            <input type="text" name="ppb_jam_mulai" id="ppb_jam_mulai" value="<?php echo esc_attr($jam_mulai); ?>" placeholder="08:30" required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_jam_selesai">⏰ Waktu Selesai (WITA):</label>
            <input type="text" name="ppb_jam_selesai" id="ppb_jam_selesai" value="<?php echo esc_attr($jam_selesai); ?>" placeholder="10:00" required />
        </div>

        <div class="ppb-jadwal-field ppb-jadwal-full">
            <label for="ppb_judul_penelitian">📖 Judul Penelitian / Skripsi:</label>
            <textarea name="ppb_judul_penelitian" id="ppb_judul_penelitian" rows="3" placeholder="Masukkan judul penelitian lengkap mahasiswa..." required><?php echo esc_textarea($judul_penelitian); ?></textarea>
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_ruangan">📍 Ruangan / Lokasi Ujian:</label>
            <input type="text" name="ppb_ruangan" id="ppb_ruangan" value="<?php echo esc_attr($ruangan); ?>" placeholder="Ruang Sidang FIP UNM Lt. 2 (Offline)" required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_link_daring">🌐 Tautan Daring (Zoom / GMeet - Opsional):</label>
            <input type="url" name="ppb_link_daring" id="ppb_link_daring" value="<?php echo esc_attr($link_daring); ?>" placeholder="https://zoom.us/j/9847123456" />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_pembimbing_1">👨‍🏫 Pembimbing 1 (Utama):</label>
            <input type="text" name="ppb_pembimbing_1" id="ppb_pembimbing_1" value="<?php echo esc_attr($pembimbing_1); ?>" placeholder="Prof. Dr. Farida Aryani, M.Pd." required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_pembimbing_2">👨‍🏫 Pembimbing 2 (Pendamping):</label>
            <input type="text" name="ppb_pembimbing_2" id="ppb_pembimbing_2" value="<?php echo esc_attr($pembimbing_2); ?>" placeholder="Dr. Abdul Saman, M.Si., Kons." required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_penguji_1">👨‍⚖️ Penguji 1:</label>
            <input type="text" name="ppb_penguji_1" id="ppb_penguji_1" value="<?php echo esc_attr($penguji_1); ?>" placeholder="Prof. Dr. H. Alimuddin Mahmud, M.Pd." required />
        </div>

        <div class="ppb-jadwal-field">
            <label for="ppb_penguji_2">👨‍⚖️ Penguji 2:</label>
            <input type="text" name="ppb_penguji_2" id="ppb_penguji_2" value="<?php echo esc_attr($penguji_2); ?>" placeholder="Dr. Suciani Latif, M.Pd." required />
        </div>
    </div>

    <div class="ppb-badge-guide">
        💡 <strong>Catatan Admin:</strong> Setelah disimpan, jadwal ini akan langsung tayang pada halaman publik <code>/akademik/jadwal-ujian/</code> secara otomatis dan dapat difilter oleh mahasiswa maupun dosen penguji.
    </div>
    <?php
}
}

if (!function_exists('ppb_jadwal_save_meta_data')) {
function ppb_jadwal_save_meta_data($post_id) {
    if (!isset($_POST['ppb_jadwal_meta_nonce']) || !wp_verify_nonce($_POST['ppb_jadwal_meta_nonce'], 'ppb_jadwal_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = [
        'ppb_jenis_ujian'      => '_ppb_jenis_ujian',
        'ppb_status'           => '_ppb_status',
        'ppb_nama_mahasiswa'   => '_ppb_nama_mahasiswa',
        'ppb_nim'              => '_ppb_nim',
        'ppb_angkatan'         => '_ppb_angkatan',
        'ppb_judul_penelitian' => '_ppb_judul_penelitian',
        'ppb_tanggal'          => '_ppb_tanggal',
        'ppb_jam_mulai'        => '_ppb_jam_mulai',
        'ppb_jam_selesai'      => '_ppb_jam_selesai',
        'ppb_ruangan'          => '_ppb_ruangan',
        'ppb_link_daring'      => '_ppb_link_daring',
        'ppb_pembimbing_1'     => '_ppb_pembimbing_1',
        'ppb_pembimbing_2'     => '_ppb_pembimbing_2',
        'ppb_penguji_1'        => '_ppb_penguji_1',
        'ppb_penguji_2'        => '_ppb_penguji_2',
    ];

    foreach ($fields as $post_key => $meta_key) {
        if (isset($_POST[$post_key])) {
            $val = ($post_key === 'ppb_link_daring') ? esc_url_raw($_POST[$post_key]) : sanitize_text_field($_POST[$post_key]);
            if ($post_key === 'ppb_judul_penelitian') {
                $val = sanitize_textarea_field($_POST[$post_key]);
            }
            update_post_meta($post_id, $meta_key, $val);
        }
    }

    // Auto update title to "Nama Mahasiswa - Jenis Ujian" if title is empty or default
    if (!empty($_POST['ppb_nama_mahasiswa'])) {
        $jenis_labels = [
            'seminar_proposal' => 'Seminar Proposal',
            'seminar_hasil'    => 'Seminar Hasil',
            'ujian_skripsi'    => 'Ujian Skripsi'
        ];
        $jenis_txt = isset($jenis_labels[$_POST['ppb_jenis_ujian']]) ? $jenis_labels[$_POST['ppb_jenis_ujian']] : 'Seminar';
        $new_title = sanitize_text_field($_POST['ppb_nama_mahasiswa']) . ' (' . $jenis_txt . ')';

        // Unhook to avoid infinite loop
        remove_action('save_post_ppb_jadwal', 'ppb_jadwal_save_meta_data');
        wp_update_post([
            'ID' => $post_id,
            'post_title' => $new_title,
        ]);
        add_action('save_post_ppb_jadwal', 'ppb_jadwal_save_meta_data');
    }

    // Always invalidate Elementor cache on schedule page so fresh data appears immediately
    delete_post_meta(30, '_elementor_element_cache');
    if (class_exists('\\Elementor\\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
}
}
add_action('save_post_ppb_jadwal', 'ppb_jadwal_save_meta_data');

/* ========================================================================== */
/* 3. KUSTOMISASI KOLOM TABEL ADMIN PPB_JADWAL                                */
/* ========================================================================== */
if (!function_exists('ppb_jadwal_custom_columns')) {
function ppb_jadwal_custom_columns($columns) {
    $new_columns = [];
    $new_columns['cb']          = $columns['cb'];
    $new_columns['mahasiswa']   = 'Mahasiswa & NIM';
    $new_columns['jenis_ujian'] = 'Jenis Ujian';
    $new_columns['judul']       = 'Judul Penelitian';
    $new_columns['jadwal']      = 'Waktu & Ruang';
    $new_columns['penguji']     = 'Pembimbing & Penguji';
    $new_columns['status']      = 'Status';
    return $new_columns;
}
}
add_filter('manage_ppb_jadwal_posts_columns', 'ppb_jadwal_custom_columns');

if (!function_exists('ppb_jadwal_render_custom_columns')) {
function ppb_jadwal_render_custom_columns($column, $post_id) {
    switch ($column) {
        case 'mahasiswa':
            $nama = get_post_meta($post_id, '_ppb_nama_mahasiswa', true) ?: get_the_title($post_id);
            $nim  = get_post_meta($post_id, '_ppb_nim', true) ?: '-';
            echo '<strong>' . esc_html($nama) . '</strong><br><span style="color:#64748b;font-family:monospace;font-size:11px;">NIM: ' . esc_html($nim) . '</span>';
            break;

        case 'jenis_ujian':
            $jenis = get_post_meta($post_id, '_ppb_jenis_ujian', true);
            if ($jenis === 'seminar_proposal') {
                echo '<span style="display:inline-block;padding:3px 8px;border-radius:6px;background:#eff6ff;color:#1e40af;font-weight:700;font-size:11px;border:1px solid #bfdbfe;">Seminar Proposal</span>';
            } elseif ($jenis === 'seminar_hasil') {
                echo '<span style="display:inline-block;padding:3px 8px;border-radius:6px;background:#fffbeb;color:#92400e;font-weight:700;font-size:11px;border:1px solid #fde68a;">Seminar Hasil</span>';
            } else {
                echo '<span style="display:inline-block;padding:3px 8px;border-radius:6px;background:#faf5ff;color:#6b21a8;font-weight:700;font-size:11px;border:1px solid #e9d5ff;">Ujian Skripsi</span>';
            }
            break;

        case 'judul':
            $judul = get_post_meta($post_id, '_ppb_judul_penelitian', true);
            echo '<span style="font-size:12px;color:#334155;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">' . esc_html($judul) . '</span>';
            break;

        case 'jadwal':
            $tgl = get_post_meta($post_id, '_ppb_tanggal', true);
            $mulai = get_post_meta($post_id, '_ppb_jam_mulai', true);
            $selesai = get_post_meta($post_id, '_ppb_jam_selesai', true);
            $ruang = get_post_meta($post_id, '_ppb_ruangan', true);
            $link = get_post_meta($post_id, '_ppb_link_daring', true);

            $formatted_tgl = $tgl ? date_i18n('d M Y', strtotime($tgl)) : '-';
            echo '<div style="font-size:12px;font-weight:600;color:#0D3B22;">' . esc_html($formatted_tgl) . '</div>';
            echo '<div style="font-size:11px;color:#64748b;">' . esc_html($mulai) . ' - ' . esc_html($selesai) . ' WITA</div>';
            echo '<div style="font-size:11px;color:#475569;margin-top:2px;">📍 ' . esc_html($ruang) . '</div>';
            if ($link) {
                echo '<a href="' . esc_url($link) . '" target="_blank" style="font-size:10px;color:#2563eb;font-weight:600;text-decoration:none;">🔗 Link Daring ↗</a>';
            }
            break;

        case 'penguji':
            $p1 = get_post_meta($post_id, '_ppb_pembimbing_1', true);
            $u1 = get_post_meta($post_id, '_ppb_penguji_1', true);
            echo '<div style="font-size:11px;color:#475569;"><strong>P1:</strong> ' . esc_html($p1 ?: '-') . '</div>';
            echo '<div style="font-size:11px;color:#475569;"><strong>U1:</strong> ' . esc_html($u1 ?: '-') . '</div>';
            break;

        case 'status':
            $status = get_post_meta($post_id, '_ppb_status', true);
            if ($status === 'terjadwal') {
                echo '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:12px;background:#ecfdf5;color:#065f46;font-weight:700;font-size:11px;border:1px solid #a7f3d0;"><span style="width:6px;height:6px;border-radius:50%;background:#059669;"></span> Terjadwal</span>';
            } elseif ($status === 'sedang_berlangsung') {
                echo '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:12px;background:#fff1f2;color:#9f1239;font-weight:700;font-size:11px;border:1px solid #fecdd3;"><span style="width:6px;height:6px;border-radius:50%;background:#e11d48;"></span> Berlangsung</span>';
            } else {
                echo '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:12px;background:#f3f4f6;color:#374151;font-weight:700;font-size:11px;border:1px solid #e5e7eb;">✓ Selesai</span>';
            }
            break;
    }
}
}
add_action('manage_ppb_jadwal_posts_custom_column', 'ppb_jadwal_render_custom_columns', 10, 2);

/* ========================================================================== */
/* 4. HALAMAN PENGATURAN TAUTAN DOKUMEN AKADEMIK & KURIKULUM                  */
/* ========================================================================== */
if (!function_exists('ppb_akademik_register_settings_page')) {
function ppb_akademik_register_settings_page() {
    add_submenu_page(
        'edit.php?post_type=ppb_jadwal',
        'Tautan Dokumen Akademik',
        'Tautan Dokumen & Drive',
        'manage_options',
        'ppb-akademik-settings',
        'ppb_akademik_render_settings_page'
    );
}
}
// Handled by ppb-portal-hub
// add_action('admin_menu', 'ppb_akademik_register_settings_page');

if (!function_exists('ppb_akademik_render_settings_page')) {
function ppb_akademik_render_settings_page() {
    if (isset($_POST['ppb_save_akademik_options']) && check_admin_referer('ppb_akademik_options_verify')) {
        update_option('ppb_link_buku_kurikulum', esc_url_raw($_POST['ppb_link_buku_kurikulum']));
        update_option('ppb_link_sk_kurikulum', esc_url_raw($_POST['ppb_link_sk_kurikulum']));
        update_option('ppb_link_pedoman_penilaian', esc_url_raw($_POST['ppb_link_pedoman_penilaian']));
        update_option('ppb_link_pedoman_skripsi', esc_url_raw($_POST['ppb_link_pedoman_skripsi']));
        echo '<div class="notice notice-success is-dismissible"><p><strong>Tautan Dokumen Akademik berhasil diperbarui!</strong></p></div>';
    }

    $link_kurikulum = get_option('ppb_link_buku_kurikulum', 'https://drive.google.com/file/d/1_Buku_Kurikulum_OBE_BK_UNM/view?usp=sharing');
    $link_sk        = get_option('ppb_link_sk_kurikulum', 'https://drive.google.com/file/d/1_SK_Senat_Kurikulum_OBE/view?usp=sharing');
    $link_pedoman   = get_option('ppb_link_pedoman_penilaian', 'https://drive.google.com/file/d/1_Panduan_Penilaian_OBE_BK/view?usp=sharing');
    $link_skripsi   = get_option('ppb_link_pedoman_skripsi', 'https://drive.google.com/drive/folders/1_Pedoman_Skripsi_BK_UNM?usp=sharing');
    ?>
    <div class="wrap" style="max-width:850px;font-family:'Poppins',sans-serif;">
        <h1 style="font-family:'Fraunces',Georgia,serif;color:#0D3B22;font-size:26px;margin-bottom:8px;">Pengaturan Tautan Google Drive Dokumen Akademik</h1>
        <p style="color:#64748b;font-size:13px;margin-bottom:24px;">Admin dapat memperbarui link Google Drive untuk Buku Kurikulum OBE, SK Senat, dan Pedoman Penilaian yang tampil di seluruh tombol website.</p>

        <form method="post" action="">
            <?php wp_nonce_field('ppb_akademik_options_verify'); ?>
            <div style="background:#fff;border:1px solid #cbd5e1;border-radius:14px;padding:24px;box-shadow:0 4px 12px rgba(0,0,0,0.03);display:flex;flex-direction:column;gap:18px;">
                <div>
                    <label style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">📘 Tautan Google Drive: Buku Kurikulum OBE Lengkap</label>
                    <input type="url" name="ppb_link_buku_kurikulum" value="<?php echo esc_attr($link_kurikulum); ?>" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:8px;font-size:13px;" required />
                    <span style="font-size:11px;color:#64748b;">Tampil pada tombol utama halaman /akademik/kurikulum/</span>
                </div>

                <div>
                    <label style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">🏛️ Tautan Google Drive: SK Senat Pengesahan Kurikulum</label>
                    <input type="url" name="ppb_link_sk_kurikulum" value="<?php echo esc_attr($link_sk); ?>" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:8px;font-size:13px;" required />
                    <span style="font-size:11px;color:#64748b;">Tampil pada tombol SK Senat halaman /akademik/kurikulum/</span>
                </div>

                <div>
                    <label style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">⚖️ Tautan Google Drive: Dokumen Resmi Pedoman Penilaian OBE</label>
                    <input type="url" name="ppb_link_pedoman_penilaian" value="<?php echo esc_attr($link_pedoman); ?>" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:8px;font-size:13px;" required />
                    <span style="font-size:11px;color:#64748b;">Tampil pada tombol utama halaman /akademik/panduan/</span>
                </div>

                <div>
                    <label style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">📁 Tautan Google Drive: Folder Pedoman & Template Skripsi</label>
                    <input type="url" name="ppb_link_pedoman_skripsi" value="<?php echo esc_attr($link_skripsi); ?>" style="width:100%;padding:10px 14px;border:1px solid #cbd5e1;border-radius:8px;font-size:13px;" required />
                    <span style="font-size:11px;color:#64748b;">Tampil pada repositori unduh formulir dan panduan skripsi</span>
                </div>

                <div style="margin-top:10px;">
                    <button type="submit" name="ppb_save_akademik_options" class="button button-primary" style="background:#0D3B22;border-color:#0D3B22;padding:6px 20px;height:auto;font-size:13px;font-weight:700;border-radius:8px;">💾 Simpan Pengaturan Tautan</button>
                </div>
            </div>
        </form>
    </div>
    <?php
}
}

/* ========================================================================== */
/* 5. SHORTCODE: [ppb_jadwal_ujian_list]                                      */
/* ========================================================================== */
if (!function_exists('ppb_shortcode_jadwal_ujian_list')) {
function ppb_shortcode_jadwal_ujian_list() {
    $args = [
        'post_type'      => 'ppb_jadwal',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => '_ppb_tanggal',
        'orderby'        => 'meta_value',
        'order'          => 'DESC'
    ];

    $query = new WP_Query($args);
    $items = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $pid = get_the_ID();

            $items[] = [
                'id'               => 'jadwal-' . $pid,
                'jenis_ujian'      => get_post_meta($pid, '_ppb_jenis_ujian', true) ?: 'seminar_proposal',
                'status'           => get_post_meta($pid, '_ppb_status', true) ?: 'terjadwal',
                'nama_mahasiswa'   => get_post_meta($pid, '_ppb_nama_mahasiswa', true) ?: get_the_title(),
                'nim'              => get_post_meta($pid, '_ppb_nim', true) ?: '-',
                'angkatan'         => get_post_meta($pid, '_ppb_angkatan', true) ?: '-',
                'judul_penelitian' => get_post_meta($pid, '_ppb_judul_penelitian', true) ?: get_the_title(),
                'tanggal'          => get_post_meta($pid, '_ppb_tanggal', true) ?: date('Y-m-d'),
                'jam_mulai'        => get_post_meta($pid, '_ppb_jam_mulai', true) ?: '08:30',
                'jam_selesai'      => get_post_meta($pid, '_ppb_jam_selesai', true) ?: '10:00',
                'ruangan'          => get_post_meta($pid, '_ppb_ruangan', true) ?: 'Ruang Sidang FIP UNM',
                'link_daring'      => get_post_meta($pid, '_ppb_link_daring', true) ?: '',
                'pembimbing_1'     => get_post_meta($pid, '_ppb_pembimbing_1', true) ?: '-',
                'pembimbing_2'     => get_post_meta($pid, '_ppb_pembimbing_2', true) ?: '-',
                'penguji_1'        => get_post_meta($pid, '_ppb_penguji_1', true) ?: '-',
                'penguji_2'        => get_post_meta($pid, '_ppb_penguji_2', true) ?: '-',
            ];
        }
        wp_reset_postdata();
    }

    // Counts
    $count_total     = count($items);
    $count_proposal  = 0;
    $count_hasil     = 0;
    $count_skripsi   = 0;
    $count_terjadwal = 0;

    foreach ($items as $it) {
        if ($it['jenis_ujian'] === 'seminar_proposal') $count_proposal++;
        if ($it['jenis_ujian'] === 'seminar_hasil') $count_hasil++;
        if ($it['jenis_ujian'] === 'ujian_skripsi') $count_skripsi++;
        if ($it['status'] === 'terjadwal') $count_terjadwal++;
    }

    ob_start();
    $items_json = wp_json_encode($items);
    ?>
    <section class="ppb-jadwal-wrapper" style="font-family:'Poppins',sans-serif;color:#1e293b;width:100%;max-width:1200px;margin:0 auto;">
        
        <!-- Quick Counter Pills -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(140px, 1fr));gap:12px;margin-bottom:24px;">
            <div style="background:#ffffff;border:1px solid #E2E8F0;border-radius:16px;padding:16px;box-shadow:0 4px 12px rgba(13,59,34,0.04);">
                <span style="font-size:10px;text-transform:uppercase;font-weight:700;letter-spacing:0.05em;color:#64748B;display:block;margin-bottom:4px;">Seminar Proposal</span>
                <span id="ppb-cnt-proposal" style="font-family:'Fraunces',Georgia,serif;font-size:26px;font-weight:700;color:#0D3B22;"><?php echo $count_proposal; ?></span>
            </div>
            <div style="background:#ffffff;border:1px solid #E2E8F0;border-radius:16px;padding:16px;box-shadow:0 4px 12px rgba(13,59,34,0.04);">
                <span style="font-size:10px;text-transform:uppercase;font-weight:700;letter-spacing:0.05em;color:#64748B;display:block;margin-bottom:4px;">Seminar Hasil</span>
                <span id="ppb-cnt-hasil" style="font-family:'Fraunces',Georgia,serif;font-size:26px;font-weight:700;color:#0D3B22;"><?php echo $count_hasil; ?></span>
            </div>
            <div style="background:#ffffff;border:1px solid #E2E8F0;border-radius:16px;padding:16px;box-shadow:0 4px 12px rgba(13,59,34,0.04);">
                <span style="font-size:10px;text-transform:uppercase;font-weight:700;letter-spacing:0.05em;color:#64748B;display:block;margin-bottom:4px;">Ujian Skripsi</span>
                <span id="ppb-cnt-skripsi" style="font-family:'Fraunces',Georgia,serif;font-size:26px;font-weight:700;color:#0D3B22;"><?php echo $count_skripsi; ?></span>
            </div>
            <div style="background:#0D3B22;border:1px solid #185333;border-radius:16px;padding:16px;box-shadow:0 4px 12px rgba(13,59,34,0.15);color:#fff;">
                <span style="font-size:10px;text-transform:uppercase;font-weight:700;letter-spacing:0.05em;color:#F5B82E;display:block;margin-bottom:4px;">Sesi Terjadwal</span>
                <span id="ppb-cnt-terjadwal" style="font-family:'Fraunces',Georgia,serif;font-size:26px;font-weight:700;color:#F5B82E;"><?php echo $count_terjadwal; ?></span>
            </div>
        </div>

        <!-- Mode Switcher: Tampilan Kartu vs Tampilan Kalender Bulanan -->
        <div style="background:#ffffff;border:1px solid #E2E8F0;border-radius:20px;padding:14px 20px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;box-shadow:0 4px 16px rgba(13,59,34,0.04);">
            <div>
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#B45309;display:block;margin-bottom:2px;">Format Penayangan</span>
                <h3 style="font-family:'Fraunces',Georgia,serif;font-size:18px;font-weight:600;color:#0F172A;margin:0;">Pilih Format Tampilan Jadwal Sidang</h3>
            </div>
            <div style="background:#FAF8F5;border:1px solid #E2E8F0;border-radius:12px;padding:4px;display:inline-flex;align-items:center;gap:4px;">
                <button type="button" id="ppb-view-btn-cards" class="ppb-view-toggle-btn active" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:#0D3B22;color:#F5B82E;transition:all 0.2s;">
                    📋 Daftar Kartu
                </button>
                <button type="button" id="ppb-view-btn-cal" class="ppb-view-toggle-btn" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:transparent;color:#475569;transition:all 0.2s;">
                    📅 Kalender Akademik
                </button>
            </div>
        </div>

        <!-- ================================================================== -->
        <!-- VIEW 1: DAFTAR KARTU & SEARCH TOOLBAR                              -->
        <!-- ================================================================== -->
        <div id="ppb-view-cards-container" style="display:block;">
            <!-- Filter & Search Toolbar -->
            <div style="background:#ffffff;border:1px solid #E2E8F0;border-radius:24px;padding:18px 20px;box-shadow:0 8px 24px -8px rgba(13,59,34,0.06);margin-bottom:24px;">
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px;">
                    <!-- Search Box -->
                    <div style="flex:1;min-width:260px;position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;">🔍</span>
                        <input type="text" id="ppb-jadwal-search" placeholder="Cari mahasiswa, NIM, judul skripsi, atau dosen..." style="width:100%;box-sizing:border-box;padding:10px 14px 10px 38px;border:1px solid #E2E8F0;border-radius:12px;font-size:13px;background:#FAF8F5;color:#1e293b;outline:none;transition:all 0.2s;" onfocus="this.style.background='#fff';this.style.borderColor='#0D3B22';" onblur="this.style.background='#FAF8F5';this.style.borderColor='#E2E8F0';" />
                    </div>

                    <!-- Status Filter -->
                    <div style="display:flex;align-items:center;gap:6px;overflow-x:auto;">
                        <span style="font-size:12px;font-weight:600;color:#64748b;margin-right:4px;">Status:</span>
                        <button type="button" class="ppb-status-btn active" data-status="semua" style="padding:6px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;border:none;background:#0D3B22;color:#fff;transition:all 0.2s;">Semua</button>
                        <button type="button" class="ppb-status-btn" data-status="terjadwal" style="padding:6px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;border:none;background:#f1f5f9;color:#475569;transition:all 0.2s;">Terjadwal</button>
                        <button type="button" class="ppb-status-btn" data-status="selesai" style="padding:6px 12px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;border:none;background:#f1f5f9;color:#475569;transition:all 0.2s;">Selesai</button>
                    </div>
                </div>

                <!-- Category Tab Pills -->
                <div style="border-top:1px solid #f1f5f9;padding-top:12px;display:flex;align-items:center;gap:8px;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                    <button type="button" class="ppb-kategori-btn active" data-jenis="semua" style="padding:7px 16px;border-radius:12px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:#F5B82E;color:#0D3B22;white-space:nowrap;transition:all 0.2s;">Semua Tahapan (<?php echo $count_total; ?>)</button>
                    <button type="button" class="ppb-kategori-btn" data-jenis="seminar_proposal" style="padding:7px 16px;border-radius:12px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:#f1f5f9;color:#475569;white-space:nowrap;transition:all 0.2s;">Seminar Proposal (<?php echo $count_proposal; ?>)</button>
                    <button type="button" class="ppb-kategori-btn" data-jenis="seminar_hasil" style="padding:7px 16px;border-radius:12px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:#f1f5f9;color:#475569;white-space:nowrap;transition:all 0.2s;">Seminar Hasil (<?php echo $count_hasil; ?>)</button>
                    <button type="button" class="ppb-kategori-btn" data-jenis="ujian_skripsi" style="padding:7px 16px;border-radius:12px;font-size:12px;font-weight:700;cursor:pointer;border:none;background:#f1f5f9;color:#475569;white-space:nowrap;transition:all 0.2s;">Ujian Skripsi (<?php echo $count_skripsi; ?>)</button>
                </div>
            </div>

            <!-- Schedule Cards Grid -->
            <div id="ppb-jadwal-cards-container" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(360px, 1fr));gap:20px;">
                <?php foreach ($items as $item): 
                    $badge_bg = '#EFF6FF';
                    $badge_color = '#1E40AF';
                    $badge_border = '#BFDBFE';
                    $badge_label = 'Seminar Proposal';

                    if ($item['jenis_ujian'] === 'seminar_hasil') {
                        $badge_bg = '#FFFBEB';
                        $badge_color = '#92400E';
                        $badge_border = '#FDE68A';
                        $badge_label = 'Seminar Hasil';
                    } elseif ($item['jenis_ujian'] === 'ujian_skripsi') {
                        $badge_bg = '#FAF5FF';
                        $badge_color = '#6B21A8';
                        $badge_border = '#E9D5FF';
                        $badge_label = 'Ujian Skripsi (Tutup)';
                    }

                    $tgl_obj = strtotime($item['tanggal']);
                    $hari_id = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'][date('l', $tgl_obj)];
                    $bln_id  = ['Jan'=>'Jan','Feb'=>'Feb','Mar'=>'Mar','Apr'=>'Apr','May'=>'Mei','Jun'=>'Jun','Jul'=>'Jul','Aug'=>'Agu','Sep'=>'Sep','Oct'=>'Okt','Nov'=>'Nov','Dec'=>'Des'][date('M', $tgl_obj)];
                    $tgl_formatted = $hari_id . ', ' . date('d', $tgl_obj) . ' ' . $bln_id . ' ' . date('Y', $tgl_obj);
                ?>
                <div class="ppb-jadwal-card" 
                     data-jenis="<?php echo esc_attr($item['jenis_ujian']); ?>" 
                     data-status="<?php echo esc_attr($item['status']); ?>" 
                     data-search="<?php echo esc_attr(strtolower($item['nama_mahasiswa'] . ' ' . $item['nim'] . ' ' . $item['judul_penelitian'] . ' ' . $item['pembimbing_1'] . ' ' . $item['penguji_1'])); ?>" 
                     style="background:#ffffff;border:1px solid #E2E8F0;border-radius:24px;padding:24px;box-shadow:0 4px 16px rgba(13,59,34,0.04);display:flex;flex-direction:column;justify-content:space-between;transition:transform 0.2s, box-shadow 0.2s;">
                    
                    <div>
                        <!-- Header Badges -->
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:14px;">
                            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:4px 10px;border-radius:9999px;background:<?php echo $badge_bg; ?>;color:<?php echo $badge_color; ?>;border:1px solid <?php echo $badge_border; ?>;">
                                <?php echo $badge_label; ?>
                            </span>

                            <?php if ($item['status'] === 'terjadwal'): ?>
                                <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;background:#ECFDF5;color:#065F46;border:1px solid #A7F3D0;font-size:10px;font-weight:700;text-transform:uppercase;">
                                    <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#059669;"></span> Terjadwal
                                </span>
                            <?php elseif ($item['status'] === 'sedang_berlangsung'): ?>
                                <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;background:#FFF1F2;color:#9F1239;border:1px solid #FECDD3;font-size:10px;font-weight:700;text-transform:uppercase;">
                                    <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#E11D48;"></span> Berlangsung
                                </span>
                            <?php else: ?>
                                <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:9999px;background:#F1F5F9;color:#475569;border:1px solid #E2E8F0;font-size:10px;font-weight:700;text-transform:uppercase;">
                                    ✓ Selesai
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Research Title -->
                        <h3 style="font-family:'Fraunces',Georgia,serif;font-size:17px;font-weight:600;color:#0F172A;line-height:1.35;margin:0 0 12px 0;">
                            <?php echo esc_html($item['judul_penelitian']); ?>
                        </h3>

                        <!-- Student Info -->
                        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#475569;margin-bottom:16px;">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:50%;background:#E8F0EA;color:#0D3B22;font-weight:700;font-size:11px;">🎓</span>
                            <strong style="color:#0F172A;"><?php echo esc_html($item['nama_mahasiswa']); ?></strong>
                            <span style="color:#CBD5E1;">•</span>
                            <span style="font-family:monospace;color:#64748B;">NIM: <?php echo esc_html($item['nim']); ?></span>
                        </div>

                        <!-- Time & Room Details -->
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
                            <div style="background:#FAF8F5;border:1px solid #EFECE6;border-radius:12px;padding:10px 12px;">
                                <span style="font-size:10px;color:#854D0E;font-weight:700;display:block;margin-bottom:2px;">🗓️ TANGGAL & WAKTU</span>
                                <div style="font-size:12px;font-weight:600;color:#1E293B;"><?php echo esc_html($tgl_formatted); ?></div>
                                <div style="font-size:11px;color:#64748B;margin-top:2px;"><?php echo esc_html($item['jam_mulai'] . ' - ' . $item['jam_selesai']); ?> WITA</div>
                            </div>

                            <div style="background:#FAF8F5;border:1px solid #EFECE6;border-radius:12px;padding:10px 12px;">
                                <span style="font-size:10px;color:#0D3B22;font-weight:700;display:block;margin-bottom:2px;">📍 LOKASI / RUANG</span>
                                <div style="font-size:12px;font-weight:600;color:#1E293B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo esc_html($item['ruangan']); ?></div>
                                <?php if (!empty($item['link_daring'])): ?>
                                    <a href="<?php echo esc_url($item['link_daring']); ?>" target="_blank" rel="noopener noreferrer" style="font-size:11px;color:#2563EB;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-top:2px;">
                                        📹 Tautan Daring ↗
                                    </a>
                                <?php else: ?>
                                    <span style="font-size:11px;color:#64748B;margin-top:2px;display:block;">Sidang Tatap Muka</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Examiners & Supervisors -->
                        <div style="border-top:1px solid #F1F5F9;padding-top:14px;display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:11px;">
                            <div style="background:#F8FAFC;border:1px solid #F1F5F9;border-radius:12px;padding:10px 12px;">
                                <span style="font-size:9px;font-weight:700;text-transform:uppercase;color:#64748B;letter-spacing:0.04em;display:block;margin-bottom:4px;">TIM PEMBIMBING</span>
                                <div style="font-weight:500;color:#1E293B;line-height:1.4;">1. <?php echo esc_html($item['pembimbing_1']); ?></div>
                                <div style="font-weight:500;color:#1E293B;line-height:1.4;margin-top:2px;">2. <?php echo esc_html($item['pembimbing_2']); ?></div>
                            </div>

                            <div style="background:#F8FAFC;border:1px solid #F1F5F9;border-radius:12px;padding:10px 12px;">
                                <span style="font-size:9px;font-weight:700;text-transform:uppercase;color:#64748B;letter-spacing:0.04em;display:block;margin-bottom:4px;">TIM PENGUJI</span>
                                <div style="font-weight:500;color:#1E293B;line-height:1.4;">1. <?php echo esc_html($item['penguji_1']); ?></div>
                                <div style="font-weight:500;color:#1E293B;line-height:1.4;margin-top:2px;">2. <?php echo esc_html($item['penguji_2']); ?></div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:16px;border-top:1px solid #F1F5F9;padding-top:10px;display:flex;align-items:center;justify-content:space-between;font-size:11px;color:#94A3B8;">
                        <span>Jurusan Psikologi Pendidikan &amp; Bimbingan</span>
                        <span style="font-family:monospace;"><?php echo esc_html($item['id']); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty State Alert -->
            <div id="ppb-jadwal-empty" style="display:none;background:#ffffff;border:1px solid #E2E8F0;border-radius:24px;padding:40px 20px;text-align:center;box-shadow:0 4px 12px rgba(0,0,0,0.03);margin-top:20px;">
                <div style="font-size:36px;margin-bottom:8px;">🗓️</div>
                <h4 style="font-family:'Fraunces',Georgia,serif;font-size:18px;color:#0F172A;margin:0 0 6px 0;">Tidak Ada Jadwal Ditemukan</h4>
                <p style="font-size:13px;color:#64748B;margin:0;">Tidak ada sesi seminar atau ujian yang sesuai dengan kata kunci atau filter yang Anda pilih.</p>
            </div>
        </div>

        <!-- ================================================================== -->
        <!-- VIEW 2: KALENDER BULANAN INTERAKTIF                                -->
        <!-- ================================================================== -->
        <div id="ppb-view-cal-container" style="display:none;">
            <div style="background:#ffffff;border:1px solid #E2E8F0;border-radius:24px;padding:24px;box-shadow:0 8px 24px -8px rgba(13,59,34,0.06);margin-bottom:24px;">
                
                <!-- Calendar Header Bar -->
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:20px;border-bottom:1px solid #F1F5F9;padding-bottom:16px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <h2 id="ppb-cal-title" style="font-family:'Fraunces',Georgia,serif;font-size:clamp(20px, 3vw, 26px);font-weight:600;color:#0D3B22;margin:0;">
                            Oktober 2026
                        </h2>
                        <button type="button" id="ppb-cal-btn-today" style="padding:4px 12px;border-radius:8px;font-size:11px;font-weight:700;border:1px solid #0D3B22;background:#E8F0EA;color:#0D3B22;cursor:pointer;transition:all 0.2s;">
                            Hari Ini
                        </button>
                    </div>

                    <!-- Month Nav Controls -->
                    <div style="display:flex;align-items:center;gap:8px;">
                        <button type="button" id="ppb-cal-btn-prev" style="display:inline-flex;align-items:center;gap:4px;padding:7px 14px;border-radius:10px;border:1px solid #E2E8F0;background:#FAF8F5;color:#1E293B;font-size:12px;font-weight:600;cursor:pointer;transition:all 0.2s;">
                            ‹ Bulan Lalu
                        </button>
                        <button type="button" id="ppb-cal-btn-next" style="display:inline-flex;align-items:center;gap:4px;padding:7px 14px;border-radius:10px;border:1px solid #E2E8F0;background:#FAF8F5;color:#1E293B;font-size:12px;font-weight:600;cursor:pointer;transition:all 0.2s;">
                            Bulan Berikut ›
                        </button>
                    </div>
                </div>

                <!-- Calendar Legend Pills -->
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:18px;font-size:11px;font-weight:600;">
                    <span style="color:#64748B;">Legenda Sidang:</span>
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;background:#EFF6FF;color:#1E40AF;border:1px solid #BFDBFE;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#2563EB;"></span> Seminar Proposal
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;background:#FFFBEB;color:#92400E;border:1px solid #FDE68A;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#D97706;"></span> Seminar Hasil
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;background:#FAF5FF;color:#6B21A8;border:1px solid #E9D5FF;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#7C3AED;"></span> Ujian Skripsi
                    </span>
                </div>

                <!-- Calendar Day Headers (Sen s/d Min) -->
                <div style="display:grid;grid-template-columns:repeat(7, 1fr);gap:6px;text-align:center;font-size:12px;font-weight:700;color:#64748B;margin-bottom:8px;">
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;">Senin</div>
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;">Selasa</div>
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;">Rabu</div>
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;">Kamis</div>
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;">Jumat</div>
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;color:#0D3B22;">Sabtu</div>
                    <div style="background:#FAF8F5;padding:8px 4px;border-radius:8px;color:#DC2626;">Minggu</div>
                </div>

                <!-- Calendar Grid (Days Cells) -->
                <div id="ppb-cal-grid" style="display:grid;grid-template-columns:repeat(7, 1fr);gap:6px;">
                    <!-- Injected dynamically via JS -->
                </div>
            </div>

            <!-- Active Day Detailed Schedule Box -->
            <div id="ppb-cal-selected-box" style="background:#ffffff;border:1.5px solid #0D3B22;border-radius:24px;padding:24px;box-shadow:0 8px 24px -8px rgba(13,59,34,0.12);margin-bottom:24px;">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:16px;border-bottom:1px solid #F1F5F9;padding-bottom:12px;">
                    <div>
                        <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#B45309;display:block;margin-bottom:2px;">Agenda Sidang Terpilih</span>
                        <h3 id="ppb-cal-selected-date-title" style="font-family:'Fraunces',Georgia,serif;font-size:19px;font-weight:600;color:#0D3B22;margin:0;">
                            Memuat Sesi Ujian...
                        </h3>
                    </div>
                    <span id="ppb-cal-selected-count-badge" style="font-size:11px;font-weight:700;background:#E8F0EA;color:#0D3B22;padding:4px 12px;border-radius:9999px;">
                        0 Sesi
                    </span>
                </div>

                <div id="ppb-cal-selected-cards" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(340px, 1fr));gap:16px;">
                    <!-- Injected dynamically when date clicked -->
                </div>
            </div>
        </div>

        <!-- Integrated Portal SIPADU Card -->
        <div style="margin-top:36px;background:linear-gradient(135deg, #0D3B22 0%, #185333 100%);border-radius:24px;padding: clamp(24px, 4vw, 36px);color:#ffffff;box-shadow:0 12px 32px rgba(13,59,34,0.18);display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;">
            <div style="max-width:680px;">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#F5B82E;display:block;margin-bottom:6px;">
                    ✨ Ingin Mengajukan Ujian?
                </span>
                <h3 style="font-family:'Fraunces',Georgia,serif;font-size:clamp(20px, 2.8vw, 26px);font-weight:400;margin:0 0 8px 0;line-height:1.25;">
                    Pendaftaran Ujian Terintegrasi di Portal SIPADU
                </h3>
                <p style="font-size:13px;color:rgba(255,255,255,0.85);line-height:1.6;margin:0;">
                    Mahasiswa yang telah mendapatkan lembar persetujuan pembimbing dapat mengajukan berkas dan memilih slot ujian secara mandiri melalui modul SIPADU setelah masuk ke akun portal.
                </p>
            </div>
            <div>
                <a href="https://bk-connect-fipunm.vercel.app/sipadu" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:9999px;background:#F5B82E;color:#0D3B22;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(245,184,46,0.4);transition:all 0.2s;">
                    Masuk Portal SIPADU →
                </a>
            </div>
        </div>

        <!-- Client-Side Filter, Live Search & Dynamic Monthly Calendar Engine -->
        <script>
        (function(){
            const allItems = <?php echo $items_json; ?>;

            // View Switcher Elements
            const btnViewCards = document.getElementById("ppb-view-btn-cards");
            const btnViewCal   = document.getElementById("ppb-view-btn-cal");
            const boxCardsView = document.getElementById("ppb-view-cards-container");
            const boxCalView   = document.getElementById("ppb-view-cal-container");

            function setViewMode(mode) {
                if (mode === "calendar") {
                    boxCardsView.style.display = "none";
                    boxCalView.style.display = "block";
                    btnViewCal.style.background = "#0D3B22";
                    btnViewCal.style.color = "#F5B82E";
                    btnViewCards.style.background = "transparent";
                    btnViewCards.style.color = "#475569";
                    renderCalendar(calCurrentYear, calCurrentMonth);
                } else {
                    boxCalView.style.display = "none";
                    boxCardsView.style.display = "block";
                    btnViewCards.style.background = "#0D3B22";
                    btnViewCards.style.color = "#F5B82E";
                    btnViewCal.style.background = "transparent";
                    btnViewCal.style.color = "#475569";
                }
            }

            if (btnViewCards && btnViewCal) {
                btnViewCards.addEventListener("click", () => setViewMode("cards"));
                btnViewCal.addEventListener("click", () => setViewMode("calendar"));
            }

            // 1. Live Filter & Search for Card View
            const searchInput = document.getElementById("ppb-jadwal-search");
            const statusBtns  = document.querySelectorAll(".ppb-status-btn");
            const katBtns     = document.querySelectorAll(".ppb-kategori-btn");
            const cards       = document.querySelectorAll(".ppb-jadwal-card");
            const emptyState  = document.getElementById("ppb-jadwal-empty");

            let currentSearch = "";
            let currentStatus = "semua";
            let currentJenis  = "semua";

            function filterJadwal() {
                let visibleCount = 0;
                cards.forEach(card => {
                    const cJenis  = card.getAttribute("data-jenis");
                    const cStatus = card.getAttribute("data-status");
                    const cSearch = card.getAttribute("data-search");

                    const matchSearch = (currentSearch === "" || cSearch.indexOf(currentSearch) !== -1);
                    const matchStatus = (currentStatus === "semua" || cStatus === currentStatus);
                    const matchJenis  = (currentJenis === "semua" || cJenis === currentJenis);

                    if (matchSearch && matchStatus && matchJenis) {
                        card.style.display = "flex";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                });

                if (emptyState) {
                    emptyState.style.display = (visibleCount === 0) ? "block" : "none";
                }
            }

            if (searchInput) {
                searchInput.addEventListener("input", function(e) {
                    currentSearch = e.target.value.toLowerCase().trim();
                    filterJadwal();
                });
            }

            statusBtns.forEach(btn => {
                btn.addEventListener("click", function() {
                    statusBtns.forEach(b => {
                        b.classList.remove("active");
                        b.style.background = "#f1f5f9";
                        b.style.color = "#475569";
                    });
                    this.classList.add("active");
                    this.style.background = "#0D3B22";
                    this.style.color = "#ffffff";
                    currentStatus = this.getAttribute("data-status");
                    filterJadwal();
                });
            });

            katBtns.forEach(btn => {
                btn.addEventListener("click", function() {
                    katBtns.forEach(b => {
                        b.classList.remove("active");
                        b.style.background = "#f1f5f9";
                        b.style.color = "#475569";
                    });
                    this.classList.add("active");
                    this.style.background = "#F5B82E";
                    this.style.color = "#0D3B22";
                    currentJenis = this.getAttribute("data-jenis");
                    filterJadwal();
                });
            });

            // 2. Dynamic Monthly Calendar Engine
            // Auto-detect initial year & month from seeded items or fallback to today
            let calCurrentYear = 2026;
            let calCurrentMonth = 9; // 0-indexed: 9 = Oktober
            let selectedDateStr = "2026-10-26";

            if (allItems.length > 0) {
                const firstUpcoming = allItems.find(it => it.status === "terjadwal") || allItems[0];
                if (firstUpcoming && firstUpcoming.tanggal) {
                    const parts = firstUpcoming.tanggal.split("-");
                    calCurrentYear = parseInt(parts[0], 10);
                    calCurrentMonth = parseInt(parts[1], 10) - 1;
                    selectedDateStr = firstUpcoming.tanggal;
                }
            }

            const monthNamesID = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            const dayNamesID = [
                "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
            ];

            const calTitleEl     = document.getElementById("ppb-cal-title");
            const calGridEl      = document.getElementById("ppb-cal-grid");
            const calBtnPrev     = document.getElementById("ppb-cal-btn-prev");
            const calBtnNext     = document.getElementById("ppb-cal-btn-next");
            const calBtnToday    = document.getElementById("ppb-cal-btn-today");
            const selDateTitleEl = document.getElementById("ppb-cal-selected-date-title");
            const selCountEl     = document.getElementById("ppb-cal-selected-count-badge");
            const selCardsEl     = document.getElementById("ppb-cal-selected-cards");

            function renderCalendar(year, month) {
                if (!calGridEl) return;

                if (calTitleEl) {
                    calTitleEl.textContent = monthNamesID[month] + " " + year;
                }

                // Days calculation
                const firstDayIndex = new Date(year, month, 1).getDay(); // 0 = Sunday
                // Adjust for Monday start (0=Mon ... 6=Sun)
                const startDay = (firstDayIndex === 0) ? 6 : firstDayIndex - 1;
                const totalDays = new Date(year, month + 1, 0).getDate();

                let html = "";

                // Empty padding cells before 1st of month
                for (let i = 0; i < startDay; i++) {
                    html += '<div style="background:#FAF8F5;border:1px dashed #E2E8F0;border-radius:12px;min-height:95px;opacity:0.4;"></div>';
                }

                const todayObj = new Date();
                const todayStr = todayObj.getFullYear() + "-" + 
                    String(todayObj.getMonth() + 1).padStart(2, '0') + "-" + 
                    String(todayObj.getDate()).padStart(2, '0');

                // Day cells
                for (let day = 1; day <= totalDays; day++) {
                    const dayStr = String(day).padStart(2, '0');
                    const monthStr = String(month + 1).padStart(2, '0');
                    const fullDateStr = year + "-" + monthStr + "-" + dayStr;

                    const dayExams = allItems.filter(it => it.tanggal === fullDateStr);
                    const isToday = (fullDateStr === todayStr);
                    const isSelected = (fullDateStr === selectedDateStr);

                    let cellBorder = isSelected ? "2px solid #F5B82E" : "1px solid #E2E8F0";
                    let cellBg = isSelected ? "#FFFDF5" : (dayExams.length > 0 ? "#ffffff" : "#ffffff");
                    let cellShadow = isSelected ? "box-shadow:0 4px 14px rgba(245,184,46,0.35);" : "";

                    html += '<div class="ppb-cal-day-cell" data-date="' + fullDateStr + '" style="background:' + cellBg + ';border:' + cellBorder + ';border-radius:12px;min-height:95px;padding:8px;cursor:pointer;display:flex;flex-direction:column;justify-content:space-between;transition:all 0.15s;' + cellShadow + '" onclick="window.ppbSelectCalDate(\'' + fullDateStr + '\')">';
                    
                    // Day cell top bar: number + count badge
                    html += '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">';
                    if (isToday) {
                        html += '<span style="display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:50%;background:#0D3B22;color:#F5B82E;font-size:11px;font-weight:700;">' + day + '</span>';
                    } else {
                        html += '<span style="font-size:12px;font-weight:700;color:' + (dayExams.length > 0 ? '#0D3B22' : '#64748B') + ';">' + day + '</span>';
                    }

                    if (dayExams.length > 0) {
                        html += '<span style="font-size:10px;font-weight:700;background:#E8F0EA;color:#0D3B22;padding:2px 6px;border-radius:6px;">' + dayExams.length + ' Ujian</span>';
                    }
                    html += '</div>';

                    // Exam event pills inside day cell
                    html += '<div style="display:flex;flex-direction:column;gap:3px;overflow:hidden;">';
                    dayExams.slice(0, 2).forEach(ex => {
                        let pillBg = "#EFF6FF";
                        let pillColor = "#1E40AF";
                        let shortLabel = "Sempro";

                        if (ex.jenis_ujian === "seminar_hasil") {
                            pillBg = "#FFFBEB";
                            pillColor = "#92400E";
                            shortLabel = "Semhas";
                        } else if (ex.jenis_ujian === "ujian_skripsi") {
                            pillBg = "#FAF5FF";
                            pillColor = "#6B21A8";
                            shortLabel = "Skripsi";
                        }

                        html += '<div style="background:' + pillBg + ';color:' + pillColor + ';font-size:10px;font-weight:700;padding:2px 5px;border-radius:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.2;" title="' + ex.nama_mahasiswa + ' (' + shortLabel + ')">';
                        html += ex.jam_mulai + ' ' + shortLabel + ' · ' + ex.nama_mahasiswa.split(' ')[0];
                        html += '</div>';
                    });

                    if (dayExams.length > 2) {
                        html += '<div style="font-size:9px;color:#64748B;font-weight:600;padding-left:2px;">+' + (dayExams.length - 2) + ' lainnya</div>';
                    }
                    html += '</div>';

                    html += '</div>';
                }

                calGridEl.innerHTML = html;
                renderSelectedDaySchedule(selectedDateStr);
            }

            function renderSelectedDaySchedule(dateStr) {
                if (!selCardsEl) return;

                const dayExams = allItems.filter(it => it.tanggal === dateStr);
                const dateObj = new Date(dateStr + "T00:00:00");
                const dayName = dayNamesID[dateObj.getDay()] || "Hari";
                const dateNum = dateObj.getDate();
                const monthName = monthNamesID[dateObj.getMonth()] || "Bulan";
                const yearNum = dateObj.getFullYear();

                const formattedTitle = dayName + ", " + dateNum + " " + monthName + " " + yearNum;

                if (selDateTitleEl) {
                    selDateTitleEl.textContent = formattedTitle;
                }
                if (selCountEl) {
                    selCountEl.textContent = dayExams.length + " Sesi Terjadwal";
                }

                if (dayExams.length === 0) {
                    selCardsEl.innerHTML = '<div style="grid-column:1/-1;background:#FAF8F5;border:1px dashed #E2E8F0;border-radius:16px;padding:30px;text-align:center;color:#64748B;font-size:13px;">' +
                        '🍃 Belum ada jadwal seminar proposal, seminar hasil, atau ujian skripsi yang diselenggarakan pada tanggal <strong>' + formattedTitle + '</strong>.' +
                        '<div style="margin-top:6px;font-size:11px;color:#94A3B8;">Silakan klik tanggal lain yang bertanda sesi sidang pada kalender di atas.</div>' +
                    '</div>';
                    return;
                }

                let cardsHtml = "";
                dayExams.forEach(item => {
                    let badgeBg = "#EFF6FF";
                    let badgeColor = "#1E40AF";
                    let badgeBorder = "#BFDBFE";
                    let badgeLabel = "Seminar Proposal";

                    if (item.jenis_ujian === "seminar_hasil") {
                        badgeBg = "#FFFBEB";
                        badgeColor = "#92400E";
                        badgeBorder = "#FDE68A";
                        badgeLabel = "Seminar Hasil";
                    } else if (item.jenis_ujian === "ujian_skripsi") {
                        badgeBg = "#FAF5FF";
                        badgeColor = "#6B21A8";
                        badgeBorder = "#E9D5FF";
                        badgeLabel = "Ujian Skripsi (Tutup)";
                    }

                    let statusBadge = "";
                    if (item.status === "terjadwal") {
                        statusBadge = '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:9999px;background:#ECFDF5;color:#065F46;border:1px solid #A7F3D0;font-size:10px;font-weight:700;text-transform:uppercase;"><span style="width:5px;height:5px;border-radius:50%;background:#059669;"></span> Terjadwal</span>';
                    } else if (item.status === "sedang_berlangsung") {
                        statusBadge = '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:9999px;background:#FFF1F2;color:#9F1239;border:1px solid #FECDD3;font-size:10px;font-weight:700;text-transform:uppercase;"><span style="width:5px;height:5px;border-radius:50%;background:#E11D48;"></span> Berlangsung</span>';
                    } else {
                        statusBadge = '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:9999px;background:#F1F5F9;color:#475569;border:1px solid #E2E8F0;font-size:10px;font-weight:700;text-transform:uppercase;">✓ Selesai</span>';
                    }

                    cardsHtml += '<div style="background:#FAF8F5;border:1px solid #E2E8F0;border-radius:18px;padding:20px;display:flex;flex-direction:column;justify-content:space-between;">' +
                        '<div>' +
                            '<div style="display:flex;align-items:center;justify-content:space-between;gap:6px;margin-bottom:10px;">' +
                                '<span style="font-size:10px;font-weight:700;text-transform:uppercase;padding:3px 8px;border-radius:9999px;background:' + badgeBg + ';color:' + badgeColor + ';border:1px solid ' + badgeBorder + ';">' + badgeLabel + '</span>' +
                                statusBadge +
                            '</div>' +
                            '<h4 style="font-family:\'Fraunces\',Georgia,serif;font-size:16px;font-weight:600;color:#0F172A;margin:0 0 10px 0;line-height:1.35;">' + item.judul_penelitian + '</h4>' +
                            '<div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#475569;margin-bottom:12px;">' +
                                '<strong style="color:#0F172A;">🎓 ' + item.nama_mahasiswa + '</strong>' +
                                '<span style="color:#CBD5E1;">•</span>' +
                                '<span style="font-family:monospace;color:#64748B;">NIM: ' + item.nim + '</span>' +
                            '</div>' +
                            '<div style="background:#ffffff;border:1px solid #EFECE6;border-radius:10px;padding:10px;margin-bottom:12px;font-size:11px;color:#1E293B;">' +
                                '<div>⏰ <strong>Waktu:</strong> ' + item.jam_mulai + ' - ' + item.jam_selesai + ' WITA</div>' +
                                '<div style="margin-top:2px;">📍 <strong>Ruang:</strong> ' + item.ruangan + '</div>' +
                                (item.link_daring ? '<div style="margin-top:4px;"><a href="' + item.link_daring + '" target="_blank" style="color:#2563EB;font-weight:600;text-decoration:none;">📹 Tautan Sidang Zoom ↗</a></div>' : '') +
                            '</div>' +
                            '<div style="border-top:1px solid #EFECE6;padding-top:10px;display:grid;grid-template-columns:1fr 1fr;gap:8px;font-size:10px;color:#475569;">' +
                                '<div><span style="font-weight:700;color:#64748B;">PEMBIMBING:</span><br>1. ' + item.pembimbing_1 + '<br>2. ' + item.pembimbing_2 + '</div>' +
                                '<div><span style="font-weight:700;color:#64748B;">PENGUJI:</span><br>1. ' + item.penguji_1 + '<br>2. ' + item.penguji_2 + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
                });

                selCardsEl.innerHTML = cardsHtml;
            }

            window.ppbSelectCalDate = function(dateStr) {
                selectedDateStr = dateStr;
                renderCalendar(calCurrentYear, calCurrentMonth);
                const targetBox = document.getElementById("ppb-cal-selected-box");
                if (targetBox) {
                    targetBox.scrollIntoView({ behavior: "smooth", block: "nearest" });
                }
            };

            if (calBtnPrev) {
                calBtnPrev.addEventListener("click", function() {
                    calCurrentMonth--;
                    if (calCurrentMonth < 0) {
                        calCurrentMonth = 11;
                        calCurrentYear--;
                    }
                    renderCalendar(calCurrentYear, calCurrentMonth);
                });
            }

            if (calBtnNext) {
                calBtnNext.addEventListener("click", function() {
                    calCurrentMonth++;
                    if (calCurrentMonth > 11) {
                        calCurrentMonth = 0;
                        calCurrentYear++;
                    }
                    renderCalendar(calCurrentYear, calCurrentMonth);
                });
            }

            if (calBtnToday) {
                calBtnToday.addEventListener("click", function() {
                    const now = new Date();
                    calCurrentYear = now.getFullYear();
                    calCurrentMonth = now.getMonth();
                    const nowStr = calCurrentYear + "-" + 
                        String(calCurrentMonth + 1).padStart(2, '0') + "-" + 
                        String(now.getDate()).padStart(2, '0');
                    selectedDateStr = nowStr;
                    renderCalendar(calCurrentYear, calCurrentMonth);
                });
            }

            // Initial render
            renderCalendar(calCurrentYear, calCurrentMonth);
        })();
        </script>
    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_jadwal_ujian_list', 'ppb_shortcode_jadwal_ujian_list');

/* ========================================================================== */
/* 8. SHORTCODE: KURIKULUM OBE, DAFTAR MK, RPS LENGKAP & RUBRIK PENILAIAN    */
/* ========================================================================== */
if (!function_exists('ppb_shortcode_kurikulum_rps_sap')) {
function ppb_shortcode_kurikulum_rps_sap($atts = []) {
    ob_start();
    ?>
    <section class="ppb-kurikulum-suite" style="font-family:'Poppins',sans-serif;color:#1F2937;margin:30px 0;">
        
        <!-- Tab Navigation Bar -->
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:25px;border-bottom:2px solid #E5E7EB;padding-bottom:12px;">
            <button type="button" class="ppb-cur-tab-btn is-active" data-tab="tab-mk" style="padding:10px 20px;border-radius:10px;border:none;background:#0D3B22;color:#ffffff;font-size:13.5px;font-weight:700;cursor:pointer;transition:all 0.2s;">
                📚 Struktur Mata Kuliah (Sem 1–8)
            </button>
            <button type="button" class="ppb-cur-tab-btn" data-tab="tab-rps" style="padding:10px 20px;border-radius:10px;border:1px solid #D1D5DB;background:#ffffff;color:#374151;font-size:13.5px;font-weight:600;cursor:pointer;transition:all 0.2s;">
                📑 Repositori RPS Lengkap
            </button>
            <button type="button" class="ppb-cur-tab-btn" data-tab="tab-sap" style="padding:10px 20px;border-radius:10px;border:1px solid #D1D5DB;background:#ffffff;color:#374151;font-size:13.5px;font-weight:600;cursor:pointer;transition:all 0.2s;">
                🗓️ SAP (Satuan Acara Perkuliahan)
            </button>
            <button type="button" class="ppb-cur-tab-btn" data-tab="tab-rubrik" style="padding:10px 20px;border-radius:10px;border:1px solid #D1D5DB;background:#ffffff;color:#374151;font-size:13.5px;font-weight:600;cursor:pointer;transition:all 0.2s;">
                ⚖️ Rubrik Penilaian OBE
            </button>
        </div>

        <!-- Tab 1: Struktur Mata Kuliah per Semester -->
        <div id="tab-mk" class="ppb-cur-pane" style="display:block;">
            <div style="background:#FAF8F5;border:1px solid #D4E3D8;border-radius:16px;padding:24px;margin-bottom:25px;">
                <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#0D3B22;margin:0 0 8px;">
                    Daftar Mata Kuliah Kurikulum OBE 2025 (144 SKS)
                </h3>
                <p style="font-size:13px;color:#4B5563;margin:0;line-height:1.6;">
                    Kurikulum Program Studi Bimbingan dan Konseling FIP UNM mengacu pada Kerangka Kualifikasi Nasional Indonesia (KKNI Level 6) dan Standar Asosiasi Bimbingan dan Konseling Indonesia (ABKIN).
                </p>
            </div>

            <?php
            $semesters = [
                1 => [
                    ['kode' => 'UNM101', 'nama' => 'Pendidikan Pancasila & Kewarganegaraan', 'sks' => 2, 'jenis' => 'Wajib Universitas'],
                    ['kode' => 'FIP102', 'nama' => 'Pengantar Ilmu Pendidikan', 'sks' => 3, 'jenis' => 'Wajib Fakultas'],
                    ['kode' => 'BK101', 'nama' => 'Dasar-Dasar Bimbingan dan Konseling', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK102', 'nama' => 'Psikologi Umum & Perkembangan Individu', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK103', 'nama' => 'Filsafat Pendidikan & Antropologi Budaya', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK104', 'nama' => 'Komunikasi Antarpribadi dalam Konseling', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'UNM102', 'nama' => 'Bahasa Indonesia Keilmuan', 'sks' => 2, 'jenis' => 'Wajib Universitas'],
                ],
                2 => [
                    ['kode' => 'BK201', 'nama' => 'Teori-Teori Kepribadian', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK202', 'nama' => 'Pemahaman Individu Teknik Non-Tes', 'sks' => 3, 'jenis' => 'Wajib Prodi / Praktik'],
                    ['kode' => 'BK203', 'nama' => 'Keterampilan Dasar Konseling (Attending & Empathy)', 'sks' => 3, 'jenis' => 'Wajib Prodi / Praktik'],
                    ['kode' => 'BK204', 'nama' => 'Profesi Bimbingan dan Konseling & Etika Konselor', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK205', 'nama' => 'Statistika Deskriptif untuk Pendidikan', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'FIP201', 'nama' => 'Perkembangan Belajar Peserta Didik', 'sks' => 2, 'jenis' => 'Wajib Fakultas'],
                    ['kode' => 'UNM201', 'nama' => 'Bahasa Inggris Akademik & Konseling', 'sks' => 2, 'jenis' => 'Wajib Universitas'],
                ],
                3 => [
                    ['kode' => 'BK301', 'nama' => 'Teori & Pendekatan Konseling Individual', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK302', 'nama' => 'Pemahaman Individu Teknik Tes (Asesmen Psikologi)', 'sks' => 3, 'jenis' => 'Wajib Prodi / Lab'],
                    ['kode' => 'BK303', 'nama' => 'Dinamika Kelompok & Bimbingan Kelompok', 'sks' => 3, 'jenis' => 'Wajib Prodi / Praktik'],
                    ['kode' => 'BK304', 'nama' => 'Pengembangan Program BK Komprehensif di Sekolah', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK305', 'nama' => 'Statistika Inferensial untuk Riset Pendidikan', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK306', 'nama' => 'Kesehatan Mental & Pertolongan Pertama Psikologis', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                ],
                4 => [
                    ['kode' => 'BK401', 'nama' => 'Praktikum Konseling Individual (Micro-Counseling)', 'sks' => 3, 'jenis' => 'Wajib Prodi / Lab'],
                    ['kode' => 'BK402', 'nama' => 'Konseling Kelompok & Intervensi Psikososial', 'sks' => 3, 'jenis' => 'Wajib Prodi / Lab'],
                    ['kode' => 'BK403', 'nama' => 'Bimbingan dan Konseling Karir Komprehensif', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK404', 'nama' => 'Media & Teknologi Informasi dalam BK', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK405', 'nama' => 'Metodologi Penelitian Bimbingan dan Konseling', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK406', 'nama' => 'Konseling Lintas Budaya & Nilai-Nilai Kearifan Lokal', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK407', 'nama' => 'Pendidikan Inklusi & Kebutuhan Khusus', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                ],
                5 => [
                    ['kode' => 'BK501', 'nama' => 'Konseling Keluarga & Pengasuhan Anak', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK502', 'nama' => 'Manajemen & Organisasi Layanan BK', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK503', 'nama' => 'Evaluasi & Akuntabilitas Program BK', 'sks' => 3, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK504', 'nama' => 'Praktikum Asesmen & Diagnostik Kesulitan Belajar', 'sks' => 3, 'jenis' => 'Wajib Prodi / Lab'],
                    ['kode' => 'BK505', 'nama' => 'Konseling Krisis, Trauma & Bencana', 'sks' => 3, 'jenis' => 'Pilihan Keahlian'],
                    ['kode' => 'BK506', 'nama' => 'Kewirausahaan Layanan Konseling & Edukasi', 'sks' => 2, 'jenis' => 'Wajib Universitas'],
                    ['kode' => 'BK507', 'nama' => 'Pencegahan & Penanganan Kekerasan di Sekolah', 'sks' => 2, 'jenis' => 'Pilihan Keahlian'],
                ],
                6 => [
                    ['kode' => 'BK601', 'nama' => 'Praktik Lapangan BK Persekolahan (PPL/Magang I)', 'sks' => 4, 'jenis' => 'Wajib Lapangan / MBKM'],
                    ['kode' => 'BK602', 'nama' => 'Seminar Proposal Penelitian Skripsi BK', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'BK603', 'nama' => 'Konseling Komunitas & Pemberdayaan Sosial', 'sks' => 3, 'jenis' => 'Pilihan Keahlian'],
                    ['kode' => 'BK604', 'nama' => 'Studi Kasus Klinis & Supervisi Konseling', 'sks' => 3, 'jenis' => 'Wajib Prodi / Lab'],
                    ['kode' => 'BK605', 'nama' => 'Teknologi Asesmen Digital & BK Connect', 'sks' => 2, 'jenis' => 'Pilihan Keahlian'],
                    ['kode' => 'BK606', 'nama' => 'Publikasi Ilmiah & Penulisan Artikel Jurnal', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                ],
                7 => [
                    ['kode' => 'BK701', 'nama' => 'Praktik Kerja Lapangan MBKM / PPL Terpadu II', 'sks' => 6, 'jenis' => 'Wajib Lapangan / MBKM'],
                    ['kode' => 'BK702', 'nama' => 'Proyek Kemanusiaan & Pengabdian Masyarakat', 'sks' => 4, 'jenis' => 'Pilihan MBKM'],
                    ['kode' => 'BK703', 'nama' => 'Kapita Selekta Bimbingan dan Konseling Kontemporer', 'sks' => 2, 'jenis' => 'Wajib Prodi'],
                    ['kode' => 'UNM701', 'nama' => 'Kuliah Kerja Nyata (KKN) Tematik / Reguler', 'sks' => 4, 'jenis' => 'Wajib Universitas'],
                ],
                8 => [
                    ['kode' => 'BK801', 'nama' => 'Skripsi / Tugas Akhir Karya Ilmiah', 'sks' => 6, 'jenis' => 'Wajib Kelulusan'],
                    ['kode' => 'BK802', 'nama' => 'Ujian Komprehensif Keahlian Konseling', 'sks' => 0, 'jenis' => 'Prasyarat Yudisium'],
                ]
            ];
            ?>

            <div style="display:flex;flex-direction:column;gap:18px;">
                <?php foreach ($semesters as $sem => $mks) : 
                    $total_sks = array_sum(array_column($mks, 'sks'));
                ?>
                    <div style="background:#ffffff;border:1px solid #E5E7EB;border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                        <div style="background:#0D3B22;color:#ffffff;padding:12px 20px;display:flex;justify-content:space-between;align-items:center;">
                            <strong style="font-size:14px;letter-spacing:0.02em;">Semester <?php echo $sem; ?></strong>
                            <span style="font-size:12px;background:rgba(245,184,46,0.25);color:#F5B82E;padding:2px 10px;border-radius:6px;font-weight:700;">Total: <?php echo $total_sks; ?> SKS</span>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width:100%;border-collapse:collapse;font-size:13px;text-align:left;">
                                <thead>
                                    <tr style="background:#F9FAFB;border-bottom:1px solid #E5E7EB;color:#6B7280;font-size:11.5px;text-transform:uppercase;">
                                        <th style="padding:10px 16px;">Kode MK</th>
                                        <th style="padding:10px 16px;">Nama Mata Kuliah</th>
                                        <th style="padding:10px 16px;text-align:center;">Bobot SKS</th>
                                        <th style="padding:10px 16px;">Kelompok / Sifat</th>
                                        <th style="padding:10px 16px;text-align:center;">Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mks as $mk) : ?>
                                        <tr style="border-bottom:1px solid #F3F4F6;">
                                            <td style="padding:10px 16px;font-family:monospace;font-weight:700;color:#0D3B22;"><?php echo esc_html($mk['kode']); ?></td>
                                            <td style="padding:10px 16px;font-weight:600;color:#1F2937;"><?php echo esc_html($mk['nama']); ?></td>
                                            <td style="padding:10px 16px;text-align:center;font-weight:700;color:#0D3B22;"><?php echo (int)$mk['sks']; ?></td>
                                            <td style="padding:10px 16px;color:#4B5563;font-size:12px;"><?php echo esc_html($mk['jenis']); ?></td>
                                            <td style="padding:10px 16px;text-align:center;">
                                                <a href="#tab-rps" onclick="window.ppbSwitchCurTab('tab-rps')" style="font-size:11px;font-weight:700;color:#0D3B22;background:#E8F0EA;padding:3px 8px;border-radius:4px;text-decoration:none;">RPS/SAP &rarr;</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab 2: Repositori RPS Lengkap -->
        <div id="tab-rps" class="ppb-cur-pane" style="display:none;">
            <div style="background:#FAF8F5;border:1px solid #D4E3D8;border-radius:16px;padding:24px;margin-bottom:25px;">
                <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#0D3B22;margin:0 0 8px;">
                    Rencana Pembelajaran Semester (RPS) Terstandar OBE
                </h3>
                <p style="font-size:13px;color:#4B5563;margin:0;line-height:1.6;">
                    Dokumen RPS memuat Capaian Pembelajaran Lulusan (CPL), Capaian Pembelajaran Mata Kuliah (CPMK), deskripsi bahan kajian, metode perkuliahan partisipatif/case-method/team-based project, dan sistem penilaian.
                </p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:18px;">
                <?php
                $rps_list = [
                    ['kode' => 'BK101', 'nama' => 'Dasar-Dasar Bimbingan dan Konseling', 'dosen' => 'Dr. Farida Aryani, M.Pd. / Tim', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK203', 'nama' => 'Keterampilan Dasar Konseling', 'dosen' => 'Prof. Dr. H. Alimuddin Mahmud, M.Pd.', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK301', 'nama' => 'Teori & Pendekatan Konseling Individual', 'dosen' => 'Dr. Abdullah Pandang, M.Pd.', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK302', 'nama' => 'Asesmen Psikologi & Pemahaman Individu', 'dosen' => 'Dra. Hj. Sitti Halimah, M.Pd.', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK401', 'nama' => 'Praktikum Micro-Counseling', 'dosen' => 'Pakar & Tim Laboratorium BK', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK403', 'nama' => 'Bimbingan dan Konseling Karir Komprehensif', 'dosen' => 'Dr. H. Sulaiman, M.Pd.', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK405', 'nama' => 'Metodologi Penelitian BK & Skripsi', 'dosen' => 'Prof. Dr. Syamsul Bachri Thalib, M.Si.', 'rev' => 'Revisi 2024'],
                    ['kode' => 'BK501', 'nama' => 'Konseling Keluarga & Krisis Psikososial', 'dosen' => 'Dr. Muhammad Anas, M.Si.', 'rev' => 'Revisi 2024']
                ];
                foreach ($rps_list as $r) : ?>
                    <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:14px;padding:20px;box-shadow:0 3px 10px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:space-between;">
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span style="font-family:monospace;font-size:11px;font-weight:700;color:#0D3B22;background:#E8F0EA;padding:2px 8px;border-radius:4px;"><?php echo esc_html($r['kode']); ?></span>
                                <span style="font-size:11px;color:#059669;font-weight:600;"><?php echo esc_html($r['rev']); ?></span>
                            </div>
                            <h4 style="font-size:15px;font-weight:700;color:#0D3B22;margin:0 0 6px;line-height:1.4;"><?php echo esc_html($r['nama']); ?></h4>
                            <p style="font-size:12px;color:#6B7280;margin:0 0 14px;">Koordinator: <?php echo esc_html($r['dosen']); ?></p>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <a href="#" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:12px;font-weight:600;padding:8px 12px;border-radius:8px;text-decoration:none;">📄 Unduh RPS PDF</a>
                            <a href="#" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:12px;font-weight:600;padding:8px 12px;border-radius:8px;text-decoration:none;">Detail CPMK</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab 3: SAP (Satuan Acara Perkuliahan) -->
        <div id="tab-sap" class="ppb-cur-pane" style="display:none;">
            <div style="background:#FAF8F5;border:1px solid #D4E3D8;border-radius:16px;padding:24px;margin-bottom:25px;">
                <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#0D3B22;margin:0 0 8px;">
                    Satuan Acara Perkuliahan (SAP) Mingguan
                </h3>
                <p style="font-size:13px;color:#4B5563;margin:0;line-height:1.6;">
                    Panduan operasional tatap muka per minggu (16 minggu perkuliahan termasuk UTS dan UAS) yang menjabarkan aktivitas dosen dan mahasiswa, media ajar, dan instrumen asesmen harian.
                </p>
            </div>
            <div style="background:#ffffff;border:1px solid #E5E7EB;border-radius:14px;padding:24px;box-shadow:0 2px 10px rgba(0,0,0,0.03);">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <strong style="color:#0D3B22;font-size:16px;">Contoh Matriks 16 Pertemuan SAP (Mata Kuliah Inti)</strong>
                    <span style="font-size:12px;color:#6B7280;">Standar Akreditasi LAMDIK Kriteria 6</span>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));gap:12px;">
                    <div style="background:#F9FAFB;padding:12px;border-radius:8px;border:1px solid #E5E7EB;"><strong style="font-size:12px;color:#0D3B22;display:block;">Minggu 1–2:</strong><span style="font-size:12px;color:#4B5563;">Orientasi CPL, CPMK, Kontrak Kuliah &amp; Konsep Fondasi</span></div>
                    <div style="background:#F9FAFB;padding:12px;border-radius:8px;border:1px solid #E5E7EB;"><strong style="font-size:12px;color:#0D3B22;display:block;">Minggu 3–7:</strong><span style="font-size:12px;color:#4B5563;">Kajian Teori Mendalam, Studi Kasus (Case Method) &amp; Diskusi</span></div>
                    <div style="background:#FEF3C7;padding:12px;border-radius:8px;border:1px solid #FCD34D;"><strong style="font-size:12px;color:#92400E;display:block;">Minggu 8:</strong><span style="font-size:12px;color:#78350F;">Evaluasi Tengah Semester (UTS) / Tes Penguasaan Konsep</span></div>
                    <div style="background:#F9FAFB;padding:12px;border-radius:8px;border:1px solid #E5E7EB;"><strong style="font-size:12px;color:#0D3B22;display:block;">Minggu 9–14:</strong><span style="font-size:12px;color:#4B5563;">Praktikum Simulasi, Team-Based Project &amp; Penyusunan Portofolio</span></div>
                    <div style="background:#F9FAFB;padding:12px;border-radius:8px;border:1px solid #E5E7EB;"><strong style="font-size:12px;color:#0D3B22;display:block;">Minggu 15:</strong><span style="font-size:12px;color:#4B5563;">Gelar Karya / Presentasi Laporan Proyek Konseling</span></div>
                    <div style="background:#DCFCE7;padding:12px;border-radius:8px;border:1px solid #86EFAC;"><strong style="font-size:12px;color:#166534;display:block;">Minggu 16:</strong><span style="font-size:12px;color:#14532D;">Evaluasi Akhir Semester (UAS) / Uji Keterampilan Portofolio</span></div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Rubrik Penilaian OBE -->
        <div id="tab-rubrik" class="ppb-cur-pane" style="display:none;">
            <div style="background:#FAF8F5;border:1px solid #D4E3D8;border-radius:16px;padding:24px;margin-bottom:25px;">
                <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#0D3B22;margin:0 0 8px;">
                    Rubrik Penilaian Holistik &amp; Analitik Outcome-Based Education (OBE)
                </h3>
                <p style="font-size:13px;color:#4B5563;margin:0;line-height:1.6;">
                    Sistem evaluasi pembelajaran BK UNM mengedepankan penilaian autentik dengan rubrik terstandar untuk mengukur keterampilan konseling praktis, partisipasi aktif, dan etika profesional.
                </p>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:20px;">
                <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:14px;padding:22px;">
                    <h4 style="color:#0D3B22;font-size:16px;font-weight:700;margin:0 0 10px;">Rubrik Kinerja Simulasi Konseling</h4>
                    <ul style="font-size:13px;color:#4B5563;line-height:1.8;padding-left:20px;margin:0 0 16px;">
                        <li>Keterampilan attending &amp; kontak mata (Bobot 20%)</li>
                        <li>Empati primer &amp; respon reflektif (Bobot 25%)</li>
                        <li>Teknik questioning &amp; eksplorasi masalah (Bobot 20%)</li>
                        <li>Perumusan tujuan intervensi (Bobot 20%)</li>
                        <li>Etika kerahasiaan &amp; terminasi sesi (Bobot 15%)</li>
                    </ul>
                    <a href="#" style="display:inline-block;background:#0D3B22;color:#ffffff;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;text-decoration:none;">Unduh Lembar Rubrik &rarr;</a>
                </div>

                <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:14px;padding:22px;">
                    <h4 style="color:#0D3B22;font-size:16px;font-weight:700;margin:0 0 10px;">Rubrik Penilaian Team-Based Project</h4>
                    <ul style="font-size:13px;color:#4B5563;line-height:1.8;padding-left:20px;margin:0 0 16px;">
                        <li>Ketepatan analisis kebutuhan (need assessment) (Bobot 25%)</li>
                        <li>Kreativitas inovasi modul/media BK (Bobot 30%)</li>
                        <li>Kolaborasi tim &amp; pembagian kerja (Bobot 20%)</li>
                        <li>Kualitas laporan &amp; video dokumentasi (Bobot 25%)</li>
                    </ul>
                    <a href="#" style="display:inline-block;background:#0D3B22;color:#ffffff;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;text-decoration:none;">Unduh Lembar Rubrik &rarr;</a>
                </div>
            </div>
        </div>

        <script>
        window.ppbSwitchCurTab = function(tabId) {
            document.querySelectorAll('.ppb-cur-pane').forEach(function(p) { p.style.display = 'none'; });
            document.querySelectorAll('.ppb-cur-tab-btn').forEach(function(b) {
                b.style.background = '#ffffff';
                b.style.color = '#374151';
                b.style.border = '1px solid #D1D5DB';
            });
            var target = document.getElementById(tabId);
            if (target) target.style.display = 'block';
            var btn = document.querySelector('.ppb-cur-tab-btn[data-tab="' + tabId + '"]');
            if (btn) {
                btn.style.background = '#0D3B22';
                btn.style.color = '#ffffff';
                btn.style.border = 'none';
            }
        };
        document.querySelectorAll('.ppb-cur-tab-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var tab = this.getAttribute('data-tab');
                window.ppbSwitchCurTab(tab);
            });
        });
        </script>
    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_kurikulum_rps_sap', 'ppb_shortcode_kurikulum_rps_sap');

/* ========================================================================== */
/* 9. SHORTCODE: MIS PNBP (HIBAH PENELITIAN & PENGABDIAN MASYARAKAT)           */
/* ========================================================================== */
if (!function_exists('ppb_shortcode_mis_pnbp')) {
function ppb_shortcode_mis_pnbp($atts = []) {
    ob_start();
    ?>
    <section class="ppb-mis-pnbp-wrapper" style="font-family:'Poppins',sans-serif;color:#1F2937;margin:30px 0;">
        
        <!-- Header Banner MIS PNBP -->
        <div style="background:#0D3B22;color:#ffffff;border-radius:20px;padding:30px;margin-bottom:30px;box-shadow:0 8px 25px rgba(13,59,34,0.15);">
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,184,46,0.2);color:#F5B82E;padding:4px 14px;border-radius:999px;font-size:11px;font-weight:700;text-transform:uppercase;margin-bottom:12px;border:1px solid rgba(245,184,46,0.35);">
                <span>Kriteria 7 &amp; 8 LAMDIK / BAN-PT</span>
            </div>
            <h2 style="font-family:'Fraunces',Georgia,serif;font-size:clamp(22px, 3vw, 30px);color:#ffffff;margin:0 0 10px;font-weight:600;">
                MIS PNBP: Manajemen Informasi Hibah Penelitian &amp; Pengabdian Masyarakat
            </h2>
            <p style="color:rgba(255,255,255,0.85);font-size:14px;max-width:760px;margin:0;line-height:1.6;">
                Pusat data transparansi pendanaan riset keilmuan dan hilirisasi pengabdian kepada masyarakat (PkM) civitas akademika Program Studi Bimbingan dan Konseling berbasis skema Pendapatan Negara Bukan Pajak (PNBP) UNM.
            </p>
        </div>

        <!-- Tab Selector -->
        <div style="display:flex;gap:12px;margin-bottom:25px;">
            <button type="button" class="ppb-pnbp-btn is-active" data-pnbp="pane-riset" style="padding:11px 22px;border-radius:12px;border:none;background:#0D3B22;color:#ffffff;font-size:14px;font-weight:700;cursor:pointer;">
                🔬 Hibah Penelitian PNBP
            </button>
            <button type="button" class="ppb-pnbp-btn" data-pnbp="pane-pkm" style="padding:11px 22px;border-radius:12px;border:1px solid #D1D5DB;background:#ffffff;color:#374151;font-size:14px;font-weight:600;cursor:pointer;">
                🤝 Pengabdian kepada Masyarakat (PkM) PNBP
            </button>
        </div>

        <!-- Pane 1: Hibah Penelitian PNBP -->
        <div id="pane-riset" class="ppb-pnbp-pane" style="display:block;">
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;">
                <?php
                $riset_list = [
                    [
                        'judul' => 'Model Bimbingan dan Konseling Komprehensif Berbasis Nilai Siri’ na Pacce untuk Mereduksi Perilaku Cyberbullying Siswa SMA di Makassar',
                        'ketua' => 'Dr. Farida Aryani, M.Pd.',
                        'anggota' => 'Prof. Dr. H. Alimuddin Mahmud, M.Pd. & 2 Mahasiswa',
                        'skema' => 'Penelitian Terapan Unggulan UNM (PNBP)',
                        'tahun' => '2024',
                        'dana' => 'Rp 45.000.000',
                        'luaran' => 'Jurnal Internasional Bereputasi & HKI Modul'
                    ],
                    [
                        'judul' => 'Pengembangan Sistem Asesmen Digital BK Connect untuk Diagnostik Dini Problem Kesejahteraan Psikologis Remaja Berbasis Web',
                        'ketua' => 'Dr. Abdullah Pandang, M.Pd.',
                        'anggota' => 'Dr. Muhammad Anas, M.Si. & 3 Mahasiswa',
                        'skema' => 'Penelitian Pengembangan Institusional (PNBP)',
                        'tahun' => '2024',
                        'dana' => 'Rp 50.000.000',
                        'luaran' => 'Aplikasi Web Ber-HKI & Prosiding Internasional'
                    ],
                    [
                        'judul' => 'Efektivitas Konseling Kelompok Cognitive Behavior Therapy (CBT) Teknik Cognitive Restructuring terhadap Academic Burnout Mahasiswa',
                        'ketua' => 'Prof. Dr. Syamsul Bachri Thalib, M.Si.',
                        'anggota' => 'Dra. Hj. Sitti Halimah, M.Pd. & 2 Mahasiswa',
                        'skema' => 'Penelitian Dasar Kolaboratif (PNBP)',
                        'tahun' => '2023',
                        'dana' => 'Rp 35.000.000',
                        'luaran' => 'Jurnal Nasional Terakreditasi SINTA 2'
                    ]
                ];
                foreach ($riset_list as $r) : ?>
                    <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:space-between;">
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span style="font-size:11px;font-weight:700;background:#E8F0EA;color:#0D3B22;padding:3px 8px;border-radius:4px;"><?php echo esc_html($r['skema']); ?></span>
                                <span style="font-size:12px;font-weight:700;color:#059669;"><?php echo esc_html($r['tahun']); ?></span>
                            </div>
                            <h4 style="font-size:15px;font-weight:700;color:#0D3B22;margin:0 0 10px;line-height:1.4;"><?php echo esc_html($r['judul']); ?></h4>
                            <div style="font-size:12.5px;color:#4B5563;line-height:1.6;margin-bottom:12px;">
                                <div><strong>Ketua Peneliti:</strong> <?php echo esc_html($r['ketua']); ?></div>
                                <div><strong>Kolaborator:</strong> <?php echo esc_html($r['anggota']); ?></div>
                                <div><strong>Dana Hibah:</strong> <?php echo esc_html($r['dana']); ?></div>
                            </div>
                        </div>
                        <div style="font-size:12px;background:#FAF8F5;border:1px solid #E2E8F0;padding:8px 12px;border-radius:8px;color:#0D3B22;font-weight:600;">
                            🎯 Luaran: <?php echo esc_html($r['luaran']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pane 2: PkM PNBP -->
        <div id="pane-pkm" class="ppb-pnbp-pane" style="display:none;">
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;">
                <?php
                $pkm_list = [
                    [
                        'judul' => 'Peningkatan Kompetensi Guru Bimbingan dan Konseling dalam Penerapan Asesmen Psikososial Digital Siswa Pasca Pandemi di Kabupaten Gowa',
                        'ketua' => 'Dr. Farida Aryani, M.Pd.',
                        'mitra' => 'Musyawarah Guru Bimbingan dan Konseling (MGBK) SMP/SMA Gowa',
                        'skema' => 'Program Kemitraan Masyarakat (PKM-PNBP)',
                        'tahun' => '2024',
                        'dana' => 'Rp 30.000.000',
                        'luaran' => 'Video Kegiatan, Modul Pelatihan, Publikasi Jurnal PkM'
                    ],
                    [
                        'judul' => 'Pendampingan Konseling Sebaya (Peer Counseling) untuk Pencegahan Kekerasan Seksual & Bullying di Pesantren Wilayah Maros',
                        'ketua' => 'Dr. H. Sulaiman, M.Pd.',
                        'mitra' => 'Pondok Pesantren & Komunitas Remaja Sebaya',
                        'skema' => 'Program Pengabdian Desa Binaan (PNBP)',
                        'tahun' => '2024',
                        'dana' => 'Rp 35.000.000',
                        'luaran' => 'Buku Panduan Kader Sebaya & Berita Media Massa'
                    ],
                    [
                        'judul' => 'Pelatihan Terapi Relaksasi dan Manajemen Emosi bagi Konselor Sekolah Inklusif di Kota Makassar',
                        'ketua' => 'Dra. Hj. Sitti Halimah, M.Pd.',
                        'mitra' => 'Forum Guru Inklusi & SLB Negeri 1 Makassar',
                        'skema' => 'Program Kemitraan Masyarakat (PKM-PNBP)',
                        'tahun' => '2023',
                        'dana' => 'Rp 25.000.000',
                        'luaran' => 'Jurnal Pengabdian Nasional & HKI Panduan'
                    ]
                ];
                foreach ($pkm_list as $p) : ?>
                    <div style="background:#ffffff;border:1px solid #D4E3D8;border-radius:16px;padding:22px;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:space-between;">
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span style="font-size:11px;font-weight:700;background:#FEF3C7;color:#92400E;padding:3px 8px;border-radius:4px;"><?php echo esc_html($p['skema']); ?></span>
                                <span style="font-size:12px;font-weight:700;color:#059669;"><?php echo esc_html($p['tahun']); ?></span>
                            </div>
                            <h4 style="font-size:15px;font-weight:700;color:#0D3B22;margin:0 0 10px;line-height:1.4;"><?php echo esc_html($p['judul']); ?></h4>
                            <div style="font-size:12.5px;color:#4B5563;line-height:1.6;margin-bottom:12px;">
                                <div><strong>Ketua Pelaksana:</strong> <?php echo esc_html($p['ketua']); ?></div>
                                <div><strong>Mitra Kegiatan:</strong> <?php echo esc_html($p['mitra']); ?></div>
                                <div><strong>Dana PNBP:</strong> <?php echo esc_html($p['dana']); ?></div>
                            </div>
                        </div>
                        <div style="font-size:12px;background:#FAF8F5;border:1px solid #E2E8F0;padding:8px 12px;border-radius:8px;color:#0D3B22;font-weight:600;">
                            🎯 Luaran: <?php echo esc_html($p['luaran']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <script>
        document.querySelectorAll('.ppb-pnbp-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var target = this.getAttribute('data-pnbp');
                document.querySelectorAll('.ppb-pnbp-pane').forEach(function(pane) { pane.style.display = 'none'; });
                document.querySelectorAll('.ppb-pnbp-btn').forEach(function(b) {
                    b.style.background = '#ffffff';
                    b.style.color = '#374151';
                    b.style.border = '1px solid #D1D5DB';
                });
                var activePane = document.getElementById(target);
                if (activePane) activePane.style.display = 'block';
                this.style.background = '#0D3B22';
                this.style.color = '#ffffff';
                this.style.border = 'none';
            });
        });
        </script>
    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_mis_pnbp', 'ppb_shortcode_mis_pnbp');

/* ========================================================================== */
/* 10. SHORTCODE: JURNAL & PENGABDIAN YANG DIKELOLA PRODI BK                  */
/* ========================================================================== */
if (!function_exists('ppb_shortcode_jurnal_bk')) {
function ppb_shortcode_jurnal_bk($atts = []) {
    ob_start();
    ?>
    <section class="ppb-jurnal-wrapper" style="font-family:'Poppins',sans-serif;color:#1F2937;margin:30px 0;">
        
        <div style="background:#0D3B22;color:#ffffff;border-radius:20px;padding:30px;margin-bottom:30px;box-shadow:0 8px 25px rgba(13,59,34,0.15);">
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,184,46,0.2);color:#F5B82E;padding:4px 14px;border-radius:999px;font-size:11px;font-weight:700;text-transform:uppercase;margin-bottom:12px;border:1px solid rgba(245,184,46,0.35);">
                <span>Publikasi Ilmiah &amp; Diseminasi Riset</span>
            </div>
            <h2 style="font-family:'Fraunces',Georgia,serif;font-size:clamp(22px, 3vw, 30px);color:#ffffff;margin:0 0 10px;font-weight:600;">
                Jurnal &amp; Pengabdian yang Dikelola Program Studi Bimbingan dan Konseling
            </h2>
            <p style="color:rgba(255,255,255,0.85);font-size:14px;max-width:760px;margin:0;line-height:1.6;">
                Dua jurnal peer-reviewed resmi yang memuat karya riset empiris dan artikel pengabdian masyarakat di bidang bimbingan, konseling, dan psikologi pendidikan terapan.
            </p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:24px;">
            
            <!-- Jurnal 1: JBK -->
            <div style="background:#ffffff;border:1.5px solid #D4E3D8;border-radius:18px;padding:26px;box-shadow:0 6px 20px rgba(0,0,0,0.04);display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <span style="background:#DCFCE7;color:#166534;font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:6px;border:1px solid #86EFAC;">
                            🏅 Terakreditasi SINTA 3
                        </span>
                        <span style="font-size:12px;color:#6B7280;font-weight:600;">e-ISSN: 2580-0442</span>
                    </div>
                    <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#0D3B22;margin:0 0 10px;line-height:1.3;">
                        Jurnal Bimbingan dan Konseling (JBK)
                    </h3>
                    <p style="font-size:13.5px;color:#4B5563;line-height:1.6;margin:0 0 16px;">
                        Jurnal ilmiah berkala yang mempublikasikan hasil penelitian orisinal mengenai teori konseling, asesmen psikologis, intervensi perilaku, dan konseling lintas budaya.
                    </p>
                    <div style="font-size:12.5px;background:#FAF8F5;padding:12px 14px;border-radius:10px;border:1px solid #E5E7EB;margin-bottom:18px;line-height:1.6;color:#374151;">
                        <div><strong>Penerbit:</strong> Jurusan PPB / Prodi BK FIP UNM</div>
                        <div><strong>Frekuensi:</strong> 2 Kali Setahun (Juni &amp; Desember)</div>
                        <div><strong>Pengindeks:</strong> SINTA, Google Scholar, Garuda, Crossref (DOI)</div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="https://ojs.unm.ac.id/JBK" target="_blank" rel="noopener" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:13px;font-weight:700;padding:11px 16px;border-radius:10px;text-decoration:none;">
                        Kunjungi Portal Jurnal OJS &rarr;
                    </a>
                    <a href="https://ojs.unm.ac.id/JBK/about/submissions" target="_blank" rel="noopener" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:13px;font-weight:600;padding:11px 14px;border-radius:10px;text-decoration:none;">
                        Pedoman Submit
                    </a>
                </div>
            </div>

            <!-- Jurnal 2: Jurnal Pengabdian Konseling Nusantara (JPKN) -->
            <div style="background:#ffffff;border:1.5px solid #D4E3D8;border-radius:18px;padding:26px;box-shadow:0 6px 20px rgba(0,0,0,0.04);display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <span style="background:#FEF3C7;color:#92400E;font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:6px;border:1px solid #FCD34D;">
                            🏅 Terindeks SINTA 4 / Garuda
                        </span>
                        <span style="font-size:12px;color:#6B7280;font-weight:600;">e-ISSN: 2775-8915</span>
                    </div>
                    <h3 style="font-family:'Fraunces',Georgia,serif;font-size:20px;color:#0D3B22;margin:0 0 10px;line-height:1.3;">
                        Jurnal Pengabdian Konseling Nusantara (JPKN)
                    </h3>
                    <p style="font-size:13.5px;color:#4B5563;line-height:1.6;margin:0 0 16px;">
                        Media diseminasi aksi nyata pengabdian kepada masyarakat, pendampingan konseling sekolah, pemberdayaan komunitas rentan, dan pelatihan kesehatan mental.
                    </p>
                    <div style="font-size:12.5px;background:#FAF8F5;padding:12px 14px;border-radius:10px;border:1px solid #E5E7EB;margin-bottom:18px;line-height:1.6;color:#374151;">
                        <div><strong>Penerbit:</strong> Prodi BK FIP bekerjasama dengan LP2M UNM</div>
                        <div><strong>Frekuensi:</strong> 2 Kali Setahun (April &amp; Oktober)</div>
                        <div><strong>Pengindeks:</strong> Google Scholar, Garuda, Moraref, ROAD</div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="https://ojs.unm.ac.id/JPKN" target="_blank" rel="noopener" style="flex:1;text-align:center;background:#0D3B22;color:#ffffff;font-size:13px;font-weight:700;padding:11px 16px;border-radius:10px;text-decoration:none;">
                        Kunjungi Portal Jurnal OJS &rarr;
                    </a>
                    <a href="https://ojs.unm.ac.id/JPKN/about/submissions" target="_blank" rel="noopener" style="background:#FAF8F5;color:#0D3B22;border:1px solid #D4E3D8;font-size:13px;font-weight:600;padding:11px 14px;border-radius:10px;text-decoration:none;">
                        Pedoman Submit
                    </a>
                </div>
            </div>

        </div>

    </section>
    <?php
    return ob_get_clean();
}
}
add_shortcode('ppb_jurnal_bk', 'ppb_shortcode_jurnal_bk');
