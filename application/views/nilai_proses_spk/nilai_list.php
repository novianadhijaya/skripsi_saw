<?php
$rows = $record->result();
$rankingRows = $ranking->result();
$unscoredEmployees = isset($unscored_employees) ? $unscored_employees : array();
$unscoredCount = isset($unscored_count) ? $unscored_count : count($unscoredEmployees);


$sumc1=$sumc2=$sumc3=$sumc4=0;
$maxc1=$maxc2=$maxc3=$maxc4=0;
foreach ($rows as $r) {
    $sumc1+=$r->C1; $sumc2+=$r->C2; $sumc3+=$r->C3; $sumc4+=$r->C4;
    $maxc1 = max($maxc1, $r->C1);
    $maxc2 = max($maxc2, $r->C2);
    $maxc3 = max($maxc3, $r->C3);
    $maxc4 = max($maxc4, $r->C4);
}

$thresholdValue = isset($threshold) ? (float)$threshold : 0.80;
$midThreshold = 0.60;
$teladanCount=$perluCount=$belumCount=0;
foreach ($rankingRows as $p) {
    $nilai = (float)$p->nilai;
    if ($nilai >= $thresholdValue) { $teladanCount++; }
    elseif ($nilai >= $midThreshold) { $perluCount++; }
    else { $belumCount++; }
}
$totalRanking = count($rankingRows);
?>

<div class="content-wrapper">
    <section class="content">
        <style>
            .panel-hero {
                background: linear-gradient(135deg, #142850, #274690);
                color: #fff;
                border-radius: 10px;
                padding: 14px 18px;
                box-shadow: 0 10px 22px rgba(0,0,0,0.18);
                margin-bottom: 12px;
            }
            .panel-hero h3 { margin: 0 0 6px 0; font-weight: 800; font-size: 20px; }
            .panel-hero small { color: rgba(255,255,255,0.85); font-size: 12px; }
            .stat-cards { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }
            .stat-card {
                flex: 1 1 160px;
                background: rgba(255,255,255,0.08);
                border-radius: 8px;
                padding: 10px 12px;
                border: 1px solid rgba(255,255,255,0.14);
                text-align: center;
            }
            .stat-card .label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; opacity: 0.9; }
            .stat-card .value { font-size: 18px; font-weight: 800; }
            .table-responsive { margin-bottom: 0; }
            .table thead th { vertical-align: middle !important; }
            .table-hover tbody tr:hover { background: #f7fbff; }
            .pill { display: inline-block; padding: 3px 8px; border-radius: 999px; font-weight: 600; }
            .pill-success { background: #2ecc71; color: #fff; }
            .pill-warning { background: #f5a623; color: #fff; }
            .pill-neutral { background: #95a5a6; color: #fff; }
            .note-card {
                margin-top: 10px;
                background: rgba(255,255,255,0.08);
                border: 1px solid rgba(255,255,255,0.16);
                border-radius: 8px;
                padding: 10px 12px;
                color: #eaf1ff;
            }
            .note-status-list { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
            .note-status { display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 7px; padding: 5px 8px; min-width: 180px; }
            .note-status.pdf-action { margin-left: auto; }
            .note-status__desc { font-size: 11px; color: #dce5ff; }
            .pill { display: inline-block; padding: 4px 8px; border-radius: 9px; font-weight: 700; border: 1px solid rgba(255,255,255,0.45); font-size: 11px; }
            .pill.teladan { background: #27ae60; color: #fff; }
            .pill.perlu { background: #f5a623; color: #fff; }
            .pill.belum { background: #95a5a6; color: #fff; }
            .alert-unscored {
                background: #fffef5;
                border: 1px solid #f5e6a7;
                border-radius: 10px;
                padding: 14px;
                margin: 12px 0 10px 0;
                box-shadow: 0 6px 14px rgba(0,0,0,0.04);
            }
            .alert-unscored__header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 8px;
            }
            .alert-unscored__subtitle { font-size: 11px; color: #6c5b02; margin-top: 2px; }
            .alert-unscored__table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }
            .alert-unscored__table th, .alert-unscored__table td {
                border: 1px solid #f0e2a4;
                padding: 8px 10px;
            }
            .alert-unscored__table th {
                background: #fff7d1;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .5px;
            }
            .alert-unscored__more { font-size: 12px; color: #6c5b02; margin-top: 6px; }
        </style>

        <div class="panel-hero">
            <h3>Hasil Prediksi SAW</h3>
            <small>Ringkasan perhitungan nilai dan ranking karyawan.</small>
            <div class="stat-cards">
                <div class="stat-card">
                    <div class="label">Total Karyawan</div>
                    <div class="value"><?php echo $totalRanking; ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Karyawan Teladan</div>
                    <div class="value"><?php echo $teladanCount; ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Perlu Peningkatan</div>
                    <div class="value"><?php echo $perluCount; ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Belum Teladan</div>
                    <div class="value"><?php echo $belumCount; ?></div>
                </div>
            </div>
            <div class="note-card">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; margin-bottom:8px;">
                    <strong>Catatan Status</strong>
                    
                </div>
                <div class="note-status-list">
                    <div class="note-status">
                        <span class="pill teladan">Teladan</span>
                        <span class="note-status__desc">Nilai >= <?php echo $thresholdValue; ?></span>
                    </div>
                    <div class="note-status">
                        <span class="pill perlu">Perlu Peningkatan</span>
                        <span class="note-status__desc"><?php echo $midThreshold; ?> <= Nilai < <?php echo $thresholdValue; ?></span>
                    </div>
                    <div class="note-status">
                        <span class="pill belum">Belum Teladan</span>
                        <span class="note-status__desc">Nilai < <?php echo $midThreshold; ?></span>
                    </div>
                    <div class="note-status pdf-action">
                        <a href="<?php echo site_url('nilai_proses_spk/print_pdf'); ?>" target="_blank" class="btn btn-default btn-sm" style="background:#e74c3c; color:#fff; border:none; box-shadow:0 6px 12px rgba(0,0,0,0.2);">
                        <i class="fa fa-file-pdf-o"></i> Cetak Laporan PDF
                    </a>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($unscoredCount > 0): ?>
        <div class="alert-unscored">
            <div class="alert-unscored__header">
                <div>
                    <strong><?php echo $unscoredCount; ?> karyawan belum dinilai.</strong>
                    <div class="alert-unscored__subtitle">Lengkapi penilaian agar hasil ranking akurat.</div>
                </div>
                <div>
                    <a href="<?php echo site_url('data_penilaian'); ?>" class="btn btn-default btn-sm">Kelola data penilaian</a>
                </div>
            </div>
            <table class="alert-unscored__table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:55px;">No</th>
                        <th>Nama Karyawan</th>
                        <th style="width:170px;">NIK</th>
                        <th style="width:120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $idx=1; foreach (array_slice($unscoredEmployees, 0, 5) as $emp): ?>
                    <tr>
                        <td class="text-center"><?php echo $idx++; ?></td>
                        <td><?php echo $emp->nama_karyawan; ?></td>
                        <td><?php echo !empty($emp->nik) ? $emp->nik : '-'; ?></td>
                        <td class="text-center">
                            <a class="btn btn-xs btn-primary" href="<?php echo site_url('data_penilaian/create?id_karyawan='.$emp->id_karyawan); ?>">Nilai sekarang</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($unscoredCount > 5): ?>
                <div class="alert-unscored__more">+<?php echo $unscoredCount - 5; ?> karyawan lain belum dinilai.</div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Rating Kecocokan</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 10px">
                                <thead>
                                    <tr class="bg-danger">
                                        <th class="text-center" width="50">No</th>
                                        <th width="220">Nama Karyawan</th>
                                        <th width="120">C1 ABSENSI</th>
                                        <th width="120">C2 PRODUKTIFITAS</th>
                                        <th width="120">C3 KUALITAS KERJA</th>
                                        <th width="120">C4 PERILAKU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach ($rows as $r) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $r->nama_karyawan; ?></td>
                                            <td><?php echo $r->C1; ?></td>
                                            <td><?php echo $r->C2; ?></td>
                                            <td><?php echo $r->C3; ?></td>
                                            <td><?php echo $r->C4; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Hasil Hitung Normalisasi</h3>
                    </div>
                    <div class="box-body">
                        <p class="text-muted" style="margin-top:0;">Setiap kolom dibagi dengan nilai maksimum kolom tersebut.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 10px">
                                <thead>
                                    <tr class="bg-warning">
                                        <th class="text-center" width="50">No</th>
                                        <th width="220">Nama Karyawan</th>
                                        <th width="180">C1 Absensi</th>
                                        <th width="180">C2 Produktifitas</th>
                                        <th width="180">C3 Kualitas Kerja</th>
                                        <th width="180">C4 Perilaku</th>
                                        <th width="200">Hasil (Bobot)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach ($rows as $r) :
                                        $hasil_c1 = $maxc1 ? $r->C1 / $maxc1 : 0;
                                        $hasil_c2 = $maxc2 ? $r->C2 / $maxc2 : 0;
                                        $hasil_c3 = $maxc3 ? $r->C3 / $maxc3 : 0;
                                        $hasil_c4 = $maxc4 ? $r->C4 / $maxc4 : 0;
                                        $weighted = ($hasil_c1 * 0.40) + ($hasil_c2 * 0.25) + ($hasil_c3 * 0.15) + ($hasil_c4 * 0.20);
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $r->nama_karyawan; ?></td>
                                            <td><strong><?php echo rtrim(rtrim(number_format($hasil_c1, 4), '0'), '.'); ?></strong></td>
                                            <td><strong><?php echo rtrim(rtrim(number_format($hasil_c2, 4), '0'), '.'); ?></strong></td>
                                            <td><strong><?php echo rtrim(rtrim(number_format($hasil_c3, 4), '0'), '.'); ?></strong></td>
                                            <td><strong><?php echo rtrim(rtrim(number_format($hasil_c4, 4), '0'), '.'); ?></strong></td>
                                            <td>
                                                <strong><?php echo rtrim(rtrim(number_format($weighted, 3), '0'), '.'); ?></strong><br>
                                                <small class="text-muted">
                                                    (<?php echo rtrim(rtrim(number_format($hasil_c1,3), '0'), '.'); ?>×0.40)
                                                    + (<?php echo rtrim(rtrim(number_format($hasil_c2,3), '0'), '.'); ?>×0.25)
                                                    + (<?php echo rtrim(rtrim(number_format($hasil_c3,3), '0'), '.'); ?>×0.15)
                                                    + (<?php echo rtrim(rtrim(number_format($hasil_c4,3), '0'), '.'); ?>×0.20)
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Hasil Penilaian Karyawan</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 10px">
                                <thead>
                                    <tr class="bg-info">
                                        <th width="80">Ranking</th>
                                        <th width="220">Nama Karyawan</th>
                                        <th width="120">Nilai</th>
                                        <th width="140">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rankingRows as $p) :
                                        $nilaiFloat = (float) $p->nilai;
                                        if ($nilaiFloat >= $thresholdValue) {
                                            $statusText = 'Karyawan Teladan';
                                            $statusClass = 'pill-success';
                                        } elseif ($nilaiFloat >= $midThreshold) {
                                            $statusText = 'Perlu Peningkatan';
                                            $statusClass = 'pill-warning';
                                        } else {
                                            $statusText = 'Belum Teladan';
                                            $statusClass = 'pill-neutral';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo isset($p->ranking) ? $p->ranking : '-'; ?></td>
                                            <td><?php echo $p->nama_karyawan; ?></td>
                                            <td><?php echo rtrim(rtrim(number_format($nilaiFloat, 3), '0'), '.'); ?></td>
                                            <td><span class="pill <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
