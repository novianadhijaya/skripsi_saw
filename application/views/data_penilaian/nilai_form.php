<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <style>
                .form-note { color: #6d7c92; margin: 0 0 12px 0; }
            </style>
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA NILAI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
                <div class="box-body">
                    <p class="form-note">Lengkapi nilai karyawan berdasarkan kriteria yang tersedia.</p>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Karyawan (NIK - Nama) <?php echo form_error('id_karyawan') ?></label>
                        <div class="col-sm-6">
                            <select name="id_karyawan" class="form-control select2" style="width:100%;">
                                <option value="">-- Pilih Karyawan --</option>
                                <?php foreach (($karyawan_list ?? []) as $k): ?>
                                    <option value="<?php echo $k->id_karyawan; ?>" <?php echo ($id_karyawan == $k->id_karyawan) ? 'selected' : ''; ?>>
                                        <?php echo $k->nik . ' - ' . $k->nama_karyawan; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <?php
                        $c1List = $list_c1 ?? array();
                        $c2List = $list_c2 ?? array();
                        $c3List = $list_c3 ?? array();
                        $c4List = $list_c4 ?? array();
                        $renderOption = function($row, $selectedId) {
                            $isSelected = ($selectedId == $row->id_kriteria) ? 'selected' : '';
                            $label = $row->pilihan_kriteria . ' — Bobot ' . rtrim(rtrim(number_format($row->bobot_kriteria, 3), '0'), '.');
                            return '<option value="'.$row->id_kriteria.'" '.$isSelected.'>'.$label.'</option>';
                        };
                    ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">C1 (Absensi) <?php echo form_error('C1') ?></label>
                        <div class="col-sm-6">
                            <select name="C1" class="form-control">
                                <option value="">-- Pilih Nilai Absensi --</option>
                                <?php foreach ($c1List as $row) { echo $renderOption($row, $C1); } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">C2 (Produktifitas) <?php echo form_error('C2') ?></label>
                        <div class="col-sm-6">
                            <select name="C2" class="form-control">
                                <option value="">-- Pilih Nilai Produktifitas --</option>
                                <?php foreach ($c2List as $row) { echo $renderOption($row, $C2); } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">C3 (Kualitas Kerja) <?php echo form_error('C3') ?></label>
                        <div class="col-sm-6">
                            <select name="C3" class="form-control">
                                <option value="">-- Pilih Nilai Kualitas Kerja --</option>
                                <?php foreach ($c3List as $row) { echo $renderOption($row, $C3); } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">C4 (Perilaku) <?php echo form_error('C4') ?></label>
                        <div class="col-sm-6">
                            <select name="C4" class="form-control">
                                <option value="">-- Pilih Nilai Perilaku --</option>
                                <?php foreach ($c4List as $row) { echo $renderOption($row, $C4); } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_nilai" value="<?php echo $id_nilai; ?>" />
                    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
                    <a href="<?php echo site_url('data_penilaian'); ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                </div>
            </form>
        </div>
    </section>
</div>
