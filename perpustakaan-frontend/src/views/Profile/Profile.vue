<template>
  <div class="profile-container">
    <div class="profile-header">
      <button class="logout-button" @click="logout">Log out</button>
    </div>

    <div class="profile-content" v-if="user">
      <h2 class="profile-name">{{ user.name }}</h2>

      <div class="profile-details">
        <div class="detail-row">
          <span class="detail-label">Nama:</span>
          <span class="detail-value">{{ user.name }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">NIM:</span>
          <span class="detail-value">{{ user.NIM }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Email:</span>
          <span class="detail-value">{{ user.email }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Role:</span>
          <span class="detail-value">{{ user.role }}</span>
        </div>
      </div>
    </div>

    <div v-else>
      <p>Loading...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "ProfileView",
  data() {
    return {
      user: null,
      errorMessage: ''
    };
  },
  created() {
    this.fetchUserProfile();
  },
  methods: {
    async fetchUserProfile() {
      try {
        const token = localStorage.getItem('auth_token');

        if (!token) {
          this.$router.push('/login');
          return;
        }

        const response = await axios.get('http://localhost:8000/api/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.user = response.data;
      } catch (error) {
        this.errorMessage = 'Terjadi kesalahan, coba lagi.';
        console.error(error);
      }
    },
    logout() {
      const token = localStorage.getItem('auth_token');
      if (token) {
        axios.post('http://localhost:8000/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
          .then(() => {
            localStorage.removeItem('auth_token');
            this.$router.push('/login');
          })
          .catch((error) => {
            console.error(error);
          });
      }
    }
  }
};
</script>

<style scoped>
.profile-container {
  font-family: Arial, sans-serif;
  background-color: #f3f3f3;
  padding: 20px;
  max-width: 600px;
  margin: 0 auto;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.profile-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.logout-button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #007bff;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

.logout-button:hover {
  background-color: #0056b3;
}

.profile-content {
  text-align: center;
}

.profile-picture {
  margin-bottom: 20px;
}

.placeholder-image {
  width: 100px;
  height: 100px;
  background-color: #d3d3d3;
  border-radius: 50%;
}

.profile-name {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 20px;
}

.profile-details {
  text-align: left;
  background: #ffffff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.detail-row {
  display: flex;
  margin-bottom: 10px;
}

.detail-label {
  font-weight: bold;
  width: 100px;
}

.detail-value {
  flex: 1;
}

.edit-profile-button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #007bff;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.edit-profile-button:hover {
  background-color: #0056b3;
}
</style>
