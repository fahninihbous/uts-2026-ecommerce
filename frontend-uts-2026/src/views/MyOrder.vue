<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// =================================
// FILTER
// =================================
const activeFilter = ref('All')

// =================================
// ORDERS DATA
// =================================
const orders = ref([
  {
    id: '#PV-1024',
    date: '14 September 2026',
    products: [
      {
        name: 'Classic T-Shirt',
        category: 'T-Shirt',
        size: 'M',
        quantity: 1,
        price: 249000,
        image: '/images/new-tshirt-1.jpg'
      }
    ],
    subtotal: 249000,
    shipping: 15000,
    total: 264000,
    status: 'Delivered'
  },

  {
    id: '#PV-1023',
    date: '10 September 2026',
    products: [
      {
        name: 'Minimal Jacket',
        category: 'Outerwear',
        size: 'L',
        quantity: 1,
        price: 599000,
        image: '/images/new-outerwear-1.jpg'
      }
    ],
    subtotal: 599000,
    shipping: 15000,
    total: 614000,
    status: 'Processing'
  },

  {
    id: '#PV-1021',
    date: '03 September 2026',
    products: [
      {
        name: 'Essential Shirt',
        category: 'Shirt',
        size: 'M',
        quantity: 1,
        price: 329000,
        image: '/images/new-shirt-1.jpg'
      }
    ],
    subtotal: 329000,
    shipping: 15000,
    total: 344000,
    status: 'Delivered'
  },

  {
    id: '#PV-1018',
    date: '28 August 2026',
    products: [
      {
        name: 'Relaxed Pants',
        category: 'Pants',
        size: 'M',
        quantity: 1,
        price: 399000,
        image: '/images/new-pants-1.jpg'
      }
    ],
    subtotal: 399000,
    shipping: 15000,
    total: 414000,
    status: 'Shipped'
  }
])

// =================================
// FILTERED ORDERS
// =================================
const filteredOrders = computed(() => {
  if (activeFilter.value === 'All') {
    return orders.value
  }

  return orders.value.filter(
    order => order.status === activeFilter.value
  )
})

// =================================
// RUPIAH FORMAT
// =================================
const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(number)
}

// =================================
// NAVIGATION
// =================================
const goHome = () => {
  router.push('/home')
}

const goShop = () => {
  router.push('/shop')
}

const goAccount = () => {
  router.push('/user')
}

// =================================
// VIEW ORDER
// =================================
const viewOrder = (order) => {
  alert(`Detail pesanan ${order.id}`)
}

// =================================
// CONTINUE SHOPPING
// =================================
const continueShopping = () => {
  router.push('/shop')
}
</script>


<template>
  <div class="orders-page">

    <!-- =================================
         NAVBAR
    ================================== -->
    <header class="navbar">

      <div class="nav-left">

        <router-link to="/shop">
          SHOP
        </router-link>

        <router-link to="/about">
          OUR MISSION
        </router-link>

      </div>


      <button
        class="logo"
        @click="goHome"
      >
        PROVIDENTIAL
      </button>


      <div class="nav-right">

        <router-link to="/search">
          SEARCH
        </router-link>

        <router-link to="/cart">
          CART
        </router-link>

        <router-link
          to="/user"
          class="active"
        >
          ACCOUNT
        </router-link>

      </div>

    </header>


    <!-- =================================
         PAGE HEADER
    ================================== -->
    <section class="page-header">

      <div class="header-top">

        <span>
          01 / ACCOUNT
        </span>

        <span>
          {{ orders.length }} ORDERS
        </span>

      </div>


      <div class="header-content">

        <div>

          <p class="eyebrow">
            ORDER HISTORY
          </p>

          <h1>
            My<br>
            <span>Orders.</span>
          </h1>

        </div>


        <div class="header-description">

          <p>
            Track your purchases, review your order
            history, and manage your recent orders.
          </p>

          <button
            class="back-button"
            @click="goAccount"
          >
            ← BACK TO ACCOUNT
          </button>

        </div>

      </div>

    </section>


    <!-- =================================
         FILTER
    ================================== -->
    <section class="filter-section">

      <div class="filter-label">
        FILTER BY
      </div>

      <div class="filters">

        <button
          :class="{ active: activeFilter === 'All' }"
          @click="activeFilter = 'All'"
        >
          ALL
        </button>

        <button
          :class="{ active: activeFilter === 'Processing' }"
          @click="activeFilter = 'Processing'"
        >
          PROCESSING
        </button>

        <button
          :class="{ active: activeFilter === 'Shipped' }"
          @click="activeFilter = 'Shipped'"
        >
          SHIPPED
        </button>

        <button
          :class="{ active: activeFilter === 'Delivered' }"
          @click="activeFilter = 'Delivered'"
        >
          DELIVERED
        </button>

      </div>

    </section>


    <!-- =================================
         ORDERS CONTENT
    ================================== -->
    <main class="orders-container">

      <!-- =================================
           ORDER LIST
      ================================== -->
      <div
        v-if="filteredOrders.length > 0"
        class="orders-list"
      >

        <article
          v-for="order in filteredOrders"
          :key="order.id"
          class="order-card"
        >

          <!-- ORDER HEADER -->
          <div class="order-header">

            <div class="order-number">

              <span>
                ORDER NUMBER
              </span>

              <h2>
                {{ order.id }}
              </h2>

            </div>


            <div class="order-date">

              <span>
                ORDER DATE
              </span>

              <strong>
                {{ order.date }}
              </strong>

            </div>


            <div
              class="status"
              :class="order.status.toLowerCase()"
            >
              {{ order.status }}
            </div>

          </div>


          <!-- PRODUCTS -->
          <div class="order-products">

            <div
              v-for="product in order.products"
              :key="product.name"
              class="product-row"
            >

              <!-- PRODUCT IMAGE -->
              <div class="product-image">

                <img
                  :src="product.image"
                  :alt="product.name"
                >

              </div>


              <!-- PRODUCT INFO -->
              <div class="product-info">

                <p class="product-category">
                  {{ product.category }}
                </p>

                <h3>
                  {{ product.name }}
                </h3>

                <div class="product-meta">

                  <span>
                    SIZE {{ product.size }}
                  </span>

                  <span>
                    QTY {{ product.quantity }}
                  </span>

                </div>

              </div>


              <!-- PRODUCT PRICE -->
              <div class="product-price">

                {{ formatRupiah(product.price) }}

              </div>

            </div>

          </div>


          <!-- ORDER FOOTER -->
          <div class="order-footer">

            <div class="order-summary">

              <div>
                <span>SUBTOTAL</span>
                <strong>
                  {{ formatRupiah(order.subtotal) }}
                </strong>
              </div>

              <div>
                <span>SHIPPING</span>
                <strong>
                  {{ formatRupiah(order.shipping) }}
                </strong>
              </div>

              <div class="total">

                <span>TOTAL</span>

                <strong>
                  {{ formatRupiah(order.total) }}
                </strong>

              </div>

            </div>


            <button
              class="details-button"
              @click="viewOrder(order)"
            >
              VIEW DETAILS →
            </button>

          </div>

        </article>

      </div>


      <!-- =================================
           EMPTY STATE
      ================================== -->
      <div
        v-else
        class="empty-orders"
      >

        <div class="empty-number">
          00
        </div>

        <h2>
          No orders found.
        </h2>

        <p>
          There are no orders in this category yet.
        </p>

        <button
          @click="activeFilter = 'All'"
        >
          VIEW ALL ORDERS
        </button>

      </div>


      <!-- =================================
           SHOP CTA
      ================================== -->
      <section class="shop-cta">

        <div>

          <p>
            LOOKING FOR SOMETHING NEW?
          </p>

          <h2>
            Discover our<br>
            <span>latest collection.</span>
          </h2>

        </div>


        <button
          @click="continueShopping"
        >
          SHOP COLLECTION
          <span>→</span>
        </button>

      </section>

    </main>


    <!-- =================================
         FOOTER
    ================================== -->
    <footer class="footer">

      <div class="footer-top">

        <div class="footer-logo">
          PROVIDENTIAL
        </div>

        <p>
          Designed for those who value simplicity.
        </p>

      </div>


      <div class="footer-bottom">

        <span>
          © 2026 PROVIDENTIAL
        </span>

        <div>

          <router-link to="/shop">
            SHOP
          </router-link>

          <router-link to="/about">
            OUR MISSION
          </router-link>

          <router-link to="/user">
            ACCOUNT
          </router-link>

        </div>

      </div>

    </footer>

  </div>
</template>


<style scoped>

/* =================================
   GENERAL
================================= */

.orders-page {
  min-height: 100vh;
  background: #fff;
  color: #111;
  font-family: 'Inter', Arial, sans-serif;
}


/* =================================
   NAVBAR
================================= */

.navbar {
  height: 78px;
  padding: 0 5%;

  display: grid;
  grid-template-columns: 1fr auto 1fr;
  align-items: center;

  border-bottom: 1px solid #e5e5e5;

  position: sticky;
  top: 0;
  z-index: 100;

  background: rgba(255, 255, 255, 0.96);
  backdrop-filter: blur(10px);
}

.nav-left,
.nav-right {
  display: flex;
  align-items: center;
  gap: 30px;
}

.nav-right {
  justify-content: flex-end;
}

.navbar a {
  color: #111;
  text-decoration: none;

  font-size: 10px;
  letter-spacing: 1.8px;
  font-weight: 500;

  transition: opacity 0.3s ease;
}

.navbar a:hover {
  opacity: 0.45;
}

.navbar .active {
  border-bottom: 1px solid #111;
  padding-bottom: 5px;
}

.logo {
  border: none;
  background: transparent;

  color: #111;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 22px;
  letter-spacing: 3px;
  font-weight: 600;

  cursor: pointer;
}


/* =================================
   PAGE HEADER
================================= */

.page-header {
  padding: 70px 8% 85px;
  border-bottom: 1px solid #111;
}

.header-top {
  display: flex;
  justify-content: space-between;

  margin-bottom: 55px;

  color: #888;

  font-size: 9px;
  letter-spacing: 2px;
}

.header-content {
  display: grid;
  grid-template-columns: 1.5fr 1fr;

  gap: 80px;

  align-items: end;
}

.eyebrow {
  margin: 0 0 22px;

  font-size: 10px;
  letter-spacing: 3px;
  font-weight: 600;
}

.header-content h1 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: clamp(60px, 9vw, 125px);

  line-height: 0.85;
  letter-spacing: -5px;
  font-weight: 400;
}

.header-content h1 span {
  font-style: italic;
}

.header-description {
  max-width: 390px;
}

.header-description p {
  margin: 0 0 30px;

  color: #777;

  font-size: 13px;
  line-height: 1.8;
}

.back-button {
  padding: 0;

  border: none;
  background: transparent;

  color: #111;

  font-size: 9px;
  letter-spacing: 1.5px;
  font-weight: 600;

  cursor: pointer;

  transition: opacity 0.3s ease;
}

.back-button:hover {
  opacity: 0.45;
}


/* =================================
   FILTER
================================= */

.filter-section {
  max-width: 1400px;

  margin: 0 auto;

  padding: 45px 8%;

  display: flex;
  align-items: center;
  gap: 50px;

  border-bottom: 1px solid #ddd;
}

.filter-label {
  color: #888;

  font-size: 8px;
  letter-spacing: 2px;
}

.filters {
  display: flex;
  gap: 30px;
}

.filters button {
  padding: 0 0 7px;

  border: none;
  border-bottom: 1px solid transparent;

  background: transparent;

  color: #888;

  font-size: 9px;
  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.filters button:hover {
  color: #111;
}

.filters button.active {
  color: #111;
  border-bottom-color: #111;
}


/* =================================
   ORDERS CONTAINER
================================= */

.orders-container {
  max-width: 1400px;

  margin: 0 auto;

  padding: 70px 8%;
}


/* =================================
   ORDER CARD
================================= */

.orders-list {
  display: flex;
  flex-direction: column;
  gap: 45px;
}

.order-card {
  border-top: 1px solid #111;

  transition: transform 0.3s ease;
}

.order-card:hover {
  transform: translateY(-2px);
}


/* =================================
   ORDER HEADER
================================= */

.order-header {
  min-height: 100px;

  display: grid;
  grid-template-columns: 1fr 1fr auto;

  align-items: center;

  gap: 30px;
}

.order-number span,
.order-date span {
  display: block;

  margin-bottom: 8px;

  color: #888;

  font-size: 8px;
  letter-spacing: 1.5px;
}

.order-number h2 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: 27px;
  font-weight: 400;
}

.order-date strong {
  font-size: 12px;
  font-weight: 500;
}


/* =================================
   STATUS
================================= */

.status {
  padding: 8px 14px;

  border: 1px solid #ccc;

  font-size: 8px;
  letter-spacing: 1.3px;

  text-transform: uppercase;
}

.status.delivered {
  background: #111;
  color: #fff;

  border-color: #111;
}

.status.processing {
  background: #fff;
  color: #111;
}

.status.shipped {
  background: #eee;
  color: #111;

  border-color: #eee;
}


/* =================================
   PRODUCTS
================================= */

.order-products {
  border-top: 1px solid #eee;
  border-bottom: 1px solid #eee;
}

.product-row {
  display: grid;
  grid-template-columns: 110px 1fr auto;

  gap: 30px;

  padding: 25px 0;
}

.product-image {
  width: 110px;
  height: 130px;

  overflow: hidden;

  background: #f3f3f3;
}

.product-image img {
  width: 100%;
  height: 100%;

  object-fit: cover;

  display: block;

  transition: transform 0.5s ease;
}

.order-card:hover .product-image img {
  transform: scale(1.04);
}

.product-category {
  margin: 3px 0 8px;

  color: #999;

  font-size: 8px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
}

.product-info h3 {
  margin: 0 0 18px;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: 24px;
  font-weight: 400;
}

.product-meta {
  display: flex;
  gap: 20px;

  color: #777;

  font-size: 8px;
  letter-spacing: 1.2px;
}

.product-price {
  align-self: center;

  font-size: 12px;
  font-weight: 500;
}


/* =================================
   ORDER FOOTER
================================= */

.order-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 30px 0;
}

.order-summary {
  display: flex;
  align-items: center;
  gap: 45px;
}

.order-summary div {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.order-summary span {
  color: #888;

  font-size: 8px;
  letter-spacing: 1.3px;
}

.order-summary strong {
  font-size: 12px;
  font-weight: 500;
}

.order-summary .total {
  padding-left: 45px;

  border-left: 1px solid #ddd;
}

.order-summary .total strong {
  font-family: 'Playfair Display', Georgia, serif;

  font-size: 20px;
  font-weight: 400;
}

.details-button {
  padding: 13px 20px;

  border: 1px solid #111;

  background: #111;
  color: #fff;

  font-size: 8px;
  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.details-button:hover {
  background: #fff;
  color: #111;
}


/* =================================
   EMPTY
================================= */

.empty-orders {
  padding: 100px 30px;

  text-align: center;

  border-top: 1px solid #111;
  border-bottom: 1px solid #111;
}

.empty-number {
  margin-bottom: 15px;

  color: #aaa;

  font-size: 9px;
  letter-spacing: 2px;
}

.empty-orders h2 {
  margin: 0 0 12px;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: 38px;
  font-weight: 400;
}

.empty-orders p {
  margin: 0 0 30px;

  color: #777;

  font-size: 12px;
}

.empty-orders button {
  padding: 13px 20px;

  border: 1px solid #111;

  background: #111;
  color: #fff;

  font-size: 8px;
  letter-spacing: 1.5px;

  cursor: pointer;
}


/* =================================
   SHOP CTA
================================= */

.shop-cta {
  margin-top: 110px;

  padding: 60px 0;

  border-top: 1px solid #111;
  border-bottom: 1px solid #111;

  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 50px;
}

.shop-cta p {
  margin: 0 0 20px;

  color: #888;

  font-size: 8px;
  letter-spacing: 2px;
}

.shop-cta h2 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: clamp(38px, 5vw, 65px);

  line-height: 0.95;
  font-weight: 400;
  letter-spacing: -2px;
}

.shop-cta h2 span {
  font-style: italic;
}

.shop-cta button {
  display: flex;
  align-items: center;
  gap: 35px;

  padding: 15px 22px;

  border: 1px solid #111;

  background: #111;
  color: #fff;

  font-size: 9px;
  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.shop-cta button:hover {
  background: #fff;
  color: #111;
}

.shop-cta button span {
  font-size: 15px;
}


/* =================================
   FOOTER
================================= */

.footer {
  padding: 70px 8% 35px;

  border-top: 1px solid #111;
}

.footer-top {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;

  padding-bottom: 60px;
}

.footer-logo {
  font-family: 'Playfair Display', Georgia, serif;

  font-size: 25px;
  letter-spacing: 3px;
}

.footer-top p {
  margin: 0;

  color: #777;

  font-size: 11px;
}

.footer-bottom {
  padding-top: 20px;

  border-top: 1px solid #ddd;

  display: flex;
  justify-content: space-between;
}

.footer-bottom span {
  color: #999;

  font-size: 8px;
  letter-spacing: 1px;
}

.footer-bottom div {
  display: flex;
  gap: 25px;
}

.footer-bottom a {
  color: #111;

  text-decoration: none;

  font-size: 8px;
  letter-spacing: 1.3px;
}


/* =================================
   TABLET
================================= */

@media (max-width: 900px) {

  .navbar {
    grid-template-columns: 1fr auto;
  }

  .nav-left {
    display: none;
  }

  .logo {
    justify-self: start;
  }

  .header-content {
    grid-template-columns: 1fr;

    gap: 50px;
  }

  .order-header {
    grid-template-columns: 1fr 1fr;
  }

  .status {
    justify-self: start;
  }

  .order-footer {
    align-items: flex-start;
    flex-direction: column;

    gap: 30px;
  }

  .shop-cta {
    align-items: flex-start;
    flex-direction: column;
  }

}


/* =================================
   MOBILE
================================= */

@media (max-width: 600px) {

  .navbar {
    height: 65px;

    padding: 0 20px;
  }

  .logo {
    font-size: 16px;
    letter-spacing: 2px;
  }

  .nav-right {
    gap: 12px;
  }

  .nav-right a {
    font-size: 8px;
  }

  .nav-right a:first-child {
    display: none;
  }


  .page-header {
    padding: 55px 25px 65px;
  }

  .header-top {
    margin-bottom: 40px;
  }

  .header-content h1 {
    font-size: 60px;
    letter-spacing: -3px;
  }


  .filter-section {
    padding: 30px 25px;

    align-items: flex-start;
    flex-direction: column;

    gap: 20px;

    overflow-x: auto;
  }

  .filters {
    gap: 20px;
    width: max-content;
  }


  .orders-container {
    padding: 55px 25px;
  }


  .order-card {
    overflow: hidden;
  }

  .order-header {
    grid-template-columns: 1fr;

    gap: 20px;

    padding: 25px 0;
  }


  .product-row {
    grid-template-columns: 80px 1fr;

    gap: 20px;
  }

  .product-image {
    width: 80px;
    height: 105px;
  }

  .product-info h3 {
    font-size: 20px;
  }

  .product-price {
    grid-column: 2;

    align-self: start;
  }


  .order-footer {
    padding: 25px 0;
  }

  .order-summary {
    width: 100%;

    display: grid;
    grid-template-columns: 1fr 1fr;

    gap: 20px;
  }

  .order-summary .total {
    padding-left: 0;

    border-left: none;
    grid-column: span 2;

    padding-top: 15px;

    border-top: 1px solid #ddd;
  }

  .details-button {
    width: 100%;
  }


  .shop-cta {
    margin-top: 70px;

    padding: 45px 0;
  }

  .shop-cta button {
    width: 100%;

    justify-content: space-between;
  }


  .footer {
    padding: 55px 25px 30px;
  }

  .footer-top {
    flex-direction: column;
    align-items: flex-start;

    gap: 20px;

    padding-bottom: 40px;
  }

  .footer-bottom {
    flex-direction: column;

    gap: 20px;
  }

  .footer-bottom div {
    gap: 15px;
  }

}
</style>