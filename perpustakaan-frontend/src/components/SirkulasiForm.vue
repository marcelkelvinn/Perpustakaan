<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <h3>{{ selectedSirkulasi ? "Edit Sirkulasi" : "Tambah Sirkulasi" }}</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>User</label>
          <select v-model="sirkulasi.id_user" class="form-control" required>
            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
          </select>
        </div>
        <div class="form-group">
          <label>Judul Buku</label>
          <select v-model="sirkulasi.id_buku" class="form-control" required>
            <option v-for="buku in bukus" :key="buku.id" :value="buku.id">{{ buku.judul }}</option>
          </select>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select v-model="sirkulasi.status" class="form-control" required>
            <option value="dipinjam">Dipinjam</option>
            <option value="kembali">Kembali</option>
          </select>
        </div>
        <div class="form-group mt-3">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SirkulasiForm",
  props: ["selectedSirkulasi"],
  data() {
    return {
      sirkulasi: {
        id_user: "",
        id_buku: "",
        status: "dipinjam",
      },
      users: [],
      bukus: [],
    };
  },
  async created() {
    if (this.selectedSirkulasi) {
      this.sirkulasi = { ...this.selectedSirkulasi };
    }
    await this.fetchUsers();
    await this.fetchBukus();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get("http://localhost:8000/api/users");
        this.users = response.data;
      } catch (error) {
        console.error("Error fetching users:", error);
      }
    },
    async fetchBukus() {
      try {
        const response = await axios.get("http://localhost:8000/api/buku");
        this.bukus = response.data;
      } catch (error) {
        console.error("Error fetching books:", error);
      }
    },
    async submitForm() {
      try {
        if (this.selectedSirkulasi) {
          await axios.put(`http://localhost:8000/api/sirkulasi/${this.sirkulasi.id}`, this.sirkulasi);
          alert("Sirkulasi berhasil diperbarui");
        } else {
          await axios.post("http://localhost:8000/api/sirkulasi", this.sirkulasi);
          alert("Sirkulasi berhasil ditambahkan");
        }
        this.$emit("close");
      } catch (error) {
        console.error("Error saving sirkulasi:", error);
      }
    },
  },
};
</script>

<style>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
}
</style>
