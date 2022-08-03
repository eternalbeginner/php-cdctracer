  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    if ($this->session->userdata('login')) { ?>
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show" id="alertlogin">
        <span class="badge badge-pill badge-dark">Success</span>
        <?= $this->session->userdata('login') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php
    }
    $this->session->set_userdata('login', '');
    ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <?php if ($this->session->userdata('id_user_grup') == '2') { ?>
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-info ">
                <div class="inner">
                  <h2 class="display-4 font-weight-bold text-center"><?= $user ?></h2>
                  <h4 class="text-center font-weight-bold">Users Alumni</h4>
                </div>
                <div class="icon ">
                  <i class="fa fa-users "></i>
                </div>
                <a href="<?= base_url('admin/alumni') ?>" class="small-box-footer">Kelola Alumni <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h2 class="display-4 font-weight-bold text-center"><?= $survey ?></h2>
                  <h4 class="text-center font-weight-bold">Survey Tersedia</h4>

                </div>
                <div class="icon">
                  <i class="fa fa-edit"></i>
                </div>
                <a href="<?= base_url('backend/survey') ?>" class="small-box-footer">Kelola Survey <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
          <?php } else { ?>
            <!-- <div class="col-lg-6 col-6">
              <div class="small-box bg-primary ">
                <div class="inner">
                  <h2 class="display-3 font-weight-bold text-center"><?= $userDosen ?></h2>
                  <h4 class="text-center font-weight-bold">Users Dosen</h4>
                </div>
                <div class="icon ">
                  <i class="fa fa-users "></i>
                </div>
                <?php if ($this->session->userdata('id_user_grup') != '4') : ?>
                  <a href="<?= base_url('admin/dosen'); ?>" class="small-box-footer">
                    Kelola Dosen
                    <i class="fas fa-arrow-circle-right"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div> -->
            <!-- ./col -->
            <div class="col-lg-12 col-12">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h2 class="display-3 font-weight-bold text-center"><?= $user ?></h2>
                  <h4 class="text-center font-weight-bold">Users Alumni</h4>

                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <?php if ($this->session->userdata('id_user_grup') != '4') : ?>
                  <a href="<?= base_url('admin/alumni'); ?>" class="small-box-footer">
                    Kelola Alumni
                    <i class="fas fa-arrow-circle-right"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- PIE CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Persentase Alumni Yang Bekerja Sesuai Bidang</h3>
                <?php
                $priaDSN = 0;
                $perempuanDSN = 0;
                $jmlhJKDSN = array();

                foreach ($usersDosen as $dosen) :
                  if ($dosen->jenis_kelamin == 'L') {
                    $priaDSN += 1;
                  } else {
                    $perempuanDSN += 1;
                  }
                endforeach;

                array_push($jmlhJKDSN, $priaDSN);
                array_push($jmlhJKDSN, $perempuanDSN);
                ?>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="jkChartDSN" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <!-- PIE CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Jumlah Gender Alumni</h3>
                <?php
                $pria = 0;
                $perempuan = 0;
                $jmlhJK = array();

                foreach ($users as $user) {
                  if ($user->jenis_kelamin == 'L') {
                    $pria += 1;
                  } else {
                    $perempuan += 1;
                  }
                }

                array_push($jmlhJK, $pria);
                array_push($jmlhJK, $perempuan);
                ?>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="jkChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="mt-4">
            <?php if (is_null($pertanyaan_terpilih)) : ?>
              <h3>Silahkan pilih pertanyaan untuk ditampilkan</h3>
            <?php else : ?>
              <div>
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title"> <span class="font-weight-bold">PERTANYAAN : </span> <?= $pertanyaan_terpilih->pertanyaan ?></h3>

                  </div>
                  <div class="card-body">
                    <canvas id="pieChart<?= $pertanyaan_terpilih->id ?>" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                  </div>
                  <?php
                  $pertanyaan = array();
                  $jmlhJawaban = array();
                  $warnaAll = array('#4addac', '#00a65a', '#FC4A1A', '#F7B733', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#FFFF00', '#FFD700', '#FF69B4', '#4B0082', '#B0C4DE', '#00FF00', '#9370DB', '#191970', '#000080', '#FF4500', '#B0E0E6', '#8B4513');
                  foreach ($jawaban as $ans) :
                    $jawaban = 0;
                    if ($ans->id_pertanyaan == $pertanyaan_terpilih->id) {
                      $jdl = "'" . $ans->jawaban . "'";
                      array_push($pertanyaan, $jdl);
                      foreach ($jawaban_terpilih as $sel_ans) :
                        if ($sel_ans->jawaban == $ans->id && $sel_ans->id_pertanyaan == $pertanyaan_terpilih->id) {
                          $jawaban += 1;
                        }
                      endforeach;
                      array_push($jmlhJawaban, $jawaban);
                    }
                  endforeach;
                  $j = sizeof($pertanyaan);
                  $pilihWarna = array();
                  for ($x = 0; $x < $j; $x++) {
                    $wrn = "'" . $warnaAll[$x] . "'";
                    array_push($pilihWarna, $wrn);
                  }

                  ?>
                  <!-- /.card-body -->
                  <script src="<?= base_url('assets/backend/') ?>plugins/jquery/jquery.min.js"></script>

                  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>

                  <script>
                    $(function() {
                      var pieChart = '#pieChart<?= $pertanyaan_terpilih->id ?>';
                      var pieChartCanvas = $(pieChart).get(0).getContext('2d');
                      var donutData = {
                        labels: [<?= join(',', $pertanyaan) ?>],
                        datasets: [{
                          data: [<?= join(',', $jmlhJawaban) ?>],
                          backgroundColor: [<?= join(',', $pilihWarna) ?>],
                        }]
                      }
                      var pieData = donutData;
                      var pieOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                      }
                      //Create pie or douhnut chart
                      // You can switch between pie and douhnut using the method below.
                      var pieChart = new Chart(pieChartCanvas, {
                        type: 'pie',
                        data: pieData,
                        options: pieOptions
                      });
                    });
                  </script>
                  <?php
                  $p = sizeof($jmlhJawaban);
                  $jmlh = 0;
                  for ($l = 0; $l < $p; $l++) {
                    $jmlh += $jmlhJawaban[$l];
                  }

                  ?>
                  <h5 class="p-3">Jumlah Responden : <span class="font-weight-bold"> <?= $jmlh ?> </span> Responden </h5>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"> <span class="font-weight-bold"> Hasil K-Means </h3>
              </div>
              <?php
              $hasilJumlahData = $kmeans->jumlahData1 + $kmeans->jumlahData2;
              $data1 = ($kmeans->jumlahData1 / $hasilJumlahData) * 100;
              $data2 = ($kmeans->jumlahData2 / $hasilJumlahData) * 100;
              ?>
              <div class="card-body">
                <canvas id="pieChartKmeans" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div> -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="<?= base_url('assets/backend/') ?>plugins/jquery/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
  <script>
    $(function() {
      var pieChart = '#jkChartDSN';
      var pieChartCanvas = $(pieChart).get(0).getContext('2d');
      var donutData = {
        labels: ['Ya', 'Tidak'],
        datasets: [{
          data: [<?= join(',', $jmlhJKDSN) ?>],
          backgroundColor: ['#4addac', '#FC4A1A'],
        }]
      }
      var pieData = donutData;
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      });
    });
  </script>
  <script>
    $(function() {
      var pieChart = '#jkChart';
      var pieChartCanvas = $(pieChart).get(0).getContext('2d');
      var donutData = {
        labels: ['Laki-Laki', 'Perempuan'],
        datasets: [{
          data: [<?= join(',', $jmlhJK) ?>],
          backgroundColor: ['#4addac', '#FC4A1A'],
        }]
      }
      var pieData = donutData;
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      });
    });
  </script>
  <script>
    $(function() {
      var pieChart = '#pieChartKmeans';
      var pieChartCanvas = $(pieChart).get(0).getContext('2d');
      var donutData = {
        labels: ['Sesuai Konsentrasi (%)', 'Tidak Sesuiai Konsentrasi (%)'],
        datasets: [{
          data: [<?= $data1 ?>, <?= $data2 ?>],
          backgroundColor: ['#1abc9c', '#2ecc71'],
        }]
      }
      var pieData = donutData;
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      });
    });
  </script>