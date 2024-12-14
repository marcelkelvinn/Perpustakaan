<template>
  <div class="container mt-4">
    <h2 style="text-align: center; margin-bottom: 80px;">Daftar Denda</h2>
    <div class="box-container">
      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary btn-blue" style="width: 150px;" @click="openForm()">
          <img src="./icon tambah.png" style="height: 12px; margin-right:3px;">
          Tambah Denda
        </button>
        <input type="text" v-model="searchQuery" class="form-control mr-2" placeholder="Cari Denda..." @input="filterDenda" style="max-width: 300px;"/>
        <h4 style="float:right; margin:7px 10px 0px 0px">Search :</h4>
      </div>

      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>
      
      <table v-if="!isLoading" class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Hari</th>
            <th>Harga Denda</th>
            <th>Status Pembayaran</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(denda, index) in filteredDendas" :key="denda.id">
            <td>{{ index + 1 }}</td>
            <td>{{ denda.hari }}</td>
            <td>{{ denda.harga_denda }}</td>
            <td>{{ denda.status_pembayaran }}</td>
            <td>
              <button class="btn btn-warning btn-sm btn-green" @click="openForm(denda)" style="width: 70px; margin-right: 2px;">
                <img src="./icon edit.png" style="height: 20px;">
              </button>
              <button class="btn btn-danger btn-sm btn-red" @click="deleteDenda(denda.id)" style="width: 70px;">
                <img src="./icon delete.png" style="height: 20px;">
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <DendaForm v-if="showForm" :selectedDenda="selectedDenda" @close="closeForm" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import DendaForm from "./DendaForm.vue";

export default {
  name: "DendaList",
  components: { DendaForm },
  data() {
    return {
      dendas: [],
      filteredDendas: [],
      searchQuery: "",
      isLoading: false,
      errorMessage: "",
      showForm: false,
      selectedDenda: null,
    };
  },
  async created() {
    await this.fetchDendas();
  },
  methods: {
    getAxiosInstance() {
      const token = localStorage.getItem("auth_token");
      return axios.create({
        baseURL: "http://localhost:8000/api",
        headers: { Authorization: `Bearer ${token}` },
      });
    },
    async fetchDendas() {
      this.isLoading = true;
      this.errorMessage = "";

      try {
        const axiosInstance = this.getAxiosInstance();
        const response = await axiosInstance.get("/dendas");
        this.dendas = response.data;
        this.filteredDendas = this.dendas;
      } catch (error) {
        this.errorMessage = "Failed to fetch denda. Please try again later.";
      } finally {
        this.isLoading = false;
      }
    },
    filterDenda() {
      this.filteredDendas = this.dendas.filter(denda => 
        denda.hari.toString().includes(this.searchQuery) ||
        denda.harga_denda.toString().includes(this.searchQuery) ||
        denda.status_pembayaran.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    openForm(denda = null) {
      this.selectedDenda = denda;
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.fetchDendas();
    },
    async deleteDenda(id) {
      if (confirm("Apakah Anda yakin ingin menghapus denda ini?")) {
        this.isLoading = true;
        this.errorMessage = "";

        try {
          const axiosInstance = this.getAxiosInstance();
          await axiosInstance.delete(`/dendas/${id}`);
          alert("Denda berhasil dihapus");
          this.fetchDendas(); // Refresh the list after deletion
        } catch (error) {
          this.errorMessage = "Failed to delete denda. Please try again.";
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

/* Box container styling */
.box-container {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #f9f9f9;
}
</style>