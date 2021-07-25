<template>
<div class="container-fluid">
  <div class="fade-in">
    <qr-code-info></qr-code-info>
  </div>
</div>
</template>

<script>
import qrCodeInfo from "../../common/qrCodeInfo.vue"
export default {
  data() {
  },
  components: {
    qrCodeInfo
  },
  mounted() {
    
  },
  props: ["data"]
}
</script>
