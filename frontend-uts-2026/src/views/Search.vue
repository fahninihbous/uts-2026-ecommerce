<template>
  <div class="search-page">

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


        <!-- RIGHT MENU -->
        <div class="right-nav">

          <!-- SEARCH -->
          <router-link
            to="/search"
            class="icon-button active"
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
          </router-link>


          <!-- CART -->
          <router-link
            to="/cart"
            class="cart-icon"
            title="Cart"
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
            title="Profile"
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



    <!-- ================= SEARCH CONTENT ================= -->
    <main class="search-container">

      <!-- PAGE HEADING -->
      <section class="search-heading">

        <p class="small-title">
          FIND YOUR STYLE
        </p>

        <h1>
          Search
        </h1>

        <p class="heading-description">
          Discover pieces that reflect your personal style.
        </p>

      </section>



      <!-- ================= SEARCH BOX ================= -->
      <section class="search-box-section">

        <form
          class="search-form"
          @submit.prevent="searchProducts"
        >

          <div class="search-input-wrapper">

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="23"
              height="23"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.7"
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

            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search products..."
            />

            <button
              v-if="searchQuery"
              type="button"
              class="clear-button"
              @click="clearSearch"
            >
              ×
            </button>

          </div>


          <button
            type="submit"
            class="search-button"
          >
            SEARCH
          </button>

        </form>

      </section>



      <!-- ================= SEARCH RESULTS ================= -->
      <section class="results-section">

        <!-- RESULTS HEADER -->
        <div class="results-header">

          <div>
            <p class="result-label">
              COLLECTION
            </p>

            <h2>
              {{ searchQuery
                ? `Results for "${searchQuery}"`
                : 'All Products'
              }}
            </h2>
          </div>


          <!-- CATEGORY FILTER -->
          <select
            v-model="selectedCategory"
            class="category-select"
          >
            <option value="All">
              All Categories
            </option>

            <option value="Apparel">
              Apparel
            </option>

            <option value="Outerwear">
              Outerwear
            </option>

            <option value="Accessories">
              Accessories
            </option>
          </select>

        </div>



        <!-- PRODUCT RESULTS -->
        <div
          v-if="filteredProducts.length > 0"
          class="product-list"
        >

          <div
            v-for="product in filteredProducts"
            :key="product.id"
            class="product-item"
          >

            <!-- NUMBER -->
            <div class="product-number">
              {{ String(product.id).padStart(2, '0') }}
            </div>


            <!-- PRODUCT INFORMATION -->
            <div class="product-information">

              <h3>
                {{ product.name }}
              </h3>

              <p>
                {{ product.category }}
              </p>

            </div>


            <!-- PRICE -->
            <div class="product-price">
              ${{ formatPrice(product.price) }}
            </div>


            <!-- ADD TO CART -->
            <button
              class="add-button"
              @click="addToCart(product)"
            >
              ADD TO CART
            </button>

          </div>

        </div>



        <!-- NO RESULTS -->
        <div
          v-else
          class="no-results"
        >

          <div class="no-results-icon">
            ×
          </div>

          <h2>
            No products found
          </h2>

          <p>
            We couldn't find anything matching your search.
          </p>

          <button
            class="reset-button"
            @click="resetSearch"
          >
            VIEW ALL PRODUCTS
          </button>

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



    <!-- ================= SUPPORT ================= -->
    <button class="support-button">
      ◉ &nbsp; Support
    </button>

  </div>
</template>



<script setup>

import {
  ref,
  computed
} from 'vue'


/* =========================================================
   SEARCH
========================================================= */

const searchQuery = ref('')

const selectedCategory = ref('All')



/* =========================================================
   CART
========================================================= */

const totalItems = ref(0)



/* =========================================================
   PRODUCT DATA
========================================================= */

const products = ref([

  {
    id: 1,
    name: 'Pastel Knit Sweater',
    category: 'Apparel',
    price: 89
  },

  {
    id: 2,
    name: 'Classic Oversized Shirt',
    category: 'Apparel',
    price: 75
  },

  {
    id: 3,
    name: 'Minimal Cotton T-Shirt',
    category: 'Apparel',
    price: 49
  },

  {
    id: 4,
    name: 'Essential Wool Coat',
    category: 'Outerwear',
    price: 149
  },

  {
    id: 5,
    name: 'Relaxed Linen Shirt',
    category: 'Apparel',
    price: 69
  },

  {
    id: 6,
    name: 'Classic Everyday Bag',
    category: 'Accessories',
    price: 95
  }

])



/* =========================================================
   FILTER PRODUCTS
========================================================= */

const filteredProducts = computed(() => {

  let result = products.value


  /* SEARCH */

  if (searchQuery.value.trim() !== '') {

    const keyword =
      searchQuery.value
        .toLowerCase()
        .trim()

    result = result.filter(product =>

      product.name
        .toLowerCase()
        .includes(keyword)

      ||

      product.category
        .toLowerCase()
        .includes(keyword)

    )

  }


  /* CATEGORY */

  if (selectedCategory.value !== 'All') {

    result = result.filter(product =>
      product.category === selectedCategory.value
    )

  }


  return result

})



/* =========================================================
   SEARCH FUNCTION
========================================================= */

const searchProducts = () => {

  // Filtering dilakukan otomatis
  // melalui computed filteredProducts

}



/* =========================================================
   CLEAR SEARCH
========================================================= */

const clearSearch = () => {

  searchQuery.value = ''

}



/* =========================================================
   RESET SEARCH
========================================================= */

const resetSearch = () => {

  searchQuery.value = ''

  selectedCategory.value = 'All'

}



/* =========================================================
   ADD TO CART
========================================================= */

const addToCart = (product) => {

  totalItems.value++

  alert(
    `${product.name} has been added to your cart.`
  )

}



/* =========================================================
   FORMAT PRICE
========================================================= */

const formatPrice = (price) => {

  return Number(price).toLocaleString('en-US')

}

</script>



<style scoped>

/* =========================================================
   GLOBAL
========================================================= */

* {
  box-sizing: border-box;
}


.search-page {

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

  position: relative;

  z-index: 10;

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
   LEFT NAV
========================================================= */

.left-nav {

  display: flex;

  align-items: center;

  gap: 28px;

}


.left-nav a {

  color: #0f172a;

  text-decoration: none;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 13px;

  font-weight: 700;

  letter-spacing: 1.2px;

  transition:
    opacity 0.2s ease;

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

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 30px;

  font-weight: 700;

  letter-spacing: 4px;

}



/* =========================================================
   RIGHT NAV
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

  align-items: center;

  justify-content: center;

  cursor: pointer;

  text-decoration: none;

}


.icon-button:hover {

  opacity: 0.5;

}


.icon-button.active {

  opacity: 1;

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

  align-items: center;

  justify-content: center;

}



/* =========================================================
   SEARCH CONTAINER
========================================================= */

.search-container {

  max-width: 1400px;

  margin: 0 auto;

  padding:
    90px
    58px
    120px;

}



/* =========================================================
   HEADING
========================================================= */

.search-heading {

  max-width: 700px;

  margin-bottom: 55px;

}


.small-title {

  margin:
    0
    0
    15px;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 2px;

  color: #64748b;

}


.search-heading h1 {

  margin: 0;

  font-size:
    clamp(
      50px,
      6vw,
      78px
    );

  line-height: 0.95;

  font-weight: 400;

  letter-spacing: -3px;

}


.heading-description {

  margin-top: 24px;

  max-width: 500px;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 14px;

  line-height: 1.7;

  color: #64748b;

}



/* =========================================================
   SEARCH BOX
========================================================= */

.search-box-section {

  margin-bottom: 85px;

}


.search-form {

  display: grid;

  grid-template-columns:
    1fr
    150px;

  gap: 12px;

  max-width: 1000px;

}


.search-input-wrapper {

  height: 62px;

  border:
    1px solid #cbd5e1;

  display: flex;

  align-items: center;

  padding:
    0
    20px;

  transition:
    border-color 0.2s ease;

}


.search-input-wrapper:focus-within {

  border-color: #111827;

}


.search-input-wrapper svg {

  flex-shrink: 0;

  color: #64748b;

}


.search-input-wrapper input {

  width: 100%;

  height: 100%;

  border: none;

  outline: none;

  padding:
    0
    16px;

  background: transparent;

  color: #111827;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 14px;

}


.search-input-wrapper input::placeholder {

  color: #94a3b8;

}


.clear-button {

  border: none;

  background: transparent;

  color: #64748b;

  font-size: 23px;

  cursor: pointer;

}



/* =========================================================
   SEARCH BUTTON
========================================================= */

.search-button {

  height: 62px;

  border: none;

  background: #111827;

  color: #ffffff;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 1px;

  cursor: pointer;

  transition:
    background 0.2s ease;

}


.search-button:hover {

  background: #334155;

}



/* =========================================================
   RESULTS
========================================================= */

.results-section {

  width: 100%;

}


.results-header {

  display: flex;

  justify-content: space-between;

  align-items: end;

  padding-bottom: 20px;

  border-bottom:
    1px solid #cbd5e1;

  margin-bottom: 0;

}


.result-label {

  margin: 0 0 10px;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 2px;

  color: #64748b;

}


.results-header h2 {

  margin: 0;

  font-size: 29px;

  font-weight: 400;

}



/* =========================================================
   CATEGORY
========================================================= */

.category-select {

  height: 40px;

  min-width: 170px;

  padding:
    0
    12px;

  border:
    1px solid #cbd5e1;

  background: #ffffff;

  color: #111827;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 12px;

  outline: none;

  cursor: pointer;

}



/* =========================================================
   PRODUCT LIST
========================================================= */

.product-list {

  width: 100%;

}


.product-item {

  min-height: 115px;

  display: grid;

  grid-template-columns:
    70px
    1fr
    150px
    150px;

  align-items: center;

  gap: 25px;

  border-bottom:
    1px solid #e2e8f0;

  transition:
    background 0.2s ease;

}


.product-item:hover {

  background: #f8fafc;

}


.product-number {

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 11px;

  color: #94a3b8;

}


.product-information h3 {

  margin: 0;

  font-size: 21px;

  font-weight: 400;

  color: #111827;

}


.product-information p {

  margin:
    8px
    0
    0;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 11px;

  color: #64748b;

}


.product-price {

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 13px;

  color: #334155;

}


.add-button {

  width: 130px;

  height: 40px;

  border:
    1px solid #111827;

  background: transparent;

  color: #111827;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 0.8px;

  cursor: pointer;

  transition:
    all 0.2s ease;

}


.add-button:hover {

  background: #111827;

  color: #ffffff;

}



/* =========================================================
   NO RESULTS
========================================================= */

.no-results {

  min-height: 350px;

  border-bottom:
    1px solid #e2e8f0;

  display: flex;

  flex-direction: column;

  align-items: center;

  justify-content: center;

  text-align: center;

}


.no-results-icon {

  width: 48px;

  height: 48px;

  border:
    1px solid #cbd5e1;

  border-radius: 50%;

  display: flex;

  align-items: center;

  justify-content: center;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 22px;

  color: #64748b;

  margin-bottom: 20px;

}


.no-results h2 {

  margin: 0;

  font-size: 30px;

  font-weight: 400;

}


.no-results p {

  margin:
    12px
    0
    25px;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 13px;

  color: #64748b;

}


.reset-button {

  border: none;

  background: #111827;

  color: #ffffff;

  padding:
    15px
    24px;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 1px;

  cursor: pointer;

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

  font-family:
    Arial,
    Helvetica,
    sans-serif;

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

  font-family:
    Arial,
    Helvetica,
    sans-serif;

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

  color: #ffffff;

  padding:
    10px
    17px;

  font-family:
    Arial,
    Helvetica,
    sans-serif;

  font-size: 12px;

  box-shadow:
    0 3px 12px
    rgba(
      0,
      0,
      0,
      0.15
    );

  cursor: pointer;

}



/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

  .product-item {

    grid-template-columns:
      50px
      1fr
      100px;

  }

  .add-button {

    display: none;

  }

}


@media (max-width: 700px) {

  .header-inner {

    padding:
      0
      20px;

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


  .search-container {

    padding:
      60px
      22px
      80px;

  }


  .search-heading {

    margin-bottom: 45px;

  }


  .search-heading h1 {

    font-size: 52px;

  }


  .search-form {

    grid-template-columns: 1fr;

  }


  .search-button {

    width: 100%;

  }


  .search-box-section {

    margin-bottom: 60px;

  }


  .results-header {

    align-items: flex-start;

    flex-direction: column;

    gap: 20px;

  }


  .category-select {

    width: 100%;

  }


  .product-item {

    grid-template-columns:
      35px
      1fr;

    gap: 12px;

    padding:
      25px
      0;

  }


  .product-price {

    grid-column: 2;

  }


  .add-button {

    display: block;

    grid-column: 2;

    width: 130px;

  }


  .footer {

    padding:
      60px
      22px
      30px;

  }

}


@media (max-width: 450px) {

  .left-nav a:nth-child(2) {

    display: none;

  }


  .logo {

    font-size: 17px;

  }


  .search-heading h1 {

    font-size: 44px;

  }


  .results-header h2 {

    font-size: 24px;

  }


  .product-information h3 {

    font-size: 18px;

  }

}

</style>