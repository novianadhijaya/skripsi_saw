<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profil Pengguna</h3>
                    </div>
                    <div class="box-body" style="display:flex; gap:20px; align-items:flex-start; flex-wrap:wrap;">
                        <?php
                        $imgFile = (isset($user->images) && $user->images) ? $user->images : 'default.png';
                        $imgPath = base_url('assets/foto_profil/'.$imgFile);
                        ?>
                        <div style="flex:0 0 140px; text-align:center;">
                            <div style="width:120px; height:120px; margin:0 auto 10px; border-radius:50%; overflow:hidden; border:1px solid #eee; background:#f7f7f7;">
                                <img src="<?php echo $imgPath; ?>" alt="Foto profil" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                            <small class="text-muted">Klik "User" → "Update" untuk ganti foto.</small>
                        </div>
                        <div style="flex:1 1 240px;">
                            <table class="table table-striped" style="margin-bottom:0;">
                                <tr>
                                    <th width="140">Nama</th>
                                    <td><?php echo $user->full_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $user->email; ?></td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td><?php echo isset($level->nama_level) ? $level->nama_level : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo ($user->is_aktif === 'y' || $user->is_aktif == 1) ? 'Aktif' : 'Nonaktif'; ?></td>
                                </tr>
                            </table>
                            <div style="margin-top:12px;">
                                <a href="<?php echo site_url('user/update/'.$user->id_users); ?>" class="btn btn-primary">Edit Profil</a>
                                <a href="<?php echo site_url('welcome'); ?>" class="btn btn-default">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
