<template>
  <div class="checkout-page">

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
          CART <span class="cart-count">({{ cartItems.length }})</span>
        </router-link>
        <router-link to="/user" class="nav-link">ACCOUNT</router-link>
      </div>
    </header>


    <!-- ================= MAIN CONTAINER ================= -->
    <main class="checkout-container">
      <div class="checkout-header-title">
        <p class="small-title">SECURE CHECKOUT</p>
        <h1>Checkout</h1>
      </div>

      <div class="checkout-layout">
        
        <!-- KOLOM KIRI: FORM PENGIRIMAN & PEMBAYARAN -->
        <form @submit.prevent="handleCheckout" class="checkout-form">
          
          <!-- Informasi Pengiriman -->
          <div class="form-section">
            <h2>1. Shipping Information</h2>
            
            <div class="form-group">
              <label>Full Name (Penerima)</label>
              <input v-model="form.name" type="text" placeholder="Justin Mason" required />
            </div>

            <div class="form-grid">
              <div class="form-group">
                <label>Email Address</label>
                <input v-model="form.email" type="email" placeholder="justin@example.com" required />
              </div>
              <div class="form-group">
                <label>Phone Number (WhatsApp)</label>
                <input v-model="form.phone" type="tel" placeholder="+62 812-3456-7890" required />
              </div>
            </div>

            <div class="form-group">
              <label>Street Address</label>
              <input v-model="form.address" type="text" placeholder="Jl. Sudirman No. 45, Senayan" required />
            </div>

            <div class="form-grid-3">
              <div class="form-group">
                <label>City</label>
                <input v-model="form.city" type="text" placeholder="Jakarta Selatan" required />
              </div>
              <div class="form-group">
                <label>State / Province</label>
                <input v-model="form.state" type="text" placeholder="DKI Jakarta" required />
              </div>
              <div class="form-group">
                <label>Postal Code</label>
                <input v-model="form.postal_code" type="text" placeholder="12190" required />
              </div>
            </div>
          </div>

          <!-- Metode Pembayaran -->
          <div class="form-section">
            <h2>2. Payment Method</h2>
            
            <div class="payment-options">
              <label :class="['payment-card', { active: form.payment_method === 'transfer' }]">
                <input type="radio" v-model="form.payment_method" value="transfer" />
                <div class="payment-info">
                  <span class="payment-title">Bank Transfer / Virtual Account</span>
                  <span class="payment-desc">BCA, Mandiri, BNI, BRI</span>
                </div>
              </label>

              <label :class="['payment-card', { active: form.payment_method === 'qris' }]">
                <input type="radio" v-model="form.payment_method" value="qris" />
                <div class="payment-info">
                  <span class="payment-title">QRIS</span>
                  <span class="payment-desc">Scan via GoPay, OVO, DANA, BCA Mobile</span>
                </div>
              </label>

              <label :class="['payment-card', { active: form.payment_method === 'cod' }]">
                <input type="radio" v-model="form.payment_method" value="cod" />
                <div class="payment-info">
                  <span class="payment-title">Cash on Delivery (COD)</span>
                  <span class="payment-desc">Bayar saat pesanan sampai di tempat</span>
                </div>
              </label>
            </div>
          </div>

          <button type="submit" class="place-order-btn" :disabled="isSubmitting || cartItems.length === 0">
            {{ isSubmitting ? 'PROCESSING...' : 'PLACE ORDER' }}
          </button>
        </form>

        <!-- KOLOM KANAN: RINGKASAN PESANAN -->
        <div class="order-summary-box">
          <h2>Order Summary</h2>
          
          <div class="summary-items-list">
            <div v-for="item in cartItems" :key="item.id" class="summary-item">
              <div class="summary-item-img">
                <img :src="item.product?.images?.[0]?.image_path ? '/storage/' + item.product.images[0].image_path : '/images/placeholder.jpg'" :alt="item.product?.name" />
                <span class="item-qty-badge">{{ item.quantity }}</span>
              </div>
              <div class="summary-item-detail">
                <h4>{{ item.product?.name }}</h4>
                <p>{{ item.size }} / {{ item.color }}</p>
              </div>
              <div class="summary-item-price">
                {{ formatRupiah((item.product?.discount_price || item.product?.price || 0) * item.quantity) }}
              </div>
            </div>
          </div>

          <div class="summary-totals">
            <div class="summary-row">
              <span>Subtotal</span>
              <span>{{ formatRupiah(subtotal) }}</span>
            </div>
            <div class="summary-row">
              <span>Shipping Cost</span>
              <span>{{ formatRupiah(shippingCost) }}</span>
            </div>
            <div class="summary-row total">
              <span>Total Payment</span>
              <span>{{ formatRupiah(subtotal + shippingCost) }}</span>
            </div>
          </div>

          <div class="secure-notice">
            <span>🔒</span> Secure & Encrypted Checkout
          </div>
        </div>

      </div>
    </main>


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
const cartItems = ref([])
const shippingCost = ref(25000)
const isSubmitting = ref(false)

const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  postal_code: '',
  payment_method: 'transfer'
})

const fetchCart = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      router.push('/login')
      return
    }
    const res = await axios.get('http://127.0.0.1:8000/api/cart', {
      headers: { 'Authorization': `Bearer ${token}` }
    })
    if (res.data?.status && res.data?.data) {
      cartItems.value = res.data.data.items || res.data.data.cart_items || []
    }
  } catch (err) {
    console.error('Gagal mengambil data keranjang:', err)
  }
}

const subtotal = computed(() => {
  return cartItems.value.reduce((acc, item) => {
    const price = item.product?.discount_price || item.product?.price || 0
    return acc + (price * item.quantity)
  }, 0)
})

const formatRupiah = (val) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val)
}

const handleCheckout = async () => {
  if (isSubmitting.value) return
  isSubmitting.value = true

  try {
    const token = localStorage.getItem('token')
    
    const payload = {
      ...form.value,
      shipping_cost: shippingCost.value,
      total_amount: subtotal.value + shippingCost.value,
      items: cartItems.value
    }

    // Menggunakan endpoint /api/pesanan sesuai rute backend Laravel Anda
    const res = await axios.post('/api/pesanan', payload, {
  headers: { 'Authorization': `Bearer ${token}` }
})

    if (res.data?.status) {
      alert('Pesanan berhasil dibuat!')
      router.push('/user')
    } else {
      alert(res.data?.message || 'Gagal memproses pesanan.')
    }
  } catch (error) {
    console.error('Error checkout:', error)
    alert(error.response?.data?.message || 'Terjadi kesalahan pada sistem checkout.')
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  fetchCart()
})
</script>

<style scoped>
.checkout-page { min-height: 100vh; background: #fff; color: #111; font-family: 'Inter', Arial, sans-serif; }

/* Navbar */
.navbar { height: 82px; padding: 0 50px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; position: sticky; top: 0; z-index: 100; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(10px); }
.nav-left, .nav-right { display: flex; align-items: center; gap: 28px; }
.nav-link { text-decoration: none; color: #111; font-size: 10px; letter-spacing: 1.8px; }
.brand { color: #111; text-decoration: none; font-family: 'Playfair Display', Georgia, serif; font-size: 23px; letter-spacing: 5px; }

/* Layout */
.checkout-container { padding: 60px 50px 100px; max-width: 1300px; margin: 0 auto; }
.checkout-header-title { margin-bottom: 40px; }
.small-title { font-size: 9px; letter-spacing: 3px; margin-bottom: 12px; color: #777; }
.checkout-header-title h1 { font-family: 'Playfair Display', Georgia, serif; font-size: 45px; font-weight: 400; margin: 0; }

.checkout-layout { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 60px; align-items: start; }

/* Form Styles */
.form-section { margin-bottom: 40px; }
.form-section h2 { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; font-weight: 400; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 9px; letter-spacing: 1.5px; margin-bottom: 8px; color: #555; }
.form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; background: #fff; font-size: 11px; outline: none; transition: border-color 0.2s; }
.form-group input:focus { border-color: #111; }

/* Payment Methods */
.payment-options { display: flex; flex-direction: column; gap: 12px; }
.payment-card { display: flex; align-items: center; gap: 15px; padding: 15px 20px; border: 1px solid #ddd; cursor: pointer; transition: all 0.2s; background: #fafafa; }
.payment-card.active { border-color: #111; background: #fff; }
.payment-card input[type="radio"] { accent-color: #111; }
.payment-info { display: flex; flex-direction: column; }
.payment-title { font-size: 11px; font-weight: 500; color: #111; }
.payment-desc { font-size: 9px; color: #777; margin-top: 3px; letter-spacing: 0.5px; }

/* Place Order Button */
.place-order-btn { width: 100%; background: #111; color: #fff; border: none; padding: 16px; font-size: 9px; letter-spacing: 2px; cursor: pointer; transition: background 0.2s; margin-top: 10px; }
.place-order-btn:hover { background: #333; }
.place-order-btn:disabled { background: #888; cursor: not-allowed; }

/* Order Summary Box (Kanan) */
.order-summary-box { background: #f9f9f9; padding: 35px; border: 1px solid #eee; }
.order-summary-box h2 { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; font-weight: 400; margin-top: 0; margin-bottom: 25px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }

.summary-items-list { display: flex; flex-direction: column; gap: 15px; max-height: 300px; overflow-y: auto; margin-bottom: 20px; padding-right: 5px; }
.summary-item { display: flex; align-items: center; gap: 15px; padding-bottom: 12px; border-bottom: 1px solid #eee; }
.summary-item-img { position: relative; width: 50px; height: 60px; background: #eee; overflow: hidden; }
.summary-item-img img { width: 100%; height: 100%; object-fit: cover; }
.item-qty-badge { position: absolute; top: -5px; right: -5px; background: #111; color: #fff; font-size: 8px; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.summary-item-detail { flex: 1; }
.summary-item-detail h4 { font-family: 'Playfair Display', Georgia, serif; font-size: 13px; font-weight: 400; margin: 0 0 4px; }
.summary-item-detail p { font-size: 9px; color: #777; margin: 0; letter-spacing: 0.5px; }
.summary-item-price { font-size: 11px; font-weight: 500; }

.summary-totals { border-top: 1px solid #ddd; padding-top: 15px; display: flex; flex-direction: column; gap: 10px; }
.summary-row { display: flex; justify-content: space-between; font-size: 10px; letter-spacing: 1px; color: #666; }
.summary-row.total { font-size: 12px; color: #111; font-weight: bold; border-top: 1px solid #ddd; padding-top: 12px; margin-top: 5px; }

.secure-notice { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 25px; font-size: 9px; letter-spacing: 1.5px; color: #555; }

/* Footer */
.footer { background: #fff; border-top: 1px solid #ddd; padding: 45px 50px; display: flex; justify-content: space-between; align-items: center; margin-top: 80px; }
.footer-brand { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; letter-spacing: 3px; }
.footer-links { display: flex; gap: 25px; }
.footer-links a { color: #111; text-decoration: none; font-size: 9px; letter-spacing: 1.5px; }
.footer p { color: #999; font-size: 8px; letter-spacing: 1px; margin: 0; }

/* Responsive */
@media (max-width: 900px) {
  .checkout-layout { grid-template-columns: 1fr; gap: 40px; }
  .checkout-container { padding: 40px 20px; }
  .navbar { padding: 0 20px; }
  .form-grid, .form-grid-3 { grid-template-columns: 1fr; }
}
</style>