<template>
  <div class="shop-page">

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">
      <div class="nav-left">
        <router-link to="/shop" class="nav-link active">
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

        <router-link to="/cart" class="nav-link">
          CART
          <span class="cart-count">({{ cartCount }})</span>
        </router-link>

        <router-link to="/user" class="nav-link">
          ACCOUNT
        </router-link>
      </div>
    </header>


    <!-- ================= PAGE HEADER ================= -->
    <section class="shop-header">

      <div class="header-content">
        <p class="small-title">THE COLLECTION</p>

        <h1>Shop</h1>

        <p class="description">
          Discover timeless pieces designed with simplicity,
          comfort, and everyday elegance in mind.
        </p>
      </div>

    </section>


    <!-- ================= FILTER ================= -->
    <section class="shop-controls">

      <div class="categories">
        <button
          v-for="category in categories"
          :key="category"
          @click="selectedCategory = category"
          :class="[
            'category-btn',
            { active: selectedCategory === category }
          ]"
        >
          {{ category }}
        </button>
      </div>

      <div class="right-controls">

        <!-- SEARCH -->
        <div class="search-box">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search products..."
          />

          <span>⌕</span>
        </div>

        <!-- SORT -->
        <select v-model="sortBy" class="sort-select">
          <option value="featured">Featured</option>
          <option value="low">Price: Low to High</option>
          <option value="high">Price: High to Low</option>
          <option value="name">Name: A-Z</option>
        </select>

      </div>

    </section>


    <!-- ================= PRODUCT COUNT ================= -->
    <div class="product-info">
      <span>
        {{ filteredProducts.length }} PRODUCTS
      </span>

      <span v-if="selectedCategory !== 'ALL'">
        {{ selectedCategory }}
      </span>
    </div>


    <!-- ================= PRODUCTS ================= -->
    <main class="product-section">

      <div
        v-if="filteredProducts.length > 0"
        class="product-grid"
      >

        <article
          v-for="product in filteredProducts"
          :key="product.id"
          class="product-card"
        >

          <!-- IMAGE -->
          <div class="product-image">

            <img
              :src="product.image"
              :alt="product.name"
            />

            <!-- SALE -->
            <span
              v-if="product.oldPrice"
              class="sale-label"
            >
              SALE
            </span>

            <!-- FEATURED -->
            <span
              v-if="product.featured && !product.oldPrice"
              class="featured-label"
            >
              FEATURED
            </span>

            <!-- ADD TO CART -->
            <button
              class="add-cart"
              @click="addToCart(product)"
            >
              ADD TO CART
            </button>

          </div>


          <!-- PRODUCT INFO -->
          <div class="product-details">

            <div class="product-category">
              {{ product.category }}
            </div>

            <h2>
              {{ product.name }}
            </h2>

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

        <div class="empty-icon">
          ×
        </div>

        <h2>No products found</h2>

        <p>
          We couldn't find any products matching your search.
        </p>

        <button
          @click="resetFilter"
          class="reset-btn"
        >
          VIEW ALL PRODUCTS
        </button>

      </div>

    </main>


    <!-- ================= EDITORIAL BANNER ================= -->
    <section class="editorial">

      <div class="editorial-content">

        <p class="small-title">
          PROVIDENTIAL ESSENTIALS
        </p>

        <h2>
          Less, but better.
        </h2>

        <p>
          Our collection is created for those who appreciate
          thoughtful details, clean silhouettes, and pieces
          that remain relevant beyond the season.
        </p>

        <router-link
          to="/about"
          class="editorial-link"
        >
          OUR MISSION →
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

import { ref, computed } from 'vue'


/* ================= CART ================= */

const cartCount = ref(0)


/* ================= CATEGORY ================= */

const categories = [
  'ALL',
  'T-SHIRT',
  'SHIRT',
  'PANTS',
  'OUTERWEAR'
]

const selectedCategory = ref('ALL')


/* ================= SEARCH ================= */

const searchQuery = ref('')


/* ================= SORT ================= */

const sortBy = ref('featured')


/* ================= PRODUCTS ================= */

const products = ref([

  {
    id: 1,
    name: 'Essential T-Shirt',
    category: 'T-SHIRT',
    price: 249000,
    oldPrice: null,
    image: '/images/product-tshirt-1.jpg',
    featured: true
  },

  {
    id: 2,
    name: 'Classic T-Shirt',
    category: 'T-SHIRT',
    price: 279000,
    oldPrice: 329000,
    image: '/images/product-tshirt-2.jpg',
    featured: true
  },

  {
    id: 3,
    name: 'Essential Shirt',
    category: 'SHIRT',
    price: 329000,
    oldPrice: null,
    image: '/images/product-shirt-1.jpg',
    featured: true
  },

  {
    id: 4,
    name: 'Relaxed Oxford Shirt',
    category: 'SHIRT',
    price: 399000,
    oldPrice: null,
    image: '/images/product-shirt-2.jpg',
    featured: false
  },

  {
    id: 5,
    name: 'Straight Pants',
    category: 'PANTS',
    price: 449000,
    oldPrice: null,
    image: '/images/product-pants-1.jpg',
    featured: true
  },

  {
    id: 6,
    name: 'Wide Leg Pants',
    category: 'PANTS',
    price: 499000,
    oldPrice: 549000,
    image: '/images/product-pants-2.jpg',
    featured: false
  },

  {
    id: 7,
    name: 'Minimal Jacket',
    category: 'OUTERWEAR',
    price: 599000,
    oldPrice: null,
    image: '/images/product-jacket-1.jpg',
    featured: true
  },

  {
    id: 8,
    name: 'Daily Overshirt',
    category: 'OUTERWEAR',
    price: 529000,
    oldPrice: null,
    image: '/images/product-jacket-2.jpg',
    featured: false
  }

])


/* ================= FILTER + SORT ================= */

const filteredProducts = computed(() => {

  let result = [...products.value]


  /* CATEGORY */

  if (selectedCategory.value !== 'ALL') {

    result = result.filter(product =>
      product.category === selectedCategory.value
    )

  }


  /* SEARCH */

  if (searchQuery.value.trim() !== '') {

    const query = searchQuery.value.toLowerCase()

    result = result.filter(product =>
      product.name.toLowerCase().includes(query) ||
      product.category.toLowerCase().includes(query)
    )

  }


  /* SORT */

  if (sortBy.value === 'low') {

    result.sort((a, b) =>
      a.price - b.price
    )

  }

  else if (sortBy.value === 'high') {

    result.sort((a, b) =>
      b.price - a.price
    )

  }

  else if (sortBy.value === 'name') {

    result.sort((a, b) =>
      a.name.localeCompare(b.name)
    )

  }

  else if (sortBy.value === 'featured') {

    result.sort((a, b) =>
      Number(b.featured) - Number(a.featured)
    )

  }


  return result

})


/* ================= RUPIAH ================= */

const formatRupiah = (price) => {

  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(price)

}


/* ================= ADD CART ================= */

const addToCart = (product) => {

  cartCount.value++

  alert(
    `${product.name} berhasil ditambahkan ke keranjang.`
  )

}


/* ================= RESET ================= */

const resetFilter = () => {

  selectedCategory.value = 'ALL'
  searchQuery.value = ''
  sortBy.value = 'featured'

}

</script>


<style scoped>

/* =====================================================
   GENERAL
===================================================== */

.shop-page {
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

  background: rgba(255, 255, 255, 0.96);
  backdrop-filter: blur(10px);
}


.nav-left,
.nav-right {
  display: flex;
  align-items: center;
  gap: 28px;
}


.nav-link {
  text-decoration: none;
  color: #111111;

  font-size: 10px;
  letter-spacing: 1.8px;

  position: relative;

  transition: opacity 0.3s ease;
}


.nav-link:hover {
  opacity: 0.5;
}


.nav-link.active::after {
  content: '';

  position: absolute;

  bottom: -8px;
  left: 0;

  width: 100%;
  height: 1px;

  background: #111111;
}


.brand {
  color: #111111;
  text-decoration: none;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: 23px;
  letter-spacing: 5px;
}


.cart-count {
  font-size: 9px;
}


/* =====================================================
   HEADER
===================================================== */

.shop-header {
  padding: 110px 50px 90px;

  border-bottom: 1px solid #dddddd;
}


.header-content {
  max-width: 800px;
}


.small-title {
  font-size: 10px;
  letter-spacing: 3px;
  margin-bottom: 22px;
}


.shop-header h1 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;

  font-size: clamp(55px, 8vw, 105px);
  font-weight: 400;

  line-height: 0.95;
}


.description {
  max-width: 520px;

  margin-top: 30px;

  color: #777777;

  font-size: 14px;
  line-height: 1.8;
}


/* =====================================================
   CONTROLS
===================================================== */

.shop-controls {
  padding: 25px 50px;

  display: flex;
  justify-content: space-between;
  align-items: center;

  gap: 30px;

  border-bottom: 1px solid #dddddd;
}


.categories {
  display: flex;
  gap: 8px;

  flex-wrap: wrap;
}


.category-btn {
  border: 1px solid #dddddd;
  background: #ffffff;

  padding: 10px 17px;

  font-size: 9px;
  letter-spacing: 1.3px;

  cursor: pointer;

  transition: all 0.25s ease;
}


.category-btn:hover {
  border-color: #111111;
}


.category-btn.active {
  background: #111111;
  color: #ffffff;
  border-color: #111111;
}


.right-controls {
  display: flex;
  align-items: center;
  gap: 15px;
}


/* SEARCH */

.search-box {
  width: 190px;

  display: flex;
  align-items: center;

  border-bottom: 1px solid #aaaaaa;

  padding: 8px 0;
}


.search-box input {
  width: 100%;

  border: none;
  outline: none;

  background: transparent;

  font-size: 11px;
  color: #111111;
}


.search-box input::placeholder {
  color: #999999;
}


.search-box span {
  font-size: 18px;
  color: #555555;
}


/* SORT */

.sort-select {
  border: 1px solid #dddddd;

  background: #ffffff;

  padding: 10px 12px;

  font-size: 10px;

  outline: none;

  cursor: pointer;
}


/* =====================================================
   PRODUCT INFO
===================================================== */

.product-info {
  padding: 22px 50px;

  display: flex;
  justify-content: space-between;

  border-bottom: 1px solid #dddddd;

  font-size: 9px;
  letter-spacing: 1.5px;

  color: #777777;
}


/* =====================================================
   PRODUCTS
===================================================== */

.product-section {
  padding: 45px 50px 100px;
}


.product-grid {
  display: grid;

  grid-template-columns: repeat(4, 1fr);

  gap: 35px 20px;
}


/* =====================================================
   PRODUCT CARD
===================================================== */

.product-card {
  min-width: 0;
}


.product-image {
  position: relative;

  aspect-ratio: 0.78;

  overflow: hidden;

  background: #f2f2f2;
}


.product-image img {
  width: 100%;
  height: 100%;

  display: block;

  object-fit: cover;

  transition: transform 0.6s ease;
}


.product-card:hover .product-image img {
  transform: scale(1.04);
}


/* LABEL */

.sale-label,
.featured-label {
  position: absolute;

  top: 14px;
  left: 14px;

  padding: 7px 10px;

  background: #ffffff;

  font-size: 8px;
  letter-spacing: 1.3px;
}


.featured-label {
  background: #111111;
  color: #ffffff;
}


/* ADD CART */

.add-cart {
  position: absolute;

  bottom: 0;
  left: 0;

  width: 100%;

  border: none;

  background: #111111;
  color: #ffffff;

  padding: 17px;

  font-size: 9px;
  letter-spacing: 1.7px;

  cursor: pointer;

  transform: translateY(100%);

  transition: transform 0.3s ease;
}


.product-card:hover .add-cart {
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
  color: #999999;

  font-size: 8px;

  letter-spacing: 1.5px;

  margin-bottom: 8px;
}


.product-details h2 {
  margin: 0;

  font-family: 'Playfair Display', Georgia, serif;

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
  font-size: 12px;
}


.old-price {
  color: #999999;

  font-size: 11px;

  text-decoration: line-through;
}


/* =====================================================
   EMPTY STATE
===================================================== */

.empty-state {
  min-height: 400px;

  display: flex;
  flex-direction: column;

  align-items: center;
  justify-content: center;

  text-align: center;
}


.empty-icon {
  width: 45px;
  height: 45px;

  display: flex;
  align-items: center;
  justify-content: center;

  border: 1px solid #dddddd;

  border-radius: 50%;

  font-size: 22px;

  margin-bottom: 25px;
}


.empty-state h2 {
  font-family: 'Playfair Display', Georgia, serif;

  font-size: 30px;

  font-weight: 400;

  margin: 0;
}


.empty-state p {
  color: #777777;

  font-size: 13px;

  margin: 12px 0 25px;
}


.reset-btn {
  border: 1px solid #111111;

  background: #111111;

  color: #ffffff;

  padding: 14px 22px;

  font-size: 9px;

  letter-spacing: 1.5px;

  cursor: pointer;
}


/* =====================================================
   EDITORIAL
===================================================== */

.editorial {
  min-height: 470px;

  background: #111111;

  color: #ffffff;

  display: flex;

  align-items: center;

  padding: 80px 50px;
}


.editorial-content {
  max-width: 620px;
}


.editorial .small-title {
  color: #aaaaaa;
}


.editorial h2 {
  font-family: 'Playfair Display', Georgia, serif;

  font-size: clamp(45px, 6vw, 80px);

  font-weight: 400;

  line-height: 1;

  margin: 0 0 30px;
}


.editorial p:not(.small-title) {
  color: #aaaaaa;

  max-width: 500px;

  font-size: 13px;

  line-height: 1.9;

  margin-bottom: 30px;
}


.editorial-link {
  color: #ffffff;

  text-decoration: none;

  font-size: 9px;

  letter-spacing: 2px;

  border-bottom: 1px solid #ffffff;

  padding-bottom: 7px;
}


/* =====================================================
   FOOTER
===================================================== */

.footer {
  background: #ffffff;

  border-top: 1px solid #dddddd;

  padding: 45px 50px;

  display: flex;

  justify-content: space-between;

  align-items: center;

  gap: 30px;
}


.footer-brand {
  font-family: 'Playfair Display', Georgia, serif;

  font-size: 18px;

  letter-spacing: 3px;
}


.footer-links {
  display: flex;

  gap: 25px;
}


.footer-links a {
  color: #111111;

  text-decoration: none;

  font-size: 9px;

  letter-spacing: 1.5px;
}


.footer p {
  color: #999999;

  font-size: 8px;

  letter-spacing: 1px;

  margin: 0;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1100px) {

  .product-grid {
    grid-template-columns: repeat(3, 1fr);
  }

}


@media (max-width: 850px) {

  .navbar {
    padding: 0 25px;
  }


  .nav-left,
  .nav-right {
    gap: 15px;
  }


  .brand {
    font-size: 18px;
    letter-spacing: 3px;
  }


  .shop-header {
    padding: 80px 25px;
  }


  .shop-controls {
    padding: 20px 25px;

    flex-direction: column;

    align-items: stretch;
  }


  .right-controls {
    justify-content: space-between;
  }


  .search-box {
    width: 100%;
  }


  .product-info {
    padding: 20px 25px;
  }


  .product-section {
    padding: 35px 25px 80px;
  }


  .product-grid {
    grid-template-columns: repeat(2, 1fr);

    gap: 30px 15px;
  }


  .editorial {
    padding: 70px 25px;
  }


  .footer {
    padding: 40px 25px;

    flex-direction: column;

    align-items: flex-start;
  }

}


@media (max-width: 550px) {

  .navbar {
    height: auto;

    padding: 20px;

    flex-wrap: wrap;

    gap: 20px;
  }


  .brand {
    order: -1;

    width: 100%;

    text-align: center;
  }


  .nav-left,
  .nav-right {
    width: 100%;

    justify-content: center;
  }


  .nav-link {
    font-size: 8px;
  }


  .shop-header {
    padding: 60px 20px;
  }


  .shop-controls {
    padding: 20px;
  }


  .categories {
    gap: 5px;
  }


  .category-btn {
    padding: 8px 11px;
  }


  .right-controls {
    flex-direction: column;

    align-items: stretch;
  }


  .sort-select {
    width: 100%;
  }


  .product-info {
    padding: 18px 20px;
  }


  .product-section {
    padding: 30px 20px 70px;
  }


  .product-grid {
    grid-template-columns: repeat(2, 1fr);

    gap: 25px 10px;
  }


  .product-details h2 {
    font-size: 14px;
  }


  .current-price {
    font-size: 10px;
  }


  .old-price {
    font-size: 9px;
  }


  .add-cart {
    position: static;

    transform: none;

    padding: 12px;

    margin-top: 10px;
  }


  .product-card:hover .add-cart {
    transform: none;
  }


  .editorial {
    min-height: 400px;
  }


  .footer-links {
    flex-wrap: wrap;
  }

}

</style>