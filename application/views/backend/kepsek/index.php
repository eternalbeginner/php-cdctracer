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
					<h1 class="m-0 text-dark">Data Kepala Sekolah</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Data Kepala Sekolah</li>
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

				<?php if (!empty($kepsek) || count($kepsek) !== 0) : ?>
					<table class="table">
						<thead>
							<tr>
								<th style="width: 10px">#</th>
								<th>Nama</th>
								<th>NIP</th>
								<th>Email</th>
								<th>Telp</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($kepsek as $_ => $kepsek_data) : ?>
								<tr>
									<td><?= $_ + 1; ?></td>
									<td><?= $kepsek_data->nama; ?></td>
									<td><?= $kepsek_data->nip; ?></td>
									<td><?= $kepsek_data->email; ?></td>
									<td><?= $kepsek_data->telp; ?></td>
									<td>
										<?php if ($user->id_user_grup == "1") : ?>
											<!-- action for role "administrator" -->
										<?php elseif ($user->id_user_grup == "2") : ?>
											<!-- action for role "panitia tracer" -->
										<?php endif; ?>

										<!-- action for all role -->
										<a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_view<?= $kepsek_data->id ?>"><i class="fa fa-eye"></i></a>
										<a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_edit<?= $kepsek_data->id ?>"><i class="fa fa-edit"></i></a>
										<a href="<?= base_url('admin/kepsek/' . $kepsek_data->id . '/delete'); ?>" class="btn btn-danger btn-sm" onclick="return confirm('anda yakin ingini menghapus data tersebut ?')"><i class="fa fa-trash"></i></a>
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
				<h4 class="modal-title">Tambah Data Kepala Sekolah</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/kepsek/create'); ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="nama" class="form-control-label">Nama</label>
						<input type="text" class="form-control" name="nama" autocomplete="off" />
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="nip" class="form-control-label">NIP</label>
							<input type="text" class="form-control" name="nip" maxlength="18" autocomplete="off" />
						</div>
						<div class="form-group col-6">
							<label for="telp" class="form-control-label">Telp</label>
							<input type="text" class="form-control" name="telp" maxlength="15" autocomplete="off" />
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="form-control-label">Email</label>
						<input type="email" class="form-control" name="email" autocomplete="off" />
					</div>
					<div class="form-group">
						<label for="alamat" class="form-control-label">Alamat</label>
						<textarea name="alamat" id="alamat" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>



<?php foreach ($kepsek as $kepsek_data) : ?>
	<div class="modal fade" id="modal_view<?= $kepsek_data->id ?>" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Data Kepala Sekolah</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table">
						<tr>
							<td width="22%"><strong>Nama : </strong></td>
							<td><?= $kepsek_data->nama ?></td>
						</tr>
						<tr>
							<td width="22%"><strong>Nip : </strong></td>
							<td><?= $kepsek_data->nip ?></td>
						</tr>
						<tr>
							<td width="22%"><strong>Email : </strong></td>
							<td><?= $kepsek_data->email ?></td>
						</tr>
						<tr>
							<td width="22%"><strong>Telp : </strong></td>
							<td><?= $kepsek_data->telp ?></td>
						</tr>
						<tr>
							<td width="22%"><strong>Alamat : </strong></td>
							<td><?= $kepsek_data->alamat ?></td>
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

<?php foreach ($kepsek as $kepsek_data) : ?>
	<div class="modal fade" id="modal_edit<?= $kepsek_data->id ?>" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Data Kepala Sekolah</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="<?= base_url('admin/kepsek/' . $kepsek_data->id . '/update'); ?>" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label for="nama" class="form-control-label">Nama</label>
							<input type="text" class="form-control" name="nama" autocomplete="off" value="<?= $kepsek_data->nama ?>" />
						</div>
						<div class="form-row">
							<div class="form-group col-6">
								<label for="nip" class="form-control-label">NIP</label>
								<input type="text" class="form-control" name="nip" maxlength="18" autocomplete="off" value="<?= $kepsek_data->nip ?>" />
							</div>
							<div class="form-group col-6">
								<label for="telp" class="form-control-label">Telp</label>
								<input type="text" class="form-control" name="telp" maxlength="15" autocomplete="off" value="<?= $kepsek_data->telp ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="form-control-label">Email</label>
							<input type="email" class="form-control" name="email" autocomplete="off" value="<?= $kepsek_data->email ?>" />
						</div>
						<div class="form-group">
							<label for="alamat" class="form-control-label">Alamat</label>
							<textarea name="alamat" id="alamat" class="form-control"><?= $kepsek_data->alamat ?> </textarea>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Edit</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
<?php endforeach; ?>