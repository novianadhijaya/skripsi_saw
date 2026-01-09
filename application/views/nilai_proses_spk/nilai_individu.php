<?php
$thresholdValue = isset($threshold) ? (float)$threshold : 0.80;
$midThreshold = isset($midThreshold) ? (float)$midThreshold : 0.60;
$weights = array('C1' => 0.40, 'C2' => 0.25, 'C3' => 0.15, 'C4' => 0.20);
$photoFile = $this->session->userdata('images');
$photoUrl = base_url().'assets/foto_profil/'.($photoFile ? $photoFile : 'default.png');

$fmt = function($number, $decimals = 3) {
    return rtrim(rtrim(number_format((float)$number, $decimals), '0'), '.');
};
?>

<div class="content-wrapper">
    <section class="content">
        <style>
            .panel-hero {
                background: linear-gradient(135deg, #0e9ed0, #0b6c9d);
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
                flex: 1 1 200px;
                background: rgba(255,255,255,0.10);
                border-radius: 8px;
                padding: 10px 12px;
                border: 1px solid rgba(255,255,255,0.14);
                text-align: center;
            }
            .stat-card .label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; opacity: 0.9; }
            .stat-card .value { font-size: 18px; font-weight: 800; }
            .pill { display: inline-block; padding: 4px 8px; border-radius: 9px; font-weight: 700; border: 1px solid rgba(255,255,255,0.45); font-size: 11px; }
            .pill-success { background: #27ae60; color: #fff; }
            .pill-warning { background: #f5a623; color: #fff; }
            .pill-neutral { background: #95a5a6; color: #fff; }
            .card {
                background: #fff;
                border: 1px solid #e6e9ef;
                border-radius: 10px;
                padding: 14px 16px;
                box-shadow: 0 6px 16px rgba(0,0,0,0.05);
                margin-bottom: 12px;
            }
            .identity {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .identity img {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                border: 2px solid rgba(255,255,255,0.5);
                object-fit: cover;
                background: rgba(255,255,255,0.2);
            }
            .badge-status { font-weight: 700; padding: 6px 10px; border-radius: 8px; font-size: 12px; }
            .badge-success { background: #e8f8f0; color: #1e824c; border: 1px solid #a8e0c7; }
            .badge-warning { background: #fff5e6; color: #c77a11; border: 1px solid #f5d7a6; }
            .badge-neutral { background: #f2f4f5; color: #5f6b7a; border: 1px solid #d3d9e0; }
            .table thead th { vertical-align: middle !important; }
            .table-hover tbody tr:hover { background: #f7fbff; }
            .muted { color: #7b8a9b; }
        </style>

        <div class="panel-hero">
            <div class="identity">
                <img src="<?php echo $photoUrl; ?>" alt="Foto Profil">
                <div>
                    <h3 style="margin:0;">Hasil Penilaian Individu</h3>
                    <small>Skor SAW berdasarkan data penilaian karyawan yang sedang login.</small>
                </div>
            </div>
            <div class="stat-cards">
                <div class="stat-card">
                    <div class="label">Nama</div>
                    <div class="value"><?php echo htmlentities($namaSession); ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Nilai</div>
                    <div class="value">
                        <?php echo $scoreRow ? $fmt($scoreRow->nilai, 3) : '-'; ?>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="label">Status</div>
                    <div class="value">
                        <?php if ($scoreRow): ?>
                            <span class="pill <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                        <?php else: ?>
                            <span class="pill pill-neutral">Belum Dinilai</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!$scoreRow): ?>
            <div class="card">
                <strong>Data penilaian belum tersedia.</strong>
                <div class="muted" style="margin-top:6px;">Karyawan ini belum memiliki data penilaian. Silakan hubungi admin atau lengkapi data penilaian terlebih dahulu.</div>
            </div>
        <?php else: ?>
            <div class="card">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <div>
                        <strong>Rincian Normalisasi & Bobot</strong>
                    </div>
                    <span class="badge-status <?php echo ($statusClass === 'pill-success') ? 'badge-success' : (($statusClass === 'pill-warning') ? 'badge-warning' : 'badge-neutral'); ?>">
                        <?php echo $statusText; ?>
                    </span>
                </div>
                <div class="table-responsive" style="margin-top:10px;">
                    <table class="table table-bordered table-striped table-hover" style="margin-bottom: 10px">
                        <thead>
                            <tr class="bg-info">
                                <th width="140">Kriteria</th>
                                <th width="140" class="text-center">Bobot</th>
                                <th width="180" class="text-center">Normalisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowsDetail = array(
                                array('label' => 'C1 - Absensi', 'raw' => (float)$scoreRow->C1, 'norm' => (float)$scoreRow->normC1, 'weight' => $weights['C1'], 'choice' => isset($scoreRow->C1_label) ? $scoreRow->C1_label : ''),
                                array('label' => 'C2 - Produktifitas', 'raw' => (float)$scoreRow->C2, 'norm' => (float)$scoreRow->normC2, 'weight' => $weights['C2'], 'choice' => isset($scoreRow->C2_label) ? $scoreRow->C2_label : ''),
                                array('label' => 'C3 - Kualitas Kerja', 'raw' => (float)$scoreRow->C3, 'norm' => (float)$scoreRow->normC3, 'weight' => $weights['C3'], 'choice' => isset($scoreRow->C3_label) ? $scoreRow->C3_label : ''),
                                array('label' => 'C4 - Perilaku', 'raw' => (float)$scoreRow->C4, 'norm' => (float)$scoreRow->normC4, 'weight' => $weights['C4'], 'choice' => isset($scoreRow->C4_label) ? $scoreRow->C4_label : ''),
                            );
                            $totalScore = 0;
                            foreach ($rowsDetail as $rd) {
                                $contrib = $rd['norm'] * $rd['weight'];
                                $totalScore += $contrib;
                                ?>
                                <tr>
                                    <td><?php echo $rd['label']; ?></td>
                                    <td class="text-center"><?php echo $fmt($rd['weight'], 2); ?></td>
                                    <td class="text-center">
                                        <?php echo $fmt($rd['norm'], 3); ?>
                                        <?php if (!empty($rd['choice'])): ?>
                                            <div style="margin-top:6px; font-size:12px; color:#5f6b7a; background:#eef4ff; display:inline-block; padding:4px 8px; border-radius:12px;">
                                                <?php echo htmlspecialchars($rd['choice'], ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Skor SAW</strong></td>
                                <td class="text-center"><strong><?php echo $fmt($totalScore, 3); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                // Tampilkan substitusi angka untuk transparansi perhitungan
                $normC1 = $fmt($scoreRow->normC1, 3);
                $normC2 = $fmt($scoreRow->normC2, 3);
                $normC3 = $fmt($scoreRow->normC3, 3);
                $normC4 = $fmt($scoreRow->normC4, 3);
                $contribC1 = $fmt(((float)$scoreRow->normC1 * $weights['C1']), 3);
                $contribC2 = $fmt(((float)$scoreRow->normC2 * $weights['C2']), 3);
                $contribC3 = $fmt(((float)$scoreRow->normC3 * $weights['C3']), 3);
                $contribC4 = $fmt(((float)$scoreRow->normC4 * $weights['C4']), 3);
                $totalFormatted = $fmt($totalScore, 3);
                ?>
                <div class="muted" style="font-size:12px; margin-top:10px;">
                    Rumus: S = (normC1×0.40)+(normC2×0.25)+(normC3×0.15)+(normC4×0.20)<br>
                    Substitusi: S = (<?php echo $normC1; ?>×0.40)+(<?php echo $normC2; ?>×0.25)+(<?php echo $normC3; ?>×0.15)+(<?php echo $normC4; ?>×0.20)
                    = (<?php echo $contribC1; ?> + <?php echo $contribC2; ?> + <?php echo $contribC3; ?> + <?php echo $contribC4; ?>) = <strong><?php echo $totalFormatted; ?></strong>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>
