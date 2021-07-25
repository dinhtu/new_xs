<template>
<div class="container">
  <div class="fade-in">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><strong>新規登録</strong></div>
          <form :action="data.registerUrl" method="POST" ref="formRegister">
            <input type="hidden" :value="csrfToken" name="_token" />
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">メールアドレス<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="email" v-validate="
                      'required|email_format|max:255|unique_custom:email'
                    " v-model="model.email">
                    <div class="input-group error" role="alert" v-if="errors.has('email')">
                      {{ errors.first("email") }}
                    </div>
                  </div>
                </div>
              </div>
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
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="ccnumber">業種<span class="text-danger">*</span><span class="txt-warning">※生産者の方はトラッキング名にアカウント名が使用されます</span></label>
                    <ul class="pagination">
                      <li class="page-item" :class="item.id == model.role ? 'active' : ''" v-for="(item,index) in data.roles" :key="index">
                        <label :for="'role-option-'+index" class="page-link">{{ item.label }}</label>
                        <input
                          type="radio"
                          class="role-option"
                          :id="'role-option-'+index"
                          name="role"
                          :value="item.id"
                          v-model="model.role"
                        >
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="row m-t-6">
                <div class="p-l-20">
                  <button class="btn btn-primary px-4" type="button" v-on:click="submit">新規登録</button>
                </div>
                <div class="p-l-20 p-t-6">
                  <a class="btn-link px-0" href="/login">すでにアカウントをお持ちの方</a><br>
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
          max: "メールアドレスは255文字以内で入力してください。",
          unique_custom: "このメールアドレスは既に登録されています。"
        },
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
    let that = this;
    this.$validator.extend("unique_custom", {
      validate(value, args) {
        return axios
          .post(that.data.checkEmail, {
            _token: Laravel.csrfToken,
            value: value,
            type: args[0]
          })
          .then(function (response) {
            return {
              valid: response.data.valid
            };
          })
          .catch(error => {});
      }
    });
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
      model: {
        role: 2
      },
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
          that.$refs.formRegister.submit();
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
