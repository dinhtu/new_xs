<template>
<div class="container">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" ref="formLogin" action="/login">
                    <input type="hidden" :value="csrfToken" name="_token" />
                    <div class="card">
                        <div class="card-header"><strong>アカウント新規追加</strong></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="ccnumber">アカウント名</label>
                                        <input class="form-control" type="text" name="email" v-validate="'required|email'" v-model="model.email" />
                                        <div class="input-group error" role="alert" v-if="errors.has('email')">
                                            {{ errors.first("email") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="ccnumber">パスワード</label>
                                        <input class="form-control" type="password" name="password" v-validate="'required|min:8'" v-model="model.password" />
                                        <div class="input-group error" role="alert" v-if="errors.has('password')">
                                            {{ errors.first("password") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-form-label">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input" id="check1" name="remember_me" type="checkbox" value="1">
                                        <label class="form-check-label" for="check1">ログイン情報を保存する</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-6">
                                <div class="p-l-20">
                                    <button class="btn btn-primary px-4" type="button" v-on:click="submit">ログイン</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
</div>
</template>

<script>
import Loader from "../common/loader.vue"
export default {
    created: function () {
        let messError = {
            custom: {
                email: {
                    required: "メールアドレスを入力してください。",
                    email: "メールアドレス形式が正しくありません。"
                },
                password: {
                    required: 'パスワードを入力してください。',
                    min: "パスワードは8文字以上にしてください。"
                }
            }
        };
        this.$validator.localize("en", messError);
    },
    data() {
        return {
            flagShowLoader: false,
            model: {},
            csrfToken: Laravel.csrfToken,
            baseUrl: Laravel.baseUrl
        }
    },
    props: {},
    components: {
        Loader
    },
    methods: {
        submit() {
            let that = this;
            this.$validator.validateAll().then(valid => {
                if (valid) {
                    this.flagShowLoader = true;
                    that.$refs.formLogin.submit();
                } else {
                    this.$el
                        .querySelector(
                            "input[name=" + Object.keys(this.errors.collect())[0] + "]"
                        )
                        .focus();
                    $("html, body").animate({
                            scrollTop: $(
                                "input[name=" + Object.keys(this.errors.collect())[0] + "]"
                            ).offset().top - 104
                        },
                        500
                    );
                }
            });
        },

    }
}
</script>
