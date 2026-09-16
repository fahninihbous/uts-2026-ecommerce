<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const profile = ref({
  firstName: 'Naura',
  lastName: 'Zahra',
  email: 'naura@example.com',
  phone: '0812 3456 7890',
  gender: 'Female',
  birthDate: '2008-05-12',
  address: 'Jl. Example No. 123',
  city: 'Bandung',
  province: 'Jawa Barat',
  postalCode: '40123'
})

const isSaving = ref(false)

const saveProfile = () => {
  isSaving.value = true

  setTimeout(() => {
    isSaving.value = false

    alert('Profile berhasil diperbarui!')

    router.push('/profile')
  }, 800)
}

const cancelEdit = () => {
  router.push('/profile')
}
</script>


<template>

  <div class="edit-profile-page">

    <!-- =====================================
         NAVBAR
    ====================================== -->

    <header class="navbar">

      <div class="nav-left">

        <router-link to="/shop">
          SHOP
        </router-link>

        <router-link to="/about">
          OUR MISSION
        </router-link>

      </div>


      <router-link
        to="/home"
        class="logo"
      >
        PROVIDENTIAL
      </router-link>


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


    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <section class="page-header">

      <div class="page-number">
        01 — ACCOUNT / PROFILE
      </div>

      <h1>
        Edit <em>Profile</em>
      </h1>

      <p>
        Update your personal information and account details.
      </p>

    </section>


    <!-- =====================================
         MAIN CONTENT
    ====================================== -->

    <main class="edit-container">


      <!-- =====================================
           BACK BUTTON
      ====================================== -->

      <div class="back-section">

        <button
          class="back-button"
          @click="cancelEdit"
        >
          ← BACK TO PROFILE
        </button>

      </div>


      <!-- =====================================
           FORM
      ====================================== -->

      <form
        class="profile-form"
        @submit.prevent="saveProfile"
      >


        <!-- =====================================
             PROFILE IMAGE
        ====================================== -->

        <section class="form-section profile-photo-section">

          <div class="section-heading">

            <div class="section-number">
              01
            </div>

            <div>

              <h2>
                Profile
              </h2>

              <p>
                Your account identity.
              </p>

            </div>

          </div>


          <div class="profile-photo">

            <div class="avatar">
              {{ profile.firstName.charAt(0) }}
            </div>


            <div class="photo-info">

              <h3>
                {{ profile.firstName }}
                {{ profile.lastName }}
              </h3>

              <p>
                PROVIDENTIAL MEMBER
              </p>

              <button
                type="button"
                class="change-photo"
              >
                CHANGE PHOTO
              </button>

            </div>

          </div>

        </section>


        <!-- =====================================
             PERSONAL INFORMATION
        ====================================== -->

        <section class="form-section">

          <div class="section-heading">

            <div class="section-number">
              02
            </div>

            <div>

              <h2>
                Personal Information
              </h2>

              <p>
                Basic information about you.
              </p>

            </div>

          </div>


          <div class="form-grid">


            <!-- FIRST NAME -->

            <div class="form-group">

              <label>
                FIRST NAME
              </label>

              <input
                v-model="profile.firstName"
                type="text"
                placeholder="First name"
                required
              />

            </div>


            <!-- LAST NAME -->

            <div class="form-group">

              <label>
                LAST NAME
              </label>

              <input
                v-model="profile.lastName"
                type="text"
                placeholder="Last name"
                required
              />

            </div>


            <!-- GENDER -->

            <div class="form-group">

              <label>
                GENDER
              </label>

              <select
                v-model="profile.gender"
              >

                <option value="Female">
                  Female
                </option>

                <option value="Male">
                  Male
                </option>

              </select>

            </div>


            <!-- BIRTH DATE -->

            <div class="form-group">

              <label>
                DATE OF BIRTH
              </label>

              <input
                v-model="profile.birthDate"
                type="date"
              />

            </div>

          </div>

        </section>


        <!-- =====================================
             CONTACT INFORMATION
        ====================================== -->

        <section class="form-section">

          <div class="section-heading">

            <div class="section-number">
              03
            </div>

            <div>

              <h2>
                Contact
              </h2>

              <p>
                Your contact information.
              </p>

            </div>

          </div>


          <div class="form-grid">


            <!-- EMAIL -->

            <div class="form-group full">

              <label>
                EMAIL ADDRESS
              </label>

              <input
                v-model="profile.email"
                type="email"
                placeholder="Email address"
                required
              />

            </div>


            <!-- PHONE -->

            <div class="form-group full">

              <label>
                PHONE NUMBER
              </label>

              <input
                v-model="profile.phone"
                type="tel"
                placeholder="Phone number"
                required
              />

            </div>

          </div>

        </section>


        <!-- =====================================
             ADDRESS
        ====================================== -->

        <section class="form-section">

          <div class="section-heading">

            <div class="section-number">
              04
            </div>

            <div>

              <h2>
                Address
              </h2>

              <p>
                Your default shipping address.
              </p>

            </div>

          </div>


          <div class="form-grid">


            <!-- ADDRESS -->

            <div class="form-group full">

              <label>
                STREET ADDRESS
              </label>

              <textarea
                v-model="profile.address"
                placeholder="Street address"
                rows="3"
                required
              ></textarea>

            </div>


            <!-- CITY -->

            <div class="form-group">

              <label>
                CITY
              </label>

              <input
                v-model="profile.city"
                type="text"
                placeholder="City"
                required
              />

            </div>


            <!-- PROVINCE -->

            <div class="form-group">

              <label>
                PROVINCE
              </label>

              <input
                v-model="profile.province"
                type="text"
                placeholder="Province"
                required
              />

            </div>


            <!-- POSTAL CODE -->

            <div class="form-group">

              <label>
                POSTAL CODE
              </label>

              <input
                v-model="profile.postalCode"
                type="text"
                placeholder="Postal code"
                required
              />

            </div>

          </div>

        </section>


        <!-- =====================================
             ACTION
        ====================================== -->

        <section class="form-actions">

          <button
            type="button"
            class="cancel-button"
            @click="cancelEdit"
          >
            CANCEL
          </button>


          <button
            type="submit"
            class="save-button"
            :disabled="isSaving"
          >

            <span v-if="!isSaving">
              SAVE CHANGES
            </span>

            <span v-else>
              SAVING...
            </span>

          </button>

        </section>

      </form>

    </main>


    <!-- =====================================
         FOOTER
    ====================================== -->

    <footer class="footer">

      <div class="footer-brand">
        PROVIDENTIAL
      </div>

      <div class="footer-tagline">
        SIMPLE. CONSCIOUS. TIMELESS.
      </div>

      <div class="footer-copy">
        © 2026 PROVIDENTIAL
      </div>

    </footer>

  </div>

</template>


<style scoped>

/* =========================================
   GENERAL
========================================= */

.edit-profile-page {
  min-height: 100vh;

  background: #fff;

  color: #111;

  font-family:
    'Inter',
    Arial,
    sans-serif;
}


/* =========================================
   NAVBAR
========================================= */

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

  background: rgba(255,255,255,0.97);

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

  letter-spacing: 1.7px;

  transition: opacity 0.3s ease;
}

.navbar a:hover {
  opacity: 0.5;
}

.logo {
  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 21px !important;

  letter-spacing: 3px !important;

  font-weight: 600;
}

.navbar .active {
  border-bottom: 1px solid #111;

  padding-bottom: 6px;
}


/* =========================================
   PAGE HEADER
========================================= */

.page-header {
  padding: 100px 8% 80px;

  border-bottom: 1px solid #111;
}

.page-number {
  margin-bottom: 25px;

  font-size: 9px;

  letter-spacing: 2.5px;

  font-weight: 600;
}

.page-header h1 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: clamp(60px, 9vw, 120px);

  line-height: 0.9;

  font-weight: 400;

  letter-spacing: -4px;
}

.page-header h1 em {
  font-style: italic;
}

.page-header p {
  max-width: 420px;

  margin: 35px 0 0;

  color: #777;

  font-size: 13px;

  line-height: 1.7;
}


/* =========================================
   CONTAINER
========================================= */

.edit-container {
  max-width: 1100px;

  margin: 0 auto;

  padding: 60px 8% 100px;
}


/* =========================================
   BACK
========================================= */

.back-section {
  margin-bottom: 50px;
}

.back-button {
  padding: 0;

  border: none;

  background: transparent;

  color: #555;

  font-size: 9px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: color 0.3s ease;
}

.back-button:hover {
  color: #111;
}


/* =========================================
   FORM SECTION
========================================= */

.form-section {
  padding: 55px 0;

  border-top: 1px solid #111;
}

.section-heading {
  display: grid;

  grid-template-columns: 50px 1fr;

  gap: 20px;

  margin-bottom: 40px;
}

.section-number {
  font-size: 9px;

  letter-spacing: 2px;

  color: #999;
}

.section-heading h2 {
  margin: 0 0 8px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 32px;

  font-weight: 400;
}

.section-heading p {
  margin: 0;

  color: #888;

  font-size: 11px;
}


/* =========================================
   PROFILE PHOTO
========================================= */

.profile-photo {
  display: flex;

  align-items: center;

  gap: 25px;

  padding-left: 70px;
}

.avatar {
  width: 90px;

  height: 90px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  background: #111;

  color: #fff;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 35px;
}

.photo-info h3 {
  margin: 0 0 7px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 22px;

  font-weight: 400;
}

.photo-info p {
  margin: 0 0 15px;

  color: #888;

  font-size: 8px;

  letter-spacing: 1.5px;
}

.change-photo {
  padding: 0;

  border: none;

  border-bottom: 1px solid #111;

  background: transparent;

  color: #111;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;
}


/* =========================================
   FORM GRID
========================================= */

.form-grid {
  display: grid;

  grid-template-columns: repeat(2, 1fr);

  gap: 35px 30px;

  padding-left: 70px;
}

.form-group {
  display: flex;

  flex-direction: column;

  gap: 10px;
}

.form-group.full {
  grid-column: 1 / -1;
}

.form-group label {
  font-size: 8px;

  letter-spacing: 1.8px;

  color: #777;

  font-weight: 600;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;

  box-sizing: border-box;

  padding: 14px 0;

  border: none;

  border-bottom: 1px solid #ccc;

  outline: none;

  background: transparent;

  color: #111;

  font-family: inherit;

  font-size: 13px;

  border-radius: 0;

  transition:
    border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-bottom-color: #111;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
  color: #aaa;
}

.form-group textarea {
  resize: vertical;

  line-height: 1.6;
}


/* =========================================
   ACTIONS
========================================= */

.form-actions {
  display: flex;

  justify-content: flex-end;

  gap: 10px;

  padding: 35px 0 0 70px;

  border-top: 1px solid #111;
}

.cancel-button,
.save-button {
  min-width: 150px;

  padding: 15px 20px;

  border: 1px solid #111;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.cancel-button {
  background: #fff;

  color: #111;
}

.cancel-button:hover {
  background: #111;

  color: #fff;
}

.save-button {
  background: #111;

  color: #fff;
}

.save-button:hover {
  background: #fff;

  color: #111;
}

.save-button:disabled {
  opacity: 0.5;

  cursor: not-allowed;
}


/* =========================================
   FOOTER
========================================= */

.footer {
  min-height: 170px;

  padding: 50px 8% 35px;

  border-top: 1px solid #111;

  display: grid;

  grid-template-columns: 1fr 1fr 1fr;

  align-items: end;
}

.footer-brand {
  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 22px;

  letter-spacing: 3px;
}

.footer-tagline {
  text-align: center;

  font-size: 8px;

  letter-spacing: 2px;

  color: #777;
}

.footer-copy {
  text-align: right;

  font-size: 8px;

  letter-spacing: 1px;

  color: #999;
}


/* =========================================
   TABLET
========================================= */

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

  .profile-photo,
  .form-grid,
  .form-actions {
    padding-left: 0;
  }

}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 600px) {

  .navbar {
    height: 65px;

    padding: 0 20px;
  }

  .logo {
    font-size: 16px !important;

    letter-spacing: 2px !important;
  }

  .nav-right {
    gap: 12px;
  }

  .nav-right a:first-child {
    display: none;
  }

  .navbar a {
    font-size: 8px;
  }


  .page-header {
    padding: 70px 25px 55px;
  }

  .page-header h1 {
    font-size: 65px;

    letter-spacing: -3px;
  }


  .edit-container {
    padding: 45px 25px 70px;
  }


  .form-section {
    padding: 45px 0;
  }


  .section-heading {
    grid-template-columns: 35px 1fr;

    gap: 10px;
  }


  .section-heading h2 {
    font-size: 27px;
  }


  .profile-photo {
    align-items: flex-start;
  }


  .avatar {
    width: 70px;

    height: 70px;

    font-size: 28px;
  }


  .photo-info h3 {
    font-size: 19px;
  }


  .form-grid {
    grid-template-columns: 1fr;

    gap: 28px;
  }


  .form-group.full {
    grid-column: auto;
  }


  .form-actions {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 8px;
  }


  .cancel-button,
  .save-button {
    min-width: 0;

    width: 100%;
  }


  .footer {
    display: flex;

    flex-direction: column;

    align-items: flex-start;

    gap: 25px;
  }


  .footer-tagline {
    text-align: left;
  }


  .footer-copy {
    text-align: left;
  }

}

</style>