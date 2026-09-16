
<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// =========================
// USER DATA
// =========================
const user = ref({
  name: 'Naura Zahra',
  email: 'naura@example.com',
  phone: '0812 3456 7890',
  address: 'Bandung, Jawa Barat'
})

// =========================
// ORDERS
// =========================
const orders = ref([
  {
    id: '#PV-1024',
    date: '14 September 2026',
    item: 'Classic T-Shirt',
    total: 249000,
    status: 'Delivered'
  },
  {
    id: '#PV-1023',
    date: '10 September 2026',
    item: 'Minimal Jacket',
    total: 599000,
    status: 'Processing'
  },
  {
    id: '#PV-1021',
    date: '03 September 2026',
    item: 'Essential Shirt',
    total: 329000,
    status: 'Delivered'
  }
])

// =========================
// RUPIAH FORMAT
// =========================
const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(number)
}

// =========================
// STATS
// =========================
const totalOrders = computed(() => orders.value.length)

const completedOrders = computed(() => {
  return orders.value.filter(
    order => order.status === 'Delivered'
  ).length
})

// =========================
// NAVIGATION
// =========================
const goHome = () => {
  router.push('/home')
}

const goShop = () => {
  router.push('/shop')
}

const goProfile = () => {
  router.push('/profile')
}

const goOrders = () => {
  router.push('/orders')
}

const logout = () => {
  alert('Logout berhasil!')
  router.push('/home')
}
</script>

<template>
  <div class="user-page">

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

      <button class="logo" @click="goHome">
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
         WELCOME HEADER
    ================================== -->
    <section class="hero">

      <div class="hero-number">
        01 / ACCOUNT
      </div>

      <div class="hero-content">

        <div>
          <p class="eyebrow">
            WELCOME BACK
          </p>

          <h1>
            Hello,<br>
            <span>{{ user.name }}</span>
          </h1>
        </div>

        <div class="hero-description">
          <p>
            Manage your personal information,
            orders, and account preferences
            from one place.
          </p>

          <button
            class="shop-button"
            @click="goShop"
          >
            CONTINUE SHOPPING
            <span>→</span>
          </button>
        </div>

      </div>

    </section>


    <!-- =================================
         ACCOUNT CONTENT
    ================================== -->
    <main class="account-content">

      <!-- =================================
           PROFILE SECTION
      ================================== -->
      <section class="profile-section">

        <div class="section-label">
          <span>01</span>
          PERSONAL INFORMATION
        </div>

        <div class="profile-grid">

          <!-- PROFILE INTRO -->
          <div class="profile-intro">

            <div class="avatar">
              {{ user.name.charAt(0) }}
            </div>

            <div>
              <h2>
                {{ user.name }}
              </h2>

              <p>
                {{ user.email }}
              </p>
            </div>

          </div>


          <!-- PROFILE DETAILS -->
          <div class="profile-details">

            <div class="detail-row">
              <span>FULL NAME</span>
              <strong>
                {{ user.name }}
              </strong>
            </div>

            <div class="detail-row">
              <span>EMAIL</span>
              <strong>
                {{ user.email }}
              </strong>
            </div>

            <div class="detail-row">
              <span>PHONE</span>
              <strong>
                {{ user.phone }}
              </strong>
            </div>

            <div class="detail-row">
              <span>LOCATION</span>
              <strong>
                {{ user.address }}
              </strong>
            </div>

          </div>

        </div>

      </section>


      <!-- =================================
           ACCOUNT STATISTICS
      ================================== -->
      <section class="stats-section">

        <div class="section-label">
          <span>02</span>
          ACCOUNT OVERVIEW
        </div>

        <div class="stats-grid">

          <div class="stat-card">
            <span>TOTAL ORDERS</span>

            <strong>
              {{ totalOrders }}
            </strong>
          </div>

          <div class="stat-card">
            <span>COMPLETED</span>

            <strong>
              {{ completedOrders }}
            </strong>
          </div>

          <div class="stat-card">
            <span>MEMBER SINCE</span>

            <strong>
              2026
            </strong>
          </div>

        </div>

      </section>


      <!-- =================================
           ORDERS
      ================================== -->
      <section class="orders-section">

        <div class="section-header">

          <div class="section-label">
            <span>03</span>
            RECENT ORDERS
          </div>

          <button
            class="text-button"
            @click="goOrders"
          >
            VIEW ALL ORDERS →
          </button>

        </div>


        <div class="orders-list">

          <div
            v-for="order in orders"
            :key="order.id"
            class="order-card"
          >

            <!-- ORDER NUMBER -->
            <div class="order-number">

              <span>
                ORDER
              </span>

              <h3>
                {{ order.id }}
              </h3>

            </div>


            <!-- ORDER INFORMATION -->
            <div class="order-details">

              <div>
                <span>DATE</span>
                <strong>
                  {{ order.date }}
                </strong>
              </div>

              <div>
                <span>ITEM</span>
                <strong>
                  {{ order.item }}
                </strong>
              </div>

              <div>
                <span>TOTAL</span>
                <strong>
                  {{ formatRupiah(order.total) }}
                </strong>
              </div>

            </div>


            <!-- STATUS -->
            <div
              class="order-status"
              :class="{
                delivered: order.status === 'Delivered',
                processing: order.status === 'Processing'
              }"
            >
              {{ order.status }}
            </div>

          </div>

        </div>

      </section>


      <!-- =================================
           ADDRESS
      ================================== -->
      <section class="address-section">

        <div class="section-label">
          <span>04</span>
          SHIPPING ADDRESS
        </div>

        <div class="address-card">

          <div class="address-top">

            <span>
              DEFAULT ADDRESS
            </span>

            <span class="address-mark">
              +
            </span>

          </div>

          <h2>
            {{ user.name }}
          </h2>

          <p>
            {{ user.address }}
          </p>

          <p>
            {{ user.phone }}
          </p>

        </div>

      </section>


      <!-- =================================
           ACCOUNT ACTIONS
      ================================== -->
      <section class="actions-section">

        <div class="section-label">
          <span>05</span>
          ACCOUNT
        </div>

        <div class="actions-grid">

          <button
            class="action-button"
            @click="goProfile"
          >
            <span>EDIT PROFILE</span>
            <strong>→</strong>
          </button>

          <button
            class="action-button"
            @click="goOrders"
          >
            <span>MY ORDERS</span>
            <strong>→</strong>
          </button>

          <button
            class="action-button logout"
            @click="logout"
          >
            <span>LOG OUT</span>
            <strong>→</strong>
          </button>

        </div>

      </section>

    </main>


    <!-- =================================
         FOOTER
    ================================== -->
    <footer class="footer">

      <div class="footer-top">

        <h2>
          PROVIDENTIAL
        </h2>

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

.user-page {
  min-height: 100vh;
  background: #ffffff;
  color: #111111;
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
  cursor: pointer;

  color: #111;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 22px;
  letter-spacing: 3px;
  font-weight: 600;
}


/* =================================
   HERO
================================= */

.hero {
  padding: 70px 8% 85px;
  border-bottom: 1px solid #111;
}

.hero-number {
  margin-bottom: 55px;

  font-size: 9px;
  letter-spacing: 2px;
  color: #888;
}

.hero-content {
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

.hero h1 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: clamp(55px, 8vw, 115px);
  line-height: 0.9;
  font-weight: 400;

  letter-spacing: -5px;
}

.hero h1 span {
  font-style: italic;
}

.hero-description {
  max-width: 400px;
}

.hero-description p {
  margin: 0 0 30px;

  color: #777;
  font-size: 13px;
  line-height: 1.8;
}

.shop-button {
  display: inline-flex;
  align-items: center;
  gap: 30px;

  padding: 15px 22px;

  border: 1px solid #111;
  background: #111;
  color: #fff;

  font-size: 9px;
  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.shop-button:hover {
  background: #fff;
  color: #111;
}

.shop-button span {
  font-size: 14px;
}


/* =================================
   ACCOUNT CONTENT
================================= */

.account-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 90px 8%;
}

.profile-section,
.stats-section,
.orders-section,
.address-section,
.actions-section {
  margin-bottom: 100px;
}


/* =================================
   SECTION LABEL
================================= */

.section-label {
  display: flex;
  align-items: center;
  gap: 20px;

  margin-bottom: 35px;

  font-size: 9px;
  letter-spacing: 2px;
  font-weight: 600;
}

.section-label span {
  color: #999;
}


/* =================================
   PROFILE
================================= */

.profile-grid {
  display: grid;
  grid-template-columns: 1fr 1.5fr;

  border-top: 1px solid #111;
  border-bottom: 1px solid #111;
}

.profile-intro {
  padding: 45px 35px;

  display: flex;
  align-items: center;
  gap: 25px;

  border-right: 1px solid #ddd;
}

.avatar {
  width: 75px;
  height: 75px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #111;
  color: #fff;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 30px;
}

.profile-intro h2 {
  margin: 0 0 7px;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 25px;
  font-weight: 400;
}

.profile-intro p {
  margin: 0;

  color: #777;
  font-size: 12px;
}

.profile-details {
  display: grid;
  grid-template-columns: 1fr 1fr;
}

.detail-row {
  padding: 30px;

  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}

.detail-row:nth-child(2n) {
  border-right: none;
}

.detail-row span {
  display: block;

  margin-bottom: 10px;

  color: #888;

  font-size: 8px;
  letter-spacing: 1.5px;
}

.detail-row strong {
  font-size: 13px;
  font-weight: 500;
}


/* =================================
   STATISTICS
================================= */

.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);

  border-top: 1px solid #111;
  border-bottom: 1px solid #111;
}

.stat-card {
  padding: 35px 30px;

  border-right: 1px solid #ddd;
}

.stat-card:last-child {
  border-right: none;
}

.stat-card span {
  display: block;

  margin-bottom: 15px;

  color: #888;

  font-size: 8px;
  letter-spacing: 1.5px;
}

.stat-card strong {
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 42px;
  font-weight: 400;
}


/* =================================
   ORDERS
================================= */

.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.text-button {
  border: none;
  background: transparent;

  font-size: 9px;
  letter-spacing: 1.5px;
  font-weight: 600;

  cursor: pointer;

  transition: opacity 0.3s ease;
}

.text-button:hover {
  opacity: 0.45;
}

.orders-list {
  display: flex;
  flex-direction: column;
}

.order-card {
  display: grid;
  grid-template-columns: 180px 1fr auto;
  align-items: center;
  gap: 40px;

  padding: 30px 0;

  border-top: 1px solid #ddd;

  transition: padding 0.3s ease;
}

.order-card:last-child {
  border-bottom: 1px solid #ddd;
}

.order-card:hover {
  padding-left: 10px;
  padding-right: 10px;
}

.order-number span {
  display: block;

  margin-bottom: 8px;

  color: #888;

  font-size: 8px;
  letter-spacing: 1.5px;
}

.order-number h3 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 23px;
  font-weight: 400;
}

.order-details {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}

.order-details span {
  display: block;

  margin-bottom: 8px;

  color: #888;

  font-size: 8px;
  letter-spacing: 1.5px;
}

.order-details strong {
  font-size: 12px;
  font-weight: 500;
}

.order-status {
  padding: 8px 14px;

  border: 1px solid #ccc;

  font-size: 8px;
  letter-spacing: 1.2px;
  text-transform: uppercase;
}

.order-status.delivered {
  background: #111;
  color: #fff;
  border-color: #111;
}

.order-status.processing {
  background: #fff;
  color: #111;
}


/* =================================
   ADDRESS
================================= */

.address-card {
  max-width: 650px;

  padding: 35px;

  border: 1px solid #ddd;
}

.address-top {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding-bottom: 20px;
  margin-bottom: 25px;

  border-bottom: 1px solid #eee;
}

.address-top span:first-child {
  color: #888;

  font-size: 8px;
  letter-spacing: 1.5px;
}

.address-mark {
  width: 28px;
  height: 28px;

  display: flex;
  align-items: center;
  justify-content: center;

  border: 1px solid #111;

  font-size: 16px;
}

.address-card h2 {
  margin: 0 0 15px;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 26px;
  font-weight: 400;
}

.address-card p {
  margin: 5px 0;

  color: #666;

  font-size: 12px;
  line-height: 1.6;
}


/* =================================
   ACTIONS
================================= */

.actions-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);

  border-top: 1px solid #111;
  border-bottom: 1px solid #111;
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 25px;

  border: none;
  border-right: 1px solid #ddd;

  background: #fff;
  color: #111;

  font-size: 9px;
  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.action-button:last-child {
  border-right: none;
}

.action-button:hover {
  background: #111;
  color: #fff;
}

.action-button strong {
  font-size: 16px;
  font-weight: 400;
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

.footer-top h2 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;
  font-size: 25px;
  font-weight: 400;
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

  .hero-content {
    grid-template-columns: 1fr;
    gap: 50px;
  }

  .profile-grid {
    grid-template-columns: 1fr;
  }

  .profile-intro {
    border-right: none;
    border-bottom: 1px solid #ddd;
  }

  .order-card {
    grid-template-columns: 150px 1fr;
  }

  .order-status {
    justify-self: start;
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


  .hero {
    padding: 55px 25px 65px;
  }

  .hero-number {
    margin-bottom: 40px;
  }

  .hero h1 {
    font-size: 58px;
    letter-spacing: -3px;
  }


  .account-content {
    padding: 60px 25px;
  }

  .profile-section,
  .stats-section,
  .orders-section,
  .address-section,
  .actions-section {
    margin-bottom: 70px;
  }


  .profile-intro {
    padding: 25px 20px;
  }

  .profile-details {
    grid-template-columns: 1fr;
  }

  .detail-row {
    border-right: none;
  }


  .stats-grid {
    grid-template-columns: 1fr;
  }

  .stat-card {
    border-right: none;
    border-bottom: 1px solid #ddd;
  }

  .stat-card:last-child {
    border-bottom: none;
  }


  .section-header {
    align-items: flex-start;
    flex-direction: column;
    gap: 20px;
  }


  .order-card {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 25px;

    padding: 25px 0;
  }

  .order-details {
    width: 100%;
    grid-template-columns: 1fr;
    gap: 18px;
  }


  .actions-grid {
    grid-template-columns: 1fr;
  }

  .action-button {
    border-right: none;
    border-bottom: 1px solid #ddd;
  }

  .action-button:last-child {
    border-bottom: none;
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