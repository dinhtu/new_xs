<template>
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-sm-3 col-xs-12">
          <div class="card">
            <div class="card-header">
              QRコード新規発行 & 出力
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="num_of_sheets">枚数</label>
                    <select class="form-select form-control" id="num_of_sheets" name="num_of_sheets">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8" selected>8</option>
                    </select>
                  </div>
                  <div class="txt-info">
                    <button class="btn btn-block btn-info btn-w-120 m-auto" type="button">QRコード発行</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-9 col-xs-12">
          <div class="card">
            <div class="card-header">
              QRコード新規発行 & 出力
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="code_box">
                    <div class="form-group mb-2">
                      <div class="txt-info d-flex flex-row-reverse">
                        <button class="btn btn-danger" type="button">PDFダウンロード</button>
                      </div>
                    </div>
                    <div class="container code_frame">
                      <!-- <p class="code_fr_pl m-auto">ここに印刷用QRコードが表示されます</p> -->
                      <div class="row code_list">
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                        <div class="code_item col-sm-6 col-xs-6">
                          <div class="code_cotent content_left">
                            ZeniMoto-170
                          </div>
                          <div class="code_cotent content_right">
                            <img :src="data.QRCodeImg" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <a class="a-link" href="#">パスワード変更はこちら</a>
        </div>
        <div class="col-sm-12">
          <a class="a-link" href="#">メールアドレス変更はこちら</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        baseUrl: Laravel.baseUrl,
      }
    },
    props: ['data']
  }
</script>
