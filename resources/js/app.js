require('./bootstrap');
// require('@coreui/coreui/dist/js/coreui.bundle.min');

import Vue from "vue";
import VModal from "vue-js-modal";
import VeeValidate from "vee-validate";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VeeValidate, {
    locale: "ja"
});

Vue.use(VModal);
Vue.use(VueSweetalert2);
Vue.filter('replaceDateTime', function(value) {
    if (value) {
        return value.split('T')[0] + ' ' + value.split('T')[1].replace('.000000Z', '')
    }
});
import moment from 'moment-timezone'
Vue.config.productionTip = false
//Nl2br
import Nl2br from 'vue-nl2br'
Vue.component('nl2br', Nl2br)

import ProfileShow from "./components/users/profile/show.vue"
import AccountInfoEdit from "./components/users/accountInfo/edit.vue"

import TraceabilityProductInfo from "./components/users/traceAbility/productInfo/show.vue";
import TraceabilityProductBasic from "./components/users/traceAbility/productBasic/show.vue";
import TraceabilityProductDetail from "./components/users/traceAbility/productDetail/show.vue";
import TraceabilityProductDistribution from "./components/users/traceAbility/productDistribution/show.vue";

import TraceabilityProductInfoEdit from "./components/users/traceAbility/productInfo/edit.vue";
import TraceabilityProductBasicEdit from "./components/users/traceAbility/productBasic/edit.vue";
import TraceabilityProductDetailEdit from "./components/users/traceAbility/productDetail/edit.vue";
import TraceabilityProductDistributionEdit from "./components/users/traceAbility/productDistribution/edit.vue";

new Vue({
    created() {
        // this.$validator.extend('required', {
        //   validate: function (value) {
        //     return value.trim() != '';
        //   }
        // })
        this.$validator.extend('code', {
            validate: function(value) {
                return /^[A-Za-z0-9]{1,20}$/i.test(value.trim())
            }
        });
        this.$validator.extend("password_rule", {
            validate: function(value) {
                return /^[A-Za-z0-9]*$/i.test(value);
            }
        });
        this.$validator.extend("is_hiragana", {
            validate: function(value) {
                return /^[ア-ン゛゜ァ-ォャ-ョーヴ　]*$/i.test(value);
            }
        });
        this.$validator.extend("email_format", {
            validate: function(value) {
                return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(value);
            }
        });
    },
    el: "#app",
    components: {
        ProfileShow,
        AccountInfoEdit,
        TraceabilityProductInfo,
        TraceabilityProductBasic,
        TraceabilityProductDetail,
        TraceabilityProductDistribution,
        TraceabilityProductInfoEdit,
        TraceabilityProductBasicEdit,
        TraceabilityProductDetailEdit,
        TraceabilityProductDistributionEdit,
    },
    methods: {},
    mounted() {}
});
