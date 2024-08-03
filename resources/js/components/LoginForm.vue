<template>
    <form @submit.prevent="submitUserName">
        <input type="text" v-model="nickname" name="nickname" class="form-control" placeholder="Nickname" required>
        <button class="btn btn-primary btn-block">Entrar</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            nickname: ''
        }
    },
    methods: {
        submitUserName() {
            let data = new FormData()

            data.append('name', this.nickname)

            axios.post('login', data).then(() => {
                window.location.reload()
            })
        }
    }
}
</script>
