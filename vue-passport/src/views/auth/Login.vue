<template>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div v-if="loginFailed" class="alert alert-danger">
                    Email atau Password Anda Salah
                </div>
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>Login</h4>
                        <hr>
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" v-model="user.email" class="form-control" placeholder="Email Address">
                            </div>
                            <div v-if="validation.email" class="mt-2 alert alert-danger">
                                {{ validation.email[0] }}
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" v-model="user.password" class="form-control"
                                    placeholder="Password">
                            </div>
                            <div v-if="validation.password" class="mt-2 alert alert-danger">
                                {{ validation.password[0] }}
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive,ref} from 'vue'
import {useRouter} from 'vue-router'
import axios from 'axios'

export default {
    setup(){
        // inisialisasi vue router on composition api
        const router  = useRouter()
        
        const user = reactive({
            email:'',
            password:''
        })


        const validation = ref([])

        const loginFailed = ref(null)

        // method login

        function login(){
            // define vareable
            let email = user.email
            let password = user.password

            // send server with axios
            axios.post('http://localhost:8000/api/login',{
                email,
                password
            })
            .then(response => {
                if(response.data.success){
                    // set token ,
                    localStorage.setItem('token',response.data.token)

                    // redirect ke halaman dashbord
                    return router.push({
                        name:'dashboard'
                    })
                }
                // set state loggedin to true
                loginFailed.value = true

            }).catch(error => {
                validation.value = error.response.data
            })
        }

        return {
            user,
            validation,
            loginFailed,
            login
        }

    }
    
}
</script>