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
                    <button class="btn btn-block btn-outline-info btn-w-120" type="button">生産者</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">漁獲者名</label>
                  <input class="form-control" type="text" value="水野 上">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">水上げ日</label>
                  <input class="form-control" type="text" value="水野 上">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">漁獲者名<span class="txt-warning">※水揚げ日に記入日時を自動入力</span></label>
                  <div>
                    <label class="c-switch c-switch-pill c-switch-label c-switch-success">
                        <input type="checkbox" class="c-switch-input" checked>
                        <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">漁場</label>
                  <input class="form-control" type="text" value="明石海峡漁港付近">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">漁法</label>
                  <input class="form-control" type="text" value="一本釣り">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">処理日<span class="txt-warning">※水揚げ日に記入日時を自動入力</span></label>
                  <div>
                    <label class="c-switch c-switch-pill c-switch-label c-switch-success">
                        <input type="checkbox" class="c-switch-input">
                        <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
                <a class="btn btn-light btn-w-100" href="/producer/profile/1"> キャンセル</a>
                <a class="btn btn-info btn-w-100" href="/producer/profile/1" type="submit"> 更新</a>
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
