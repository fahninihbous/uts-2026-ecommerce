<template>
  <div class="admin-page">

    <!-- ================= SIDEBAR ================= -->
    <aside
      class="sidebar"
      :class="{ 'sidebar-open': sidebarOpen }"
    >

      <!-- LOGO -->
      <div class="sidebar-brand">
        <router-link to="/home">
          PROVIDENTIAL
        </router-link>

        <button
          class="close-sidebar"
          @click="sidebarOpen = false"
        >
          ×
        </button>
      </div>


      <!-- ADMIN PROFILE -->
      <div class="admin-profile">

        <div class="admin-avatar">
          NZ
        </div>

        <div>
          <strong>
            Naura Zahra
          </strong>

          <span>
            Administrator
          </span>
        </div>

      </div>


      <!-- MENU -->
      <nav class="sidebar-menu">

        <p class="menu-title">
          MAIN MENU
        </p>

        <button
          class="menu-item active"
          @click="activeSection = 'dashboard'"
        >
          <span>01</span>
          DASHBOARD
        </button>


        <button
          class="menu-item"
          @click="activeSection = 'products'"
        >
          <span>02</span>
          PRODUCTS
        </button>


        <button
          class="menu-item"
          @click="activeSection = 'orders'"
        >
          <span>03</span>
          ORDERS
        </button>


        <button
          class="menu-item"
          @click="activeSection = 'customers'"
        >
          <span>04</span>
          CUSTOMERS
        </button>


        <button
          class="menu-item"
          @click="activeSection = 'categories'"
        >
          <span>05</span>
          CATEGORIES
        </button>


        <p class="menu-title second">
          MANAGEMENT
        </p>


        <button
          class="menu-item"
          @click="activeSection = 'inventory'"
        >
          <span>06</span>
          INVENTORY
        </button>


        <button
          class="menu-item"
          @click="activeSection = 'reports'"
        >
          <span>07</span>
          REPORTS
        </button>


        <button
          class="menu-item"
          @click="activeSection = 'settings'"
        >
          <span>08</span>
          SETTINGS
        </button>

      </nav>


      <!-- SIDEBAR BOTTOM -->
      <div class="sidebar-bottom">

        <router-link
          to="/home"
          class="back-store"
        >
          ← BACK TO STORE
        </router-link>


        <button
          class="logout-button"
          @click="logout"
        >
          LOG OUT
        </button>

      </div>

    </aside>


    <!-- ================= MAIN ================= -->
    <main class="main-content">

      <!-- TOPBAR -->
      <header class="topbar">

        <button
          class="menu-toggle"
          @click="sidebarOpen = !sidebarOpen"
        >
          ☰
        </button>


        <div class="topbar-title">

          <p>
            ADMIN / {{ activeSection.toUpperCase() }}
          </p>

          <h1>
            {{ pageTitle }}
          </h1>

        </div>


        <div class="topbar-actions">

          <button
            class="notification-button"
            @click="showNotification = !showNotification"
          >
            ♢
            <span></span>
          </button>


          <router-link
            to="/user"
            class="view-store"
          >
            VIEW STORE →
          </router-link>

        </div>

      </header>


      <!-- ================= DASHBOARD ================= -->
      <section
        v-if="activeSection === 'dashboard'"
        class="content"
      >

        <!-- WELCOME -->
        <div class="welcome">

          <div>
            <p class="eyebrow">
              OVERVIEW / 2026
            </p>

            <h2>
              Good morning,<br />
              Naura.
            </h2>

            <p>
              Here's what's happening with your store today.
            </p>
          </div>


          <div class="date-box">
            <span>
              TODAY
            </span>

            <strong>
              15 SEP 2026
            </strong>
          </div>

        </div>


        <!-- STATISTICS -->
        <div class="stats-grid">

          <div class="stat-card">

            <div class="stat-top">
              <span>
                TOTAL SALES
              </span>

              <small>
                +12.8%
              </small>
            </div>

            <strong>
              Rp 24.850.000
            </strong>

            <p>
              Compared to last month
            </p>

          </div>


          <div class="stat-card">

            <div class="stat-top">
              <span>
                ORDERS
              </span>

              <small>
                +8.4%
              </small>
            </div>

            <strong>
              184
            </strong>

            <p>
              Orders this month
            </p>

          </div>


          <div class="stat-card">

            <div class="stat-top">
              <span>
                CUSTOMERS
              </span>

              <small>
                +15.2%
              </small>
            </div>

            <strong>
              1,248
            </strong>

            <p>
              Registered customers
            </p>

          </div>


          <div class="stat-card">

            <div class="stat-top">
              <span>
                PRODUCTS
              </span>

              <small>
                8 NEW
              </small>
            </div>

            <strong>
              126
            </strong>

            <p>
              Active products
            </p>

          </div>

        </div>


        <!-- DASHBOARD GRID -->
        <div class="dashboard-grid">

          <!-- SALES -->
          <div class="panel sales-panel">

            <div class="panel-header">

              <div>
                <p class="eyebrow">
                  PERFORMANCE
                </p>

                <h3>
                  Sales Overview
                </h3>
              </div>


              <select>
                <option>
                  This Year
                </option>

                <option>
                  This Month
                </option>

                <option>
                  This Week
                </option>
              </select>

            </div>


            <div class="chart">

              <div class="chart-value">
                Rp 24.8M
              </div>

              <div class="chart-bars">

                <div
                  v-for="(item, index) in salesData"
                  :key="index"
                  class="bar-column"
                >

                  <div
                    class="bar"
                    :style="{
                      height: item.value + '%'
                    }"
                  ></div>

                  <span>
                    {{ item.month }}
                  </span>

                </div>

              </div>

            </div>

          </div>


          <!-- TOP PRODUCTS -->
          <div class="panel">

            <div class="panel-header">

              <div>
                <p class="eyebrow">
                  BEST SELLERS
                </p>

                <h3>
                  Top Products
                </h3>
              </div>

              <button
                class="text-button"
                @click="activeSection = 'products'"
              >
                VIEW ALL →
              </button>

            </div>


            <div class="top-products">

              <div
                v-for="(product, index) in topProducts"
                :key="product.id"
                class="top-product"
              >

                <span class="product-number">
                  0{{ index + 1 }}
                </span>


                <img
                  :src="product.image"
                  :alt="product.name"
                />


                <div class="top-product-info">

                  <strong>
                    {{ product.name }}
                  </strong>

                  <span>
                    {{ product.sold }} sold
                  </span>

                </div>


                <strong class="top-price">
                  {{ formatRupiah(product.price) }}
                </strong>

              </div>

            </div>

          </div>

        </div>


        <!-- LOWER GRID -->
        <div class="dashboard-grid lower">

          <!-- RECENT ORDERS -->
          <div class="panel">

            <div class="panel-header">

              <div>
                <p class="eyebrow">
                  LATEST ACTIVITY
                </p>

                <h3>
                  Recent Orders
                </h3>
              </div>

              <button
                class="text-button"
                @click="activeSection = 'orders'"
              >
                VIEW ALL →
              </button>

            </div>


            <div class="orders-table">

              <div
                v-for="order in recentOrders"
                :key="order.id"
                class="order-row"
              >

                <div class="order-id">
                  #{{ order.id }}
                </div>

                <div class="order-customer">
                  <strong>
                    {{ order.customer }}
                  </strong>

                  <span>
                    {{ order.items }} items
                  </span>
                </div>

                <div class="order-total">
                  {{ formatRupiah(order.total) }}
                </div>

                <span
                  class="status"
                  :class="order.status.toLowerCase()"
                >
                  {{ order.status }}
                </span>

              </div>

            </div>

          </div>


          <!-- LOW STOCK -->
          <div class="panel">

            <div class="panel-header">

              <div>
                <p class="eyebrow">
                  INVENTORY
                </p>

                <h3>
                  Low Stock
                </h3>
              </div>

              <button
                class="text-button"
                @click="activeSection = 'inventory'"
              >
                MANAGE →
              </button>

            </div>


            <div class="stock-list">

              <div
                v-for="product in lowStockProducts"
                :key="product.id"
                class="stock-item"
              >

                <img
                  :src="product.image"
                  :alt="product.name"
                />


                <div class="stock-info">

                  <strong>
                    {{ product.name }}
                  </strong>

                  <span>
                    {{ product.category }}
                  </span>

                </div>


                <div class="stock-number">

                  <strong>
                    {{ product.stock }}
                  </strong>

                  <span>
                    left
                  </span>

                </div>

              </div>

            </div>

          </div>

        </div>


        <!-- QUICK ACTION -->
        <div class="quick-actions">

          <p class="eyebrow">
            QUICK ACTIONS
          </p>

          <div class="quick-grid">

            <button
              @click="activeSection = 'products'"
            >
              <span>+</span>
              ADD PRODUCT
            </button>

            <button
              @click="activeSection = 'orders'"
            >
              <span>→</span>
              VIEW ORDERS
            </button>

            <button
              @click="activeSection = 'inventory'"
            >
              <span>□</span>
              CHECK INVENTORY
            </button>

            <button
              @click="activeSection = 'reports'"
            >
              <span>↗</span>
              VIEW REPORTS
            </button>

          </div>

        </div>

      </section>


      <!-- ================= PRODUCTS ================= -->
      <section
        v-if="activeSection === 'products'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              CATALOG / MANAGEMENT
            </p>

            <h2>
              Products
            </h2>
          </div>

          <button
            class="primary-button"
            @click="addProduct"
          >
            + ADD PRODUCT
          </button>

        </div>


        <div class="toolbar">

          <input
            v-model="productSearch"
            type="text"
            placeholder="Search products..."
          />

          <select v-model="productFilter">

            <option value="ALL">
              All Categories
            </option>

            <option>
              T-SHIRT
            </option>

            <option>
              SHIRT
            </option>

            <option>
              PANTS
            </option>

            <option>
              OUTERWEAR
            </option>

          </select>

        </div>


        <div class="product-admin-grid">

          <div
            v-for="product in filteredAdminProducts"
            :key="product.id"
            class="admin-product-card"
          >

            <div class="admin-product-image">

              <img
                :src="product.image"
                :alt="product.name"
              />

              <span
                :class="[
                  'product-status',
                  product.active
                    ? 'active-status'
                    : 'inactive-status'
                ]"
              >
                {{ product.active ? 'ACTIVE' : 'INACTIVE' }}
              </span>

            </div>


            <div class="admin-product-info">

              <span>
                {{ product.category }}
              </span>

              <h3>
                {{ product.name }}
              </h3>

              <strong>
                {{ formatRupiah(product.price) }}
              </strong>

              <p>
                Stock: {{ product.stock }}
              </p>

            </div>


            <div class="product-actions">

              <button
                @click="editProduct(product)"
              >
                EDIT
              </button>

              <button
                @click="deleteProduct(product)"
              >
                DELETE
              </button>

            </div>

          </div>

        </div>

      </section>


      <!-- ================= ORDERS ================= -->
      <section
        v-if="activeSection === 'orders'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              SALES / MANAGEMENT
            </p>

            <h2>
              Orders
            </h2>
          </div>

        </div>


        <div class="full-panel">

          <div class="admin-table-header">
            <span>ORDER</span>
            <span>CUSTOMER</span>
            <span>DATE</span>
            <span>TOTAL</span>
            <span>STATUS</span>
          </div>


          <div
            v-for="order in allOrders"
            :key="order.id"
            class="admin-table-row"
          >

            <strong>
              #{{ order.id }}
            </strong>

            <span>
              {{ order.customer }}
            </span>

            <span>
              {{ order.date }}
            </span>

            <span>
              {{ formatRupiah(order.total) }}
            </span>

            <span
              class="status"
              :class="order.status.toLowerCase()"
            >
              {{ order.status }}
            </span>

          </div>

        </div>

      </section>


      <!-- ================= CUSTOMERS ================= -->
      <section
        v-if="activeSection === 'customers'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              USERS / DATABASE
            </p>

            <h2>
              Customers
            </h2>
          </div>

        </div>


        <div class="customer-grid">

          <div
            v-for="customer in customers"
            :key="customer.id"
            class="customer-card"
          >

            <div class="customer-avatar">
              {{ customer.initial }}
            </div>

            <div>
              <h3>
                {{ customer.name }}
              </h3>

              <p>
                {{ customer.email }}
              </p>

              <span>
                {{ customer.orders }} orders
              </span>
            </div>

          </div>

        </div>

      </section>


      <!-- ================= CATEGORIES ================= -->
      <section
        v-if="activeSection === 'categories'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              CATALOG / ORGANIZATION
            </p>

            <h2>
              Categories
            </h2>
          </div>

          <button
            class="primary-button"
            @click="addCategory"
          >
            + ADD CATEGORY
          </button>

        </div>


        <div class="category-admin-grid">

          <div
            v-for="category in adminCategories"
            :key="category.name"
            class="category-admin-card"
          >

            <span>
              {{ category.number }}
            </span>

            <h3>
              {{ category.name }}
            </h3>

            <p>
              {{ category.products }} products
            </p>

            <button>
              MANAGE →
            </button>

          </div>

        </div>

      </section>


      <!-- ================= INVENTORY ================= -->
      <section
        v-if="activeSection === 'inventory'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              STOCK / MANAGEMENT
            </p>

            <h2>
              Inventory
            </h2>
          </div>

        </div>


        <div class="inventory-summary">

          <div>
            <span>
              TOTAL PRODUCTS
            </span>

            <strong>
              126
            </strong>
          </div>

          <div>
            <span>
              LOW STOCK
            </span>

            <strong>
              12
            </strong>
          </div>

          <div>
            <span>
              OUT OF STOCK
            </span>

            <strong>
              3
            </strong>
          </div>

        </div>


        <div class="full-panel">

          <div class="admin-table-header inventory-header">
            <span>PRODUCT</span>
            <span>CATEGORY</span>
            <span>STOCK</span>
            <span>STATUS</span>
          </div>


          <div
            v-for="product in inventoryProducts"
            :key="product.id"
            class="admin-table-row inventory-row"
          >

            <strong>
              {{ product.name }}
            </strong>

            <span>
              {{ product.category }}
            </span>

            <span>
              {{ product.stock }}
            </span>

            <span
              class="inventory-status"
              :class="getStockClass(product.stock)"
            >
              {{ getStockStatus(product.stock) }}
            </span>

          </div>

        </div>

      </section>


      <!-- ================= REPORTS ================= -->
      <section
        v-if="activeSection === 'reports'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              ANALYTICS / PERFORMANCE
            </p>

            <h2>
              Reports
            </h2>
          </div>

          <button
            class="primary-button"
            @click="downloadReport"
          >
            DOWNLOAD REPORT
          </button>

        </div>


        <div class="report-grid">

          <div class="report-card">
            <span>
              MONTHLY REVENUE
            </span>

            <strong>
              Rp 24.850.000
            </strong>

            <small>
              +12.8% from last month
            </small>
          </div>


          <div class="report-card">
            <span>
              AVERAGE ORDER
            </span>

            <strong>
              Rp 385.000
            </strong>

            <small>
              +5.4% from last month
            </small>
          </div>


          <div class="report-card">
            <span>
              CONVERSION
            </span>

            <strong>
              4.82%
            </strong>

            <small>
              +1.2% from last month
            </small>
          </div>

        </div>


        <div class="report-message">

          <span>
            REPORT OVERVIEW
          </span>

          <h3>
            Your store is growing.
          </h3>

          <p>
            Sales, customers, and orders are showing
            positive growth compared to the previous period.
          </p>

        </div>

      </section>


      <!-- ================= SETTINGS ================= -->
      <section
        v-if="activeSection === 'settings'"
        class="content"
      >

        <div class="page-heading">

          <div>
            <p class="eyebrow">
              ADMIN / CONFIGURATION
            </p>

            <h2>
              Settings
            </h2>
          </div>

        </div>


        <div class="settings-panel">

          <div class="setting-row">

            <div>
              <strong>
                Store Name
              </strong>

              <span>
                Your online store name
              </span>
            </div>

            <input
              type="text"
              value="PROVIDENTIAL"
            />

          </div>


          <div class="setting-row">

            <div>
              <strong>
                Admin Email
              </strong>

              <span>
                Email used for administration
              </span>
            </div>

            <input
              type="email"
              value="admin@providential.com"
            />

          </div>


          <div class="setting-row">

            <div>
              <strong>
                Currency
              </strong>

              <span>
                Store default currency
              </span>
            </div>

            <select>
              <option>
                Indonesian Rupiah (IDR)
              </option>

              <option>
                US Dollar (USD)
              </option>
            </select>

          </div>


          <button
            class="primary-button save-settings"
            @click="saveSettings"
          >
            SAVE CHANGES
          </button>

        </div>

      </section>

    </main>


    <!-- ================= NOTIFICATION ================= -->
    <div
      v-if="showNotification"
      class="notification-box"
    >

      <div class="notification-header">
        <strong>
          NOTIFICATIONS
        </strong>

        <button
          @click="showNotification = false"
        >
          ×
        </button>
      </div>

      <p>
        You have 3 new orders waiting to be processed.
      </p>

      <p>
        5 products are running low on stock.
      </p>

    </div>

  </div>
</template>


<script setup>

import {
  ref,
  computed
} from 'vue'


/* =====================================================
   STATE
===================================================== */

const activeSection = ref('dashboard')

const sidebarOpen = ref(false)

const showNotification = ref(false)

const productSearch = ref('')

const productFilter = ref('ALL')


/* =====================================================
   PAGE TITLE
===================================================== */

const pageTitle = computed(() => {

  const titles = {

    dashboard: 'Dashboard',

    products: 'Products',

    orders: 'Orders',

    customers: 'Customers',

    categories: 'Categories',

    inventory: 'Inventory',

    reports: 'Reports',

    settings: 'Settings'

  }

  return titles[activeSection.value]

})


/* =====================================================
   SALES DATA
===================================================== */

const salesData = [

  {
    month: 'JAN',
    value: 42
  },

  {
    month: 'FEB',
    value: 55
  },

  {
    month: 'MAR',
    value: 48
  },

  {
    month: 'APR',
    value: 67
  },

  {
    month: 'MAY',
    value: 58
  },

  {
    month: 'JUN',
    value: 76
  },

  {
    month: 'JUL',
    value: 64
  },

  {
    month: 'AUG',
    value: 88
  },

  {
    month: 'SEP',
    value: 94
  }

]


/* =====================================================
   TOP PRODUCTS
===================================================== */

const topProducts = [

  {
    id: 1,
    name: 'Essential Cotton Tee',
    price: 269000,
    sold: 84,
    image: '/images/new-tshirt-1.jpg'
  },

  {
    id: 2,
    name: 'Signature Linen Shirt',
    price: 429000,
    sold: 71,
    image: '/images/new-shirt-1.jpg'
  },

  {
    id: 3,
    name: 'Essential Overshirt',
    price: 529000,
    sold: 62,
    image: '/images/new-outerwear-1.jpg'
  },

  {
    id: 4,
    name: 'Relaxed Straight Pants',
    price: 479000,
    sold: 48,
    image: '/images/new-pants-1.jpg'
  }

]


/* =====================================================
   RECENT ORDERS
===================================================== */

const recentOrders = [

  {
    id: 'PV001284',
    customer: 'Alya Putri',
    items: 2,
    total: 798000,
    status: 'Processing'
  },

  {
    id: 'PV001283',
    customer: 'Raka Pratama',
    items: 1,
    total: 429000,
    status: 'Shipped'
  },

  {
    id: 'PV001282',
    customer: 'Dinda Maharani',
    items: 3,
    total: 1247000,
    status: 'Delivered'
  },

  {
    id: 'PV001281',
    customer: 'Fajar Ramadhan',
    items: 2,
    total: 698000,
    status: 'Pending'
  },

  {
    id: 'PV001280',
    customer: 'Nadia Salsabila',
    items: 1,
    total: 529000,
    status: 'Delivered'
  }

]


const allOrders = [

  ...recentOrders,

  {
    id: 'PV001279',
    customer: 'Rizky Maulana',
    date: '14 Sep 2026',
    total: 649000,
    status: 'Processing'
  },

  {
    id: 'PV001278',
    customer: 'Citra Lestari',
    date: '14 Sep 2026',
    total: 899000,
    status: 'Delivered'
  },

  {
    id: 'PV001277',
    customer: 'Salsa Amelia',
    date: '13 Sep 2026',
    total: 479000,
    status: 'Shipped'
  }

]


/* =====================================================
   LOW STOCK
===================================================== */

const lowStockProducts = [

  {
    id: 1,
    name: 'Heavyweight Relaxed Tee',
    category: 'T-SHIRT',
    stock: 4,
    image: '/images/new-tshirt-2.jpg'
  },

  {
    id: 2,
    name: 'Wide Pleated Pants',
    category: 'PANTS',
    stock: 6,
    image: '/images/new-pants-2.jpg'
  },

  {
    id: 3,
    name: 'Minimal Utility Jacket',
    category: 'OUTERWEAR',
    stock: 3,
    image: '/images/new-outerwear-2.jpg'
  }

]


/* =====================================================
   PRODUCTS
===================================================== */

const adminProducts = ref([

  {
    id: 101,
    name: 'Essential Cotton Tee',
    category: 'T-SHIRT',
    price: 269000,
    stock: 32,
    active: true,
    image: '/images/new-tshirt-1.jpg'
  },

  {
    id: 102,
    name: 'Heavyweight Relaxed Tee',
    category: 'T-SHIRT',
    price: 299000,
    stock: 4,
    active: true,
    image: '/images/new-tshirt-2.jpg'
  },

  {
    id: 103,
    name: 'Signature Linen Shirt',
    category: 'SHIRT',
    price: 429000,
    stock: 24,
    active: true,
    image: '/images/new-shirt-1.jpg'
  },

  {
    id: 104,
    name: 'Relaxed Daily Shirt',
    category: 'SHIRT',
    price: 379000,
    stock: 18,
    active: true,
    image: '/images/new-shirt-2.jpg'
  },

  {
    id: 105,
    name: 'Relaxed Straight Pants',
    category: 'PANTS',
    price: 479000,
    stock: 15,
    active: true,
    image: '/images/new-pants-1.jpg'
  },

  {
    id: 106,
    name: 'Wide Pleated Pants',
    category: 'PANTS',
    price: 529000,
    stock: 6,
    active: true,
    image: '/images/new-pants-2.jpg'
  },

  {
    id: 107,
    name: 'Essential Overshirt',
    category: 'OUTERWEAR',
    price: 529000,
    stock: 20,
    active: true,
    image: '/images/new-outerwear-1.jpg'
  },

  {
    id: 108,
    name: 'Minimal Utility Jacket',
    category: 'OUTERWEAR',
    price: 649000,
    stock: 3,
    active: true,
    image: '/images/new-outerwear-2.jpg'
  }

])


/* =====================================================
   FILTER ADMIN PRODUCTS
===================================================== */

const filteredAdminProducts = computed(() => {

  return adminProducts.value.filter(product => {

    const search =
      product.name
        .toLowerCase()
        .includes(
          productSearch.value.toLowerCase()
        )


    const category =
      productFilter.value === 'ALL' ||
      product.category === productFilter.value


    return search && category

  })

})


/* =====================================================
   CUSTOMERS
===================================================== */

const customers = [

  {
    id: 1,
    name: 'Alya Putri',
    email: 'alya@example.com',
    orders: 12,
    initial: 'AP'
  },

  {
    id: 2,
    name: 'Raka Pratama',
    email: 'raka@example.com',
    orders: 8,
    initial: 'RP'
  },

  {
    id: 3,
    name: 'Dinda Maharani',
    email: 'dinda@example.com',
    orders: 15,
    initial: 'DM'
  },

  {
    id: 4,
    name: 'Fajar Ramadhan',
    email: 'fajar@example.com',
    orders: 6,
    initial: 'FR'
  },

  {
    id: 5,
    name: 'Nadia Salsabila',
    email: 'nadia@example.com',
    orders: 10,
    initial: 'NS'
  },

  {
    id: 6,
    name: 'Citra Lestari',
    email: 'citra@example.com',
    orders: 9,
    initial: 'CL'
  }

]


/* =====================================================
   CATEGORIES
===================================================== */

const adminCategories = [

  {
    number: '01',
    name: 'T-SHIRT',
    products: 34
  },

  {
    number: '02',
    name: 'SHIRT',
    products: 28
  },

  {
    number: '03',
    name: 'PANTS',
    products: 31
  },

  {
    number: '04',
    name: 'OUTERWEAR',
    products: 33
  }

]


/* =====================================================
   INVENTORY
===================================================== */

const inventoryProducts = [

  {
    id: 1,
    name: 'Essential Cotton Tee',
    category: 'T-SHIRT',
    stock: 32
  },

  {
    id: 2,
    name: 'Heavyweight Relaxed Tee',
    category: 'T-SHIRT',
    stock: 4
  },

  {
    id: 3,
    name: 'Signature Linen Shirt',
    category: 'SHIRT',
    stock: 24
  },

  {
    id: 4,
    name: 'Relaxed Daily Shirt',
    category: 'SHIRT',
    stock: 18
  },

  {
    id: 5,
    name: 'Relaxed Straight Pants',
    category: 'PANTS',
    stock: 15
  },

  {
    id: 6,
    name: 'Wide Pleated Pants',
    category: 'PANTS',
    stock: 6
  },

  {
    id: 7,
    name: 'Essential Overshirt',
    category: 'OUTERWEAR',
    stock: 20
  },

  {
    id: 8,
    name: 'Minimal Utility Jacket',
    category: 'OUTERWEAR',
    stock: 3
  }

]


/* =====================================================
   RUPIAH
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
   PRODUCT ACTION
===================================================== */

const addProduct = () => {

  alert(
    'Halaman tambah produk dapat dihubungkan ke form Add Product.'
  )

}


const editProduct = (product) => {

  alert(
    `Edit produk: ${product.name}`
  )

}


const deleteProduct = (product) => {

  const confirmDelete =
    confirm(
      `Hapus produk "${product.name}"?`
    )


  if (confirmDelete) {

    adminProducts.value =
      adminProducts.value.filter(
        item =>
          item.id !== product.id
      )

  }

}


/* =====================================================
   CATEGORY ACTION
===================================================== */

const addCategory = () => {

  alert(
    'Form tambah kategori dapat dibuat di sini.'
  )

}


/* =====================================================
   INVENTORY STATUS
===================================================== */

const getStockStatus = (stock) => {

  if (stock === 0) {
    return 'OUT OF STOCK'
  }

  if (stock <= 5) {
    return 'LOW STOCK'
  }

  return 'IN STOCK'

}


const getStockClass = (stock) => {

  if (stock === 0) {
    return 'out-stock'
  }

  if (stock <= 5) {
    return 'low-stock'
  }

  return 'in-stock'

}


/* =====================================================
   REPORT
===================================================== */

const downloadReport = () => {

  alert(
    'Laporan penjualan siap diunduh.'
  )

}


/* =====================================================
   SETTINGS
===================================================== */

const saveSettings = () => {

  alert(
    'Pengaturan berhasil disimpan.'
  )

}


/* =====================================================
   LOGOUT
===================================================== */

const logout = () => {

  const confirmLogout =
    confirm(
      'Apakah kamu yakin ingin logout?'
    )


  if (confirmLogout) {

    alert(
      'Kamu berhasil logout.'
    )

  }

}

</script>


<style scoped>

/* =====================================================
   GENERAL
===================================================== */

* {
  box-sizing: border-box;
}


.admin-page {
  min-height: 100vh;

  background: #f7f7f5;

  color: #111111;

  font-family:
    'Inter',
    Arial,
    sans-serif;
}


/* =====================================================
   SIDEBAR
===================================================== */

.sidebar {
  position: fixed;

  left: 0;

  top: 0;

  bottom: 0;

  width: 250px;

  background: #111111;

  color: #ffffff;

  display: flex;

  flex-direction: column;

  z-index: 200;
}


.sidebar-brand {
  height: 100px;

  padding: 0 28px;

  display: flex;

  align-items: center;

  border-bottom: 1px solid #333333;
}


.sidebar-brand a {
  color: #ffffff;

  text-decoration: none;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 17px;

  letter-spacing: 3px;
}


.close-sidebar {
  display: none;
}


/* =====================================================
   ADMIN PROFILE
===================================================== */

.admin-profile {
  padding: 28px;

  display: flex;

  align-items: center;

  gap: 13px;

  border-bottom: 1px solid #333333;
}


.admin-avatar {
  width: 40px;

  height: 40px;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #ffffff;

  color: #111111;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 12px;
}


.admin-profile strong {
  display: block;

  font-size: 11px;

  font-weight: 500;
}


.admin-profile span {
  display: block;

  margin-top: 4px;

  color: #888888;

  font-size: 8px;

  letter-spacing: 1px;
}


/* =====================================================
   SIDEBAR MENU
===================================================== */

.sidebar-menu {
  flex: 1;

  padding: 28px 15px;

  overflow-y: auto;
}


.menu-title {
  margin: 0 13px 13px;

  color: #666666;

  font-size: 8px;

  letter-spacing: 2px;
}


.menu-title.second {
  margin-top: 30px;
}


.menu-item {
  width: 100%;

  padding: 14px 13px;

  border: none;

  border-left: 1px solid transparent;

  background: transparent;

  color: #999999;

  text-align: left;

  display: flex;

  gap: 14px;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.25s ease;
}


.menu-item span {
  color: #555555;
}


.menu-item:hover,
.menu-item.active {
  color: #ffffff;

  border-left-color: #ffffff;
}


.menu-item.active span {
  color: #ffffff;
}


/* =====================================================
   SIDEBAR BOTTOM
===================================================== */

.sidebar-bottom {
  padding: 25px;

  border-top: 1px solid #333333;
}


.back-store {
  display: block;

  color: #aaaaaa;

  text-decoration: none;

  font-size: 8px;

  letter-spacing: 1.5px;

  margin-bottom: 20px;
}


.logout-button {
  border: none;

  background: transparent;

  color: #777777;

  font-size: 8px;

  letter-spacing: 1.5px;

  padding: 0;

  cursor: pointer;
}


.logout-button:hover,
.back-store:hover {
  color: #ffffff;
}


/* =====================================================
   MAIN
===================================================== */

.main-content {
  margin-left: 250px;

  min-height: 100vh;
}


/* =====================================================
   TOPBAR
===================================================== */

.topbar {
  height: 100px;

  padding: 0 45px;

  background: #ffffff;

  border-bottom: 1px solid #dddddd;

  display: flex;

  align-items: center;

  justify-content: space-between;
}


.menu-toggle {
  display: none;

  border: none;

  background: transparent;

  font-size: 20px;

  cursor: pointer;
}


.topbar-title p {
  margin: 0 0 7px;

  color: #999999;

  font-size: 8px;

  letter-spacing: 1.8px;
}


.topbar-title h1 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 32px;

  font-weight: 400;
}


.topbar-actions {
  display: flex;

  align-items: center;

  gap: 25px;
}


.notification-button {
  position: relative;

  border: none;

  background: transparent;

  font-size: 22px;

  cursor: pointer;
}


.notification-button span {
  position: absolute;

  top: 3px;

  right: 2px;

  width: 5px;

  height: 5px;

  background: #111111;

  border-radius: 50%;
}


.view-store {
  color: #111111;

  text-decoration: none;

  font-size: 8px;

  letter-spacing: 1.5px;

  border-bottom: 1px solid #111111;

  padding-bottom: 5px;
}


/* =====================================================
   CONTENT
===================================================== */

.content {
  padding: 45px;
}


.eyebrow {
  margin: 0 0 12px;

  color: #999999;

  font-size: 8px;

  letter-spacing: 2.5px;
}


/* =====================================================
   WELCOME
===================================================== */

.welcome {
  display: flex;

  justify-content: space-between;

  align-items: flex-end;

  margin-bottom: 45px;
}


.welcome h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 48px;

  font-weight: 400;

  line-height: 0.95;
}


.welcome > div:first-child > p:last-child {
  margin: 20px 0 0;

  color: #888888;

  font-size: 11px;
}


.date-box {
  padding: 18px 22px;

  border: 1px solid #dddddd;

  background: #ffffff;

  text-align: right;
}


.date-box span {
  display: block;

  color: #999999;

  font-size: 8px;

  letter-spacing: 2px;

  margin-bottom: 7px;
}


.date-box strong {
  font-size: 11px;

  letter-spacing: 1px;
}


/* =====================================================
   STATS
===================================================== */

.stats-grid {
  display: grid;

  grid-template-columns:
    repeat(4, 1fr);

  gap: 15px;

  margin-bottom: 25px;
}


.stat-card {
  padding: 25px;

  background: #ffffff;

  border: 1px solid #dddddd;
}


.stat-top {
  display: flex;

  justify-content: space-between;

  align-items: center;

  margin-bottom: 20px;
}


.stat-top span {
  color: #888888;

  font-size: 8px;

  letter-spacing: 1.5px;
}


.stat-top small {
  color: #111111;

  font-size: 8px;
}


.stat-card > strong {
  display: block;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 27px;

  font-weight: 400;
}


.stat-card > p {
  margin: 8px 0 0;

  color: #aaaaaa;

  font-size: 8px;
}


/* =====================================================
   DASHBOARD GRID
===================================================== */

.dashboard-grid {
  display: grid;

  grid-template-columns:
    1.4fr 1fr;

  gap: 20px;

  margin-bottom: 20px;
}


.dashboard-grid.lower {
  grid-template-columns:
    1.4fr 1fr;
}


/* =====================================================
   PANEL
===================================================== */

.panel {
  background: #ffffff;

  border: 1px solid #dddddd;

  padding: 28px;
}


.panel-header {
  display: flex;

  align-items: flex-end;

  justify-content: space-between;

  padding-bottom: 20px;

  border-bottom: 1px solid #eeeeee;
}


.panel-header h3 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 24px;

  font-weight: 400;
}


.panel-header select {
  border: none;

  border-bottom: 1px solid #cccccc;

  padding: 6px 0;

  background: transparent;

  font-size: 8px;

  outline: none;
}


.text-button {
  border: none;

  background: transparent;

  padding: 0;

  color: #111111;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;
}


/* =====================================================
   CHART
===================================================== */

.chart {
  height: 280px;

  padding-top: 25px;

  position: relative;
}


.chart-value {
  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 30px;
}


.chart-bars {
  height: 200px;

  display: flex;

  align-items: flex-end;

  justify-content: space-between;

  gap: 12px;

  margin-top: 15px;
}


.bar-column {
  height: 100%;

  flex: 1;

  display: flex;

  flex-direction: column;

  justify-content: flex-end;

  align-items: center;

  gap: 10px;
}


.bar {
  width: 100%;

  max-width: 35px;

  background: #111111;

  transition:
    height 0.5s ease;
}


.bar-column span {
  color: #999999;

  font-size: 7px;

  letter-spacing: 1px;
}


/* =====================================================
   TOP PRODUCTS
===================================================== */

.top-products {
  padding-top: 10px;
}


.top-product {
  display: flex;

  align-items: center;

  gap: 12px;

  padding: 14px 0;

  border-bottom: 1px solid #eeeeee;
}


.product-number {
  color: #aaaaaa;

  font-size: 8px;
}


.top-product img {
  width: 45px;

  height: 55px;

  object-fit: cover;

  background: #eeeeee;
}


.top-product-info {
  flex: 1;
}


.top-product-info strong {
  display: block;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 13px;

  font-weight: 400;
}


.top-product-info span {
  display: block;

  margin-top: 5px;

  color: #999999;

  font-size: 8px;
}


.top-price {
  font-size: 9px;

  font-weight: 500;
}


/* =====================================================
   ORDERS
===================================================== */

.orders-table {
  padding-top: 10px;
}


.order-row {
  display: grid;

  grid-template-columns:
    80px 1fr 110px 85px;

  align-items: center;

  gap: 10px;

  padding: 17px 0;

  border-bottom: 1px solid #eeeeee;
}


.order-id {
  color: #666666;

  font-size: 8px;
}


.order-customer strong {
  display: block;

  font-size: 10px;

  font-weight: 500;
}


.order-customer span {
  display: block;

  margin-top: 4px;

  color: #999999;

  font-size: 8px;
}


.order-total {
  font-size: 9px;
}


/* =====================================================
   STATUS
===================================================== */

.status {
  display: inline-block;

  padding: 6px 8px;

  font-size: 7px;

  letter-spacing: 0.8px;

  text-align: center;
}


.status.processing {
  background: #eeeeee;

  color: #333333;
}


.status.pending {
  border: 1px solid #cccccc;

  color: #666666;
}


.status.shipped {
  background: #111111;

  color: #ffffff;
}


.status.delivered {
  background: #eeeeee;

  color: #111111;
}


/* =====================================================
   STOCK
===================================================== */

.stock-list {
  padding-top: 10px;
}


.stock-item {
  display: flex;

  align-items: center;

  gap: 13px;

  padding: 15px 0;

  border-bottom: 1px solid #eeeeee;
}


.stock-item img {
  width: 45px;

  height: 55px;

  object-fit: cover;

  background: #eeeeee;
}


.stock-info {
  flex: 1;
}


.stock-info strong {
  display: block;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 13px;

  font-weight: 400;
}


.stock-info span {
  display: block;

  margin-top: 4px;

  color: #999999;

  font-size: 7px;

  letter-spacing: 1px;
}


.stock-number {
  text-align: right;
}


.stock-number strong {
  display: block;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 21px;

  font-weight: 400;
}


.stock-number span {
  color: #999999;

  font-size: 7px;
}


/* =====================================================
   QUICK ACTION
===================================================== */

.quick-actions {
  margin-top: 40px;
}


.quick-grid {
  display: grid;

  grid-template-columns:
    repeat(4, 1fr);

  gap: 12px;
}


.quick-grid button {
  padding: 22px;

  border: 1px solid #dddddd;

  background: #ffffff;

  text-align: left;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.25s ease;
}


.quick-grid button span {
  display: block;

  margin-bottom: 15px;

  font-size: 18px;
}


.quick-grid button:hover {
  background: #111111;

  color: #ffffff;

  border-color: #111111;
}


/* =====================================================
   PAGE HEADING
===================================================== */

.page-heading {
  display: flex;

  align-items: flex-end;

  justify-content: space-between;

  margin-bottom: 35px;
}


.page-heading h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 52px;

  font-weight: 400;
}


/* =====================================================
   BUTTON
===================================================== */

.primary-button {
  border: 1px solid #111111;

  background: #111111;

  color: #ffffff;

  padding: 13px 18px;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.25s ease;
}


.primary-button:hover {
  background: #ffffff;

  color: #111111;
}


/* =====================================================
   TOOLBAR
===================================================== */

.toolbar {
  display: flex;

  justify-content: space-between;

  gap: 15px;

  margin-bottom: 25px;
}


.toolbar input {
  flex: 1;

  border: 1px solid #dddddd;

  background: #ffffff;

  padding: 14px;

  outline: none;

  font-size: 10px;
}


.toolbar select {
  width: 190px;

  border: 1px solid #dddddd;

  background: #ffffff;

  padding: 14px;

  outline: none;

  font-size: 9px;
}


/* =====================================================
   PRODUCT ADMIN GRID
===================================================== */

.product-admin-grid {
  display: grid;

  grid-template-columns:
    repeat(4, 1fr);

  gap: 18px;
}


.admin-product-card {
  background: #ffffff;

  border: 1px solid #dddddd;
}


.admin-product-image {
  position: relative;

  aspect-ratio: 0.82;

  background: #eeeeee;

  overflow: hidden;
}


.admin-product-image img {
  width: 100%;

  height: 100%;

  object-fit: cover;
}


.product-status {
  position: absolute;

  top: 12px;

  left: 12px;

  padding: 6px 8px;

  font-size: 7px;

  letter-spacing: 1px;
}


.active-status {
  background: #111111;

  color: #ffffff;
}


.inactive-status {
  background: #ffffff;

  color: #777777;
}


.admin-product-info {
  padding: 18px;
}


.admin-product-info > span {
  color: #999999;

  font-size: 7px;

  letter-spacing: 1.5px;
}


.admin-product-info h3 {
  margin: 7px 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 16px;

  font-weight: 400;
}


.admin-product-info strong {
  font-size: 10px;
}


.admin-product-info p {
  margin: 7px 0 0;

  color: #999999;

  font-size: 8px;
}


.product-actions {
  display: grid;

  grid-template-columns: 1fr 1fr;

  border-top: 1px solid #eeeeee;
}


.product-actions button {
  padding: 12px;

  border: none;

  background: transparent;

  font-size: 7px;

  letter-spacing: 1px;

  cursor: pointer;
}


.product-actions button + button {
  border-left: 1px solid #eeeeee;

  color: #888888;
}


.product-actions button:hover {
  background: #f3f3f3;
}


/* =====================================================
   FULL PANEL / TABLE
===================================================== */

.full-panel {
  background: #ffffff;

  border: 1px solid #dddddd;

  overflow-x: auto;
}


.admin-table-header,
.admin-table-row {
  min-width: 650px;

  display: grid;

  grid-template-columns:
    1fr 1.5fr 1fr 1fr 1fr;

  align-items: center;

  gap: 15px;

  padding: 18px 22px;
}


.admin-table-header {
  border-bottom: 1px solid #dddddd;

  color: #999999;

  font-size: 7px;

  letter-spacing: 1.5px;
}


.admin-table-row {
  border-bottom: 1px solid #eeeeee;

  font-size: 9px;
}


.admin-table-row:last-child {
  border-bottom: none;
}


/* =====================================================
   CUSTOMERS
===================================================== */

.customer-grid {
  display: grid;

  grid-template-columns:
    repeat(3, 1fr);

  gap: 15px;
}


.customer-card {
  background: #ffffff;

  border: 1px solid #dddddd;

  padding: 25px;

  display: flex;

  align-items: center;

  gap: 15px;
}


.customer-avatar {
  flex-shrink: 0;

  width: 50px;

  height: 50px;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111111;

  color: #ffffff;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 12px;
}


.customer-card h3 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 16px;

  font-weight: 400;
}


.customer-card p {
  margin: 5px 0;

  color: #888888;

  font-size: 9px;
}


.customer-card span {
  color: #999999;

  font-size: 8px;
}


/* =====================================================
   CATEGORIES
===================================================== */

.category-admin-grid {
  display: grid;

  grid-template-columns:
    repeat(2, 1fr);

  gap: 15px;
}


.category-admin-card {
  min-height: 250px;

  padding: 35px;

  background: #111111;

  color: #ffffff;

  display: flex;

  flex-direction: column;

  justify-content: space-between;
}


.category-admin-card > span {
  color: #777777;

  font-size: 9px;
}


.category-admin-card h3 {
  margin: 20px 0 5px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 40px;

  font-weight: 400;
}


.category-admin-card p {
  margin: 0;

  color: #999999;

  font-size: 9px;
}


.category-admin-card button {
  align-self: flex-start;

  margin-top: 25px;

  border: none;

  border-bottom: 1px solid #ffffff;

  background: transparent;

  color: #ffffff;

  padding: 0 0 6px;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;
}


/* =====================================================
   INVENTORY
===================================================== */

.inventory-summary {
  display: grid;

  grid-template-columns:
    repeat(3, 1fr);

  gap: 15px;

  margin-bottom: 25px;
}


.inventory-summary > div {
  padding: 25px;

  background: #ffffff;

  border: 1px solid #dddddd;
}


.inventory-summary span {
  display: block;

  color: #999999;

  font-size: 8px;

  letter-spacing: 1.5px;
}


.inventory-summary strong {
  display: block;

  margin-top: 12px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 35px;

  font-weight: 400;
}


.inventory-header,
.inventory-row {
  grid-template-columns:
    2fr 1fr 1fr 1fr;
}


.inventory-status {
  font-size: 7px;

  letter-spacing: 1px;
}


.in-stock {
  color: #333333;
}


.low-stock {
  color: #888888;
}


.out-stock {
  color: #111111;

  font-weight: bold;
}


/* =====================================================
   REPORTS
===================================================== */

.report-grid {
  display: grid;

  grid-template-columns:
    repeat(3, 1fr);

  gap: 15px;

  margin-bottom: 25px;
}


.report-card {
  background: #ffffff;

  border: 1px solid #dddddd;

  padding: 30px;
}


.report-card span {
  display: block;

  color: #999999;

  font-size: 8px;

  letter-spacing: 1.5px;
}


.report-card strong {
  display: block;

  margin: 20px 0 7px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 30px;

  font-weight: 400;
}


.report-card small {
  color: #777777;

  font-size: 8px;
}


.report-message {
  min-height: 300px;

  padding: 45px;

  background: #111111;

  color: #ffffff;

  display: flex;

  flex-direction: column;

  justify-content: center;
}


.report-message > span {
  color: #777777;

  font-size: 8px;

  letter-spacing: 2px;
}


.report-message h3 {
  margin: 20px 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 48px;

  font-weight: 400;
}


.report-message p {
  max-width: 500px;

  margin: 0;

  color: #999999;

  font-size: 11px;

  line-height: 1.8;
}


/* =====================================================
   SETTINGS
===================================================== */

.settings-panel {
  max-width: 850px;

  background: #ffffff;

  border: 1px solid #dddddd;

  padding: 35px;
}


.setting-row {
  display: grid;

  grid-template-columns: 1fr 1fr;

  align-items: center;

  gap: 40px;

  padding: 25px 0;

  border-bottom: 1px solid #eeeeee;
}


.setting-row strong {
  display: block;

  font-size: 11px;

  font-weight: 500;
}


.setting-row span {
  display: block;

  margin-top: 6px;

  color: #999999;

  font-size: 8px;
}


.setting-row input,
.setting-row select {
  width: 100%;

  border: none;

  border-bottom: 1px solid #cccccc;

  background: transparent;

  padding: 12px 0;

  outline: none;

  font-size: 10px;
}


.save-settings {
  margin-top: 30px;
}


/* =====================================================
   NOTIFICATION
===================================================== */

.notification-box {
  position: fixed;

  top: 80px;

  right: 30px;

  width: 300px;

  background: #ffffff;

  border: 1px solid #dddddd;

  box-shadow:
    0 10px 30px rgba(0, 0, 0, 0.08);

  padding: 20px;

  z-index: 300;
}


.notification-header {
  display: flex;

  justify-content: space-between;

  padding-bottom: 15px;

  border-bottom: 1px solid #eeeeee;
}


.notification-header strong {
  font-size: 9px;

  letter-spacing: 1.5px;
}


.notification-header button {
  border: none;

  background: transparent;

  font-size: 18px;

  cursor: pointer;
}


.notification-box p {
  padding: 12px 0;

  margin: 0;

  border-bottom: 1px solid #eeeeee;

  color: #777777;

  font-size: 9px;

  line-height: 1.6;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1200px) {

  .stats-grid {
    grid-template-columns:
      repeat(2, 1fr);
  }


  .product-admin-grid {
    grid-template-columns:
      repeat(3, 1fr);
  }


  .customer-grid {
    grid-template-columns:
      repeat(2, 1fr);
  }

}


@media (max-width: 1000px) {

  .sidebar {
    transform: translateX(-100%);

    transition:
      transform 0.3s ease;
  }


  .sidebar.sidebar-open {
    transform: translateX(0);
  }


  .close-sidebar {
    display: block;

    margin-left: auto;

    border: none;

    background: transparent;

    color: #ffffff;

    font-size: 25px;

    cursor: pointer;
  }


  .main-content {
    margin-left: 0;
  }


  .menu-toggle {
    display: block;
  }


  .topbar {
    padding: 0 25px;
  }


  .dashboard-grid,
  .dashboard-grid.lower {
    grid-template-columns: 1fr;
  }

}


@media (max-width: 700px) {

  .content {
    padding: 25px 18px;
  }


  .topbar {
    height: 85px;

    padding: 0 18px;
  }


  .topbar-title h1 {
    font-size: 25px;
  }


  .topbar-actions {
    gap: 10px;
  }


  .view-store {
    display: none;
  }


  .welcome {
    display: block;
  }


  .welcome h2 {
    font-size: 40px;
  }


  .date-box {
    margin-top: 25px;

    display: inline-block;
  }


  .stats-grid {
    grid-template-columns: 1fr;
  }


  .quick-grid {
    grid-template-columns:
      repeat(2, 1fr);
  }


  .product-admin-grid {
    grid-template-columns:
      repeat(2, 1fr);
  }


  .customer-grid {
    grid-template-columns: 1fr;
  }


  .category-admin-grid {
    grid-template-columns: 1fr;
  }


  .inventory-summary {
    grid-template-columns: 1fr;
  }


  .report-grid {
    grid-template-columns: 1fr;
  }


  .page-heading {
    display: block;
  }


  .page-heading h2 {
    font-size: 42px;
  }


  .page-heading .primary-button {
    margin-top: 20px;
  }


  .toolbar {
    flex-direction: column;
  }


  .toolbar select {
    width: 100%;
  }


  .setting-row {
    grid-template-columns: 1fr;

    gap: 15px;
  }


  .notification-box {
    right: 15px;

    left: 15px;

    width: auto;
  }

}


@media (max-width: 480px) {

  .product-admin-grid {
    grid-template-columns: 1fr;
  }


  .quick-grid {
    grid-template-columns: 1fr;
  }


  .panel {
    padding: 20px;
  }


  .welcome h2 {
    font-size: 36px;
  }


  .report-message h3 {
    font-size: 38px;
  }

}

</style>