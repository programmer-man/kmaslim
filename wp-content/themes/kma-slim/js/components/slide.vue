<template>
    <div
            class="slide"
            :class="{
                'active': isActive
            }"
            :style="{
                'background-image': 'url(' + image + ')',
                'z-index': zindex,
            }">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            image: ''
        },

        data () {
            return {
                id: '',
                isActive: false
            }
        },

        computed: {
            zindex: function () {
                let index = this.id
                return (20 - index)
            }
        }

    }
</script>