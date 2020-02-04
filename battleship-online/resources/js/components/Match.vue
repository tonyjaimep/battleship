<template>
    <div class="row">
        <div class="col-xl-8 col-lg-9">
            <board :ships="ships" :attacks="attacks.received" :size="board.size"></board>
        </div>
        <div class="col-xl-4 col-lg-3">
            <board :attacks="attacks.sent" :size="board.size"></board>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ships: [],
            attacks: {
                sent: [],
                received: [],
            },
            board: {
                size: 10
            }
        }
    }
}
</script>
