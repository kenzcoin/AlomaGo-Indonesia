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
                  <?php if ( isset($transfer_pulsa) && ! @$transfer_pulsa->return): ?>
                  <h4 class="text-center">Data History <strong><?= @$list ?></strong> masih kosong</h4>
                    <select name="History" class="form-control" onchange="dateChange(this.value)">
                          <option>-- Pilih Batas Waktu --</option>
                          <option value="all">Semua History</option>
                          <option value="today">Hari ini</option>
                          <option value="yesterday">Kemarin</option>
                          <option value="last7">7 Hari terakhir</option>
                          <option value="last30">30 Hari terakhir</option>
                          <option value="monthly">Bulan ini</option>
                          <option value="lastmonth">Bulan terakhir</option>
                          <option value="custom">Atur Manual</option>
                      </select>
                  <?php else: ?>
                  <?php if ( $this->input->get('list')): ?>
                  <div class="filter col-md-3 pull-left">
                      <h5>Hasil pencarian <strong><?= $list; ?></strong></h5>
                  </div>
                  <?php endif; ?>
                  <div class="filter col-md-3 pull-right">
                    <select name="History" class="form-control" onchange="dateChange(this.value)">
                          <option>-- Pilih Batas Waktu --</option>
                          <option value="all">Semua History</option>
                          <option value="today">Hari ini</option>
                          <option value="yesterday">Kemarin</option>
                          <option value="last7">7 Hari terakhir</option>
                          <option value="last30">30 Hari terakhir</option>
                          <option value="monthly">Bulan ini</option>
                          <option value="lastmonth">Bulan terakhir</option>
                          <option value="custom">Atur Manual</option>
                      </select>
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