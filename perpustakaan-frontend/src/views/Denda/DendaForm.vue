DendaForm.vue
<template>
  <div class="modal-overlay">
    <div class="modal-content">
      <h3>{{ selectedDenda ? "Edit Denda" : "Tambah Denda" }}</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>ID User</label>
          <input type="number" v-model="denda.id_user" class="form-control" required min="0" />
        </div>
        <div class="form-group">
          <label>Hari</label>
          <input type="number" v-model="denda.hari" class="form-control" required min="0" />
        </div>
        <div class="form-group">
          <label>Harga Denda</label>
          <input type="number" v-model="denda.harga_denda" class="form-control" required min="0" />
        </div>
        <div class="form-group">
          <label>Status Pembayaran</label>
          <select v-model="denda.status_pembayaran" class="form-control" required>
            <option value="sudah dibayar">Sudah Dibayar</option>
            <option value="belum dibayar">Belum Dibayar</option>
          </select>
        </div>
        <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
        <div class="form-group mt-4">
          <button type="submit" class="btn btn-primary btn-submit" :disabled="isLoading">Simpan</button>
          <button type="button" class="btn btn-secondary btn-cancel" style="float: right;" @click="$emit('close')">Batal</button>
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
        id_user: "",
        hari: "",
        harga_denda: "",
        status_pembayaran: "belum dibayar", // Default value
      },
      isLoading: false,
      errorMessage: "",
    };
  },
  created() {
    if (this.selectedDenda) {
      this.denda = { ...this.selectedDenda };
    }
  },
  methods: {
    async submitForm() {
      this.isLoading = true;
      this.errorMessage = "";

      try {
        if (this.selectedDenda) {
          await axios.put("/dendas/${this.denda.id}", this.denda);
          alert("Denda berhasil diperbarui");
        } else {
          await axios.post("http://localhost:8000/api/dendas", this.denda);
          alert("Denda berhasil ditambahkan");
        }
        this.$emit("close");
      } catch (error) {
        if (error.response && error.response.data) {
          this.errorMessage = error.response.data.message || "Gagal menyimpan denda. Silakan periksa input Anda.";
        } else {
          this.errorMessage = "Gagal menyimpan denda. Silakan periksa input Anda.";
        }
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #ffffff;
  padding: 30px;
  border-radius: 20px;
  width: 450px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h3 {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
}

input,
select {
  width: 100%;
  padding: 10px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
  transition: all 0.3s ease;
}

input:focus,
select:focus {
  border-color: #007bff;
  outline: none;
}

button {
  width: 48%;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  border: none;
}

.btn-primary:disabled {
  background-color: #007bff;
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
  border: none;
}

.btn-secondary:hover {
  background-color: #5a6268;
}
</style>