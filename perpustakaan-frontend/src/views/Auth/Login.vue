<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" v-model="email" required />
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <div>
        <button type="submit" :disabled="isLoading">Login</button>
      </div>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </form>
    <p>
      Belum punya akun? <router-link to="/register">Daftar di sini</router-link>
    </p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      isLoading: false,
      errorMessage: ''
    };
  },
  methods: {
    async handleLogin() {
      this.isLoading = true;
      this.errorMessage = '';

      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          email: this.email,
          password: this.password
        });

        if (response.data.token) {
          localStorage.setItem('auth_token', response.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.user));
          this.$router.push('/');
        }
      } catch (error) {
        this.errorMessage = 'Invalid email or password';
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>
