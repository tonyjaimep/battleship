<template>
    <div class="board" @click.right.prevent="toggleNewShipOrientation">
        <div class="container" @click="placeNewShip">
            <ship v-for="ship in ships" :origin="boardOrigin" :cell-size="cellHeight" :position="ship.position" :orientation="ship.orientation" :length="ship.length" :key="'ship-' + ship.position.x + '-' + ship.position.y"/>
            <ship v-if="modality == 'own' && state == 'placing'" :origin="boardOrigin" :cell-size="cellHeight" :position="newShip.position" :orientation="newShip.orientation" :length="newShip.length" key="new-ship" :class="{'invalid-position': !isValidNewShipPosition}"/>
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
            },
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
        },
        'available-ships': {
            type: Array,
            required: false
        },
        'match-id': {
            type: Number
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

            this.newShip.position.x = x
            this.newShip.position.y = y
        },
        placeNewShip() {
            if (this.state != 'placing')
                return

            if (!this.isValidNewShipPosition)
                return

            let t = this

            //axios.put('match/' + this.matchId + '/ship').then((r) => {
                t.ships.push(_.cloneDeep(this.newShip))
                t.$emit('shipPlaced')
            //})
        },
        shipsIntersect(shipA, shipB) {
            if (shipA.orientation === 'h') {
                if (shipB.orientation === 'h')
                    return shipA.position.y == shipB.position.y && shipA.position.x >= shipB.position.x && shipA.position.x < shipB.position.x + shipB.length
                if (shipB.orientation === 'v')
                    return shipA.position.y >= shipB.position.y && shipA.position.y < shipB.position.y + shipB.length && shipA.position.x + shipA.length - 1 >= shipB.position.x && shipA.position.x <= shipB.position.x
            }

            if (shipA.orientation === 'v') {
                if (shipB.orientation === 'v')
                    return shipA.position.x == shipB.position.x && shipA.position.y >= shipB.position.y && shipA.position.y < shipB.position.y + shipB.length
                if (shipB.orientation === 'h')
                    return shipA.position.x >= shipB.position.x && shipA.position.x < shipB.position.x + shipB.length && shipA.position.y + shipA.length - 1 >= shipB.position.y && shipA.position.y <= shipB.position.y
            }
        }
    },
    computed: {
        isValidNewShipPosition() {
            if (this.newShip.orientation == 'h'
                && this.newShip.position.x - 1 + this.newShip.length > this.size)
                return false

            if (this.newShip.orientation == 'v'
                && this.newShip.position.y - 1 + this.newShip.length > this.size)
                return false

            if (this.ships.some(ship => this.shipsIntersect(ship, this.newShip)))
                return false

            return true
        }
    },
    watch: {
        availableShips() {
            if (this.availableShips.length)
                Object.assign(this.newShip, this.availableShips[0])
        }
    },
    mounted() {
        if (this.availableShips)
            Object.assign(this.newShip, this.availableShips[0])
        this.onResize()
        window.addEventListener('resize', this.onResize)
    },
}
</script>
