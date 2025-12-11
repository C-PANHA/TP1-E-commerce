<template>
  <header class="app-header">
    <!-- Top Header Bar -->
    <div class="header-top">
      <div class="header-container">
        <!-- Logo -->
        <div class="logo-section">
          <img src="/src/assets/images/categories/image1.png" alt="Melon" class="logo" />
          <span class="brand-name">Melon</span>
          <p class="brand-tagline">MART & GROCERY</p>
        </div>

        <!-- Search Bar -->
        <div class="search-section">
          <select class="category-select">
            <option>All Categories</option>
            <option>Milk & Dairies</option>
            <option>Coffee & Teas</option>
            <option>Pet Food</option>
            <option>Meats</option>
            <option>Vegetables</option>
            <option>Fruits</option>
          </select>
          <input
            type="text"
            class="search-input"
            placeholder="Search for items..."
            @keyup.enter="handleSearch"
            v-model="searchQuery"
          />
          <button class="search-btn" @click="handleSearch">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.35-4.35"></path>
            </svg>
          </button>
        </div>

        <!-- Right Actions -->
        <div class="header-actions">
          <div class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Account</span>
          </div>
          <div class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M9 4H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4"></path>
              <path d="M15 4h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
              <line x1="9" y1="9" x2="15" y2="9"></line>
              <line x1="9" y1="13" x2="15" y2="13"></line>
              <line x1="9" y1="17" x2="15" y2="17"></line>
            </svg>
            <span>Compare</span>
          </div>
          <div class="action-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path
                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
              ></path>
            </svg>
            <span>Wishlist</span>
          </div>
          <div class="action-item cart-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path
                d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"
              ></path>
            </svg>
            <span>Cart</span>
            <span class="cart-count">0</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Support Line -->
    <div class="support-line">
      <div class="support-info">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path
            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
          ></path>
        </svg>
        <div class="support-text">
          <span class="support-label">24/7 Support Center</span>
          <span class="support-number">099 777 888</span>
        </div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="navbar">
      <div class="nav-container">
        <button class="browse-btn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="8" y1="6" x2="21" y2="6"></line>
            <line x1="8" y1="12" x2="21" y2="12"></line>
            <line x1="8" y1="18" x2="21" y2="18"></line>
            <line x1="3" y1="6" x2="3.01" y2="6"></line>
            <line x1="3" y1="12" x2="3.01" y2="12"></line>
            <line x1="3" y1="18" x2="3.01" y2="18"></line>
          </svg>
          Browse All Categories
        </button>

        <!-- Menu Items -->
        <ul class="nav-menu">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
              </svg>
              Home
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link">Food</a>
            <div class="dropdown-menu">
              <a href="#">Coffee & Teas</a>
              <a href="#">Biscuits</a>
              <a href="#">Snacks</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link">Vegetables</a>
            <div class="dropdown-menu">
              <a href="#">Fresh Vegetables</a>
              <a href="#">Organic</a>
              <a href="#">Frozen</a>
            </div>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Drink</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Cookies</a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link">Meat & Seafood</a>
            <div class="dropdown-menu">
              <a href="#">Fresh Meat</a>
              <a href="#">Seafood</a>
              <a href="#">Processed Meat</a>
            </div>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Bakery</a>
          </li>
        </ul>

        <!-- Hot Deals Badge -->
        <div class="hot-deals">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
          </svg>
          Hot Deals
        </div>
      </div>
    </nav>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
      <div class="newsletter-container">
        <div class="newsletter-left">
          <div class="newsletter-content">
            <h3>Don't miss amazing grocery deals</h3>
            <p>Sign up for the daily newsletter</p>
          </div>
          <div class="newsletter-form">
            <div class="email-input-group">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
              <input
                type="email"
                placeholder="Your email address"
                v-model="email"
                @keyup.enter="subscribeNewsletter"
              />
            </div>
            <button class="subscribe-btn" @click="subscribeNewsletter">Subscribe</button>
          </div>
        </div>
        <div class="newsletter-right">
          <img src="/src/assets/images/categories/image7.png" alt="Fresh groceries in mesh bag" class="hero-image" />
        </div>
      </div>
    </section>
  </header>
</template>

<script>
export default {
  name: 'HeaderComponent',
  data() {
    return {
      searchQuery: '',
      email: '',
    }
  },
  methods: {
    handleSearch() {
      if (this.searchQuery.trim()) {
        console.log('Searching for:', this.searchQuery)
        this.$emit('search', this.searchQuery)
      }
    },
    subscribeNewsletter() {
      if (this.email.trim()) {
        console.log('Newsletter subscription:', this.email)
        this.$emit('subscribe', this.email)
        this.email = ''
      }
    },
  },
}
</script>

<style scoped>
.app-header {
  background: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px;
}

/* Top Header */
.header-top {
  border-bottom: 1px solid #f1f1f1;
  padding: 20px 0;
}

.header-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
}

/* Logo Section */
.logo-section {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 180px;
}

.logo {
  width: 45px;
  height: 45px;
  object-fit: contain;
}

.brand-name {
  font-size: 28px;
  font-weight: 800;
  color: #3bb77e;
  margin: 0;
  line-height: 1;
}

.brand-tagline {
  font-size: 11px;
  color: #7e7e7e;
  margin: 0;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Search Section */
.search-section {
  display: flex;
  flex: 1;
  gap: 0;
  background: #f3f4f6;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.category-select {
  padding: 12px 15px;
  border: none;
  background: white;
  color: #253d4e;
  font-size: 14px;
  cursor: pointer;
  border-right: 1px solid #e5e7eb;
  outline: none;
  min-width: 140px;
  font-weight: 500;
}

.search-input {
  flex: 1;
  border: none;
  padding: 12px 15px;
  background: transparent;
  font-size: 14px;
  color: #253d4e;
  outline: none;
}

.search-input::placeholder {
  color: #aaa;
}

.search-btn {
  padding: 12px 20px;
  background: transparent;
  border: none;
  color: #7e7e7e;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.search-btn:hover {
  color: #3bb77e;
}

/* Header Actions */
.header-actions {
  display: flex;
  gap: 30px;
  align-items: center;
}

.action-item {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  color: #253d4e;
  font-weight: 500;
  font-size: 14px;
  transition: all 0.3s ease;
  position: relative;
}

.action-item:hover {
  color: #3bb77e;
}

.action-item svg {
  transition: all 0.3s ease;
}

.action-item:hover svg {
  transform: scale(1.1);
}

.cart-item {
  gap: 5px;
}

.cart-count {
  background: #3bb77e;
  color: white;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 600;
  margin-left: 5px;
}

/* Support Line */
.support-line {
  background: #f8f9fa;
  padding: 15px 0;
  border-bottom: 1px solid #f1f1f1;
}

.support-info {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 30px;
  display: flex;
  align-items: center;
  gap: 15px;
  justify-content: flex-end;
}

.support-text {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.support-label {
  font-size: 13px;
  color: #7e7e7e;
  font-weight: 500;
}

.support-number {
  font-size: 18px;
  font-weight: 700;
  color: #3bb77e;
}

/* Navigation Bar */
.navbar {
  background: white;
  border-bottom: 1px solid #f1f1f1;
  padding: 0;
}

.nav-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 30px;
  display: flex;
  align-items: center;
  gap: 0;
}

.browse-btn {
  background: #3bb77e;
  color: white;
  border: none;
  padding: 15px 20px;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.3s ease;
  border-radius: 0;
  white-space: nowrap;
  min-width: 220px;
  justify-content: center;
}

.browse-btn:hover {
  background: #2e8b57;
}

/* Navigation Menu */
.nav-menu {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex: 1;
  align-items: center;
  gap: 0;
}

.nav-item {
  position: relative;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 15px 18px;
  text-decoration: none;
  color: #253d4e;
  font-weight: 500;
  font-size: 14px;
  transition: all 0.3s ease;
  border-bottom: 3px solid transparent;
}

.nav-link:hover {
  color: #3bb77e;
  border-bottom-color: #3bb77e;
}

.nav-link svg {
  transition: all 0.3s ease;
}

.nav-link:hover svg {
  fill: #3bb77e;
}

/* Dropdown Menu */
.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  background: white;
  min-width: 200px;
  border-radius: 8px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.3s ease;
  z-index: 1000;
  overflow: hidden;
  margin-top: 5px;
}

.dropdown:hover .dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.dropdown-menu a {
  display: block;
  padding: 12px 20px;
  color: #253d4e;
  text-decoration: none;
  font-size: 14px;
  transition: all 0.3s ease;
  border-left: 3px solid transparent;
}

.dropdown-menu a:hover {
  background: #f8f9fa;
  color: #3bb77e;
  border-left-color: #3bb77e;
  padding-left: 25px;
}

/* Hot Deals */
.hot-deals {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 15px 20px;
  background: #ffd700;
  color: #253d4e;
  font-weight: 600;
  font-size: 14px;
  border-radius: 0;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
  margin-left: auto;
}

.hot-deals:hover {
  background: #ffed4e;
}

/* Newsletter Section */
.newsletter-section {
  background: linear-gradient(135deg, #fff8e7 0%, #ffe8d1 100%);
  padding: 40px 30px;
  border-top: 1px solid #f1f1f1;
}

.newsletter-container {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 40px;
}

.newsletter-left {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.newsletter-right {
  flex: 0.8;
  display: flex;
  justify-content: center;
  align-items: center;
}

.hero-image {
  max-width: 100%;
  height: auto;
  object-fit: contain;
  max-height: 350px;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.newsletter-content {
  flex: 1;
}

.newsletter-content h3 {
  font-size: 28px;
  font-weight: 700;
  color: #253d4e;
  margin: 0 0 10px 0;
  line-height: 1.3;
}

.newsletter-content p {
  font-size: 16px;
  color: #7e7e7e;
  margin: 0;
}

/* Newsletter Form */
.newsletter-form {
  display: flex;
  gap: 15px;
  align-items: center;
  flex: 1;
}

.email-input-group {
  display: flex;
  align-items: center;
  gap: 10px;
  flex: 1;
  background: white;
  padding: 12px 15px;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.email-input-group svg {
  color: #aaa;
  min-width: 18px;
}

.email-input-group input {
  flex: 1;
  border: none;
  outline: none;
  font-size: 14px;
  color: #253d4e;
}

.email-input-group input::placeholder {
  color: #aaa;
}

.subscribe-btn {
  background: #3bb77e;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.subscribe-btn:hover {
  background: #2e8b57;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59, 183, 126, 0.3);
}

/* Responsive Design */
@media (max-width: 1200px) {
  .header-container {
    padding: 0 20px;
    gap: 15px;
  }

  .search-section {
    flex: 0.8;
  }

  .category-select {
    min-width: 120px;
  }

  .header-actions {
    gap: 20px;
  }

  .action-item span {
    display: none;
  }

  .action-item {
    gap: 0;
  }

  .cart-count {
    margin-left: 0;
  }

  .support-info {
    padding: 0 20px;
  }

  .nav-container {
    padding: 0 20px;
  }

  .browse-btn {
    min-width: 180px;
    padding: 12px 15px;
  }

  .nav-link {
    padding: 12px 12px;
    font-size: 13px;
  }

  .hot-deals {
    padding: 12px 15px;
  }

  .newsletter-container {
    gap: 20px;
    padding: 0 20px;
  }
}

@media (max-width: 768px) {
  .header-top {
    padding: 15px 0;
  }

  .header-container {
    flex-wrap: wrap;
    padding: 0 15px;
  }

  .logo-section {
    min-width: auto;
    flex-basis: 100%;
    margin-bottom: 10px;
  }

  .search-section {
    flex: 1;
    flex-basis: 100%;
    order: 3;
  }

  .header-actions {
    flex-basis: 100%;
    order: 4;
    gap: 15px;
    margin-top: 10px;
  }

  .category-select {
    display: none;
  }

  .search-section {
    flex-basis: 100%;
  }

  .browse-btn {
    display: none;
  }

  .nav-menu {
    flex-wrap: wrap;
    gap: 0;
  }

  .nav-link {
    padding: 12px 10px;
    font-size: 12px;
  }

  .hot-deals {
    margin-left: 0;
  }

  .newsletter-container {
    flex-direction: column;
    gap: 15px;
    align-items: stretch;
  }

  .newsletter-left {
    order: 2;
  }

  .newsletter-right {
    order: 1;
    flex: 1;
    max-width: 100%;
  }

  .hero-image {
    max-height: 250px;
  }

  .newsletter-form {
    flex-direction: column;
  }

  .email-input-group {
    width: 100%;
  }

  .subscribe-btn {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .header-container {
    padding: 0 10px;
  }

  .logo {
    width: 35px;
    height: 35px;
  }

  .brand-name {
    font-size: 22px;
  }

  .brand-tagline {
    font-size: 9px;
  }

  .search-input {
    padding: 10px 10px;
  }

  .search-btn {
    padding: 10px 12px;
  }

  .header-actions {
    gap: 10px;
  }

  .action-item svg {
    width: 18px;
    height: 18px;
  }

  .nav-link {
    padding: 10px 8px;
    font-size: 11px;
  }

  .nav-link svg {
    width: 14px;
    height: 14px;
  }

  .newsletter-content h3 {
    font-size: 20px;
  }

  .newsletter-content p {
    font-size: 14px;
  }
}
</style>
