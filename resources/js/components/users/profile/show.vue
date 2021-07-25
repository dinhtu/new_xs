<template>
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <strong>ユーザー情報</strong>
                        <div class="box-action">
                            <a href="/users/accountInfo/1/edit">
                                <img src="/images/example/detail.svg">
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div>
                                        <img src="/images/example/avatar3.png" alt="">
                                    </div>
                                    <div class="txt-name">goodcustomer_sample</div>
                                    <div class="text-center txt-name-detail">GoodCustomer</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">Url</label>
                                    <div class="txt-info">
                                        https://sample.com
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">メールアドレス</label>
                                    <div class="txt-info">
                                        goodcustomer_sample@test.jp
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">アカウント作成日</label>
                                    <div class="txt-info">
                                        2020年10月12日
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">権限</label>
                                    <div>
                                        <button class="btn btn-block btn-outline-info btn-w-120" type="button">利用者</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <a class="a-link" href="#">パスワード変更はこちら</a>
                    </div>
                    <div class="col-sm-12">
                        <a class="a-link" href="#">メールアドレス変更はこちら</a>
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
