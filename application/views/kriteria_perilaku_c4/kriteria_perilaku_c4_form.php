<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA KRITERIA_PERILAKU_C4</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Pilihan Kriteria <?php echo form_error('pilihan_kriteria') ?></td><td><input type="text" class="form-control" name="pilihan_kriteria" id="pilihan_kriteria" placeholder="Pilihan Kriteria" value="<?php echo $pilihan_kriteria; ?>" /></td></tr>
	    <tr><td width='200'>Bobot Kriteria <?php echo form_error('bobot_kriteria') ?></td><td><input type="text" class="form-control" name="bobot_kriteria" id="bobot_kriteria" placeholder="Bobot Kriteria" value="<?php echo $bobot_kriteria; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_kriteria" value="<?php echo $id_kriteria; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('kriteria_perilaku_c4') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>