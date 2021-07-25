<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card product-basic">
          <div class="card-header">
            商品情報
            <a class="float-right collapse-toggle" data-toggle="collapse" href="#collapseProductBasic" aria-expanded="true" aria-controls="collapseProductBasic">
              <!-- TODO トグルの開閉に合わせて180度回転 -->
              <img src="/assets/img/arrow-down.svg" alt="ARROW-DOWN-ICON">
            </a>
          </div>
          <!-- TODO トグルが開閉しないのを直す -->
          <div class="collapse show" id="collapseProductBasic">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <div id="carouselProductBasicIndicators" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        <li data-target="#carouselProductBasicIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselProductBasicIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselProductBasicIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselProductBasicIndicators" data-slide-to="3"></li>
                      </ol>
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <div class="bd-placeholder-img bd-placeholder-img-lg w-100">
                            <img class="w-100" src="/uploads/users/鯛サンプル.jpg" alt="PRODUCT-IMG">
                          </div>
                          <div class="carousel-caption d-none d-block">
                            <p>漁獲後</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <div class="bd-placeholder-img bd-placeholder-img-lg w-100">
                            <img class="w-100" src="/uploads/users/鯛サンプル2.jpg" alt="PRODUCT-IMG">
                          </div>
                          <div class="carousel-caption d-none d-block">
                            <p>漁獲後</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <div class="bd-placeholder-img bd-placeholder-img-lg w-100">
                            <img class="w-100" src="/uploads/users/鯛サンプル3.jpg" alt="PRODUCT-IMG">
                          </div>
                          <div class="carousel-caption d-none d-block">
                            <p>卸売受け取り後</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <div class="bd-placeholder-img bd-placeholder-img-lg w-100">
                            <img class="w-100" src="/uploads/users/鯛サンプル4.jpg" alt="PRODUCT-IMG">
                          </div>
                          <div class="carousel-caption d-none d-block">
                            <p>飲食店受け取り後</p>
                          </div>
                        </div>
                      </div>
                      <a class="carousel-control-prev" href="#carouselProductBasicIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselProductBasicIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">魚種</label>
                    <div>
                      タイ
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">目方</label>
                    <div>
                      100.5 kg
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">品質</label>
                    <div>
                      ★★★★☆
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
</template>

<script>
export default {
  data() {
    return {}
  },
  props: {}
}
</script>
