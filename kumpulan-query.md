<!-- #query buat ambil data penilaian karyawan -->

SELECT
    ROW_NUMBER() OVER (ORDER BY nilai DESC) AS no,
    nama_karyawan,
    nilai,
    CASE
        WHEN nilai >= 1 THEN 'Karyawan Teladan'
        ELSE 'Belum Teladan'
    END AS status
FROM (
    SELECT
        f.nama_karyawan,
        (0.4 * b.bobot_kriteria)
      + (0.25 * c.bobot_kriteria)
      + (0.15 * d.bobot_kriteria)
      + (0.2 * e.bobot_kriteria) AS nilai
    FROM nilai AS a
    LEFT JOIN kriteria_absensi_c1        AS b ON a.C1 = b.id_kriteria
    LEFT JOIN kriteria_produktifitas_c2  AS c ON a.C2 = c.id_kriteria
    LEFT JOIN kriteria_kualitaskerja_c3  AS d ON a.C3 = d.id_kriteria
    LEFT JOIN kriteria_perilaku_c4       AS e ON a.C4 = e.id_kriteria
    LEFT JOIN karyawan                   AS f ON f.id_karyawan = a.id_karyawan
) AS X;

<!-- hasil normalisasi -->

SELECT
    f.nama_karyawan,
    a.C1,
    a.C2,
    a.C3,
    a.C4,
    b.bobot_kriteria AS bobot_c1,
    c.bobot_kriteria AS bobot_c2,
    d.bobot_kriteria AS bobot_c3,
    e.bobot_kriteria AS bobot_c4,
    -- Normalisasi (cost/benefit sesuaikan kebutuhan; contoh benefit)
    b.bobot_kriteria / (SELECT MAX(b1.bobot_kriteria) FROM kriteria_absensi_c1 b1) AS norm_c1,
    c.bobot_kriteria / (SELECT MAX(c1.bobot_kriteria) FROM kriteria_produktifitas_c2 c1) AS norm_c2,
    d.bobot_kriteria / (SELECT MAX(d1.bobot_kriteria) FROM kriteria_kualitaskerja_c3 d1) AS norm_c3,
    e.bobot_kriteria / (SELECT MAX(e1.bobot_kriteria) FROM kriteria_perilaku_c4 e1) AS norm_c4,
    -- Skor akhir (SAW)
    (0.4 *
        (b.bobot_kriteria / (SELECT MAX(b1.bobot_kriteria) FROM kriteria_absensi_c1 b1)))
  + (0.25 *
        (c.bobot_kriteria / (SELECT MAX(c1.bobot_kriteria) FROM kriteria_produktifitas_c2 c1)))
  + (0.15 *
        (d.bobot_kriteria / (SELECT MAX(d1.bobot_kriteria) FROM kriteria_kualitaskerja_c3 d1)))
  + (0.2 *
        (e.bobot_kriteria / (SELECT MAX(e1.bobot_kriteria) FROM kriteria_perilaku_c4 e1))) AS nilai_saw
FROM nilai AS a
LEFT JOIN kriteria_absensi_c1        AS b ON a.C1 = b.id_kriteria
LEFT JOIN kriteria_produktifitas_c2  AS c ON a.C2 = c.id_kriteria
LEFT JOIN kriteria_kualitaskerja_c3  AS d ON a.C3 = d.id_kriteria
LEFT JOIN kriteria_perilaku_c4       AS e ON a.C4 = e.id_kriteria
LEFT JOIN karyawan                   AS f ON f.id_karyawan = a.id_karyawan;

<!-- query ambil data perngguna -->

SELECT
    u.id_users,
    u.full_name,
    u.email,
    u.images,
    u.id_user_level,
    u.is_aktif,
    l.nama_level
FROM tbl_user AS u
LEFT JOIN tbl_user_level AS l
    ON u.id_user_level = l.id_user_level
ORDER BY u.id_users;

<!-- query ambil data karyawan -->
SELECT * FROM `karyawan`