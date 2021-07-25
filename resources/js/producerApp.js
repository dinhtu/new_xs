require('./bootstrap');
// require('@coreui/coreui/dist/js/coreui.bundle.min');

import Vue from "vue";
import VModal from "vue-js-modal";
import VeeValidate from "vee-validate";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// import { library } from '@fortawesome/fontawesome-svg-core'
// import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// library.add(faUserSecret)

// Vue.component('font-awesome-icon', FontAwesomeIcon)
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

import PopupAlert from "./components/common/popupAlert.vue"
import ProfileCreate from "./components/producer/profile/create.vue"
import ProfileShow from "./components/producer/profile/show.vue"
import CodeIndex from "./components/producer/code/index.vue"
import ProfileEdit from "./components/producer/profile/edit.vue"
import AccountInfoEdit from "./components/producer/accountInfo/edit.vue"
import InfoIndex from "./components/producer/info/index.vue"
import SystemInfoEdit from "./components/producer/systemInfo/edit.vue"
import ReadHistoryIndex from "./components/producer/readHistory/index.vue"

import TraceabilityProductInfo from "./components/producer/traceAbility/productInfo/show.vue";
import TraceabilityProductBasic from "./components/producer/traceAbility/productBasic/show.vue";
import TraceabilityProductDetail from "./components/producer/traceAbility/productDetail/show.vue";
import TraceabilityProductDistribution from "./components/producer/traceAbility/productDistribution/show.vue";

import TraceabilityProductInfoEdit from "./components/producer/traceAbility/productInfo/edit.vue";
import TraceabilityProductBasicEdit from "./components/producer/traceAbility/productBasic/edit.vue";
import TraceabilityProductDetailEdit from "./components/producer/traceAbility/productDetail/edit.vue";
import TraceabilityProductDistributionEdit from "./components/producer/traceAbility/productDistribution/edit.vue";

import TraceabilityAlert from "./components/producer/traceAbility/alert/show.vue";
import TraceabilityDefault from "./components/producer/traceAbility/default/show.vue";
import TraceabilityControl from "./components/producer/traceAbility/control/show.vue";
import TraceabilityControlEdit from "./components/producer/traceAbility/control/edit.vue";

import PastTraceability from "./components/producer/pastTraceAbility/index.vue";
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
        PopupAlert,
        ProfileCreate,
        ProfileShow,
        CodeIndex,
        ProfileEdit,
        InfoIndex,
        AccountInfoEdit,
        SystemInfoEdit,
        PastTraceability,
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
