        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Aloma Go - develope by <a href="http://illiyin.co" target="_blank">illiyin.co</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= resources_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= resources_url(); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= resources_url(); ?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= resources_url(); ?>vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?= resources_url(); ?>vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- jQuery Sparklines -->
    <script src="<?= resources_url(); ?>vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- Flot -->
    <script src="<?= resources_url(); ?>vendors/Flot/jquery.flot.js"></script>
    <script src="<?= resources_url(); ?>vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?= resources_url(); ?>vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?= resources_url(); ?>vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?= resources_url(); ?>vendors/Flot/jquery.flot.resize.js"></script>
     <!-- bootstrap-wysiwyg -->
    <script src="<?= resources_url(); ?>vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?= resources_url(); ?>vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="<?= resources_url(); ?>vendors/google-code-prettify/src/prettify.js"></script>
    <!-- Flot plugins -->
    <script src="<?= resources_url(); ?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?= resources_url(); ?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?= resources_url(); ?>vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?= resources_url(); ?>vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?= resources_url(); ?>vendors/moment/min/moment.min.js"></script>
    <script src="<?= resources_url(); ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?= resources_url(); ?>build/js/custom.min.js"></script>

    <script>
        $(function(){
            $('#saveBtn').click(function () {
                var mysave = $('#editor-one').html();
                $('#textarea').val(mysave);
            });
        });
    </script>
  </body>
</html>