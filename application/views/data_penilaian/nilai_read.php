<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Nilai Read</h2>
        <table class="table">
	    <tr><td>Id Puskesmas</td><td><?php echo $id_puskesmas; ?></td></tr>
	    <tr><td>C1</td><td><?php echo $C1; ?></td></tr>
	    <tr><td>C2</td><td><?php echo $C2; ?></td></tr>
	    <tr><td>C3</td><td><?php echo $C3; ?></td></tr>
	    <tr><td>C4</td><td><?php echo $C4; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('data_puskesmas_penilaian') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>