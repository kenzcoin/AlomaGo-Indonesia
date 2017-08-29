        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>History Transaksi <small>Laporan setiap transaksi transfer pulsa</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              

              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php if ( ! $transfer_pulsa->return ): ?>
                  <h4 class="text-center">Data History masih kosong</h4>
                  <?php else: ?>
                  <div class="filter">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Invoice </th>
                            <th class="column-title">Tanggal Invoice </th>
                            <th class="column-title">No. Penerima </th>
                            <th class="column-title">No. Pengirim </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Jumlah </th>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach($transfer_pulsa->data as $row): ?>
                          <tr class="even pointer" onclick="doModal('<?= $row->invoice ?>','<?= humantime($row->tanggal_waktu) ?>','<?= $row->nomer_pengirim ?>',
                          '<?= $row->nomer_tujuan ?>','<?= $row->status == 0 ? 'Pending' : 'Sukses' ?>','<?= Rupiah($row->nominal) ?>')">
                            <td style="cursor: default;">#<?= $row->invoice ?></td>
                            <td style="cursor: default;"><?= humantime($row->tanggal_waktu); ?></td>
                            <td style="cursor: default;"><?= $row->nomer_tujuan; ?></td>
                            <td style="cursor: default;"><?= $row->nomer_pengirim; ?></td>
                            <td style="cursor: default;"><?= $row->status == 0 ? 'Pending' : 'Sukses'; ?></td>
                            <td class="a-right a-right "><?= Rupiah($row->nominal); ?></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->