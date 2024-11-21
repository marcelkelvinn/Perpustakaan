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
      };
    },
    created() {
      if (this.selectedBuku) {
        this.buku = { ...this.selectedBuku };
      }
    },
    methods: {
      async submitForm() {
        try {
          if (this.selectedBuku) {
            await axios.put(`http://localhost:8000/api/buku/${this.buku.id}`, this.buku);
            alert("Buku berhasil diperbarui");
          } else {
            await axios.post("http://localhost:8000/api/buku", this.buku);
            alert("Buku berhasil ditambahkan");
          }
          this.$emit("close");
        } catch (error) {
          console.error("Error saving buku:", error);
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
  