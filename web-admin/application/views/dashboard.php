        <div class="right_col" role="main">
          <div class="">
            <div class="row top_tiles">
              <?php
              $pendapatan = 0;
              $today = date('Y-m-d');
              $userToday = 0;
              $transToday = 0;
              $feedbackToday = 0;

              if ( $transferPulsa->return)
              {
                foreach($transferPulsa->data as $row)
                {
                  $tanggal = explode(' ' , $row->tanggal_waktu);

                  if ( $tanggal[0] == $today)
                  {
                    $transToday += 1;
                  }

                  $pendapatan += $row->nominal;
                }
              }

              if ( $dataUser->return)
              {
                foreach($dataUser->data as $row)
                {
                    $tanggal = explode(' ' , $row->terdaftar);

                    if ( $tanggal[0] == $today)
                    {
                        $userToday += 1;
                    }
                }
              }

              if ( $dataFeedback->return)
              {
                  foreach($dataFeedback->data as $row)
                  {
                     $tanggal = explode(' ' , $row->tanggal_waktu->real_datetime);

                    if ( $tanggal[0] == $today)
                    {
                        $feedbackToday += 1;
                    }
                  }
              }

              if ( $historyMonthly->return)
              {
                  $mingguSatu = 0;
                  $mingguDua = 0;
                  $mingguTiga = 0;
                  $mingguEmpat = 0;

                  // 7 , 14 , 21 , 28-31
                  foreach ($historyMonthly->data as $row) {
                      // 2017-12-12 (week 2)
                      // 2017-12-1 (week 1)
                      // 2017-12-25 (week 3)
                      // 2017-12-5 (week 1)
                      // 2017-09-11 (week 2)
                      $tanggal_waktu = date('Y-m-d', strtotime($row->tanggal_waktu));

                      if ( $tanggal_waktu >= date('Y-m-01') AND $tanggal_waktu <= date('Y-m-07'))
                      {
                          // $weekly = 'satu';
                          $mingguSatu += 1;
                      }
                      elseif( $tanggal_waktu >= date('Y-m-08') AND $tanggal_waktu <= date('Y-m-14'))
                      {
                          // $weekly = 'dua';
                          $mingguDua += 1;
                      }
                      elseif( $tanggal_waktu >= date('Y-m-15') AND $tanggal_waktu <= date('Y-m-21'))
                      {
                          // $weekly = 'tiga';
                          $mingguTiga += 1;
                      }
                      elseif( $tanggal_waktu >= date('Y-m-22') AND $tanggal_waktu <= date('Y-m-31'))
                      {
                          // $weekly = 'empat';
                          $mingguEmpat += 1;
                      }
                  }
              }
              ?>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                  <div class="count"><?= $transferPulsa->return ? count($transferPulsa->data) : 0?></div>
                  <h3>Transaksi</h3>
                  <p><?= $transToday; ?> transaksi hari ini.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?= $dataUser->return ? count($dataUser->data) : 0; ?></div>
                  <h3>Pengguna</h3>
                  <p><?= $userToday; ?> pengguna terdatar hari ini.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                  <div class="count"><?= Nominal($pendapatan); ?></div>
                  <h3>Pendapatan</h3>
                  <p>Total pendapatan: <?= Rupiah($pendapatan); ?></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count"><?= ( $dataFeedback->return ) ? count($dataFeedback->data) : 0; ?></div>
                  <h3>Feedback</h3>
                  <p><?= $feedbackToday; ?> feedback hari ini.</p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Transaksi Summary (<?= $historyMonthly ? count($historyMonthly->data) : 0?>)<small>Progress Mingguan <strong>September</strong></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <div class="demo-container" style="height:280px">
                        <div id="placeholder" class="demo-placeholder"></div>
                      </div>
                      <form id="weekLabel">
                      <div>Minggu ke-1 sekitar: <span><?= $mingguSatu ?></span> transaksi</div><br/>
                      <div>Minggu ke-2 sekitar: <span><?= $mingguDua ?></span> transaksi</div><br/>
                      <div>Minggu ke-3 sekitar: <span><?= $mingguTiga ?></span> transaksi</div><br/>
                      <div>Minggu ke-4 sekitar: <span><?= $mingguEmpat ?></span> transaksi</div><br/>
                      </form>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                      <div>
                        <div class="x_title">
                          <h2>Top Kabar Burung</h2>
                          <div class="clearfix"></div>
                        </div>
                        <?php if ( ! $topLists->return ): ?>
                        <h2 class="text-center">Tidak ada !</h2>
                        <?php else:
                        ?>
                        <ul class="list-unstyled top_profiles scroll-view">
                        <?php
                        $row = $topLists->data;
                        for($i = 0; $i < count($row); $i++):
                        ?>
                          <li class="media event">
                            <a class="pull-left border-aero profile_thumb" style="padding: 9px 9px !important;">
                              <i class="fa fa-newspaper-o aero"></i>
                            </a>
                            <div class="media-body">
                              <a class="title" href="#"><?= strlen($row[$i]->judul) > 25 ? 
                              substr($row[$i]->judul,0,25).'...' : $row[$i]->judul ?></a>
                              <p><?= strlen($row[$i]->content) > 25 ? 
                              strip_tags(substr($row[$i]->content,0,25)).'...' : strip_tags($row[$i]->content) ?></p>
                              <p> <small><?= $row[$i]->author; ?></small>
                              </p>
                            </div>
                          </li>
                        <?php 
                        endfor;
                        ?>
                        </ul>
                      <?php endif; ?>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>