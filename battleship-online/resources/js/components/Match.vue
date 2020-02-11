<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-9">
                <board :attacks="attacks.received" :size="board.size" modality="own" class="own" :state="state"></board>
            </div>
            <div class="col-xl-4 col-lg-3">
                <board :attacks="attacks.sent" :size="board.size" modality="enemy" class="enemy" :state="state"></board>
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
            state: 'placing',
            attacks: {
                sent: [
                    {
                        x: 2,
                        y: 2,
                        isHit: true
                    }
                ],
                received: [
                    {
                        x: 2,
                        y: 2,
                        isHit: true
                    },
                    {
                        x: 5,
                        y: 7,
                        isHit: false
                    }
                ],
            },
            board: {
                size: 10
            }
        }
    }
}
</script>
