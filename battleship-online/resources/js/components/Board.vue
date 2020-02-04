<template>
    <div class="board">
        <div class="row" :class="'row-cols-' + size" v-for="row in size">
            <div class="cell col" v-for="column in size" :ref="'cell-' + row + '-' + column"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        size: {
            type: Number,
            required: false,
            default: 10
        },
        attacks: {
            type: Array,
            required: true,
            default: []
        },
        ships: {
            type: Array,
            required: false,
            default: []
        }
    }
}
</script>
