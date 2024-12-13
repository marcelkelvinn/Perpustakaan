<template>
    <div class="container mt-4">
        <div class="search-bar mb-4">
            <input type="text" v-model="searchQuery" class="form-control" placeholder="Cari Judul / Kategori Buku"
                @input="filterBuku" />
        </div>

        <h5 class="search-result-title">Hasil Pencarian :</h5>
        <div v-if="loading" class="text-center">
            <p>Loading...</p>
        </div>

        <div v-else>
            <div v-if="filteredBukus.length === 0" class="text-center">
                <p>Data buku tidak ditemukan.</p>
            </div>

            <div class="book-list">
                <div v-for="(buku, index) in filteredBukus" :key="buku.id" class="book-card">
                    <div class="book-image">
                        <img :src="buku.cover || 'default-cover.png'" alt="Cover Buku" />
                    </div>
                    <div class="book-details">
                        <h3 class="book-title">{{ buku.judul }}</h3>
                        <p class="book-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.
                        </p>
                        <div class="book-rating">
                            <span v-for="n in 5" :key="n" class="star" :class="{ 'active': n <= 4 }">★</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "BukuDisplay",
    data() {
        return {
            bukus: [],
            loading: true,
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
                (buku.kategori?.nama || '').toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
    },
};
</script>

<style scoped>
.container {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.search-bar input {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-bottom: 20px;
}

.search-result-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

.book-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.book-card {
    display: flex;
    align-items: flex-start;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
    background-color: #fff;
}

.book-card:hover {
    transform: translateY(-5px);
}

.book-image img {
    height: 150px;
    width: auto;
    border-radius: 8px;
    margin-right: 20px;
}

.book-details {
    flex: 1;
}

.book-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #444;
}

.book-description {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 10px;
}

.book-rating {
    font-size: 1.2rem;
    color: #ffc107;
    margin-bottom: 10px;
}

.star {
    color: #ddd;
}

.star.active {
    color: #ffc107;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}
</style>