<template>
    <div>

    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    data(){
        return {
            code : '',
            provider : '',
        }
    },
    computed : {
        ...mapGetters({
              user : 'auth/user',  
        })
    },
    methods : {
        ...mapActions({
            setAlert : 'alert/set',
            setAuth : 'auth/set',
            setDialogStatus : 'dialog/setStatus'
        }),
        go(provider, code){
            let url = '/api/auth/social/' + provider + '/callback?code=' + code
            console.log(url)
            axios.get(url)
                .then((response) => {
                    let {data} = response.data
                    this.setAuth(data)
                    console.log('adsada')
                    console.log(this.user.user)
                    if(this.user.user.email !== ""){
                        this.setAlert({
                            status : true , 
                            color : 'success', 
                            text : 'login success',
                            })
                        this.setDialogStatus(false)
                        this.$router.push({name : 'home'})
                    }
                    else{
                        this.setAlert({
                            status : true , 
                            color : 'error', 
                            text : 'login failed bb',

                        })
                    }
                })
                .catch((error) => {
                    this.setAlert({
                        status : true , 
                        color : 'error', 
                        text : 'login failed aa',

                    })
                })
            }
    },
    mounted(){
        this.code = this.$route.query.code
        this.provider = this.$route.path.split('/')[3]

        this.go(this.provider, this.code)
    }
}
</script>