<template>
  <div class="container mt-4">
    <h2 style="text-align: center; margin-bottom: 80px;">Daftar Buku</h2>
    <div class="box-container">
      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary btn-blue" @click="openForm()">
          <img src="../assets/icon tambah.png" style="height: 12px; margin-right:3px;">
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
            <th>#</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Kategori</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(buku, index) in filteredBukus" :key="buku.id">
            <td>{{ index + 1 }}</td>
            <td>{{ buku.judul }}</td>
            <td>{{ buku.pengarang?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.penerbit?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.kategori?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.tahun_terbit }}</td>
            <td>
              <button class="btn btn-warning btn-sm btn-green" @click="openForm(buku)">
                <img src="../assets/icon edit.png" style="height: 20px;">
              </button>
              <button class="btn btn-danger btn-sm btn-red" @click="deleteBuku(buku.id)">
                <img src="../assets/icon delete.png" style="height: 20px;">
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
      loading: true,
      showForm: false,
      selectedBuku: null,
      searchQuery: "", // Added to track search query
      filteredBukus: [], // Added for filtered books
    };
  },
  async created() {
    await this.fetchBukus();
  },
  methods: {
    async fetchBukus() {
      this.loading = true;
      try {
        const response = await axios.get("http://localhost:8000/api/buku");
        this.bukus = response.data;
        this.filteredBukus = this.bukus; // Initialize with all bukus
      } catch (error) {
        console.error("Error fetching data:", error);
      } finally {
        this.loading = false;
      }
    },
    filterBuku() {
      // Filter books based on the search query
      this.filteredBukus = this.bukus.filter(buku => 
        buku.judul.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (buku.pengarang?.nama || '').toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (buku.penerbit?.nama || '').toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (buku.kategori?.nama || '').toLowerCase().includes(this.searchQuery.toLowerCase()) ||
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
        try {
          await axios.delete(`http://localhost:8000/api/buku/${id}`);
          alert("Buku berhasil dihapus");
          this.fetchBukus();
        } catch (error) {
          console.error("Error deleting buku:", error);
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
  background-color: #ff1d1d;
}

.btn-green {
  background-color: #7cd653;
}

.btn-red:hover {
  background-color: #a81616;
}

.btn-blue:hover {
  background-color: #126b9b;
}

.btn-green:hover {
  background-color: #29c015;
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
