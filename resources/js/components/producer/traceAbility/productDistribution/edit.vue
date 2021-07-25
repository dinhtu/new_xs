<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card product-distribution edit">
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
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>出荷日<span class="text-danger">*</span></label>
                          <input-date-time-picker></input-date-time-picker>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>卸売業者名<span class="text-danger">*</span></label>
                          <input class="form-control" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>受け取り日<span class="text-danger">*</span></label>
                          <input-date-time-picker></input-date-time-picker>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>発送日<span class="text-danger">*</span></label>
                          <input-date-time-picker></input-date-time-picker>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>受け取り日<span class="text-danger">*</span></label>
                          <input-date-time-picker></input-date-time-picker>
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
import InputDateTimePicker from "../../../common/inputDateTimePicker.vue";

export default {
  components: {
    InputDateTimePicker
  },
  data() {
    return {}
  },
  props: {}
}
</script>
