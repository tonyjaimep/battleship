<template>
    <div
        :style="{
            width: width,
            height: height,
            left: x,
            top: y,
            transform: `rotate(${rotation})`,
            transformOrigin,
        }"
        class="ship"
    ></div>
</template>

<script>
export default {
    props: {
        length: {
            type: Number,
            required: true,
        },
        position: {
            type: Object,
            required: true,
        },
        orientation: {
            type: String,
            required: true,
        },
        "cell-size": {
            type: Number,
            required: true,
        },
        origin: {
            type: Object,
            required: true,
        },
    },
    computed: {
        width() {
            return this.cellSize * this.length + "px";
        },
        height() {
            return this.cellSize + "px";
        },
        rotation() {
            return this.orientation === "h" ? "0" : "90deg";
        },
        transformOrigin() {
            return this.cellSize / 2 + "px center";
        },
        x() {
            return this.cellSize * (this.position.x - 1) + "px";
        },
        y() {
            return this.cellSize * (this.position.y - 1) + "px";
        },
    },
};
</script>
