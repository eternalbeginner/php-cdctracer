<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tracer Study SMK Negeri 2 Tabanan</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/frontend') ?>/img/logo.png" rel="icon">
  <link href="<?= base_url('assets/frontend/alumni') ?>/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/frontend/alumni') ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/frontend/alumni') ?>/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/frontend/alumni') ?>/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/frontend/alumni') ?>/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?= base_url('assets/frontend/alumni') ?>/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/frontend/alumni') ?>/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/frontend/alumni') ?>/css/style.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />

  <!-- =======================================================
  * Template Name: iPortfolio - v1.3.0
  * Template URL: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">
        <img src="<?= base_url('assets') ?>/user/<?= $this->session->userdata('foto') ?>" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light"><?= ucfirst($this->session->userdata('nama_depan')) ?></h1>
        <h1 class="text-light"><?= ucfirst($this->session->userdata('nama_belakang')) ?></h1>
      </div>

      <nav class="nav-menu">
        <ul>
          <li><a href="<?= base_url('alumni') ?>" id="home"><i class="bx bx-home"></i> <span>Back To Home</span></a></li>
          <li><a href="<?= base_url('login/logout') ?>"><i class="bx bx-exit"></i> Log out</a></li>
        </ul>
      </nav><!-- .nav-menu -->
      <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

    </div>
  </header><!-- End Header -->

  <main id="main">
    <section id="contact" class="contact">
      <div class="container">
        <div class="section-title">
          <h2>Detail Lowongan Kerja</h2>
        </div>

        <div class="row" data-aos="fade-in">

          <div class="col-lg-6  align-items-stretch">
            <div class="info">
              <a href="<?= base_url('assets/loker/' . $loker->foto) ?>" data-gall="portfolioGallery" class="venobox" title="Klik untuk memperbesar Gambar"><img src="<?= base_url('assets/loker/' . $loker->foto) ?>" class="img-fluid rounded mx-auto d-block" alt="Responsive image"></a>
            </div>

          </div>

          <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch">
            <div class="info">
              <h4><?= strtoupper($loker->judul) ?></h4>
              <span class='text-justify'><?= $loker->deskripsi ?></span>
              <p class="font-weight-light">Sumber Informasi : <?= ucfirst($loker->nama_depan) . ' ' . ucfirst($loker->nama_belakang) ?></p>

              <!-- <?php if ($user->id === $loker->id_user) : ?>
										<div class="d-flex align-items-center justify-content-end">
												<a  class="btn btn-primary text-white mr-2" data-toggle="modal" data-target="#modal_edit_loker">Edit</a>
												<a class="btn btn-danger" href="<?= base_url('loker/' . $loker->id . '/delete'); ?>">Hapus Loker</a>
										</div>
								<?php endif; ?> -->
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- ======= Footer ======= -->
    <footer id="footer">
      <div class="container">
        <div class="copyright">
          &copy; Copyright <strong><span>Tracer Study <?php echo date('Y'); ?></span></strong>
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/ -->
          Designed by <a href="https://bootstrapmade.com/">I Dewa Komang Raditya Ariawan</a>
        </div>
      </div>
    </footer><!-- End  Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <div class="modal fade" style="z-index: 999999" id="modal_edit_loker" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Loker</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="<?= base_url('loker/' . $loker->id . '/update'); ?>" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="name">Judul Lowongan</label>
                <input type="text" class="form-control" name="judul" id="judul" value="<?= $loker->judul; ?>" required />
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">Tanggal Sekarang</label>
                  <input type="text" name="tgl_buat" class="form-control" id="datepicker" autocomplete="off" value="<?= $loker->tgl_buat; ?>" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Batas Akhir lowongan</label>
                  <input type="text" class="form-control" name="tgl_akhir" id="datepicker1" autocomplete="off" value="<?= $loker->tgl_akhir; ?>" required />
                </div>
              </div>
              <div class="form-group">
                <label for="name">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi"><?= $loker->deskripsi; ?></textarea>
              </div>
              <div class="form-group">
                <label for="name">Foto</label>
                <input type="file" class="form-control" name="foto" />
              </div>
              <div class="d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/jquery.easing/jquery.easing.min.js"></script>
    <!-- <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/php-email-form/validate.js"></script> -->
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/counterup/counterup.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/venobox/venobox.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/typed.js/typed.min.js"></script>
    <script src="<?= base_url('assets/frontend/alumni') ?>/vendor/aos/aos.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>
    <script>
      window.setTimeout(function() {
        $("#alertAlumni").fadeTo(500, 0).slideUp(500, function() {
          $(this).remove();
        });
      }, 2000);
    </script>
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
    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/frontend/alumni') ?>/js/main.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js" type="text/javascript"></script>

</body>

</html>