<template>
  <div class="container mt-4">
    <h2>Daftar Peminjaman</h2>
    <button class="btn btn-primary mb-3" @click="openForm()">Tambah Peminjaman</button>
    <div v-if="loading" class="text-center">
      <p>Loading...</p>
    </div>
    <table v-if="!loading" class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Peminjam</th>
          <th>Judul Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(peminjaman, index) in peminjamans" :key="peminjaman.id">
          <td>{{ index + 1 }}</td>
          <td>{{ peminjaman.user?.name || "Tidak ada" }}</td>
          <td>{{ peminjaman.buku?.judul || "Tidak ada" }}</td>
          <td>{{ peminjaman.tgl_pinjam }}</td>
          <td>
            <button class="btn btn-warning btn-sm" @click="openForm(peminjaman)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deletePeminjaman(peminjaman.id)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
    <PeminjamanForm v-if="showForm" :selectedPeminjaman="selectedPeminjaman" @close="closeForm" />
  </div>
</template>

<script>
import axios from "axios";
import PeminjamanForm from "./PeminjamanForm.vue";

export default {
  name: "PeminjamanList",
  components: { PeminjamanForm },
  data() {
    return {
      peminjamans: [],
      loading: true,
      showForm: false,
      selectedPeminjaman: null,
    };
  },
  async created() {
    await this.fetchPeminjamans();
  },
  methods: {
    async fetchPeminjamans() {
      this.loading = true;
      try {
        const response = await axios.get("http://localhost:8000/api/peminjaman");
        this.peminjamans = response.data;
      } catch (error) {
        console.error("Error fetching data:", error);
      } finally {
        this.loading = false;
      }
    },
    openForm(peminjaman = null) {
      this.selectedPeminjaman = peminjaman;
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.fetchPeminjamans();
    },
    async deletePeminjaman(id) {
      if (confirm("Apakah Anda yakin ingin menghapus peminjaman ini?")) {
        try {
          await axios.delete(`http://localhost:8000/api/peminjaman/${id}`);
          alert("Peminjaman berhasil dihapus");
          this.fetchPeminjamans();
        } catch (error) {
          console.error("Error deleting peminjaman:", error);
        }
      }
    },
  },
};
</script>

<style>
/* Tambahkan styling jika diperlukan */
</style>
