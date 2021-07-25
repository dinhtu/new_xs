<template>
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><strong>システム情報 - 編集中</strong></div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">設定職種</label>
                  <div>
                    <button class="btn btn-block btn-outline-info btn-w-120" type="button">生産者</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">販売者受け取り通知</label>
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
                  <label for="ccnumber">トラッキング名<span class="text-danger">*</span></label>
                  <input class="form-control" type="text" value="ZeniMoto">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">飲食店受け取り通知</label>
                  <div>
                    <label class="c-switch c-switch-pill c-switch-label c-switch-success">
                        <input type="checkbox" class="c-switch-input">
                        <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">消費者受け取り通知</label>
                  <div>
                    <label class="c-switch c-switch-pill c-switch-label c-switch-success">
                        <input type="checkbox" class="c-switch-input">
                        <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="ccnumber">メールアドレスの表示</label>
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
