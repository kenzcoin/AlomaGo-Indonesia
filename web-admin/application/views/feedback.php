        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Feedback <small>Tanggapan user tentang aplikasi</small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form method="get">
                      <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search for..." autocomplete="off">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="submit">Go!</button>
                        </span>
                      </div>
                    </form>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="clearfix"></div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">Pesan </th>
                            <th class="column-title">User </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title no-link last"><span class="nobr">Aksi</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if ( ! $feedback->return && $this->input->get('q')): ?>
                          <h2 class="text-center">Kata kunci <strong><?= $this->input->get('q')?></strong> untuk pencarian feedback tidak ditemukan</h2>
                          <?php elseif ( ! $feedback->return ): ?>
                          <h2 class="text-center">Data feedback masih kosong!</h2>
                          <?php else:
                          $row = $feedback->data;
                          if ( $this->input->get('q'))
                          {
                            echo '<h2 class="text-center">'.count($row).' data pencarian feedback ditemukan</h2>';
                          }
                          for($i = 0; $i < count($row); $i++):
                          ?>
                          <tr class="even pointer">
                            <td class=" "><?= $i + 1;?></td>
                            <td class=" "><?= strlen($row[$i]->pesan) > 20 ?
                                substr($row[$i]->pesan,0,20).'...' : $row[$i]->pesan;?></td>
                            <td class=" "><?= $row[$i]->nama ?></td>
                            <td class=" "><?= $row[$i]->tanggal_waktu->human_datetime; ?> </td>
                            <td class=" last"><a href="#" onclick="doModal('<?= $row[$i]->id; ?>','<?= $row[$i]->nama; ?>','<?= $row[$i]->pesan; ?>','<?= $row[$i]->tanggal_waktu->human_datetime; ?>')"><i class="fa fa-eye"></i></a>
                            </td>
                          </tr>
                          <?php 
                          endfor;
                          endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->