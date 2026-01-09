<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>APPLIKASI SAW</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <?php
    $thresholdValue = isset($threshold_value) ? $threshold_value : 0.80;
    $midThreshold = isset($mid_threshold) ? $mid_threshold : 0.60;
    $rankingRows = isset($ranking_chart) ? $ranking_chart : array();
    $chartLabels = isset($ranking_labels) ? $ranking_labels : array();
    $chartValues = isset($ranking_values) ? $ranking_values : array();
    $statusCounts = isset($status_counts) ? $status_counts : array('teladan' => 0, 'perlu' => 0, 'belum' => 0);
    $topScore = isset($top_score) ? $top_score : 0;
    $topName = isset($top_name) ? $top_name : '';
    $teladanCount = isset($statusCounts['teladan']) ? $statusCounts['teladan'] : 0;
    $perluCount = isset($statusCounts['perlu']) ? $statusCounts['perlu'] : 0;
    $belumCount = isset($statusCounts['belum']) ? $statusCounts['belum'] : 0;
    ?>

    <section class="content">
        <style>
            .chart-container { position: relative; min-height: 360px; }
            #nilaiSpkEmpty { display: none; padding-top: 140px; color: #888; }
            .status-note { font-size: 12px; color: #777; margin-top: 4px; display: block; }
        </style>

        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Karyawan Teladan</span>
                        <span class="info-box-number"><?php echo $teladanCount; ?></span>
                        <span class="progress-description">Nilai >= <?php echo number_format($thresholdValue, 2); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-refresh"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Perlu Peningkatan</span>
                        <span class="info-box-number"><?php echo $perluCount; ?></span>
                        <span class="progress-description">Rentang <?php echo number_format($midThreshold, 2); ?> - <?php echo number_format($thresholdValue, 2); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-user-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Belum Teladan</span>
                        <span class="info-box-number"><?php echo $belumCount; ?></span>
                        <span class="progress-description">Nilai &lt; <?php echo number_format($midThreshold, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafik Nilai Proses SPK (Ranking)</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart-container">
                            <canvas id="nilaiSpkChart"></canvas>
                            <div id="nilaiSpkEmpty" class="text-center">Data ranking belum tersedia.</div>
                        </div>
                        <span class="status-note">Nilai tersaji setelah normalisasi bobot kriteria.</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Distribusi Status</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart-container">
                            <canvas id="nilaiSpkPie"></canvas>
                        </div>
                        <span class="status-note">Pembagian status dihitung otomatis dari nilai akhir.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabel Skor SPK (SAW)</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:50px">No</th>
                                    <th>Nama Karyawan</th>
                                    <th style="width:120px">Nilai</th>
                                    <th style="width:140px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rows = $rankingRows;
                                if (count($rows) === 0): ?>
                                    <tr><td colspan="4" class="text-center">Data ranking belum tersedia.</td></tr>
                                <?php else:
                                    foreach ($rows as $idx => $row):
                                        $nilaiFloat = (float)$row->nilai;
                                        if ($nilaiFloat >= $thresholdValue) {
                                            $statusText = 'Karyawan Teladan';
                                            $statusClass = 'label-success';
                                        } elseif ($nilaiFloat >= $midThreshold) {
                                            $statusText = 'Perlu Peningkatan';
                                            $statusClass = 'label-warning';
                                        } else {
                                            $statusText = 'Belum Teladan';
                                            $statusClass = 'label-default';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $idx + 1; ?></td>
                                            <td><?php echo $row->nama_karyawan; ?></td>
                                            <td><?php echo rtrim(rtrim(number_format($nilaiFloat, 3), '0'), '.'); ?></td>
                                            <td><span class="label <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                        </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="<?php echo base_url() ?>assets/js/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var rankingLabels = <?php echo json_encode(array_values($chartLabels)); ?>;
    var rankingValues = <?php echo json_encode(array_map('floatval', $chartValues)); ?>;
    var statusCounts = <?php echo json_encode(array(
        isset($statusCounts['teladan']) ? $statusCounts['teladan'] : 0,
        isset($statusCounts['perlu']) ? $statusCounts['perlu'] : 0,
        isset($statusCounts['belum']) ? $statusCounts['belum'] : 0,
    )); ?>;

    var barCanvas = document.getElementById('nilaiSpkChart');
    var pieCanvas = document.getElementById('nilaiSpkPie');
    var emptyMsg = document.getElementById('nilaiSpkEmpty');

    if (!barCanvas || typeof Chart === 'undefined') {
        if (emptyMsg && !rankingLabels.length) {
            emptyMsg.style.display = 'block';
        }
        return;
    }

    if (!rankingLabels.length) {
        barCanvas.style.display = 'none';
        if (pieCanvas) { pieCanvas.style.display = 'none'; }
        if (emptyMsg) { emptyMsg.style.display = 'block'; }
        return;
    }

    var cleanedValues = rankingValues.map(function(value) {
        var numeric = parseFloat(value);
        return isFinite(numeric) ? numeric : 0;
    });

    var maxValue = cleanedValues.length ? Math.max.apply(null, cleanedValues) : 1;
    var suggestedMax = maxValue < 1 ? 1 : Math.ceil(maxValue * 10) / 10;

    new Chart(barCanvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: rankingLabels,
            datasets: [{
                label: 'Nilai',
                data: cleanedValues,
                backgroundColor: 'rgba(52, 152, 219, 0.75)',
                borderColor: 'rgba(41, 128, 185, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            title: { display: false },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: suggestedMax,
                        callback: function(value) {
                            var num = Number(value);
                            return isFinite(num) ? num.toFixed(2) : value;
                        }
                    },
                    gridLines: { color: 'rgba(0,0,0,0.05)' }
                }],
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 25,
                        minRotation: 0,
                        fontSize: 10
                    },
                    gridLines: { display: false }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        var value = Number(tooltipItem.yLabel);
                        var formatted = isFinite(value) ? value.toFixed(2) : tooltipItem.yLabel;
                        return label + ': ' + formatted;
                    }
                }
            }
        }
    });

    if (pieCanvas) {
        new Chart(pieCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Karyawan Teladan', 'Perlu Peningkatan', 'Belum Teladan'],
                datasets: [{
                    data: statusCounts,
                    backgroundColor: ['#2ecc71', '#f5a623', '#95a5a6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { position: 'right' },
                cutoutPercentage: 55,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index] || '';
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || 0;
                            return label + ': ' + value + ' orang';
                        }
                    }
                }
            }
        });
    }
});
</script>
