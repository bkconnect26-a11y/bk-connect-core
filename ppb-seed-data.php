<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('ppb_run_complete_dummy_seeder')) {
function ppb_run_complete_dummy_seeder() {
    global $wpdb;
    $theme_dir = get_template_directory();
    $dosen_json_path = $theme_dir . '/dosen-data.json';
    $dosen_list = file_exists($dosen_json_path) ? json_decode(file_get_contents($dosen_json_path), true) : array();

// 5. SEED REALISTIC DUMMY DATA FOR ALL ADMIN MENUS IN bk-fip DATABASE
// ============================================================================
function bk_clear_and_seed_cpt($post_type, $items) {
    global $wpdb;
    $existing = get_posts(array('post_type' => $post_type, 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids'));
    foreach ($existing as $pid) {
        wp_delete_post($pid, true);
    }
    $order = 1;
    foreach ($items as $item) {
        $pid = wp_insert_post(array(
            'post_type'    => $post_type,
            'post_title'   => $item['title'],
            'post_content' => $item['content'] ?? '',
            'post_excerpt' => $item['excerpt'] ?? '',
            'post_status'  => 'publish',
            'menu_order'   => $order++,
        ));
        if ($pid && !is_wp_error($pid) && !empty($item['meta'])) {
            foreach ($item['meta'] as $k => $v) {
                update_post_meta($pid, $k, $v);
            }
        }
    }
    echo "Seeded " . count($items) . " items for CPT [$post_type].\n";
}

// 5a. Sync ppb_dosen CPT from dosen-data.json (25 lecturers)
if (!empty($dosen_list)) {
    $dosen_items = array();
    foreach ($dosen_list as $d) {
        $nama = $d['nama_lengkap'] ?? ($d['nama'] ?? '');
        $jab = $d['jabatan_fungsional'] ?? 'Lektor';
        $kat = 'LEKTOR';
        if (stripos($nama, 'prof.') !== false || stripos($jab, 'guru besar') !== false) $kat = 'GURU BESAR';
        elseif (stripos($jab, 'lektor kepala') !== false) $kat = 'LEKTOR KEPALA';
        elseif (stripos($jab, 'asisten') !== false) $kat = 'ASISTEN AHLI';

        $dosen_items[] = array(
            'title' => $nama,
            'meta'  => array(
                '_ppb_dosen_nip'       => $d['nip'] ?? '',
                '_ppb_dosen_kategori'  => $kat,
                '_ppb_dosen_jabatan'   => $jab . (!empty($d['jabatan_struktural']) ? ' / ' . $d['jabatan_struktural'] : ''),
                '_ppb_dosen_inisial'   => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $d['slug'] ?? 'BK'), 0, 2)),
                '_ppb_dosen_kepakaran' => implode(', ', $d['kepakaran'] ?? array('Bimbingan dan Konseling')),
                '_ppb_dosen_sinta_url' => $d['sinta_url'] ?? 'https://sinta.kemdiktisaintek.go.id/',
            )
        );
    }
    bk_clear_and_seed_cpt('ppb_dosen', $dosen_items);
}

// 5b. Seed ppb_dokumen (8 Dokumen Mutu & Akreditasi)
$dokumen_items = array(
    array(
        'title' => 'Sertifikat & SK Akreditasi Unggul LAMDIK Prodi S1 Bimbingan dan Konseling',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'Akreditasi & Mutu',
            '_ppb_dokumen_nomor'     => 'SK LAMDIK No. 412/SK/LAMDIK/Ak/S/IV/2024',
            '_ppb_dokumen_tahun'     => '2024',
            '_ppb_dokumen_pengesah'  => 'Lembaga Akreditasi Mandiri Kependidikan (LAMDIK)',
            '_ppb_dokumen_size'      => '2.4 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_SK_Akreditasi_Unggul_BK_UNM/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Sertifikat dan Surat Keputusan resmi pemeringkatan Akreditasi Unggul Program Studi S1 Bimbingan dan Konseling FIP UNM berlaku 5 tahun.',
        ),
    ),
    array(
        'title' => 'Rencana Strategis (Renstra) Jurusan PPB FIP UNM Periode 2024–2028',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'Rencana Strategis',
            '_ppb_dokumen_nomor'     => '089/UN36.1/PPB/RENSTRA/2024',
            '_ppb_dokumen_tahun'     => '2024',
            '_ppb_dokumen_pengesah'  => 'Dekan FIP UNM & Ketua Jurusan PPB',
            '_ppb_dokumen_size'      => '3.8 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_Renstra_PPB_FIP_UNM_2024_2028/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Dokumen arah kebijakan, indikator kinerja utama (IKU), dan peta pengembangan tridharma Jurusan Psikologi Pendidikan dan Bimbingan.',
        ),
    ),
    array(
        'title' => 'Buku Pedoman Akademik & Struktur Kurikulum OBE Bimbingan dan Konseling',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'Kurikulum & Akademik',
            '_ppb_dokumen_nomor'     => '114/UN36.1/KRK-OBE/2024',
            '_ppb_dokumen_tahun'     => '2024',
            '_ppb_dokumen_pengesah'  => 'Rektor Universitas Negeri Makassar',
            '_ppb_dokumen_size'      => '5.1 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_Kurikulum_OBE_BK_FIP_UNM/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Pedoman struktur mata kuliah berbasis Outcome-Based Education (OBE), matriks CPL, sebaran SKS tiap semester, dan konversi MBKM.',
        ),
    ),
    array(
        'title' => 'Roadmap Penelitian & Pengabdian Kepada Masyarakat (PkM) Jurusan PPB 2024–2028',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'Rencana Strategis',
            '_ppb_dokumen_nomor'     => '205/UN36.1/PPB/RISET/2024',
            '_ppb_dokumen_tahun'     => '2024',
            '_ppb_dokumen_pengesah'  => 'Senat Fakultas Ilmu Pendidikan UNM',
            '_ppb_dokumen_size'      => '2.9 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_Roadmap_Riset_PKM_PPB_UNM/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Peta jalan payung penelitian dosen dan mahasiswa berbasis 3 pilar keilmuan: Konseling Berbasis Budaya Lokal, Asesmen Digital, dan Konseling Sekolah.',
        ),
    ),
    array(
        'title' => 'Standar Operasional Prosedur (SOP) Penulisan Tugas Akhir & Skripsi Mahasiswa BK',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'SOP & Panduan',
            '_ppb_dokumen_nomor'     => 'SOP-PPB-AKD-04/2025',
            '_ppb_dokumen_tahun'     => '2025',
            '_ppb_dokumen_pengesah'  => 'Gugus Penjaminan Mutu (GPM) FIP UNM',
            '_ppb_dokumen_size'      => '1.7 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_SOP_Skripsi_BK_FIP_UNM/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Panduan tata tulis ilmiah APA 7th Edition, prosedur pengajuan judul di SIPADU, seminar proposal, seminar hasil, dan ujian tutup skripsi.',
        ),
    ),
    array(
        'title' => 'Laporan Audit Mutu Internal (AMI) Siklus XVII Program Studi S1 BK',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'Akreditasi & Mutu',
            '_ppb_dokumen_nomor'     => 'AMI-XVII/LP2M-UNM/PPB/2025',
            '_ppb_dokumen_tahun'     => '2025',
            '_ppb_dokumen_pengesah'  => 'Pusat Penjaminan Mutu LP2M UNM',
            '_ppb_dokumen_size'      => '3.2 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_Laporan_AMI_Prodi_BK_UNM/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Laporan evaluasi ketercapaian standar nasional pendidikan tinggi (SN-Dikti) dan tindak lanjut pengendalian mutu Prodi BK.',
        ),
    ),
    array(
        'title' => 'SK Penetapan Dosen Pembimbing Akademik (PA) & Pembimbing Skripsi Semester berjalan',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'SK & Regulasi',
            '_ppb_dokumen_nomor'     => '318/UN36.1/KP/2025',
            '_ppb_dokumen_tahun'     => '2025',
            '_ppb_dokumen_pengesah'  => 'Dekan Fakultas Ilmu Pendidikan UNM',
            '_ppb_dokumen_size'      => '1.5 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_SK_Pembimbing_Akademik_BK/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Surat Keputusan Dekan FIP UNM tentang distribusi penugasan dosen Penasehat Akademik (PA) dan pembimbing tugas akhir mahasiswa.',
        ),
    ),
    array(
        'title' => 'Pedoman Praktik Pengalaman Lapangan (PPL / PLP) Konseling Sekolah & Industri',
        'meta'  => array(
            '_ppb_dokumen_kategori'  => 'Kurikulum & Akademik',
            '_ppb_dokumen_nomor'     => 'SOP-PPB-PLP-02/2025',
            '_ppb_dokumen_tahun'     => '2025',
            '_ppb_dokumen_pengesah'  => 'Ketua Jurusan PPB FIP UNM',
            '_ppb_dokumen_size'      => '2.1 MB',
            '_ppb_dokumen_link'      => 'https://drive.google.com/file/d/1_Pedoman_PLP_BK_FIP_UNM/view?usp=sharing',
            '_ppb_dokumen_deskripsi' => 'Buku panduan pelaksanaan magang kependidikan, asesmen kebutuhan siswa di sekolah mitra, serta rubrik supervisi dosen pembimbing lapangan.',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_dokumen', $dokumen_items);

// 5c. Seed ppb_jadwal (6 Jadwal Seminar & Ujian Skripsi)
$jadwal_items = array(
    array(
        'title' => 'Ujian Tutup Skripsi - Andi Nurul Izzah (210404501012)',
        'meta'  => array(
            '_ppb_jenis_ujian'      => 'Ujian Skripsi',
            '_ppb_status'           => 'Terjadwal',
            '_ppb_nama_mahasiswa'   => 'Andi Nurul Izzah',
            '_ppb_nim'              => '210404501012',
            '_ppb_angkatan'         => '2021',
            '_ppb_judul_penelitian' => 'Efektivitas Konseling Kelompok Berbasis Nilai Budaya Siri\' na Pacce untuk Meningkatkan Resiliensi Akademik Siswa SMA di Kota Makassar',
            '_ppb_tanggal'          => date('Y-m-d', strtotime('+3 days')),
            '_ppb_jam_mulai'        => '09:00',
            '_ppb_jam_selesai'      => '11:00',
            '_ppb_ruangan'          => 'Ruang Sidang Utama Lt. 2 Jurusan PPB',
            '_ppb_link_daring'      => '',
            '_ppb_pembimbing_1'     => 'Prof. Dr. H. Abdul Saman, M.Si., Kons.',
            '_ppb_pembimbing_2'     => 'Dr. Suciani Latif, M.Pd.',
            '_ppb_penguji_1'        => 'Prof. Dr. Hj. Farida Aryani, M.Pd.',
            '_ppb_penguji_2'        => 'Dr. Sahril Buchori, M.Pd., Kons.',
        ),
    ),
    array(
        'title' => 'Seminar Hasil Penelitian - Muh. Fauzan Azhari (210404502034)',
        'meta'  => array(
            '_ppb_jenis_ujian'      => 'Seminar Hasil',
            '_ppb_status'           => 'Terjadwal',
            '_ppb_nama_mahasiswa'   => 'Muh. Fauzan Azhari',
            '_ppb_nim'              => '210404502034',
            '_ppb_angkatan'         => '2021',
            '_ppb_judul_penelitian' => 'Pengembangan Media Cybercounseling Berbasis Web Interaktif untuk Mereduksi Kecemasan Karir Siswa Kelas XII SMK Negeri di Sulawesi Selatan',
            '_ppb_tanggal'          => date('Y-m-d', strtotime('+4 days')),
            '_ppb_jam_mulai'        => '10:30',
            '_ppb_jam_selesai'      => '12:00',
            '_ppb_ruangan'          => 'Ruang Seminar Laboratorium BK Kampus Gunungsari',
            '_ppb_link_daring'      => '',
            '_ppb_pembimbing_1'     => 'Prof. Dr. Abdullah Sinring, M.Pd.',
            '_ppb_pembimbing_2'     => 'Akhmad Harum, S.Pd., M.Pd.',
            '_ppb_penguji_1'        => 'Prof. Dr. H. Muhammad Jufri, S.Psi., M.Si.',
            '_ppb_penguji_2'        => 'Dr. Awalya Syukur, M.Pd., Kons.',
        ),
    ),
    array(
        'title' => 'Seminar Proposal - Siti Rahmawati Syam (220404501008)',
        'meta'  => array(
            '_ppb_jenis_ujian'      => 'Seminar Proposal',
            '_ppb_status'           => 'Terjadwal',
            '_ppb_nama_mahasiswa'   => 'Siti Rahmawati Syam',
            '_ppb_nim'              => '220404501008',
            '_ppb_angkatan'         => '2022',
            '_ppb_judul_penelitian' => 'Hubungan Antara Self-Compassion dan Dukungan Sosial Teman Sebaya dengan Burnout Belajar pada Mahasiswa Rantau Fakultas Ilmu Pendidikan',
            '_ppb_tanggal'          => date('Y-m-d', strtotime('+6 days')),
            '_ppb_jam_mulai'        => '13:30',
            '_ppb_jam_selesai'      => '15:00',
            '_ppb_ruangan'          => 'Ruang Sidang 1 Gedung PPB FIP UNM',
            '_ppb_link_daring'      => '',
            '_ppb_pembimbing_1'     => 'Dr. Suciani Latif, M.Pd.',
            '_ppb_pembimbing_2'     => 'Muh. Ilham Bakhtiar, S.Pd., M.Pd.',
            '_ppb_penguji_1'        => 'Dr. H. Ahmad Razak, M.Si.',
            '_ppb_penguji_2'        => 'Salmiati, S.Pd., M.Pd.',
        ),
    ),
    array(
        'title' => 'Seminar Proposal - Rezky Pratama Putra (220404501045)',
        'meta'  => array(
            '_ppb_jenis_ujian'      => 'Seminar Proposal',
            '_ppb_status'           => 'Terjadwal',
            '_ppb_nama_mahasiswa'   => 'Rezky Pratama Putra',
            '_ppb_nim'              => '220404501045',
            '_ppb_angkatan'         => '2022',
            '_ppb_judul_penelitian' => 'Penerapan Teknik Cognitive Restructuring dalam Konseling Individu untuk Mengatasi Perilaku Phubbing pada Remaja SMP di Kota Makassar',
            '_ppb_tanggal'          => date('Y-m-d', strtotime('+7 days')),
            '_ppb_jam_mulai'        => '08:30',
            '_ppb_jam_selesai'      => '10:00',
            '_ppb_ruangan'          => 'Ruang Seminar Laboratorium BK Kampus Gunungsari',
            '_ppb_link_daring'      => '',
            '_ppb_pembimbing_1'     => 'Dr. Sahril Buchori, M.Pd., Kons.',
            '_ppb_pembimbing_2'     => 'Drs. Muhammad Anas, M.Pd., M.Si.',
            '_ppb_penguji_1'        => 'Prof. Dr. Hj. Kustiah Sunarty, M.Pd., Kons.',
            '_ppb_penguji_2'        => 'Dr. Hilman Mangkuwibawa, M.Pd.',
        ),
    ),
    array(
        'title' => 'Ujian Tutup Skripsi - Nurfadillah Maharani (210404500019)',
        'meta'  => array(
            '_ppb_jenis_ujian'      => 'Ujian Skripsi',
            '_ppb_status'           => 'Selesai',
            '_ppb_nama_mahasiswa'   => 'Nurfadillah Maharani',
            '_ppb_nim'              => '210404500019',
            '_ppb_angkatan'         => '2021',
            '_ppb_judul_penelitian' => 'Validasi Instrumen Asesmen Kematangan Karir Berbasis Digital bagi Siswa Sekolah Menengah Atas di Provinsi Sulawesi Selatan',
            '_ppb_tanggal'          => date('Y-m-d', strtotime('-5 days')),
            '_ppb_jam_mulai'        => '09:00',
            '_ppb_jam_selesai'      => '11:00',
            '_ppb_ruangan'          => 'Ruang Sidang Utama Lt. 2 Jurusan PPB',
            '_ppb_link_daring'      => '',
            '_ppb_pembimbing_1'     => 'Prof. Dr. Hj. Farida Aryani, M.Pd.',
            '_ppb_pembimbing_2'     => 'Dr. Sahril Buchori, M.Pd., Kons.',
            '_ppb_penguji_1'        => 'Prof. Dr. H. Abdul Saman, M.Si., Kons.',
            '_ppb_penguji_2'        => 'Dr. Suciani Latif, M.Pd.',
        ),
    ),
    array(
        'title' => 'Seminar Hasil Penelitian - Ahmad Zulkifli Mansyur (210404501055)',
        'meta'  => array(
            '_ppb_jenis_ujian'      => 'Seminar Hasil',
            '_ppb_status'           => 'Selesai',
            '_ppb_nama_mahasiswa'   => 'Ahmad Zulkifli Mansyur',
            '_ppb_nim'              => '210404501055',
            '_ppb_angkatan'         => '2021',
            '_ppb_judul_penelitian' => 'Efektivitas Bimbingan Klasikal Menggunakan Permainan Simulasi Karir untuk Meningkatkan Efikasi Diri Pengambilan Keputusan Lanjut Studi',
            '_ppb_tanggal'          => date('Y-m-d', strtotime('-8 days')),
            '_ppb_jam_mulai'        => '13:00',
            '_ppb_jam_selesai'      => '14:30',
            '_ppb_ruangan'          => 'Ruang Sidang 1 Gedung PPB FIP UNM',
            '_ppb_link_daring'      => '',
            '_ppb_pembimbing_1'     => 'Prof. Dr. H. Muhammad Jufri, S.Psi., M.Si.',
            '_ppb_pembimbing_2'     => 'Dr. Awalya Syukur, M.Pd., Kons.',
            '_ppb_penguji_1'        => 'Prof. Dr. Abdullah Sinring, M.Pd.',
            '_ppb_penguji_2'        => 'Akhmad Harum, S.Pd., M.Pd.',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_jadwal', $jadwal_items);

// 5d. Seed ppb_prestasi (6 Prestasi & Rekognisi Mahasiswa)
$prestasi_items = array(
    array(
        'title' => 'Juara 1 Nasional Lomba Microcounseling & Inovasi Layanan BK ABKIN',
        'meta'  => array(
            '_ppb_nama_mahasiswa'        => 'Tim Delegasi HMJ PPB (Nurul Izzah, Fauzan Azhari, Rahmawati)',
            '_ppb_nim'                   => '210404501012',
            '_ppb_angkatan'              => '2021',
            '_ppb_capaian'               => 'Juara 1 Nasional (Medali Emas)',
            '_ppb_nama_kegiatan'         => 'Olimpiade & Kompetisi Nasional Bimbingan dan Konseling Indonesia',
            '_ppb_penyelenggara'         => 'Asosiasi Bimbingan dan Konseling Indonesia (ABKIN) Pusat',
            '_ppb_tingkat'               => 'Nasional',
            '_ppb_tahun'                 => '2025',
            '_ppb_dosen_pembimbing'      => 'Dr. Suciani Latif, M.Pd.',
            '_ppb_deskripsi'             => 'Meraih peringkat terbaik nasional dalam demonstrasi keterampilan konseling singkat berfokus solusi (SFBC) terintegrasi kearifan lokal Bugis-Makassar.',
            '_ppb_drive_sertifikat_link' => 'https://drive.google.com/file/d/1_Sertifikat_Juara1_ABKIN_Nasional/view?usp=sharing',
            '_ppb_drive_foto_link'       => '',
            '_ppb_is_featured'           => '1',
        ),
    ),
    array(
        'title' => 'Silver Medal - ASEAN Youth Educational Innovation & Counseling Media Exhibition',
        'meta'  => array(
            '_ppb_nama_mahasiswa'        => 'Nurfadillah Maharani & Tim Riset BK',
            '_ppb_nim'                   => '210404500019',
            '_ppb_angkatan'              => '2021',
            '_ppb_capaian'               => 'Silver Medal (Tingkat Internasional)',
            '_ppb_nama_kegiatan'         => 'ASEAN Youth Educational Innovation Competition (AYEIC)',
            '_ppb_penyelenggara'         => 'Southeast Asian Ministers of Education Organization (SEAMEO)',
            '_ppb_tingkat'               => 'Internasional',
            '_ppb_tahun'                 => '2025',
            '_ppb_dosen_pembimbing'      => 'Prof. Dr. H. Abdul Saman, M.Si., Kons.',
            '_ppb_deskripsi'             => 'Inovasi aplikasi asesmen kesejahteraan psikologis remaja berbasis gamifikasi interaktif untuk sekolah menengah di kawasan Asia Tenggara.',
            '_ppb_drive_sertifikat_link' => 'https://drive.google.com/file/d/1_Sertifikat_Silver_Medal_ASEAN/view?usp=sharing',
            '_ppb_drive_foto_link'       => '',
            '_ppb_is_featured'           => '1',
        ),
    ),
    array(
        'title' => 'Pendanaan Terbaik PKM-RSH (Riset Sosial Humaniora) Kemdiktisaintek',
        'meta'  => array(
            '_ppb_nama_mahasiswa'        => 'Rezky Pratama Putra, Siti Rahmawati Syam, dkk.',
            '_ppb_nim'                   => '220404501045',
            '_ppb_angkatan'              => '2022',
            '_ppb_capaian'               => 'Penerima Hibah Pendanaan Nasional & Finalis PIMNAS',
            '_ppb_nama_kegiatan'         => 'Program Kreativitas Mahasiswa (PKM) Skema Riset Sosial Humaniora',
            '_ppb_penyelenggara'         => 'Direktorat Belmawa Kemdiktisaintek RI',
            '_ppb_tingkat'               => 'Nasional',
            '_ppb_tahun'                 => '2024',
            '_ppb_dosen_pembimbing'      => 'Dr. Sahril Buchori, M.Pd., Kons.',
            '_ppb_deskripsi'             => 'Riset pengembangan model konseling sebaya berbasis nilai Sipakatau untuk pencegahan perundungan siber (cyberbullying) pelajar SMA.',
            '_ppb_drive_sertifikat_link' => 'https://drive.google.com/file/d/1_Sertifikat_PKM_RSH_BK_UNM/view?usp=sharing',
            '_ppb_drive_foto_link'       => '',
            '_ppb_is_featured'           => '1',
        ),
    ),
    array(
        'title' => 'Juara 2 Nasional Lomba Desain Media Bimbingan Klasikal Kreatif (Board Game BK)',
        'meta'  => array(
            '_ppb_nama_mahasiswa'        => 'Annisa Fitriani & Muh. Ilham Saputra',
            '_ppb_nim'                   => '220404502018',
            '_ppb_angkatan'              => '2022',
            '_ppb_capaian'               => 'Juara 2 Nasional',
            '_ppb_nama_kegiatan'         => 'Gebyar Inovasi Media Bimbingan dan Konseling Nusantara',
            '_ppb_penyelenggara'         => 'Ikatan Mahasiswa Bimbingan dan Konseling Indonesia (IMABKIN)',
            '_ppb_tingkat'               => 'Nasional',
            '_ppb_tahun'                 => '2024',
            '_ppb_dosen_pembimbing'      => 'Akhmad Harum, S.Pd., M.Pd.',
            '_ppb_deskripsi'             => 'Merancang permainan papan edukatif "Jelajah Karir Masa Depan" dilengkapi kartu refleksi QR-Code untuk siswa SMP/SMA.',
            '_ppb_drive_sertifikat_link' => 'https://drive.google.com/file/d/1_Sertifikat_Juara2_IMABKIN/view?usp=sharing',
            '_ppb_drive_foto_link'       => '',
            '_ppb_is_featured'           => '0',
        ),
    ),
    array(
        'title' => 'Mahasiswa Berprestasi (Mawapres) Utama I Fakultas Ilmu Pendidikan UNM',
        'meta'  => array(
            '_ppb_nama_mahasiswa'        => 'Andi Nurul Izzah',
            '_ppb_nim'                   => '210404501012',
            '_ppb_angkatan'              => '2021',
            '_ppb_capaian'               => 'Juara 1 Mahasiswa Berprestasi FIP UNM',
            '_ppb_nama_kegiatan'         => 'Pemilihan Mahasiswa Berprestasi (Pilmapres) Tingkat Fakultas & Universitas',
            '_ppb_penyelenggara'         => 'Universitas Negeri Makassar',
            '_ppb_tingkat'               => 'Provinsi / Wilayah',
            '_ppb_tahun'                 => '2024',
            '_ppb_dosen_pembimbing'      => 'Prof. Dr. Hj. Farida Aryani, M.Pd.',
            '_ppb_deskripsi'             => 'Terpilih sebagai Mahasiswa Berprestasi Terbaik I FIP UNM berkat capaian publikasi ilmiah, karya gagasan kreatif, dan kemampuan bahasa Inggris.',
            '_ppb_drive_sertifikat_link' => 'https://drive.google.com/file/d/1_Sertifikat_Mawapres_FIP_UNM/view?usp=sharing',
            '_ppb_drive_foto_link'       => '',
            '_ppb_is_featured'           => '0',
        ),
    ),
    array(
        'title' => 'Juara 1 Lomba Esai Ilmiah Kesehatan Mental Remaja Tingkat Nasional',
        'meta'  => array(
            '_ppb_nama_mahasiswa'        => 'Putri Ayu Lestari',
            '_ppb_nim'                   => '230404501009',
            '_ppb_angkatan'              => '2023',
            '_ppb_capaian'               => 'Juara 1 Nasional',
            '_ppb_nama_kegiatan'         => 'National Mental Health & Counseling Scientific Writing Competition',
            '_ppb_penyelenggara'         => 'Konsorsium Jurusan BK LPTK Indonesia',
            '_ppb_tingkat'               => 'Nasional',
            '_ppb_tahun'                 => '2025',
            '_ppb_dosen_pembimbing'      => 'Muh. Ilham Bakhtiar, S.Pd., M.Pd.',
            '_ppb_deskripsi'             => 'Karya esai tentang integrasi pertolongan pertama psikologis (Psychological First Aid) oleh konselor sebaya di lingkungan kampus ramah mahasiswa.',
            '_ppb_drive_sertifikat_link' => 'https://drive.google.com/file/d/1_Sertifikat_Juara1_Esai_BK/view?usp=sharing',
            '_ppb_drive_foto_link'       => '',
            '_ppb_is_featured'           => '0',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_prestasi', $prestasi_items);

// 5e. Seed ppb_karya (6 Karya Inovasi & Produk Mahasiswa)
$karya_items = array(
    array(
        'title' => 'Aplikasi "SI-KARIR": Sistem Pakar Pemetaan Minat & Bakat Karir Siswa SMA Berbasis Web',
        'meta'  => array(
            '_ppb_karya_judul'      => 'Aplikasi SI-KARIR: Pemetaan Minat Karir Holland RIASEC Digital',
            '_ppb_kategori'         => 'Aplikasi & Cybercounseling',
            '_ppb_pembuat'          => 'Muh. Fauzan Azhari, Andi Nurul Izzah, & Tim Lab Asesmen BK',
            '_ppb_nim_ketua'        => '210404502034',
            '_ppb_angkatan'         => '2021',
            '_ppb_dosen_pembimbing' => 'Prof. Dr. Hj. Farida Aryani, M.Pd.',
            '_ppb_mata_kuliah'      => 'Teknologi Informasi dalam Bimbingan dan Konseling',
            '_ppb_tahun'            => '2025',
            '_ppb_badge_unggulan'   => 'Terdaftar HKI & Teruji di 5 SMA',
            '_ppb_manfaat'          => 'Membantu guru BK memetakan kecenderungan karir siswa secara instan beserta rekomendasi jurusan perguruan tinggi.',
            '_ppb_deskripsi'        => 'Platform asesmen mandiri berbasis web yang mengadaptasi teori tipologi karir John Holland (RIASEC) dengan laporan profil grafis otomatis untuk konselor sekolah.',
            '_ppb_foto_karya_link'  => '',
            '_ppb_drive_file_link'  => 'https://drive.google.com/file/d/1_Karya_Aplikasi_SIKARIR_BK_UNM/view?usp=sharing',
        ),
    ),
    array(
        'title' => 'Board Game Edukatif "SI-PACCE": Media Bimbingan Kelompok Penguatan Empati & Anti-Perundungan',
        'meta'  => array(
            '_ppb_karya_judul'      => 'Board Game SI-PACCE (Siri\' na Pacce Counseling Game)',
            '_ppb_kategori'         => 'Board Game & Media Kreatif',
            '_ppb_pembuat'          => 'Rezky Pratama Putra & Kelompok Inovasi Media BK',
            '_ppb_nim_ketua'        => '220404501045',
            '_ppb_angkatan'         => '2022',
            '_ppb_dosen_pembimbing' => 'Dr. Suciani Latif, M.Pd.',
            '_ppb_mata_kuliah'      => 'Pengembangan Media Bimbingan dan Konseling',
            '_ppb_tahun'            => '2024',
            '_ppb_badge_unggulan'   => 'Juara Nasional Media BK',
            '_ppb_manfaat'          => 'Meningkatkan keaktifan diskusi kelompok dan empati sosial siswa SMP melalui tantangan studi kasus interaktif.',
            '_ppb_deskripsi'        => 'Satu set permainan papan bimbingan kelompok berisi 48 kartu skenario dilema moral remaja, pion karakter, dan buku panduan fasilitator untuk guru BK.',
            '_ppb_foto_karya_link'  => '',
            '_ppb_drive_file_link'  => 'https://drive.google.com/file/d/1_Karya_BoardGame_SIPACCE/view?usp=sharing',
        ),
    ),
    array(
        'title' => 'Modul Pelatihan Konselor Sebaya (Peer Counselor) untuk Pencegahan Kekerasan Seksual & Perundungan',
        'meta'  => array(
            '_ppb_karya_judul'      => 'Modul Praktis Pelatihan Konselor Sebaya Ramah Remaja',
            '_ppb_kategori'         => 'Modul & Buku Panduan BK',
            '_ppb_pembuat'          => 'Siti Rahmawati Syam, Putri Ayu Lestari, dkk.',
            '_ppb_nim_ketua'        => '220404501008',
            '_ppb_angkatan'         => '2022',
            '_ppb_dosen_pembimbing' => 'Dr. Sahril Buchori, M.Pd., Kons.',
            '_ppb_mata_kuliah'      => 'Konseling Sebaya & Kesehatan Mental',
            '_ppb_tahun'            => '2025',
            '_ppb_badge_unggulan'   => 'Ber-ISBN & Digunakan Mitra Sekolah',
            '_ppb_manfaat'          => 'Menjadi pegangan terstruktur bagi guru BK dalam melatih kader konselor sebaya di tingkat SMP dan SMA.',
            '_ppb_deskripsi'        => 'Modul komprehensif 8 sesi pelatihan mencakup keterampilan mendengar aktif, empati dasar, etika kerahasiaan, dan alur rujukan kasus darurat.',
            '_ppb_foto_karya_link'  => '',
            '_ppb_drive_file_link'  => 'https://drive.google.com/file/d/1_Karya_Modul_Konselor_Sebaya/view?usp=sharing',
        ),
    ),
    array(
        'title' => 'Instrumen Inventori Deteksi Dini Prokrastinasi & Burnout Akademik Siswa (IDP-BA Digital)',
        'meta'  => array(
            '_ppb_karya_judul'      => 'Inventori Asesmen Non-Tes IDP-BA Terkomputerisasi',
            '_ppb_kategori'         => 'Instrumen Asesmen Psikologis',
            '_ppb_pembuat'          => 'Nurfadillah Maharani & Tim Asisten Lab Asesmen PPB',
            '_ppb_nim_ketua'        => '210404500019',
            '_ppb_angkatan'         => '2021',
            '_ppb_dosen_pembimbing' => 'Prof. Dr. H. Muhammad Jufri, S.Psi., M.Si.',
            '_ppb_mata_kuliah'      => 'Asesmen Psikologis Teknik Non-Tes',
            '_ppb_tahun'            => '2024',
            '_ppb_badge_unggulan'   => 'Validitas & Reliabilitas Tinggi (α = 0.91)',
            '_ppb_manfaat'          => 'Memudahkan guru BK mengidentifikasi tingkat kejenuhan belajar siswa secara klasikal dalam waktu kurang dari 15 menit.',
            '_ppb_deskripsi'        => 'Paket instrumen asesmen skala psikologis 36 aitem lengkap dengan template skoring otomatis berbasis spreadsheet dan pedoman interpretasi profil.',
            '_ppb_foto_karya_link'  => '',
            '_ppb_drive_file_link'  => 'https://drive.google.com/file/d/1_Karya_Instrumen_IDP_BA/view?usp=sharing',
        ),
    ),
    array(
        'title' => 'Serial Video Animasi Microlearning "Regulasi Emosi & Mindfulness untuk Pelajar Gen-Z"',
        'meta'  => array(
            '_ppb_karya_judul'      => 'Paket 6 Video Microlearning Bimbingan Klasikal Berbasis Mindfulness',
            '_ppb_kategori'         => 'Video & Podcast Edukasi',
            '_ppb_pembuat'          => 'Ahmad Zulkifli Mansyur & Divisi Kreatif HMJ PPB FIP UNM',
            '_ppb_nim_ketua'        => '210404501055',
            '_ppb_angkatan'         => '2021',
            '_ppb_dosen_pembimbing' => 'Akhmad Harum, S.Pd., M.Pd.',
            '_ppb_mata_kuliah'      => 'Praktikum Bimbingan Klasikal & Kelompok',
            '_ppb_tahun'            => '2024',
            '_ppb_badge_unggulan'   => 'Media Digital Pilihan Jurusan',
            '_ppb_manfaat'          => 'Menyediakan bahan tayang visual berdurasi 5 menit sebagai pemantik refleksi layanan bimbingan klasikal di kelas.',
            '_ppb_deskripsi'        => 'Rangkaian video animasi pendek disertai lembar kerja refleksi diri (worksheet) untuk melatih teknik pernapasan sadar dan pengelolaan stres ujian.',
            '_ppb_foto_karya_link'  => '',
            '_ppb_drive_file_link'  => 'https://drive.google.com/file/d/1_Karya_Video_Mindfulness_BK/view?usp=sharing',
        ),
    ),
    array(
        'title' => 'Buku Saku Digital "Kamus Regulasi Diri & Manajemen Waktu Mahasiswa Baru"',
        'meta'  => array(
            '_ppb_karya_judul'      => 'E-Booklet Panduan Adaptasi Akademik Mahasiswa Baru',
            '_ppb_kategori'         => 'Modul & Buku Panduan BK',
            '_ppb_pembuat'          => 'Annisa Fitriani & Tim Penulis Mahasiswa BK Angkatan 2022',
            '_ppb_nim_ketua'        => '220404502018',
            '_ppb_angkatan'         => '2022',
            '_ppb_dosen_pembimbing' => 'Muh. Ilham Bakhtiar, S.Pd., M.Pd.',
            '_ppb_mata_kuliah'      => 'Bimbingan dan Konseling Belajar',
            '_ppb_tahun'            => '2025',
            '_ppb_badge_unggulan'   => 'E-Booklet Interaktif',
            '_ppb_manfaat'          => 'Membantu mahasiswa tahun pertama menyusun prioritas belajar, mengatasi culture shock, dan mengakses layanan konseling kampus.',
            '_ppb_deskripsi'        => 'Buku saku interaktif berformat flipbook PDF yang memuat matriks Eisenhower, tracker kebiasaan belajar, dan direktori layanan konseling FIP UNM.',
            '_ppb_foto_karya_link'  => '',
            '_ppb_drive_file_link'  => 'https://drive.google.com/file/d/1_Karya_BukuSaku_RegulasiDiri/view?usp=sharing',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_karya', $karya_items);

// 5f. Seed ppb_template_dok (6 Template Persuratan & Akademik)
$template_items = array(
    array(
        'title' => 'Formulir Pengajuan Judul Skripsi & Permohonan Dosen Pembimbing (F-01)',
        'meta'  => array(
            '_ppb_tpl_kategori'     => 'Persuratan Skripsi & Tugas Akhir',
            '_ppb_tpl_format_file'  => 'DOCX (Word)',
            '_ppb_tpl_ukuran_kb'    => '145 KB',
            '_ppb_tpl_nomor_revisi' => 'SOP-PPB/F-01/Rev.03',
            '_ppb_tpl_file_link'    => 'https://drive.google.com/file/d/1_Template_F01_Pengajuan_Judul_BK/view?usp=sharing',
            '_ppb_tpl_deskripsi'    => 'Format resmi pengajuan 3 alternatif topik penelitian skripsi beserta persetujuan Penasehat Akademik (PA) sebelum diunggah ke SIPADU.',
        ),
    ),
    array(
        'title' => 'Template Kartu Kontrol & Jurnal Bimbingan Tugas Akhir / Skripsi (F-02)',
        'meta'  => array(
            '_ppb_tpl_kategori'     => 'Persuratan Skripsi & Tugas Akhir',
            '_ppb_tpl_format_file'  => 'DOCX (Word)',
            '_ppb_tpl_ukuran_kb'    => '180 KB',
            '_ppb_tpl_nomor_revisi' => 'SOP-PPB/F-02/Rev.02',
            '_ppb_tpl_file_link'    => 'https://drive.google.com/file/d/1_Template_F02_Kartu_Bimbingan/view?usp=sharing',
            '_ppb_tpl_deskripsi'    => 'Lembar kendali konsultasi berkala bersama Pembimbing I dan Pembimbing II sebagai syarat pendaftaran seminar proposal dan hasil.',
        ),
    ),
    array(
        'title' => 'Format Permohonan Surat Izin Penelitian & Pengambilan Data di Sekolah (F-03)',
        'meta'  => array(
            '_ppb_tpl_kategori'     => 'Izin Penelitian & Observasi',
            '_ppb_tpl_format_file'  => 'DOCX (Word)',
            '_ppb_tpl_ukuran_kb'    => '120 KB',
            '_ppb_tpl_nomor_revisi' => 'SOP-PPB/F-03/Rev.02',
            '_ppb_tpl_file_link'    => 'https://drive.google.com/file/d/1_Template_F03_Izin_Penelitian/view?usp=sharing',
            '_ppb_tpl_deskripsi'    => 'Formulir pengantar jurusan untuk penerbitan surat izin penelitian/observasi lapangan dari Dekanat FIP UNM dan Dinas Pendidikan.',
        ),
    ),
    array(
        'title' => 'Formulir Pendaftaran Seminar Proposal, Seminar Hasil, & Ujian Tutup (F-04)',
        'meta'  => array(
            '_ppb_tpl_kategori'     => 'Persuratan Skripsi & Tugas Akhir',
            '_ppb_tpl_format_file'  => 'DOCX (Word)',
            '_ppb_tpl_ukuran_kb'    => '165 KB',
            '_ppb_tpl_nomor_revisi' => 'SOP-PPB/F-04/Rev.03',
            '_ppb_tpl_file_link'    => 'https://drive.google.com/file/d/1_Template_F04_Pendaftaran_Ujian/view?usp=sharing',
            '_ppb_tpl_deskripsi'    => 'Berkas ceklis kelengkapan persyaratan administrasi dan lembar persetujuan pembimbing untuk penjadwalan ujian meja mahasiswa.',
        ),
    ),
    array(
        'title' => 'Formulir Peminjaman Ruang Konseling Individual & Alat Tes Psikologi Lab BK (F-05)',
        'meta'  => array(
            '_ppb_tpl_kategori'     => 'Peminjaman Lab & Alat Tes',
            '_ppb_tpl_format_file'  => 'DOCX (Word)',
            '_ppb_tpl_ukuran_kb'    => '135 KB',
            '_ppb_tpl_nomor_revisi' => 'SOP-LAB/F-05/Rev.01',
            '_ppb_tpl_file_link'    => 'https://drive.google.com/file/d/1_Template_F05_Peminjaman_Lab_BK/view?usp=sharing',
            '_ppb_tpl_deskripsi'    => 'Surat permohonan penggunaan bilik konseling kedap suara, kamera observasi, atau peminjaman instrumen tes psikologi bagi mahasiswa praktikum.',
        ),
    ),
    array(
        'title' => 'Surat Keterangan Aktif Kuliah & Rekomendasi Beasiswa / Lomba Mahasiswa (F-06)',
        'meta'  => array(
            '_ppb_tpl_kategori'     => 'Kemahasiswaan & Beasiswa',
            '_ppb_tpl_format_file'  => 'DOCX (Word)',
            '_ppb_tpl_ukuran_kb'    => '115 KB',
            '_ppb_tpl_nomor_revisi' => 'SOP-KMH/F-06/Rev.02',
            '_ppb_tpl_file_link'    => 'https://drive.google.com/file/d/1_Template_F06_Rekomendasi_Beasiswa/view?usp=sharing',
            '_ppb_tpl_deskripsi'    => 'Format draf surat rekomendasi Ketua Jurusan PPB untuk pengajuan beasiswa prestasi, pertukaran mahasiswa merdeka, dan delegasi lomba.',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_template_dok', $template_items);

// 5g. Seed ppb_inventaris_lab (6 Inventaris Laboratorium BK)
$inventaris_items = array(
    array(
        'title' => 'Bilik Konseling Individual Kedap Suara & One-Way Mirror Observation',
        'meta'  => array(
            '_ppb_inv_kode_alat'     => 'LAB-BK-RK-001',
            '_ppb_inv_kategori'      => 'Fasilitas Ruang Konseling',
            '_ppb_inv_spesifikasi'   => '4 Bilik Konseling Eksekutif berperedam akustik, sofa ergonomis konselor-konseli, cermin observasi satu arah (One-Way Mirror), & interkom supervisor.',
            '_ppb_inv_jumlah_unit'   => '4',
            '_ppb_inv_kondisi'       => 'Sangat Baik (Siap Pakai)',
            '_ppb_inv_lokasi'        => 'Lantai 1 Gedung Laboratorium BK Kampus Gunungsari',
            '_ppb_inv_manual_link'   => 'https://drive.google.com/file/d/1_Manual_Bilik_Konseling_LabBK/view?usp=sharing',
            '_ppb_inv_foto_link'     => '',
            '_ppb_inv_keterangan'    => 'Digunakan untuk praktikum Mikrokonseling, Konseling Individual, dan layanan konseling langsung.',
        ),
    ),
    array(
        'title' => 'Ruang Simulasi Konseling Kelompok & Bimbingan Klasikal Multimedia',
        'meta'  => array(
            '_ppb_inv_kode_alat'     => 'LAB-BK-RK-002',
            '_ppb_inv_kategori'      => 'Fasilitas Ruang Konseling',
            '_ppb_inv_spesifikasi'   => 'Kapasitas 20 peserta, kursi melingkar dinamis, Interactive Smart Flat Panel 75 Inci 4K, dan sistem tata suara konferensi.',
            '_ppb_inv_jumlah_unit'   => '2',
            '_ppb_inv_kondisi'       => 'Sangat Baik (Siap Pakai)',
            '_ppb_inv_lokasi'        => 'Lantai 1 Gedung Laboratorium BK Kampus Gunungsari',
            '_ppb_inv_manual_link'   => 'https://drive.google.com/file/d/1_Manual_Ruang_Konseling_Kelompok/view?usp=sharing',
            '_ppb_inv_foto_link'     => '',
            '_ppb_inv_keterangan'    => 'Dilengkapi karpet akustik dan formasi kursi fleksibel untuk dinamika kelompok dan psikodrama.',
        ),
    ),
    array(
        'title' => 'Kit Instrumen Tes Inteligensi & Bakat Skolastik (IST, CFIT, & DAT Lengkap)',
        'meta'  => array(
            '_ppb_inv_kode_alat'     => 'LAB-BK-TES-010',
            '_ppb_inv_kategori'      => 'Alat Tes Psikologi & Asesmen',
            '_ppb_inv_spesifikasi'   => 'Buku soal standar, lembar jawaban optik/manual, kunci skoring, dan buku norma terbaru (Intelligenz Struktur Test, Culture Fair Intelligence Test, Differential Aptitude Test).',
            '_ppb_inv_jumlah_unit'   => '15',
            '_ppb_inv_kondisi'       => 'Sangat Baik (Siap Pakai)',
            '_ppb_inv_lokasi'        => 'Lemari Instrumen Rahasia Ruang Asesmen Psikologis Lab BK',
            '_ppb_inv_manual_link'   => 'https://drive.google.com/file/d/1_Katalog_Alat_Tes_Psikologi_BK/view?usp=sharing',
            '_ppb_inv_foto_link'     => '',
            '_ppb_inv_keterangan'    => 'Peminjaman wajib disertai persetujuan Dosen Pengampu Mata Kuliah Asesmen Teknik Tes dan Kepala Lab BK.',
        ),
    ),
    array(
        'title' => 'Kit Asesmen Minat Karir & Kepribadian Konseling (RMIB, SDS Holland, EPPS, Kuder)',
        'meta'  => array(
            '_ppb_inv_kode_alat'     => 'LAB-BK-TES-014',
            '_ppb_inv_kategori'      => 'Alat Tes Psikologi & Asesmen',
            '_ppb_inv_spesifikasi'   => 'Rothwell Miller Interest Blank (RMIB), Self-Directed Search (SDS Holland), Edwards Personal Preference Schedule (EPPS), beserta software skoring profil.',
            '_ppb_inv_jumlah_unit'   => '20',
            '_ppb_inv_kondisi'       => 'Sangat Baik (Siap Pakai)',
            '_ppb_inv_lokasi'        => 'Lemari Instrumen Ruang Asesmen Psikologis Lab BK',
            '_ppb_inv_manual_link'   => 'https://drive.google.com/file/d/1_Panduan_Skoring_RMIB_SDS_BK/view?usp=sharing',
            '_ppb_inv_foto_link'     => '',
            '_ppb_inv_keterangan'    => 'Tersedia versi cetak dan versi lembar skoring terkomputerisasi untuk praktikum Konseling Karir.',
        ),
    ),
    array(
        'title' => 'Perangkat Rekam Observasi Audio-Visual PTZ & Podcast Studio Cybercounseling',
        'meta'  => array(
            '_ppb_inv_kode_alat'     => 'LAB-BK-MM-005',
            '_ppb_inv_kategori'      => 'Perangkat Rekam & Observasi',
            '_ppb_inv_spesifikasi'   => 'Kamera Sony PTZ Auto-Tracking Full HD, Condenser Microphone Rode PodMic Dual Set, Audio Interface Focusrite, & Monitor Kontrol Observasi.',
            '_ppb_inv_jumlah_unit'   => '4',
            '_ppb_inv_kondisi'       => 'Sangat Baik (Siap Pakai)',
            '_ppb_inv_lokasi'        => 'Ruang Kontrol Observasi & Studio Cybercounseling Lab BK',
            '_ppb_inv_manual_link'   => 'https://drive.google.com/file/d/1_SOP_Perekaman_Mikrokonseling/view?usp=sharing',
            '_ppb_inv_foto_link'     => '',
            '_ppb_inv_keterangan'    => 'Digunakan mahasiswa untuk merekam sesi ujian keterampilan komunikasi dasar konseling (attending, reflecting, probing).',
        ),
    ),
    array(
        'title' => 'Workstation Komputer Asesmen Digital & Pengolahan Data Psikometrik (SPSS / Jamovi / R)',
        'meta'  => array(
            '_ppb_inv_kode_alat'     => 'LAB-BK-KOM-008',
            '_ppb_inv_kategori'      => 'Komputer & Software Statistik',
            '_ppb_inv_spesifikasi'   => 'PC All-in-One Core i7 RAM 16GB SSD 512GB terinstal aplikasi asesmen non-tes (AKPD/DCM), Jamovi, JASP, SPSS, dan Winsteps Rasch Model.',
            '_ppb_inv_jumlah_unit'   => '12',
            '_ppb_inv_kondisi'       => 'Sangat Baik (Siap Pakai)',
            '_ppb_inv_lokasi'        => 'Ruang Komputasi & Asesmen Digital Lab BK',
            '_ppb_inv_manual_link'   => 'https://drive.google.com/file/d/1_Panduan_Pengolahan_Data_LabBK/view?usp=sharing',
            '_ppb_inv_foto_link'     => '',
            '_ppb_inv_keterangan'    => 'Dapat diakses mahasiswa untuk pengolahan data skripsi dan analisis butir instrumen penelitian.',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_inventaris_lab', $inventaris_items);

// 5h. Seed ppb_alur_sop (5 Alur SOP Layanan Akademik & Laboratorium)
$sop_items = array(
    array(
        'title' => 'SOP Pengajuan Judul Skripsi & Penetapan Dosen Pembimbing melalui SIPADU',
        'meta'  => array(
            '_ppb_sop_nomor'     => 'SOP-PPB-AKD-01/2025',
            '_ppb_sop_estimasi'  => '3 - 5 Hari Kerja',
            '_ppb_sop_dok_link'  => 'https://drive.google.com/file/d/1_SOP_Pengajuan_Judul_SIPADU/view?usp=sharing',
            '_ppb_sop_langkah_1' => 'Mahasiswa mengunduh Formulir F-01 dan mendiskusikan 3 alternatif topik penelitian bersama Dosen Penasehat Akademik (PA).',
            '_ppb_sop_langkah_2' => 'Mahasiswa login ke portal SIPADU BK-Connect dan mengunggah rasional judul beserta matriks masalah penelitian.',
            '_ppb_sop_langkah_3' => 'Ketua & Sekretaris Jurusan PPB melakukan verifikasi kesesuaian payung riset dan memetakan calon Pembimbing I & II.',
            '_ppb_sop_langkah_4' => 'Penerbitan Surat Penunjukan Dosen Pembimbing dan pembukaan buku kendali bimbingan digital di akun mahasiswa.',
            '_ppb_sop_langkah_5' => 'Mahasiswa mulai menyusun draf proposal Bab I–III dan melakukan bimbingan minimal 8 kali sebelum seminar proposal.',
        ),
    ),
    array(
        'title' => 'SOP Pendaftaran Seminar Proposal, Seminar Hasil, dan Ujian Tutup Skripsi',
        'meta'  => array(
            '_ppb_sop_nomor'     => 'SOP-PPB-AKD-02/2025',
            '_ppb_sop_estimasi'  => '2 - 4 Hari Kerja',
            '_ppb_sop_dok_link'  => 'https://drive.google.com/file/d/1_SOP_Pendaftaran_Seminar_Ujian/view?usp=sharing',
            '_ppb_sop_langkah_1' => 'Mahasiswa memperoleh tanda tangan persetujuan siap seminar/ujian dari Pembimbing I dan Pembimbing II pada Kartu Kontrol (F-02).',
            '_ppb_sop_langkah_2' => 'Melengkapi berkas persyaratan (KRS berjalan, bukti bebas plagiasi Turnitin <= 25%, dan kartu hadir mengikuti seminar).',
            '_ppb_sop_langkah_3' => 'Menyerahkan berkas verifikasi ke Staf Administrasi Jurusan PPB dan mengisi form pengajuan jadwal.',
            '_ppb_sop_langkah_4' => 'Jurusan menerbitkan undangan resmi dewan penguji serta mempublikasikan jadwal di halaman Jadwal Seminar & Ujian website.',
            '_ppb_sop_langkah_5' => 'Pelaksanaan sidang seminar/ujian di Ruang Sidang Jurusan PPB dan pendokumentasian berita acara nilai.',
        ),
    ),
    array(
        'title' => 'SOP Permohonan Surat Izin Penelitian & Pengambilan Data Lapangan',
        'meta'  => array(
            '_ppb_sop_nomor'     => 'SOP-PPB-ADM-03/2025',
            '_ppb_sop_estimasi'  => '1 - 2 Hari Kerja',
            '_ppb_sop_dok_link'  => 'https://drive.google.com/file/d/1_SOP_Surat_Izin_Penelitian/view?usp=sharing',
            '_ppb_sop_langkah_1' => 'Mahasiswa telah melaksanakan Seminar Proposal dan menyelesaikan revisi instrumen yang disahkan oleh Pembimbing & Penguji.',
            '_ppb_sop_langkah_2' => 'Mengisi Formulir Permohonan Izin Penelitian (F-03) dengan mencantumkan lokasi sekolah/instansi sasaran dan waktu pengambilan data.',
            '_ppb_sop_langkah_3' => 'Verifikasi dan penandatanganan surat pengantar oleh Ketua Jurusan PPB FIP UNM.',
            '_ppb_sop_langkah_4' => 'Penerbitan Surat Izin Penelitian Fakultas melalui Bagian Akademik Dekanat FIP UNM untuk diteruskan ke PTSP / Sekolah Mitra.',
            '_ppb_sop_langkah_5' => '',
        ),
    ),
    array(
        'title' => 'SOP Peminjaman Bilik Konseling & Instrumen Tes Psikologi Laboratorium BK',
        'meta'  => array(
            '_ppb_sop_nomor'     => 'SOP-PPB-LAB-04/2025',
            '_ppb_sop_estimasi'  => '1 Hari Kerja (Konfirmasi Instan)',
            '_ppb_sop_dok_link'  => 'https://drive.google.com/file/d/1_SOP_Peminjaman_Lab_BK/view?usp=sharing',
            '_ppb_sop_langkah_1' => 'Mahasiswa memeriksa ketersediaan bilik konseling atau alat tes psikologi melalui katalog Inventaris Lab BK di website.',
            '_ppb_sop_langkah_2' => 'Mengisi Formulir Peminjaman Lab (F-05) yang diketahui oleh Dosen Pengampu Mata Kuliah Praktikum.',
            '_ppb_sop_langkah_3' => 'Menyerahkan formulir dan Kartu Tanda Mahasiswa (KTM) kepada Laboran / Pengelola Laboratorium BK untuk penjadwalan sesi.',
            '_ppb_sop_langkah_4' => 'Menggunakan fasilitas/instrumen sesuai kode etik kerahasiaan asesmen dan mengembalikan alat dalam kondisi lengkap.',
            '_ppb_sop_langkah_5' => '',
        ),
    ),
    array(
        'title' => 'SOP Layanan Konseling Sebaya & Pendampingan Psikologis Mahasiswa (Satgas PPKS)',
        'meta'  => array(
            '_ppb_sop_nomor'     => 'SOP-PPB-KMH-05/2025',
            '_ppb_sop_estimasi'  => 'Respon Cepat < 24 Jam',
            '_ppb_sop_dok_link'  => 'https://drive.google.com/file/d/1_SOP_Perlindungan_Mahasiswa_BK/view?usp=sharing',
            '_ppb_sop_langkah_1' => 'Mahasiswa mengajukan permohonan sesi konseling rahasia atau pelaporan perlindungan melalui tombol Hotline Konselor Siaga.',
            '_ppb_sop_langkah_2' => 'Tim Konselor Laboratorium BK melakukan asesmen awal (intake interview) dengan jaminan kerahasiaan identitas 100%.',
            '_ppb_sop_langkah_3' => 'Penjadwalan sesi konseling individual tatap muka di Bilik Konseling Lab BK atau sesi cybercounseling daring.',
            '_ppb_sop_langkah_4' => 'Pendampingan psikologis berkelanjutan, advokasi akademik bersama Penasehat Akademik, atau rujukan profesional bila diperlukan.',
            '_ppb_sop_langkah_5' => '',
        ),
    ),
);
bk_clear_and_seed_cpt('ppb_alur_sop', $sop_items);

// 5i. Seed standard WordPress Posts (Berita, Pengumuman, Liputan Prestasi, Opini) - 6 Items
$existing_posts = get_posts(array('post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids'));
foreach ($existing_posts as $pid) {
    wp_delete_post($pid, true);
}

$cat_map = array(
    'berita'     => 'Berita Jurusan',
    'pengumuman' => 'Pengumuman Akademik',
    'prestasi'   => 'Liputan Prestasi',
    'opini'      => 'Opini & Artikel BK',
);
$cat_ids = array();
foreach ($cat_map as $slug => $name) {
    $term = term_exists($slug, 'category');
    if (!$term) {
        $term = wp_insert_term($name, 'category', array('slug' => $slug));
    }
    if (!is_wp_error($term)) {
        $cat_ids[$slug] = (int)(is_array($term) ? $term['term_id'] : $term);
    }
}

$berita_items = array(
    array(
        'title'   => 'Prodi S1 Bimbingan dan Konseling FIP UNM Pertahankan Predikat Akreditasi Unggul LAMDIK',
        'cat'     => 'berita',
        'date'    => date('Y-m-d H:i:s', strtotime('-2 days')),
        'summary' => 'Program Studi S1 Bimbingan dan Konseling Jurusan PPB FIP UNM kembali mengukuhkan reputasi akademik nasional dengan capaian Akreditasi Unggul dari LAMDIK.',
        'author'  => 'Tim Humas PPB FIP UNM',
        'role'    => 'Redaksi Resmi Jurusan',
        'content' => '<p><strong>MAKASSAR</strong> — Program Studi S1 Bimbingan dan Konseling (BK), Jurusan Psikologi Pendidikan dan Bimbingan (PPB), Fakultas Ilmu Pendidikan Universitas Negeri Makassar (FIP UNM) resmi meraih dan mempertahankan peringkat <strong>Akreditasi Unggul</strong> berdasarkan Surat Keputusan Lembaga Akreditasi Mandiri Kependidikan (LAMDIK).</p><p>Capaian tertinggi ini merupakan wujud nyata dedikasi seluruh sivitas akademika—mulai dari pimpinan fakultas, pimpinan jurusan, 25 dosen pengajar bergelar Guru Besar dan Doktor, tenaga kependidikan, mahasiswa, hingga jejaring alumni dan mitra sekolah laboratorium di Sulawesi Selatan.</p><h3>Transformasi Kurikulum OBE dan Digitalisasi Layanan</h3><p>Ketua Jurusan PPB FIP UNM, <strong>Dr. Suciani Latif, M.Pd.</strong>, menyampaikan bahwa penguatan kurikulum berbasis <em>Outcome-Based Education</em> (OBE), integrasi riset konseling berbasis budaya lokal Bugis-Makassar, serta inovasi layanan digital melalui ekosistem <strong>BK-Connect &amp; SIPADU</strong> menjadi poin keunggulan utama dalam asesmen lapangan.</p>',
    ),
    array(
        'title'   => 'Pengumuman Pendaftaran Seminar Proposal, Seminar Hasil, & Ujian Skripsi Gelombang Berjalan',
        'cat'     => 'pengumuman',
        'date'    => date('Y-m-d H:i:s', strtotime('-4 days')),
        'summary' => 'Informasi resmi batas waktu pengajuan berkas verifikasi seminar proposal, seminar hasil, dan ujian tutup skripsi mahasiswa S1 Bimbingan dan Konseling.',
        'author'  => 'Dr. Sahril Buchori, M.Pd., Kons.',
        'role'    => 'Sekretaris Jurusan PPB',
        'content' => '<p>Diberitahukan kepada seluruh mahasiswa Program Studi S1 Bimbingan dan Konseling FIP UNM yang sedang memprogramkan Tugas Akhir/Skripsi bahwa pendaftaran <strong>Seminar Proposal, Seminar Hasil Penelitian, dan Ujian Tutup Skripsi</strong> periode berjalan telah dibuka.</p><h3>Persyaratan Berkas Pendaftaran:</h3><ul><li>Kartu Kontrol Bimbingan (F-02) yang telah ditandatangani oleh Pembimbing I dan Pembimbing II (minimal 8 kali konsultasi).</li><li>Bukti lulus uji kemiripan naskah (Turnitin maksimal 25%) yang diverifikasi oleh staf perpustakaan/laboratorium jurusan.</li><li>Fotokopi KRS semester berjalan dan bukti menghadiri seminar proposal/hasil mahasiswa lain minimal 5 kali.</li></ul><p>Seluruh formulir persuratan dapat diunduh secara mandiri melalui menu <strong>Layanan &rarr; Layanan Akademik</strong> pada portal website ini.</p>',
    ),
    array(
        'title'   => 'Delegasi Mahasiswa BK FIP UNM Sabet Juara 1 Nasional Lomba Microcounseling ABKIN',
        'cat'     => 'prestasi',
        'date'    => date('Y-m-d H:i:s', strtotime('-7 days')),
        'summary' => 'Tim mahasiswa Jurusan PPB FIP UNM berhasil mengharumkan nama almamater dengan meraih Medali Emas pada kompetisi keterampilan konseling tingkat nasional.',
        'author'  => 'Bidang Kemahasiswaan PPB',
        'role'    => 'Pembina Prestasi Mahasiswa',
        'content' => '<p>Prestasi membanggakan kembali ditorehkan oleh mahasiswa Jurusan Psikologi Pendidikan dan Bimbingan (PPB) FIP UNM. Tim delegasi mahasiswa berhasil meraih <strong>Juara 1 Nasional</strong> pada ajang Kompetisi Keterampilan Microcounseling &amp; Inovasi Layanan BK yang diselenggarakan oleh Asosiasi Bimbingan dan Konseling Indonesia (ABKIN).</p><p>Dalam babak final, delegasi BK FIP UNM mendemonstrasikan praktik <em>Solution-Focused Brief Counseling</em> (SFBC) yang dipadukan dengan nilai filosofis budaya lokal <em>Siri\' na Pacce</em> untuk membantu konseli remaja membangun resiliensi akademik.</p>',
    ),
    array(
        'title'   => 'Workshop Penyusunan Perangkat Layanan BK Komprehensif & Asesmen Digital bagi Guru BK Mitra',
        'cat'     => 'berita',
        'date'    => date('Y-m-d H:i:s', strtotime('-11 days')),
        'summary' => 'Jurusan PPB FIP UNM menggelar pelatihan kolaboratif bersama MGBK SMP/SMA/SMK se-Sulawesi Selatan terkait pemanfaatan instrumen asesmen non-tes digital.',
        'author'  => 'Tim Pengabdian Masyarakat PPB',
        'role'    => 'Gugus Riset & PkM Jurusan',
        'content' => '<p>Sebagai bagian dari hilirisasi roadmap penelitian dan pengabdian kepada masyarakat, dosen Jurusan PPB FIP UNM menyelenggarakan kegiatan <strong>Workshop Penyusunan Program BK Komprehensif Berbasis Asesmen Digital</strong> yang diikuti oleh lebih dari 85 guru Bimbingan dan Konseling (MGBK) SMP, SMA, dan SMK mitra.</p><p>Kegiatan yang berlangsung di Laboratorium Konseling &amp; Asesmen Kampus Gunungsari ini melatih para praktisi sekolah dalam mengoperasikan instrumen pemetaan kebutuhan peserta didik serta perancangan media bimbingan klasikal interaktif.</p>',
    ),
    array(
        'title'   => 'Jadwal Pembagian Dosen Penasehat Akademik (PA) & Konsultasi KRS Mahasiswa Baru',
        'cat'     => 'pengumuman',
        'date'    => date('Y-m-d H:i:s', strtotime('-15 days')),
        'summary' => 'Panduan alur perwalian akademik, konsultasi Kartu Rencana Studi (KRS), serta daftar distribusi Dosen Penasehat Akademik (PA) Jurusan PPB.',
        'author'  => 'Sub-Bagian Akademik PPB',
        'role'    => 'Layanan Administrasi Akademik',
        'content' => '<p>Sehubungan dengan dimulainya masa perwalian dan pengisian Kartu Rencana Studi (KRS), seluruh mahasiswa Program Studi S1 Bimbingan dan Konseling diimbau untuk segera melaksanakan konsultasi akademik bersama <strong>Dosen Penasehat Akademik (PA)</strong> masing-masing.</p><p>Dokumen SK Penetapan Dosen PA dapat diunduh melalui halaman <strong>Profil &rarr; Dokumen Mutu</strong>. Mahasiswa diharapkan membawa lembar evaluasi studi semester sebelumnya saat melakukan perwalian.</p>',
    ),
    array(
        'title'   => 'Mengintegrasikan Kearifan Lokal Bugis-Makassar dalam Praktik Konseling Multibudaya di Sekolah',
        'cat'     => 'opini',
        'date'    => date('Y-m-d H:i:s', strtotime('-20 days')),
        'summary' => 'Refleksi keilmuan tentang urgensi pendekatan konseling peka budaya (indigenous counseling) berbasis nilai Sipakatau, Sipakainge, dan Sipakalebbi.',
        'author'  => 'Prof. Dr. H. Abdul Saman, M.Si., Kons.',
        'role'    => 'Guru Besar Bimbingan dan Konseling FIP UNM',
        'content' => '<p>Praktik layanan Bimbingan dan Konseling di Indonesia tidak dapat dilepaskan dari konteks sosiokultural tempat konseli tumbuh dan berinteraksi. Di Sulawesi Selatan, nilai luhur <em>Sipakatau</em> (saling memanusiakan), <em>Sipakainge</em> (saling mengingatkan dengan santun), dan <em>Sipakalebbi</em> (saling menghargai) merupakan fondasi hubungan terapeutik yang sangat kuat antara konselor dan konseli.</p><p>Melalui pilar keilmuan <strong>Konseling Berbasis Budaya Lokal</strong>, Program Studi Bimbingan dan Konseling FIP UNM terus mendorong riset kolaboratif dosen dan mahasiswa untuk memformulasikan model intervensi konseling yang kontekstual, empatik, dan relevan dengan karakter generasi muda Indonesia.</p>',
    ),
);

foreach ($berita_items as $b) {
    $pid = wp_insert_post(array(
        'post_type'     => 'post',
        'post_title'    => $b['title'],
        'post_content'  => $b['content'],
        'post_excerpt'  => $b['summary'],
        'post_status'   => 'publish',
        'post_date'     => $b['date'],
        'post_category' => isset($cat_ids[$b['cat']]) ? array($cat_ids[$b['cat']]) : array(),
    ));
    if ($pid && !is_wp_error($pid)) {
        update_post_meta($pid, '_ppb_berita_ringkasan', $b['summary']);
        update_post_meta($pid, '_ppb_berita_author_nama', $b['author']);
        update_post_meta($pid, '_ppb_berita_author_role', $b['role']);
    }
}
echo "Seeded " . count($berita_items) . " Berita & Pengumuman posts.\n";

update_option('ppb_portal_initial_seeded_v2', 'yes');
update_option('ppb_content_synced_version', '9.7');



}
}
