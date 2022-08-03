<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Hasil Survey</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Hasil Survey</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- <form method="GET">
                <div class="form-row">
                    <div class="col">
                        <label for="q_id">Pilih Pertanyaan</label>
                        <select class="form-control" id="q_id" name="q_id">
                            <option default>Pilih</option>
                            <?php foreach ($pertanyaan as $q) : ?>
                                <option value="<?= $q->id; ?>" <?= $id_pertanyaan == $q->id ? "selected" : ""; ?>><?= $q->pertanyaan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col d-flex align-items-end">
                        <button type="submit" class="btn btn-primary text-white">Tampilkan</button>
                    </div>
                </div>
            </form> -->

    </section>
</div>