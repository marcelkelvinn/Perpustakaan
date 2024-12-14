<template>
  <div class="home-container">
    <h1>Selamat datang di Aplikasi Perpustakaan</h1>
    <div class="button-container">
      <button @click="goToBuku">Buku</button>
      <button @click="goToPeminjaman">Peminjaman</button>
      <button @click="goToDenda">Denda</button>
      <button @click="goToSirkulasi">Sirkulasi</button>
      <button @click="goToProfile">Profil</button>
    </div>
    <div class="logout-container">
      <button @click="logout">Logout</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Home',
  methods: {
    goToBuku() {
      this.$router.push('/buku');
    },
    goToPeminjaman() {
      this.$router.push('/peminjaman');
    },
    goToDenda() {
      this.$router.push('/denda');
    },
    goToSirkulasi() {
      this.$router.push('/sirkulasi');
    },
    goToProfile() {
      this.$router.push('/profile');
    },
    async logout() {
      try {
        const token = localStorage.getItem('auth_token');
        if (token) {
          await axios.post('http://localhost:8000/api/logout', {}, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });
          
          localStorage.removeItem('auth_token');
          localStorage.removeItem('user');
          
          this.$router.push('/login');
        }
      } catch (error) {
        console.error('Logout failed:', error);
      }
    }
  },
};
</script>

<style scoped>
.home-container {
  text-align: center;
  margin-top: 50px;
}
.button-container {
  margin-top: 30px;
}
.logout-container {
  margin-top: 20px;
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
