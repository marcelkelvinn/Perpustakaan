<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <h3>{{ selectedBuku ? "Edit Buku" : "Tambah Buku" }}</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>Judul</label>
          <input type="text" v-model="buku.judul" class="form-control" required />
        </div>
        <div class="form-group">
          <label>ID Pengarang</label>
          <input type="number" v-model="buku.id_pengarang" class="form-control" required />
        </div>
        <div class="form-group">
          <label>ID Penerbit</label>
          <input type="number" v-model="buku.id_penerbit" class="form-control" required />
        </div>
        <div class="form-group">
          <label>ID Kategori</label>
          <input type="number" v-model="buku.id_kategori" class="form-control" required />
        </div>
        <div class="form-group">
          <label>Tahun Terbit</label>
          <input type="number" v-model="buku.tahun_terbit" class="form-control" required />
        </div>
        <div class="form-group mt-4">
          <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
          <button type="button" class="btn btn-secondary btn-cancel" style="float: right;" @click="$emit('close')">Batal</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "BukuForm",
  props: ["selectedBuku"],
  data() {
    return {
      buku: {
        judul: "",
        id_pengarang: "",
        id_penerbit: "",
        id_kategori: "",
        tahun_terbit: "",
      },
      isLoading: false,
      errorMessage: "",
    };
  },
  created() {
    if (this.selectedBuku) {
      this.buku = { ...this.selectedBuku };
    }
  },
  methods: {
    // Helper untuk mendapatkan instance axios dengan token
    getAxiosInstance() {
      const token = localStorage.getItem("auth_token");
      return axios.create({
        baseURL: "http://localhost:8000/api",
        headers: { Authorization: `Bearer ${token}` },
      });
    },
    async submitForm() {
      this.isLoading = true;
      this.errorMessage = "";

      try {
        const axiosInstance = this.getAxiosInstance();
        if (this.selectedBuku) {
          await axiosInstance.put(`/buku/${this.buku.id}`, this.buku);
          alert("Buku berhasil diperbarui");
        } else {
          await axiosInstance.post("/buku", this.buku);
          alert("Buku berhasil ditambahkan");
        }
        this.$emit("close");
      } catch (error) {
        this.errorMessage = "Failed to save book. Please check your input.";
      } finally {
        this.isLoading = false;
      }
    },
  },
};

</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #ffffff;
  padding: 30px;
  border-radius: 20px;
  width: 450px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h3 {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
}

input {
  width: 100%;
  padding: 10px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
  transition: all 0.3s ease;
}

input:focus {
  border-color: #007bff;
  outline: none;
}

button {
  width: 48%;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-submit {
  background-color: #4682B4;
  color: white;
  border: none;
}

.btn-submit:hover {
  background-color: #126b9b;
}

.btn-cancel {
  background-color: #f8d7da;
  color: #721c24;
  border: none;
}

.btn-cancel:hover {
  background-color: #f5c6cb;
}
</style>
