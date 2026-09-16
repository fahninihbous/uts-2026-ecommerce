<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Set baseURL sesuai API Laravel Anda (sesuaikan port jika perlu, misal: http://127.0.0.1:8000/api)
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

const categories = ref([])
const featuredProducts = ref([])
const latestProducts = ref([])
const cartCount = ref(0)
const isLoggedIn = ref(false)

// Fungsi untuk mengambil data dari API Laravel
const fetchHomeData = async () => {
  try {
    // 1. Ambil Kategori Publik
    const catRes = await axios.get('/public/kategori')
    categories.value = catRes.data.data || catRes.data

    // 2. Ambil Produk Publik (Produk Unggulan & Terbaru)
    const prodRes = await axios.get('/public/produk')
    const products = prodRes.data.data || prodRes.data

    // Membagi produk (misal: 4 untuk unggulan, 4 berikutnya untuk terbaru)
    featuredProducts.value = products.slice(0, 4)
    latestProducts.value = products.slice(4, 8)

    // 3. Cek Status Login & Cart jika token tersedia di localStorage
    const token = localStorage.getItem('token')
    if (token) {
      isLoggedIn.value = true
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

      // Ambil jumlah item keranjang
      const cartRes = await axios.get('/cart')
      const cartItems = cartRes.data.data || cartRes.data
      cartCount.value = cartItems.length || cartItems.reduce((acc, item) => acc + item.quantity, 0)
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
  <div class="home-container">

    <!-- HERO SECTION -->
    <header class="hero-wrapper">
      <nav class="navbar">
        <div class="nav-left">
          <router-link to="/shop" class="nav-link">SHOP</router-link>
          <router-link to="/about" class="nav-link">OUR MISSION</router-link>
        </div>

        <div class="nav-center">
          <router-link to="/home" class="brand-logo">PROVIDENTIAL</router-link>
        </div>

        <div class="nav-right">
          <router-link to="/search" class="icon-btn" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.3-4.3"/>
            </svg>
          </router-link>

          <router-link to="/cart" class="icon-btn cart-btn" aria-label="Cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
              <path d="M3 6h18"/>
              <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <span v-if="cartCount > 0" class="cart-badge">{{ cartCount }}</span>
          </router-link>

          <router-link to="/user" class="icon-btn" aria-label="Account">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </router-link>
        </div>
      </nav>

      <div class="hero-content">
        <div class="hero-text-card">
          <span class="hero-tag">TERRACE CULTURE 2026</span>
          <h1 class="hero-title">Football Tribune & Casual Style</h1>
          <p class="hero-subtitle">Terinspirasi dari atmosfer tribun stadion dan kultur kasual klasik penuh elegansi.</p>
          <div class="hero-actions">
            <router-link to="/shop" class="btn-hero">Belanja Sekarang</router-link>
            <router-link to="/about" class="btn-hero-outline">Our Philosophy</router-link>
          </div>
        </div>
      </div>
    </header>

    <!-- CATEGORY SECTION -->
    <section class="category-section">
      <div class="category-header">
        <p class="category-label">EXPLORE</p>
        <h2 class="category-title">Kategori Populer</h2>
        <p class="category-description">
          Discover timeless pieces crafted for comfort, structural elegance, and everyday wearability.
        </p>
      </div>

      <div class="category-grid">
        <router-link
          v-for="category in categories"
          :key="category.id || category.name"
          to="/shop"
          class="category-card"
        >
          <div class="category-image-wrapper">
            <img :src="category.image || 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1000&auto=format&fit=crop'" :alt="category.name" class="category-image" />
            <div class="category-overlay">
              <span class="view-category">View Collection</span>
            </div>
          </div>
          <div class="category-info">
            <h3 class="category-name">{{ category.name }}</h3>
            <span class="category-products-count">{{ category.products_count || 'Koleksi' }}</span>
            <p class="category-text">{{ category.description || 'Terrace & casual essentials' }}</p>
          </div>
        </router-link>
      </div>
    </section>

    <!-- PRODUK UNGGULAN -->
    <section class="product-section bg-subtle">
      <div class="custom-container">
        <div class="section-header-flex">
          <h2 class="section-heading-custom">Produk Unggulan</h2>
          <router-link to="/shop" class="btn-view-all">Lihat Semua &rarr;</router-link>
        </div>
        <div class="custom-grid">
          <div v-for="product in featuredProducts" :key="product.id" class="product-item-card">
            <div class="product-img-box">
              <img :src="product.image || 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=600&auto=format&fit=crop'" :alt="product.name" class="product-img">
            </div>
            <div class="product-desc">
              <h4 class="product-name">{{ product.name }}</h4>
              <span class="product-price">Rp {{ Number(product.price).toLocaleString('id-ID') }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PROMO BANNER -->
    <section class="promo-section">
      <div class="custom-container">
        <div class="promo-grid">
          <div class="promo-box">
            <span class="custom-badge bg-danger-badge">PROMO TERBATAS</span>
            <h2 class="promo-title">Flash Sale! <span class="promo-highlight">CLOTH20</span></h2>
            <p class="promo-text">Diskon hingga 50% untuk produk pilihan tribun & casual.</p>
            <router-link to="/shop" class="btn-promo">Lihat Semua Promo</router-link>
          </div>

          <div class="promo-box promo-box-member">
            <template v-if="!isLoggedIn">
              <span class="custom-badge bg-white-badge">MEMBER BARU</span>
              <h2 class="promo-title">Makin <span class="promo-highlight">Hemat?</span></h2>
              <p class="promo-text">Dapatkan voucher Rp 50.000 untuk pembelian pertama.</p>
              <router-link to="/register" class="btn-promo">Daftar Sekarang</router-link>
            </template>
            <template v-else>
              <span class="custom-badge bg-success-badge">AKUN MEMBER</span>
              <h2 class="promo-title">Selamat Datang!</h2>
              <p class="promo-text">Cek pesanan terbaru atau lanjutkan belanja koleksi kami.</p>
              <router-link to="/pesanan" class="btn-promo">Riwayat Pesanan</router-link>
            </template>
          </div>
        </div>
      </div>
    </section>

    <!-- PRODUK TERBARU -->
    <section class="product-section bg-white">
      <div class="custom-container">
        <div class="section-header-flex">
          <h2 class="section-heading-custom">Produk Terbaru</h2>
        </div>
        <div class="custom-grid">
          <div v-for="product in latestProducts" :key="product.id" class="product-item-card">
            <div class="product-img-box">
              <img :src="product.image || 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=600&auto=format&fit=crop'" :alt="product.name" class="product-img">
            </div>
            <div class="product-desc">
              <h4 class="product-name">{{ product.name }}</h4>
              <span class="product-price">Rp {{ Number(product.price).toLocaleString('id-ID') }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SUPPORT BUTTON -->
    <button class="support-btn" aria-label="Customer Support">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
        <line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
      <span>Support</span>
    </button>

  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap');

.home-container {
  font-family: 'Inter', sans-serif;
  color: #17243a;
  background: #ffffff;
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
}

/* HERO SECTION */
.hero-wrapper {
  position: relative;
  min-height: 90vh;
  display: flex;
  flex-direction: column;
  background-image: 
    linear-gradient(
      100deg,
      rgba(255, 250, 242, 0.96) 0%,
      rgba(255, 250, 242, 0.88) 40%,
      rgba(255, 250, 242, 0.4) 70%,
      rgba(255, 250, 242, 0.15) 100%
    ),
    url('https://images.unsplash.com/photo-1518091043644-c1d4457512c6?q=80&w=2070&auto=format&fit=crop');
  background-size: cover;
  background-position: center;
}

.navbar {
  position: relative;
  z-index: 10;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.8rem 4rem;
}

.nav-left { display: flex; align-items: center; gap: 2rem; }
.nav-link {
  color: #17243a;
  text-decoration: none;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 2px;
  transition: opacity 0.2s ease;
}
.nav-link:hover { opacity: 0.6; }
.nav-center { position: absolute; left: 50%; transform: translateX(-50%); }
.brand-logo { color: #17243a; text-decoration: none; font-size: 1.8rem; font-weight: 800; letter-spacing: 5px; }
.nav-right { display: flex; align-items: center; gap: 1.5rem; }
.icon-btn { position: relative; color: #17243a; background: transparent; border: none; cursor: pointer; padding: 4px; transition: transform 0.2s ease; }
.icon-btn:hover { transform: translateY(-2px); }
.cart-badge {
  position: absolute; top: -6px; right: -8px; width: 18px; height: 18px;
  display: flex; align-items: center; justify-content: center;
  background: #17243a; color: #ffffff; border-radius: 50%; font-size: 9px; font-weight: 700;
}

.hero-content { flex: 1; display: flex; align-items: center; padding: 0 4rem; max-width: 1400px; margin: 0 auto; width: 100%; }
.hero-text-card { max-width: 540px; }
.hero-tag { display: inline-block; font-size: 0.7rem; font-weight: 700; letter-spacing: 3px; color: #5c677d; margin-bottom: 1rem; text-transform: uppercase; }
.hero-title { margin: 0 0 1.2rem; font-family: 'Playfair Display', Georgia, serif; font-size: 3.5rem; font-weight: 400; line-height: 1.1; color: #17243a; }
.hero-subtitle { margin-bottom: 2rem; color: #4a5568; font-size: 1.1rem; line-height: 1.6; }
.hero-actions { display: flex; align-items: center; gap: 1rem; }
.btn-hero { display: inline-block; padding: 0.95rem 2.2rem; background: #17243a; color: #ffffff; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: background 0.2s ease, transform 0.2s ease; }
.btn-hero:hover { background: #27364e; transform: translateY(-2px); }
.btn-hero-outline { display: inline-block; padding: 0.95rem 1.8rem; background: transparent; color: #17243a; border: 1px solid rgba(23, 36, 58, 0.3); border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: border-color 0.2s ease, background 0.2s ease; }
.btn-hero-outline:hover { border-color: #17243a; background: rgba(23, 36, 58, 0.03); }

/* CATEGORY SECTION */
.category-section { padding: 5rem 3rem 6rem; background: #f8f6f2; }
.category-header { text-align: center; max-width: 650px; margin: 0 auto 4rem; }
.category-label { margin: 0 0 0.8rem; font-size: 0.7rem; font-weight: 700; letter-spacing: 3px; color: #717784; }
.category-title { margin: 0 0 1rem; font-family: 'Playfair Display', Georgia, serif; font-size: 2.8rem; font-weight: 400; color: #17243a; }
.category-description { margin: 0; color: #6b7280; font-size: 1rem; line-height: 1.7; }
.category-grid { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; }
.category-card { display: block; background: #ffffff; text-decoration: none; color: #17243a; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); transition: transform 0.3s ease, box-shadow 0.3s ease; }
.category-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08); }
.category-image-wrapper { position: relative; width: 100%; height: 320px; overflow: hidden; background: #e8e3dc; }
.category-image { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease; }
.category-card:hover .category-image { transform: scale(1.05); }
.category-overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(23, 36, 58, 0.3); opacity: 0; transition: opacity 0.3s ease; }
.category-card:hover .category-overlay { opacity: 1; }
.view-category { padding: 0.8rem 1.4rem; background: #ffffff; color: #17243a; font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; border-radius: 4px; }
.category-info { padding: 1.4rem 1.2rem 1.6rem; text-align: center; }
.category-name { margin: 0 0 0.2rem; font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; font-weight: 500; color: #17243a; }
.category-products-count { display: block; font-size: 0.7rem; color: #8c93a0; margin-bottom: 0.5rem; font-weight: 600; }
.category-text { margin: 0; color: #7b8190; font-size: 0.8rem; line-height: 1.4; }

/* REUSABLE PRODUCT SECTIONS */
.product-section { padding: 5rem 0; }
.bg-subtle { background-color: #fbf9f5; }
.bg-white { background-color: #ffffff; }

.custom-container {
  max-width: 1250px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

.section-header-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2.5rem;
  border-bottom: 1px solid #eae3dc;
  padding-bottom: 1rem;
}

.section-heading-custom {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 2rem;
  font-weight: 500;
  color: #17243a;
  margin: 0;
}

.btn-view-all {
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 1px;
  color: #17243a;
  text-decoration: none;
  text-transform: uppercase;
  transition: opacity 0.2s ease;
}
.btn-view-all:hover { opacity: 0.6; }

.custom-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

.product-item-card {
  background: #ffffff;
  border-radius: 8px;
  overflow: hidden;
  border: 1px solid #eae3dc;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-item-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.product-img-box {
  width: 100%;
  aspect-ratio: 1 / 1;
  overflow: hidden;
  background: #f1ede6;
}

.product-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}
.product-item-card:hover .product-img {
  transform: scale(1.06);
}

.product-desc {
  padding: 1.25rem;
  text-align: center;
}

.product-name {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 1.05rem;
  font-weight: 600;
  color: #17243a;
  margin-bottom: 0.4rem;
}

.product-price {
  font-size: 0.9rem;
  font-weight: 700;
  color: #5c677d;
}

/* PROMO SECTION */
.promo-section { padding: 4rem 0 5rem; background: #ffffff; }
.promo-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
.promo-box {
  background: linear-gradient(135deg, #17243a 0%, #27364e 100%);
  border-radius: 16px;
  padding: 3.5rem 2rem;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: 0 15px 35px rgba(23, 36, 58, 0.15);
  transition: transform 0.3s ease;
}
.promo-box:hover { transform: translateY(-3px); }
.promo-box-member { background: linear-gradient(135deg, #22314a 0%, #111a28 100%); }
.custom-badge {
  display: inline-block;
  padding: 0.35rem 0.85rem;
  border-radius: 50rem;
  font-size: 10px;
  font-weight: 700;
  margin-bottom: 0.8rem;
  letter-spacing: 1px;
}
.bg-danger-badge { background-color: #dc3545; color: white; }
.bg-white-badge { background-color: #ffffff; color: #17243a; }
.bg-success-badge { background-color: #198754; color: white; }

.promo-title { margin: 0 0 1rem; font-family: 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 500; color: #ffffff; }
.promo-highlight { color: #e2c182; }
.promo-text { margin: 0 0 2rem; color: rgba(255, 255, 255, 0.85); font-size: 1.05rem; }
.btn-promo {
  display: inline-block; padding: 0.95rem 2.5rem; background: #ffffff; color: #17243a;
  border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: 700; letter-spacing: 0.5px;
  transition: background 0.2s ease, transform 0.2s ease;
}
.btn-promo:hover { background: #f8f6f2; transform: translateY(-2px); }

/* SUPPORT BUTTON */
.support-btn {
  position: fixed; right: 24px; bottom: 24px; z-index: 100;
  display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.35rem;
  border: none; border-radius: 30px; background: #17243a; color: white; font-size: 0.85rem; font-weight: 500; cursor: pointer;
  box-shadow: 0 6px 20px rgba(23, 36, 58, 0.25);
  transition: background 0.2s ease, transform 0.2s ease;
}
.support-btn:hover { background: #27364e; transform: scale(1.05); }

/* RESPONSIVE MEDIA QUERIES */
@media (max-width: 1200px) {
  .category-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 992px) {
  .custom-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
  .navbar { padding: 1.2rem 2rem; }
  .brand-logo { font-size: 1.4rem; letter-spacing: 3px; }
  .hero-content { padding: 0 2rem; }
  .hero-title { font-size: 2.8rem; }
  .category-grid { grid-template-columns: repeat(2, 1fr); }
  .promo-grid { grid-template-columns: 1fr; }
}

@media (max-width: 600px) {
  .navbar { padding: 1rem 1.2rem; }
  .hero-wrapper { min-height: 80vh; }
  .hero-content { padding: 0 1.5rem; }
  .hero-title { font-size: 2.2rem; }
  .category-grid { grid-template-columns: 1fr; }
  .custom-grid { grid-template-columns: 1fr; }
}
</style>