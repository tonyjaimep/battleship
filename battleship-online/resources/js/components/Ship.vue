<template>
    <div :style="{ 'width': width, 'height': height, 'left': x, 'top': y }" class="ship" :class="'ship-' + ship.orientation + '-' + ship.length"></div>
</template>

<script>
export default {
    props: {
        length: {
            type: Number,
            required: true
        },
        position: {
            type: Object,
            required: true
        },
        orientation: {
            type: String,
            required: true,
        }
        'cell-size': {
            type: Number,
            required: true
        }
    },
    computed: {
        width() {
            if (this.orientation === 'h') {
                return this.cellSize * this.length
            } else {
                return this.cellSize
            }
        },
        height() {
            if (this.orientation === 'v') {
                return this.cellSize * this.length
            } else {
                return this.cellSize
            }
        },
        x() {
            return this.cellSize * this.position.x
        },
        y() {
            return this.cellSize * this.position.y
        }
    }
}
</script>

<style lang="css" scoped>
.ship {
    background-color: red;
    position: absolute;
}


</style>
