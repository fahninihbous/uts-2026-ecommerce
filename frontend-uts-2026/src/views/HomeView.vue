<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

// Inisialisasi router
const router = useRouter()

// Set baseURL sesuai API Laravel Anda
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

// ==========================================
// STATE MANAGEMENT
// ==========================================
const categories = ref([])
const allProducts = ref([])
const cartCount = ref(0)
const isLoggedIn = ref(false)
const isAdmin = ref(false)

// STATE KHUSUS SEARCH OVERLAY
const isSearchOpen = ref(false)
const searchQuery = ref('')
const selectedCategory = ref('All')

// Penentu arah link tombol ikon User secara dinamis
const accountLink = computed(() => {
  return isLoggedIn.value ? '/user' : '/login'
})

// ==========================================
// FETCH API DATA
// ==========================================
const fetchHomeData = async () => {
  try {
    const catRes = await axios.get('/public/kategori')
    categories.value = catRes.data.data || catRes.data

    const prodRes = await axios.get('/public/produk')
    const products = prodRes.data.data || prodRes.data
    allProducts.value = products

    const token = localStorage.getItem('token')
    if (token) {
      isLoggedIn.value = true
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

      try {
        const userRes = await axios.get('/profile') 
        const userData = userRes.data.data || userRes.data
        if (userData.role === 'admin' || userData.is_admin === 1) {
          isAdmin.value = true
        }
      } catch (err) {
        console.log('Gagal memuat profil.', err)
      }

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

// ==========================================
// NAVIGATION LOGIC (DISAMAKAN KE /productdetail?id=...)
// ==========================================
const goToDetail = (productId) => {
  if (isSearchOpen.value) {
    closeSearchModal()
  }
  router.push({ path: '/productdetail', query: { id: productId } })
}

// ==========================================
// SEARCH OVERLAY LOGIC
// ==========================================
const openSearchModal = async () => {
  isSearchOpen.value = true
  if (allProducts.value.length === 0) {
    try {
      const res = await axios.get('/public/produk')
      allProducts.value = res.data.data || res.data
    } catch (err) {
      console.error('Gagal memuat produk untuk search:', err)
    }
  }
}

const closeSearchModal = () => {
  isSearchOpen.value = false
  searchQuery.value = ''
  selectedCategory.value = 'All'
}

const filteredSearchResults = computed(() => {
  let result = allProducts.value

  if (searchQuery.value.trim() !== '') {
    const keyword = searchQuery.value.toLowerCase().trim()
    result = result.filter(product =>
      product.name.toLowerCase().includes(keyword) ||
      (product.description && product.description.toLowerCase().includes(keyword))
    )
  }

  if (selectedCategory.value !== 'All') {
    result = result.filter(product => 
      product.category_id == selectedCategory.value || 
      (product.category && product.category.name === selectedCategory.value)
    )
  }

  return result
})

onMounted(() => {
  fetchHomeData()
})
</script>

<template>
  <div class="heritage-container">

    <!-- RUNNING TICKER / MARQUEE BAR -->
    <div class="heritage-marquee">
      <div class="marquee-track">
        <span>ESTABLISHED HERITAGE &bull; TERRACE CULTURE &bull; NO COMPROMISE &bull; ESTABLISHED HERITAGE &bull; TERRACE CULTURE &bull; NO COMPROMISE &bull;</span>
      </div>
    </div>

    <!-- =====================================
         NAVIGATION BAR
    ====================================== -->
    <header class="heritage-navbar-wrapper">
      <nav class="heritage-navbar">
        <div class="nav-left">
          <router-link to="/shop" class="nav-link">ARCHIVES</router-link>
          <router-link to="/about" class="nav-link">MANIFESTO</router-link>
        </div>

        <div class="nav-center">
          <router-link to="/home" class="brand-logo">PROVIDENTIAL<span class="logo-accent">.</span></router-link>
        </div>

        <div class="nav-right">
          <!-- Tombol Search -->
          <button @click="openSearchModal" class="icon-btn" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          </button>

          <!-- Tombol Cart -->
          <router-link to="/cart" class="icon-btn cart-btn" aria-label="Cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
              <path d="M3 6h18"/>
              <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <span v-if="cartCount > 0" class="cart-badge">{{ cartCount }}</span>
          </router-link>

          <!-- TOMBOL ADMIN PANEL -->
          <router-link v-if="isAdmin" to="/admin" class="admin-panel-badge" title="Panel Admin">
            <span>ADMIN</span>
          </router-link>

          <!-- Tombol Akun -->
          <router-link :to="accountLink" class="icon-btn" :title="isLoggedIn ? 'Akun Saya' : 'Login'" aria-label="Account">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </router-link>
        </div>
      </nav>
    </header>


    <!-- =====================================
         HERO SECTION (CLASSIC HERITAGE VIBE)
    ====================================== -->
    <section class="hero-section">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <div class="hero-badge-box">
          <span class="hero-badge">⚡ SEASON 01 // TOKYO &bull; JAKARTA</span>
        </div>
        <h1 class="hero-title">STREET ATTITUDE.<br><span class="highlight-red">ZERO COMPROMISE.</span></h1>
        <p class="hero-subtitle">Eksklusivitas budaya jalanan, terrace culture, dan rilisan terbatas yang mendefinisikan ulang batas gaya urban modern.</p>
        <div class="hero-actions">
          <router-link to="/shop" class="btn-primary">EXPLORE DROPS &rarr;</router-link>
          <router-link to="/about" class="btn-outline">OUR MANIFESTO</router-link>
        </div>
      </div>
    </section>


    <!-- =====================================
         CATEGORY SECTION (REFINED CLASSIC CARDS)
    ====================================== -->
    <section class="section-container">
      <div class="section-header">
        <span class="sub-heading">COLLECTIONS</span>
        <h2>CHOOSE YOUR LINEUP</h2>
      </div>

      <div class="category-grid">
        <router-link
          v-for="category in categories"
          :key="category.id || category.name"
          to="/shop"
          class="category-card"
        >
          <div class="category-img-wrap">
            <img :src="category.image_url || 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop'" :alt="category.name" />
            <div class="category-badge-pill">ARCHIVE</div>
          </div>
          <div class="category-details">
            <h3>{{ category.name }}</h3>
            <p>{{ category.description || 'Core essentials & limited release' }}</p>
            <span class="explore-link">VIEW LINEUP &rarr;</span>
          </div>
        </router-link>
      </div>
    </section>


    <!-- =====================================
         PROMO & MEMBERSHIP BANNER
    ====================================== -->
    <section class="section-container promo-container">
      <div class="promo-grid">
        
        <div class="promo-card red-card">
          <span class="badge-pill bg-white-pill">LIMITED VOUCHER</span>
          <h3>USE CODE <span class="highlight-yellow">STREET20</span></h3>
          <p>Potongan harga eksklusif 20% khusus untuk koleksi terpilih. Amankan sebelum kehabisan stok.</p>
          <router-link to="/shop" class="btn-dark-solid">CLAIM VOUCHER</router-link>
        </div>

        <div class="promo-card dark-card">
          <template v-if="!isLoggedIn">
            <span class="badge-pill bg-red-pill">CREW ACCESS</span>
            <h3>JOIN THE INNER CIRCLE</h3>
            <p>Daftar sekarang untuk mendapatkan akses prioritas ke rilisan eksklusif mingguan.</p>
            <router-link to="/register" class="btn-white-solid">SIGN UP FREE</router-link>
          </template>
          <template v-else>
            <span class="badge-pill bg-red-pill">DASHBOARD</span>
            <h3>WELCOME BACK, CREW</h3>
            <p>Periksa status pengiriman pesanan atau histori drop Anda melalui profil akun.</p>
            <router-link to="/pesanan" class="btn-white-solid">VIEW ORDERS</router-link>
          </template>
        </div>

      </div>
    </section>


    <!-- =====================================
         PRODUK KAMI (ALL PRODUCTS LISTING)
    ====================================== -->
    <section class="section-container">
      <div class="section-header-flex">
        <div>
          <span class="sub-heading">OUR CATALOGUE</span>
          <h2>PRODUK KAMI</h2>
        </div>
        <router-link to="/shop" class="view-all-link">VIEW ALL VAULT &rarr;</router-link>
      </div>

      <div class="product-grid">
        <div v-for="product in allProducts" :key="product.id" class="product-card">
          <div class="product-img-wrap">
            <img :src="product.images?.[0]?.image_url || 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=600&auto=format&fit=crop'" :alt="product.name" />
            <div class="product-badge-tag">AVAILABLE</div>
          </div>
          <div class="product-info">
            <span class="product-cat-label">AUTHENTIC GEAR</span>
            <h4>{{ product.name }}</h4>
            <div class="product-footer">
              <span class="product-price">Rp {{ Number(product.price).toLocaleString('id-ID') }}</span>
              <!-- Tombol Detail menggunakan metode goToDetail dengan format query id -->
              <button 
                class="action-btn detail-btn" 
                @click="goToDetail(product.id)"
              >
                DETAILS
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- =====================================
         FOOTER SECTIONS (CLASSIC HERITAGE)
    ====================================== -->
    <footer class="heritage-footer">
      <div class="footer-container">
        <div class="footer-top">
          <div class="footer-brand-col">
            <router-link to="/home" class="footer-logo">PROVIDENTIAL<span class="logo-accent">.</span></router-link>
            <p>Eksklusivitas budaya jalanan, terrace culture, dan rilisan terbatas yang mendefinisikan ulang batas gaya urban modern.</p>
            <div class="footer-socials">
              <a href="#" aria-label="Instagram">IG</a>
              <a href="#" aria-label="Twitter">X</a>
              <a href="#" aria-label="Spotify">SPT</a>
            </div>
          </div>

          <div class="footer-links-col">
            <h4>EXPLORE</h4>
            <ul>
              <li><router-link to="/shop">Archives</router-link></li>
              <li><router-link to="/shop">Limited Drops</router-link></li>
              <li><router-link to="/about">Our Manifesto</router-link></li>
            </ul>
          </div>

          <div class="footer-links-col">
            <h4>ASSISTANCE</h4>
            <ul>
              <li><router-link to="/cart">Cart Status</router-link></li>
              <li><a href="#">Shipping Guide</a></li>
              <li><a href="#">Terms & Conditions</a></li>
            </ul>
          </div>

          <div class="footer-newsletter-col">
            <h4>NEWSLETTER</h4>
            <p>Dapatkan informasi rahasia mengenai jadwal drop eksklusif berikutnya.</p>
            <div class="newsletter-input-group">
              <input type="email" placeholder="Alamat email Anda..." />
              <button type="button">JOIN</button>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <p>&copy; 2026 PROVIDENTIAL TOKYO &bull; JAKARTA. ALL RIGHTS RESERVED.</p>
          <div class="footer-bottom-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Legal Notice</a>
          </div>
        </div>
      </div>
    </footer>


    <!-- =====================================
         FLOATING SUPPORT BUTTON
    ====================================== -->
    <button class="support-float-btn" aria-label="Customer Support">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
      <span>SUPPORT</span>
    </button>


    <!-- =========================================================
         SPLIT-SCREEN SEARCH OVERLAY MODAL
    ========================================================== -->
    <div v-if="isSearchOpen" class="search-overlay-backdrop">
      <div class="search-split-container">
        
        <div class="search-sidebar-pane">
          <button class="close-modal-btn" @click="closeSearchModal">&times; ESC</button>
          <span class="sub-heading">QUICK FIND</span>
          <h2>SEARCH VAULT</h2>
          <p class="desc">Ketik nama produk untuk mencari koleksi.</p>

          <div class="search-input-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input 
              v-model="searchQuery" 
              type="text" 
              placeholder="Cari jacket, tee, dll..." 
              autofocus
            />
            <button v-if="searchQuery" @click="searchQuery = ''" class="clear-input">&times;</button>
          </div>

          <div class="filter-group">
            <label>FILTER CATEGORY:</label>
            <select v-model="selectedCategory" class="category-select">
              <option value="All">All Categories</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                {{ cat.name }}
              </option>
            </select>
          </div>

          <div class="search-stats">
            <span>Ditemukan: <strong>{{ filteredSearchResults.length }}</strong> item</span>
          </div>
        </div>

        <div class="search-results-pane">
          <div class="results-header">
            <h3>SEARCH RESULTS</h3>
            <span class="results-keyword" v-if="searchQuery">Keyword: "{{ searchQuery }}"</span>
          </div>

          <div class="results-list" v-if="filteredSearchResults.length > 0">
            <div v-for="prod in filteredSearchResults" :key="prod.id" class="result-product-card">
              <img :src="prod.images?.[0]?.image_url || 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=300'" :alt="prod.name" />
              <div class="result-info">
                <h4>{{ prod.name }}</h4>
                <span class="price">Rp {{ Number(prod.price).toLocaleString('id-ID') }}</span>
              </div>
              <button class="action-btn detail-btn" @click="goToDetail(prod.id)">DETAILS</button>
            </div>
          </div>

          <div class="no-results" v-else>
            <p>Tidak ada produk ditemukan di database.</p>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@500;700;800&display=swap');

/* =========================================
   GLOBAL & LAYOUT STYLES (CLASSIC HERITAGE)
   ========================================= */
.heritage-container {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: #fcfbfa;
  color: #111111;
  min-height: 100vh;
  overflow-x: hidden;
}

/* RUNNING MARQUEE TICKER */
.heritage-marquee {
  background: #111111;
  color: #ffffff;
  font-weight: 800;
  font-size: 0.75rem;
  letter-spacing: 3px;
  overflow: hidden;
  white-space: nowrap;
  padding: 10px 0;
  border-bottom: 2px solid #d92323;
}
.marquee-track {
  display: inline-block;
  animation: marquee 30s linear infinite;
}
@keyframes marquee {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* NAVBAR */
.heritage-navbar-wrapper {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(252, 251, 250, 0.95);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid #e5e0dc;
}

.heritage-navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1440px;
  margin: 0 auto;
  padding: 1.5rem 3rem;
}

.nav-left, .nav-right { display: flex; align-items: center; gap: 2rem; }

.nav-link {
  color: #555555;
  text-decoration: none;
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 2px;
  transition: color 0.2s;
}
.nav-link:hover { color: #d92323; }

.nav-center { position: absolute; left: 50%; transform: translateX(-50%); }

.brand-logo {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  font-weight: 900;
  letter-spacing: 4px;
  color: #111111;
  text-decoration: none;
}
.logo-accent { color: #d92323; }

.icon-btn {
  position: relative;
  background: none;
  border: none;
  color: #111111;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  transition: transform 0.2s;
}
.icon-btn:hover { color: #d92323; transform: scale(1.1); }

/* TOMBOL ADMIN PANEL */
.admin-panel-badge {
  background: #111111;
  color: #ffffff;
  padding: 0.4rem 0.9rem;
  border-radius: 2px;
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 1px;
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: background 0.2s;
}
.admin-panel-badge:hover {
  background: #d92323;
}

.cart-badge {
  position: absolute;
  top: -6px;
  right: -8px;
  background: #d92323;
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #fcfbfa;
}

/* HERO SECTION */
.hero-section {
  position: relative;
  height: 85vh;
  display: flex;
  align-items: center;
  background: url('https://images.unsplash.com/photo-1555529771-835f59fc5efe?q=80&w=2000&auto=format&fit=crop') center/cover no-repeat;
  border-bottom: 2px solid #111;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, rgba(252, 251, 250, 0.96) 0%, rgba(252, 251, 250, 0.5) 75%);
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 3rem;
  width: 100%;
}

.hero-badge-box { margin-bottom: 1rem; }
.hero-badge {
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 3px;
  background: #d92323;
  color: #ffffff;
  padding: 5px 12px;
  text-transform: uppercase;
  display: inline-block;
}

.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: 4.5rem;
  font-weight: 900;
  line-height: 1.05;
  margin: 0 0 1.5rem;
  letter-spacing: 1px;
  color: #111;
}
.highlight-red { color: #d92323; }

.hero-subtitle {
  max-width: 520px;
  color: #444444;
  font-size: 1rem;
  line-height: 1.7;
  margin-bottom: 2.5rem;
}

.hero-actions { display: flex; gap: 1rem; }

/* COMMON BUTTONS */
.btn-primary, .btn-outline {
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 2px;
  text-decoration: none;
  border-radius: 2px;
  transition: all 0.2s ease;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-primary { 
  background: #111111; 
  color: #ffffff; 
  padding: 1rem 2.2rem; 
  border: 2px solid #111111; 
}
.btn-primary:hover { background: #d92323; border-color: #d92323; }

.btn-outline { 
  background: transparent; 
  color: #111111; 
  border: 2px solid #111111; 
  padding: 1rem 2rem; 
}
.btn-outline:hover { background: #111111; color: #ffffff; }

/* SECTIONS & GRIDS */
.section-container { max-width: 1440px; margin: 0 auto; padding: 5rem 3rem; border-bottom: 1px solid #e5e0dc; }

.sub-heading {
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 3px;
  color: #d92323;
  display: block;
  margin-bottom: 0.5rem;
}

.section-header h2, .section-header-flex h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  font-weight: 900;
  letter-spacing: 1px;
  margin: 0;
  color: #111;
}

.section-header-flex {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 3rem;
  border-bottom: 2px solid #111;
  padding-bottom: 1rem;
}

.view-all-link {
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 2px;
  color: #111111;
  text-decoration: none;
}
.view-all-link:hover { color: #d92323; text-decoration: underline; }

/* =========================================
   CATEGORY SECTION (CLASSIC CARDS)
   ========================================= */
.category-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
}

.category-card {
  background: #ffffff;
  border: 1px solid #e5e0dc;
  border-radius: 4px;
  overflow: hidden;
  text-decoration: none;
  color: #111111;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  display: flex;
  flex-direction: column;
}
.category-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
  border-color: #d92323;
}

.category-img-wrap {
  position: relative;
  aspect-ratio: 4/5;
  overflow: hidden;
  background: #eee;
}
.category-img-wrap img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.category-card:hover img { transform: scale(1.06); }

.category-badge-pill {
  position: absolute; top: 12px; left: 12px;
  background: #111111; color: #fff; font-size: 8px; font-weight: 800; padding: 4px 8px; letter-spacing: 1px;
}

.category-details { padding: 1.5rem; display: flex; flex-direction: column; flex: 1; }
.category-details h3 { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 900; margin: 0 0 0.4rem; }
.category-details p { font-size: 0.85rem; color: #666; margin: 0 0 1.2rem; flex: 1; }
.explore-link { font-size: 0.7rem; font-weight: 800; letter-spacing: 1.5px; color: #d92323; }

/* =========================================
   PRODUCT SECTION (CLASSIC EDITORIAL CARDS)
   ========================================= */
.product-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
}

.product-card {
  background: #ffffff;
  border: 1px solid #e5e0dc;
  border-radius: 4px;
  overflow: hidden;
  text-decoration: none;
  color: #111111;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  display: flex;
  flex-direction: column;
}
.product-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
  border-color: #d92323;
}

.product-img-wrap {
  position: relative;
  aspect-ratio: 1/1;
  overflow: hidden;
  background: #eee;
}
.product-img-wrap img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.product-card:hover img { transform: scale(1.06); }

.product-badge-tag {
  position: absolute; top: 12px; left: 12px;
  background: #d92323; color: #fff; font-size: 8px; font-weight: 800; padding: 4px 8px; letter-spacing: 1px;
}

.product-info { padding: 1.5rem; display: flex; flex-direction: column; flex: 1; }
.product-cat-label { font-size: 9px; font-weight: 800; letter-spacing: 2px; color: #888; margin-bottom: 6px; display: block; text-transform: uppercase; }
.product-info h4 { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 900; margin: 0 0 1rem; }

.product-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
  padding-top: 10px;
  border-top: 1px solid #f0e9e4;
}
.product-price { font-size: 0.95rem; font-weight: 800; color: #d92323; }

/* STYLE TOMBOL DETAIL */
.action-btn.detail-btn {
  background: transparent;
  color: #111;
  border: 1px solid #111;
  padding: 6px 12px;
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.2s;
}
.action-btn.detail-btn:hover {
  background: #d92323;
  border-color: #d92323;
  color: #fff;
}

/* PROMO BANNER */
.promo-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
.promo-card { padding: 3rem; border-radius: 4px; display: flex; flex-direction: column; justify-content: center; }
.red-card { background: #d92323; color: #ffffff; }
.dark-card { background: #111111; color: #ffffff; }

.badge-pill { font-size: 9px; font-weight: 800; padding: 4px 10px; letter-spacing: 2px; margin-bottom: 1rem; border-radius: 2px; display: inline-block; }
.bg-white-pill { background: #ffffff; color: #d92323; }
.bg-red-pill { background: #d92323; color: #ffffff; }

.promo-card h3 { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 900; margin: 0 0 0.8rem; letter-spacing: 1px; }
.highlight-yellow { color: #ffeb3b; }
.promo-card p { color: rgba(255, 255, 255, 0.85); font-size: 0.95rem; line-height: 1.6; margin-bottom: 2rem; }

.btn-dark-solid, .btn-white-solid {
  font-size: 0.75rem; font-weight: 800; letter-spacing: 2px; text-decoration: none; border-radius: 2px; padding: 0.9rem 2rem; text-align: center; display: inline-block; transition: all 0.2s;
}
.btn-dark-solid { background: #111111; color: #ffffff; }
.btn-dark-solid:hover { background: #ffffff; color: #111111; }
.btn-white-solid { background: #ffffff; color: #111111; }
.btn-white-solid:hover { background: #d92323; color: #ffffff; }

/* =========================================
   FOOTER STYLING (CLASSIC HERITAGE)
   ========================================= */
.heritage-footer {
  background-color: #111111;
  color: #ffffff;
  padding: 5rem 3rem 2rem 3rem;
  border-top: 3px solid #d92323;
}

.footer-container {
  max-width: 1440px;
  margin: 0 auto;
}

.footer-top {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1.5fr;
  gap: 3rem;
  padding-bottom: 4rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-brand-col .footer-logo {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  font-weight: 900;
  letter-spacing: 4px;
  color: #ffffff;
  text-decoration: none;
  display: inline-block;
  margin-bottom: 1rem;
}

.footer-brand-col p {
  color: #aaaaaa;
  font-size: 0.85rem;
  line-height: 1.7;
  max-width: 340px;
  margin-bottom: 1.5rem;
}

.footer-socials {
  display: flex;
  gap: 1rem;
}

.footer-socials a {
  background: rgba(255, 255, 255, 0.08);
  color: #ffffff;
  width: 36px;
  height: 36px;
  border-radius: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 800;
  text-decoration: none;
  transition: background 0.2s;
}
.footer-socials a:hover {
  background: #d92323;
}

.footer-links-col h4, .footer-newsletter-col h4 {
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 2px;
  color: #ffffff;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
}

.footer-links-col ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
}

.footer-links-col ul li a {
  color: #aaaaaa;
  text-decoration: none;
  font-size: 0.85rem;
  transition: color 0.2s;
}
.footer-links-col ul li a:hover {
  color: #d92323;
}

.footer-newsletter-col p {
  color: #aaaaaa;
  font-size: 0.85rem;
  line-height: 1.6;
  margin-bottom: 1.2rem;
}

.newsletter-input-group {
  display: flex;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 2px;
  overflow: hidden;
}

.newsletter-input-group input {
  background: transparent;
  border: none;
  padding: 0.8rem 1rem;
  color: #fff;
  font-size: 0.85rem;
  outline: none;
  width: 100%;
}

.newsletter-input-group button {
  background: #d92323;
  color: #fff;
  border: none;
  padding: 0 1.2rem;
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 1px;
  cursor: pointer;
  transition: background 0.2s;
}
.newsletter-input-group button:hover {
  background: #b51c1c;
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 2rem;
  font-size: 0.75rem;
  color: #777777;
}

.footer-bottom-links {
  display: flex;
  gap: 2rem;
}

.footer-bottom-links a {
  color: #777777;
  text-decoration: none;
  transition: color 0.2s;
}
.footer-bottom-links a:hover {
  color: #ffffff;
}

/* SUPPORT BUTTON */
.support-float-btn {
  position: fixed; bottom: 30px; right: 30px; z-index: 1000;
  background: #111111; color: #fff; border: 2px solid #111;
  padding: 0.8rem 1.4rem; font-size: 0.75rem; font-weight: 800;
  border-radius: 30px; display: flex; align-items: center; gap: 8px; cursor: pointer;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  transition: transform 0.2s;
}
.support-float-btn:hover { background: #d92323; border-color: #d92323; transform: scale(1.05); }

/* =========================================
   SEARCH OVERLAY MODAL STYLING
   ========================================= */
.search-overlay-backdrop {
  position: fixed; inset: 0;
  background: rgba(17, 17, 17, 0.8);
  backdrop-filter: blur(8px);
  z-index: 9999;
  display: flex; justify-content: center; align-items: center;
}

.search-split-container {
  width: 90vw; max-width: 1200px; height: 80vh;
  background: #fcfbfa; border: 2px solid #111; border-radius: 4px;
  display: grid; grid-template-columns: 380px 1fr;
  overflow: hidden;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
}

.search-sidebar-pane {
  background: #f4f1eb; padding: 3rem 2.5rem;
  display: flex; flex-direction: column; border-right: 2px solid #111;
}

.close-modal-btn {
  align-self: flex-start; background: #111; color: #fff;
  border: none; padding: 6px 12px; font-size: 10px; font-weight: 800;
  cursor: pointer; margin-bottom: 2rem;
}

.search-sidebar-pane h2 { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 900; margin: 0 0 0.5rem; }
.search-sidebar-pane .desc, .search-stats, .results-keyword, .no-results { font-size: 0.85rem; color: #666; }

.search-input-box, .category-select {
  display: flex; align-items: center;
  background: #fff; border: 1px solid #ccc;
  height: 48px; padding: 0 1rem; margin-bottom: 1.2rem;
}
.search-input-box:focus-within, .category-select:focus { border-color: #d92323; }
.search-input-box input { width: 100%; border: none; outline: none; background: transparent; font: inherit; font-size: 0.9rem; }
.clear-input { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #666; }

.filter-group { display: flex; flex-direction: column; gap: 6px; font-size: 0.75rem; font-weight: 800; color: #111; margin-bottom: 1.2rem; letter-spacing: 1px; }
.category-select { width: 100%; outline: none; font: inherit; cursor: pointer; }

.search-results-pane { padding: 3rem; overflow-y: auto; background: #fcfbfa; }

.results-header {
  display: flex; justify-content: space-between; align-items: center;
  border-bottom: 2px solid #111; padding-bottom: 1rem; margin-bottom: 1.5rem;
}
.results-header h3 { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; margin: 0; }

.results-list { display: flex; flex-direction: column; gap: 1rem; }

.result-product-card {
  display: flex; align-items: center; gap: 1.5rem;
  padding: 1rem; background: #fff; border: 1px solid #e5e0dc; border-radius: 4px;
}
.result-product-card:hover { border-color: #d92323; }
.result-product-card img { width: 60px; height: 60px; object-fit: cover; border-radius: 2px; }

.result-info { flex: 1; }
.result-info h4 { font-size: 0.95rem; font-weight: 800; margin: 0 0 4px; font-family: 'Playfair Display', serif; }
.result-info .price { font-size: 0.85rem; color: #d92323; font-weight: 800; }

.no-results { text-align: center; padding: 4rem 0; }

/* RESPONSIVE QUERIES */
@media (max-width: 1200px) {
  .category-grid, .product-grid { grid-template-columns: repeat(2, 1fr); }
  .footer-top { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 900px) {
  .search-split-container { grid-template-columns: 1fr; height: 90vh; width: 95vw; }
}

@media (max-width: 768px) {
  .heritage-navbar { padding: 1.2rem 1.5rem; }
  .nav-left { display: none; }
  .hero-title { font-size: 3rem; }
  .category-grid, .product-grid, .promo-grid, .footer-top { grid-template-columns: 1fr; }
  .section-container, .heritage-footer { padding: 3rem 1.5rem; }
  .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
}
</style>