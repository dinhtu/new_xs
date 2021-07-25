<template>
<div class="container-fluid alerts">
  <div class="fade-in">

    <!-- 一般情報照会（入力できる可能性がある業者） -->
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-info" role="alert">
          新しく利用可能なQRコードです。
        </div>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-info" role="alert">
          商品を受け取った卸売業者の方は、トレーサビリティ情報を<a href="">こちら</a>から追加してください。
        </div>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-info" role="alert">
          商品を受け取った飲食店の方は、トレーサビリティ情報を<a href="">こちら</a>から追加してください。
        </div>
      </div>
    </div>

    <!-- 一般情報照会（消費者入力段階） -->
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-success light-success" role="alert">
          トレーサビリティがすべて達成されました！<a href="">読み取り履歴</a>からもう一度詳細情報を確認することができます。
        </div>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-info" role="alert">
          業者ユーザーの方で、読み取り履歴に保存したい場合は<a href="">こちら</a>を選択してください。
        </div>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-success light-outline-success" role="alert">
          読み取り履歴に保存いたしました！<a href="">読み取り履歴</a>から詳細情報を確認することができます。
        </div>
      </div>
    </div>

    <!-- 情報入力不可 -->
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-warning" role="alert">
          既に入力されたトレーサビリティ情報です。入力に間違いがあった場合は<a href="">こちら</a>からご相談ください。
        </div>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-warning" role="alert">
          まだ使用できないトレーサビリティ情報です。先に引き取る必要がある場合は<a href="">こちら</a>からご相談ください。
        </div>
      </div>
    </div>
    <div class="row d-none">
      <div class="col-sm-12">
        <div class="alert alert-danger" role="alert">
          このトレーサビリティ情報を変更することはできません。何かお困りのことがあれば<a href="">こちら</a>からご相談ください。
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
