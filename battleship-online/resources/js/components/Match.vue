<template>
    <div class="container">
        <h1 class="text-center">{{ stateText }}</h1>
        <div class="row">
            <div class="offset-1 col-5">
                <h2>Su tablero</h2>
                <board @shipPlaced="availableShips.splice(0, 1)" :match-id="matchId" :attacks="attacks.received" :size="board.size" modality="own" class="own" :state="state" :available-ships="availableShips"></board>
            </div>
            <div class="col-5">
                <h2>Su adversario</h2>
                <board :match-id="matchId" :attacks="attacks.sent" :size="board.size" modality="enemy" class="enemy" :state="state"></board>
            </div>
        </div>
        <p class="instructions text-center mt-3">
            <template v-if="state == 'placing'">
                <b>Clic</b>: colocar pieza<br>
                <b>Clic derecho</b>: rotar pieza
            </template>
            <template v-else-if="state == 'my-turn'">
                <b>Clic</b>: mandar ataque
            </template>
            <template v-else>
                Espere a su adversario
            </template>
        </p>
    </div>
</template>

<script>
import Board from './Board'

export default {
    components: { Board },
    props: ['match-id'],
    data() {
        return {
            state: 'placing',
            attacks: {
                sent: [],
                received: [],
            },
            board: {
                size: 10
            },
            availableShips: [
                {
                    position: { x: 0, y: 0 },
                    length: 2,
                    orientation: 'v'
                },
                {
                    position: { x: 0, y: 0 },
                    length: 3,
                    orientation: 'h'
                },
                {
                    position: { x: 0, y: 0 },
                    length: 3,
                    orientation: 'h'
                },
                {
                    position: { x: 0, y: 0 },
                    length: 2,
                    orientation: 'v'
                }
            ]
        }
    },
    computed: {
        stateText() {
            switch (this.state) {
                case 'placing':
                    return "Colocando fichas"
                    break
                case 'my-turn':
                    return "Su turno"
                    break
                case 'enemy-turn':
                    return "Turno de su enemigo"
                    break
                case 'stand-by':
                    return "Espere"
                    break
            }
        }
    },
    watch: {
        availableShips() {
            if (this.availableShips.length == 0)
                this.state = 'stand-by'
        }
    }
}
</script>
