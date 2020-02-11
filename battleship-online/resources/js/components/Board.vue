<template>
    <div class="board">
        <div class="row" :class="'row-cols-' + size" v-for="row in size">
            <div :style="{ 'height': cellHeight + 'px' }" :class="cellClass(column, row)" class="cell col" v-for="column in size" :ref="'cell-' + row + '-' + column"></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cellHeight: 10,
        }
    },
    props: {
        size: {
            type: Number,
            required: false,
            default: 10
        },
        attacks: {
            type: Array,
            required: true,
            default() {
                return []
            }
        },
        ships: {
            type: Array,
            required: false,
            default() {
                return []
            }
        }
    },
    methods: {
        cellClass(x, y) {
            let attack = _.find(this.attacks, { x: x, y: y})
            let result = 'cell'

            if (attack) {
                result += ' attacked'
                if (attack.hit)
                    result += ' hit'
            }

            return result
        },
        updateCellWidth() {
            this.cellHeight = this.$refs['cell-1-1'][0].getBoundingClientRect().width
        }
    },
    mounted() {
        this.updateCellWidth()
        window.addEventListener('resize', this.updateCellWidth)
    }
}
</script>
