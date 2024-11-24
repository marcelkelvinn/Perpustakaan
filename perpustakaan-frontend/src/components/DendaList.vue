<template>
  <div class="container mt-4">
    <h2>Daftar Denda</h2>
    <button class="btn btn-primary mb-3" @click="openForm()">Tambah Denda</button>
    <div v-if="loading" class="text-center">
      <p>Loading...</p>
    </div>
    <table v-if="!loading" class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Peminjam</th> <!-- Kolom peminjam ditempatkan di sini -->
          <th>Hari</th>
          <th>Harga Denda</th>
          <th>Status Pembayaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(denda, index) in dendas" :key="denda.id">
          <td>{{ index + 1 }}</td>
          <td>{{ denda.peminjam?.nama || 'Tidak ada' }}</td> <!-- Menampilkan nama peminjam -->
          <td>{{ denda.hari }}</td>
          <td>{{ denda.harga_denda }}</td>
          <td>{{ denda.status_pembayaran }}</td>
          <td>
            <button class="btn btn-warning btn-sm" @click="openForm(denda)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteDenda(denda.id)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
    <DendaForm v-if="showForm" :selectedDenda="selectedDenda" @close="closeForm" />
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
      loading: true,
      showForm: false,
      selectedDenda: null,
    };
  },
  async created() {
    await this.fetchDendas();
  },
  methods: {
    async fetchDendas() {
      this.loading = true;
      try {
        const response = await axios.get("http://localhost:8000/api/denda");
        this.dendas = response.data;
      } catch (error) {
        console.error("Error fetching data:", error);
      } finally {
        this.loading = false;
      }
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
        try {
          await axios.delete(`http://localhost:8000/api/denda/${id}`);
          alert("Denda berhasil dihapus");
          this.fetchDendas();
        } catch (error) {
          console.error("Error deleting denda:", error);
        }
      }
    },
  },
};
</script>

<style>
/* Tambahkan styling jika diperlukan */
</style>
