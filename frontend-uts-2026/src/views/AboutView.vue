<template>
  <div class="about-wrapper">
    <div class="about-container">
      
      <!-- Hero Section -->
      <section class="hero-section">
        <h1 class="brand-title">PROVIDENTIAL</h1>
        <p class="brand-tagline">Minimalist Fashion & Apparel</p>
        <div class="divider-line"></div>
      </section>

      <!-- Content Section -->
      <section class="content-section">
        <div class="info-card">
          <h2>About Us</h2>
          <p>
           Providential is here to provide an elegant, simple, and timeless dressing experience.
           We believe that true beauty in fashion lies in simplicity and the finest quality materials.
          </p>
        </div>

        <!-- Grid Keunggulan / Nilai Brand -->
        <div class="values-grid">
          <div class="value-card">
            <div class="icon">✨</div>
            <h3>Minimalist Design</h3>
            <p>Modern and clean cuts that can be easily combined for various occasions.</p>
          </div>

          <div class="value-card">
            <div class="icon">🌿</div>
            <h3>Material Quality</h3>
            <p>Using premium fabrics that are comfortable, soft against the skin, and durable.</p>
          </div>

          <div class="value-card">
            <div class="icon">💙</div>
            <h3>Sustained Style</h3>
            <p>Timeless designs that stand the test of time and remain relevant across seasons.</p>
          </div>
        </div>
      </section>

      <!-- Link Navigasi Kembali -->
      <div class="action-footer">
        <router-link to="/" class="btn-back">Back to Home</router-link>
        <router-link to="/login" class="btn-login">Sign in to Account</router-link>
      </div>

    </div>
  </div>
</template>

<style scoped>
.about-wrapper {
  min-height: 100vh;
  background-color: #f3f4f6;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 2rem 1rem;
  font-family: 'Inter', sans-serif;
}

.about-container {
  max-width: 800px;
  width: 100%;
  background-color: #ffffff;
  border-radius: 20px;
  padding: 2.5rem;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
  border: 1px solid #e5e7eb;
}

/* Hero Section */
.hero-section {
  text-align: center;
  margin-bottom: 2rem;
}

.brand-title {
  font-size: 2.25rem;
  font-weight: 700;
  color: #111827;
  letter-spacing: 3px;
  margin: 0;
}

.brand-tagline {
  font-size: 0.8rem;
  letter-spacing: 2px;
  color: #6b7280;
  text-transform: uppercase;
  margin-top: 6px;
}

.divider-line {
  width: 60px;
  height: 3px;
  background-color: #9ca3af;
  margin: 1.5rem auto 0;
  border-radius: 2px;
}

/* Content Section */
.info-card {
  text-align: center;
  margin-bottom: 2.5rem;
}

.info-card h2 {
  font-size: 1.3rem;
  color: #111827;
  margin-bottom: 0.75rem;
}

.info-card p {
  color: #4b5563;
  line-height: 1.6;
  font-size: 0.95rem;
  max-width: 600px;
  margin: 0 auto;
}

/* Grid Values */
.values-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2.5rem;
}

.value-card {
  background-color: #f9fafb;
  border: 1px solid #e5e7eb;
  padding: 1.5rem;
  border-radius: 12px;
  text-align: center;
  transition: transform 0.2s ease;
}

.value-card:hover {
  transform: translateY(-3px);
}

.value-card .icon {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.value-card h3 {
  font-size: 1rem;
  color: #111827;
  margin-bottom: 0.5rem;
}

.value-card p {
  font-size: 0.8rem;
  color: #6b7280;
  line-height: 1.4;
  margin: 0;
}

/* Navigasi Footer */
.action-footer {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1rem;
}

.btn-back, .btn-login {
  padding: 0.75rem 1.5rem;
  border-radius: 10px;
  font-size: 0.85rem;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-back {
  background-color: #f3f4f6;
  color: #4b5563;
  border: 1px solid #d1d5db;
}

.btn-back:hover {
  background-color: #e5e7eb;
}

.btn-login {
  background-color: #111827;
  color: #ffffff;
}

.btn-login:hover {
  background-color: #374151;
}
</style>