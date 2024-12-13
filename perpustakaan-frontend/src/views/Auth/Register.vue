<template>
    <div class="register-container">
      <h2>Daftar</h2>
      <form @submit.prevent="handleRegister">
        <div>
          <label for="NIM">NIM</label>
          <input type="text" id="NIM" v-model="NIM" required />
        </div>
        <div>
          <label for="name">Nama</label>
          <input type="text" id="name" v-model="name" required :class="{'error-input': nameTaken}" />
          <span v-if="nameTaken" class="error-text">Nama sudah terdaftar.</span>
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required :class="{'error-input': emailTaken}" />
          <span v-if="emailTaken" class="error-text">Email sudah terdaftar.</span>
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password" required />
        </div>
        <div>
          <label for="password_confirmation">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" v-model="password_confirmation" required />
        </div>
        <div>
          <button type="submit" :disabled="isLoading">Daftar</button>
          <button type="button" @click="cancelRegistration">Batal</button> <!-- Tombol Batal -->
        </div>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      </form>
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
      },
      cancelRegistration() {
        // Mengarahkan pengguna kembali ke halaman login
        this.$router.push('/login');
      }
    }
  };
  </script>
  
  <style scoped>
  .error-input {
    border-color: red;
  }
  .error-text {
    color: red;
    font-size: 12px;
  }
  button {
    margin: 10px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
  }
  button:hover {
    background-color: #3498db;
    color: white;
  }
  </style>
  