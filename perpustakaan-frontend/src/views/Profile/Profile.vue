<template>
  <div>
    <button class="logout-button" @click="logout">Log out</button>

    <div class="profile-container" v-if="user && !editing">
      <div class="profile-content" v-if="user">
        <div class="profile-picture">
          <span class="icon-profile"></span>
        </div>
        <h2 class="profile-name">{{ user.name }}</h2>
        <button class="edit-profile-button" @click="startEditing">Edit Profile</button>
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
    </div>

    <!-- Loading indicator -->
    <div v-if="loading" class="profile-container">
      <p>Loading...</p>
    </div>

    <div class="profile-container" v-if="editing">
      <form @submit.prevent="submitEditProfile">
        <div class="form-row">
          <label for="name">Nama:</label>
          <input type="text" id="name" v-model="editForm.name" required />
        </div>
        <div class="form-row">
          <label for="email">NIM:</label>
          <input type="text" id="NIM" v-model="editForm.NIM" required />
        </div>
        <div class="form-row">
          <label for="role">Email:</label>
          <input type="email" id="email" v-model="editForm.email" required />
        </div>
        <div class="form-actions">
          <button type="submit" class="save-button">Save</button>
          <button type="button" class="cancel-button" @click="cancelEditing">Cancel</button>
        </div>
      </form>
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
      editing: false,
      loading: true, // Status loading
      editForm: {
        name: '',
        NIM: '',
        email: ''
      },
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
        this.loading = false;
      } catch (error) {
        this.errorMessage = 'Terjadi kesalahan, coba lagi.';
        console.error(error);
        this.loading = false;
      }
    },
    startEditing() {
      this.editing = true;
      this.editForm.name = this.user.name;
      this.editForm.NIM = this.user.NIM;
      this.editForm.email = this.user.email;
    },
    cancelEditing() {
      this.editing = false;
    },
    async submitEditProfile() {
      try {
        const token = localStorage.getItem('auth_token');
        if (!token) {
          this.$router.push('/login');
          return;
        }

        const response = await axios.put(`http://localhost:8000/api/uprofile/${this.user.id}`, this.editForm, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.user = response.data;
        this.editing = false;
      } catch (error) {
        console.error(error);
        this.errorMessage = 'Terjadi kesalahan saat menyimpan perubahan.';
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
.logout-button {
  position: fixed;
  top: 10px;
  right: 10px;
  padding: 5px 10px;
  background-color: #ff4d4d;
  color: #ffffff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  z-index: 1000;
  width: 100px;
}

.logout-button:hover {
  background-color: #cc0000;
}

.profile-container {
  font-family: Arial, sans-serif;
  background-color: #f3f3f3;
  padding: 20px;
  max-width: 600px;
  margin: 50px auto;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.profile-content {
  text-align: center;
}

.profile-picture {
  text-align: center;
  margin-bottom: 20px;
}

.icon-profile {
  font-size: 50px;
  background-color: #d3d3d3;
  color: #ffffff;
  border-radius: 50%;
  padding: 20px;
  display: inline-block;
  width: 100px;
  height: 100px;
  line-height: 60px;
}

.profile-name {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 10px;
}

.edit-profile-button {
  display: block;
  margin: 0 10px 20px auto;
  padding: 8px 16px;
  background-color: #28a745;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  width: 100px;
}

.edit-profile-button:hover {
  background-color: #218838;
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

form {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  margin: 0 auto;
}

.form-row {
  margin: 25px;
}

.form-row label {
  font-weight: bold;
}

.form-row input {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-actions {
  text-align: center;
  display: flex;
  justify-content: center;
  /* Menyusun tombol di tengah */
  gap: 10px;
  /* Memberikan jarak antar tombol */
}

.save-button,
.cancel-button {
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.save-button {
  background-color: #28a745;
  color: white;
}

.save-button:hover {
  background-color: #218838;
}

.cancel-button {
  background-color: #f44336;
  color: white;
}

.cancel-button:hover {
  background-color: #d32f2f;
}
</style>
