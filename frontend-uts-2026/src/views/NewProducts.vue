<template>
  <div class="new-products-page">

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">

      <div class="nav-left">
        <router-link to="/shop" class="nav-link">
          SHOP
        </router-link>

        <router-link to="/categories" class="nav-link">
          CATEGORIES
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

        <router-link to="/cart" class="nav-link">
          CART
          <span class="cart-count">
            ({{ cartCount }})
          </span>
        </router-link>

        <router-link to="/user" class="nav-link">
          ACCOUNT
        </router-link>

      </div>

    </header>


    <!-- ================= HERO ================= -->
    <section class="hero">

      <div class="hero-overlay"></div>

      <div class="hero-content">

        <p class="eyebrow">
          NEW ARRIVALS / 2026
        </p>

        <h1>
          New<br />
          Products.
        </h1>

        <p class="hero-description">
          A new selection of timeless essentials,
          carefully designed for the everyday wardrobe.
        </p>

        <a
          href="#products"
          class="hero-button"
        >
          EXPLORE NEW ARRIVALS ↓
        </a>

      </div>

    </section>


    <!-- ================= INTRO ================= -->
    <section class="intro-section">

      <div class="intro-number">
        01
      </div>


      <div class="intro-content">

        <p class="eyebrow">
          JUST IN
        </p>

        <h2>
          New pieces.<br />
          Same philosophy.
        </h2>

        <p>
          Introducing our latest collection of carefully
          considered pieces. Clean silhouettes, neutral
          tones, and timeless designs made to last.
        </p>

      </div>

    </section>


    <!-- ================= PRODUCTS HEADER ================= -->
    <section
      id="products"
      class="products-section"
    >

      <div class="section-header">

        <div>

          <p class="eyebrow">
            LATEST COLLECTION
          </p>

          <h2>
            New Arrivals
          </h2>

        </div>


        <div class="section-meta">
          <span>
            {{ filteredProducts.length }} PRODUCTS
          </span>
        </div>

      </div>


      <!-- ================= FILTER ================= -->
      <div class="filter-bar">

        <div class="category-filter">

          <button
            v-for="category in categories"
            :key="category"
            :class="[
              'filter-button',
              {
                active:
                  selectedCategory === category
              }
            ]"
            @click="selectedCategory = category"
          >
            {{ category }}
          </button>

        </div>


        <div class="sort-wrapper">

          <label>
            SORT
          </label>

          <select v-model="sortBy">
            <option value="latest">
              Latest
            </option>

            <option value="low">
              Price: Low to High
            </option>

            <option value="high">
              Price: High to Low
            </option>

            <option value="name">
              Name: A-Z
            </option>
          </select>

        </div>

      </div>


      <!-- ================= PRODUCT GRID ================= -->
      <div
        v-if="filteredProducts.length"
        class="product-grid"
      >

        <article
          v-for="product in filteredProducts"
          :key="product.id"
          class="product-card"
        >

          <!-- PRODUCT IMAGE -->
          <div class="product-image">

            <img
              :src="product.image"
              :alt="product.name"
            />


            <!-- NEW LABEL -->
            <span class="new-label">
              NEW
            </span>


            <!-- SALE -->
            <span
              v-if="product.oldPrice"
              class="sale-label"
            >
              SALE
            </span>


            <!-- QUICK VIEW -->
            <button
              class="quick-view"
              @click="viewProduct(product)"
            >
              QUICK VIEW →
            </button>


            <!-- ADD TO CART -->
            <button
              class="add-cart"
              @click="addToCart(product)"
            >
              ADD TO CART
            </button>

          </div>


          <!-- PRODUCT DETAILS -->
          <div class="product-details">

            <p class="product-category">
              {{ product.category }}
            </p>

            <h3>
              {{ product.name }}
            </h3>


            <div class="price">

              <span class="current-price">
                {{ formatRupiah(product.price) }}
              </span>

              <span
                v-if="product.oldPrice"
                class="old-price"
              >
                {{ formatRupiah(product.oldPrice) }}
              </span>

            </div>

          </div>

        </article>

      </div>


      <!-- ================= EMPTY ================= -->
      <div
        v-else
        class="empty-state"
      >

        <span>
          ×
        </span>

        <h3>
          No products found.
        </h3>

        <p>
          Try another category.
        </p>

        <button
          @click="selectedCategory = 'ALL'"
        >
          VIEW ALL PRODUCTS
        </button>

      </div>

    </section>


    <!-- ================= FEATURED NEW PRODUCT ================= -->
    <section class="feature-section">

      <div class="feature-image">

        <img
          src="/images/new-featured.jpg"
          alt="New Providential Collection"
        />

      </div>


      <div class="feature-content">

        <p class="eyebrow">
          FEATURED NEW ARRIVAL
        </p>

        <h2>
          The everyday<br />
          overshirt.
        </h2>

        <p>
          Designed as a versatile layer for everyday wear.
          A relaxed silhouette with subtle details that
          complement every wardrobe.
        </p>


        <button
          class="feature-button"
          @click="addFeaturedToCart"
        >
          ADD TO CART — {{ formatRupiah(529000) }}
        </button>

      </div>

    </section>


    <!-- ================= PHILOSOPHY ================= -->
    <section class="philosophy">

      <div class="philosophy-content">

        <p class="eyebrow">
          OUR APPROACH
        </p>

        <h2>
          Made to be<br />
          worn repeatedly.
        </h2>

        <p>
          We create clothing that does not depend on trends.
          Every new product is designed to work naturally
          with what you already own.
        </p>

        <router-link
          to="/about"
          class="philosophy-link"
        >
          DISCOVER OUR MISSION →
        </router-link>

      </div>

    </section>


    <!-- ================= FOOTER ================= -->
    <footer class="footer">

      <div class="footer-brand">
        PROVIDENTIAL
      </div>


      <div class="footer-links">

        <router-link to="/shop">
          SHOP
        </router-link>

        <router-link to="/categories">
          CATEGORIES
        </router-link>

        <router-link to="/about">
          OUR MISSION
        </router-link>

        <router-link to="/user">
          ACCOUNT
        </router-link>

      </div>


      <p>
        © 2026 PROVIDENTIAL. ALL RIGHTS RESERVED.
      </p>

    </footer>

  </div>
</template>


<script setup>

import {
  ref,
  computed
} from 'vue'


/* =====================================================
   CART
===================================================== */

const cartCount = ref(0)


/* =====================================================
   CATEGORY
===================================================== */

const categories = [
  'ALL',
  'T-SHIRT',
  'SHIRT',
  'PANTS',
  'OUTERWEAR'
]


const selectedCategory = ref('ALL')


/* =====================================================
   SORT
===================================================== */

const sortBy = ref('latest')


/* =====================================================
   NEW PRODUCTS
===================================================== */

const products = ref([

  {
    id: 101,

    name: 'Essential Cotton Tee',

    category: 'T-SHIRT',

    price: 269000,

    oldPrice: null,

    image: '/images/new-tshirt-1.jpg',

    date: 10
  },


  {
    id: 102,

    name: 'Heavyweight Relaxed Tee',

    category: 'T-SHIRT',

    price: 299000,

    oldPrice: 349000,

    image: '/images/new-tshirt-2.jpg',

    date: 9
  },


  {
    id: 103,

    name: 'Signature Linen Shirt',

    category: 'SHIRT',

    price: 429000,

    oldPrice: null,

    image: '/images/new-shirt-1.jpg',

    date: 8
  },


  {
    id: 104,

    name: 'Relaxed Daily Shirt',

    category: 'SHIRT',

    price: 379000,

    oldPrice: null,

    image: '/images/new-shirt-2.jpg',

    date: 7
  },


  {
    id: 105,

    name: 'Relaxed Straight Pants',

    category: 'PANTS',

    price: 479000,

    oldPrice: null,

    image: '/images/new-pants-1.jpg',

    date: 6
  },


  {
    id: 106,

    name: 'Wide Pleated Pants',

    category: 'PANTS',

    price: 529000,

    oldPrice: 579000,

    image: '/images/new-pants-2.jpg',

    date: 5
  },


  {
    id: 107,

    name: 'Essential Overshirt',

    category: 'OUTERWEAR',

    price: 529000,

    oldPrice: null,

    image: '/images/new-outerwear-1.jpg',

    date: 4
  },


  {
    id: 108,

    name: 'Minimal Utility Jacket',

    category: 'OUTERWEAR',

    price: 649000,

    oldPrice: null,

    image: '/images/new-outerwear-2.jpg',

    date: 3
  }

])


/* =====================================================
   FILTER PRODUCTS
===================================================== */

const filteredProducts = computed(() => {

  let result = [
    ...products.value
  ]


  /* CATEGORY */

  if (
    selectedCategory.value !== 'ALL'
  ) {

    result = result.filter(
      product =>
        product.category ===
        selectedCategory.value
    )

  }


  /* SORT */

  if (sortBy.value === 'latest') {

    result.sort(
      (a, b) =>
        b.date - a.date
    )

  }


  if (sortBy.value === 'low') {

    result.sort(
      (a, b) =>
        a.price - b.price
    )

  }


  if (sortBy.value === 'high') {

    result.sort(
      (a, b) =>
        b.price - a.price
    )

  }


  if (sortBy.value === 'name') {

    result.sort(
      (a, b) =>
        a.name.localeCompare(b.name)
    )

  }


  return result

})


/* =====================================================
   RUPIAH FORMAT
===================================================== */

const formatRupiah = (price) => {

  return new Intl.NumberFormat(
    'id-ID',
    {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }
  ).format(price)

}


/* =====================================================
   ADD TO CART
===================================================== */

const addToCart = (product) => {

  cartCount.value++

  alert(
    `${product.name} berhasil ditambahkan ke keranjang.`
  )

}


/* =====================================================
   FEATURED PRODUCT
===================================================== */

const addFeaturedToCart = () => {

  cartCount.value++

  alert(
    'Essential Overshirt berhasil ditambahkan ke keranjang.'
  )

}


/* =====================================================
   QUICK VIEW
===================================================== */

const viewProduct = (product) => {

  alert(
    `${product.name}\n\n${formatRupiah(product.price)}`
  )

}

</script>


<style scoped>

/* =====================================================
   GENERAL
===================================================== */

.new-products-page {
  min-height: 100vh;

  background: #ffffff;

  color: #111111;

  font-family: 'Inter', Arial, sans-serif;
}


/* =====================================================
   NAVBAR
===================================================== */

.navbar {
  height: 82px;

  padding: 0 50px;

  display: flex;

  align-items: center;

  justify-content: space-between;

  border-bottom: 1px solid #dddddd;

  position: sticky;

  top: 0;

  z-index: 100;

  background: rgba(
    255,
    255,
    255,
    0.96
  );

  backdrop-filter: blur(10px);
}


.nav-left,
.nav-right {
  display: flex;

  align-items: center;

  gap: 24px;
}


.nav-link {
  color: #111111;

  text-decoration: none;

  font-size: 9px;

  letter-spacing: 1.7px;

  transition: opacity 0.3s ease;
}


.nav-link:hover {
  opacity: 0.5;
}


.brand {
  color: #111111;

  text-decoration: none;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 23px;

  letter-spacing: 5px;
}


.cart-count {
  font-size: 8px;
}


/* =====================================================
   HERO
===================================================== */

.hero {
  min-height: 680px;

  position: relative;

  display: flex;

  align-items: flex-end;

  padding: 90px 50px;

  background-image:
    url('/images/new-products-hero.jpg');

  background-size: cover;

  background-position: center;

  color: #ffffff;
}


.hero-overlay {
  position: absolute;

  inset: 0;

  background:
    linear-gradient(
      to top,
      rgba(0, 0, 0, 0.65),
      rgba(0, 0, 0, 0.05)
    );
}


.hero-content {
  position: relative;

  z-index: 2;

  max-width: 850px;
}


.hero .eyebrow {
  color: #dddddd;
}


.eyebrow {
  margin: 0 0 22px;

  font-size: 9px;

  letter-spacing: 3px;
}


.hero h1 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size:
    clamp(
      65px,
      10vw,
      130px
    );

  font-weight: 400;

  line-height: 0.88;

  letter-spacing: -4px;
}


.hero-description {
  max-width: 480px;

  margin: 35px 0;

  color: #dddddd;

  font-size: 13px;

  line-height: 1.8;
}


.hero-button {
  display: inline-block;

  color: #ffffff;

  text-decoration: none;

  border-bottom: 1px solid #ffffff;

  padding-bottom: 8px;

  font-size: 9px;

  letter-spacing: 2px;
}


/* =====================================================
   INTRO
===================================================== */

.intro-section {
  display: grid;

  grid-template-columns: 1fr 2fr;

  padding: 120px 50px;

  border-bottom: 1px solid #dddddd;
}


.intro-number {
  color: #999999;

  font-size: 9px;

  letter-spacing: 2px;
}


.intro-content {
  max-width: 650px;
}


.intro-content h2 {
  margin: 0 0 35px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size:
    clamp(
      45px,
      6vw,
      75px
    );

  font-weight: 400;

  line-height: 0.95;
}


.intro-content p:last-child {
  max-width: 470px;

  margin: 0;

  color: #777777;

  font-size: 13px;

  line-height: 1.9;
}


/* =====================================================
   PRODUCTS SECTION
===================================================== */

.products-section {
  padding: 100px 50px 130px;
}


.section-header {
  display: flex;

  justify-content: space-between;

  align-items: flex-end;

  padding-bottom: 25px;

  border-bottom: 1px solid #dddddd;

  margin-bottom: 25px;
}


.section-header h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 45px;

  font-weight: 400;
}


.section-meta {
  color: #999999;

  font-size: 9px;

  letter-spacing: 2px;
}


/* =====================================================
   FILTER
===================================================== */

.filter-bar {
  display: flex;

  justify-content: space-between;

  align-items: center;

  margin-bottom: 45px;

  gap: 20px;
}


.category-filter {
  display: flex;

  gap: 7px;

  flex-wrap: wrap;
}


.filter-button {
  padding: 9px 15px;

  border: 1px solid #dddddd;

  background: #ffffff;

  color: #111111;

  font-size: 8px;

  letter-spacing: 1.2px;

  cursor: pointer;

  transition: all 0.25s ease;
}


.filter-button:hover {
  border-color: #111111;
}


.filter-button.active {
  background: #111111;

  color: #ffffff;

  border-color: #111111;
}


/* SORT */

.sort-wrapper {
  display: flex;

  align-items: center;

  gap: 10px;
}


.sort-wrapper label {
  color: #999999;

  font-size: 8px;

  letter-spacing: 1.5px;
}


.sort-wrapper select {
  border: none;

  border-bottom: 1px solid #999999;

  background: #ffffff;

  padding: 7px 0;

  outline: none;

  font-size: 9px;

  cursor: pointer;
}


/* =====================================================
   PRODUCT GRID
===================================================== */

.product-grid {
  display: grid;

  grid-template-columns:
    repeat(4, 1fr);

  gap: 50px 20px;
}


.product-card {
  min-width: 0;
}


/* =====================================================
   PRODUCT IMAGE
===================================================== */

.product-image {
  position: relative;

  aspect-ratio: 0.78;

  overflow: hidden;

  background: #eeeeee;
}


.product-image img {
  width: 100%;

  height: 100%;

  display: block;

  object-fit: cover;

  transition:
    transform 0.7s ease;
}


.product-card:hover
.product-image img {
  transform: scale(1.04);
}


/* =====================================================
   LABELS
===================================================== */

.new-label,
.sale-label {
  position: absolute;

  top: 15px;

  left: 15px;

  padding: 7px 10px;

  font-size: 8px;

  letter-spacing: 1.2px;
}


.new-label {
  background: #111111;

  color: #ffffff;
}


.sale-label {
  top: 48px;

  background: #ffffff;

  color: #111111;
}


/* =====================================================
   QUICK VIEW
===================================================== */

.quick-view {
  position: absolute;

  top: 15px;

  right: 15px;

  border: none;

  background: #ffffff;

  color: #111111;

  padding: 9px 11px;

  font-size: 8px;

  letter-spacing: 1px;

  cursor: pointer;

  opacity: 0;

  transform: translateY(-5px);

  transition:
    opacity 0.3s ease,
    transform 0.3s ease;
}


.product-card:hover
.quick-view {
  opacity: 1;

  transform: translateY(0);
}


/* =====================================================
   ADD CART
===================================================== */

.add-cart {
  position: absolute;

  bottom: 0;

  left: 0;

  width: 100%;

  padding: 17px;

  border: none;

  background: #111111;

  color: #ffffff;

  font-size: 9px;

  letter-spacing: 1.8px;

  cursor: pointer;

  transform: translateY(100%);

  transition:
    transform 0.3s ease;
}


.product-card:hover
.add-cart {
  transform: translateY(0);
}


.add-cart:hover {
  background: #333333;
}


/* =====================================================
   PRODUCT DETAILS
===================================================== */

.product-details {
  padding-top: 18px;
}


.product-category {
  margin: 0 0 8px;

  color: #999999;

  font-size: 8px;

  letter-spacing: 1.5px;
}


.product-details h3 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 17px;

  font-weight: 400;
}


.price {
  display: flex;

  align-items: center;

  gap: 10px;

  margin-top: 10px;
}


.current-price {
  font-size: 11px;
}


.old-price {
  color: #999999;

  font-size: 10px;

  text-decoration: line-through;
}


/* =====================================================
   EMPTY
===================================================== */

.empty-state {
  min-height: 350px;

  display: flex;

  flex-direction: column;

  align-items: center;

  justify-content: center;

  text-align: center;
}


.empty-state > span {
  width: 45px;

  height: 45px;

  border: 1px solid #dddddd;

  border-radius: 50%;

  display: flex;

  align-items: center;

  justify-content: center;

  font-size: 20px;

  margin-bottom: 20px;
}


.empty-state h3 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 28px;

  font-weight: 400;
}


.empty-state p {
  color: #888888;

  font-size: 12px;
}


.empty-state button {
  margin-top: 15px;

  border: 1px solid #111111;

  background: #111111;

  color: #ffffff;

  padding: 13px 20px;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;
}


/* =====================================================
   FEATURE
===================================================== */

.feature-section {
  display: grid;

  grid-template-columns: 1.2fr 1fr;

  min-height: 650px;

  background: #111111;

  color: #ffffff;
}


.feature-image {
  min-height: 650px;

  overflow: hidden;
}


.feature-image img {
  width: 100%;

  height: 100%;

  object-fit: cover;

  display: block;
}


.feature-content {
  padding: 80px;

  display: flex;

  flex-direction: column;

  justify-content: center;
}


.feature-content .eyebrow {
  color: #999999;
}


.feature-content h2 {
  margin: 0 0 35px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size:
    clamp(
      45px,
      5vw,
      75px
    );

  font-weight: 400;

  line-height: 0.95;
}


.feature-content p:not(.eyebrow) {
  max-width: 420px;

  margin: 0 0 35px;

  color: #aaaaaa;

  font-size: 13px;

  line-height: 1.9;
}


.feature-button {
  align-self: flex-start;

  border: 1px solid #ffffff;

  background: transparent;

  color: #ffffff;

  padding: 15px 20px;

  font-size: 9px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}


.feature-button:hover {
  background: #ffffff;

  color: #111111;
}


/* =====================================================
   PHILOSOPHY
===================================================== */

.philosophy {
  padding: 130px 50px;

  border-bottom: 1px solid #dddddd;
}


.philosophy-content {
  max-width: 720px;

  margin: auto;

  text-align: center;
}


.philosophy-content h2 {
  margin: 0 0 35px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size:
    clamp(
      50px,
      6vw,
      80px
    );

  font-weight: 400;

  line-height: 0.95;
}


.philosophy-content p:not(.eyebrow) {
  max-width: 480px;

  margin: 0 auto 35px;

  color: #777777;

  font-size: 13px;

  line-height: 1.9;
}


.philosophy-link {
  color: #111111;

  text-decoration: none;

  font-size: 9px;

  letter-spacing: 1.8px;

  border-bottom: 1px solid #111111;

  padding-bottom: 7px;
}


/* =====================================================
   FOOTER
===================================================== */

.footer {
  padding: 45px 50px;

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 30px;

  border-top: 1px solid #dddddd;
}


.footer-brand {
  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 18px;

  letter-spacing: 3px;
}


.footer-links {
  display: flex;

  gap: 22px;

  flex-wrap: wrap;
}


.footer-links a {
  color: #111111;

  text-decoration: none;

  font-size: 8px;

  letter-spacing: 1.5px;
}


.footer p {
  margin: 0;

  color: #999999;

  font-size: 8px;

  letter-spacing: 1px;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1100px) {

  .product-grid {
    grid-template-columns:
      repeat(3, 1fr);
  }

}


@media (max-width: 900px) {

  .navbar {
    padding: 0 25px;
  }


  .nav-left,
  .nav-right {
    gap: 14px;
  }


  .brand {
    font-size: 18px;

    letter-spacing: 3px;
  }


  .hero {
    min-height: 580px;

    padding: 70px 25px;
  }


  .intro-section {
    padding: 90px 25px;
  }


  .products-section {
    padding: 80px 25px 100px;
  }


  .feature-section {
    grid-template-columns: 1fr;
  }


  .feature-image {
    min-height: 500px;
  }


  .feature-content {
    padding: 70px 25px;
  }


  .philosophy {
    padding: 100px 25px;
  }


  .footer {
    padding: 40px 25px;

    flex-wrap: wrap;
  }

}


@media (max-width: 650px) {

  .navbar {
    height: auto;

    padding: 20px;

    flex-wrap: wrap;

    gap: 18px;
  }


  .brand {
    width: 100%;

    order: -1;

    text-align: center;
  }


  .nav-left,
  .nav-right {
    width: 100%;

    justify-content: center;

    gap: 13px;
  }


  .nav-link {
    font-size: 7px;
  }


  .hero {
    min-height: 500px;

    padding: 50px 20px;
  }


  .hero h1 {
    font-size: 62px;

    letter-spacing: -2px;
  }


  .intro-section {
    display: block;

    padding: 70px 20px;
  }


  .intro-number {
    margin-bottom: 30px;
  }


  .intro-content h2 {
    font-size: 45px;
  }


  .products-section {
    padding: 65px 20px 80px;
  }


  .section-header {
    display: block;
  }


  .section-header h2 {
    font-size: 36px;
  }


  .section-meta {
    display: block;

    margin-top: 15px;
  }


  .filter-bar {
    flex-direction: column;

    align-items: flex-start;
  }


  .sort-wrapper {
    width: 100%;

    justify-content: space-between;
  }


  .sort-wrapper select {
    flex: 1;

    margin-left: 15px;
  }


  .product-grid {
    grid-template-columns:
      repeat(2, 1fr);

    gap: 35px 10px;
  }


  .product-details h3 {
    font-size: 14px;
  }


  .current-price {
    font-size: 10px;
  }


  .old-price {
    font-size: 9px;
  }


  .quick-view {
    display: none;
  }


  .add-cart {
    position: static;

    transform: none;

    margin-top: 10px;

    padding: 12px;
  }


  .product-card:hover
  .add-cart {
    transform: none;
  }


  .feature-image {
    min-height: 400px;
  }


  .feature-content {
    padding: 60px 20px;
  }


  .philosophy {
    padding: 80px 20px;
  }


  .footer {
    flex-direction: column;

    align-items: flex-start;

    padding: 35px 20px;
  }

}

</style>