<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-9">
                <board :ships="ships" :attacks="attacks.received" :size="board.size"></board>
            </div>
            <div class="col-xl-4 col-lg-3">
                <board :attacks="attacks.sent" :size="board.size"></board>
            </div>
        </div>
    </div>
</template>

<script>
import Board from './Board'

export default {
    components: { Board },
    data() {
        return {
            ships: [],
            attacks: {
                sent: [
                    {
                        x: 2,
                        y: 2,
                        isHit: true
                    }
                ],
                received: [],
            },
            board: {
                size: 10
            }
        }
    }
}
</script>
