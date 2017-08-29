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

    <!-- SweetAlert -->
    <script type="text/javascript" src="<?= resources_url(); ?>build/js/sweetalert.min.js"></script>

    <script type="text/javascript">
        <?php if ( $this->uri->segment(2) == 'feedback'): ?>
        function doModal(a,b,x,y)
        {
          /* a = id , b = nama , x = pesan , y = tanggal_waktu */
              html =  '<div id="dynamicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
              html += '<div class="modal-dialog">';
              html += '<div class="modal-content">';
              html += '<div class="modal-header">';
              html += '<a class="close" data-dismiss="modal">×</a>';
              html += '<h4 class="modal-title">Feedback #'+ a +'</h4>'
              html += '</div>';
              html += '<div class="modal-body">';
              html += '<h6>Nama</h6><h5>' + b + '</h5>';
              html += '<hr/>';
              html += '<h6>Pesan</h6><h5>' + x + '</h5>';
              html += '<hr/>';
              html += '<h6>Terkirim</h6><h5>' + y + '</h5>';
              html += '</div>';
              html += '<div class="modal-footer">';
              html += '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
              html += '</div>';  // content
              html += '</div>';  // dialog
              html += '</div>';  // footer
              html += '</div>';  // modalWindow
              $('body').append(html);
              $("#dynamicModal").modal();
              $("#dynamicModal").modal('show');

              $('#dynamicModal').on('hidden.bs.modal', function (e) {
                  $(this).remove();
              });
        }

        <?php elseif( $this->uri->segment(2) == 'history'): ?>
        function doModal(inv, invDt, sender, to , status, nominal)
        {
          /* a = id , b = nama , x = pesan , y = tanggal_waktu */
              html =  '<div id="dynamicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
              html += '<div class="modal-dialog">';
              html += '<div class="modal-content">';
              html += '<div class="modal-header">';
              html += '<a class="close" data-dismiss="modal">×</a>';
              html += '<h4 class="modal-title">Invoice #'+ inv +' <small>' + invDt + '</small></h4>'
              html += '</div>';
              html += '<div class="modal-body">';
              html += '<h6>No. Pengirim</h6><h5>' + sender + '</h5>';
              html += '<hr/>';
              html += '<h6>No. Penerima</h6><h5>' + to + '</h5>';
              html += '<hr/>';
              html += '<h6> Status</h6><h5>' + status + '</h5>';
              html += '<hr/>';
              html += '<h6>Nominal</h6><h5>' + nominal + '</h5>';
              html += '</div>';
              html += '<div class="modal-footer">';
              html += '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
              html += '</div>';  // content
              html += '</div>';  // dialog
              html += '</div>';  // footer
              html += '</div>';  // modalWindow
              $('body').append(html);
              $("#dynamicModal").modal();
              $("#dynamicModal").modal('show');

              $('#dynamicModal').on('hidden.bs.modal', function (e) {
                  $(this).remove();
              });
        }
        <?php endif; ?>
    </script>
    
    <script>
        $(function(){
            $('#saveBtn').click(function () {
                var mysave = $('#editor-one').html();
                $('#textarea').val(mysave);
            }); 

             $("#imagePreview").hide();
        });

        <?php if ( $this->uri->segment(2) == 'kabar-burung'): ?>

        function deleteKabarBurung(x , nextUri)
        {
            swal({
              title: "Hapus kabar burung?",
              text: "<strong>" + x + "</strong> akan dihapus. Jika setuju, klik Ok",
              type: "warning",
              html: true,
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ok",
              closeOnConfirm: false,
              closeButtonText: "Batalkan",
              showLoaderOnConfirm: true
            },
            function(){
              setTimeout(function(){
                  window.location.href = nextUri;
              }, 2000);
            });
        }

        function readURL(input , tags) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#' + tags).attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#gambarUtama").change(function(){
            readURL(this , 'imagePreview');
            $("#imagePreview").show();
        });

        $("#btnUpload").click(function(){
            $("#imgUpload").trigger('click');
        });

        $("#imgUpload").change(function(){
            readURL(this, 'imgPreview');
             $("#imgPreview").show();
        });
        <?php endif; ?>
    </script>
  </body>
</html>