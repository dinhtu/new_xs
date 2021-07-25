<template>
<div>
    <cool-select
        v-model="selected"
        :items="options"
        :placeholder="label"
        :allowMobileScroll="false"
        :resetSearchOnBlur="false"
    >
    </cool-select>
</div>
</template>

<script>
// vue-cool-select
// https://github.com/iliyaZelenko/vue-cool-select
// https://www.sukerou.com/2019/05/vuejs3.html
import { CoolSelect } from 'vue-cool-select';
import "vue-cool-select/dist/themes/bootstrap.css";

export default {
    components: {
        CoolSelect
    },
    data() {
        return {
            selected: null,
        };
    },
    props: {
        options: {
            type: Array
        },
        label: {
            type: String
        }
    }
}
</script>
