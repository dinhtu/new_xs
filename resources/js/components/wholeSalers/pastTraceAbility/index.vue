<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="card">
          <p class="card-header">読み取り検索</p>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>読み取り日付</label>
                  <div class="input-prepend input-group group-date">
                      <date-picker class="form-control col-sm-6 search-date" v-model="startDate" :config="fromOption"></date-picker>
                      <p class="m-t-6">&nbsp;～&nbsp;</p>
                      <date-picker class="form-control col-sm-6 search-date" v-model="endDate" :config="toOption"></date-picker>
                  </div>
                </div>
                
               <div class="form-group">
                  <label for="name">魚種</label>
                   <suggest-select  :options="kinds" label="タイ" />
                </div>
                
                <div class="form-group">
                  <label for="name">トラッキングID（ZeniMoto-ここの番号です）</label>
                   <div class="input-prepend input-group group-date">
                      <input class="form-control" id="name" type="number" placeholder="1111">
                      <p class="m-t-6">&nbsp;～&nbsp;</p>
                      <input class="form-control" id="name" type="number" placeholder="1120">
                  </div>
                </div>

              </div>
            </div>
            <div class="row text-center">
              <div class="col-sm-12 text-center">
                <button class="btn btn-info" type="submit"> 更新 </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
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
            <p class="text-center text-small mb-2 txt-paginate">全25件中10件/25件表示</p>

              <div class="card">
                <div class="timeline_block">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-8">
                        <div class="row">
                          <div class="col-12 col-sm-12 px-0">
                            <div class="tracking-code">
                              <strong>ZeniMoto-1112</strong>
                              <button class="btn btn-sm btn-info ml-3" type="submit"> 更新 </button>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-12 px-0">
                            <div class="uuid">
                              lwl8ecbahade83bVegccdjvhdvjcd4fs
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="col-4 px-0 qr-code-wrapper">
                      <img :src="baseUrl + '/assets/img/sample_qr_code.png'" alt="SAMPLE_QR_CODE" width="50" height="50">
                    </div>
                  </div>

                  <div class="row detail-info">
                    <div class="col-8">
                      <div class="row">
                        <div class="col-4 px-0">
                          <p> 魚種 </p>
                          <p>記入日時</p>
                        </div>
                        <div class="col-8 px-0">
                          <p>タ</p>
                          <p>2021/7/09 22時32分</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 px-0">
                      <a href="/wholeSalers/qrCode/11">
                        <p class="text-info text-right">ダウンロード</p>
                      </a>
                    </div>
                  </div>
                  <!-- </div> -->

                  <div class="row mt-1 tracking-distribution">
                    <div class="col-sm-12 px-0">
                      <div class="outer-circle">
                        <div class="inner-circle"></div>
                      </div>
                      <div class="title">
                        <span>生産者</span>
                      </div>
                    </div>
                    <div class="col-sm-12 px-0 comment">
                      <span class="balloon-left"></span>
                        <div class="body">
                          <p>フラットアワー合同会社　2021/7/09 22時32分</p>
                        </div>
                    </div>
                  </div>

                  <div class="row tracking-distribution active">
                    <div class="col-sm-12 px-0">
                      <div class="outer-circle">
                        <div class="inner-circle"></div>
                      </div>
                      <div class="title">
                        <span>卸売業者</span>
                      </div>
                    </div>
                    <div class="col-sm-12 px-0 comment">
                      <span class="balloon-left"></span>
                      <div class="body">
                        <p>大元商店　2021/7/10 2時3分</p>
                      </div>
                    </div>
                  </div>

                  <div class="row tracking-distribution">
                    <div class="col-sm-12 px-0">
                      <div class="outer-circle">
                        <div class="inner-circle"></div>
                      </div>
                      <div class="title">
                        <span>飲食店</span>
                      </div>
                    </div>
                    <div class="col-sm-12 px-0 comment">
                      <span class="balloon-left"></span>
                      <div class="body">
                        <p>寿司屋本店　2021/7/12 22時27分</p>
                      </div>
                    </div>
                  </div>
                
                  <div class="row tracking-distribution">
                    <div class="col-sm-12 px-0">
                      <div class="outer-circle">
                        <div class="inner-circle"></div>
                      </div>
                      <div class="title">
                        <span>消費者</span>
                      </div>
                    </div>
                    <div class="col-sm-12 px-0 comment">
                      <span class="balloon-left"></span>
                      <div class="body">
                        <p>GoodCustomer</p>
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
  </div>
</div>
</template>

<script>
import datePicker from "vue-bootstrap-datetimepicker";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import SuggestSelect from "../../common/suggestSelect.vue";

export default {
  data() {
    return {
      startDate: this.data.startDate,
      endDate: this.data.endDate,
      numbers: [1111, 1112, 1113, 1114, 1115, 1117, 1118, 1119, 1120],
      fromOption: {
        format: "YYYY/MM/DD",
        locale: "ja",
        showClear: true,
        useCurrent: false,
        dayViewHeaderFormat: "MMM YYYY",
        maxDate: this.endDate
      },
      toOption: {
        format: "YYYY/MM/DD",
        locale: "ja",
        showClear: true,
        useCurrent: false,
        dayViewHeaderFormat: "MMM YYYY",
        minDate: this.startDate
      },
       kinds: [
        'タイ',
        'タラバガニ',
        'タラ',
      ],
      baseUrl: Laravel.baseUrl,
    };
  },
  components: {
    datePicker,
    SuggestSelect
  },
  mounted() {
    this.fromOption.maxDate = this.endDate;
    this.toOption.minDate = this.startDate;
  },
  props: ["data"]
}
</script>
<style lang="css" scoped>
.item-content {
  font-size: 10px
}
.item-title {
  font-size: 14px;
}
.detail-info { 
  font-size: 10px;
}
.detail-info p {
  margin: 0;
  padding-bottom: 5px;
}
.tracking-distribution .comment .body {
  background-color: #fff!important;
  padding-left: 0;
  padding-top: 0;
}
.tracking-distribution .comment .body p{
  font-size: 12px;
  margin: 0;
}
.tracking-distribution.active .inner-circle {
  background-color: #F36262
}
.tracking-distribution.active .title, .tracking-distribution.active .body {
  color: #F36262
}
.tracking-distribution::after {
  border-left: 1px solid #707070;
  left: 5.1px;
}
.tracking-distribution .body {
  margin-left: 15px
}
</style>
