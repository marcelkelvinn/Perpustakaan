<template>
  <div class="container mt-4">
    <h2 style="text-align: center; margin-bottom: 80px;">Daftar Sirkulasi</h2>
    <div class="box-container">
      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary btn-blue" style="width: 175px;" @click="openForm()">
          <img src="./icon tambah.png" style="height: 12px; margin-right:3px;">
          Tambah Sirkulasi
          </button>
        <input type="text" v-model="searchQuery" class="form-control mr-2" placeholder="Cari Sirkulasi..." @input="filterSirkulasi" style="max-width: 300px;" />
        <h4 style="float:right; margin:7px 10px 0px 0px;">Search:</h4>
      </div>

      <div v-if="loading" class="text-center">
        <p>Loading...</p>
      </div>
      
      <table v-if="!loading" class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(sirkulasi, index) in filteredSirkulasi" :key="sirkulasi.id">
            <td>{{ index + 1 }}</td>
            <td>{{ sirkulasi.buku?.judul || 'Tidak ada' }}</td>
            <td>{{ sirkulasi.user?.name || 'Tidak ada' }}</td>
            <td>{{ sirkulasi.tgl_pinjam }}</td>
            <td>{{ sirkulasi.tgl_kembali || 'Belum kembali' }}</td>
            <td>{{ sirkulasi.tgl_pengembalian || 'Belum kembali' }}</td>
            <td>{{ sirkulasi.status }}</td>
            <td>
              <button class="btn btn-warning btn-sm btn-green" @click="openForm(sirkulasi)" style="width: 70px; margin-right: 2px; margin-bottom: 3px;">
                <img src="./icon edit.png" style="height: 20px;">
              </button>
              <button class="btn btn-danger btn-sm btn-red" @click="deleteSirkulasi(sirkulasi.id)" style="width: 70px;">
                <img src="./icon delete.png" style="height: 20px;">
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <SirkulasiForm v-if="showForm" :selectedSirkulasi="selectedSirkulasi" @close="closeForm" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import SirkulasiForm from "./SirkulasiForm.vue";

export default {
  name: "Sirkulasi",
  components: { SirkulasiForm },
  data() {
    return {
      sirkulasi: [],
      filteredSirkulasi: [],
      searchQuery: "",
      loading: false,
      errorMessage: "",
      showForm: false,
      selectedSirkulasi: null,
    };
  },
  async created() {
    await this.fetchSirkulasi();
  },
  methods: {
    getAxiosInstance() {
      const token = localStorage.getItem("auth_token");
      return axios.create({
        baseURL: "http://localhost:8000/api",
        headers: { Authorization: `Bearer ${token}` },
      });
    },
    async fetchSirkulasi() {
      this.loading = true;
      try {
        const axiosInstance = this.getAxiosInstance();
        const response = await axiosInstance.get("/sirkulasi");
        this.sirkulasi = response.data;
        this.filteredSirkulasi = this.sirkulasi;
      } catch {
        this.errorMessage = "Failed to fetch data.";
      } finally {
        this.loading = false;
      }
    },
    filterSirkulasi() {
      this.filteredSirkulasi = this.sirkulasi.filter(item =>
        item.buku?.judul.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        item.user?.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        item.tgl_pinjam.includes(this.searchQuery) ||
        (item.tgl_kembali && item.tgl_kembali.includes(this.searchQuery)) ||
        (item.tgl_pengembalian && item.tgl_pengembalian.includes(this.searchQuery))
      );
    },
    openForm(sirkulasi = null) {
      this.selectedSirkulasi = sirkulasi;
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.fetchSirkulasi();
    },
    async deleteSirkulasi(id) {
      if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        try {
          const axiosInstance = this.getAxiosInstance();
          await axiosInstance.delete(`/sirkulasi/${id}`);
          alert("Data berhasil dihapus");
          this.fetchSirkulasi();
        } catch {
          alert("Gagal menghapus data.");
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
