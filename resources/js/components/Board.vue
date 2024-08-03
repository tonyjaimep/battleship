<template>
    <div class="board" @click.right.prevent="toggleNewShipOrientation" :class="[modality, state]">
        <div class="container" @click="placeNewShip">
            <ship v-for="ship in ships" :origin="boardOrigin" :cell-size="cellHeight" :position="ship.position" :orientation="ship.orientation" :length="ship.length" :key="'ship-' + ship.position.x + '-' + ship.position.y"/>
            <ship v-if="modality == 'own' && state == 'placing' && availableShips.length" :origin="boardOrigin" :cell-size="cellHeight" :position="newShip.position" :orientation="newShip.orientation" :length="newShip.length" key="new-ship" :class="{'invalid-position': !isValidNewShipPosition}"/>
            <div class="row" :class="'row-cols-' + size" v-for="row in size">
                <div :style="{ 'height': cellHeight + 'px' }"
                    :class="cellClass(column, row)"
                    class="cell col"
                    v-for="column in size"
                    :ref="'cell-' + row + '-' + column"
                    @mouseenter="moveNewShip(column, row)"
                    @click="onCellClick(column, row)"></div>
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
            attacks: [],
            newShip: {
                position: {
                    x: 0,
                    y: 0,
                },
                orientation: '',
                length: 0
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
        },
        'id': {
            type: Number,
            required: true
        }
    },
    methods: {
        onCellClick(x, y) {
            switch (this.state) {
                case 'placing':
                    this.placeNewShip()
                    break
                case 'attacking':
                    if (this.modality == 'enemy')
                        this.sendAttack(x, y)
                    break
            }
        },
        sendAttack(x, y) {
            if (this.modality != 'enemy' && this.state != 'attacking')
                return

            let data = new FormData()

            data.append('x', x)
            data.append('y', y)
            data.append('target_board_id', this.id)

            axios.post('board/' + this.id + '/attack', data);
        },
        cellClass(x, y) {
            let attack = _.find(this.attacks, { target_x: Number(x), target_y: Number(y)})
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
            if (this.state != 'placing' || this.modality != 'own')
                return
            if ('h' == this.newShip.orientation)
                this.newShip.orientation = 'v'
            else
                this.newShip.orientation = 'h'
        },
        moveNewShip(x, y) {
            if (this.state != 'placing' || this.modality != 'own')
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

            let data = new FormData()

            data.append('x', this.newShip.position.x)
            data.append('y', this.newShip.position.y)
            data.append('orientation', this.newShip.orientation)
            data.append('length', this.newShip.length)
            data.append('board_id', this.id)

            axios.post('board/' + this.id + '/piece', data).then((r) => {
                t.$emit('shipPlaced', r.data)
                t.ships.push(r.data)
            })
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
    created() {
        let t = this
        // fetch ships if board is own
        if (this.modality == 'own') {
            axios.get('/board/' + this.id + '/pieces').then((r) => {
                t.ships = r.data
            })
        }

        axios.get('/board/' + this.id + '/attacks').then((r) => {
            t.attacks = r.data
        })

        Echo.channel('board.' + this.id)
            .listen('AttackSent', (e) => {
                let attack = e.attack
                attack.target_x = Number(attack.target_x)
                attack.target_y = Number(attack.target_y)
                attack.hit = Boolean(attack.hit_piece_id)
                t.attacks.push(attack)
            }).listen('PieceDestroyed', (e) => {
                let idx = _.findIndex(t.ships, {id: e.piece.id})
                t.ships.splice(idx, 1)
            });
    }
}
</script>
