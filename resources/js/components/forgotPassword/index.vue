<template>
<div class="container">
  <div class="fade-in">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><strong>ログイン</strong></div>
          <form :action="data.forgotPasswordUrl" method="POST" ref="formforgotPass">
            <input type="hidden" :value="csrfToken" name="_token" />
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">メールアドレス<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="email" v-validate="
                      'required|email_format|max:255'
                    " v-model="model.email">
                    <div class="input-group error" role="alert" v-if="errors.has('email')">
                      {{ errors.first("email") }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row m-t-6">
                <div class="p-l-20">
                  <button class="btn btn-primary px-4" type="button" v-on:click="submit">新規登録</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <loader :flag-show="flagShowLoader"></loader>
</div>
</template>

<script>

import axios from "axios";
import Loader from "../common/loader.vue"

export default {
  created: function () {
    let messError = {
      custom: {
        email: {
          required: "メールアドレスを入力してください。",
          email_format: "メールアドレス形式は正しくありません。",
          max: "メールアドレスは255文字以内で入力してください。"
        }
      }
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
      model: [],
      flagShowLoader: false,
    }
  },
  props: ['data'],
  components: {
    Loader
  },
  methods: {
    submit() {
      let that = this;
      this.$validator.validateAll().then(valid => {
        if (valid) {
          that.flagShowLoader = true;
          that.$refs.formforgotPass.submit();
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
