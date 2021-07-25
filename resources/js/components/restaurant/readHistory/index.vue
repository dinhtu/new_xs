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
                <label>読み取り日付</label>
                <div class="input-prepend input-group group-date">
                    <date-picker class="form-control col-sm-6 search-date" v-model="startDate" :config="fromOption"></date-picker>
                    <p class="m-t-6">&nbsp;～&nbsp;</p>
                    <date-picker class="form-control col-sm-6 search-date" v-model="endDate" :config="toOption"></date-picker>
                </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-sm-12 text-center">
                <button class="btn btn-info btn-w-100" type="submit"> 更新</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <p class="card-header">読み取り履歴情報</p>
          <div class="card-body card-body-res">
            <p class="text-center text-small mb-2 txt-paginate">全25件中10件/25件表示</p>
            <div class="row" v-for="number in numbers" :key="number">

              <!-- item -->
              <div class="col-sm-12">
                <div class="card card-shadow">
                  <div class="card-body d-flex item">
                    <div class="col-2 col-sm-2 px-0">
                      <img class="w-100" src="/assets/img/sample_qr_code.png" alt="">
                    </div>
                    <div class="col-8 col-sm-8 item-content">
                      <span class="font-weight-bolder item-title">ZeniMoto-{{number}}</span>
                      <div class="row px-0">
                        <span class="col-6 pr-0"> 魚種</span>
                        <span class="col-6 px-0">タイ</span>
                      </div>
                      <div class="row px-0">
                        <span class="col-6 pr-0"> 最終読み取り日時 </span>
                        <span class="col-6 px-0"> 2021/7/09 22時32分 </span>
                      </div>
                    </div>
                    <div class="col-2 col-sm-2 px-0 d-flex align-items-center justify-content-end">
                      <a class="btn btn-info btn-sm" :href="baseUrl + '/restaurant/traceAbility/1' + number">詳細</a>
                    </div>
                  </div>
                </div>
              </div>
              <!--  -->
            </div>

            <div class="col-sm-12 d-flex justify-content-center">
              <nav class="font-weight-bold">
                <ul class="pagination">
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.707" height="16.707" viewBox="0 0 8.707 16.707">
                          <g id="Group_185" data-name="Group 185" transform="translate(-138.146 -1449.146)">
                            <line id="Line_18" data-name="Line 18" y1="8" x2="8" transform="translate(138.5 1449.5)" fill="none" stroke="#e0e0e0" stroke-width="1" />
                            <line id="Line_19" data-name="Line 19" x2="8" y2="8" transform="translate(138.5 1457.5)" fill="none" stroke="#e0e0e0" stroke-width="1" />
                          </g>
                        </svg>
                      </span>
                    </a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.707" height="16.707" viewBox="0 0 8.707 16.707">
                          <g id="Group_186" data-name="Group 186" transform="translate(146.854 1465.854) rotate(180)">
                            <line id="Line_18" data-name="Line 18" y1="8" x2="8" transform="translate(138.5 1449.5)" fill="none" stroke="#e0e0e0" stroke-width="1" />
                            <line id="Line_19" data-name="Line 19" x2="8" y2="8" transform="translate(138.5 1457.5)" fill="none" stroke="#e0e0e0" stroke-width="1" />
                          </g>
                        </svg>
                      </span>
                    </a>
                  </li>
                </ul>
              </nav>
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
      baseUrl: Laravel.baseUrl
    };
  },
  components: {
    datePicker
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
</style>
