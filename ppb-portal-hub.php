<?php
/**
 * Module: PPB FIP UNM - Unified Portal Hub Dashboard
 * Description: Pusat kendali terpadu WP Admin untuk Jurusan PPB / Prodi BK FIP UNM.
 *              Menyatukan seluruh pengelolaan Data Dosen, Dokumen Drive, Jadwal Ujian,
 *              Layanan, dan Navigasi Navbar dalam 1 menu utama tanpa perlu menyentuh kode HTML/PHP.
 * Author: Jurusan PPB / BK FIP UNM
 * Version: 1.1.0
 */

if (!defined('ABSPATH')) exit;

/* ========================================================================== */
/* 1. REGISTRASI MENU UTAMA PORTAL & DASHBOARD HUB                            */
/* ========================================================================== */
if (!function_exists('ppb_render_portal_settings_bridge')) {
function ppb_render_portal_settings_bridge() {
    if (function_exists('bk_fip_render_settings_page')) {
        bk_fip_render_settings_page();
    } else {
        echo '<div class="wrap"><h1>Pengaturan Beranda</h1><p>Silakan aktifkan tema BK FIP untuk mengelola pengaturan beranda.</p></div>';
    }
}
}

if (!function_exists('ppb_render_portal_dosen_bridge')) {
function ppb_render_portal_dosen_bridge() {
    if (function_exists('bk_fip_render_sync_dosen_page')) {
        bk_fip_render_sync_dosen_page();
    } else {
        echo '<div class="wrap"><h1>Data & Direktori Dosen</h1><p>Silakan aktifkan tema BK FIP untuk mengelola direktori dosen.</p></div>';
    }
}
}

if (!function_exists('ppb_register_portal_hub_menu')) {
function ppb_register_portal_hub_menu() {
    // 🏛️ SATU-SATUNYA MENU INDUK PPB FIP DI WP ADMIN
    add_menu_page(
        'Portal PPB FIP UNM',
        '🏛️ Portal PPB FIP',
        'edit_posts',
        'ppb-portal-hub',
        'ppb_render_portal_hub_dashboard',
        'dashicons-networking',
        20
    );

    // 1. Dashboard Utama
    add_submenu_page(
        'ppb-portal-hub',
        'Pusat Kendali Portal PPB',
        '📊 Dashboard Aksi Cepat',
        'edit_posts',
        'ppb-portal-hub',
        'ppb_render_portal_hub_dashboard'
    );

    // 2. Spotlight Beranda (Video & Slider Media)
    add_submenu_page(
        'ppb-portal-hub',
        'Hero Spotlight Beranda',
        '🌟 Spotlight Beranda',
        'manage_options',
        'ppb-spotlight-beranda',
        'ppb_render_spotlight_admin_page'
    );

    // 3. Pengaturan Teks Beranda
    add_submenu_page(
        'ppb-portal-hub',
        'Pengaturan Teks Beranda',
        '⚙️ Teks Beranda',
        'manage_options',
        'bk-pengaturan-beranda',
        'ppb_render_portal_settings_bridge'
    );

    // 4. Warta & Berita Jurusan (Pindah dari luar ke dalam Portal)
    add_submenu_page(
        'ppb-portal-hub',
        'Semua Berita & Pengumuman',
        '📰 Warta & Berita',
        'edit_posts',
        'edit.php'
    );

    // 5. Data Dosen & Staf Pengajar
    add_submenu_page(
        'ppb-portal-hub',
        'Direktori Dosen',
        '👨‍🏫 Data Dosen & Staf',
        'edit_posts',
        'bk-direktori-dosen',
        'ppb_render_portal_dosen_bridge'
    );

    // 6. Jadwal Ujian & Seminar
    add_submenu_page(
        'ppb-portal-hub',
        'Jadwal Ujian & Seminar',
        '📅 Jadwal Ujian & Seminar',
        'edit_posts',
        'edit.php?post_type=ppb_jadwal'
    );

    // 7. Kemahasiswaan & Prestasi
    add_submenu_page(
        'ppb-portal-hub',
        'Kemahasiswaan & Prestasi',
        '🏆 Kemahasiswaan & Prestasi',
        'edit_posts',
        'ppb-kemahasiswaan-settings',
        'ppb_render_kemahasiswaan_settings_page'
    );

    // 8. Layanan & Inventaris Lab
    add_submenu_page(
        'ppb-portal-hub',
        'Layanan Mahasiswa & Lab',
        '📁 Layanan & Inventaris',
        'edit_posts',
        'ppb-layanan-settings',
        'ppb_render_layanan_settings_page'
    );

    // 9. Dokumen Mutu (Link Google Drive)
    add_submenu_page(
        'ppb-portal-hub',
        'Dokumen Mutu (Google Drive)',
        '📂 Dokumen Mutu (Drive)',
        'edit_posts',
        'edit.php?post_type=ppb_dokumen'
    );

    // 10. Navigasi Menu Navbar
    add_submenu_page(
        'ppb-portal-hub',
        'Kelola Navigasi Navbar',
        '🧭 Navigasi Menu Navbar',
        'manage_options',
        'nav-menus.php'
    );
}
}
add_action('admin_menu', 'ppb_register_portal_hub_menu', 9);

// Sidebar Cleanup Hook: Hapus semua menu ganda atau menu liar di luar Portal PPB FIP
add_action('admin_menu', function() {
    remove_menu_page('edit.php'); // Berita WP bawaan sudah ada di dalam Portal PPB FIP
    remove_menu_page('bk-pengaturan-beranda');
    remove_menu_page('ppb-spotlight-beranda');
    remove_menu_page('bk-direktori-dosen');
    remove_menu_page('edit.php?post_type=dosen');
    remove_menu_page('edit.php?post_type=ppb_dosen');
    remove_menu_page('edit.php?post_type=ppb_dokumen');
    remove_menu_page('edit.php?post_type=ppb_jadwal');
    remove_menu_page('edit.php?post_type=ppb_prestasi');
    remove_menu_page('edit.php?post_type=ppb_karya');
    remove_menu_page('edit.php?post_type=ppb_template_dok');
    remove_menu_page('edit.php?post_type=ppb_inventaris_lab');
    remove_menu_page('edit.php?post_type=ppb_alur_sop');
}, 9999);


/* ========================================================================== */
/* 2. RENDER DASHBOARD PUSAT KENDALI (USER-FRIENDLY UNTUK ADMIN NON-TEKNIS)   */
/* ========================================================================== */
if (!function_exists('ppb_render_portal_hub_dashboard')) {
function ppb_render_portal_hub_dashboard() {
    $count_dosen   = wp_count_posts('ppb_dosen')->publish ?: (wp_count_posts('dosen')->publish ?: 25);
    $count_dokumen = wp_count_posts('ppb_dokumen')->publish ?: 8;
    $count_jadwal  = wp_count_posts('ppb_jadwal')->publish ?: 5;
    $count_berita  = wp_count_posts('post')->publish ?: 2;
    ?>
    <div class="wrap ppb-hub-wrap">
        <style>
            .ppb-hub-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; max-width: 1240px; margin: 20px auto; color: #1e293b; }
            .ppb-header-card { background: linear-gradient(135deg, #0D3B22 0%, #185333 100%); color: #ffffff; padding: 32px; border-radius: 16px; margin-bottom: 24px; box-shadow: 0 10px 25px rgba(13, 59, 34, 0.2); position: relative; overflow: hidden; }
            .ppb-header-card::after { content: "PPB"; position: absolute; right: 20px; bottom: -20px; font-size: 110px; font-weight: 900; color: rgba(255, 255, 255, 0.04); pointer-events: none; }
            .ppb-header-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(245, 184, 46, 0.18); border: 1px solid rgba(245, 184, 46, 0.4); color: #F5B82E; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 12px; }
            .ppb-header-title { font-size: 26px; font-weight: 700; margin: 0 0 8px 0; color: #ffffff; line-height: 1.25; }
            .ppb-header-subtitle { font-size: 14px; color: rgba(255, 255, 255, 0.85); margin: 0; max-width: 780px; line-height: 1.6; }
            
            /* Metrik Ringkas */
            .ppb-metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 28px; }
            .ppb-metric-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: transform 0.15s ease; }
            .ppb-metric-card:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,0.06); }
            .ppb-metric-info span { display: block; font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; }
            .ppb-metric-info strong { display: block; font-size: 26px; font-weight: 800; color: #0D3B22; margin-top: 2px; }
            .ppb-metric-icon { width: 44px; height: 44px; border-radius: 10px; background: #E8F0EA; color: #0D3B22; display: flex; align-items: center; justify-content: center; font-size: 20px; }

            /* Grid Kartu Aksi */
            .ppb-actions-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 20px; margin-bottom: 32px; }
            .ppb-action-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease; position: relative; }
            .ppb-action-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
            .ppb-card-top { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 14px; }
            .ppb-card-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
            .ppb-card-icon.green { background: #E8F0EA; color: #0D3B22; }
            .ppb-card-icon.gold { background: #FEF3C7; color: #92400E; }
            .ppb-card-icon.blue { background: #E0F2FE; color: #0369A1; }
            .ppb-card-icon.purple { background: #F3E8FF; color: #6B21A8; }
            .ppb-card-icon.orange { background: #FFEDD5; color: #C2410C; }
            .ppb-card-icon.dark { background: #0D3B22; color: #F5B82E; }
            .ppb-card-text h3 { font-size: 17px; font-weight: 700; margin: 0 0 6px 0; color: #0f172a; }
            .ppb-card-text p { font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; }
            .ppb-card-btns { display: flex; gap: 10px; margin-top: 18px; border-top: 1px solid #f1f5f9; padding-top: 16px; flex-wrap: wrap; }
            
            .ppb-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 600; text-decoration: none; transition: all 0.15s ease; cursor: pointer; }
            .ppb-btn-primary { background: #0D3B22; color: #ffffff !important; border: 1px solid #0D3B22; }
            .ppb-btn-primary:hover { background: #185333; }
            .ppb-btn-gold { background: #F5B82E; color: #0D3B22 !important; border: 1px solid #F5B82E; font-weight: 700; }
            .ppb-btn-gold:hover { background: #e5a925; }
            .ppb-btn-secondary { background: #f8fafc; color: #334155 !important; border: 1px solid #cbd5e1; }
            .ppb-btn-secondary:hover { background: #f1f5f9; color: #0f172a !important; }

            /* Bagian Panduan */
            .ppb-guide-box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
            .ppb-guide-header { font-size: 16px; font-weight: 700; margin: 0 0 16px 0; color: #0D3B22; display: flex; align-items: center; gap: 8px; }
            .ppb-guide-list { margin: 0; padding-left: 20px; }
            .ppb-guide-list li { margin-bottom: 12px; font-size: 13.5px; line-height: 1.6; color: #475569; }
            .ppb-guide-list li strong { color: #0f172a; }
        </style>

        <!-- Header Banner -->
        <div class="ppb-header-card">
            <span class="ppb-header-badge">⭐ Jurusan PPB / Prodi BK FIP UNM</span>
            <h1 class="ppb-header-title">Pusat Kendali Portal Web PPB</h1>
            <p class="ppb-header-subtitle">
                Selamat datang di pusat pengelolaan mandiri website. Seluruh data dosen, tautan berkas Google Drive, jadwal ujian, dan tata letak menu dapat Anda atur langsung melalui tombol di bawah ini tanpa perlu memahami kode pemrograman.
            </p>
        </div>

        <!-- Metrik Ringkas -->
        <div class="ppb-metrics-grid">
            <div class="ppb-metric-card">
                <div class="ppb-metric-info">
                    <span>Total Dosen</span>
                    <strong><?php echo esc_html($count_dosen); ?></strong>
                </div>
                <div class="ppb-metric-icon">👥</div>
            </div>
            <div class="ppb-metric-card">
                <div class="ppb-metric-info">
                    <span>Dokumen Mutu (Drive)</span>
                    <strong><?php echo esc_html($count_dokumen); ?></strong>
                </div>
                <div class="ppb-metric-icon">📂</div>
            </div>
            <div class="ppb-metric-card">
                <div class="ppb-metric-info">
                    <span>Jadwal Ujian Aktif</span>
                    <strong><?php echo esc_html($count_jadwal); ?></strong>
                </div>
                <div class="ppb-metric-icon">📅</div>
            </div>
            <div class="ppb-metric-card">
                <div class="ppb-metric-info">
                    <span>Berita & Artikel</span>
                    <strong><?php echo esc_html($count_berita); ?></strong>
                </div>
                <div class="ppb-metric-icon">📢</div>
            </div>
        </div>

        <!-- Kartu Aksi Cepat Terpadu -->
        <div class="ppb-actions-grid">
            
            <!-- 0. Spotlight & Media Beranda -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon dark">🌟</div>
                        <div class="ppb-card-text">
                            <h3>Spotlight &amp; Media Beranda</h3>
                            <p>Atur video profil YouTube/Drive, foto kegiatan, dan link pengumuman pada panggung utama (hero) beranda.</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('admin.php?page=ppb-spotlight-beranda'); ?>" class="ppb-btn ppb-btn-primary">🎬 Kelola Slide Spotlight</a>
                </div>
            </div>

            <!-- 1. Dosen -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon green">👥</div>
                        <div class="ppb-card-text">
                            <h3>Data Dosen & Pengajar</h3>
                            <p>Kelola profil dosen, gelar, NIP, pangkat akademik (Guru Besar, Lektor Kepala, dll.), foto, dan profil SINTA.</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('admin.php?page=bk-direktori-dosen'); ?>" class="ppb-btn ppb-btn-primary">👨‍🏫 Kelola Data &amp; Direktori Dosen (25)</a>
                </div>
            </div>

            <!-- 2. Dokumen Mutu (Google Drive) -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon gold">📂</div>
                        <div class="ppb-card-text">
                            <h3>Dokumen Mutu & Link Drive</h3>
                            <p>Publikasikan link Google Drive berkas Renstra, SK, dan Regulasi tanpa membebani server hosting.</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('post-new.php?post_type=ppb_dokumen'); ?>" class="ppb-btn ppb-btn-gold">➕ Tambah Link Drive</a>
                    <a href="<?php echo admin_url('edit.php?post_type=ppb_dokumen'); ?>" class="ppb-btn ppb-btn-secondary">📋 Semua Dokumen</a>
                </div>
            </div>

            <!-- 3. Jadwal Seminar & Ujian -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon blue">📅</div>
                        <div class="ppb-card-text">
                            <h3>Jadwal Seminar & Ujian</h3>
                            <p>Publikasikan jadwal seminar proposal, hasil, dan ujian tutup skripsi mahasiswa secara berkala.</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('post-new.php?post_type=ppb_jadwal'); ?>" class="ppb-btn ppb-btn-primary">➕ Tambah Jadwal</a>
                    <a href="<?php echo admin_url('edit.php?post_type=ppb_jadwal'); ?>" class="ppb-btn ppb-btn-secondary">📋 Semua Jadwal</a>
                </div>
            </div>

            <!-- 4. Kemahasiswaan -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon purple">🏆</div>
                        <div class="ppb-card-text">
                            <h3>Prestasi & Karya Mahasiswa</h3>
                            <p>Publikasikan rekam jejak juara mahasiswa dan etalase karya inovasi/konseling bimbingan mahasiswa.</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('edit.php?post_type=ppb_prestasi'); ?>" class="ppb-btn ppb-btn-secondary">🏅 Prestasi</a>
                    <a href="<?php echo admin_url('edit.php?post_type=ppb_karya'); ?>" class="ppb-btn ppb-btn-secondary">🎨 Karya</a>
                </div>
            </div>

            <!-- 5. Layanan & SOP -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon orange">📋</div>
                        <div class="ppb-card-text">
                            <h3>Layanan & Template SOP</h3>
                            <p>Kelola formulir download surat permohonan, alur prosedur SOP layanan mahasiswa, dan inventaris lab.</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('edit.php?post_type=ppb_template_dok'); ?>" class="ppb-btn ppb-btn-secondary">📄 Template Surat</a>
                    <a href="<?php echo admin_url('edit.php?post_type=ppb_alur_sop'); ?>" class="ppb-btn ppb-btn-secondary">🔄 Alur SOP</a>
                </div>
            </div>

            <!-- 6. Navbar & Menu (Drag-and-Drop) -->
            <div class="ppb-action-card">
                <div>
                    <div class="ppb-card-top">
                        <div class="ppb-card-icon dark">🧭</div>
                        <div class="ppb-card-text">
                            <h3>Navigasi Navbar (Menu)</h3>
                            <p>Atur susunan menu dan dropdown navbar tema secara drag-and-drop. Tambah submenu tinggal geser ke kanan!</p>
                        </div>
                    </div>
                </div>
                <div class="ppb-card-btns">
                    <a href="<?php echo admin_url('nav-menus.php'); ?>" class="ppb-btn ppb-btn-primary">⚙️ Atur Menu Navbar</a>
                </div>
            </div>

        </div>

        <!-- Panduan Singkat Admin -->
        <div class="ppb-guide-box">
            <h2 class="ppb-guide-header">💡 Panduan Cepat untuk Admin Website</h2>
            <ol class="ppb-guide-list">
                <li>
                    <strong>Menambahkan Tautan Google Drive Dokumen:</strong> 
                    Klik tombol <em>Tambah Link Drive</em> di atas. Cukup masukkan nama dokumen dan tempelkan link Google Drive berkas Anda. Pastikan izin akses link Google Drive diatur ke <code>Siapa saja yang memiliki link (Anyone with the link)</code> agar pengunjung dapat membuka dan mengunduh berkas.
                </li>
                <li>
                    <strong>Menambahkan Data Dosen Baru:</strong> 
                    Klik <em>Tambah Dosen</em>. Masukkan nama lengkap beserta gelar, NIP 18 digit, pilih kategori pangkat (Guru Besar/Lektor/dll.), dan tetapkan foto profil dosen di kolom <em>Gambar Andalan (Featured Image)</em> di sebelah kanan.
                </li>
                <li>
                    <strong>Mengatur Submenu Navbar:</strong> 
                    Buka <em>Atur Menu Navbar</em>. Jika Anda ingin membuat submenu (dropdown), cukup tarik (drag) item menu ke bawah menu induk, lalu geser sedikit ke kanan.
                </li>
                <li>
                    <strong>Mengedit Teks Langsung di Frontend:</strong> 
                    Saat Anda sedang membuka website (misal halaman depan atau profil) dan sudah login sebagai admin, cukup aktifkan tombol <strong>✏️ Mode Edit Frontend</strong> di pojok kanan bawah. Klik teks yang ingin Anda ubah, lalu tekan <kbd>Ctrl + S</kbd> untuk menyimpan seketika!
                </li>
            </ol>
        </div>

    </div>
    <?php
}
}

/* ========================================================================== */
/* 3. AUTO-SEEDING DUMMY & DEFAULT RECORDS (SELF-HEALING WP-ADMIN)            */
/* ========================================================================== */
require_once plugin_dir_path(__FILE__) . 'ppb-seed-data.php';

add_action('admin_init', 'ppb_auto_seed_portal_data');
if (!function_exists('ppb_auto_seed_portal_data')) {
function ppb_auto_seed_portal_data() {
    if (!current_user_can('manage_options')) return;
    if (get_option('ppb_portal_dummy_seeded_v4') === 'yes') return;

    if (function_exists('ppb_run_complete_dummy_seeder')) {
        ppb_run_complete_dummy_seeder();
    }
    update_option('ppb_portal_dummy_seeded_v4', 'yes');
}
}
