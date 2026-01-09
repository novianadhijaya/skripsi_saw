<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA KARYAWAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nik <?php echo form_error('nik') ?></td>
            <td>
                <input type="text" class="form-control" name="nik" id="nik" placeholder="Boleh dikosongkan, akan otomatis" value="<?php echo $nik; ?>" />
                <small class="text-muted">Kosongkan untuk auto-generate (PREFIX-XXXX) sesuai departemen, atau isi manual jika perlu.</small>
            </td>
        </tr>
	    <tr><td width='200'>Nama Karyawan <?php echo form_error('nama_karyawan') ?></td><td><input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" placeholder="Nama Karyawan" value="<?php echo $nama_karyawan; ?>" /></td></tr>
	    
        <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td> <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea></td></tr>
	    <tr><td width='200'>Departemen <?php echo form_error('departemen') ?></td>
            <td>
                <select name="departemen" id="departemen" class="form-control">
                    <option value="">-- Pilih Departemen --</option>
                    <?php foreach (($departemen_options ?? array()) as $opt): ?>
                        <option value="<?php echo $opt; ?>" <?php echo ($departemen === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                    <?php endforeach; ?>
                </select>
            </td></tr>
	    <tr><td></td><td><input type="hidden" name="id_karyawan" value="<?php echo $id_karyawan; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('karyawan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>
