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
        <h2 style="margin-top:0px">Kriteria_absensi_c1 Read</h2>
        <table class="table">
	    <tr><td>Pilihan Kriteria</td><td><?php echo $pilihan_kriteria; ?></td></tr>
	    <tr><td>Bobot Kriteria</td><td><?php echo $bobot_kriteria; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kriteria_absensi_c1') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>