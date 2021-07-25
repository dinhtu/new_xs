<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card product-distribution">
          <div class="card-header">
            流通情報
            <a class="float-right collapse-toggle" data-toggle="collapse" href="#collapseProductDistribution" aria-expanded="true" aria-controls="collapseProductDistribution">
              <!-- TODO トグルの開閉に合わせて180度回転 -->
              <img src="/assets/img/arrow-down.svg" alt="ARROW-DOWN-ICON">
            </a>
          </div>
          <!-- TODO トグルが開閉しないのを直す -->
          <div class="collapse show" id="collapseProductDistribution">
            <div class="card-body">

              <div class="row tracking-distribution">
                <div class="col-sm-12">
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <div class="title">
                    <span>生産者</span>
                    <span>フラットアワー合同会社</span>
                  </div>
                </div>
                <div class="col-sm-12 comment">
                  <img class="balloon-left" src="/assets/img/balloon-left.png" alt="BALLON-LEFT">
                  <div class="body">
                    <div class="row">
                      <div class="col-3 attr label">水揚げ日</div>
                      <div class="col-9 attr ">2021年7月12日</div>
                    </div>
                    <div class="row">
                      <div class="col-3 attr label">出荷日</div>
                      <div class="col-9 attr">2021年7月15日</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row tracking-distribution">
                <div class="col-sm-12">
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <div class="title">
                    <span>卸売業者</span>
                    <span>大元商店</span>
                  </div>
                </div>
                <div class="col-sm-12 comment">
                  <img class="balloon-left" src="/assets/img/balloon-left.png" alt="BALLON-LEFT">
                  <div class="body">
                    <div class="row">
                      <div class="col-3 attr label">受け取り日</div>
                      <div class="col-9 attr ">2021年7月15日</div>
                    </div>
                    <div class="row">
                      <div class="col-3 attr label">発送日</div>
                      <div class="col-9 attr">2021年7月21日</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row tracking-distribution">
                <div class="col-sm-12">
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <div class="title">
                    <span>飲食店</span>
                    <span>寿司屋本店</span>
                  </div>
                </div>
                <div class="col-sm-12 comment">
                  <img class="balloon-left" src="/assets/img/balloon-left.png" alt="BALLON-LEFT">
                  <div class="body">
                    <div class="row">
                      <div class="col-3 attr label">受け取り日</div>
                      <div class="col-9 attr ">2021年7月21日</div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row tracking-distribution">
                <div class="col-sm-12">
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <div class="title">
                    <span>消費者</span>
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
