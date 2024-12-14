<template>
  <div class="container mt-4">
    <h2 style="text-align: center; margin-bottom: 80px;">Daftar Buku</h2>
    <div class="box-container">
      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary btn-blue" style="width: 150px;" @click="openForm()">
          <img src="./icon tambah.png" style="height: 12px; margin-right:3px;">
          Tambah Buku
          </button>
        <input type="text" v-model="searchQuery" class="form-control mr-2" placeholder="Cari Buku..." @input="filterBuku" style="max-width: 300px;"/>
        <h4 style="float:right; margin:7px 10px 0px 0px" >Search :</h4>
      </div>

      <div v-if="loading" class="text-center">
        <p>Loading...</p>
      </div>
      
      <table v-if="!loading" class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Kategori</th>
            <th>Tahun Terbit</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(buku, index) in filteredBukus" :key="buku.id">
            <td>{{ index + 1 }}</td>
            <td>{{ buku.judul }}</td>
            <td>{{ buku.pengarang?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.penerbit?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.kategori?.kategori || 'Tidak ada' }}</td>
            <td>{{ buku.tahun_terbit }}</td>
            <td>
              <button class="btn btn-warning btn-sm btn-green" @click="openForm(buku)" style="width: 70px; margin-right: 2px;">
                <img src="./icon edit.png" style="height: 20px;">
              </button>
              <button class="btn btn-danger btn-sm btn-red" @click="deleteBuku(buku.id)" style="width: 70px;">
                <img src="./icon delete.png" style="height: 20px;">
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <BukuForm v-if="showForm" :selectedBuku="selectedBuku" @close="closeForm" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import BukuForm from "./BukuForm.vue";

export default {
  name: "BukuList",
  components: { BukuForm },
  data() {
    return {
      bukus: [],
      filteredBukus: [],
      searchQuery: "",
      isLoading: false,
      errorMessage: "",
      showForm: false,
      selectedBuku: null,
    };
  },
  async created() {
    await this.fetchBukus();
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
    async fetchBukus() {
      this.isLoading = true;
      this.errorMessage = "";

      try {
        const axiosInstance = this.getAxiosInstance();
        const response = await axiosInstance.get("/buku");
        this.bukus = response.data;
        this.filteredBukus = this.bukus;
      } catch (error) {
        this.errorMessage = "Failed to fetch books. Please try again later.";
      } finally {
        this.isLoading = false;
      }
    },
    filterBuku() {
      this.filteredBukus = this.bukus.filter(buku => 
        buku.judul.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (buku.pengarang?.nama || "").toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (buku.penerbit?.nama || "").toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (buku.kategori?.nama || "").toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        buku.tahun_terbit.toString().includes(this.searchQuery)
      );
    },
    openForm(buku = null) {
      this.selectedBuku = buku;
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.fetchBukus();
    },
    async deleteBuku(id) {
      if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
        this.isLoading = true;
        this.errorMessage = "";

        try {
          const axiosInstance = this.getAxiosInstance();
          await axiosInstance.delete(`/buku/${id}`);
          alert("Buku berhasil dihapus");
          this.fetchBukus();
        } catch (error) {
          this.errorMessage = "Failed to delete book. Please try again.";
        } finally {
          this.isLoading = false;
        }
      }
    },
  },
};
</script>

<style scoped>
.text-primary {
  color: #000000;
}

.table {
  margin-top: 1rem;
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
  text-align: center;
  padding: 1rem;
}

.table th {
  background-color: #343a40;
  color: #fff;
}

.table-striped tbody tr:nth-child(odd) {
  background-color: #f8f9fa;
}

.btn {
  font-size: 0.9rem;
  transition: background-color 0.3s ease;
  color: #f9f9f9;
}

.btn-blue {
  background-color: #4682B4;
}

.btn-red {
  background-color: #cb442c;
}

.btn-green {
  background-color: #42ac50;
}

.btn-red:hover {
  background-color: #a53926;
}

.btn-blue:hover {
  background-color: #126b9b;
}

.btn-green:hover {
  background-color: #399045;
}

/* Search field styling */
input.form-control {
  width: 100%;
  padding: 10px;
  font-size: 1rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  float:right;
}

/* Box container styling */
.box-container {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #f9f9f9;
}
</style>
