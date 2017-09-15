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
                    <div class="x_content">
                      <?php 
                      $postdata = $this->input->post();
                      if ( $postdata): 
                      $tanggalAwal = strtotime($postdata['tanggalAwal']);
                      $tanggalAkhir = strtotime($postdata['tanggalAkhir']);

                      $sort = "[custom:".$tanggalAwal.'|'.$tanggalAkhir."]";
                      $data['transfer_pulsa'] = $this->EndpointInterface->getTransferPulsa($this->authToken, $sort);

                      if ( $data['transfer_pulsa']->return ): 
                      ?>
                      <div class="filter col-md-6 pull-left">
                          <h5 class="text-left"><?= count($data['transfer_pulsa']->data)?> data history transfer pulsa ditemukan.</h5>
                      </div>
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
                              <?php foreach($data['transfer_pulsa']->data as $row): ?>
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
                      <?php else: ?>
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
                      <?php endif; ?>
                      <?php else: ?>
                      <form id="customRange" class="form-horizontal form-label-left" action="<?= admin_url(); ?>history?list=custom" method="post">
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tanggal Awal <span class="required">*</span>
                          </label>

                          <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder="Tanggal Awal" aria-describedby="inputSuccess2Status" name="tanggalAwal">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tanggal Akhir <span class="required">*</span>
                          </label>
                          <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="Tanggal Akhir" aria-describedby="inputSuccess2Status3" name="tanggalAkhir">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                        </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <button type="submit" id="saveBtn" class="btn btn-success">Simpan</button>
                        </div>
                      </form>
                      <?php endif; ?> 
                  </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->