<template>
  <div class="shop-page">

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">
      <div class="nav-left">
        <router-link to="/shop" class="nav-link active">
          SHOP
        </router-link>
        <router-link to="/about" class="nav-link">
          OUR MISSION
        </router-link>
      </div>

      <router-link to="/home" class="brand">
        PROVIDENTIAL
      </router-link>

      <div class="nav-right">
        <router-link to="/home" class="nav-link">
          SEARCH
        </router-link>
        <router-link to="/cart" class="nav-link">
          CART
          <span class="cart-count">({{ cartCount }})</span>
        </router-link>
        <router-link to="/user" class="nav-link">
          ACCOUNT
        </router-link>
      </div>
    </header>


    <!-- ================= HEADER ================= -->
    <section class="shop-header">
      <div class="header-content">
        <p class="small-title">THE COLLECTION</p>
        <h1>Shop</h1>
        <p class="description">
          Discover timeless pieces designed with simplicity,
          comfort, and everyday elegance in mind.
        </p>
      </div>
    </section>


    <!-- ================= CONTROLS ================= -->
    <section class="shop-controls">
      <div class="categories">
        <button
          v-for="category in categories"
          :key="category.id || category"
          @click="selectedCategory = category.name || category"
          :class="['category-btn', { active: selectedCategory === (category.name || category) }]"
        >
          {{ category.name || category }}
        </button>
      </div>

      <div class="right-controls">
        <div class="search-box">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search products..."
          />
          <span>⌕</span>
        </div>

        <select v-model="sortBy" class="sort-select">
          <option value="featured">Featured</option>
          <option value="low">Price: Low to High</option>
          <option value="high">Price: High to Low</option>
          <option value="name">Name: A-Z</option>
        </select>
      </div>
    </section>


    <!-- ================= PRODUCT INFO ================= -->
    <div class="product-info">
      <span>{{ filteredProducts.length }} PRODUCTS</span>
      <span v-if="selectedCategory !== 'ALL'">{{ selectedCategory }}</span>
    </div>


    <!-- ================= PRODUCTS ================= -->
    <main class="product-section">
      <div v-if="filteredProducts.length > 0" class="product-grid">
        <article
          v-for="product in filteredProducts"
          :key="product.id"
          class="product-card"
        >
          <div class="product-image" @click="goToDetail(product.id)">
            <img
              :src="product?.images && product.images.length > 0 && product.images[0]?.image_path 
                ? '/storage/' + product.images[0].image_path 
                : (product?.image || '/images/placeholder.jpg')"
              :alt="product?.name || 'Product'"
            />

            <span v-if="product.discount_price || product.oldPrice" class="sale-label">
              SALE
            </span>

            <span v-if="(product.is_featured || product.featured) && !(product.discount_price || product.oldPrice)" class="featured-label">
              FEATURED
            </span>
          </div>

          <!-- DUA TOMBOL AKSI: ADD TO CART & DETAILS -->
          <div class="product-actions-bar">
            <button 
              class="action-btn add-btn" 
              @click="addToCart(product)" 
              :disabled="product.isSubmitting"
            >
              {{ product.isSubmitting ? '...' : '+ CART' }}
            </button>
            <button 
              class="action-btn detail-btn" 
              @click="goToDetail(product.id)"
            >
              DETAILS
            </button>
          </div>

          <div class="product-details" @click="goToDetail(product.id)" style="cursor: pointer;">
            <div class="product-category">
              {{ product.category?.name || product.category || 'General' }}
            </div>
            <h2>{{ product.name }}</h2>
            <div class="price">
              <span class="current-price">
                {{ formatRupiah(product.discount_price || product.price) }}
              </span>
              <span v-if="product.discount_price || product.oldPrice" class="old-price">
                {{ formatRupiah(product.oldPrice || product.price) }}
              </span>
            </div>
          </div>
        </article>
      </div>

      <div v-else class="empty-state">
        <div class="empty-icon">×</div>
        <h2>No products found</h2>
        <p>We couldn't find any products matching your search.</p>
        <button @click="resetFilter" class="reset-btn">
          VIEW ALL PRODUCTS
        </button>
      </div>
    </main>


    <!-- ================= EDITORIAL ================= -->
    <section class="editorial">
      <div class="editorial-content">
        <p class="small-title">PROVIDENTIAL ESSENTIALS</p>
        <h2>Less, but better.</h2>
        <p>
          Our collection is created for those who appreciate
          thoughtful details, clean silhouettes, and pieces
          that remain relevant beyond the season.
        </p>
        <router-link to="/about" class="editorial-link">
          OUR MISSION →
        </router-link>
      </div>
    </section>


    <!-- ================= FOOTER ================= -->
    <footer class="footer">
      <div class="footer-brand">PROVIDENTIAL</div>
      <div class="footer-links">
        <router-link to="/shop">SHOP</router-link>
        <router-link to="/about">OUR MISSION</router-link>
        <router-link to="/user">ACCOUNT</router-link>
      </div>
      <p>© 2026 PROVIDENTIAL. ALL RIGHTS RESERVED.</p>
    </footer>

  </div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const cartCount = ref(0)
const categories = ref(['ALL'])
const selectedCategory = ref('ALL')
const searchQuery = ref('')
const sortBy = ref('featured')
const products = ref([])

const fetchData = async () => {
  try {
    const prodRes = await axios.get('http://127.0.0.1:8000/api/public/produk')
    if (prodRes.data) {
      if (Array.isArray(prodRes.data)) {
        products.value = prodRes.data
      } else if (Array.isArray(prodRes.data.data)) {
        products.value = prodRes.data.data
      } else {
        products.value = []
      }
    }

    const catRes = await axios.get('http://127.0.0.1:8000/api/public/kategori')
    if (catRes.data) {
      const catData = Array.isArray(catRes.data) ? catRes.data : (catRes.data.data || [])
      categories.value = ['ALL', ...catData]
    }

    const token = localStorage.getItem('token')
    if (token) {
      const cartRes = await axios.get('http://127.0.0.1:8000/api/cart', { 
        headers: { 'Authorization': `Bearer ${token}` } 
      })
      if (cartRes.data?.status && cartRes.data?.data) {
        const itemsList = cartRes.data.data.items || cartRes.data.data.cart_items || []
        cartCount.value = itemsList.reduce((acc, item) => acc + item.quantity, 0)
      }
    }
  } catch (error) {
    console.error('Gagal mengambil data dari database:', error)
    products.value = []
  }
}

onMounted(() => {
  fetchData()
})

const filteredProducts = computed(() => {
  let result = [...products.value]

  if (selectedCategory.value !== 'ALL') {
    result = result.filter(product => {
      const catName = product.category?.name || product.category
      return catName === selectedCategory.value
    })
  }

  if (searchQuery.value.trim() !== '') {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(product =>
      product?.name?.toLowerCase().includes(query) ||
      (product?.category?.name || product?.category || '').toLowerCase().includes(query)
    )
  }

  if (sortBy.value === 'low') {
    result.sort((a, b) => (a.discount_price || a.price) - (b.discount_price || b.price))
  } else if (sortBy.value === 'high') {
    result.sort((a, b) => (b.discount_price || b.price) - (a.discount_price || a.price))
  } else if (sortBy.value === 'name') {
    result.sort((a, b) => (a.name || '').localeCompare(b.name || ''))
  } else if (sortBy.value === 'featured') {
    result.sort((a, b) => Number(b.is_featured || b.featured || 0) - Number(a.is_featured || a.featured || 0))
  }

  return result
})

const formatRupiah = (price) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(price || 0)
}

const goToDetail = (productId) => {
  router.push({ name: 'productdetail', query: { id: productId } })
}

const addToCart = async (product) => {
  if (product.isSubmitting) return
  product.isSubmitting = true

  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.')
      window.location.href = '/login'
      return
    }

    const payload = {
      product_id: product.id,
      quantity: 1,
      size: product.size || 'All Size',
      color: product.color || 'Default'
    }

    const response = await axios.post('http://127.0.0.1:8000/api/cart', payload, {
      headers: { 'Authorization': `Bearer ${token}` }
    })

    if (response.data.status) {
      const updatedItems = response.data.data.items || []
      cartCount.value = updatedItems.reduce((acc, item) => acc + item.quantity, 0)
      
      alert(`${product.name} berhasil ditambahkan ke keranjang.`)
    }
  } catch (error) {
    console.error('Gagal menambahkan ke keranjang:', error)
    alert(error.response?.data?.message || 'Terjadi kesalahan saat menambah ke keranjang.')
  } finally {
    product.isSubmitting = false
  }
}

const resetFilter = () => {
  selectedCategory.value = 'ALL'
  searchQuery.value = ''
  sortBy.value = 'featured'
}
</script>


<style scoped>
.shop-page { min-height: 100vh; background: #fff; color: #111; font-family: 'Inter', Arial, sans-serif; }
.navbar { height: 82px; padding: 0 50px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; position: sticky; top: 0; z-index: 100; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(10px); }
.nav-left, .nav-right { display: flex; align-items: center; gap: 28px; }
.nav-link { text-decoration: none; color: #111; font-size: 10px; letter-spacing: 1.8px; position: relative; transition: opacity 0.3s ease; }
.nav-link:hover { opacity: 0.5; }
.nav-link.active::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 100%; height: 1px; background: #111; }
.brand { color: #111; text-decoration: none; font-family: 'Playfair Display', Georgia, serif; font-size: 23px; letter-spacing: 5px; }
.cart-count { font-size: 9px; }

.shop-header { padding: 110px 50px 90px; border-bottom: 1px solid #ddd; }
.header-content { max-width: 800px; }
.small-title { font-size: 10px; letter-spacing: 3px; margin-bottom: 22px; }
.shop-header h1 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: clamp(55px, 8vw, 105px); font-weight: 400; line-height: 0.95; }
.description { max-width: 520px; margin-top: 30px; color: #777; font-size: 14px; line-height: 1.8; }

.shop-controls { padding: 25px 50px; display: flex; justify-content: space-between; align-items: center; gap: 30px; border-bottom: 1px solid #ddd; }
.categories { display: flex; gap: 8px; flex-wrap: wrap; }
.category-btn { border: 1px solid #ddd; background: #fff; padding: 10px 17px; font-size: 9px; letter-spacing: 1.3px; cursor: pointer; transition: all 0.25s ease; }
.category-btn:hover { border-color: #111; }
.category-btn.active { background: #111; color: #fff; border-color: #111; }
.right-controls { display: flex; align-items: center; gap: 15px; }

.search-box { width: 190px; display: flex; align-items: center; border-bottom: 1px solid #aaa; padding: 8px 0; }
.search-box input { width: 100%; border: none; outline: none; background: transparent; font-size: 11px; color: #111; }
.search-box input::placeholder { color: #999; }
.search-box span { font-size: 18px; color: #555; }
.sort-select { border: 1px solid #ddd; background: #fff; padding: 10px 12px; font-size: 10px; outline: none; cursor: pointer; }

.product-info { padding: 22px 50px; display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; font-size: 9px; letter-spacing: 1.5px; color: #777; }
.product-section { padding: 45px 50px 100px; }
.product-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 35px 20px; }

.product-card { min-width: 0; }
.product-image { position: relative; aspect-ratio: 0.78; overflow: hidden; background: #f2f2f2; cursor: pointer; }
.product-image img { width: 100%; height: 100%; display: block; object-fit: cover; transition: transform 0.6s ease; }
.product-card:hover .product-image img { transform: scale(1.04); }

.sale-label, .featured-label { position: absolute; top: 14px; left: 14px; padding: 7px 10px; background: #fff; font-size: 8px; letter-spacing: 1.3px; }
.featured-label { background: #111; color: #fff; }

/* Tombol Aksi Ganda (Add Cart & Details) */
.product-actions-bar {
  display: flex;
  gap: 5px;
  margin-top: 12px;
}
.action-btn {
  flex: 1;
  border: 1px solid #111;
  padding: 10px 5px;
  font-size: 8px;
  letter-spacing: 1.2px;
  cursor: pointer;
  transition: all 0.25s ease;
  text-align: center;
}
.add-btn { background: #111; color: #fff; }
.add-btn:hover { background: #333; }
.add-btn:disabled { background: #777; border-color: #777; cursor: not-allowed; }
.detail-btn { background: #fff; color: #111; }
.detail-btn:hover { background: #f4f4f4; }

.product-details { padding-top: 12px; }
.product-category { color: #999; font-size: 8px; letter-spacing: 1.5px; margin-bottom: 8px; }
.product-details h2 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 17px; font-weight: 400; }
.price { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
.current-price { font-size: 12px; }
.old-price { color: #999; font-size: 11px; text-decoration: line-through; }

.empty-state { min-height: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
.empty-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; border-radius: 50%; font-size: 22px; margin-bottom: 25px; }
.empty-state h2 { font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 400; margin: 0; }
.empty-state p { color: #777; font-size: 13px; margin: 12px 0 25px; }
.reset-btn { border: 1px solid #111; background: #111; color: #fff; padding: 14px 22px; font-size: 9px; letter-spacing: 1.5px; cursor: pointer; }

.editorial { min-height: 470px; background: #111; color: #fff; display: flex; align-items: center; padding: 80px 50px; }
.editorial-content { max-width: 620px; }
.editorial .small-title { color: #aaa; }
.editorial h2 { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(45px, 6vw, 80px); font-weight: 400; line-height: 1; margin: 0 0 30px; }
.editorial p:not(.small-title) { color: #aaa; max-width: 500px; font-size: 13px; line-height: 1.9; margin-bottom: 30px; }
.editorial-link { color: #fff; text-decoration: none; font-size: 9px; letter-spacing: 2px; border-bottom: 1px solid #fff; padding-bottom: 7px; }

.footer { background: #fff; border-top: 1px solid #ddd; padding: 45px 50px; display: flex; justify-content: space-between; align-items: center; gap: 30px; }
.footer-brand { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; letter-spacing: 3px; }
.footer-links { display: flex; gap: 25px; }
.footer-links a { color: #111; text-decoration: none; font-size: 9px; letter-spacing: 1.5px; }
.footer p { color: #999; font-size: 8px; letter-spacing: 1px; margin: 0; }

@media (max-width: 1100px) {
  .product-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 850px) {
  .navbar { padding: 0 25px; }
  .nav-left, .nav-right { gap: 15px; }
  .brand { font-size: 18px; letter-spacing: 3px; }
  .shop-header { padding: 80px 25px; }
  .shop-controls { padding: 20px 25px; flex-direction: column; align-items: stretch; }
  .right-controls { justify-content: space-between; }
  .search-box { width: 100%; }
  .product-info { padding: 20px 25px; }
  .product-section { padding: 35px 25px 80px; }
  .product-grid { grid-template-columns: repeat(2, 1fr); gap: 30px 15px; }
  .editorial { padding: 70px 25px; }
  .footer { padding: 40px 25px; flex-direction: column; align-items: flex-start; }
}

@media (max-width: 550px) {
  .navbar { height: auto; padding: 20px; flex-wrap: wrap; gap: 20px; }
  .brand { order: -1; width: 100%; text-align: center; }
  .nav-left, .nav-right { width: 100%; justify-content: center; }
  .nav-link { font-size: 8px; }
  .shop-header { padding: 60px 20px; }
  .shop-controls { padding: 20px; }
  .categories { gap: 5px; }
  .category-btn { padding: 8px 11px; }
  .right-controls { flex-direction: column; align-items: stretch; }
  .sort-select { width: 100%; }
  .product-info { padding: 18px 20px; }
  .product-section { padding: 30px 20px 70px; }
  .product-grid { grid-template-columns: repeat(2, 1fr); gap: 25px 10px; }
  .product-details h2 { font-size: 14px; }
  .current-price { font-size: 10px; }
  .old-price { font-size: 9px; }
  .editorial { min-height: 400px; }
  .footer-links { flex-wrap: wrap; }
}
</style>