        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Kabar Burung <small>Kabar berita dan komik</small></h3>
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
                  <div class="form-group">
                          <a href="<?= admin_url() ?>kabar-burung?method=new" type="submit" class="btn btn-success"> Kabar Baru</a>
                        </div>
                      </div>
                  <div class="clearfix"></div>
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title"># </th>
                            <th class="column-title">Judul </th>
                            <th class="column-title">Penulis </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title no-link last"><span class="nobr">Aksi</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          if ( ! $lists->return):
                          ?>
                          <h3 class="text-center">data kabar burung masih kosong!</h3>
                          <?php else:
                          $row = $lists->data;
                          for($i = 0; $i < count($row); $i ++):
                          ?>
                          <tr class="even pointer">
                            <td class=" "><?= $i + 1; ?></td>
                            <td class=" "><?= strlen($row[$i]->judul) > 15 ? 
                            substr($row[$i]->judul, 0, 15).'...' : substr($row[$i]->judul, 0, 15) ?></td>
                            <td class=" "><?= $row[$i]->author; ?></td>
                            <td class=" "><?= $row[$i]->tanggal_waktu->human_datetime ?></td>
                            <td class=" last"><a href="#"><i class="fa fa-eye"></i></a> <a href="<?= admin_url(); ?>kabar-burung?method=edit&encrypted=<?= $row[$i]->key; ?>"><i class="fa fa-pencil-square-o"></i></a>  <a href="#"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <?php 
                          endfor;
                          endif;
                          ?>
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