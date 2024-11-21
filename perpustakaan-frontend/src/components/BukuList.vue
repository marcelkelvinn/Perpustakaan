<template>
    <div class="container mt-4">
      <h2>Daftar Buku</h2>
      <button class="btn btn-primary mb-3" @click="openForm()">Tambah Buku</button>
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
          <tr v-for="(buku, index) in bukus" :key="buku.id">
            <td>{{ index + 1 }}</td>
            <td>{{ buku.judul }}</td>
            <td>{{ buku.pengarang?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.penerbit?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.kategori?.nama || 'Tidak ada' }}</td>
            <td>{{ buku.tahun_terbit }}</td>
            <td>
              <button class="btn btn-warning btn-sm" @click="openForm(buku)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deleteBuku(buku.id)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
      <BukuForm v-if="showForm" :selectedBuku="selectedBuku" @close="closeForm" />
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
        } catch (error) {
          console.error("Error fetching data:", error);
        } finally {
          this.loading = false;
        }
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
  
  <style>
  /* Tambahkan styling jika diperlukan */
  </style>
  