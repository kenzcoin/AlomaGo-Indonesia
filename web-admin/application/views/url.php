        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Download URL<small>Edit</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="<?= admin_url() ?>do_action?method=download-url">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Link 1
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="link1" name="link1" required="required" value="<?= $dataUrl->data[0]->content; ?>" class="form-control col-md-7 col-xs-12" autocomplete="off" /> 
                          <span>Keterangan: <?= $dataUrl->data[0]->title; ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Link 2
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="link2" name="link2" required="required" value="<?= $dataUrl->data[1]->content; ?>" class="form-control col-md-7 col-xs-12" autocomplete="off" />
                          <span>Keterangan: <?= $dataUrl->data[1]->title; ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Link 3
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="link3" name="link3" required="required" value="<?= $dataUrl->data[2]->content; ?>" class="form-control col-md-7 col-xs-12" autocomplete="off" />
                          <span>Keterangan: <?= $dataUrl->data[2]->title; ?></span>
                        </div>
                      </div>
                  <br />

                  <div class="ln_solid"></div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                        </form>
                      </div>
                </div>
              </div>
            </div>
        <!-- /page content -->