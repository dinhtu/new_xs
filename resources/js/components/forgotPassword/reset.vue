<template>
<div class="container">
  <div class="fade-in">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><strong>パスワードを再設定する</strong></div>
          <form :action="data.updateUrl" method="POST" ref="formReset">
            <input type="hidden" :value="csrfToken" name="_token" />
            <input type="hidden" :value="data.token" name="reset_password_token" />
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">パスワード<span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="password" v-model="model.password" v-validate="'required|min:8|max:15|password_rule'" ref="password">
                    <div class="input-group error" role="alert" v-if="errors.has('password')">
                      {{ errors.first("password") }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">パスワード<span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="password_confirm" v-validate="'required|confirmed:password'">
                    <div class="input-group error" role="alert" v-if="errors.has('password_confirm')">
                      {{ errors.first("password_confirm") }}
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

</div>
</template>

<script>

import axios from "axios";

export default {
  created: function () {
    let messError = {
      custom: {
        password: {
          required: "パスワードを入力してください。",
          max: "パスワードは15文字以内で入力してください。",
          min: "パスワードは8文字以上で入力してください。",
          password_rule: "パスワードは半角英数字で、大文字、小文字、数字で入力してください。"
        },
        password_confirm: {
          required: "パスワード （確認用） を入力してください。",
          confirmed: "パスワード（確認用）が入力されたものと異なります。"
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
    }
  },
  props: ['data'],
  components: {},
  methods: {
    submit() {
      let that = this;
      this.$validator.validateAll().then(valid => {
        if (valid) {
          // that.flagShowLoader = true;
          that.$refs.formReset.submit();
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
