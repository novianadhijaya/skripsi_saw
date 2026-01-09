<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <style>
                        .table-hover tbody tr:hover { background: #fffaf2; }
                        .criteria-chip { display: inline-block; padding: 3px 8px; border-radius: 12px; background: #eef3fb; color: #1f3a56; font-weight: 600; min-width: 38px; text-align: center; }
                        .criteria-empty { background: #f1f1f1; color: #888; }
                    </style>
                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA NILAI</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="margin-bottom: 12px;">
                            <div class="col-md-8">
                                <form method="get" action="<?php echo site_url('data_penilaian'); ?>" class="form-inline" style="margin-top:8px;">
                                    <div class="form-group">
                                        <input type="text" name="q" value="<?php echo isset($q) ? $q : ''; ?>" class="form-control input-sm" placeholder="Cari NIK / Nama / Departemen / Alamat">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                                    <?php if (!empty($q)) : ?>
                                        <a href="<?php echo site_url('data_penilaian'); ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reset</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php if (!empty($flash)) : ?>
                                    <div class="alert alert-success alert-dismissible" style="margin-top:8px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo $flash; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="bg-warning">
                                        <th class="text-center" width="40">No</th>
                                        <th width="110">NIK</th>
                                        <th width="180">Nama Karyawan</th>
                                        <th width="120">Departemen</th>
                                        <th width="240">Alamat</th>
                                        <th width="140">C1 Absensi</th>
                                        <th width="140">C2 Produktifitas</th>
                                        <th width="140">C3 Kualitas Kerja</th>
                                        <th width="200">C4 Perilaku</th>
                                        <th class="text-center" width="140">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no=1;
                                    $hasData = $record && $record->num_rows() > 0;
                                    if (!$hasData): ?>
                                        <tr><td colspan="10" class="text-center">Belum ada data penilaian.</td></tr>
                                    <?php else:
                                        foreach ($record->result() as $r) {
                                            $actions = '';
                                            if (!empty($r->id_nilai)) {
                                                $actions .= anchor('data_penilaian/update/'.$r->id_nilai,'<i class="fa fa-pencil"></i> Edit', 'class="btn btn-primary btn-xs"');
                                                $actions .= ' ';
                                                $actions .= anchor('data_penilaian/delete/'.$r->id_nilai,'<i class="fa fa-trash"></i> Delete', 'class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini?\')"');
                                            } else {
                                                $actions .= anchor('data_penilaian/create?id_karyawan='.$r->id_karyawan,'<i class="fa fa-plus"></i> Insert', 'class="btn btn-success btn-xs"');
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $r->nik; ?></td>
                                                <td><?php echo $r->nama_karyawan; ?></td>
                                                <td><?php echo $r->departemen; ?></td>
                                                <td><?php echo $r->alamat; ?></td>
                                                <td><span class="criteria-chip <?php echo $r->C1 ? '' : 'criteria-empty'; ?>"><?php echo $r->C1 ?: '-'; ?></span></td>
                                                <td><span class="criteria-chip <?php echo $r->C2 ? '' : 'criteria-empty'; ?>"><?php echo $r->C2 ?: '-'; ?></span></td>
                                                <td><span class="criteria-chip <?php echo $r->C3 ? '' : 'criteria-empty'; ?>"><?php echo $r->C3 ?: '-'; ?></span></td>
                                                <td><span class="criteria-chip <?php echo $r->C4 ? '' : 'criteria-empty'; ?>"><?php echo $r->C4 ?: '-'; ?></span></td>
                                                <td class="text-center" style="white-space: nowrap;"><?php echo $actions; ?></td>
                                            </tr>
                                    <?php } endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
