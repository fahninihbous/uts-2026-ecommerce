<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

/* =========================
   CUSTOMER DATA
========================= */

const customer = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  province: '',
  postalCode: ''
})


/* =========================
   PAYMENT METHOD
========================= */

const paymentMethod = ref('Bank Transfer')


/* =========================
   CART DATA
========================= */

const cartItems = ref([
  {
    id: 1,
    name: 'Classic T-Shirt',
    category: 'T-Shirt',
    price: 350000,
    quantity: 1,
    image: '/images/product-tshirt.jpg'
  },
  {
    id: 2,
    name: 'Essential Shirt',
    category: 'Shirt',
    price: 450000,
    quantity: 1,
    image: '/images/product-shirt.jpg'
  }
])


/* =========================
   FORMAT RUPIAH
========================= */

const formatPrice = (price) => {
  return 'Rp ' + new Intl.NumberFormat('id-ID').format(price)
}


/* =========================
   SUBTOTAL
========================= */

const subtotal = computed(() => {
  return cartItems.value.reduce((total, item) => {
    return total + (item.price * item.quantity)
  }, 0)
})


/* =========================
   SHIPPING
========================= */

const shipping = computed(() => {
  if (subtotal.value >= 500000) {
    return 0
  }

  return 25000
})


/* =========================
   TOTAL
========================= */

const grandTotal = computed(() => {
  return subtotal.value + shipping.value
})


/* =========================
   TOTAL ITEMS
========================= */

const totalItems = computed(() => {
  return cartItems.value.reduce((total, item) => {
    return total + item.quantity
  }, 0)
})


/* =========================
   UPDATE QUANTITY
========================= */

const increaseQuantity = (item) => {
  item.quantity++
}


const decreaseQuantity = (item) => {
  if (item.quantity > 1) {
    item.quantity--
  }
}


/* =========================
   REMOVE ITEM
========================= */

const removeItem = (id) => {
  cartItems.value = cartItems.value.filter(
    item => item.id !== id
  )
}


/* =========================
   VALIDATE FORM
========================= */

const validateForm = () => {

  if (!customer.value.firstName.trim()) {
    alert('Please enter your first name.')
    return false
  }

  if (!customer.value.lastName.trim()) {
    alert('Please enter your last name.')
    return false
  }

  if (!customer.value.email.trim()) {
    alert('Please enter your email.')
    return false
  }

  if (!customer.value.phone.trim()) {
    alert('Please enter your phone number.')
    return false
  }

  if (!customer.value.address.trim()) {
    alert('Please enter your shipping address.')
    return false
  }

  if (!customer.value.city.trim()) {
    alert('Please enter your city.')
    return false
  }

  if (!customer.value.province.trim()) {
    alert('Please select your province.')
    return false
  }

  if (!customer.value.postalCode.trim()) {
    alert('Please enter your postal code.')
    return false
  }

  return true
}


/* =========================
   PLACE ORDER
========================= */

const placeOrder = () => {

  if (cartItems.value.length === 0) {
    alert('Your shopping bag is empty.')
    return
  }

  if (!validateForm()) {
    return
  }

  /*
    Setelah semua data lengkap,
    arahkan ke halaman Place Order.
  */

  router.push('/place-order')
}


/* =========================
   BACK TO CART
========================= */

const backToCart = () => {
  router.push('/cart')
}


/* =========================
   CONTINUE SHOPPING
========================= */

const continueShopping = () => {
  router.push('/shop')
}
</script>


<template>

  <div class="checkout-page">


    <!-- =========================
         NAVBAR
    ========================== -->

    <nav class="navbar">


      <!-- LEFT -->

      <div class="nav-left">

        <router-link
          to="/shop"
          class="nav-link"
        >
          SHOP
        </router-link>

        <router-link
          to="/about"
          class="nav-link"
        >
          OUR MISSION
        </router-link>

      </div>


      <!-- CENTER LOGO -->

      <div class="nav-center">

        <router-link
          to="/home"
          class="brand-logo"
        >
          PROVIDENTIAL
        </router-link>

      </div>


      <!-- RIGHT -->

      <div class="nav-right">


        <!-- SEARCH -->

        <router-link
          to="/search"
          class="icon-btn"
          aria-label="Search"
        >

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="21"
            height="21"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >

            <circle
              cx="11"
              cy="11"
              r="8"
            />

            <path
              d="m21 21-4.3-4.3"
            />

          </svg>

        </router-link>


        <!-- CART -->

        <router-link
          to="/cart"
          class="icon-btn cart-icon"
          aria-label="Cart"
        >

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="21"
            height="21"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >

            <path
              d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"
            />

            <path
              d="M3 6h18"
            />

            <path
              d="M16 10a4 4 0 0 1-8 0"
            />

          </svg>


          <span class="cart-badge">
            {{ totalItems }}
          </span>

        </router-link>


        <!-- USER -->

        <router-link
          to="/user"
          class="icon-btn"
          aria-label="Account"
        >

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="21"
            height="21"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >

            <path
              d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
            />

            <circle
              cx="12"
              cy="7"
              r="4"
            />

          </svg>

        </router-link>

      </div>

    </nav>



    <!-- =========================
         CHECKOUT HEADER
    ========================== -->

    <section class="checkout-header">

      <p class="section-label">
        PROVIDENTIAL
      </p>

      <h1>
        Checkout
      </h1>

      <p>
        Complete your information to place your order.
      </p>

    </section>



    <!-- =========================
         CHECKOUT CONTENT
    ========================== -->

    <main class="checkout-container">


      <!-- =========================
           LEFT CONTENT
      ========================== -->

      <div class="checkout-left">


        <!-- =========================
             CONTACT INFORMATION
        ========================== -->

        <section class="checkout-card">


          <div class="card-heading">

            <div class="heading-number">
              01
            </div>

            <div>

              <p class="heading-label">
                INFORMATION
              </p>

              <h2>
                Contact Information
              </h2>

            </div>

          </div>


          <div class="form-grid">


            <!-- FIRST NAME -->

            <div class="form-group">

              <label>
                First Name
              </label>

              <input
                v-model="customer.firstName"
                type="text"
                placeholder="Enter your first name"
              />

            </div>


            <!-- LAST NAME -->

            <div class="form-group">

              <label>
                Last Name
              </label>

              <input
                v-model="customer.lastName"
                type="text"
                placeholder="Enter your last name"
              />

            </div>


            <!-- EMAIL -->

            <div class="form-group">

              <label>
                Email Address
              </label>

              <input
                v-model="customer.email"
                type="email"
                placeholder="you@example.com"
              />

            </div>


            <!-- PHONE -->

            <div class="form-group">

              <label>
                Phone Number
              </label>

              <input
                v-model="customer.phone"
                type="tel"
                placeholder="08xxxxxxxxxx"
              />

            </div>

          </div>

        </section>



        <!-- =========================
             SHIPPING ADDRESS
        ========================== -->

        <section class="checkout-card">


          <div class="card-heading">

            <div class="heading-number">
              02
            </div>

            <div>

              <p class="heading-label">
                DELIVERY
              </p>

              <h2>
                Shipping Address
              </h2>

            </div>

          </div>


          <div class="form-grid">


            <!-- ADDRESS -->

            <div class="form-group full-width">

              <label>
                Address
              </label>

              <textarea
                v-model="customer.address"
                rows="3"
                placeholder="Enter your complete address"
              ></textarea>

            </div>


            <!-- CITY -->

            <div class="form-group">

              <label>
                City
              </label>

              <input
                v-model="customer.city"
                type="text"
                placeholder="Enter your city"
              />

            </div>


            <!-- PROVINCE -->

            <div class="form-group">

              <label>
                Province
              </label>

              <select
                v-model="customer.province"
              >

                <option
                  value=""
                  disabled
                >
                  Select province
                </option>

                <option>
                  Jawa Barat
                </option>

                <option>
                  Jawa Tengah
                </option>

                <option>
                  Jawa Timur
                </option>

                <option>
                  DKI Jakarta
                </option>

                <option>
                  Banten
                </option>

                <option>
                  DI Yogyakarta
                </option>

                <option>
                  Bali
                </option>

                <option>
                  Sumatera Utara
                </option>

                <option>
                  Sumatera Barat
                </option>

                <option>
                  Sumatera Selatan
                </option>

                <option>
                  Kalimantan Barat
                </option>

                <option>
                  Kalimantan Timur
                </option>

                <option>
                  Sulawesi Selatan
                </option>

                <option>
                  Papua
                </option>

              </select>

            </div>


            <!-- POSTAL CODE -->

            <div class="form-group">

              <label>
                Postal Code
              </label>

              <input
                v-model="customer.postalCode"
                type="text"
                placeholder="40123"
              />

            </div>

          </div>

        </section>



        <!-- =========================
             PAYMENT
        ========================== -->

        <section class="checkout-card">


          <div class="card-heading">

            <div class="heading-number">
              03
            </div>

            <div>

              <p class="heading-label">
                PAYMENT
              </p>

              <h2>
                Payment Method
              </h2>

            </div>

          </div>


          <div class="payment-options">


            <!-- BANK TRANSFER -->

            <label
              class="payment-option"
              :class="{
                active: paymentMethod === 'Bank Transfer'
              }"
            >

              <input
                v-model="paymentMethod"
                type="radio"
                value="Bank Transfer"
              />


              <div class="payment-radio"></div>


              <div class="payment-details">

                <strong>
                  Bank Transfer
                </strong>

                <span>
                  Pay securely via bank transfer
                </span>

              </div>


              <div class="payment-symbol">

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="25"
                  height="25"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.7"
                >

                  <path
                    d="M3 10h18"
                  />

                  <path
                    d="M5 10v8"
                  />

                  <path
                    d="M9 10v8"
                  />

                  <path
                    d="M15 10v8"
                  />

                  <path
                    d="M19 10v8"
                  />

                  <path
                    d="M2 18h20"
                  />

                  <path
                    d="m12 3 10 5H2l10-5Z"
                  />

                </svg>

              </div>

            </label>



            <!-- E-WALLET -->

            <label
              class="payment-option"
              :class="{
                active: paymentMethod === 'E-Wallet'
              }"
            >

              <input
                v-model="paymentMethod"
                type="radio"
                value="E-Wallet"
              />


              <div class="payment-radio"></div>


              <div class="payment-details">

                <strong>
                  E-Wallet
                </strong>

                <span>
                  Pay with your preferred e-wallet
                </span>

              </div>


              <div class="payment-symbol">

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="25"
                  height="25"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.7"
                >

                  <rect
                    x="3"
                    y="5"
                    width="18"
                    height="14"
                    rx="2"
                  />

                  <path
                    d="M16 12h3"
                  />

                </svg>

              </div>

            </label>



            <!-- CASH ON DELIVERY -->

            <label
              class="payment-option"
              :class="{
                active: paymentMethod === 'Cash on Delivery'
              }"
            >

              <input
                v-model="paymentMethod"
                type="radio"
                value="Cash on Delivery"
              />


              <div class="payment-radio"></div>


              <div class="payment-details">

                <strong>
                  Cash on Delivery
                </strong>

                <span>
                  Pay when your order arrives
                </span>

              </div>


              <div class="payment-symbol">

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="25"
                  height="25"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.7"
                >

                  <path
                    d="M3 7h13a3 3 0 0 1 3 3v6H3z"
                  />

                  <path
                    d="M19 11h2l1 2v3h-3"
                  />

                  <circle
                    cx="7"
                    cy="17"
                    r="2"
                  />

                  <circle
                    cx="18"
                    cy="17"
                    r="2"
                  />

                </svg>

              </div>

            </label>

          </div>

        </section>



        <!-- =========================
             BACK TO CART
        ========================== -->

        <button
          type="button"
          class="back-cart-btn"
          @click="backToCart"
        >

          ← Back to Shopping Bag

        </button>

      </div>



      <!-- =========================
           RIGHT SUMMARY
      ========================== -->

      <aside class="summary-card">


        <div class="summary-heading">

          <p>
            YOUR ORDER
          </p>

          <h2>
            Order Summary
          </h2>

        </div>



        <!-- =========================
             PRODUCTS
        ========================== -->

        <div class="summary-products">


          <div
            v-for="item in cartItems"
            :key="item.id"
            class="summary-product"
          >


            <!-- IMAGE -->

            <div class="summary-image">

              <img
                :src="item.image"
                :alt="item.name"
              />

              <span>
                {{ item.quantity }}
              </span>

            </div>


            <!-- INFO -->

            <div class="summary-product-info">

              <strong>
                {{ item.name }}
              </strong>

              <span>
                {{ item.category }}
              </span>

              <div class="quantity-control">

                <button
                  type="button"
                  @click="decreaseQuantity(item)"
                >
                  −
                </button>

                <span>
                  {{ item.quantity }}
                </span>

                <button
                  type="button"
                  @click="increaseQuantity(item)"
                >
                  +
                </button>

              </div>

            </div>


            <!-- PRICE -->

            <div class="summary-product-price">

              {{ formatPrice(item.price * item.quantity) }}

              <button
                type="button"
                class="remove-btn"
                @click="removeItem(item.id)"
              >
                Remove
              </button>

            </div>

          </div>

        </div>



        <!-- =========================
             PRICE
        ========================== -->

        <div class="price-section">


          <div class="price-row">

            <span>
              Subtotal
            </span>

            <strong>
              {{ formatPrice(subtotal) }}
            </strong>

          </div>


          <div class="price-row">

            <span>
              Shipping
            </span>

            <strong>

              <span
                v-if="shipping === 0"
                class="free"
              >
                FREE
              </span>

              <span v-else>
                {{ formatPrice(shipping) }}
              </span>

            </strong>

          </div>


          <!-- FREE SHIPPING MESSAGE -->

          <p
            v-if="shipping === 0"
            class="shipping-message"
          >
            You qualify for free shipping.
          </p>


          <p
            v-else
            class="shipping-message"
          >
            Add {{ formatPrice(500000 - subtotal) }}
            more for free shipping.
          </p>


          <div class="price-divider"></div>


          <div class="total-row">

            <span>
              Total
            </span>

            <strong>
              {{ formatPrice(grandTotal) }}
            </strong>

          </div>

        </div>



        <!-- =========================
             PLACE ORDER
        ========================== -->

        <button
          type="button"
          class="place-order-btn"
          @click="placeOrder"
        >

          <span>
            Place Order
          </span>

          <span>
            →
          </span>

        </button>



        <!-- =========================
             SECURE
        ========================== -->

        <div class="secure-payment">

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="15"
            height="15"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >

            <rect
              x="3"
              y="11"
              width="18"
              height="10"
              rx="2"
            />

            <path
              d="M7 11V7a5 5 0 0 1 10 0v4"
            />

          </svg>

          Secure & encrypted checkout

        </div>

      </aside>

    </main>



    <!-- =========================
         SUPPORT BUTTON
    ========================== -->

    <button
      type="button"
      class="support-btn"
    >

      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="17"
        height="17"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >

        <path
          d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"
        />

      </svg>

      Support

    </button>

  </div>

</template>


<style scoped>

/* =========================
   GENERAL
========================= */

.checkout-page {
  min-height: 100vh;

  background: #ffffff;

  color: #111111;

  font-family:
    'Inter',
    Arial,
    sans-serif;
}


/* =========================
   NAVBAR
========================= */

.navbar {
  position: relative;

  z-index: 10;

  display: flex;

  align-items: center;

  justify-content: space-between;

  padding: 1.5rem 3rem;

  background: #ffffff;

  border-bottom: 1px solid #dddddd;
}


.nav-left,
.nav-right {
  display: flex;

  align-items: center;

  gap: 1.5rem;
}


.nav-link {
  color: #111111;

  text-decoration: none;

  font-size: 0.82rem;

  font-weight: 700;

  letter-spacing: 1.5px;

  transition: color 0.2s ease;
}


.nav-link:hover {
  color: #666666;
}


.nav-center {
  position: absolute;

  left: 50%;

  transform: translateX(-50%);
}


.brand-logo {
  color: #111111;

  text-decoration: none;

  font-size: 2rem;

  font-weight: 800;

  letter-spacing: 4px;

  white-space: nowrap;
}


.icon-btn {
  position: relative;

  display: flex;

  align-items: center;

  justify-content: center;

  color: #111111;

  text-decoration: none;

  transition:
    transform 0.2s ease,
    color 0.2s ease;
}


.icon-btn:hover {
  transform: translateY(-2px);

  color: #666666;
}


/* =========================
   CART BADGE
========================= */

.cart-badge {
  position: absolute;

  top: -8px;

  right: -9px;

  width: 16px;

  height: 16px;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111111;

  color: #ffffff;

  border-radius: 50%;

  font-size: 9px;

  font-weight: 700;
}


/* =========================
   CHECKOUT HEADER
========================= */

.checkout-header {
  padding: 4.5rem 1.5rem 4rem;

  text-align: center;

  background: #f1f1f1;

  border-bottom: 1px solid #dddddd;
}


.section-label {
  margin: 0 0 0.8rem;

  color: #777777;

  font-size: 0.7rem;

  font-weight: 700;

  letter-spacing: 3px;
}


.checkout-header h1 {
  margin: 0 0 0.8rem;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 3.2rem;

  font-weight: 400;

  letter-spacing: -0.5px;
}


.checkout-header > p:last-child {
  margin: 0;

  color: #666666;

  font-size: 0.9rem;
}


/* =========================
   MAIN CONTAINER
========================= */

.checkout-container {
  max-width: 1250px;

  margin: 0 auto;

  padding: 4rem 2rem 7rem;

  display: grid;

  grid-template-columns:
    minmax(0, 1.5fr)
    minmax(350px, 0.8fr);

  gap: 3rem;

  align-items: start;
}


.checkout-left {
  display: flex;

  flex-direction: column;

  gap: 1.8rem;
}


/* =========================
   CHECKOUT CARD
========================= */

.checkout-card {
  padding: 2rem;

  background: #ffffff;

  border: 1px solid #dddddd;
}


.card-heading {
  display: flex;

  align-items: center;

  gap: 1rem;

  margin-bottom: 2rem;

  padding-bottom: 1.4rem;

  border-bottom: 1px solid #eeeeee;
}


.heading-number {
  width: 38px;

  height: 38px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111111;

  color: #ffffff;

  font-size: 0.75rem;

  font-weight: 700;
}


.heading-label {
  margin: 0 0 0.25rem;

  color: #888888;

  font-size: 0.62rem;

  font-weight: 700;

  letter-spacing: 2px;
}


.card-heading h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 1.6rem;

  font-weight: 500;
}


/* =========================
   FORM
========================= */

.form-grid {
  display: grid;

  grid-template-columns:
    repeat(2, 1fr);

  gap: 1.3rem;
}


.form-group {
  display: flex;

  flex-direction: column;

  gap: 0.5rem;
}


.full-width {
  grid-column: 1 / -1;
}


.form-group label {
  color: #333333;

  font-size: 0.72rem;

  font-weight: 600;
}


.form-group input,
.form-group textarea,
.form-group select {
  width: 100%;

  box-sizing: border-box;

  padding: 0.9rem 1rem;

  border: 1px solid #d2d2d2;

  border-radius: 0;

  background: #ffffff;

  color: #111111;

  font-family: inherit;

  font-size: 0.82rem;

  outline: none;

  transition:
    border-color 0.2s ease,
    box-shadow 0.2s ease;
}


.form-group input::placeholder,
.form-group textarea::placeholder {
  color: #aaaaaa;
}


.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
  border-color: #111111;

  box-shadow:
    0 0 0 2px rgba(0, 0, 0, 0.06);
}


.form-group textarea {
  resize: vertical;

  min-height: 100px;
}


/* =========================
   PAYMENT OPTIONS
========================= */

.payment-options {
  display: flex;

  flex-direction: column;

  gap: 0.8rem;
}


.payment-option {
  position: relative;

  display: flex;

  align-items: center;

  gap: 1rem;

  padding: 1.1rem;

  border: 1px solid #dddddd;

  background: #ffffff;

  cursor: pointer;

  transition:
    border-color 0.2s ease,
    background 0.2s ease;
}


.payment-option:hover {
  border-color: #999999;
}


.payment-option.active {
  border-color: #111111;

  background: #f5f5f5;
}


.payment-option input {
  position: absolute;

  opacity: 0;

  pointer-events: none;
}


.payment-radio {
  width: 18px;

  height: 18px;

  flex-shrink: 0;

  border: 1px solid #999999;

  border-radius: 50%;

  position: relative;
}


.payment-option.active .payment-radio {
  border-color: #111111;
}


.payment-option.active .payment-radio::after {
  content: '';

  position: absolute;

  width: 8px;

  height: 8px;

  top: 4px;

  left: 4px;

  border-radius: 50%;

  background: #111111;
}


.payment-details {
  flex: 1;

  display: flex;

  flex-direction: column;

  gap: 0.3rem;
}


.payment-details strong {
  font-size: 0.82rem;
}


.payment-details span {
  color: #777777;

  font-size: 0.7rem;
}


.payment-symbol {
  display: flex;

  align-items: center;

  justify-content: center;

  color: #555555;
}


/* =========================
   BACK BUTTON
========================= */

.back-cart-btn {
  align-self: flex-start;

  padding: 0;

  border: none;

  background: transparent;

  color: #555555;

  font-size: 0.78rem;

  cursor: pointer;

  transition: color 0.2s ease;
}


.back-cart-btn:hover {
  color: #111111;
}


/* =========================
   SUMMARY CARD
========================= */

.summary-card {
  position: sticky;

  top: 2rem;

  padding: 2rem;

  background: #f1f1f1;

  border: 1px solid #dddddd;
}


.summary-heading {
  padding-bottom: 1.4rem;

  border-bottom: 1px solid #d2d2d2;
}


.summary-heading p {
  margin: 0 0 0.4rem;

  color: #777777;

  font-size: 0.65rem;

  font-weight: 700;

  letter-spacing: 2px;
}


.summary-heading h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 1.7rem;

  font-weight: 500;
}


/* =========================
   SUMMARY PRODUCTS
========================= */

.summary-products {
  display: flex;

  flex-direction: column;
}


.summary-product {
  display: flex;

  align-items: center;

  gap: 0.9rem;

  padding: 1.3rem 0;

  border-bottom: 1px solid #d8d8d8;
}


.summary-image {
  position: relative;

  width: 65px;

  height: 80px;

  flex-shrink: 0;

  background: #d4d4d4;

  overflow: visible;
}


.summary-image img {
  width: 100%;

  height: 100%;

  display: block;

  object-fit: cover;

  filter: grayscale(100%);
}


.summary-image > span {
  position: absolute;

  top: -7px;

  right: -7px;

  width: 20px;

  height: 20px;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111111;

  color: #ffffff;

  border-radius: 50%;

  font-size: 10px;

  font-weight: 700;
}


.summary-product-info {
  flex: 1;

  min-width: 0;

  display: flex;

  flex-direction: column;

  gap: 0.25rem;
}


.summary-product-info strong {
  font-size: 0.78rem;

  line-height: 1.3;
}


.summary-product-info > span {
  color: #777777;

  font-size: 0.67rem;
}


/* =========================
   QUANTITY
========================= */

.quantity-control {
  display: flex;

  align-items: center;

  width: fit-content;

  margin-top: 0.3rem;

  border: 1px solid #cccccc;

  background: #ffffff;
}


.quantity-control button {
  width: 24px;

  height: 24px;

  border: none;

  background: transparent;

  color: #111111;

  cursor: pointer;

  font-size: 14px;
}


.quantity-control button:hover {
  background: #eeeeee;
}


.quantity-control > span {
  width: 24px;

  text-align: center;

  font-size: 0.7rem;
}


/* =========================
   PRODUCT PRICE
========================= */

.summary-product-price {
  display: flex;

  flex-direction: column;

  align-items: flex-end;

  gap: 0.4rem;

  font-size: 0.75rem;

  font-weight: 700;

  white-space: nowrap;
}


.remove-btn {
  border: none;

  background: transparent;

  color: #888888;

  font-size: 0.6rem;

  text-decoration: underline;

  cursor: pointer;
}


.remove-btn:hover {
  color: #111111;
}


/* =========================
   PRICE SECTION
========================= */

.price-section {
  padding-top: 1.5rem;
}


.price-row {
  display: flex;

  align-items: center;

  justify-content: space-between;

  margin-bottom: 0.9rem;

  font-size: 0.78rem;
}


.price-row span:first-child {
  color: #666666;
}


.price-row strong {
  font-size: 0.78rem;
}


.free {
  font-size: 0.7rem;
}


.shipping-message {
  margin: 0.4rem 0 1.2rem;

  color: #777777;

  font-size: 0.65rem;

  line-height: 1.5;
}


.price-divider {
  height: 1px;

  margin: 1.3rem 0;

  background: #cccccc;
}


.total-row {
  display: flex;

  align-items: center;

  justify-content: space-between;
}


.total-row span {
  font-size: 0.9rem;

  font-weight: 600;
}


.total-row strong {
  font-size: 1.2rem;

  font-weight: 700;
}


/* =========================
   PLACE ORDER BUTTON
========================= */

.place-order-btn {
  width: 100%;

  display: flex;

  align-items: center;

  justify-content: space-between;

  margin-top: 1.5rem;

  padding: 1rem 1.2rem;

  border: none;

  background: #111111;

  color: #ffffff;

  font-size: 0.85rem;

  font-weight: 700;

  cursor: pointer;

  transition:
    background 0.2s ease,
    transform 0.2s ease;
}


.place-order-btn:hover {
  background: #444444;

  transform: translateY(-2px);
}


.place-order-btn span:last-child {
  font-size: 1.1rem;
}


/* =========================
   SECURE
========================= */

.secure-payment {
  display: flex;

  align-items: center;

  justify-content: center;

  gap: 0.4rem;

  margin-top: 1.2rem;

  color: #777777;

  font-size: 0.65rem;
}


/* =========================
   SUPPORT
========================= */

.support-btn {
  position: fixed;

  right: 20px;

  bottom: 20px;

  z-index: 100;

  display: flex;

  align-items: center;

  gap: 0.5rem;

  padding: 0.65rem 1.2rem;

  border: none;

  border-radius: 25px;

  background: #111111;

  color: #ffffff;

  font-size: 0.8rem;

  cursor: pointer;

  box-shadow:
    0 4px 15px rgba(0, 0, 0, 0.2);

  transition:
    transform 0.2s ease,
    background 0.2s ease;
}


.support-btn:hover {
  transform: translateY(-2px);

  background: #444444;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1000px) {

  .checkout-container {
    grid-template-columns: 1fr;
  }


  .summary-card {
    position: static;

    order: -1;
  }

}


@media (max-width: 700px) {

  .navbar {
    padding: 1rem;
  }


  .nav-left {
    gap: 0.7rem;
  }


  .nav-link {
    font-size: 0.65rem;
  }


  .brand-logo {
    font-size: 1.2rem;

    letter-spacing: 2px;
  }


  .nav-right {
    gap: 0.8rem;
  }


  .checkout-header {
    padding: 3.5rem 1.5rem 3rem;
  }


  .checkout-header h1 {
    font-size: 2.5rem;
  }


  .checkout-container {
    padding: 2.5rem 1rem 5rem;

    gap: 1.5rem;
  }


  .checkout-card {
    padding: 1.3rem;
  }


  .summary-card {
    padding: 1.3rem;
  }


  .form-grid {
    grid-template-columns: 1fr;
  }


  .full-width {
    grid-column: auto;
  }

}


@media (max-width: 450px) {

  .nav-left {
    display: none;
  }


  .nav-center {
    position: static;

    transform: none;

    margin: 0 auto;
  }


  .checkout-header h1 {
    font-size: 2.2rem;
  }


  .summary-product {
    gap: 0.6rem;
  }


  .summary-image {
    width: 55px;

    height: 70px;
  }


  .summary-product-price {
    font-size: 0.68rem;
  }


  .checkout-card {
    padding: 1rem;
  }


  .summary-card {
    padding: 1rem;
  }


  .support-btn {
    right: 12px;

    bottom: 12px;
  }

}

</style>