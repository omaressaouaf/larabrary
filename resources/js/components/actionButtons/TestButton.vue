<template>
    <button class="test-btn" @click="test">Test it now!</button>
</template>

<script>
export default   {
    methods: {
        test() {
            this.$emit("test", this.data)
        }
    },

    props: {
        data: {
            type: Object,
            required: true
        },
    }
};
</script>