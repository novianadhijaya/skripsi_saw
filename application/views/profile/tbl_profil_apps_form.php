<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <style>
                .profil-wrap { padding: 10px; }
                .profil-card { display: flex; flex-wrap: wrap; gap: 18px; align-items: flex-start; }
                .profil-fields { flex: 1 1 320px; }
                .profil-logo { width: 260px; max-width: 100%; text-align: center; }
                .profil-logo img { max-width: 100%; border-radius: 8px; border: 1px solid #eee; }
                @media (max-width: 767px) {
                    .profil-card { flex-direction: column; }
                    .profil-logo { width: 100%; }
                }
            </style>
            <div class="box-header with-border">
                <h3 class="box-title">PROFIL APLIKASI</h3>
            </div>
            <form enctype="multipart/form-data" action="<?php echo $action; ?>" method="post">
                <div class="box-body profil-wrap">
                    <div class="profil-card">
                        <div class="profil-fields">
                            <div class="form-group">
                                <label>Nama Apps <?php echo form_error('nama_apps') ?></label>
                                <input type="text" class="form-control" name="nama_apps" id="nama_apps" placeholder="Nama Rumah Sakit" value="<?php echo $nama_apps; ?>" />
                            </div>
                            <div class="form-group">
                                <label>Judul Skripsi <?php echo form_error('judul') ?></label>
                                <textarea class="form-control" rows="3" name="judul" id="judul" placeholder="Judul skripsi"><?php echo $judul; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Logo <?php echo form_error('logo') ?></label>
                                <input type="file" name="logo" class="form-control">
                            </div>
                        </div>
                        <div class="profil-logo">
                            <p><strong>Pratinjau Logo</strong></p>
                            <img src="<?php echo base_url('assets/foto_profil/'.$logo); ?>" alt="Logo" onerror="this.src='<?php echo base_url('assets/foto_profil/logo2.png'); ?>'">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                    <a href="<?php echo site_url('profile') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                </div>
            </form>
        </div>
    </section>
</div>
