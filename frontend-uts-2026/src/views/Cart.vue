<template>
  <div class="cart-page">

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">
      <div class="nav-left">
        <router-link to="/shop" class="nav-link">
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
        <router-link to="/search" class="nav-link">
          SEARCH
        </router-link>
        <router-link to="/cart" class="nav-link active">
          CART
          <span class="cart-count">({{ totalItems }})</span>
        </router-link>
        <router-link to="/user" class="nav-link">
          ACCOUNT
        </router-link>
      </div>
    </header>


    <!-- ================= CART CONTENT ================= -->
    <main class="cart-container">
      <!-- TITLE -->
      <section class="cart-heading">
        <p class="small-title">YOUR SHOPPING BAG</p>
        <h1>Shopping Cart</h1>
        <p class="heading-description">Review your selected items before proceeding to checkout.</p>
      </section>

      <!-- ================= EMPTY CART ================= -->
      <section v-if="cartItems.length === 0" class="empty-cart">
        <div class="empty-icon">×</div>
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added anything to your cart yet.</p>
        <router-link to="/shop" class="shop-button">Continue Shopping</router-link>
      </section>

      <!-- ================= CART ================= -->
      <section v-else class="cart-content">
        <!-- ================= PRODUCTS ================= -->
        <div class="cart-items">
          <!-- TABLE HEADER -->
          <div class="items-header">
            <span>PRODUCT</span>
            <span>PRICE</span>
            <span>QUANTITY</span>
            <span>TOTAL</span>
          </div>

          <!-- PRODUCT -->
          <div v-for="item in cartItems" :key="item.id" class="cart-item">
            <!-- PRODUCT NAME -->
            <div class="product">
              <div class="product-info">
                <h3>{{ item.product?.name }}</h3>
                <p>
                  <span v-if="item.size">Size: {{ item.size }}</span>
                  <span v-if="item.size && item.color"> · </span>
                  <span v-if="item.color">Color: {{ item.color }}</span>
                </p>
                <button class="remove-button" @click="removeItem(item.id)">Remove</button>
              </div>
            </div>

            <!-- PRICE -->
            <div class="price">Rp {{ formatPrice(item.product?.discount_price || item.product?.price) }}</div>

            <!-- QUANTITY -->
            <div class="quantity">
              <button @click="decreaseQuantity(item)">−</button>
              <span>{{ item.quantity }}</span>
              <button @click="increaseQuantity(item)">+</button>
            </div>

            <!-- TOTAL -->
            <div class="item-total">Rp {{ formatPrice((item.product?.discount_price || item.product?.price || 0) * item.quantity) }}</div>
          </div>

          <!-- CONTINUE SHOPPING -->
          <div class="continue-shopping">
            <router-link to="/shop">← Continue Shopping</router-link>
          </div>
        </div>

        <!-- ================= SUMMARY ================= -->
        <aside class="summary">
          <div class="summary-header">
            <p>ORDER SUMMARY</p>
            <h2>Your Order</h2>
          </div>

          <div class="summary-row">
            <span>Subtotal</span>
            <strong>Rp {{ formatPrice(subtotal) }}</strong>
          </div>

          <div class="summary-row">
            <span>Shipping</span>
            <span>{{ shipping === 0 ? 'FREE' : 'Rp ' + formatPrice(shipping) }}</span>
          </div>

          <div class="summary-line"></div>

          <div class="summary-total">
            <span>Total</span>
            <strong>Rp {{ formatPrice(grandTotal) }}</strong>
          </div>

          <button class="checkout-button" @click="checkout">Proceed to Checkout</button>

          <p class="secure-text">Secure checkout · Fast delivery · Easy returns</p>
        </aside>
      </section>
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
import axios from 'axios'

const cartItems = ref([])

// Ambil data keranjang dari database backend Laravel menggunakan token
const fetchCart = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) return

    const response = await axios.get('http://127.0.0.1:8000/api/cart', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
    
    if (response.data?.status && response.data?.data) {
      // Menyesuaikan dengan relasi model Laravel (cart_items / items)
      cartItems.value = response.data.data.cart_items || response.data.data.items || []
    }
  } catch (error) {
    console.error('Gagal mengambil data keranjang:', error)
  }
}

onMounted(() => {
  fetchCart()
})

const totalItems = computed(() => cartItems.value.reduce((total, item) => total + item.quantity, 0))
const subtotal = computed(() => cartItems.value.reduce((total, item) => total + (((item.product?.discount_price || item.product?.price) || 0) * item.quantity), 0))
const shipping = computed(() => (subtotal.value >= 500000 || subtotal.value === 0 ? 0 : 20000))
const grandTotal = computed(() => subtotal.value + shipping.value)

const formatPrice = (price) => {
  return Number(price || 0).toLocaleString('id-ID')
}

const increaseQuantity = async (item) => { 
  item.quantity++ 
  // Tambahkan logic update ke backend jika diperlukan
}

const decreaseQuantity = async (item) => { 
  if (item.quantity > 1) {
    item.quantity-- 
    // Tambahkan logic update ke backend jika diperlukan
  }
}

// Hapus item menggunakan route DELETE /api/cart/{id}
const removeItem = async (id) => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.delete(`http://127.0.0.1:8000/api/cart/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })

    if (response.data.status) {
      cartItems.value = cartItems.value.filter(item => item.id !== id)
    }
  } catch (error) {
    console.error('Gagal menghapus item:', error)
    alert('Gagal menghapus item dari keranjang.')
  }
}

const checkout = () => {
  if (cartItems.value.length === 0) {
    alert('Your cart is empty.')
    return
  }
  window.location.href = '/checkout'
}
</script>


<style scoped>
.cart-page { min-height: 100vh; background: #fff; color: #111; font-family: 'Inter', Arial, sans-serif; }
.navbar { height: 82px; padding: 0 50px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; position: sticky; top: 0; z-index: 100; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(10px); }
.nav-left, .nav-right { display: flex; align-items: center; gap: 28px; }
.nav-link { text-decoration: none; color: #111; font-size: 10px; letter-spacing: 1.8px; position: relative; transition: opacity 0.3s ease; }
.nav-link:hover { opacity: 0.5; }
.nav-link.active::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 100%; height: 1px; background: #111; }
.brand { color: #111; text-decoration: none; font-family: 'Playfair Display', Georgia, serif; font-size: 23px; letter-spacing: 5px; }
.cart-count { font-size: 9px; }

.cart-container { max-width: 1400px; margin: auto; padding: 90px 50px 120px; }

.cart-heading { max-width: 700px; margin-bottom: 70px; }
.small-title { margin: 0 0 15px; font-size: 10px; font-weight: 700; letter-spacing: 3px; color: #777; }
.cart-heading h1 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: clamp(45px, 5vw, 72px); font-weight: 400; line-height: 0.95; }
.heading-description { margin-top: 24px; max-width: 500px; font-size: 14px; line-height: 1.7; color: #777; }

.cart-content { display: grid; grid-template-columns: minmax(0, 1fr) 380px; gap: 80px; align-items: start; }

.items-header {
  display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; padding-bottom: 17px;
  border-bottom: 1px solid #ddd; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; color: #777;
}

.cart-item { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; align-items: center; min-height: 145px; border-bottom: 1px solid #eee; }

.product { display: flex; align-items: center; }
.product-info h3 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 20px; font-weight: 400; color: #111; }
.product-info p { margin: 8px 0 18px; font-size: 12px; color: #777; }
.remove-button { border: none; padding: 0; background: transparent; color: #777; font-size: 11px; text-decoration: underline; cursor: pointer; }

.price, .item-total { font-size: 13px; color: #111; }
.item-total { font-weight: 600; }

.quantity { width: 100px; height: 38px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: space-between; }
.quantity button { width: 32px; height: 100%; border: none; background: transparent; font-size: 18px; color: #333; cursor: pointer; }
.quantity button:hover { background: #f2f2f2; }
.quantity span { font-size: 13px; }

.continue-shopping { padding-top: 28px; }
.continue-shopping a { color: #111; font-size: 12px; text-decoration: none; border-bottom: 1px solid #111; padding-bottom: 4px; letter-spacing: 1px; }

.summary { background: #f9f9f9; padding: 40px 34px; border: 1px solid #eee; }
.summary-header p { margin: 0 0 12px; font-size: 10px; letter-spacing: 2px; font-weight: 700; color: #777; }
.summary-header h2 { margin: 0 0 38px; font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 400; }

.summary-row { display: flex; justify-content: space-between; padding: 13px 0; font-size: 13px; color: #555; }
.summary-row strong { color: #111; font-weight: 500; }
.summary-line { height: 1px; background: #ddd; margin: 25px 0; }

.summary-total { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.summary-total span { font-size: 13px; font-weight: 700; letter-spacing: 1px; }
.summary-total strong { font-size: 19px; }

.checkout-button {
  width: 100%; height: 55px; border: none; background: #111; color: white;
  font-size: 12px; font-weight: 700; letter-spacing: 1.5px; cursor: pointer;
}
.checkout-button:hover { background: #333; }
.secure-text { margin-top: 15px; font-size: 10px; color: #777; text-align: center; letter-spacing: 0.5px; }

.empty-cart { min-height: 450px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
.empty-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; border-radius: 50%; font-size: 22px; margin-bottom: 25px; }
.empty-cart h2 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 34px; font-weight: 400; }
.empty-cart p { margin: 12px 0 30px; font-size: 13px; color: #777; }
.shop-button { padding: 16px 30px; background: #111; color: white; text-decoration: none; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; }

.footer { background: #fff; border-top: 1px solid #ddd; padding: 45px 50px; display: flex; justify-content: space-between; align-items: center; gap: 30px; }
.footer-brand { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; letter-spacing: 3px; }
.footer-links { display: flex; gap: 25px; }
.footer-links a { color: #111; text-decoration: none; font-size: 9px; letter-spacing: 1.5px; }
.footer p { color: #999; font-size: 8px; letter-spacing: 1px; margin: 0; }

@media (max-width: 1000px) {
  .cart-content { grid-template-columns: 1fr; gap: 50px; }
  .summary { max-width: 500px; }
}

@media (max-width: 700px) {
  .navbar { padding: 0 25px; }
  .cart-container { padding: 60px 25px 80px; }
  .items-header { display: none; }
  .cart-item { grid-template-columns: 1fr; gap: 18px; padding: 25px 0; }
}
</style>