<template>
    <div class="container">
        <h1 class="text-center my-2">{{ stateText }}</h1>
        <div class="row text-center">
            <div class="offset-1 col-5">
                <h2>Su tablero</h2>
                <board :id="ownBoard.id" @shipPlaced="availableShips = availableShips.splice(1)" :match-id="matchId" :size="ownBoard.size" modality="own" class="own" :state="state" :available-ships="availableShips"></board>
            </div>
            <div class="col-5">
                <h2>Su adversario</h2>
                <board :id="enemyBoard.id" :match-id="matchId" :size="enemyBoard.size" modality="enemy" class="enemy" :state="state"></board>
            </div>
        </div>
        <p class="instructions text-center mt-3">
            <template v-if="state == 'placing'">
                <b>Clic</b>: colocar pieza<br>
                <b>Clic derecho</b>: rotar pieza
            </template>
            <template v-else-if="state == 'attacking'">
                <b>Clic</b>: mandar ataque
            </template>
            <template v-else-if="state == 'attacking-stand-by'">
                Esperando el ataque de su adversario
            </template>
            <template v-else-if="state == 'waiting-opponent'">
                Espere a su adversario
            </template>
            <template v-else-if="state == 'finished'">
                Gracias por jugar. Regrese a la <a href="/">página principal</a> para empezar un juego nuevo.
            </template>
            <template v-else>
                Espere
            </template>
        </p>
    </div>
</template>

<script>
import Board from './Board'

export default {
    components: { Board },
    props: ['match-id', 'own-board', 'enemy-board', 'user-id'],
    data() {
        return {
            state: '',
            turn: null,
            availableShips: [
                {
                    position: { x: 0, y: 0 },
                    length: 4,
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
            ],
            winnerId: -1
        }
    },
    computed: {
        stateText() {
            switch (this.state) {
                case 'waiting-opponent':
                    return "Esperando un adversario"
                    break
                case 'placing':
                    return "Colocando fichas"
                    break
                case 'attacking':
                    return "Su turno de atacar"
                    break
                case 'attacking-stand-by':
                    return "Turno de su adversario"
                    break
                case 'finished':
                    return this.winnerId == this.userId ? "Victoria" : "Derrota"
                    break
                default:
                    return "Espere"
                    break
            }
        },
        isMyTurn() {
            return this.turn == this.userId
        }
    },
    mounted() {
        let t = this
        axios.get('match/' + this.matchId + '/state').then((r) => {
            t.state = r.data
        })

        axios.get('match/' + this.matchId + '/winner').then((r) => {
            t.winnerId = r.data
        })

        Echo.channel('match.' + this.matchId).listen('MatchStateUpdated', (e) => {
            t.state = e.match.state
            t.winnerId = e.match.winner_id
            t.turn = e.match.turn
        }).listen('MatchTurn', (e) => {
            t.turn = e.match.turn
            if (!t.isMyTurn)
                t.state = 'attacking-stand-by'
            else
                t.state = 'attacking'
        })
    }
}
</script>
