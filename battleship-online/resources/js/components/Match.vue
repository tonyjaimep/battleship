<template>
    <div class="container">
        <h1 class="text-center my-2">{{ stateText }}</h1>
        <div class="row text-center">
            <div class="offset-1 col-5">
                <h2>Su tablero</h2>
                <board :id="ownBoard.id" @shipPlaced="availableShips.shift()" :match-id="matchId" :attacks="attacks.received" :size="ownBoard.size" modality="own" class="own" :state="state" :available-ships="availableShips"></board>
            </div>
            <div class="col-5">
                <h2>Su adversario</h2>
                <board :id="enemyBoard.id" :match-id="matchId" :attacks="attacks.sent" :size="enemyBoard.size" modality="enemy" class="enemy" :state="state"></board>
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
    props: ['match-id', 'own-board', 'enemy-board'],
    data() {
        return {
            state: '',
            attacks: {
                sent: [],
                received: [],
            },
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
            ]
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
                    return "Ataque"
                    break
                case 'attacking-stand-by':
                    return "Esperando ataque"
                    break
                default:
                    return "Espere"
                    break
            }
        }
    },
    mounted() {
        let t = this
        axios.get('match/' + this.matchId + '/state').then((r) => {
            t.state = r.data
        })

        Echo.channel('match.' + this.matchId).listen('MatchStateUpdated', (e) => {
            t.state = e.match.state
        }).listen('AttackSent', (e) => {
            if (e.attack.target_board_id == t.ownBoard.id)
                t.attacks.received.push(e.attack)
            else
                t.attacks.sent.push(e.attack)
        });
    }
}
</script>
