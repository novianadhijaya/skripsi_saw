<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php echo alert('alert-info', 'Perhatian', 'Silahkan Cheklist Pada Menu Yang Akan Diberikan Akses') ?>
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">KELOLA HAK AKSES UNTUK LEVEL :  <b><?php echo $level['nama_level'] ?></b></h3>
                        <a href="<?php echo site_url('userlevel'); ?>" class="btn btn-danger btn-sm pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nama Modul</th>
                                        <th width="100px">Beri Akses</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    foreach ($menu as $m) {
                                        echo "<tr>
                        <td>$no</td>
                        <td>$m->title</td>
                        <td align='center'><input type='checkbox' ".  checked_akses($this->uri->segment(3), $m->id_menu)." onClick='kasi_akses(this, $m->id_menu)'></td>
                        </tr>";
                                        $no++;
                                    }
                                    ?>
                                </thead>
                                

                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

<div class="modal fade" id="aksesNotifModal" tabindex="-1" role="dialog" aria-labelledby="aksesNotifLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info" id="aksesNotifHeader">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="aksesNotifLabel">Notifikasi</h4>
            </div>
            <div class="modal-body" id="aksesNotifBody">Memproses perubahan akses.</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function show_akses_notif(isChecked, isError){
        var $header = $('#aksesNotifHeader');
        var message = '';
        var headerClass = 'bg-info';

        if (isError) {
            message = 'Gagal memperbarui akses.';
            headerClass = 'bg-red';
        } else if (isChecked) {
            message = 'Akses disimpan.';
            headerClass = 'bg-green';
        } else {
            message = 'Akses dihapus.';
            headerClass = 'bg-red';
        }

        $header.removeClass('bg-info bg-green bg-red').addClass(headerClass);
        $('#aksesNotifBody').text(message);
        $('#aksesNotifModal').modal('show');

        clearTimeout(window.aksesNotifTimer);
        window.aksesNotifTimer = setTimeout(function(){
            $('#aksesNotifModal').modal('hide');
        }, 1200);
    }

    function kasi_akses(checkbox, id_menu){
        var isChecked = $(checkbox).is(':checked');
        var id_menu = id_menu;
        var level = '<?php echo $this->uri->segment(3); ?>';
        $.ajax({
            url:"<?php echo base_url()?>index.php/userlevel/kasi_akses_ajax",
            data:"id_menu=" + id_menu + "&level="+ level ,
            success: function(html)
            { 
                show_akses_notif(isChecked, false);
            },
            error: function()
            {
                $(checkbox).prop('checked', !isChecked);
                show_akses_notif(isChecked, true);
            }
        });
    }    
</script>
