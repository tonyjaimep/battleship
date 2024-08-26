<template>
    <div class="container">
        <h1 class="text-center my-2">{{ stateText }}</h1>
        <div class="row text-center">
            <div class="offset-1 col-5">
                <h2>Your board</h2>
                <board
                    :id="ownBoard.id"
                    @shipPlaced="availableShips = availableShips.splice(1)"
                    :game-match-id="gameMatchId"
                    :size="ownBoard.size"
                    modality="own"
                    class="own"
                    :state="state"
                    :available-ships="availableShips"
                ></board>
            </div>
            <div class="col-5">
                <h2>Opponent</h2>
                <board
                    :id="enemyBoard.id"
                    :game-match-id="gameMatchId"
                    :size="enemyBoard.size"
                    modality="enemy"
                    class="enemy"
                    :state="state"
                ></board>
            </div>
        </div>
        <p class="instructions text-center mt-3">
            <template v-if="state == 'placing'">
                <b>Mouse1</b>: place ship<br />
                <b>Mouse2</b>: rotate ship
            </template>
            <template v-else-if="state == 'attacking'">
                <b>Mouse1</b>: attack
            </template>
            <template v-else-if="state == 'attacking-stand-by'">
                Waiting for opponent attack
            </template>
            <template v-else-if="state == 'waiting-opponent'">
                Waiting for your opponent
            </template>
            <template v-else-if="state == 'finished'">
                Thank you for playing! Go back to the
                <a href="/">home screen</a> to start a new match.
            </template>
            <template v-else> Wait </template>
        </p>
    </div>
</template>

<script>
import Board from "./Board";

export default {
    components: { Board },
    props: ["game-match-id", "own-board", "enemy-board", "user-id"],
    data() {
        return {
            state: "",
            turn: null,
            availableShips: [
                {
                    position: { x: 0, y: 0 },
                    length: 4,
                    orientation: "v",
                },
                {
                    position: { x: 0, y: 0 },
                    length: 3,
                    orientation: "h",
                },
                {
                    position: { x: 0, y: 0 },
                    length: 3,
                    orientation: "h",
                },
                {
                    position: { x: 0, y: 0 },
                    length: 2,
                    orientation: "v",
                },
            ],
            winnerId: -1,
        };
    },
    computed: {
        stateText() {
            switch (this.state) {
                case "waiting-opponent":
                    return "Waiting for an opponent";
                case "placing":
                    return "Placing pieces";
                case "attacking":
                    return "Your turn";
                case "attacking-stand-by":
                    return "Opponent's turn";
                case "finished":
                    return this.winnerId == this.userId ? "You win!" : "Defeat";
                default:
                    return "Wait...";
            }
        },
        isMyTurn() {
            return this.turn == this.userId;
        },
    },
    async mounted() {
        let t = this;

        const { data: matchState } = await axios.get(
            "game-match/" + this.gameMatchId + "/state"
        );

        if (matchState === "attacking") {
            const { data: matchTurn } = await axios.get(
                "game-match/" + this.gameMatchId + "/turn"
            );

            t.turn = matchTurn;

            if (!t.isMyTurn) t.state = "attacking-stand-by";
            else t.state = "attacking";
        } else {
            t.state = matchState;
        }

        const { data: winnerId } = await axios.get(
            "game-match/" + this.gameMatchId + "/winner"
        );

        this.winnerId = winnerId;

        Echo.channel("gameMatch." + this.gameMatchId)
            .listen("GameMatchStateUpdated", (e) => {
                t.state = e.gameMatch.state;
                t.winnerId = e.gameMatch.winner_id;
                t.turn = e.gameMatch.turn;
            })
            .listen("GameMatchTurn", (e) => {
                t.turn = e.gameMatch.turn;
                if (!t.isMyTurn) t.state = "attacking-stand-by";
                else t.state = "attacking";
            });
    },
};
</script>
