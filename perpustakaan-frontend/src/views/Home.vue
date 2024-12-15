<template>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="profile-image"></div>
                <p class="username">{{ user.name }}</p>
                <span class="role">{{ user.role }}</span>
            </div>
            <nav class="navigation">
                <ul>
                    <li @click="goToDashboard">Dashboard</li>
                    <li @click="goToDataAnggota">Data Anggota</li>
                    <li @click="goToDataBuku">Data Buku</li>
                    <li @click="goToPeminjaman">Peminjaman</li>
                    <li @click="goToDenda">Denda</li>
                    <li @click="goToSirkulasi">Sirkulasi</li>
                </ul>
            </nav>
            <div class="setting-logout">
                <button @click="logout">Log Out</button>
            </div>
        </aside>

        <!-- Content -->
        <main class="content">
            <h1>Dashboard Administrator</h1>
            <div class="cards-container">
                <div class="card" @click="goToDataAnggota">Anggota</div>
                <div class="card" @click="goToDataBuku">Buku</div>
                <div class="card" @click="goToPeminjaman">Peminjaman</div>
                <div class="card" @click="goToDenda">Denda</div>
                <div class="card" @click="goToSirkulasi">Sirkulasi</div>
            </div>
        </main>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Dashboard',
    data() {
        return {
            user: {
                name: 'Loading...',
                role: 'Loading...',
            },
        };
    },
    created() {
        this.fetchUserData();
    },
    methods: {
        async fetchUserData() {
            try {
                const token = localStorage.getItem('auth_token');
                if (token) {
                    const response = await axios.get('http://localhost:8000/api/user', {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                    this.user = response.data;
                } else {
                    this.$router.push('/login');
                }
            } catch (error) {
                console.error('Failed to fetch user data:', error);
                this.$router.push('/login');
            }
        },
        goToDashboard() {
            this.$router.push('/');
        },
        goToDataBuku() {
            this.$router.push('/buku');
        },
        goToDataAnggota() {
            this.$router.push('/profile');
        },
        goToPeminjaman() {
            this.$router.push('/peminjaman');
        },
        goToDenda() {
            this.$router.push('/denda');
        },
        goToSirkulasi() {
            this.$router.push('/sirkulasi');
        },
        async logout() {
            try {
                const token = localStorage.getItem('auth_token');
                if (token) {
                    await axios.post('http://localhost:8000/api/logout', {}, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                    localStorage.removeItem('auth_token');
                    this.$router.push('/login');
                }
            } catch (error) {
                console.error('Logout failed:', error);
            }
        },
    },
};
</script>

<style scoped>
.dashboard-container {
    display: flex;
    height: 100vh;
    font-family: Arial, sans-serif;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background-color: #5c5c5c;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
}

.profile-section {
    text-align: center;
}

.profile-image {
    width: 60px;
    height: 60px;
    background-color: #ccc;
    border-radius: 50%;
    margin: 0 auto 10px;
}

.username {
    font-weight: bold;
    margin: 0;
}

.role {
    font-size: 12px;
    color: #aaa;
}

.navigation ul {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.navigation li {
    margin: 10px 0;
    cursor: pointer;
    transition: background 0.3s;
    padding: 8px;
}

.navigation li:hover {
    background-color: #444;
}

.setting-logout button {
    margin: 5px 0;
    width: 100%;
    padding: 8px;
    cursor: pointer;
    background-color: #ff4d4d;
    color: #ffffff;
    border: none;
    border-radius: 3px;
    transition: background 0.3s;
}

.setting-logout button:hover {
    background-color: #cc0000;
}


/* Content */
.content {
    flex-grow: 1;
    padding: 30px;
    background-color: #f5f5f5;
}

h1 {
    margin-bottom: 30px;
}

.cards-container {
    display: flex;
    gap: 20px;
}

.card {
    flex: 1;
    padding: 40px;
    background-color: #ddd;
    text-align: center;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}

.card:hover {
    background-color: #bbb;
    transform: scale(1.05);
}
</style>