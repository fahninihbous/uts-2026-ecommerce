<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

/* =========================
   ORDER DATA
========================= */

const order = {
  orderNumber: 'PRV-2026-0001',

  date: '14 September 2026',

  status: 'Order Confirmed',

  customer: {
    firstName: 'Naura',
    lastName: 'Zahra',
    email: 'customer@email.com',
    phone: '081234567890'
  },

  shippingAddress: {
    address: 'Jl. Contoh No. 123',
    city: 'Bandung',
    province: 'Jawa Barat',
    postalCode: '40123'
  },

  paymentMethod: 'Bank Transfer',

  items: [
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
  ]
}


/* =========================
   FORMAT PRICE
========================= */

const formatPrice = (price) => {
  return 'Rp ' + new Intl.NumberFormat('id-ID').format(price)
}


/* =========================
   CALCULATE SUBTOTAL
========================= */

const subtotal = computed(() => {

  return order.items.reduce((total, item) => {

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
   GRAND TOTAL
========================= */

const grandTotal = computed(() => {

  return subtotal.value + shipping.value

})


/* =========================
   CONTINUE SHOPPING
========================= */

const continueShopping = () => {

  router.push('/shop')

}


/* =========================
   VIEW ORDER DETAILS
========================= */

const viewOrderDetails = () => {

  alert(
    `Order ${order.orderNumber}\n\n` +
    `Status: ${order.status}\n` +
    `Total: ${formatPrice(grandTotal.value)}`
  )

}


/* =========================
   GO HOME
========================= */

const goHome = () => {

  router.push('/home')

}
</script>


<template>

  <div class="place-order-page">


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


      <!-- LOGO -->

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
          class="icon-btn"
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
         SUCCESS HEADER
    ========================== -->

    <section class="success-section">


      <!-- CHECK ICON -->

      <div class="success-icon">

        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="42"
          height="42"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="1.8"
        >

          <path
            d="M20 6 9 17l-5-5"
          />

        </svg>

      </div>


      <p class="success-label">
        THANK YOU FOR YOUR ORDER
      </p>


      <h1>
        Order Confirmed
      </h1>


      <p class="success-description">
        Your order has been successfully placed.
        We will prepare your items with care.
      </p>


      <div class="order-number">

        <span>
          ORDER NUMBER
        </span>

        <strong>
          {{ order.orderNumber }}
        </strong>

      </div>

    </section>


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="order-container">


      <!-- =========================
           LEFT COLUMN
      ========================== -->

      <div class="order-left">


        <!-- =========================
             ORDER ITEMS
        ========================== -->

        <section class="order-card">


          <div class="card-header">

            <div>

              <p class="card-label">
                YOUR PURCHASE
              </p>

              <h2>
                Order Items
              </h2>

            </div>

            <span class="order-date">
              {{ order.date }}
            </span>

          </div>


          <!-- PRODUCTS -->

          <div class="order-items">


            <div
              v-for="item in order.items"
              :key="item.id"
              class="order-item"
            >


              <!-- IMAGE -->

              <div class="item-image">

                <img
                  :src="item.image"
                  :alt="item.name"
                />

              </div>


              <!-- INFO -->

              <div class="item-info">

                <h3>
                  {{ item.name }}
                </h3>

                <p>
                  {{ item.category }}
                </p>

                <span>
                  Quantity: {{ item.quantity }}
                </span>

              </div>


              <!-- PRICE -->

              <div class="item-price">

                {{ formatPrice(item.price * item.quantity) }}

              </div>

            </div>

          </div>

        </section>


        <!-- =========================
             SHIPPING INFORMATION
        ========================== -->

        <section class="order-card">


          <div class="card-header">

            <div>

              <p class="card-label">
                DELIVERY
              </p>

              <h2>
                Shipping Information
              </h2>

            </div>

          </div>


          <div class="shipping-content">


            <!-- CUSTOMER -->

            <div class="info-block">

              <span>
                CUSTOMER
              </span>

              <strong>
                {{ order.customer.firstName }}
                {{ order.customer.lastName }}
              </strong>

              <p>
                {{ order.customer.email }}
              </p>

              <p>
                {{ order.customer.phone }}
              </p>

            </div>


            <!-- ADDRESS -->

            <div class="info-block">

              <span>
                SHIPPING ADDRESS
              </span>

              <strong>
                {{ order.shippingAddress.address }}
              </strong>

              <p>
                {{ order.shippingAddress.city }},
                {{ order.shippingAddress.province }}
              </p>

              <p>
                {{ order.shippingAddress.postalCode }}
              </p>

            </div>

          </div>

        </section>


        <!-- =========================
             PAYMENT
        ========================== -->

        <section class="order-card">


          <div class="card-header">

            <div>

              <p class="card-label">
                PAYMENT
              </p>

              <h2>
                Payment Method
              </h2>

            </div>

          </div>


          <div class="payment-info">


            <div class="payment-icon">

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
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


            <div>

              <strong>
                {{ order.paymentMethod }}
              </strong>

              <p>
                Please complete your payment using
                the selected payment method.
              </p>

            </div>

          </div>

        </section>

      </div>


      <!-- =========================
           RIGHT COLUMN
      ========================== -->

      <aside class="order-summary">


        <div class="summary-header">

          <p>
            ORDER SUMMARY
          </p>

          <h2>
            {{ order.orderNumber }}
          </h2>

        </div>


        <!-- STATUS -->

        <div class="status-box">

          <div class="status-icon">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >

              <path
                d="M20 6 9 17l-5-5"
              />

            </svg>

          </div>


          <div>

            <strong>
              {{ order.status }}
            </strong>

            <span>
              Thank you for shopping with us.
            </span>

          </div>

        </div>


        <!-- PRICE -->

        <div class="summary-prices">


          <div class="summary-row">

            <span>
              Subtotal
            </span>

            <strong>
              {{ formatPrice(subtotal) }}
            </strong>

          </div>


          <div class="summary-row">

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


          <div class="summary-divider"></div>


          <div class="total-row">

            <span>
              Total
            </span>

            <strong>
              {{ formatPrice(grandTotal) }}
            </strong>

          </div>

        </div>


        <!-- PAYMENT METHOD -->

        <div class="summary-payment">

          <span>
            PAYMENT METHOD
          </span>

          <strong>
            {{ order.paymentMethod }}
          </strong>

        </div>


        <!-- BUTTONS -->

        <button
          type="button"
          class="primary-btn"
          @click="continueShopping"
        >

          Continue Shopping

          <span>
            →
          </span>

        </button>


        <button
          type="button"
          class="secondary-btn"
          @click="viewOrderDetails"
        >

          View Order Details

        </button>


        <!-- HOME -->

        <button
          type="button"
          class="home-btn"
          @click="goHome"
        >

          ← Back to Home

        </button>


        <!-- SECURE -->

        <div class="secure">

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

          Secure order confirmation

        </div>

      </aside>

    </main>


    <!-- =========================
         SUPPORT
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

.place-order-page {
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
   SUCCESS
========================= */

.success-section {
  padding: 5rem 1.5rem 4rem;

  text-align: center;

  background: #f3f3f3;

  border-bottom: 1px solid #dddddd;
}


.success-icon {
  width: 72px;

  height: 72px;

  margin: 0 auto 1.5rem;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111111;

  color: #ffffff;

  border-radius: 50%;
}


.success-label {
  margin: 0 0 0.7rem;

  color: #666666;

  font-size: 0.7rem;

  font-weight: 700;

  letter-spacing: 3px;
}


.success-section h1 {
  margin: 0 0 1rem;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 3.2rem;

  font-weight: 400;
}


.success-description {
  max-width: 500px;

  margin: 0 auto 1.8rem;

  color: #666666;

  font-size: 0.95rem;

  line-height: 1.7;
}


/* =========================
   ORDER NUMBER
========================= */

.order-number {
  display: inline-flex;

  flex-direction: column;

  gap: 0.35rem;

  padding: 0.9rem 1.5rem;

  background: #ffffff;

  border: 1px solid #d5d5d5;
}


.order-number span {
  color: #888888;

  font-size: 0.65rem;

  font-weight: 700;

  letter-spacing: 1.5px;
}


.order-number strong {
  font-size: 0.9rem;

  letter-spacing: 1px;
}


/* =========================
   CONTAINER
========================= */

.order-container {
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


.order-left {
  display: flex;

  flex-direction: column;

  gap: 2rem;
}


/* =========================
   ORDER CARD
========================= */

.order-card {
  padding: 2rem;

  background: #ffffff;

  border: 1px solid #dddddd;
}


.card-header {
  display: flex;

  align-items: flex-start;

  justify-content: space-between;

  gap: 1rem;

  padding-bottom: 1.4rem;

  border-bottom: 1px solid #eeeeee;
}


.card-label {
  margin: 0 0 0.4rem;

  color: #777777;

  font-size: 0.65rem;

  font-weight: 700;

  letter-spacing: 2px;
}


.card-header h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 1.6rem;

  font-weight: 500;
}


.order-date {
  color: #777777;

  font-size: 0.75rem;

  white-space: nowrap;
}


/* =========================
   ORDER ITEMS
========================= */

.order-items {
  display: flex;

  flex-direction: column;
}


.order-item {
  display: flex;

  align-items: center;

  gap: 1.2rem;

  padding: 1.4rem 0;

  border-bottom: 1px solid #eeeeee;
}


.order-item:last-child {
  border-bottom: none;

  padding-bottom: 0;
}


.item-image {
  width: 85px;

  height: 110px;

  flex-shrink: 0;

  overflow: hidden;

  background: #dddddd;
}


.item-image img {
  width: 100%;

  height: 100%;

  display: block;

  object-fit: cover;

  filter: grayscale(100%);
}


.item-info {
  flex: 1;
}


.item-info h3 {
  margin: 0 0 0.4rem;

  font-size: 0.95rem;

  font-weight: 600;
}


.item-info p {
  margin: 0 0 0.7rem;

  color: #777777;

  font-size: 0.75rem;
}


.item-info span {
  color: #888888;

  font-size: 0.72rem;
}


.item-price {
  font-size: 0.9rem;

  font-weight: 700;

  white-space: nowrap;
}


/* =========================
   SHIPPING
========================= */

.shipping-content {
  display: grid;

  grid-template-columns:
    repeat(2, 1fr);

  gap: 2rem;

  padding-top: 1.5rem;
}


.info-block {
  display: flex;

  flex-direction: column;

  gap: 0.4rem;
}


.info-block > span {
  margin-bottom: 0.3rem;

  color: #888888;

  font-size: 0.65rem;

  font-weight: 700;

  letter-spacing: 1.5px;
}


.info-block strong {
  font-size: 0.85rem;
}


.info-block p {
  margin: 0;

  color: #666666;

  font-size: 0.78rem;

  line-height: 1.5;
}


/* =========================
   PAYMENT INFO
========================= */

.payment-info {
  display: flex;

  align-items: center;

  gap: 1rem;

  padding-top: 1.5rem;
}


.payment-icon {
  width: 48px;

  height: 48px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #eeeeee;

  border-radius: 50%;
}


.payment-info strong {
  font-size: 0.9rem;
}


.payment-info p {
  margin: 0.35rem 0 0;

  color: #777777;

  font-size: 0.78rem;

  line-height: 1.5;
}


/* =========================
   SUMMARY
========================= */

.order-summary {
  position: sticky;

  top: 2rem;

  padding: 2rem;

  background: #f3f3f3;

  border: 1px solid #dddddd;
}


.summary-header {
  padding-bottom: 1.5rem;

  border-bottom: 1px solid #d7d7d7;
}


.summary-header p {
  margin: 0 0 0.5rem;

  color: #777777;

  font-size: 0.65rem;

  font-weight: 700;

  letter-spacing: 2px;
}


.summary-header h2 {
  margin: 0;

  font-size: 1.2rem;

  letter-spacing: 1px;
}


/* =========================
   STATUS
========================= */

.status-box {
  display: flex;

  align-items: center;

  gap: 0.9rem;

  margin: 1.5rem 0;

  padding: 1rem;

  background: #ffffff;

  border: 1px solid #dddddd;
}


.status-icon {
  width: 38px;

  height: 38px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111111;

  color: #ffffff;

  border-radius: 50%;
}


.status-box div:last-child {
  display: flex;

  flex-direction: column;

  gap: 0.25rem;
}


.status-box strong {
  font-size: 0.8rem;
}


.status-box span {
  color: #777777;

  font-size: 0.7rem;
}


/* =========================
   PRICES
========================= */

.summary-prices {
  padding: 0.5rem 0 1.3rem;
}


.summary-row {
  display: flex;

  align-items: center;

  justify-content: space-between;

  margin-bottom: 0.9rem;

  font-size: 0.8rem;
}


.summary-row span:first-child {
  color: #666666;
}


.summary-row strong {
  font-size: 0.8rem;
}


.free {
  font-size: 0.7rem;
}


.summary-divider {
  height: 1px;

  margin: 1.2rem 0;

  background: #cccccc;
}


.total-row {
  display: flex;

  align-items: center;

  justify-content: space-between;
}


.total-row span {
  font-size: 0.95rem;

  font-weight: 600;
}


.total-row strong {
  font-size: 1.2rem;

  font-weight: 700;
}


/* =========================
   PAYMENT SUMMARY
========================= */

.summary-payment {
  display: flex;

  flex-direction: column;

  gap: 0.4rem;

  padding: 1.2rem 0;

  border-top: 1px solid #d7d7d7;
}


.summary-payment span {
  color: #888888;

  font-size: 0.62rem;

  font-weight: 700;

  letter-spacing: 1.5px;
}


.summary-payment strong {
  font-size: 0.8rem;
}


/* =========================
   BUTTONS
========================= */

.primary-btn {
  width: 100%;

  display: flex;

  align-items: center;

  justify-content: space-between;

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


.primary-btn:hover {
  background: #444444;

  transform: translateY(-2px);
}


.primary-btn span {
  font-size: 1.1rem;
}


.secondary-btn {
  width: 100%;

  margin-top: 0.8rem;

  padding: 0.9rem;

  border: 1px solid #bbbbbb;

  background: #ffffff;

  color: #111111;

  font-size: 0.78rem;

  cursor: pointer;

  transition: background 0.2s ease;
}


.secondary-btn:hover {
  background: #e8e8e8;
}


.home-btn {
  width: 100%;

  margin-top: 0.8rem;

  padding: 0.8rem;

  border: none;

  background: transparent;

  color: #555555;

  font-size: 0.75rem;

  cursor: pointer;
}


.home-btn:hover {
  color: #111111;
}


/* =========================
   SECURE
========================= */

.secure {
  display: flex;

  align-items: center;

  justify-content: center;

  gap: 0.4rem;

  margin-top: 1.2rem;

  color: #777777;

  font-size: 0.68rem;
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

  .order-container {
    grid-template-columns: 1fr;
  }


  .order-summary {
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


  .success-section {
    padding: 4rem 1.5rem 3rem;
  }


  .success-section h1 {
    font-size: 2.5rem;
  }


  .order-container {
    padding: 2.5rem 1rem 5rem;

    gap: 1.5rem;
  }


  .order-card {
    padding: 1.3rem;
  }


  .order-summary {
    padding: 1.3rem;
  }


  .shipping-content {
    grid-template-columns: 1fr;

    gap: 1.5rem;
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


  .success-section h1 {
    font-size: 2.2rem;
  }


  .order-item {
    align-items: flex-start;
  }


  .item-image {
    width: 70px;

    height: 90px;
  }


  .item-price {
    font-size: 0.75rem;
  }


  .card-header {
    flex-direction: column;
  }


  .order-date {
    font-size: 0.7rem;
  }

}

</style>