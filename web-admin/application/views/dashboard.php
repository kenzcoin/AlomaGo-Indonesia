        <div class="right_col" role="main">
          <div class="">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                  <div class="count">179</div>
                  <h3>Transaksi</h3>
                  <p>Lorem ipsum psdea itgum rixt.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count">179</div>
                  <h3>Pengguna</h3>
                  <p>Lorem ipsum psdea itgum rixt.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                  <div class="count">179</div>
                  <h3>Pendapatan</h3>
                  <p>Lorem ipsum psdea itgum rixt.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count"><?= ( $dataFeedback->return ) ? count($dataFeedback->data) : 0; ?></div>
                  <h3>Feedback</h3>
                  <p>Lorem ipsum psdea itgum rixt.</p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Transaksi Summary <small>Progress Mingguan</small></h2>
                    <div class="filter">
                      <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <div class="demo-container" style="height:280px">
                        <div id="chart_plot_02" class="demo-placeholder"></div>
                      </div>

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