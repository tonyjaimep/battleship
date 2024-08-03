<template>
    <div :style="{ 'width': width, 'height': height, 'left': x, 'top': y }" class="ship" :class="['ship-length-' + length, 'ship-orientation-' + orientation]"></div>
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
        },
        'cell-size': {
            type: Number,
            required: true
        },
        origin: {
            type: Object,
            required: true
        }
    },
    computed: {
        width() {
            if (this.orientation === 'h') {
                return this.cellSize * this.length + 'px'
            } else {
                return this.cellSize + 'px'
            }
        },
        height() {
            if (this.orientation === 'v') {
                return this.cellSize * this.length + 'px'
            } else {
                return this.cellSize + 'px'
            }
        },
        x() {
            return this.origin.x + this.cellSize * (this.position.x - 1) + 'px'
        },
        y() {
            return this.origin.y + this.cellSize * (this.position.y - 1) + 'px'
        }
    }
}
</script>
