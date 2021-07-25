<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card product-detail edit">
          <div class="card-header">
            漁獲/加工情報
            <a class="float-right collapse-toggle" data-toggle="collapse" href="#collapseProductDetail" aria-expanded="true" aria-controls="collapseProductDetail">
              <!-- TODO トグルの開閉に合わせて180度回転 -->
              <img src="/assets/img/arrow-down.svg" alt="ARROW-DOWN-ICON">
            </a>
          </div>
          <!-- TODO トグルが開閉しないのを直す -->
          <div class="collapse show" id="collapseProductDetail">
            <div class="card-body">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>漁獲者<span class="text-danger">*</span></label>
                          <input class="form-control" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>水揚げ日<span class="text-danger">*</span></label>

                          <!-- TODO IDが被ってしまうのを直す -->
                          <input-date-time-picker></input-date-time-picker>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>漁場<span class="text-danger">*</span></label>
                          <input class="form-control" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>漁法<span class="text-danger">*</span></label>
                          <input class="form-control" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>処理者<span class="text-danger">*</span></label>
                          <suggest-select
                            :options="processors"
                            label="処理者を入力または選択してください"
                          ></suggest-select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>処理日<span class="text-danger">*</span></label>
                          <input-date-time-picker></input-date-time-picker>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>処理方法<span class="text-danger">*</span></label>
                          <suggest-select
                            :options="processKinds"
                            label="処理方法を入力または選択してください"
                          ></suggest-select>
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
import SuggestSelect from "../../../common/suggestSelect.vue";

export default {
  components: {
    InputDateTimePicker,
    SuggestSelect
  },
  data() {
    return {
      processors: [
        '水野 赤',
        '水野 上',
        '水野 追史佐',
      ],
      processKinds: [
        '塩漬',
        '塩漬け',
        '塩漬け & 天日干し',
      ]
    }
  },
  props: {}
}
</script>
