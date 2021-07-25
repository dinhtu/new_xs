<template>
<vue-ctk-date-time-picker
    v-model="requestDate"
    label="日時を選択してください"
    button-now-translation="現在時刻"
    :format="'YYYY-MM-DD HH:00'"
    :no-header="true"
    :min-date="start"
    :max-date="end"
></vue-ctk-date-time-picker>
</template>

<script>
// vue-ctk-date-time-picker
// https://github.com/chronotruck/vue-ctk-date-time-picker#Behaviour
import moment from 'moment';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

export default {
    components: {
        VueCtkDateTimePicker
    },
    data() {
        return {
            requestDate: ''
        }
    },
    props: {},
    computed: {
        start() {
            const start = moment().subtract(3, 'months');
            return start.format('YYYY-MM-DD HH:00');
        },
        end() {
            const end = moment().add(3, 'months');
            return end.format('YYYY-MM-DD HH:00');
        }
    }
}
</script>
