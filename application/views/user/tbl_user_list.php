<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA USER</h3>
                    </div>
        
        <div class="box-body">
            <div style="padding-bottom: 10px; display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <?php echo anchor(site_url('user/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
                <form method="get" action="<?php echo site_url('user'); ?>" class="form-inline" style="margin:0; display:flex; gap:6px; flex-wrap:wrap;">
                    <input type="text" name="q" value="<?php echo isset($q) ? htmlspecialchars($q, ENT_QUOTES, 'UTF-8') : ''; ?>" class="form-control input-sm" placeholder="Cari nama / email / level">
                    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i> Cari</button>
                    <?php if (!empty($q)): ?>
                        <a href="<?php echo site_url('user'); ?>" class="btn btn-link btn-sm">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="40px">No</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Nama Level</th>
                        <th>Status</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center">Belum ada data user.</td></tr>
                    <?php else: $no = isset($start) ? $start : 0; foreach ($users as $u): ?>
                        <tr>
                            <td class="text-center"><?php echo ++$no; ?></td>
                            <td><?php echo htmlspecialchars($u->full_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($u->email, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo isset($u->nama_level) ? htmlspecialchars($u->nama_level, ENT_QUOTES, 'UTF-8') : '-'; ?></td>
                            <td><?php echo rename_string_is_aktif($u->is_aktif); ?></td>
                            <td>
                                <?php echo anchor('user/update/'.$u->id_users,'<i class="fa fa-pencil"></i> Edit','class="btn btn-primary btn-xs"'); ?>
                                <?php echo anchor('user/delete/'.$u->id_users,'<i class="fa fa-trash"></i> Delete','class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini?\')"'); ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo isset($total_rows) ? 'Total: '.$total_rows.' pengguna' : ''; ?>
                </div>
                <div class="col-sm-6 text-right">
                    <?php echo isset($pagination) ? $pagination : ''; ?>
                </div>
            </div>
        </div>
        </div>
            </div>
            </div>
    </section>
</div>
