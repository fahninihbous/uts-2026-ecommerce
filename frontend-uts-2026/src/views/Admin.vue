<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

// Set baseURL API Laravel
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

// State Menu Sidebar Aktif ('dashboard', 'categories', 'products', 'orders')
const activeMenu = ref('dashboard')

// State untuk Sidebar Buka/Tutup
const isSidebarOpen = ref(true)
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

// Data States
const categories = ref([])
const products = ref([])
const orders = ref([])
const loading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

// Modal States
const showCategoryModal = ref(false)
const showProductModal = ref(false)
const showOrderDetailModal = ref(false)
const selectedOrder = ref(null)
const isEditing = ref(false)

// Form State Kategori
const categoryForm = ref({
  id: null,
  name: '',
  description: '',
  image: null,
  is_active: true
})

// Form State Produk
const productForm = ref({
  id: null,
  category_id: '',
  name: '',
  slug: '',
  description: '',
  price: 0,
  stock: 0,
  is_active: true,
  images: []
})

// Ambil token dan set header authorization
const getAuthHeaders = () => {
  const token = localStorage.getItem('token')
  return { headers: { Authorization: `Bearer ${token}` } }
}

// ==========================================
// FETCH DATA (Categories, Products, Orders)
// ==========================================
const fetchData = async () => {
  loading.value = true
  errorMessage.value = ''
  try {
    const catRes = await axios.get('/kategori', getAuthHeaders())
    categories.value = Array.isArray(catRes.data) ? catRes.data : (catRes.data.data || [])

    const prodRes = await axios.get('/produk', getAuthHeaders())
    products.value = Array.isArray(prodRes.data) ? prodRes.data : (prodRes.data.data || [])

    // Ambil data pesanan (pastikan endpoint admin/pesanan atau /pesanan tersedia di backend)
    const ordRes = await axios.get('/admin/pesanan', getAuthHeaders()).catch(() => axios.get('/pesanan', getAuthHeaders()))
    orders.value = Array.isArray(ordRes.data) ? ordRes.data : (ordRes.data.data || [])
  } catch (error) {
    errorMessage.value = 'Gagal memuat data dari server. Pastikan Anda login sebagai Admin.'
    console.error(error)
  } finally {
    loading.value = false
  }
}

// ==========================================
// STATISTIK DASHBOARD
// ==========================================
const stats = computed(() => {
  let totalRevenue = 0
  let totalItemsSold = 0
  let pendingCount = 0

  orders.value.forEach(order => {
    if (order.status !== 'cancelled' && order.payment_status === 'paid' || order.status === 'completed') {
      totalRevenue += Number(order.total_amount || 0)
    }
    if (order.status === 'pending') {
      pendingCount++
    }
    if (order.items && Array.isArray(order.items)) {
      order.items.forEach(item => {
        if (order.status !== 'cancelled') {
          totalItemsSold += Number(item.quantity || 0)
        }
      })
    }
  })

  return {
    revenue: totalRevenue,
    itemsSold: totalItemsSold,
    totalProducts: products.value.length,
    totalCategories: categories.value.length,
    pendingOrders: pendingCount,
    totalOrders: orders.value.length
  }
})

// ==========================================
// UPDATE STATUS PESANAN OLEH ADMIN
// ==========================================
const updateOrderStatus = async (orderId, newStatus) => {
  try {
    const token = localStorage.getItem('token')
    await axios.put(`/admin/pesanan/${orderId}/status`, { status: newStatus }, {
      headers: { Authorization: `Bearer ${token}` }
    })
    successMessage.value = `Status pesanan berhasil diubah menjadi ${newStatus}.`
    fetchData()
    setTimeout(() => successMessage.value = '', 3000)
  } catch (error) {
    alert('Gagal mengubah status pesanan: ' + (error.response?.data?.message || error.message))
  }
}

const openOrderDetail = (order) => {
  selectedOrder.value = order
  showOrderDetailModal.value = true
}

// Auto-generate slug sederhana berdasarkan nama produk
const generateSlug = () => {
  if (!productForm.value.name) return
  productForm.value.slug = productForm.value.name
    .toLowerCase()
    .replace(/[^a-z0-9\s-]/g, '')
    .trim()
    .replace(/\s+/g, '-')
}

// ==========================================
// KATEGORI CRUD
// ==========================================
const openCategoryModal = (category = null) => {
  if (category) {
    isEditing.value = true
    categoryForm.value = { 
      id: category.id,
      name: category.name,
      description: category.description,
      image: null,
      is_active: category.is_active 
    }
  } else {
    isEditing.value = false
    categoryForm.value = { id: null, name: '', description: '', image: null, is_active: true }
  }
  showCategoryModal.value = true
}

const saveCategory = async () => {
  try {
    const formData = new FormData()
    formData.append('name', categoryForm.value.name)
    formData.append('description', categoryForm.value.description || '')
    formData.append('is_active', categoryForm.value.is_active ? 1 : 0)
    
    if (categoryForm.value.image instanceof File) {
      formData.append('image', categoryForm.value.image)
    }

    const token = localStorage.getItem('token')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'multipart/form-data'
      }
    }

    if (isEditing.value) {
      formData.append('_method', 'PUT')
      await axios.post(`/kategori/${categoryForm.value.id}`, formData, config)
      successMessage.value = 'Kategori berhasil diperbarui.'
    } else {
      await axios.post('/kategori', formData, config)
      successMessage.value = 'Kategori berhasil ditambahkan.'
    }

    showCategoryModal.value = false
    fetchData()
    setTimeout(() => successMessage.value = '', 3000)
  } catch (error) {
    alert('Gagal menyimpan kategori: ' + (error.response?.data?.message || error.message))
  }
}

const deleteCategory = async (id) => {
  if (!confirm('Yakin ingin menghapus kategori ini?')) return
  try {
    await axios.delete(`/kategori/${id}`, getAuthHeaders())
    successMessage.value = 'Kategori berhasil dihapus.'
    fetchData()
    setTimeout(() => successMessage.value = '', 3000)
  } catch (error) {
    alert('Gagal menghapus kategori.')
  }
}

const handleFileUpload = (event) => {
  categoryForm.value.image = event.target.files[0]
}

// ==========================================
// PRODUK CRUD
// ==========================================
const handleProductFiles = (event) => {
  productForm.value.images = Array.from(event.target.files)
}

const openProductModal = (product = null) => {
  if (product) {
    isEditing.value = true
    productForm.value = { 
      id: product.id,
      category_id: product.category_id || '',
      name: product.name || '',
      slug: product.slug || '',
      description: product.description || '',
      price: product.price || 0,
      stock: product.stock || 0,
      is_active: product.is_active !== undefined ? Boolean(product.is_active) : true,
      images: []
    }
  } else {
    isEditing.value = false
    productForm.value = {
      id: null,
      category_id: categories.value[0]?.id || '',
      name: '',
      slug: '',
      description: '',
      price: 0,
      stock: 0,
      is_active: true,
      images: []
    }
  }
  showProductModal.value = true
}

const saveProduct = async () => {
  try {
    const formData = new FormData()
    formData.append('category_id', productForm.value.category_id)
    formData.append('name', productForm.value.name)
    formData.append('slug', productForm.value.slug)
    formData.append('description', productForm.value.description || '')
    formData.append('price', productForm.value.price)
    formData.append('stock', productForm.value.stock)
    formData.append('is_active', productForm.value.is_active ? 1 : 0)

    productForm.value.images.forEach((file) => {
      formData.append('images[]', file)
    })

    const token = localStorage.getItem('token')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'multipart/form-data'
      }
    }

    if (isEditing.value) {
      formData.append('_method', 'PUT')
      await axios.post(`/produk/${productForm.value.id}`, formData, config)
      successMessage.value = 'Produk berhasil diperbarui.'
    } else {
      await axios.post('/produk', formData, config)
      successMessage.value = 'Produk berhasil ditambahkan.'
    }

    showProductModal.value = false
    fetchData()
    setTimeout(() => successMessage.value = '', 3000)
  } catch (error) {
    alert('Gagal menyimpan produk: ' + (error.response?.data?.message || error.message))
  }
}

const deleteProduct = async (id) => {
  if (!confirm('Yakin ingin menghapus produk ini?')) return
  try {
    await axios.delete(`/produk/${id}`, getAuthHeaders())
    successMessage.value = 'Produk berhasil dihapus.'
    fetchData()
    setTimeout(() => successMessage.value = '', 3000)
  } catch (error) {
    alert('Gagal menghapus produk.')
  }
}

onMounted(() => {
  fetchData()
})
</script>

<template>
  <div class="admin-layout">
    
    <!-- ================= SIDEBAR ================= -->
    <aside :class="['admin-sidebar', { closed: !isSidebarOpen }]">
      <div class="sidebar-top" @click="toggleSidebar" title="Toggle Sidebar">
        <div class="sidebar-brand-icon">P</div>
        <span v-if="isSidebarOpen" class="sidebar-brand-title">PROVIDENTIAL</span>
      </div>

      <nav class="sidebar-nav">
        <button 
          :class="['sidebar-link', { active: activeMenu === 'dashboard' }]" 
          @click="activeMenu = 'dashboard'"
          title="Dashboard"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
          <span v-if="isSidebarOpen" class="link-label">Dashboard</span>
        </button>

        <button 
          :class="['sidebar-link', { active: activeMenu === 'orders' }]" 
          @click="activeMenu = 'orders'"
          title="Pesanan"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
          <span v-if="isSidebarOpen" class="link-label">Pesanan Masuk</span>
          <span v-if="stats.pendingOrders > 0" class="badge-count alert">{{ stats.pendingOrders }}</span>
        </button>

        <button 
          :class="['sidebar-link', { active: activeMenu === 'categories' }]" 
          @click="activeMenu = 'categories'"
          title="Kategori"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
          <span v-if="isSidebarOpen" class="link-label">Kategori</span>
          <span v-if="categories.length > 0" class="badge-count">{{ categories.length }}</span>
        </button>

        <button 
          :class="['sidebar-link', { active: activeMenu === 'products' }]" 
          @click="activeMenu = 'products'"
          title="Produk"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
          <span v-if="isSidebarOpen" class="link-label">Produk</span>
          <span v-if="products.length > 0" class="badge-count">{{ products.length }}</span>
        </button>
      </nav>

      <div class="sidebar-footer">
        <router-link to="/home" class="btn-exit-store" title="Keluar ke Toko">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          <span v-if="isSidebarOpen">Keluar Toko</span>
        </router-link>
      </div>
    </aside>

    <!-- ================= MAIN CONTENT AREA ================= -->
    <main :class="['admin-main', { expanded: !isSidebarOpen }]">
      
      <!-- Top Bar -->
      <header class="main-header">
        <div class="header-title-wrap">
          <span class="sub-brand-tag">ADMINISTRATION PANEL</span>
          <h1>Admin Providential</h1>
          <p>Kelola data katalog, inventaris, dan pesanan pelanggan toko secara real-time.</p>
        </div>
        <div class="badge-admin">
          <span></span> Super Admin
        </div>
      </header>

      <!-- Alert Pesan Sukses / Error -->
      <div v-if="successMessage" class="alert-message success">{{ successMessage }}</div>
      <div v-if="errorMessage" class="alert-message error">{{ errorMessage }}</div>

      <!-- ================= 1. DASHBOARD UTAMA ================= -->
      <section v-if="activeMenu === 'dashboard'" class="content-table-card">
        <div class="table-header-row">
          <h2>Ringkasan Dashboard Toko</h2>
        </div>
        
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-title">Total Pendapatan</div>
            <div class="stat-value">Rp {{ Number(stats.revenue).toLocaleString('id-ID') }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Barang Terjual</div>
            <div class="stat-value">{{ stats.itemsSold }} Pcs</div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Jumlah Produk</div>
            <div class="stat-value">{{ stats.totalProducts }} Item</div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Jumlah Kategori</div>
            <div class="stat-value">{{ stats.totalCategories }} Kategori</div>
          </div>
          <div class="stat-card highlight">
            <div class="stat-title">Pesanan Pending</div>
            <div class="stat-value">{{ stats.pendingOrders }} Pesanan</div>
          </div>
          <div class="stat-card">
            <div class="stat-title">Total Seluruh Pesanan</div>
            <div class="stat-value">{{ stats.totalOrders }} Pesanan</div>
          </div>
        </div>
      </section>

      <!-- ================= 2. PESANAN MASUK ================= -->
      <section v-if="activeMenu === 'orders'" class="content-table-card">
        <div class="table-header-row">
          <h2>Manajemen Pesanan Pelanggan</h2>
        </div>

        <div class="table-responsive">
          <table class="admin-data-table">
            <thead>
              <tr>
                <th>No. Pesanan</th>
                <th>Pemesan</th>
                <th>Total Biaya</th>
                <th>Status Pembayaran</th>
                <th>Status Pesanan</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="orders.length === 0">
                <td colspan="6" class="empty-row-text">Belum ada pesanan masuk.</td>
              </tr>
              <tr v-else v-for="ord in orders" :key="ord.id">
                <td class="bold-text">{{ ord.order_number }}</td>
                <td>
                  <div>{{ ord.shipping_name || ord.user?.name }}</div>
                  <small style="color: #777;">{{ ord.shipping_phone }}</small>
                </td>
                <td>Rp {{ Number(ord.total_amount).toLocaleString('id-ID') }}</td>
                <td>
                  <span :class="['status-pill', ord.payment_status === 'paid' ? 'active' : 'inactive']">
                    {{ ord.payment_status }}
                  </span>
                </td>
                <td>
                  <select :value="ord.status" @change="updateOrderStatus(ord.id, $event.target.value)" class="status-select">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                  </select>
                </td>
                <td style="text-align: center;">
                  <button class="btn-edit" @click="openOrderDetail(ord)">Detail</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- ================= 3. KATEGORI KATALOG TABLE ================= -->
      <section v-if="activeMenu === 'categories'" class="content-table-card">
        <div class="table-header-row">
          <h2>Manajemen Kategori Katalog</h2>
          <button class="btn-primary" @click="openCategoryModal()">+ Tambah Kategori</button>
        </div>

        <div class="table-responsive">
          <table class="admin-data-table">
            <thead>
              <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th style="width: 150px;">Status</th>
                <th style="width: 180px; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="categories.length === 0">
                <td colspan="5" class="empty-row-text">Belum ada data kategori tersedia.</td>
              </tr>
              <tr v-else v-for="(cat, index) in categories" :key="cat.id">
                <td>{{ index + 1 }}</td>
                <td class="bold-text">{{ cat.name }}</td>
                <td>{{ cat.description || '-' }}</td>
                <td>
                  <span :class="['status-pill', cat.is_active ? 'active' : 'inactive']">
                    {{ cat.is_active ? 'Aktif' : 'Nonaktif' }}
                  </span>
                </td>
                <td style="text-align: center;">
                  <div class="action-btn-group" style="justify-content: center;">
                    <button class="btn-edit" @click="openCategoryModal(cat)">Edit</button>
                    <button class="btn-delete" @click="deleteCategory(cat.id)">Hapus</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- ================= 4. PRODUK TABLE ================= -->
      <section v-if="activeMenu === 'products'" class="content-table-card">
        <div class="table-header-row">
          <h2>Manajemen Koleksi Produk</h2>
          <button class="btn-primary" @click="openProductModal()">+ Tambah Produk Baru</button>
        </div>

        <div class="table-responsive">
          <table class="admin-data-table">
            <thead>
              <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="width: 180px; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="products.length === 0">
                <td colspan="6" class="empty-row-text">Belum ada data produk tersedia.</td>
              </tr>
              <tr v-else v-for="(prod, index) in products" :key="prod.id">
                <td>{{ index + 1 }}</td>
                <td>
                  <span class="bold-text">{{ prod.name }}</span>
                </td>
                <td>{{ prod.category?.name || '-' }}</td>
                <td>Rp {{ Number(prod.price).toLocaleString('id-ID') }}</td>
                <td>{{ prod.stock }} Pcs</td>
                <td style="text-align: center;">
                  <div class="action-btn-group" style="justify-content: center;">
                    <button class="btn-edit" @click="openProductModal(prod)">Edit</button>
                    <button class="btn-delete" @click="deleteProduct(prod.id)">Hapus</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

    </main>

    <!-- ================= MODAL DETAIL PESANAN ================= -->
    <div v-if="showOrderDetailModal" class="modal-overlay">
      <div class="modal-card" style="max-width: 600px;">
        <h3>Detail Pesanan #{{ selectedOrder?.order_number }}</h3>
        <div v-if="selectedOrder" class="order-detail-content" style="margin-bottom: 20px;">
          <p><strong>Nama Penerima:</strong> {{ selectedOrder.shipping_name }}</p>
          <p><strong>No Telepon:</strong> {{ selectedOrder.shipping_phone }}</p>
          <p><strong>Alamat Pengiriman:</strong> {{ selectedOrder.shipping_address }}</p>
          <p><strong>Ongkir:</strong> Rp {{ Number(selectedOrder.shipping_cost || 0).toLocaleString('id-ID') }}</p>
          <p><strong>Total Keseluruhan:</strong> Rp {{ Number(selectedOrder.total_amount || 0).toLocaleString('id-ID') }}</p>
          
          <h4 style="margin-top: 15px; margin-bottom: 8px;">Daftar Barang:</h4>
          <ul style="padding-left: 20px;">
            <li v-for="item in selectedOrder.items" :key="item.id">
              {{ item.product_name }} ({{ item.quantity }}x) - Rp {{ Number(item.subtotal || item.price * item.quantity).toLocaleString('id-ID') }}
            </li>
          </ul>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn-primary" @click="showOrderDetailModal = false">Tutup</button>
        </div>
      </div>
    </div>

    <!-- ================= MODAL KATEGORI ================= -->
    <div v-if="showCategoryModal" class="modal-overlay">
      <div class="modal-card">
        <h3>{{ isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
        <form @submit.prevent="saveCategory" class="modal-form">
          <div class="form-group">
            <label>Nama Kategori</label>
            <input v-model="categoryForm.name" type="text" required placeholder="Contoh: Outerwear" />
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea v-model="categoryForm.description" placeholder="Deskripsi kategori..."></textarea>
          </div>
          <div class="form-group">
            <label>Foto Kategori</label>
            <input type="file" @change="handleFileUpload" accept="image/*" />
          </div>
          <div class="form-group row-checkbox">
            <input v-model="categoryForm.is_active" type="checkbox" id="catActive" />
            <label for="catActive" style="margin: 0;">Aktifkan Kategori</label>
          </div>
          <div class="modal-actions">
            <button type="button" class="btn-text" @click="showCategoryModal = false">Batal</button>
            <button type="submit" class="btn-primary">Simpan Data</button>
          </div>
        </form>
      </div>
    </div>

    <!-- ================= MODAL PRODUK ================= -->
    <div v-if="showProductModal" class="modal-overlay">
      <div class="modal-card">
        <h3>{{ isEditing ? 'Edit Informasi Produk' : 'Tambah Produk Baru' }}</h3>
        <form @submit.prevent="saveProduct" class="modal-form">
          <div class="form-group">
            <label>Nama Produk</label>
            <input v-model="productForm.name" type="text" required placeholder="Contoh: Overcoat Wool Black" @input="generateSlug" />
          </div>
          
          <div class="form-group">
            <label>Slug URL</label>
            <input v-model="productForm.slug" type="text" required />
          </div>
          
          <div class="form-grid-2">
            <div class="form-group">
              <label>Kategori Produk</label>
              <select v-model="productForm.category_id" required>
                <option value="" disabled>Pilih Kategori</option>
                <option v-for="cat in categories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>Harga Produk (Rupiah)</label>
              <input v-model="productForm.price" type="number" required min="0" />
            </div>
          </div>

          <div class="form-group">
            <label>Stok Ketersediaan</label>
            <input v-model="productForm.stock" type="number" required min="0" />
          </div>

          <div class="form-group">
            <label>Foto Produk (Bisa pilih lebih dari satu)</label>
            <input type="file" @change="handleProductFiles" multiple accept="image/*" />
          </div>

          <div class="form-group">
            <label>Deskripsi Produk</label>
            <textarea v-model="productForm.description" rows="3" placeholder="Penjelasan detail produk..."></textarea>
          </div>

          <div class="form-group row-checkbox">
            <input v-model="productForm.is_active" type="checkbox" id="prodActive" />
            <label for="prodActive" style="margin: 0;">Tampilkan Publik (Aktif)</label>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-text" @click="showProductModal = false">Batal</button>
            <button type="submit" class="btn-primary">Simpan Produk</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>


<style scoped>
/* =====================================================
ADMIN LAYOUT SYSTEM & MODERN DESIGNS
===================================================== */
.admin-layout {
  display: flex;
  min-height: 100vh;
  background-color: #f8f9fa;
  font-family: 'Inter', sans-serif;
  color: #212529;
}

/* SIDEBAR STYLES */
.admin-sidebar {
  width: 260px;
  background-color: #11151c;
  color: #ffffff;
  display: flex;
  flex-direction: column;
  transition: width 0.3s ease;
  position: fixed;
  height: 100vh;
  z-index: 99;
}
.admin-sidebar.closed { width: 70px; }

.sidebar-top {
  padding: 24px 20px;
  display: flex;
  align-items: center;
  gap: 15px;
  border-bottom: 1px solid #222e3d;
  cursor: pointer;
  user-select: none;
}
.sidebar-top:hover {
  background-color: rgba(255, 255, 255, 0.03);
}

.sidebar-brand-icon {
  width: 32px;
  height: 32px;
  background-color: #ffffff;
  color: #11151c;
  font-weight: 800;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  border-radius: 4px;
}

.sidebar-brand-title {
  font-weight: 700;
  letter-spacing: 2px;
  font-size: 14px;
  white-space: nowrap;
}

.sidebar-nav {
  padding: 30px 10px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex: 1;
}

.sidebar-link {
  background: none;
  border: none;
  width: 100%;
  padding: 14px 15px;
  color: #a0aec0;
  display: flex;
  align-items: center;
  gap: 15px;
  cursor: pointer;
  border-radius: 6px;
  text-align: left;
  transition: all 0.2s ease;
  position: relative;
}

.sidebar-link:hover, .sidebar-link.active {
  background-color: #222e3d;
  color: #ffffff;
}

.link-label { font-size: 13px; font-weight: 500; white-space: nowrap; }

.badge-count {
  position: absolute;
  right: 15px;
  background-color: #e53e3e;
  color: #ffffff;
  font-size: 10px;
  padding: 2px 7px;
  border-radius: 10px;
}
.admin-sidebar.closed .badge-count {
  position: absolute;
  top: 6px;
  right: 6px;
}

.sidebar-footer {
  padding: 20px;
  border-top: 1px solid #222e3d;
}

.btn-exit-store {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #a0aec0;
  text-decoration: none;
  font-size: 13px;
  white-space: nowrap;
}
.btn-exit-store:hover { color: #ffffff; }

/* MAIN CONTENT BOX */
.admin-main {
  flex: 1;
  margin-left: 260px;
  padding: 40px;
  transition: margin-left 0.3s ease;
}
.admin-main.expanded { margin-left: 70px; }

.main-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 30px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  margin-bottom: 35px;
}

.sub-brand-tag { font-size: 10px; letter-spacing: 2px; color: #a0aec0; font-weight: 600; }
.main-header h1 { font-size: 28px; font-weight: 700; margin: 8px 0; letter-spacing: -0.5px; }
.main-header p { font-size: 13px; color: #718096; margin: 0; }

.badge-admin {
  background-color: #ebf8ff;
  color: #2b6cb0;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
}
.badge-admin span { width: 6px; height: 6px; background-color: #3182ce; border-radius: 50%; }

/* TABLES & MANAGEMENT CONTENT */
.content-table-card {
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  padding: 30px;
}

.table-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}
.table-header-row h2 { font-size: 18px; font-weight: 600; margin: 0; }

.admin-data-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.admin-data-table th {
  background-color: #f7fafc;
  color: #4a5568;
  font-weight: 600;
  text-align: left;
  padding: 16px 20px;
  border-bottom: 2px solid #edf2f7;
}

.admin-data-table td {
  padding: 16px 20px;
  border-bottom: 1px solid #edf2f7;
  color: #4a5568;
}

.bold-text { font-weight: 600; color: #1a202c; }
.empty-row-text { text-align: center; color: #a0aec0; padding: 40px !important; }

.status-pill {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 500;
}
.status-pill.active { background-color: #c6f6d5; color: #22543d; }
.status-pill.inactive { background-color: #fed7d7; color: #742a2a; }

.action-btn-group { display: flex; gap: 10px; }
.action-btn-group button {
  background: none;
  border: none;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
}
.btn-edit { color: #3182ce; }
.btn-delete { color: #e53e3e; }

/* BUTTONS & ALERTS */
.btn-primary {
  background-color: #11151c;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 12px;
  font-weight: 600;
  border-radius: 4px;
  cursor: pointer;
}
.btn-primary:hover { background-color: #2d3748; }

.alert-message {
  padding: 12px 20px;
  border-radius: 6px;
  font-size: 13px;
  margin-bottom: 25px;
}
.alert-message.success { background-color: #c6f6d5; color: #22543d; }
.alert-message.error { background-color: #fed7d7; color: #742a2a; }

/* =====================================================
MODAL WINDOW DIALOGS
===================================================== */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal-card {
  background-color: #ffffff;
  border-radius: 8px;
  padding: 35px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.modal-card h3 { margin: 0 0 25px 0; font-size: 18px; font-weight: 600; }

.modal-form { display: flex; flex-direction: column; gap: 20px; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-group label { font-size: 12px; font-weight: 600; color: #4a5568; }
.form-group input, .form-group textarea, .form-group select {
  padding: 10px 14px;
  border: 1px solid #cbd5e0;
  border-radius: 4px;
  font-size: 13px;
  background-color: #ffffff;
  font-family: 'Inter', sans-serif;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #11151c; }

.row-checkbox { flex-direction: row; align-items: center; gap: 10px; cursor: pointer; }
.row-checkbox input { width: auto; cursor: pointer; }

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 15px;
}
.btn-text { background: none; border: none; font-size: 13px; color: #718096; cursor: pointer; }

/* RESPONSIVE DESIGN */
@media (max-width: 992px) {
  .admin-main { margin-left: 70px; padding: 20px; }
  .admin-sidebar { width: 70px; }
  .sidebar-brand-title, .link-label, .badge-count, .sidebar-footer span { display: none; }
  .form-grid-2 { grid-template-columns: 1fr; gap: 20px; }
}
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-top: 15px;
}
.stat-card {
  background: #f9f9f9;
  border: 1px solid #eee;
  padding: 20px;
  border-radius: 8px;
}
.stat-card.highlight {
  background: #fff8e6;
  border-color: #ffeeba;
}
.stat-title {
  font-size: 13px;
  color: #666;
  text-transform: uppercase;
  margin-bottom: 8px;
  font-weight: 600;
}
.stat-value {
  font-size: 22px;
  font-weight: bold;
  color: #222;
}
.status-select {
  padding: 6px 10px;
  border-radius: 4px;
  border: 1px solid #ccc;
  background: #fff;
}
.badge-count.alert {
  background: #e74c3c;
  color: #fff;
}
</style>
