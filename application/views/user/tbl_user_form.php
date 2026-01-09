<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA USER</h3>
            </div>
<?php
    $lockProfile = !empty($lock_profile_fields);
    $levelLookup = array();
    foreach (($level_list ?? array()) as $lvl) {
        $levelLookup[$lvl->id_user_level] = $lvl->nama_level;
    }
    $currentLevelName = isset($levelLookup[$id_user_level]) ? $levelLookup[$id_user_level] : '-';
?>
<?php echo form_open_multipart($action); ?>
                <table class="table table-bordered">
                    <tr>
                        <td width="200">Nama Lengkap</td>
                        <td>
                            <?php
                                if ($lockProfile) {
                                    echo '<input type="text" class="form-control" value="'.htmlspecialchars($full_name, ENT_QUOTES).'" readonly>';
                                    echo form_hidden('full_name', $full_name);
                                    echo '<small class="text-muted">Nama tidak dapat diubah dari halaman profil.</small>';
                                } else {
                                    $karyawanOptions = array('' => '-- Pilih dari Karyawan --');
                                    foreach (($karyawan_list ?? array()) as $k) {
                                        $karyawanOptions[$k->nama_karyawan] = $k->nama_karyawan;
                                    }
                                    echo form_dropdown('full_name', $karyawanOptions, $full_name, 'class="form-control"');
                                }
                                echo form_error('full_name', '<div class="text-danger small">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">Email</td>
                        <td>
                            <?php
                                if ($lockProfile) {
                                    echo form_input(array(
                                        'type' => 'email',
                                        'name' => 'email',
                                        'id' => 'email',
                                        'class' => 'form-control',
                                        'value' => $email,
                                        'readonly' => true
                                    ));
                                    echo '<small class="text-muted">Email tidak dapat diubah dari halaman profil.</small>';
                                } else {
                                    echo form_input(array(
                                        'type' => 'email',
                                        'name' => 'email',
                                        'id' => 'email',
                                        'class' => 'form-control',
                                        'placeholder' => 'Email',
                                        'value' => $email
                                    ));
                                }
                                echo form_error('email', '<div class="text-danger small">', '</div>');
                            ?>
                        </td>
                    </tr>
                    
                    <?php if(!empty($show_password)): ?>
                    <tr>
                        <td width="200">Password</td>
                        <td>
                            <?php
                                echo form_password(array(
                                    'name' => 'password',
                                    'id' => 'password',
                                    'class' => 'form-control',
                                    'placeholder' => !empty($id_users) ? 'Kosongkan jika tidak diubah (min 6 karakter)' : 'Password (min 6 karakter)'
                                ));
                                echo form_error('password', '<div class="text-danger small">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr>
                        <td width="200">Level User</td>
                        <td>
                            <?php
                                if ($lockProfile) {
                                    echo '<input type="text" class="form-control" value="'.htmlspecialchars($currentLevelName, ENT_QUOTES).'" readonly>';
                                    echo form_hidden('id_user_level', $id_user_level);
                                    echo '<small class="text-muted">Level tidak dapat diubah dari halaman profil.</small>';
                                } else {
                                    $levelOptions = array('' => '-- Pilih Level --');
                                    foreach (($level_list ?? array()) as $lvl) {
                                        $levelOptions[$lvl->id_user_level] = $lvl->nama_level;
                                    }
                                    echo form_dropdown('id_user_level', $levelOptions, $id_user_level, 'class="form-control"');
                                }
                                echo form_error('id_user_level', '<div class="text-danger small">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">Status Aktif</td>
                        <td>
                            <?php
                                if ($lockProfile) {
                                    $statusLabel = ($is_aktif === 'y' || $is_aktif == 1) ? 'AKTIF' : 'TIDAK AKTIF';
                                    echo '<input type="text" class="form-control" value="'.htmlspecialchars($statusLabel, ENT_QUOTES).'" readonly>';
                                    echo form_hidden('is_aktif', $is_aktif);
                                    echo '<small class="text-muted">Status tidak dapat diubah dari halaman profil.</small>';
                                } else {
                                    echo form_dropdown('is_aktif', array('' => '-- Pilih Status --','y' => 'AKTIF', 'n' => 'TIDAK AKTIF'), $is_aktif, 'class="form-control"');
                                }
                                echo form_error('is_aktif', '<div class="text-danger small">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">Foto Profile</td>
                        <td>
                            <?php
                                echo form_upload(array('name' => 'images'));
                                echo form_error('images', '<div class="text-danger small">', '</div>');

                                if (!empty($images)) {
                                    $src = base_url('assets/foto_profil/'.$images);
                                    echo '<div class="m-t-5"><small>Foto saat ini:</small><br><img src="'.$src.'" alt="Foto profil" style="max-height:120px;border:1px solid #ddd;padding:4px;"></div>';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo form_hidden('id_users', $id_users); ?>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('user/profile') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                        </td>
                    </tr>
                </table>
            <?php echo form_close(); ?>
        </div>
</div>
</div>
