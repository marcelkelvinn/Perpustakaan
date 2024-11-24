<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <h3>{{ selectedDenda ? "Edit Denda" : "Tambah Denda" }}</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>Peminjam</label>
          <select v-model="denda.peminjam_id" class="form-control" required>
            <option v-for="peminjam in peminjamList" :key="peminjam.id" :value="peminjam.id">
              {{ peminjam.nama }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label>Hari</label>
          <input type="number" v-model="denda.hari" class="form-control" required />
        </div>
        <div class="form-group">
          <label>Harga Denda</label>
          <input type="number" v-model="denda.harga_denda" class="form-control" required />
        </div>
        <div class="form-group">
          <label>Status Pembayaran</label>
          <select v-model="denda.status_pembayaran" class="form-control" required>
            <option value="sudah dibayar">Sudah Dibayar</option>
            <option value="belum dibayar">Belum Dibayar</option>
          </select>
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
  name: "DendaForm",
  props: ["selectedDenda"],
  data() {
    return {
      denda: {
        hari: "",
        harga_denda: "",
        status_pembayaran: "belum dibayar",
        peminjam_id: null,
      },
      peminjamList: [],  // Daftar peminjam
    };
  },
  async created() {
    await this.fetchPeminjam();
    if (this.selectedDenda) {
      this.denda = { ...this.selectedDenda };
    }
  },
  methods: {
    async fetchPeminjam() {
      try {
        const response = await axios.get("http://localhost:8000/api/peminjam");
        this.peminjamList = response.data;
      } catch (error) {
        console.error("Error fetching peminjam data:", error);
      }
    },
    async submitForm() {
      try {
        if (this.selectedDenda) {
          await axios.put(`http://localhost:8000/api/denda/${this.denda.id}`, this.denda);
          alert("Denda berhasil diperbarui");
        } else {
          await axios.post("http://localhost:8000/api/denda", this.denda);
          alert("Denda berhasil ditambahkan");
        }
        this.$emit("close");
      } catch (error) {
        console.error("Error saving denda:", error);
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
