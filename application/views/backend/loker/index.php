<script src="<?= base_url('assets/frontend/alumni') ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/frontend/alumni') ?>/js/main.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js" type="text/javascript"></script>
<div class="content-wrapper">

    <?php
    if (!empty($this->session->flashdata('kondisi'))) {
        if ($this->session->flashdata('kondisi') == "1") {
    ?>
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show" id="alertlogin">
                <span class="badge badge-pill badge-success">Success</span>
                <?= $this->session->flashdata('msg') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        } else {
        ?>
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" id="alertlogin">
                <span class="badge badge-pill badge-danger">Failed</span>
                <?= $this->session->flashdata('msg') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        }
        ?>

    <?php
    }
    $this->session->set_userdata('status', '');
    $this->session->set_userdata('kondisi', '');
    ?>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Loker</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Data Loker</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-end">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal_create_kepsek">Tambah</butt>
            </div>
            <div class="card-body">
                <?php if (!empty($loker) || count($loker) !== 0) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Judul</th>
                                <th>Durasi</th>
                                <th>Pembuat</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loker as $_ => $loker_data) : ?>
                                <tr>
                                    <td><?= $_ + 1; ?></td>
                                    <td><?= $loker_data->judul; ?></td>
                                    <td><?= $loker_data->tgl_buat; ?> s/d <?= $loker_data->tgl_akhir; ?></td>
                                    <td><?= $loker_data->nama_depan . $loker_data->nama_belakang ?></td>
                                    <td> <img width="100px" src="<?= base_url('assets/loker/' . $loker_data->foto) ?>" width="100%" class="img-fluid" alt=""></td>

                                    <td><?= $loker_data->status; ?></td>
                                    <td>
                                        <?php if ($user->id_user_grup == "1") : ?>
                                            <!-- action for role "administrator" -->
                                        <?php elseif ($user->id_user_grup == "2") : ?>
                                            <!-- action for role "panitia tracer" -->
                                        <?php endif; ?>

                                        <!-- action for all role -->
                                        <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_view<?= $loker_data->id ?>"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_edit<?= $loker_data->id ?>"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url('loker/' . $loker_data->id . '/delete'); ?>" class="btn btn-danger btn-sm" onclick="return confirm('anda yakin ingini menghapus data tersebut ?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="d-flex align-items-center justify-content-center">
                        <p>Data Kepsek Kosong</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- modals section -->
<div class="modal fade" id="modal_create_kepsek" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Lowongan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/loker/create/' . $this->session->userdata('id')) ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Judul Lowongan</label>
                        <input type="text" class="form-control" name="judul" id="judul" required />
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Tanggal Sekarang</label>
                            <input type="text" name="tgl_buat" class="form-control" id="datepicker" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Batas Akhir lowongan</label>
                            <input type="text" class="form-control" name="tgl_akhir" id="datepicker1" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Foto</label>
                        <input type="file" class="form-control" name="foto" required />
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-primary">Simpan</button></div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal  -->
<?php foreach ($loker as $loker_data) : ?>
    <div class="modal fade" id="modal_view<?= $loker_data->id ?>" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Loker</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td width="35%" rowspan="11">
                                <img src="<?= base_url('assets/loker/' . $loker_data->foto) ?>" alt="<?= $loker_data->foto ?>" class="img-thumbnail">
                            </td>
                            <td width="22%"><strong>Judul : </strong></td>
                            <td><?= $loker_data->judul ?></td>
                        </tr>
                        <tr>
                            <td width="22%"><strong>Deskripsi : </strong></td>
                            <td><?= $loker_data->deskripsi ?></td>
                        </tr>
                        <tr>
                            <td width="22%"><strong>Tanggal Buat : </strong></td>
                            <td><?= $loker_data->tgl_buat ?></td>
                        </tr>
                        <tr>
                            <td width="22%"><strong>Tanggal Akhir : </strong></td>
                            <td><?= $loker_data->tgl_akhir ?></td>
                        </tr>
                        <tr>
                            <td width="22%"><strong>Status : </strong></td>
                            <td><?= $loker_data->status ?></td>
                        </tr>
                    </table>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php endforeach; ?>

<?php foreach ($loker as $loker_data) : ?>
    <div class="modal fade" id="modal_edit<?= $loker_data->id ?>" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Loker</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('loker/' . $loker_data->id . '/update'); ?>" method="POST" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Judul Lowongan</label>
                                <input type="text" class="form-control" name="judul" id="judul" required value="<?= $loker_data->judul ?>" />
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Tanggal Sekarang</label>
                                    <input type="text" name="tgl_buat" class="form-control" id="datepicker<?= $loker_data->id ?>" required value="<?= $loker_data->tgl_buat ?>" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">Batas Akhir lowongan</label>
                                    <input type="text" class="form-control" name="tgl_akhir" id="datepicker<?= $loker_data->id ?>" required value="<?= $loker_data->tgl_akhir ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi<?= $loker_data->id ?>" rows="10"><?= $loker_data->judul ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Foto</label>
                                <input type="file" class="form-control" name="foto" />
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select name="status" class="form-control">
                                    <option value="publish" <?= ($loker_data->status == 'publish') ? 'selected' : '' ?>>Publish</option>
                                    <option value="unpublish" <?= ($loker_data->status == 'unpublish') ? 'selected' : '' ?>>Unpublish</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                    <script>
                        ClassicEditor
                            .create(document.querySelector('#deskripsi<?= $loker_data->id ?>'))
                            .then(editor => {
                                console.log(editor);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    </script>
                    <script>
                        $(document).ready(function() {

                            $("#datepicker<?= $loker_data->id ?>").datepicker({
                                autoclose: true,
                                format: 'dd mm yyyy'
                            });
                            $("#datepicker<?= $loker_data->id ?>").datepicker({
                                autoclose: true,
                                format: 'dd mm yyyy'
                            });
                        });
                    </script>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php endforeach; ?>



<script>
    ClassicEditor
        .create(document.querySelector('#deskripsi'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    $(document).ready(function() {
        $("#datepicker").datepicker({
            autoclose: true,
            format: 'dd mm yyyy'
        });
        $("#datepicker1").datepicker({
            autoclose: true,
            format: 'dd mm yyyy'
        });

        $('#showpassword').click(function() {
            if ($('#oldPass').attr('type') == "password") {
                $('#oldPass').attr('type', 'text');
                $('#newPass').attr('type', 'text');
                $('#conPass').attr('type', 'text');
                $('#showpassword').html("<i class='bx bx-show-alt'></i>  Tutup Password");
            } else {
                $('#oldPass').attr('type', 'password');
                $('#newPass').attr('type', 'password');
                $('#conPass').attr('type', 'password');
                $('#showpassword').html("<i class='bx bx-show-alt'></i>  Lihat Password");
            }
        });
    });
</script>