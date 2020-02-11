<template>
    <div class="board" @click.right.prevent="toggleNewShipOrientation">
        <div class="container" @click="placeNewShip">
            <ship v-for="ship in ships" :origin="boardOrigin" :cell-size="cellHeight" :position="ship.position" :orientation="ship.orientation" :length="ship.length" :key="'ship-' + ship.position.x + '-' + ship.position.y"/>
            <ship v-if="state == 'placing'" :origin="boardOrigin" :cell-size="cellHeight" :position="newShip.position" :orientation="newShip.orientation" :length="newShip.length" key="new-ship"/>
            <div class="row" :class="'row-cols-' + size" v-for="row in size">
                <div :style="{ 'height': cellHeight + 'px' }"
                    :class="cellClass(column, row)"
                    class="cell col"
                    v-for="column in size"
                    :ref="'cell-' + row + '-' + column"
                    @mouseenter="moveNewShip(column, row)"
                    @click="placeNewShip"></div>
            </div>
        </div>
    </div>
</template>

<script>
import Ship from './Ship'

export default {
    data() {
        return {
            cellHeight: 10,
            boardOrigin: { x: 0, y: 0 },
            ships: [],
            newShip: {
                position: {
                    x: 0,
                    y: 0,
                },
                orientation: 'h',
                length: 3
            }
        }
    },
    components: { Ship },
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
        modality: {
            type: String,
            required: true,
        },
        state: {
            type: String,
            required: true
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
        onResize() {
            let rect = this.$refs['cell-1-1'][0].getBoundingClientRect()
            this.cellHeight = rect.width
            this.boardOrigin = {
                x: rect.x,
                y: rect.y
            }
        },
        toggleNewShipOrientation() {
            if (this.state != 'placing')
                return
            if ('h' == this.newShip.orientation)
                this.newShip.orientation = 'v'
            else
                this.newShip.orientation = 'h'
        },
        moveNewShip(x, y) {
            if (this.state != 'placing')
                return

            if (this.newShip.orientation == 'h'
                && x - 1 + this.newShip.length > this.size)
                return

            if (this.newShip.orientation == 'v'
                && y - 1 + this.newShip.length > this.size)
                return

            this.newShip.position.x = x
            this.newShip.position.y = y
        },
        placeNewShip() {
            console.log("Placing new ship")
            this.ships.push(_.cloneDeep(this.newShip))
        }
    },
    mounted() {
        this.onResize()
        window.addEventListener('resize', this.onResize)
    },
}
</script>
