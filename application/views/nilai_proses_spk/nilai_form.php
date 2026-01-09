<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA NILAI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Id Puskesmas <?php echo form_error('id_puskesmas') ?></td><td><input type="text" class="form-control" name="id_puskesmas" id="id_puskesmas" placeholder="Id Puskesmas" value="<?php echo $id_puskesmas; ?>" /></td></tr>
	    <tr><td width='200'>C1 <?php echo form_error('C1') ?></td><td><input type="text" class="form-control" name="C1" id="C1" placeholder="C1" value="<?php echo $C1; ?>" /></td></tr>
	    <tr><td width='200'>C2 <?php echo form_error('C2') ?></td><td><input type="text" class="form-control" name="C2" id="C2" placeholder="C2" value="<?php echo $C2; ?>" /></td></tr>
	    <tr><td width='200'>C3 <?php echo form_error('C3') ?></td><td><input type="text" class="form-control" name="C3" id="C3" placeholder="C3" value="<?php echo $C3; ?>" /></td></tr>
	    <tr><td width='200'>C4 <?php echo form_error('C4') ?></td><td><input type="text" class="form-control" name="C4" id="C4" placeholder="C4" value="<?php echo $C4; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_nilai" value="<?php echo $id_nilai; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('nilai_proses_spk') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>