<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

// Set baseURL sesuai API Laravel Anda
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

// ==========================================
// STATE MANAGEMENT
// ==========================================
const categories = ref([])
const featuredProducts = ref([])
const latestProducts = ref([])
const cartCount = ref(0)
const isLoggedIn = ref(false)
const isAdmin = ref(false) // <-- State baru untuk status admin

// Penentu arah link tombol ikon User secara dinamis
const accountLink = computed(() => {
  if (isAdmin.value) return '/admin'
  return isLoggedIn.value ? '/user' : '/login'
})

// ==========================================
// FETCH API DATA
// ==========================================
const fetchHomeData = async () => {
  try {
    // 1. Ambil Kategori Publik
    const catRes = await axios.get('/public/kategori')
    categories.value = catRes.data.data || catRes.data

    // 2. Ambil Produk Publik
    const prodRes = await axios.get('/public/produk')
    const products = prodRes.data.data || prodRes.data

    // Membagi produk (4 untuk unggulan, 4 berikutnya untuk terbaru)
    featuredProducts.value = products.slice(0, 4)
    latestProducts.value = products.slice(4, 8)

    // 3. Cek Status Login, Role Admin, & Cart via Token
    const token = localStorage.getItem('token')
    if (token) {
      isLoggedIn.value = true
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

      // Opsional: Jika backend Anda memiliki endpoint profil untuk cek role (contoh: /user atau /auth/me)
      try {
        const userRes = await axios.get('/user') // Sesuaikan endpoint user/profil di Laravel Anda
        const userData = userRes.data.data || userRes.data
        
        // Sesuaikan kondisi ini dengan field role dari database Anda (misal: role === 'admin' atau is_admin === 1)
        if (userData.role === 'admin' || userData.is_admin === 1) {
          isAdmin.value = true
        }
      } catch (err) {
        // Fallback darurat jika endpoint /user belum ada: 
        // Anda bisa menyetel manual / mendeteksi email admin tertentu di sini
        console.log('Gagal memuat profil, menggunakan cek token dasar.')
      }

      // Ambil data keranjang
      const cartRes = await axios.get('/cart').catch(() => ({ data: [] }))
      const cartItems = cartRes.data.data || cartRes.data
      
      cartCount.value = Array.isArray(cartItems) 
        ? cartItems.reduce((acc, item) => acc + (item.quantity || 1), 0) 
        : 0
    }
  } catch (error) {
    console.error('Gagal memuat data dari API Laravel:', error)
  }
}

onMounted(() => {
  fetchHomeData()
})
</script>

<template>
  <div class="street-container">

    <!-- =====================================
         NAVIGATION BAR
    ====================================== -->
    <header class="street-navbar-wrapper">
      <nav class="street-navbar">
        <div class="nav-left">
          <router-link to="/shop" class="nav-link">SHOP</router-link>
          <router-link to="/about" class="nav-link">OUR MISSION</router-link>
          
          <!-- Tombol khusus Admin yang hanya muncul jika role-nya admin -->
          <!-- Tombol Admin Panel -->
          <router-link to="/admin" class="btn-admin-panel" title="Masuk ke Admin Panel">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            <span>Admin Panel</span>
          </router-link>
        </div>

        <div class="nav-center">
          <router-link to="/home" class="brand-logo">PROVIDENTIAL</router-link>
        </div>

        <div class="nav-right">
          <router-link to="/search" class="icon-btn" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.3-4.3"/>
            </svg>
          </router-link>

          <router-link to="/cart" class="icon-btn cart-btn" aria-label="Cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
              <path d="M3 6h18"/>
              <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <span v-if="cartCount > 0" class="cart-badge">{{ cartCount }}</span>
          </router-link>

          <!-- Jika admin, ikon ini otomatis mengarah ke /admin. Jika customer ke /profile, jika belum login ke /login -->
          <router-link :to="accountLink" class="icon-btn" :title="isAdmin ? 'Panel Admin' : 'Akun Saya'" aria-label="Account">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </router-link>
        </div>
      </nav>
    </header>


    <!-- =====================================
         HERO SECTION
    ====================================== -->
    <section class="hero-section">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <span class="hero-badge">STREETWEAR & TERRACE CULTURE</span>
        <h1 class="hero-title">RAW ATTITUDE.<br><span>TIMELESS GRIT.</span></h1>
        <p class="hero-subtitle">Terinspirasi dari kultur sub-kultur tribun stadion, streetwear urban modern, dan ketahanan identitas jalanan.</p>
        <div class="hero-actions">
          <router-link to="/shop" class="btn-primary">EXPLORE DROP</router-link>
          <router-link to="/about" class="btn-outline">THE MANIFESTO</router-link>
        </div>
      </div>
    </section>


    <!-- =====================================
         CATEGORY SECTION
    ====================================== -->
    <section class="section-container ">
      <div class="section-header">
        <span class="sub-heading">ARCHIVES</span>
        <h2>Shop By Category</h2>
      </div>

      <div class="category-grid">
        <router-link
          v-for="category in categories"
          :key="category.id || category.name"
          to="/shop"
          class="category-card"
        >
          <div class="category-img-wrap">
            <img :src="category.image || 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop'" :alt="category.name" />
            <div class="category-overlay-box">
              <span>VIEW LINEUP</span>
            </div>
          </div>
          <div class="category-details">
            <h3>{{ category.name }}</h3>
            <p>{{ category.description || 'Core essentials & limited release' }}</p>
          </div>
        </router-link>
      </div>
    </section>


    <!-- =====================================
         FEATURED PRODUCTS
    ====================================== -->
    <section class="section-container">
      <div class="section-header-flex">
        <div>
          <span class="sub-heading">FEATURED DROP</span>
          <h2>Featured Gear</h2>
        </div>
        <router-link to="/shop" class="view-all-link">VIEW ALL &rarr;</router-link>
      </div>

      <div class="product-grid">
        <div v-for="product in featuredProducts" :key="product.id" class="product-card">
          <div class="product-img-wrap">
            <img :src="product.image || 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=600&auto=format&fit=crop'" :alt="product.name" />
            <div class="product-badge-tag">NEW DROP</div>
          </div>
          <div class="product-info">
            <h4>{{ product.name }}</h4>
            <span class="product-price">Rp {{ Number(product.price).toLocaleString('id-ID') }}</span>
          </div>
        </div>
      </div>
    </section>


    <!-- =====================================
         PROMO & MEMBERSHIP BANNER
    ====================================== -->
    <section class="section-container promo-container">
      <div class="promo-grid">
        
        <div class="promo-card dark-card">
          <span class="badge-pill bg-neon">LIMITED CODE</span>
          <h3>USE CODE <span class="highlight">STREET20</span></h3>
          <p>Potongan harga eksklusif 20% untuk semua item streetwear & terrace culture pilihan.</p>
          <router-link to="/shop" class="btn-white">CLAIM VOUCHER</router-link>
        </div>

        <div class="promo-card grey-card">
          <template v-if="!isLoggedIn">
            <span class="badge-pill bg-dark">JOIN THE CREW</span>
            <h3>UNLOCK PERKS & REWARDS</h3>
            <p>Daftarkan diri Anda sekarang dan dapatkan potongan instan untuk pembelian pertama.</p>
            <router-link to="/register" class="btn-dark">SIGN UP FREE</router-link>
          </template>
          <template v-else>
            <span class="badge-pill bg-dark">MEMBER DASHBOARD</span>
            <h3>WELCOME BACK, CREW</h3>
            <p>Akses riwayat transaksi Anda atau cek update pesanan terbaru melalui profil.</p>
            <router-link to="/pesanan" class="btn-dark">VIEW ORDERS</router-link>
          </template>
        </div>

      </div>
    </section>


    <!-- =====================================
         LATEST PRODUCTS
    ====================================== -->
    <section class="section-container">
      <div class="section-header-flex">
        <div>
          <span class="sub-heading">FRESH ARRIVALS</span>
          <h2>Latest Releases</h2>
        </div>
        <router-link to="/shop" class="view-all-link">VIEW ALL &rarr;</router-link>
      </div>

      <div class="product-grid">
        <div v-for="product in latestProducts" :key="product.id" class="product-card">
          <div class="product-img-wrap">
            <img :src="product.image || 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?q=80&w=600&auto=format&fit=crop'" :alt="product.name" />
          </div>
          <div class="product-info">
            <h4>{{ product.name }}</h4>
            <span class="product-price">Rp {{ Number(product.price).toLocaleString('id-ID') }}</span>
          </div>
        </div>
      </div>
    </section>


    <!-- =====================================
         FLOATING SUPPORT BUTTON
    ====================================== -->
    <button class="support-float-btn" aria-label="Customer Support">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
      <span>SUPPORT</span>
    </button>

  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Syne:wght@700;800&display=swap');

/* =========================================
   GLOBAL THEME (WARNA AWAL / KREM KLASIK)
   ========================================= */
.street-container {
  font-family: 'Space Grotesk', sans-serif;
  background-color: #ffffff;
  color: #17243a;
  min-height: 100vh;
  overflow-x: hidden;
}

/* ================= NAVBAR ================= */
.street-navbar-wrapper {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid #eae3dc;
}

.street-navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1440px;
  margin: 0 auto;
  padding: 1.5rem 3rem;
}

.nav-left, .nav-right {
  display: flex;
  align-items: center;
  gap: 2.5rem;
}

.nav-link {
  color: #5c677d;
  text-decoration: none;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 2px;
  transition: color 0.2s ease;
}
.nav-link:hover { color: #17243a; }

.nav-center {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.brand-logo {
  font-family: 'Syne', sans-serif;
  font-size: 1.5rem;
  font-weight: 800;
  letter-spacing: 5px;
  color: #17243a;
  text-decoration: none;
}

.icon-btn {
  position: relative;
  background: none;
  border: none;
  color: #17243a;
  cursor: pointer;
  padding: 0;
  transition: opacity 0.2s ease;
}
.icon-btn:hover { opacity: 0.6; }

.cart-badge {
  position: absolute;
  top: -6px;
  right: -8px;
  background: #17243a;
  color: #ffffff;
  font-size: 9px;
  font-weight: 800;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ================= HERO SECTION ================= */
.hero-section {
  position: relative;
  height: 85vh;
  display: flex;
  align-items: center;
  background: url('https://images.unsplash.com/photo-1555529771-835f59fc5efe?q=80&w=2000&auto=format&fit=crop') center/cover no-repeat;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(100deg, rgba(255, 250, 242, 0.96) 0%, rgba(255, 250, 242, 0.88) 40%, rgba(255, 250, 242, 0.4) 70%, rgba(255, 250, 242, 0.15) 100%);
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 3rem;
  width: 100%;
}

.hero-badge {
  display: inline-block;
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 3px;
  color: #5c677d;
  margin-bottom: 1.2rem;
  text-transform: uppercase;
}

.hero-title {
  font-family: 'Syne', sans-serif;
  font-size: 4rem;
  font-weight: 800;
  line-height: 1.05;
  margin: 0 0 1.5rem 0;
  color: #17243a;
}

.hero-title span {
  color: #717784;
}

.hero-subtitle {
  max-width: 500px;
  color: #4a5568;
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 2.5rem;
}

.hero-actions {
  display: flex;
  gap: 1rem;
}

.btn-primary {
  background: #17243a;
  color: #ffffff;
  padding: 1rem 2.2rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 2px;
  text-decoration: none;
  border-radius: 2px;
  transition: background 0.2s ease;
}
.btn-primary:hover { background: #27364e; }

.btn-outline {
  background: transparent;
  color: #17243a;
  border: 1px solid rgba(23, 36, 58, 0.3);
  padding: 1rem 2rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 2px;
  text-decoration: none;
  border-radius: 2px;
  transition: border-color 0.2s ease;
}
.btn-outline:hover { border-color: #17243a; }

/* ================= SECTION COMMON ================= */
.section-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 5rem 3rem;
}

.section-header {
  margin-bottom: 3rem;
}

.sub-heading {
  font-size: 0.65rem;
  font-weight: 700;
  letter-spacing: 3px;
  color: #717784;
  display: block;
  margin-bottom: 0.5rem;
}

.section-header h2, .section-header-flex h2 {
  font-family: 'Syne', sans-serif;
  font-size: 2.2rem;
  font-weight: 700;
  color: #17243a;
  margin: 0;
}

.section-header-flex {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 3rem;
  border-bottom: 1px solid #eae3dc;
  padding-bottom: 1rem;
}

.view-all-link {
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 2px;
  color: #17243a;
  text-decoration: none;
  transition: opacity 0.2s ease;
}
.view-all-link:hover { opacity: 0.6; }

/* ================= CATEGORY GRID ================= */
.category-section {
  background: #f8f6f2;
}

.category-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

.category-card {
  text-decoration: none;
  color: #17243a;
  background: #ffffff;
  border: 1px solid #eae3dc;
  border-radius: 4px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.category-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.category-img-wrap {
  position: relative;
  aspect-ratio: 4 / 5;
  overflow: hidden;
  background: #e8e3dc;
}

.category-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}
.category-card:hover .category-img-wrap img {
  transform: scale(1.05);
}

.category-overlay-box {
  position: absolute;
  inset: 0;
  background: rgba(23, 36, 58, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}
.category-card:hover .category-overlay-box { opacity: 1; }
.category-overlay-box span {
  background: #ffffff;
  color: #17243a;
  padding: 0.6rem 1.2rem;
  font-size: 0.65rem;
  font-weight: 800;
  letter-spacing: 1px;
}

.category-details {
  padding: 1.2rem;
}
.category-details h3 {
  font-family: 'Syne', sans-serif;
  font-size: 1rem;
  font-weight: 700;
  margin: 0 0 0.3rem 0;
}
.category-details p {
  font-size: 0.8rem;
  color: #7b8190;
  margin: 0;
}

/* ================= PRODUCT GRID ================= */
.product-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

.product-card {
  background: #ffffff;
  border: 1px solid #eae3dc;
  border-radius: 4px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.product-img-wrap {
  position: relative;
  aspect-ratio: 1 / 1;
  background: #f1ede6;
  overflow: hidden;
}

.product-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}
.product-card:hover .product-img-wrap img {
  transform: scale(1.05);
}

.product-badge-tag {
  position: absolute;
  top: 10px;
  left: 10px;
  background: #dc3545;
  color: #ffffff;
  font-size: 9px;
  font-weight: 800;
  padding: 3px 8px;
  letter-spacing: 1px;
}

.product-info {
  padding: 1.2rem;
}

.product-info h4 {
  font-family: 'Syne', sans-serif;
  font-size: 0.95rem;
  font-weight: 600;
  color: #17243a;
  margin: 0 0 0.5rem 0;
}

.product-price {
  font-size: 0.85rem;
  font-weight: 700;
  color: #5c677d;
}

/* ================= PROMO SECTION ================= */
.promo-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.promo-card {
  padding: 3rem;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  box-shadow: 0 15px 35px rgba(23, 36, 58, 0.1);
}

.dark-card {
  background: linear-gradient(135deg, #17243a 0%, #27364e 100%);
  color: #ffffff;
}

.grey-card {
  background: linear-gradient(135deg, #22314a 0%, #111a28 100%);
  color: #ffffff;
}

.badge-pill {
  font-size: 9px;
  font-weight: 800;
  padding: 4px 10px;
  letter-spacing: 2px;
  margin-bottom: 1rem;
  border-radius: 2px;
}
.bg-neon { background: #ffffff; color: #17243a; }
.bg-dark { background: rgba(255, 255, 255, 0.2); color: #ffffff; }

.promo-card h3 {
  font-family: 'Syne', sans-serif;
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0 0 0.8rem 0;
  color: #ffffff;
}

.highlight { color: #e2c182; }

.promo-card p {
  color: rgba(255, 255, 255, 0.85);
  font-size: 0.9rem;
  line-height: 1.6;
  margin-bottom: 2rem;
}

.btn-white {
  background: #ffffff;
  color: #17243a;
  padding: 0.8rem 1.8rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-decoration: none;
  border-radius: 4px;
}

.btn-dark {
  background: #ffffff;
  color: #17243a;
  padding: 0.8rem 1.8rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-decoration: none;
  border-radius: 4px;
}

/* ================= SUPPORT BUTTON ================= */
.support-float-btn {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 1000;
  background: #17243a;
  color: #ffffff;
  border: none;
  padding: 0.8rem 1.4rem;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 1px;
  border-radius: 30px;
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  box-shadow: 0 10px 30px rgba(23, 36, 58, 0.25);
  transition: transform 0.2s ease;
}
.support-float-btn:hover {
  transform: scale(1.05);
}

/* ================= RESPONSIVE QUERY ================= */
@media (max-width: 1200px) {
  .category-grid, .product-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .street-navbar { padding: 1.2rem 1.5rem; }
  .nav-left { display: none; }
  .hero-title { font-size: 2.8rem; }
  .category-grid, .product-grid, .promo-grid {
    grid-template-columns: 1fr;
  }
  .section-container { padding: 3rem 1.5rem; }
}
.btn-admin-panel {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background-color: #11151c;
  color: #ffffff;
  padding: 10px 18px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: background-color 0.2s ease, transform 0.1s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-admin-panel:hover {
  background-color: #2d3748;
  transform: translateY(-1px);
}
</style>