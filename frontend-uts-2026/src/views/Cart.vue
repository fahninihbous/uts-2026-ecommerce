<template>

  <div class="cart-page">

    <!-- ================= HEADER ================= -->

    <header class="header">

      <div class="header-inner">

        <!-- LEFT MENU -->
        <nav class="left-nav">

          <router-link to="/shop">
            SHOP
          </router-link>

          <router-link to="/mission">
            OUR MISSION
          </router-link>

        </nav>


        <!-- LOGO -->
        <router-link
          to="/home"
          class="logo"
        >
          PROVIDENTIAL
        </router-link>


        <!-- RIGHT ICON -->
        <div class="right-nav">

          <!-- SEARCH -->
          <button
            class="icon-button"
            title="Search"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="21"
              height="21"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >

              <circle
                cx="11"
                cy="11"
                r="7"
              />

              <path
                d="m20 20-4-4"
              />

            </svg>

          </button>


          <!-- CART -->
          <router-link
            to="/cart"
            class="cart-icon"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="22"
              height="22"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >

              <path
                d="M6 6h15l-1.5 9h-12z"
              />

              <path
                d="M6 6 5 3H2"
              />

              <circle
                cx="9"
                cy="20"
                r="1"
              />

              <circle
                cx="18"
                cy="20"
                r="1"
              />

            </svg>


            <span class="cart-count">
              {{ totalItems }}
            </span>

          </router-link>


          <!-- PROFILE -->
          <router-link
            to="/profile"
            class="icon-button"
          >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="21"
              height="21"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >

              <circle
                cx="12"
                cy="8"
                r="3"
              />

              <path
                d="M5 21c0-3.5 3-6 7-6s7 2.5 7 6"
              />

            </svg>

          </router-link>

        </div>

      </div>

    </header>



    <!-- ================= CART CONTENT ================= -->

    <main class="cart-container">


      <!-- TITLE -->

      <section class="cart-heading">

        <p class="small-title">
          YOUR SHOPPING BAG
        </p>

        <h1>
          Shopping Cart
        </h1>

        <p class="heading-description">
          Review your selected items before proceeding to checkout.
        </p>

      </section>



      <!-- ================= EMPTY CART ================= -->

      <section
        v-if="cart.length === 0"
        class="empty-cart"
      >

        <div class="empty-icon">
          🛒
        </div>

        <h2>
          Your cart is empty
        </h2>

        <p>
          Looks like you haven't added anything to your cart yet.
        </p>

        <router-link
          to="/shop"
          class="shop-button"
        >
          Continue Shopping
        </router-link>

      </section>



      <!-- ================= CART ================= -->

      <section
        v-else
        class="cart-content"
      >


        <!-- ================= PRODUCTS ================= -->

        <div class="cart-items">


          <!-- TABLE HEADER -->

          <div class="items-header">

            <span>
              PRODUCT
            </span>

            <span>
              PRICE
            </span>

            <span>
              QUANTITY
            </span>

            <span>
              TOTAL
            </span>

          </div>



          <!-- PRODUCT -->

          <div
            v-for="item in cart"
            :key="item.id"
            class="cart-item"
          >


            <!-- PRODUCT NAME -->

            <div class="product">

              <div class="product-info">

                <h3>
                  {{ item.name }}
                </h3>

                <p>
                  {{ item.category }}
                </p>

                <button
                  class="remove-button"
                  @click="removeItem(item.id)"
                >
                  Remove
                </button>

              </div>

            </div>



            <!-- PRICE -->

            <div class="price">

              ${{ formatPrice(item.price) }}

            </div>



            <!-- QUANTITY -->

            <div class="quantity">

              <button
                @click="decreaseQuantity(item)"
              >
                −
              </button>

              <span>
                {{ item.quantity }}
              </span>

              <button
                @click="increaseQuantity(item)"
              >
                +
              </button>

            </div>



            <!-- TOTAL -->

            <div class="item-total">

              ${{ formatPrice(item.price * item.quantity) }}

            </div>

          </div>



          <!-- CONTINUE SHOPPING -->

          <div class="continue-shopping">

            <router-link to="/shop">
              ← Continue Shopping
            </router-link>

          </div>

        </div>



        <!-- ================= SUMMARY ================= -->

        <aside class="summary">

          <div class="summary-header">

            <p>
              ORDER SUMMARY
            </p>

            <h2>
              Your Order
            </h2>

          </div>


          <div class="summary-row">

            <span>
              Subtotal
            </span>

            <strong>
              ${{ formatPrice(subtotal) }}
            </strong>

          </div>


          <div class="summary-row">

            <span>
              Shipping
            </span>

            <span>
              {{
                shipping === 0
                  ? 'FREE'
                  : '$' + formatPrice(shipping)
              }}
            </span>

          </div>


          <div class="summary-line"></div>


          <div class="summary-total">

            <span>
              Total
            </span>

            <strong>
              ${{ formatPrice(grandTotal) }}
            </strong>

          </div>


          <button
            class="checkout-button"
            @click="checkout"
          >
            Proceed to Checkout
          </button>


          <p class="secure-text">
            Secure checkout · Fast delivery · Easy returns
          </p>

        </aside>

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

import { ref, computed } from 'vue'


/* ================= CART DATA ================= */

const cart = ref([

  {
    id: 1,
    name: 'Pastel Knit Sweater',
    category: 'Apparel',
    price: 89,
    quantity: 1
  },

  {
    id: 2,
    name: 'Classic Oversized Shirt',
    category: 'Apparel',
    price: 75,
    quantity: 2
  },

  {
    id: 3,
    name: 'Minimal Cotton T-Shirt',
    category: 'Apparel',
    price: 49,
    quantity: 1
  }

])


/* ================= TOTAL ITEM ================= */

const totalItems = computed(() => {

  return cart.value.reduce(
    (total, item) => total + item.quantity,
    0
  )

})


/* ================= SUBTOTAL ================= */

const subtotal = computed(() => {

  return cart.value.reduce(
    (total, item) =>
      total + item.price * item.quantity,
    0
  )

})


/* ================= SHIPPING ================= */

const shipping = computed(() => {

  if (subtotal.value >= 100) {
    return 0
  }

  return 10

})


/* ================= GRAND TOTAL ================= */

const grandTotal = computed(() => {

  return subtotal.value + shipping.value

})


/* ================= FORMAT PRICE ================= */

const formatPrice = (price) => {

  return Number(price).toLocaleString('en-US')

}


/* ================= ADD QUANTITY ================= */

const increaseQuantity = (item) => {

  item.quantity++

}


/* ================= REDUCE QUANTITY ================= */

const decreaseQuantity = (item) => {

  if (item.quantity > 1) {

    item.quantity--

  }

}


/* ================= REMOVE ================= */

const removeItem = (id) => {

  cart.value = cart.value.filter(
    item => item.id !== id
  )

}


/* ================= CHECKOUT ================= */

const checkout = () => {

  if (cart.value.length === 0) {

    alert('Your cart is empty.')

    return

  }

  window.location.href = '/checkout'

}

</script>



<style scoped>

/* =========================================================
   GLOBAL
========================================================= */

* {
  box-sizing: border-box;
}


.cart-page {

  min-height: 100vh;

  background: #ffffff;

  color: #111827;

  font-family:
    Georgia,
    "Times New Roman",
    serif;

}



/* =========================================================
   HEADER
========================================================= */

.header {

  height: 74px;

  background: #ffffff;

}


.header-inner {

  height: 100%;

  padding: 0 44px;

  display: grid;

  grid-template-columns:
    1fr
    auto
    1fr;

  align-items: center;

}



/* =========================================================
   LEFT MENU
========================================================= */

.left-nav {

  display: flex;

  gap: 28px;

}


.left-nav a {

  color: #0f172a;

  text-decoration: none;

  font-family: Arial, sans-serif;

  font-size: 13px;

  font-weight: 700;

  letter-spacing: 1.2px;

}


.left-nav a:hover {

  opacity: 0.55;

}



/* =========================================================
   LOGO
========================================================= */

.logo {

  color: #0f172a;

  text-decoration: none;

  font-family: Arial, sans-serif;

  font-size: 30px;

  font-weight: 700;

  letter-spacing: 4px;

}



/* =========================================================
   RIGHT MENU
========================================================= */

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

  cursor: pointer;

}


.icon-button:hover {

  opacity: 0.5;

}


.cart-icon {

  position: relative;

  display: flex;

  color: #0f172a;

  text-decoration: none;

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

  justify-content: center;

  align-items: center;

}



/* =========================================================
   CONTAINER
========================================================= */

.cart-container {

  max-width: 1400px;

  margin: auto;

  padding:
    90px
    58px
    120px;

}



/* =========================================================
   HEADING
========================================================= */

.cart-heading {

  max-width: 700px;

  margin-bottom: 70px;

}


.small-title {

  margin: 0 0 15px;

  font-family: Arial, sans-serif;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 2px;

  color: #64748b;

}


.cart-heading h1 {

  margin: 0;

  font-size: clamp(
    45px,
    5vw,
    72px
  );

  line-height: 0.95;

  font-weight: 400;

  letter-spacing: -2px;

}


.heading-description {

  margin-top: 24px;

  max-width: 500px;

  font-family: Arial, sans-serif;

  font-size: 14px;

  line-height: 1.7;

  color: #64748b;

}



/* =========================================================
   CART CONTENT
========================================================= */

.cart-content {

  display: grid;

  grid-template-columns:
    minmax(0, 1fr)
    380px;

  gap: 80px;

  align-items: start;

}



/* =========================================================
   HEADER TABLE
========================================================= */

.items-header {

  display: grid;

  grid-template-columns:
    2fr
    0.7fr
    0.9fr
    0.7fr;

  padding-bottom: 17px;

  border-bottom:
    1px solid #cbd5e1;

  font-family: Arial, sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 1.5px;

  color: #64748b;

}



/* =========================================================
   CART ITEM
========================================================= */

.cart-item {

  display: grid;

  grid-template-columns:
    2fr
    0.7fr
    0.9fr
    0.7fr;

  align-items: center;

  min-height: 145px;

  border-bottom:
    1px solid #e2e8f0;

}



/* =========================================================
   PRODUCT
========================================================= */

.product {

  display: flex;

  align-items: center;

}


.product-info h3 {

  margin: 0;

  font-size: 20px;

  font-weight: 400;

  color: #111827;

}


.product-info p {

  margin:
    8px
    0
    18px;

  font-family: Arial, sans-serif;

  font-size: 12px;

  color: #64748b;

}


.remove-button {

  border: none;

  padding: 0;

  background: transparent;

  color: #64748b;

  font-family: Arial, sans-serif;

  font-size: 11px;

  text-decoration: underline;

  cursor: pointer;

}



/* =========================================================
   PRICE
========================================================= */

.price,
.item-total {

  font-family: Arial, sans-serif;

  font-size: 13px;

  color: #1e293b;

}


.item-total {

  font-weight: 600;

}



/* =========================================================
   QUANTITY
========================================================= */

.quantity {

  width: 100px;

  height: 38px;

  border:
    1px solid #cbd5e1;

  display: flex;

  align-items: center;

  justify-content: space-between;

}


.quantity button {

  width: 32px;

  height: 100%;

  border: none;

  background: transparent;

  font-size: 18px;

  color: #334155;

  cursor: pointer;

}


.quantity button:hover {

  background: #e5e7eb;

}


.quantity span {

  font-family: Arial, sans-serif;

  font-size: 13px;

}



/* =========================================================
   CONTINUE SHOPPING
========================================================= */

.continue-shopping {

  padding-top: 28px;

}


.continue-shopping a {

  color: #111827;

  font-family: Arial, sans-serif;

  font-size: 12px;

  text-decoration: none;

  border-bottom:
    1px solid #111827;

  padding-bottom: 4px;

}



/* =========================================================
   SUMMARY
========================================================= */

.summary {

  background: #f1f3f5;

  padding:
    40px
    34px;

}


.summary-header p {

  margin:
    0
    0
    12px;

  font-family: Arial, sans-serif;

  font-size: 10px;

  letter-spacing: 2px;

  font-weight: 700;

  color: #64748b;

}


.summary-header h2 {

  margin:
    0
    0
    38px;

  font-size: 30px;

  font-weight: 400;

}



/* =========================================================
   SUMMARY ROW
========================================================= */

.summary-row {

  display: flex;

  justify-content: space-between;

  padding: 13px 0;

  font-family: Arial, sans-serif;

  font-size: 13px;

  color: #475569;

}


.summary-row strong {

  color: #111827;

  font-weight: 500;

}


.summary-line {

  height: 1px;

  background: #cbd5e1;

  margin: 25px 0;

}



/* =========================================================
   TOTAL
========================================================= */

.summary-total {

  display: flex;

  justify-content: space-between;

  align-items: center;

  margin-bottom: 30px;

}


.summary-total span {

  font-family: Arial, sans-serif;

  font-size: 13px;

  font-weight: 700;

  letter-spacing: 1px;

}


.summary-total strong {

  font-family: Arial, sans-serif;

  font-size: 19px;

}



/* =========================================================
   CHECKOUT
========================================================= */

.checkout-button {

  width: 100%;

  height: 55px;

  border: none;

  background: #111827;

  color: white;

  font-family: Arial, sans-serif;

  font-size: 12px;

  font-weight: 700;

  letter-spacing: 0.8px;

  cursor: pointer;

}


.checkout-button:hover {

  background: #334155;

}



/* =========================================================
   EMPTY CART
========================================================= */

.empty-cart {

  min-height: 450px;

  display: flex;

  flex-direction: column;

  align-items: center;

  justify-content: center;

  text-align: center;

  border-top:
    1px solid #e2e8f0;

  border-bottom:
    1px solid #e2e8f0;

}


.empty-icon {

  font-size: 38px;

  margin-bottom: 20px;

  filter: grayscale(1);

}


.empty-cart h2 {

  margin: 0;

  font-size: 34px;

  font-weight: 400;

}


.empty-cart p {

  margin:
    12px
    0
    30px;

  font-family: Arial, sans-serif;

  font-size: 13px;

  color: #64748b;

}


.shop-button {

  padding:
    16px
    30px;

  background: #111827;

  color: white;

  text-decoration: none;

  font-family: Arial, sans-serif;

  font-size: 12px;

  font-weight: 700;

}



/* =========================================================
   FOOTER
========================================================= */

.footer {

  padding:
    70px
    58px
    35px;

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

  margin:
    12px
    0
    35px;

  font-size: 13px;

  color: #64748b;

}


.footer-line {

  max-width: 1300px;

  height: 1px;

  background: #cbd5e1;

  margin:
    auto
    auto
    25px;

}


.footer span {

  font-family: Arial, sans-serif;

  font-size: 10px;

  color: #64748b;

}



/* =========================================================
   SUPPORT
========================================================= */

.support-button {

  position: fixed;

  right: 16px;

  bottom: 12px;

  border: none;

  border-radius: 20px;

  background: #334155;

  color: white;

  padding:
    10px
    17px;

  font-family: Arial, sans-serif;

  font-size: 12px;

  box-shadow:
    0 3px 12px
    rgba(0, 0, 0, 0.15);

  cursor: pointer;

}



/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

  .cart-content {

    grid-template-columns: 1fr;

    gap: 50px;

  }

  .summary {

    max-width: 500px;

  }

}


@media (max-width: 700px) {

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

    font-size: 20px;

    letter-spacing: 2px;

  }

  .right-nav {

    gap: 12px;

  }

  .cart-container {

    padding:
      60px
      22px
      80px;

  }

  .cart-heading {

    margin-bottom: 45px;

  }

  .cart-heading h1 {

    font-size: 48px;

  }

  .items-header {

    display: none;

  }

  .cart-item {

    grid-template-columns: 1fr;

    gap: 18px;

    padding:
      25px
      0;

  }

  .price::before {

    content: "Price: ";

    color: #64748b;

  }

  .item-total::before {

    content: "Total: ";

    color: #64748b;

    font-weight: 400;

  }

}


@media (max-width: 450px) {

  .left-nav a:nth-child(2) {

    display: none;

  }

  .logo {

    font-size: 17px;

  }

  .cart-heading h1 {

    font-size: 42px;

  }

  .summary {

    padding:
      30px
      22px;

  }

}

</style>