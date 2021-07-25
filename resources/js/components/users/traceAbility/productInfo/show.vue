<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-8">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="tracking-code">
                      <strong>ZeniMoto-1112</strong>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="uuid">
                      lwl8ecbahade83bVegccdjvhdvjcd4fs
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4 qr-code-wrapper">
                <img class="qr-code" :src="baseUrl + '/assets/img/sample_qr_code.png'" alt="SAMPLE_QR_CODE">
              </div>
            </div>
            <div class="row attr top">
              <div class="col-3">
                <div class="">
                  <label for="ccnumber">魚種</label>
                </div>
              </div>
              <div class="col-9">
                <div class="">
                  <label for="ccnumber">---</label>
                </div>
              </div>
            </div>
            <div class="row attr">
              <div class="col-3">
                <div>
                  <label for="ccnumber">最終更新者</label>
                </div>
              </div>
              <div class="col-9">
                <div>
                  <label for="ccnumber">---</label>
                </div>
              </div>
            </div>
            <div class="row attr last">
              <div class="col-3">
                <div>
                  <label for="ccnumber">最終更新日時</label>
                </div>
              </div>
              <div class="col-9">
                <div>
                  <label for="ccnumber">---</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3 producer tracking done">
                <div class="text-center">
                  <label for="ccnumber">生産者</label>
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <img :src="baseUrl + '/uploads/users/生産者サンプル.jpg'" alt="PRODUCER-IMG">
                </div>
              </div>
              <div class="col-3 whole-salers tracking done">
                <div class="text-center">
                  <label for="ccnumber">卸売業者</label>
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <img :src="baseUrl + '/uploads/users/卸売業者サンプル.jpg'" alt="WHOLE-SALERS-IMG">
                </div>
              </div>
              <div class="col-3 restaurant tracking point">
                <div class="text-center">
                  <label for="ccnumber">飲食店</label>
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <img :src="baseUrl + '/uploads/users/飲食店サンプル.jpg'" alt="RESTAURANT-IMG">
                </div>
              </div>
              <div class="col-3 customer tracking">
                <div class="text-center">
                  <label for="ccnumber">消費者</label>
                  <div class="outer-circle">
                    <div class="inner-circle"></div>
                  </div>
                  <img :src="baseUrl + '/uploads/users/消費者サンプル.jpg'" alt="CUSTOMER-IMG">
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
    return {
      baseUrl: Laravel.baseUrl,
    }
  },
  props: {}
}
</script>
