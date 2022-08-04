<footer class="main-footer">
  <strong>Copyright &copy; 2022-<?php echo date('Y'); ?> <a href="http://smkn2tabanan.sch.id">SMK Negeri 2 Tabanan</a>.</strong>
  All rights reserved.
  <!-- <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div> -->
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('assets/backend/') ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/backend/') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/backend/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<!-- Sparkline -->
<!-- <script src="<?= base_url('assets/backend/') ?>plugins/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<script src="<?= base_url('assets/backend/') ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url('assets/backend/') ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('assets/backend/') ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/backend/') ?>plugins/moment/moment.min.js"></script>
<script src="<?= base_url('assets/backend/') ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/backend/') ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url('assets/backend/') ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/backend/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/backend/') ?>dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?= base_url('assets/backend/') ?>dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/backend/') ?>dist/js/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    Chart.register(ChartDataLabels)

    Chart.defaults.type = 'doughnut';
    Chart.defaults.plugins.tooltips = { enabled: false };
    Chart.defaults.plugins.datalabels = {
        formatter: (value, ctx) => {
            let sum = ctx.chart.data.datasets[0].data.reduce((p, c) => {
                return p + c
            }, 0);
            let percentage = (value * 100 / sum).toFixed(2) + "%";
            return percentage;
        },
        color: "#fff"
    }

  jQuery(document).ready(function() {
    window.setTimeout(function() {
      jQuery("#alertlogin").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 2000);

    jQuery("#tgl_mulai").datepicker({
      format: "dd mm yyyy"
    });
    jQuery("#tgl_berakhir").datepicker({
      format: "dd mm yyyy"
    });


    jQuery('#showpassword').click(function() {
      if (jQuery('#oldPass').attr('type') == "password") {
        jQuery('#oldPass').attr('type', 'text');
        jQuery('#newPass').attr('type', 'text');
        jQuery('#conPass').attr('type', 'text');
        jQuery('#showpassword').html("<i class='fa fa-eye'></i>  Tutup Password");
      } else {
        jQuery('#oldPass').attr('type', 'password');
        jQuery('#newPass').attr('type', 'password');
        jQuery('#conPass').attr('type', 'password');
        jQuery('#showpassword').html("<i class='fa fa-eye'></i>  Lihat Password");
      }
    });
  });
</script>
</body>

</html>
