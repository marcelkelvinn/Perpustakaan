<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <h3>{{ selectedPeminjaman ? "Edit Peminjaman" : "Tambah Peminjaman" }}</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>Nama Peminjam</label>
          <select v-model="peminjaman.id_user" class="form-control" required>
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label>Judul Buku</label>
          <select v-model="peminjaman.id_buku" class="form-control" required>
            <option v-for="buku in bukus" :key="buku.id" :value="buku.id">
              {{ buku.judul }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label>Tanggal Pinjam</label>
          <input type="date" v-model="peminjaman.tgl_pinjam" class="form-control" required />
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
  name: "PeminjamanForm",
  props: ["selectedPeminjaman"],
  data() {
    return {
      peminjaman: {
        id_user: "",
        id_buku: "",
        tgl_pinjam: "",
      },
      users: [],
      bukus: [],
    };
  },
  async created() {
    await this.fetchUsers();
    await this.fetchBukus();

    if (this.selectedPeminjaman) {
      this.peminjaman = { ...this.selectedPeminjaman };
    }
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
        const response = await axios.get("http://localhost:8000/api/bukus");
        this.bukus = response.data;
      } catch (error) {
        console.error("Error fetching books:", error);
      }
    },
    async submitForm() {
      try {
        if (this.selectedPeminjaman) {
          // Update existing peminjaman
          await axios.put(
            `http://localhost:8000/api/peminjaman/${this.peminjaman.id}`,
            this.peminjaman
          );
          alert("Peminjaman berhasil diperbarui");
        } else {
          // Create new peminjaman
          await axios.post("http://localhost:8000/api/peminjaman", this.peminjaman);
          alert("Peminjaman berhasil ditambahkan");
        }
        this.$emit("close");
      } catch (error) {
        console.error("Error saving peminjaman:", error);
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