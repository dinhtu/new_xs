<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><strong>トレーサビリティ自動反映情報 - 編集中</strong></div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">登録職種</label>
                  <div>
                    <button class="btn btn-block btn-outline-info btn-w-120" type="button">飲食店</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">受取日<span class="txt-warning">※水揚げ日に記入日時を自動入力</span></label>
                  <div>
                    <label class="c-switch c-switch-pill c-switch-label c-switch-success">
                        <input type="checkbox" class="c-switch-input" checked>
                        <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
                <button class="btn btn-light btn-w-100" type="reset"> キャンセル</button>
                <button class="btn btn-info btn-w-100" type="submit"> 更新</button>
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
