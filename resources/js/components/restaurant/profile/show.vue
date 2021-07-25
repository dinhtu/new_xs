<template>
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <strong>ユーザー情報</strong>
                        <div class="box-action">
                            <a href="/restaurant/accountInfo/1/edit">
                                <img src="/images/example/detail.svg">
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <div>
                                        <img src="/images/example/avatar2.png" alt="">
                                    </div>
                                    <div class="txt-name">寿司屋本店</div>
                                    <div class="text-center txt-name-detail">InshoKuten</div>
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
                                        sakuma_sample@test.jp
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

                <div class="card">
                    <div class="card-header">
                        トレーサビリティ自動反映情報
                        <div class="box-action">
                            <a href="/restaurant/profile/1/edit">
                                <img src="/images/example/detail.svg">
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">登録職種</label>
                                    <div class="txt-info">
                                        <button class="btn btn-block btn-outline-info btn-w-120" type="button">飲食店</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">受取日<span class="txt-warning">※水揚げ日に記入日時を自動入力</span></label>
                                    <div class="txt-info">
                                        ON（記入日）
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">最終更新日時</label>
                                    <div class="txt-info">
                                        2021年10月11日 23時31分
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        システム情報
                        <div class="box-action">
                            <a href="/producer/profile/1/edit">
                                <img src="/images/example/detail.svg">
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">設定職種</label>
                                    <div class="txt-info">
                                        <button class="btn btn-block btn-outline-info btn-w-120" type="button">飲食店</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ccnumber">消費者受け取り通知</label>
                                    <div class="txt-info">
                                        OFF
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
