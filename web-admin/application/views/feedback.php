        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Feedback <small>Tanggapan user tentang aplikasi</small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
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
                          <?php if ( ! $feedback->return ): ?>
                          <h2 class="text-center">Data feedback masih kosong!</h2>
                          <?php else: 
                          $row = $feedback->data;
                          for($i = 0; $i < count($row); $i++):
                          ?>
                          <tr class="even pointer">
                            <td class=" "><?= $i + 1;?></td>
                            <td class=" "><?= strlen($row[$i]->pesan) > 20 ?
                                substr($row[$i]->pesan,0,20).'...' : $row[$i]->pesan;?></td>
                            <td class=" "><?= $row[$i]->nama ?></td>
                            <td class=" "><?= $row[$i]->tanggal_waktu->human_datetime; ?> </td>
                            <td class=" last"><a href="#"><i class="fa fa-eye"></i></a>
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