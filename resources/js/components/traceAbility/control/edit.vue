<template>
<div class="container-fluid controls edit">
  <div class="fade-in">

    <!-- 情報入力 -->
    <div class="row">
      <div class="col-sm-12">
        <div class="guide">
          <a class="btn btn-sm btn-light" href="">キャンセル</a>
          
          <!-- TODO 下書き中かどうかで表示の切り替え -->
          <a class="btn btn-sm btn-info main ">下書き保存</a>
          <a class="btn btn-sm btn-info main">保存して公開</a>
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
