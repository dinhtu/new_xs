<template>
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <strong>ユーザー情報</strong>
                    </div>
                    <info-edit></info-edit>
                    <div class="card-footer">
                        <a class="btn btn-light btn-w-100" href="/wholeSalers/profile/1"> キャンセル</a>
                        <a class="btn btn-info btn-w-100" href="/wholeSalers/profile/1" type="submit"> 更新</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import InfoEdit from "../../common/accountInfoEdit.vue"
export default {
    data() {
        return {}
    },
    props: {},
    components: {
        InfoEdit
    },
}
</script>
