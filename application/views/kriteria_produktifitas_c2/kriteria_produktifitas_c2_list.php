<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA KRITERIA_PRODUKTIFITAS_C2</h3>
                    </div>
        
        <div class="box-body">
            <div class='row'>
            <div class='col-md-9'>
            <div style="padding-bottom: 10px;"'>
        <?php echo anchor(site_url('kriteria_produktifitas_c2/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?></div>
            </div>
            <div class='col-md-3'>
            <form action="<?php echo site_url('kriteria_produktifitas_c2/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('kriteria_produktifitas_c2'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            </div>
        
   
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Pilihan Kriteria</th>
		<th>Bobot Kriteria</th>
		<th>Action</th>
            </tr><?php
            foreach ($kriteria_produktifitas_c2_data as $kriteria_produktifitas_c2)
            {
                ?>
                <tr>
			<td width="10px"><?php echo ++$start ?></td>
			<td><?php echo $kriteria_produktifitas_c2->pilihan_kriteria ?></td>
			<td><?php echo $kriteria_produktifitas_c2->bobot_kriteria ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				
				echo '  '; 
				echo anchor(site_url('kriteria_produktifitas_c2/update/'.$kriteria_produktifitas_c2->id_kriteria),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm"'); 
				echo '  '; 
				echo anchor(site_url('kriteria_produktifitas_c2/delete/'.$kriteria_produktifitas_c2->id_kriteria),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
        </div>
                    </div>
            </div>
            </div>
    </section>
</div>