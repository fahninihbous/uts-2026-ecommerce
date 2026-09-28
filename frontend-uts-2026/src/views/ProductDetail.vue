<template>
  <div class="product-detail-page">

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">
      <div class="nav-left">
        <router-link to="/shop" class="nav-link">SHOP</router-link>
        <router-link to="/about" class="nav-link">OUR MISSION</router-link>
      </div>

      <router-link to="/home" class="brand">
        PROVIDENTIAL
      </router-link>

      <div class="nav-right">
        <router-link to="/home" class="nav-link">SEARCH</router-link>
        <router-link to="/cart" class="nav-link">
          CART <span class="cart-count">({{ cartCount }})</span>
        </router-link>
        <router-link to="/user" class="nav-link">ACCOUNT</router-link>
      </div>
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="main-container" v-if="product">
      <div class="breadcrumb">
        <router-link to="/shop">SHOP</router-link> / 
        <span>{{ product.category?.name || product.category || 'GENERAL' }}</span> / 
        <span class="current">{{ product.name }}</span>
      </div>

      <div class="product-grid-detail">
        <!-- Galeri Gambar -->
        <div class="product-gallery">
          <div 
            v-for="(img, idx) in (product.images?.length ? product.images : [{image_path: product.image}])" 
            :key="idx" 
            class="gallery-item"
          >
            <img 
              :src="img.image_path && !img.image_path.startsWith('http') ? '/storage/' + img.image_path : (img.image_path || img)" 
              :alt="product.name" 
            />
          </div>
        </div>

        <!-- Informasi & Opsi Pembelian -->
        <div class="product-info-sidebar">
          <div class="cat-tag">{{ product.category?.name || product.category || 'Essentials' }}</div>
          <h1>{{ product.name }}</h1>
          
          <div class="price-box">
            <span class="current-price">{{ formatRupiah(product.discount_price || product.price) }}</span>
            <span v-if="product.discount_price || product.oldPrice" class="old-price">
              {{ formatRupiah(product.oldPrice || product.price) }}
            </span>
          </div>

          <p class="product-description">{{ product.description || 'Crafted with precision and premium materials to ensure timeless comfort and effortless elegance.' }}</p>

          <!-- Pilihan Ukuran -->
          <div class="option-group" v-if="sizes.length > 0">
            <label>SIZE: <span class="selected-label">{{ selectedSize }}</span></label>
            <div class="size-options">
              <button 
                v-for="size in sizes" 
                :key="size" 
                @click="selectedSize = size"
                :class="['size-btn', { active: selectedSize === size }]"
              >
                {{ size }}
              </button>
            </div>
          </div>

          <!-- Pilihan Warna -->
          <div class="option-group" v-if="colors.length > 0">
            <label>COLOR: <span class="selected-label">{{ selectedColor }}</span></label>
            <div class="color-options">
              <button 
                v-for="color in colors" 
                :key="color" 
                @click="selectedColor = color"
                :class="['color-btn', { active: selectedColor === color }]"
              >
                {{ color }}
              </button>
            </div>
          </div>

          <!-- Kuantitas & Tombol Add to Cart -->
          <div class="purchase-actions">
            <div class="quantity-selector">
              <button @click="decreaseQty">-</button>
              <span>{{ quantity }}</span>
              <button @click="increaseQty">+</button>
            </div>
            <button class="add-to-cart-btn" @click="addToCart" :disabled="isSubmitting">
              {{ isSubmitting ? 'ADDING...' : 'ADD TO CART' }}
            </button>
          </div>

          <!-- Detail Tambahan (Accordion sederhana) -->
          <div class="meta-accordion">
            <div class="accordion-item">
              <h3>DETAILS & FIT</h3>
              <p>Designed for a relaxed, contemporary silhouette. True to size. Take your normal size for an effortless drape.</p>
            </div>
            <div class="accordion-item">
              <h3>SHIPPING & RETURNS</h3>
              <p>Complimentary standard shipping on all orders over IDR 1,000,000. Returns accepted within 14 days of delivery.</p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div v-else class="loading-state">
      <p>Loading product details...</p>
    </div>

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
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const product = ref(null)
const cartCount = ref(0)
const quantity = ref(1)
const selectedSize = ref('All Size')
const selectedColor = ref('Default')
const sizes = ref(['S', 'M', 'L', 'XL'])
const colors = ref(['Black', 'White', 'Charcoal'])
const isSubmitting = ref(false)

const fetchProductDetail = async () => {
  const productId = route.query.id
  if (!productId) return

  try {
    const res = await axios.get(`http://127.0.0.1:8000/api/public/produk/${productId}`)
    if (res.data) {
      product.value = res.data.data || res.data
    }
  } catch (error) {
    console.error('Gagal memuat detail produk:', error)
  }
}

const formatRupiah = (price) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(price || 0)
}

const increaseQty = () => { quantity.value++ }
const decreaseQty = () => { if (quantity.value > 1) quantity.value-- }

const addToCart = async () => {
  if (isSubmitting.value) return
  isSubmitting.value = true

  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Silakan login terlebih dahulu.')
      router.push('/login')
      return
    }

    const payload = {
      product_id: product.value.id,
      quantity: quantity.value,
      size: selectedSize.value,
      color: selectedColor.value
    }

    const res = await axios.post('http://127.0.0.1:8000/api/cart', payload, {
      headers: { 'Authorization': `Bearer ${token}` }
    })

    if (res.data.status) {
      alert('Produk berhasil ditambahkan ke keranjang.')
    }
  } catch (error) {
    console.error(error)
    alert('Gagal menambahkan ke keranjang.')
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  fetchProductDetail()
})
</script>

<style scoped>
.product-detail-page { min-height: 100vh; background: #fff; color: #111; font-family: 'Inter', Arial, sans-serif; }
.navbar { height: 82px; padding: 0 50px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; position: sticky; top: 0; z-index: 100; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(10px); }
.nav-left, .nav-right { display: flex; align-items: center; gap: 28px; }
.nav-link { text-decoration: none; color: #111; font-size: 10px; letter-spacing: 1.8px; }
.brand { color: #111; text-decoration: none; font-family: 'Playfair Display', Georgia, serif; font-size: 23px; letter-spacing: 5px; }

.main-container { padding: 40px 50px 100px; max-width: 1400px; margin: 0 auto; }
.breadcrumb { font-size: 9px; letter-spacing: 1.5px; color: #888; margin-bottom: 40px; }
.breadcrumb a { color: #888; text-decoration: none; }
.breadcrumb .current { color: #111; }

.product-grid-detail { display: grid; grid-template-columns: 1fr 450px; gap: 60px; align-items: start; }
.product-gallery { display: flex; flex-direction: column; gap: 20px; }
.gallery-item { width: 100%; background: #f2f2f2; aspect-ratio: 0.82; overflow: hidden; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

.product-info-sidebar { position: sticky; top: 120px; }
.cat-tag { font-size: 9px; letter-spacing: 2px; color: #888; margin-bottom: 12px; }
.product-info-sidebar h1 { font-family: 'Playfair Display', Georgia, serif; font-size: 36px; font-weight: 400; margin: 0 0 20px; }
.price-box { display: flex; gap: 15px; align-items: center; margin-bottom: 25px; }
.current-price { font-size: 16px; font-weight: 500; }
.old-price { font-size: 14px; color: #999; text-decoration: line-through; }
.product-description { font-size: 13px; line-height: 1.8; color: #666; margin-bottom: 30px; }

.option-group { margin-bottom: 25px; }
.option-group label { display: block; font-size: 9px; letter-spacing: 1.5px; margin-bottom: 10px; }
.selected-label { font-weight: bold; color: #111; }
.size-options, .color-options { display: flex; gap: 10px; }
.size-btn, .color-btn { border: 1px solid #ddd; background: #fff; padding: 10px 16px; font-size: 9px; letter-spacing: 1px; cursor: pointer; transition: all 0.2s; }
.size-btn.active, .color-btn.active { border-color: #111; background: #111; color: #fff; }

.purchase-actions { display: flex; gap: 15px; margin: 35px 0; }
.quantity-selector { display: flex; align-items: center; border: 1px solid #ddd; }
.quantity-selector button { background: none; border: none; padding: 12px 16px; cursor: pointer; font-size: 12px; }
.quantity-selector span { padding: 0 10px; font-size: 11px; }
.add-to-cart-btn { flex: 1; background: #111; color: #fff; border: 1px solid #111; font-size: 9px; letter-spacing: 2px; cursor: pointer; transition: background 0.2s; }
.add-to-cart-btn:hover { background: #333; }

.meta-accordion { border-top: 1px solid #ddd; margin-top: 40px; }
.accordion-item { padding: 20px 0; border-bottom: 1px solid #ddd; }
.accordion-item h3 { font-size: 9px; letter-spacing: 1.8px; margin: 0 0 8px; }
.accordion-item p { font-size: 12px; color: #777; line-height: 1.7; margin: 0; }

.loading-state { min-height: 50vh; display: flex; align-items: center; justify-content: center; font-size: 10px; letter-spacing: 2px; }

.footer { background: #fff; border-top: 1px solid #ddd; padding: 45px 50px; display: flex; justify-content: space-between; align-items: center; }
.footer-brand { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; letter-spacing: 3px; }
.footer-links { display: flex; gap: 25px; }
.footer-links a { color: #111; text-decoration: none; font-size: 9px; letter-spacing: 1.5px; }
.footer p { color: #999; font-size: 8px; letter-spacing: 1px; margin: 0; }

@media (max-width: 950px) {
  .product-grid-detail { grid-template-columns: 1fr; gap: 40px; }
  .product-info-sidebar { position: static; }
  .main-container { padding: 30px 20px; }
  .navbar { padding: 0 20px; }
}
</style>