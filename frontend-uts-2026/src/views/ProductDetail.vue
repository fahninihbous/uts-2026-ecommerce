<template>
  <div class="product-page">

    <!-- ================= HEADER ================= -->
    <header class="header">
      <div class="header-inner">

        <!-- LEFT NAV -->
        <nav class="left-nav">
          <router-link to="/shop">SHOP</router-link>
          <router-link to="/mission">OUR MISSION</router-link>
        </nav>

        <!-- LOGO -->
        <router-link to="/home" class="logo">
          PROVIDENTIAL
        </router-link>

        <!-- RIGHT NAV -->
        <div class="right-nav">

          <!-- Search -->
          <router-link to="/search" class="icon-button">
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
              {{ quantity }}
            </span>
          </router-link>

          <!-- Profile -->
          <router-link to="/profile" class="icon-button">
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

      <section class="product-detail">

        <!-- LEFT : PLAIN PRODUCT AREA -->
        <div class="product-display">

          <div class="product-placeholder">
            <span>PROVIDENTIAL</span>
          </div>

        </div>


        <!-- RIGHT : PRODUCT INFORMATION -->
        <div class="product-info">

          <p class="product-category">
            APPAREL
          </p>

          <h1>
            Classic Oversized Shirt
          </h1>

          <p class="price">
            $75
          </p>

          <div class="line"></div>

          <p class="description">
            A timeless oversized shirt designed with simplicity,
            comfort, and effortless elegance in mind.
          </p>

          <p class="description">
            Crafted for everyday wear, this piece brings together
            clean details and a relaxed silhouette for a refined look.
          </p>


          <!-- PRODUCT INFORMATION -->
          <div class="information">

            <div class="info-row">
              <span>Material</span>
              <strong>Premium Cotton</strong>
            </div>

            <div class="info-row">
              <span>Color</span>
              <strong>Classic White</strong>
            </div>

            <div class="info-row">
              <span>Availability</span>
              <strong>In Stock</strong>
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
            >
              ADD TO CART
            </button>

            <button
              class="buy-button"
              @click="buyNow"
            >
              BUY IT NOW
            </button>

          </div>


          <p class="shipping-info">
            Free shipping on orders over $100
          </p>

        </div>

      </section>


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

import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const quantity = ref(1)


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


// Add to cart
const addToCart = () => {

  alert(
    `Classic Oversized Shirt added to cart. Quantity: ${quantity.value}`
  )

}


// Buy now
const buyNow = () => {

  router.push('/checkout')

}

</script>


<style scoped>

/* =====================================================
   GLOBAL
===================================================== */

* {
  box-sizing: border-box;
}

.product-page {
  min-height: 100vh;
  background: #ffffff;
  color: #111827;
  font-family: Georgia, "Times New Roman", serif;
}


/* =====================================================
   HEADER
===================================================== */

.header {
  height: 74px;
  background: #ffffff;
  position: relative;
  z-index: 10;
}

.header-inner {
  height: 100%;
  padding: 0 44px;

  display: grid;
  grid-template-columns: 1fr auto 1fr;

  align-items: center;
}


/* =====================================================
   LEFT NAV
===================================================== */

.left-nav {
  display: flex;
  align-items: center;
  gap: 28px;
}

.left-nav a {
  color: #0f172a;

  text-decoration: none;

  font-family: Arial, Helvetica, sans-serif;

  font-size: 13px;

  font-weight: 700;

  letter-spacing: 1.2px;

  transition: opacity 0.2s ease;
}

.left-nav a:hover {
  opacity: 0.55;
}


/* =====================================================
   LOGO
===================================================== */

.logo {
  color: #0f172a;

  text-decoration: none;

  font-family: Arial, Helvetica, sans-serif;

  font-size: 30px;

  font-weight: 700;

  letter-spacing: 4px;
}


/* =====================================================
   RIGHT NAV
===================================================== */

.right-nav {
  justify-self: end;

  display: flex;

  align-items: center;

  gap: 21px;
}

.icon-button {
  border: none;

  background: transparent;

  color: #0f172a;

  padding: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  cursor: pointer;

  text-decoration: none;
}

.cart-icon {
  position: relative;
}

.cart-count {
  position: absolute;

  top: -9px;

  right: -8px;

  width: 15px;

  height: 15px;

  border-radius: 50%;

  background: #ffffff;

  color: #111827;

  font-family: Arial, sans-serif;

  font-size: 9px;

  font-weight: 700;

  display: flex;

  align-items: center;

  justify-content: center;
}


/* =====================================================
   PRODUCT CONTAINER
===================================================== */

.product-container {
  max-width: 1400px;

  margin: auto;

  padding: 70px 58px 120px;
}


/* =====================================================
   BACK
===================================================== */

.back-link {
  display: inline-block;

  margin-bottom: 50px;

  color: #475569;

  font-family: Arial, sans-serif;

  font-size: 12px;

  text-decoration: none;
}

.back-link:hover {
  color: #111827;
}


/* =====================================================
   PRODUCT DETAIL
===================================================== */

.product-detail {
  display: grid;

  grid-template-columns: 1fr 1fr;

  gap: 100px;

  align-items: start;
}


/* =====================================================
   PRODUCT DISPLAY
===================================================== */

.product-display {
  width: 100%;
}

.product-placeholder {
  height: 650px;

  background: #f1f3f5;

  display: flex;

  align-items: center;

  justify-content: center;
}

.product-placeholder span {
  font-family: Arial, sans-serif;

  font-size: 20px;

  font-weight: 700;

  letter-spacing: 5px;

  color: #cbd5e1;
}


/* =====================================================
   PRODUCT INFO
===================================================== */

.product-info {
  padding-top: 30px;

  max-width: 520px;
}

.product-category {
  margin: 0 0 18px;

  font-family: Arial, sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 2px;

  color: #64748b;
}

.product-info h1 {
  margin: 0;

  font-size: clamp(42px, 5vw, 68px);

  line-height: 0.98;

  font-weight: 400;

  letter-spacing: -2px;
}

.price {
  margin: 25px 0;

  font-family: Arial, sans-serif;

  font-size: 17px;

  color: #334155;
}

.line {
  width: 100%;

  height: 1px;

  background: #cbd5e1;

  margin: 30px 0;
}

.description {
  font-family: Arial, sans-serif;

  font-size: 14px;

  line-height: 1.8;

  color: #64748b;

  margin-bottom: 15px;
}


/* =====================================================
   INFORMATION
===================================================== */

.information {
  margin-top: 35px;

  border-top: 1px solid #e2e8f0;
}

.info-row {
  display: flex;

  justify-content: space-between;

  padding: 15px 0;

  border-bottom: 1px solid #e2e8f0;

  font-family: Arial, sans-serif;

  font-size: 12px;
}

.info-row span {
  color: #64748b;
}

.info-row strong {
  font-weight: 500;

  color: #111827;
}


/* =====================================================
   QUANTITY
===================================================== */

.quantity-section {
  margin-top: 30px;
}

.quantity-section p {
  margin-bottom: 10px;

  font-family: Arial, sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 1.5px;

  color: #64748b;
}

.quantity {
  width: 110px;

  height: 42px;

  border: 1px solid #cbd5e1;

  display: flex;

  align-items: center;

  justify-content: space-between;
}

.quantity button {
  width: 35px;

  height: 100%;

  border: none;

  background: transparent;

  cursor: pointer;

  font-size: 18px;

  color: #334155;
}

.quantity span {
  font-family: Arial, sans-serif;

  font-size: 13px;
}


/* =====================================================
   BUTTONS
===================================================== */

.buttons {
  margin-top: 30px;

  display: flex;

  flex-direction: column;

  gap: 10px;
}

.add-button,
.buy-button {
  width: 100%;

  height: 55px;

  font-family: Arial, sans-serif;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 1px;

  cursor: pointer;

  transition: 0.2s;
}

.add-button {
  background: #111827;

  color: white;

  border: 1px solid #111827;
}

.add-button:hover {
  background: #334155;
}

.buy-button {
  background: white;

  color: #111827;

  border: 1px solid #111827;
}

.buy-button:hover {
  background: #f1f3f5;
}


/* =====================================================
   SHIPPING
===================================================== */

.shipping-info {
  margin-top: 18px;

  text-align: center;

  font-family: Arial, sans-serif;

  font-size: 10px;

  color: #64748b;
}


/* =====================================================
   BOTTOM DESCRIPTION
===================================================== */

.bottom-description {
  margin-top: 140px;

  padding-top: 70px;

  border-top: 1px solid #e2e8f0;

  display: grid;

  grid-template-columns: 1fr 1fr;

  gap: 100px;
}

.section-label {
  margin: 0 0 20px;

  font-family: Arial, sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 2px;

  color: #64748b;
}

.description-column h2 {
  margin: 0;

  font-size: 45px;

  line-height: 1;

  font-weight: 400;

  letter-spacing: -1px;
}

.description-text {
  max-width: 500px;
}

.description-text p {
  margin: 0 0 20px;

  font-family: Arial, sans-serif;

  font-size: 14px;

  line-height: 1.9;

  color: #64748b;
}


/* =====================================================
   FOOTER
===================================================== */

.footer {
  padding: 70px 58px 35px;

  background: #f1f3f5;

  text-align: center;
}

.footer-logo {
  font-family: Arial, sans-serif;

  font-size: 23px;

  font-weight: 700;

  letter-spacing: 3px;
}

.footer p {
  margin: 12px 0 35px;

  font-size: 13px;

  color: #64748b;
}

.footer-line {
  max-width: 1300px;

  height: 1px;

  background: #cbd5e1;

  margin: auto auto 25px;
}

.footer span {
  font-family: Arial, sans-serif;

  font-size: 10px;

  color: #64748b;
}


/* =====================================================
   SUPPORT
===================================================== */

.support-button {
  position: fixed;

  right: 16px;

  bottom: 12px;

  border: none;

  border-radius: 20px;

  background: #334155;

  color: white;

  padding: 10px 17px;

  font-family: Arial, sans-serif;

  font-size: 12px;

  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);

  cursor: pointer;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

  .product-detail {
    grid-template-columns: 1fr;

    gap: 50px;
  }

  .product-placeholder {
    height: 450px;
  }

  .product-info {
    max-width: none;
  }

  .bottom-description {
    grid-template-columns: 1fr;

    gap: 40px;
  }
}


@media (max-width: 600px) {

  .header-inner {
    padding: 0 20px;
  }

  .left-nav {
    gap: 12px;
  }

  .left-nav a {
    font-size: 10px;
  }

  .logo {
    font-size: 19px;

    letter-spacing: 2px;
  }

  .right-nav {
    gap: 12px;
  }

  .product-container {
    padding: 50px 22px 80px;
  }

  .product-placeholder {
    height: 350px;
  }

  .product-info h1 {
    font-size: 45px;
  }

  .bottom-description {
    margin-top: 90px;
  }

  .description-column h2 {
    font-size: 38px;
  }

  .footer {
    padding: 60px 22px 30px;
  }
}


@media (max-width: 450px) {

  .left-nav a:nth-child(2) {
    display: none;
  }

  .logo {
    font-size: 16px;
  }

  .product-placeholder {
    height: 280px;
  }

}

</style>