<template>
  <div class="container mt-4">
    <h2>Daftar Sirkulasi</h2>
    <button class="btn btn-primary mb-3" @click="openForm()">Tambah Sirkulasi</button>
    <div v-if="loading" class="text-center">
      <p>Loading...</p>
    </div>
    <table v-if="!loading" class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama User</th>
          <th>Judul Buku</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(sirkulasi, index) in sirkulasis" :key="sirkulasi.id">
          <td>{{ index + 1 }}</td>
          <td>{{ sirkulasi.user?.name || 'Tidak ada' }}</td>
          <td>{{ sirkulasi.buku?.judul || 'Tidak ada' }}</td>
          <td>{{ sirkulasi.status }}</td>
          <td>
            <button class="btn btn-warning btn-sm" @click="openForm(sirkulasi)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteSirkulasi(sirkulasi.id)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
    <SirkulasiForm v-if="showForm" :selectedSirkulasi="selectedSirkulasi" @close="closeForm" />
  </div>
</template>

<script>
import axios from "axios";
import SirkulasiForm from "./SirkulasiForm.vue";

export default {
  name: "SirkulasiList",
  components: { SirkulasiForm },
  data() {
    return {
      sirkulasis: [],
      loading: true,
      showForm: false,
      selectedSirkulasi: null,
    };
  },
  async created() {
    await this.fetchSirkulasis();
  },
  methods: {
    async fetchSirkulasis() {
      this.loading = true;
      try {
        const response = await axios.get("http://localhost:8000/api/sirkulasi");
        this.sirkulasis = response.data;
      } catch (error) {
        console.error("Error fetching data:", error);
      } finally {
        this.loading = false;
      }
    },
    openForm(sirkulasi = null) {
      this.selectedSirkulasi = sirkulasi;
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.fetchSirkulasis();
    },
    async deleteSirkulasi(id) {
      if (confirm("Apakah Anda yakin ingin menghapus sirkulasi ini?")) {
        try {
          await axios.delete(`http://localhost:8000/api/sirkulasi/${id}`);
          alert("Sirkulasi berhasil dihapus");
          this.fetchSirkulasis();
        } catch (error) {
          console.error("Error deleting sirkulasi:", error);
        }
      }
    },
  },
};
</script>

<style>
/* Tambahkan styling jika diperlukan */
</style>
