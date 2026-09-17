<template>
  <div class="product-page">

    <!-- ================= HEADER ================= -->
    <header class="header">
      <div class="header-inner">

        <!-- LEFT NAV -->
        <nav class="left-nav">
          <router-link to="/shop">SHOP</router-link>
          <router-link to="/about">OUR MISSION</router-link>
        </nav>

        <!-- LOGO -->
        <router-link to="/home" class="logo">
          PROVIDENTIAL
        </router-link>

        <!-- RIGHT NAV -->
        <div class="right-nav">

          <!-- Search -->
          <router-link to="/home" class="icon-button">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="21"
              height="21"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <circle cx="11" cy="11" r="7"></circle>
              <path d="m20 20-4-4"></path>
            </svg>
          </router-link>

          <!-- Cart -->
          <router-link to="/cart" class="icon-button cart-icon">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="22"
              height="22"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <path d="M6 6h15l-1.5 9h-12z"></path>
              <path d="M6 6 5 3H2"></path>
              <circle cx="9" cy="20" r="1"></circle>
              <circle cx="18" cy="20" r="1"></circle>
            </svg>

            <span class="cart-count">
              {{ cartCount }}
            </span>
          </router-link>

          <!-- Profile -->
          <router-link to="/user" class="icon-button">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="21"
              height="21"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <circle cx="12" cy="8" r="3"></circle>
              <path d="M5 21c0-3.5 3-6 7-6s7 2.5 7 6"></path>
            </svg>
          </router-link>

        </div>
      </div>
    </header>


    <!-- ================= PRODUCT DETAIL ================= -->
    <main class="product-container">

      <!-- BACK -->
      <router-link to="/shop" class="back-link">
        ← Back to Shop
      </router-link>

      <section class="product-detail" v-if="product">

        <!-- LEFT : PRODUCT IMAGE DISPLAY -->
        <div class="product-display">
          <div class="product-image-container">
            <img 
              :src="product?.images && product.images.length > 0 && product.images[0]?.image_path 
                ? '/storage/' + product.images[0].image_path 
                : (product?.image || '/images/placeholder.jpg')" 
              :alt="product.name" 
            />
          </div>
        </div>


        <!-- RIGHT : PRODUCT INFORMATION -->
        <div class="product-info">

          <p class="product-category">
            {{ product.category?.name || product.category || 'APPAREL' }}
          </p>

          <h1>
            {{ product.name }}
          </h1>

          <p class="price">
            {{ formatRupiah(product.discount_price || product.price) }}
          </p>

          <div class="line"></div>

          <p class="description">
            {{ product.description || 'A timeless piece designed with simplicity, comfort, and effortless elegance in mind.' }}
          </p>


          <!-- PRODUCT INFORMATION -->
          <div class="information">

            <div class="info-row">
              <span>Material</span>
              <strong>{{ product.material || 'Premium Quality' }}</strong>
            </div>

            <div class="info-row">
              <span>Color</span>
              <strong>{{ product.color || 'Default' }}</strong>
            </div>

            <div class="info-row">
              <span>Availability</span>
              <strong>{{ product.stock > 0 ? 'In Stock (' + product.stock + ')' : 'Out of Stock' }}</strong>
            </div>

          </div>


          <!-- QUANTITY -->
          <div class="quantity-section">

            <p>QUANTITY</p>

            <div class="quantity">

              <button @click="decreaseQuantity">
                −
              </button>

              <span>
                {{ quantity }}
              </span>

              <button @click="increaseQuantity">
                +
              </button>

            </div>

          </div>


          <!-- BUTTONS -->
          <div class="buttons">

            <button
              class="add-button"
              @click="addToCart"
              :disabled="isSubmitting || product.stock <= 0"
            >
              {{ isSubmitting ? 'PROCESSING...' : 'ADD TO CART' }}
            </button>

            <button
              class="buy-button"
              @click="buyNow"
              :disabled="isSubmitting || product.stock <= 0"
            >
              BUY IT NOW
            </button>

          </div>


          <p class="shipping-info">
            Free shipping on orders over IDR 500.000
          </p>

        </div>

      </section>

      <!-- LOADING / NOT FOUND STATE -->
      <div v-else class="empty-state">
        <h2>Loading product details...</h2>
      </div>


      <!-- ================= PRODUCT DESCRIPTION ================= -->
      <section class="bottom-description">

        <div class="description-column">

          <p class="section-label">
            ABOUT THE PRODUCT
          </p>

          <h2>
            Simple pieces.
            <br>
            Timeless style.
          </h2>

        </div>

        <div class="description-text">

          <p>
            Providential is designed for those who appreciate
            simplicity and quality. Every piece is created to
            provide comfort while maintaining an elegant and
            timeless appearance.
          </p>

          <p>
            Our collection focuses on carefully selected
            materials, clean silhouettes, and versatile designs
            that can be worn season after season.
          </p>

        </div>

      </section>

    </main>


    <!-- ================= FOOTER ================= -->
    <footer class="footer">

      <div class="footer-logo">
        PROVIDENTIAL
      </div>

      <p>
        Spreading comfort & style.
      </p>

      <div class="footer-line"></div>

      <span>
        © 2026 Providential. All rights reserved.
      </span>

    </footer>


    <!-- SUPPORT -->
    <button class="support-button">
      ◉ &nbsp; Support
    </button>

  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const product = ref(null)
const quantity = ref(1)
const cartCount = ref(0)
const isSubmitting = ref(false)

// Ambil data produk berdasarkan ID dari query URL (?id=...) atau route parameter
const fetchProductDetail = async () => {
  try {
    const productId = route.query.id || route.params.id
    if (!productId) {
      router.push('/shop')
      return
    }

    const response = await axios.get(`http://127.0.0.1:8000/api/public/produk`)
    if (response.data) {
      const items = Array.isArray(response.data) ? response.data : (response.data.data || [])
      product.value = items.find(p => p.id == productId) || null
    }

    // Ambil jumlah keranjang user jika sudah login
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
    console.error('Gagal memuat detail produk:', error)
  }
}

onMounted(() => {
  fetchProductDetail()
})

// Format Rupiah
const formatRupiah = (price) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(price || 0)
}

// Increase quantity
const increaseQuantity = () => {
  quantity.value++
}

// Decrease quantity
const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

// Tombol Add to Cart (Memunculkan notifikasi sukses)
const addToCart = async () => {
  if (isSubmitting.value || !product.value) return
  isSubmitting.value = true

  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.')
      router.push('/login')
      return
    }

    const payload = {
      product_id: product.value.id,
      quantity: quantity.value,
      size: product.value.size || 'All Size',
      color: product.value.color || 'Default'
    }

    const response = await axios.post('http://127.0.0.1:8000/api/cart', payload, {
      headers: { 'Authorization': `Bearer ${token}` }
    })

    if (response.data.status) {
      const updatedItems = response.data.data.items || response.data.data.cart_items || []
      cartCount.value = updatedItems.reduce((acc, item) => acc + item.quantity, 0)
      
      alert(`${product.value.name} berhasil ditambahkan ke keranjang.`)
    }
  } catch (error) {
    console.error('Gagal menambahkan ke keranjang:', error)
    alert(error.response?.data?.message || 'Terjadi kesalahan saat menambah ke keranjang.')
  } finally {
    isSubmitting.value = false
  }
}

// Tombol Buy It Now (Langsung senyap masuk database TANPA alert keranjang, lalu pindah ke checkout)
const buyNow = async () => {
  if (isSubmitting.value || !product.value) return
  isSubmitting.value = true

  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Silakan login terlebih dahulu untuk melakukan pembelian.')
      router.push('/login')
      return
    }

    const payload = {
      product_id: product.value.id,
      quantity: quantity.value,
      size: product.value.size || 'All Size',
      color: product.value.color || 'Default'
    }

    // Kirim data ke backend secara senyap
    const response = await axios.post('http://127.0.0.1:8000/api/cart', payload, {
      headers: { 'Authorization': `Bearer ${token}` }
    })

    if (response.data.status) {
      const updatedItems = response.data.data.items || response.data.data.cart_items || []
      cartCount.value = updatedItems.reduce((acc, item) => acc + item.quantity, 0)
      
      // Langsung navigasi ke halaman checkout tanpa memunculkan alert keranjang
      router.push('/checkout')
    }
  } catch (error) {
    console.error('Gagal memproses Buy Now:', error)
    alert(error.response?.data?.message || 'Terjadi kesalahan saat memproses pembelian.')
  } finally {
    isSubmitting.value = false
  }
}
</script>


<style scoped>
* { box-sizing: border-box; }
.product-page { min-height: 100vh; background: #ffffff; color: #111827; font-family: Georgia, "Times New Roman", serif; }

.header { height: 74px; background: #ffffff; position: relative; z-index: 10; border-bottom: 1px solid #e2e8f0; }
.header-inner { height: 100%; padding: 0 44px; display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; }

.left-nav { display: flex; align-items: center; gap: 28px; }
.left-nav a { color: #0f172a; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1.2px; transition: opacity 0.2s ease; }
.left-nav a:hover { opacity: 0.55; }

.logo { color: #0f172a; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 30px; font-weight: 700; letter-spacing: 4px; }

.right-nav { justify-self: end; display: flex; align-items: center; gap: 21px; }
.icon-button { border: none; background: transparent; color: #0f172a; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; }
.cart-icon { position: relative; }
.cart-count { position: absolute; top: -9px; right: -8px; width: 15px; height: 15px; border-radius: 50%; background: #111827; color: #ffffff; font-family: Arial, sans-serif; font-size: 9px; font-weight: 700; display: flex; align-items: center; justify-content: center; }

.product-container { max-width: 1400px; margin: auto; padding: 70px 58px 120px; }
.back-link { display: inline-block; margin-bottom: 50px; color: #475569; font-family: Arial, sans-serif; font-size: 12px; text-decoration: none; }
.back-link:hover { color: #111827; }

.product-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 100px; align-items: start; }
.product-display { width: 100%; }
.product-image-container { height: 650px; background: #f1f3f5; overflow: hidden; display: flex; align-items: center; justify-content: center; }
.product-image-container img { width: 100%; height: 100%; object-fit: cover; }

.product-info { padding-top: 30px; max-width: 520px; }
.product-category { margin: 0 0 18px; font-family: Arial, sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #64748b; }
.product-info h1 { margin: 0; font-size: clamp(36px, 4vw, 55px); line-height: 1.1; font-weight: 400; }
.price { margin: 25px 0; font-family: Arial, sans-serif; font-size: 18px; font-weight: bold; color: #334155; }
.line { width: 100%; height: 1px; background: #cbd5e1; margin: 30px 0; }
.description { font-family: Arial, sans-serif; font-size: 14px; line-height: 1.8; color: #64748b; margin-bottom: 15px; }

.information { margin-top: 35px; border-top: 1px solid #e2e8f0; }
.info-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e2e8f0; font-family: Arial, sans-serif; font-size: 12px; }
.info-row span { color: #64748b; }
.info-row strong { font-weight: 500; color: #111827; }

.quantity-section { margin-top: 30px; }
.quantity-section p { margin-bottom: 10px; font-family: Arial, sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; color: #64748b; }
.quantity { width: 110px; height: 42px; border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: space-between; }
.quantity button { width: 35px; height: 100%; border: none; background: transparent; cursor: pointer; font-size: 18px; color: #334155; }
.quantity span { font-family: Arial, sans-serif; font-size: 13px; }

.buttons { margin-top: 30px; display: flex; flex-direction: column; gap: 10px; }
.add-button, .buy-button { width: 100%; height: 55px; font-family: Arial, sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1px; cursor: pointer; transition: 0.2s; }
.add-button { background: #111827; color: white; border: 1px solid #111827; }
.add-button:hover { background: #334155; }
.add-button:disabled { background: #94a3b8; border-color: #94a3b8; cursor: not-allowed; }
.buy-button { background: white; color: #111827; border: 1px solid #111827; }
.buy-button:hover { background: #f1f3f5; }
.buy-button:disabled { background: #f1f3f5; color: #94a3b8; cursor: not-allowed; }

.shipping-info { margin-top: 18px; text-align: center; font-family: Arial, sans-serif; font-size: 10px; color: #64748b; }

.bottom-description { margin-top: 140px; padding-top: 70px; border-top: 1px solid #e2e8f0; display: grid; grid-template-columns: 1fr 1fr; gap: 100px; }
.section-label { margin: 0 0 20px; font-family: Arial, sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #64748b; }
.description-column h2 { margin: 0; font-size: 45px; line-height: 1; font-weight: 400; letter-spacing: -1px; }
.description-text { max-width: 500px; }
.description-text p { margin: 0 0 20px; font-family: Arial, sans-serif; font-size: 14px; line-height: 1.9; color: #64748b; }

.footer { padding: 70px 58px 35px; background: #f1f3f5; text-align: center; }
.footer-logo { font-family: Arial, sans-serif; font-size: 23px; font-weight: 700; letter-spacing: 3px; }
.footer p { margin: 12px 0 35px; font-size: 13px; color: #64748b; }
.footer-line { max-width: 1300px; height: 1px; background: #cbd5e1; margin: auto auto 25px; }
.footer span { font-family: Arial, sans-serif; font-size: 10px; color: #64748b; }

.support-button { position: fixed; right: 16px; bottom: 12px; border: none; border-radius: 20px; background: #334155; color: white; padding: 10px 17px; font-family: Arial, sans-serif; font-size: 12px; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15); cursor: pointer; }

@media (max-width: 900px) {
  .product-detail { grid-template-columns: 1fr; gap: 50px; }
  .product-image-container { height: 450px; }
  .product-info { max-width: none; }
  .bottom-description { grid-template-columns: 1fr; gap: 40px; }
}

@media (max-width: 600px) {
  .header-inner { padding: 0 20px; }
  .left-nav { gap: 12px; }
  .logo { font-size: 19px; letter-spacing: 2px; }
  .product-container { padding: 50px 22px 80px; }
  .product-image-container { height: 350px; }
  .bottom-description { margin-top: 90px; }
}
</style>