<template>
    <div class="register-container">
        <div class="register-box">
            <form @submit.prevent="handleRegister">
                <div class="form-group">
                    <label for="NIM">NIM</label>
                    <input type="text" id="NIM" v-model="NIM" placeholder="Enter your NIM" required />
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" v-model="name" placeholder="Enter your name" required />
                    <span v-if="nameTaken" class="error-text">Nama sudah terdaftar.</span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" v-model="email" placeholder="Enter your email" required />
                    <span v-if="emailTaken" class="error-text">Email sudah terdaftar.</span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" v-model="password" placeholder="Enter your password" required />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" v-model="password_confirmation" placeholder="Confirm your password" required />
                </div>

                <button type="submit" class="submit-button">Register</button>
            </form>

            <p class="signup-link">
                Already have an account? <router-link to="/login">Login Here</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
  
  export default {
    data() {
      return {
        NIM: '',
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        isLoading: false,
        errorMessage: '',
        nameTaken: false,
        emailTaken: false
      };
    },
    methods: {
      async handleRegister() {
        this.isLoading = true;
        this.errorMessage = '';
        this.nameTaken = false;
        this.emailTaken = false;
  
        if (this.password !== this.password_confirmation) {
          this.errorMessage = 'Password dan konfirmasi password tidak cocok.';
          this.isLoading = false;
          return;
        }
  
        try {
          const response = await axios.post('http://localhost:8000/api/register', {
            NIM: this.NIM,
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          });
  
          if (response.data.token) {
            localStorage.setItem('auth_token', response.data.token);
            localStorage.setItem('user', JSON.stringify(response.data.user));
            this.$router.push('/');
          }
        } catch (error) {
          if (error.response && error.response.data.errors) {
            if (error.response.data.errors.name) {
              this.nameTaken = true;
            }
            if (error.response.data.errors.email) {
              this.emailTaken = true;
            }
          } else {
            this.errorMessage = 'Terjadi kesalahan, coba lagi.';
          }
        } finally {
          this.isLoading = false;
        }
      }
    }
  };
</script>

<style scoped>
.register-box {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.submit-button {
    background-color: #007bff;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

.submit-button:hover {
    background-color: #0056b3;
}

.signup-link {
    margin-top: 20px;
    font-size: 14px;
}

.signup-link a {
    color: #007bff;
    text-decoration: none;
}
</style>