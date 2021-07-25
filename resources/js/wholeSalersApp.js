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

import ProfileCreate from "./components/wholeSalers/profile/create.vue"
import ProfileShow from "./components/wholeSalers/profile/show.vue"
import ProfileEdit from "./components/wholeSalers/profile/edit.vue"
import AccountInfoEdit from "./components/wholeSalers/accountInfo/edit.vue"
import SystemInfoEdit from "./components/wholeSalers/systemInfo/edit.vue"
import ReadHistoryIndex from "./components/wholeSalers/readHistory/index.vue"

import TraceabilityProductInfo from "./components/wholeSalers/traceAbility/productInfo/show.vue";
import TraceabilityProductBasic from "./components/wholeSalers/traceAbility/productBasic/show.vue";
import TraceabilityProductDetail from "./components/wholeSalers/traceAbility/productDetail/show.vue";
import TraceabilityProductDistribution from "./components/wholeSalers/traceAbility/productDistribution/show.vue";

import TraceabilityProductInfoEdit from "./components/wholeSalers/traceAbility/productInfo/edit.vue";
import TraceabilityProductBasicEdit from "./components/wholeSalers/traceAbility/productBasic/edit.vue";
import TraceabilityProductDetailEdit from "./components/wholeSalers/traceAbility/productDetail/edit.vue";
import TraceabilityProductDistributionEdit from "./components/wholeSalers/traceAbility/productDistribution/edit.vue";

import TraceabilityAlert from "./components/wholeSalers/traceAbility/alert/show.vue";
import TraceabilityDefault from "./components/wholeSalers/traceAbility/default/show.vue";
import TraceabilityControl from "./components/wholeSalers/traceAbility/control/show.vue";
import TraceabilityControlEdit from "./components/wholeSalers/traceAbility/control/edit.vue";

import PastTraceability from "./components/wholeSalers/pastTraceAbility/index.vue";
import InfoIndex from "./components/wholeSalers/info/index.vue";
import QrCodeInfo from "./components/producer/qrCode/show.vue";

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
        ProfileCreate,
        ProfileShow,
        ProfileEdit,
        AccountInfoEdit,
        SystemInfoEdit,
        PastTraceability,
        InfoIndex,
        QrCodeInfo,
        ReadHistoryIndex,
        TraceabilityProductInfo,
        TraceabilityProductBasic,
        TraceabilityProductDetail,
        TraceabilityProductDistribution,
        TraceabilityProductInfoEdit,
        TraceabilityProductBasicEdit,
        TraceabilityProductDetailEdit,
        TraceabilityProductDistributionEdit,
        TraceabilityAlert,
        TraceabilityDefault,
        TraceabilityControl,
        TraceabilityControlEdit
    },
    methods: {},
    mounted() {}
});
