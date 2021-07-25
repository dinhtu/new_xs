<template>
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <p class="card-header">ZeniMoto-1111</p>
            <div class="card-body">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-center mb-2">
                <img class="img" src="/assets/img/sample_qr_code.png" width="240" height="240">
                </div>
            </div>
            <div class="row text-center">
                <div class="col-sm-12 text-center">
                <button class="btn btn-info btn-w-100" type="submit"> ダウンロード</button>
                </div>
            </div>
            
            <div class="col-10 mx-auto mt-4">
                <div class="box-border">
                <div class="col-12 col-sm-12 p">
                    <div class="row">
                    <div class="col-6 col-sm-6 px-0">
                        <p>ZeniMoto-1111</p>
                    </div>
                    <div class="col-6 col-sm-6 px-0" style=" text-align: end;">
                        <img class="img w-100" src="/assets/img/sample_qr_code.png">
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-sm-12 mt-2 text-center">
                <button class="btn btn-info btn-w-100" type="submit"> ダウンロード</button>
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
     
    };
  },
  components: {
  },
  mounted() {
    
  },
  props: ["data"]
}
</script>
<style lang="css" scoped>
.box-border {
  border: 1px solid #707070;
  padding: 20px 15px
}
</style>
