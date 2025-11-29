import { defineStore } from 'pinia'
import axios from 'axios'

export const useProductStore = defineStore('product', {
  state: () => ({
    groups: [
      {
        id: 1,
        name: 'Milk & Dairies',
        description: 'Fresh milk, cheese, yogurt and dairy products',
        image: '/src/assets/images/categories/image1.png',
        isActive: true,
      },
      {
        id: 2,
        name: 'Coffee & Teas',
        description: 'Premium coffee beans, teas and beverages',
        image: '/src/assets/images/categories/image2.png',
        isActive: true,
      },
      {
        id: 3,
        name: 'Pet Food',
        description: 'Nutritious food and treats for pets',
        image: '/src/assets/images/categories/image3.png',
        isActive: true,
      },
      {
        id: 4,
        name: 'Meats',
        description: 'Fresh and processed meat products',
        image: '/src/assets/images/categories/image4.png',
        isActive: true,
      },
      {
        id: 5,
        name: 'Vegetables',
        description: 'Fresh organic and conventional vegetables',
        image: '/src/assets/images/categories/image7.png',
        isActive: true,
      },
      {
        id: 6,
        name: 'Fruits',
        description: 'Fresh seasonal and exotic fruits',
        image: '/src/assets/images/categories/image10.png',
        isActive: true,
      },
    ],

    categories: [
      // Milk & Dairies categories
      {
        id: 101,
        groupId: 1,
        name: 'Fresh Milk',
        description: 'Whole milk, skim milk, and flavored milk',
        image: '/src/assets/images/fresh-milk-category.jpg',
        isActive: true,
      },
      {
        id: 102,
        groupId: 1,
        name: 'Cheese',
        description: 'Artisan and processed cheese varieties',
        image: '/src/assets/images/cheese-category.jpg',
        isActive: true,
      },
      {
        id: 103,
        groupId: 1,
        name: 'Yogurt',
        description: 'Greek yogurt, regular yogurt, and drinks',
        image: '/src/assets/images/yogurt-category.jpg',
        isActive: true,
      },

      // Coffee & Teas categories
      {
        id: 104,
        groupId: 2,
        name: 'Coffee Beans',
        description: 'Premium coffee beans and grounds',
        image: '/src/assets/images/coffee-beans-category.jpg',
        isActive: true,
      },
      {
        id: 105,
        groupId: 2,
        name: 'Tea Varieties',
        description: 'Black, green, herbal and specialty teas',
        image: '/src/assets/images/tea-varieties-category.jpg',
        isActive: true,
      },
      {
        id: 107,
        groupId: 2,
        name: 'Instant Drinks',
        description: 'Instant coffee, tea mixes and beverages',
        image: '/src/assets/images/instant-drinks-category.jpg',
        isActive: true,
      },

      // Pet Food categories
      {
        id: 106,
        groupId: 3,
        name: 'Dog Food',
        description: 'Dry and wet food for dogs',
        image: '/src/assets/images/dog-food-category.jpg',
        isActive: true,
      },
      {
        id: 108,
        groupId: 3,
        name: 'Cat Food',
        description: 'Nutritious food for cats',
        image: '/src/assets/images/cat-food-category.jpg',
        isActive: true,
      },

      // Meats categories
      {
        id: 9,
        groupId: 4,
        name: 'Fresh Poultry',
        description: 'Chicken, turkey and other poultry',
        image: '/src/assets/images/poultry-category.jpg',
        isActive: true,
      },
      {
        id: 10,
        groupId: 4,
        name: 'Beef & Pork',
        description: 'Fresh cuts of beef and pork',
        image: '/src/assets/images/beef-pork-category.jpg',
        isActive: true,
      },

      // Vegetables categories
      {
        id: 11,
        groupId: 5,
        name: 'Leafy Greens',
        description: 'Spinach, lettuce, kale and herbs',
        image: '/src/assets/images/leafy-greens-category.jpg',
        isActive: true,
      },
      {
        id: 12,
        groupId: 5,
        name: 'Root Vegetables',
        description: 'Carrots, potatoes, onions and turnips',
        image: '/src/assets/images/root-vegetables-category.jpg',
        isActive: true,
      },

      // Fruits categories
      {
        id: 13,
        groupId: 6,
        name: 'Citrus Fruits',
        description: 'Oranges, lemons, limes and grapefruits',
        image: '/src/assets/images/citrus-fruits-category.jpg',
        isActive: true,
      },
      {
        id: 14,
        groupId: 6,
        name: 'Tropical Fruits',
        description: 'Bananas, pineapples, mangoes and exotic fruits',
        image: '/src/assets/images/tropical-fruits-category.jpg',
        isActive: true,
      },
    ],

    promotions: [
      {
        id: 1001,
        title: 'Fresh Dairy Sale',
        description: 'Up to 30% off on milk and dairy products',
        discountType: 'percentage', // 'percentage' or 'fixed'
        discountValue: 30,
        startDate: '2025-11-15T00:00:00Z',
        endDate: '2025-11-25T23:59:59Z',
        isActive: true,
        image: '/src/assets/images/dairy-sale-promo.jpg',
        applicableCategories: [101, 102, 103], // fresh milk, cheese, yogurt
        minimumPurchase: 25,
      },
      {
        id: 1002,
        title: 'Free Shipping Weekend',
        description: 'Free shipping on all orders over $30',
        discountType: 'free_shipping',
        discountValue: 0,
        startDate: '2025-11-15T00:00:00Z',
        endDate: '2025-11-17T23:59:59Z',
        isActive: true,
        image: '/src/assets/images/free-shipping-promo.jpg',
        applicableCategories: [], // applies to all
        minimumPurchase: 30,
      },
      {
        id: 3,
        title: 'Premium Coffee & Tea',
        description: '25% off on all coffee and tea products',
        discountType: 'percentage',
        discountValue: 25,
        startDate: '2025-11-20T00:00:00Z',
        endDate: '2025-12-01T23:59:59Z',
        isActive: true,
        image: '/src/assets/images/coffee-tea-promo.jpg',
        applicableCategories: [4, 5, 6], // coffee beans, tea varieties, instant drinks
        minimumPurchase: 0,
      },
      {
        id: 4,
        title: 'Fresh Produce Sale',
        description: '$5 off orders over $40',
        discountType: 'fixed',
        discountValue: 5,
        startDate: '2025-11-20T12:00:00Z',
        endDate: '2025-11-22T18:00:00Z',
        isActive: true,
        image: '/src/assets/images/produce-sale-promo.jpg',
        applicableCategories: [11, 12, 13, 14], // vegetables and fruits
        minimumPurchase: 40,
      },
    ],

    products: [
      // Fresh Milk Products (Category 101)
      {
        id: 2001,
        name: 'Organic Whole Milk',
        description: 'Fresh organic whole milk from grass-fed cows',
        categoryId: 101,
        price: 4.99,
        originalPrice: 5.49,
        stock: 120,
        sku: 'MILK-ORG-WHOLE-1GAL',
        images: ['/src/assets/images/products/product1.jpg'],
        isActive: true,
        isFeatured: true,
        rating: 4.8,
        reviewCount: 156,
        countSold: 45,
        tags: ['milk', 'organic', 'whole', 'dairy'],
        specifications: {
          volume: '1 Gallon',
          fat: '3.25%',
          source: 'Grass-fed cows',
          expiry: '7 days',
          organic: true,
        },
        createdAt: '2025-10-01T00:00:00Z',
      },
      {
        id: 2002,
        name: 'Almond Milk Unsweetened',
        description: 'Plant-based almond milk with no added sugar',
        categoryId: 101,
        price: 3.49,
        originalPrice: 3.99,
        stock: 85,
        sku: 'MILK-ALMOND-UNSW-32OZ',
        images: ['/src/assets/images/products/product2.png'],
        isActive: true,
        isFeatured: false,
        rating: 4.5,
        reviewCount: 98,
        countSold: 8,
        tags: ['milk', 'almond', 'plant-based', 'unsweetened'],
        specifications: {
          volume: '32 fl oz',
          calories: '30 per cup',
          source: 'Almonds',
          expiry: '7-10 days',
          organic: false,
        },
        createdAt: '2025-09-15T00:00:00Z',
      },

      // Cheese Products (Category 102)
      {
        id: 2003,
        name: 'Aged Cheddar Cheese',
        description: 'Sharp aged cheddar cheese, perfect for snacking',
        categoryId: 102,
        price: 8.99,
        originalPrice: 9.99,
        stock: 65,
        sku: 'CHEESE-CHEDDAR-AGED-8OZ',
        images: ['/src/assets/images/products/product3.png'],
        isActive: true,
        isFeatured: true,
        rating: 4.7,
        reviewCount: 134,
        countSold: 23,
        tags: ['cheese', 'cheddar', 'aged', 'sharp'],
        specifications: {
          weight: '8 oz',
          age: '2 years',
          texture: 'Hard',
          fat: '33%',
          origin: 'Vermont',
        },
        createdAt: '2025-08-20T00:00:00Z',
      },

      // Yogurt Products (Category 103)
      {
        id: 2004,
        name: 'Greek Yogurt Vanilla',
        description: 'Creamy Greek yogurt with natural vanilla flavor',
        categoryId: 103,
        price: 5.99,
        originalPrice: 6.49,
        stock: 90,
        sku: 'YOGURT-GREEK-VANILLA-32OZ',
        images: ['/src/assets/images/product4.png'],
        isActive: true,
        isFeatured: false,
        rating: 4.6,
        reviewCount: 87,
        countSold: 15,
        tags: ['yogurt', 'greek', 'vanilla', 'protein'],
        specifications: {
          size: '32 oz',
          protein: '15g per serving',
          flavor: 'Vanilla',
          fat: '0%',
          culture: 'Live & active',
        },
        createdAt: '2025-07-10T00:00:00Z',
      },

      // Coffee Beans (Category 4)
      {
        id: 5,
        name: 'Ethiopian Single Origin Coffee',
        description: 'Premium single origin coffee beans from Ethiopia',
        categoryId: 4,
        price: 16.99,
        originalPrice: 19.99,
        stock: 45,
        sku: 'COFFEE-ETHIOPIAN-12OZ',
        images: [
          '/src/assets/images/ethiopian-coffee-1.jpg',
          '/src/assets/images/ethiopian-coffee-2.jpg',
        ],
        isActive: true,
        isFeatured: true,
        rating: 4.9,
        reviewCount: 203,
        countSold: 67,
        tags: ['coffee', 'ethiopian', 'single-origin', 'premium'],
        specifications: {
          weight: '12 oz',
          roast: 'Medium',
          origin: 'Ethiopia',
          notes: 'Floral, citrus',
          grind: 'Whole bean',
        },
        createdAt: '2025-06-05T00:00:00Z',
      },

      // Tea Varieties (Category 5)
      {
        id: 6,
        name: 'Earl Grey Black Tea',
        description: 'Classic Earl Grey tea with bergamot oil',
        categoryId: 5,
        price: 12.99,
        originalPrice: 14.99,
        stock: 75,
        sku: 'TEA-EARL-GREY-50BAG',
        images: ['/src/assets/images/earl-grey-1.jpg', '/src/assets/images/earl-grey-2.jpg'],
        isActive: true,
        isFeatured: false,
        rating: 4.4,
        reviewCount: 92,
        countSold: 12,
        tags: ['tea', 'earl-grey', 'black-tea', 'bergamot'],
        specifications: {
          quantity: '50 tea bags',
          type: 'Black tea',
          flavor: 'Bergamot',
          caffeine: 'Medium',
          origin: 'Sri Lanka',
        },
        createdAt: '2025-05-15T00:00:00Z',
      },

      // Dog Food (Category 7)
      {
        id: 7,
        name: 'Premium Dry Dog Food',
        description: 'High-quality dry dog food for adult dogs',
        categoryId: 7,
        price: 24.99,
        originalPrice: 27.99,
        stock: 55,
        sku: 'DOG-FOOD-ADULT-15LB',
        images: ['/src/assets/images/product8.png'],
        isActive: true,
        isFeatured: true,
        rating: 4.6,
        reviewCount: 167,
        countSold: 34,
        tags: ['dog-food', 'premium', 'adult', 'dry'],
        specifications: {
          weight: '15 lbs',
          age: 'Adult',
          protein: '26%',
          ingredients: 'Chicken, rice, vegetables',
          grain: 'Grain-free',
        },
        createdAt: '2025-04-20T00:00:00Z',
      },

      // Fresh Poultry (Category 9)
      {
        id: 8,
        name: 'Organic Chicken Breast',
        description: 'Fresh organic chicken breast, boneless and skinless',
        categoryId: 9,
        price: 12.99,
        originalPrice: 14.99,
        stock: 35,
        sku: 'CHICKEN-BREAST-ORG-2LB',
        images: [
          '/src/assets/images/chicken-breast-1.jpg',
          '/src/assets/images/chicken-breast-2.jpg',
        ],
        isActive: true,
        isFeatured: false,
        rating: 4.7,
        reviewCount: 89,
        countSold: 18,
        tags: ['chicken', 'organic', 'fresh', 'protein'],
        specifications: {
          weight: '2 lbs',
          cut: 'Boneless, skinless',
          organic: true,
          source: 'Free-range',
          freshness: '2-3 days',
        },
        createdAt: '2025-03-10T00:00:00Z',
      },

      // Leafy Greens (Category 11)
      {
        id: 9,
        name: 'Organic Baby Spinach',
        description: 'Fresh organic baby spinach leaves',
        categoryId: 11,
        price: 4.49,
        originalPrice: 4.99,
        stock: 80,
        sku: 'SPINACH-BABY-ORG-5OZ',
        images: ['/src/assets/images/baby-spinach-1.jpg', '/src/assets/images/baby-spinach-2.jpg'],
        isActive: true,
        isFeatured: true,
        rating: 4.5,
        reviewCount: 76,
        countSold: 29,
        tags: ['spinach', 'organic', 'leafy-greens', 'fresh'],
        specifications: {
          weight: '5 oz',
          type: 'Baby spinach',
          organic: true,
          origin: 'Local farm',
          freshness: '3-5 days',
        },
        createdAt: '2025-02-15T00:00:00Z',
      },

      // Citrus Fruits (Category 13)
      {
        id: 10,
        name: 'Organic Navel Oranges',
        description: 'Sweet and juicy organic navel oranges',
        categoryId: 13,
        price: 6.99,
        originalPrice: 7.99,
        stock: 100,
        sku: 'ORANGES-NAVEL-ORG-3LB',
        images: [
          '/src/assets/images/navel-oranges-1.jpg',
          '/src/assets/images/navel-oranges-2.jpg',
        ],
        isActive: true,
        isFeatured: true,
        rating: 4.8,
        reviewCount: 145,
        countSold: 52,
        tags: ['oranges', 'citrus', 'organic', 'sweet'],
        specifications: {
          weight: '3 lbs',
          variety: 'Navel',
          organic: true,
          origin: 'California',
          season: 'Winter',
        },
        createdAt: '2025-01-20T00:00:00Z',
      },

      // Root Vegetables (Category 12)
      {
        id: 11,
        name: 'Organic Carrots',
        description: 'Fresh organic carrots, perfect for cooking',
        categoryId: 12,
        price: 3.49,
        originalPrice: 3.99,
        stock: 95,
        sku: 'CARROTS-ORG-2LB',
        images: ['/src/assets/images/carrots-1.jpg', '/src/assets/images/carrots-2.jpg'],
        isActive: true,
        isFeatured: false,
        rating: 4.4,
        reviewCount: 67,
        countSold: 6,
        tags: ['carrots', 'organic', 'root-vegetables', 'fresh'],
        specifications: {
          weight: '2 lbs',
          type: 'Medium size',
          organic: true,
          origin: 'Local farm',
          freshness: '7-10 days',
        },
        createdAt: '2025-01-15T00:00:00Z',
      },

      // Tropical Fruits (Category 14)
      {
        id: 12,
        name: 'Fresh Bananas',
        description: 'Ripe yellow bananas, naturally sweet',
        categoryId: 14,
        price: 2.99,
        originalPrice: 3.29,
        stock: 150,
        sku: 'BANANAS-FRESH-3LB',
        images: ['/src/assets/images/bananas-1.jpg', '/src/assets/images/bananas-2.jpg'],
        isActive: true,
        isFeatured: false,
        rating: 4.6,
        reviewCount: 98,
        countSold: 87,
        tags: ['bananas', 'tropical', 'fresh', 'sweet'],
        specifications: {
          weight: '3 lbs (approx 6-8 bananas)',
          ripeness: 'Yellow, ready to eat',
          organic: false,
          origin: 'Ecuador',
          potassium: 'High',
        },
        createdAt: '2025-01-10T00:00:00Z',
      },
    ],

    // Loading states
    loading: {
      groups: false,
      categories: false,
      promotions: false,
      products: false,
    },

    // Error states
    errors: {
      groups: null,
      categories: null,
      promotions: null,
      products: null,
    },
  }),

  getters: {
    // Get active groups
    activeGroups: (state) => state.groups.filter((group) => group.isActive),

    // Get active categories
    activeCategories: (state) => state.categories.filter((category) => category.isActive),

    // Get categories by group name
    getCategoriesByGroup: (state) => (groupName) => {
      const group = state.groups.find((g) => g.name === groupName && g.isActive)
      if (!group) return []
      return state.categories.filter(
        (category) => category.groupId === group.id && category.isActive,
      )
    },

    // Get active promotions
    activePromotions: (state) => {
      const now = new Date()
      return state.promotions.filter((promotion) => {
        const startDate = new Date(promotion.startDate)
        const endDate = new Date(promotion.endDate)
        return promotion.isActive && now >= startDate && now <= endDate
      })
    },

    // Get active products
    activeProducts: (state) =>
      state.products.filter((product) => product.isActive && product.stock > 0),

    // Get featured products
    featuredProducts: (state) =>
      state.products.filter(
        (product) => product.isFeatured && product.isActive && product.stock > 0,
      ),

    // Get products by category
    getProductsByCategory: (state) => (categoryId) => {
      return state.products.filter(
        (product) => product.categoryId === categoryId && product.isActive && product.stock > 0,
      )
    },

    // Get products by group name
    getProductsByGroup: (state) => (groupName) => {
      const group = state.groups.find((g) => g.name === groupName && g.isActive)
      if (!group) return []
      const groupCategories = state.categories.filter(
        (cat) => cat.groupId === group.id && cat.isActive,
      )
      const categoryIds = groupCategories.map((cat) => cat.id)
      return state.products.filter(
        (product) =>
          categoryIds.includes(product.categoryId) && product.isActive && product.stock > 0,
      )
    },

    // Get popular products (countSold > 10)
    getPopularProducts: (state) => {
      return state.products.filter(
        (product) => product.countSold > 10 && product.isActive && product.stock > 0,
      )
    },

    // Get product by ID
    getProductById: (state) => (productId) => {
      return state.products.find((product) => product.id === productId)
    },

    // Get products on sale (with discounted price)
    productsOnSale: (state) => {
      return state.products.filter(
        (product) => product.isActive && product.stock > 0 && product.originalPrice > product.price,
      )
    },

    // Get products by search term
    searchProducts: (state) => (searchTerm) => {
      if (!searchTerm)
        return state.products.filter((product) => product.isActive && product.stock > 0)

      const term = searchTerm.toLowerCase()
      return state.products.filter(
        (product) =>
          product.isActive &&
          product.stock > 0 &&
          (product.name.toLowerCase().includes(term) ||
            product.description.toLowerCase().includes(term) ||
            product.tags.some((tag) => tag.toLowerCase().includes(term))),
      )
    },

    // Check if any data is loading
    isLoading: (state) => {
      return Object.values(state.loading).some((loading) => loading)
    },

    // Check if there are any errors
    hasErrors: (state) => {
      return Object.values(state.errors).some((error) => error !== null)
    },
  },

  actions: {
    // Load all data from backend (with deduplication)
    async loadAllData() {
      // Prevent duplicate loading if already in progress
      if (
        this.loading.products ||
        this.loading.categories ||
        this.loading.groups ||
        this.loading.promotions
      ) {
        console.log('🔄 Data loading already in progress, skipping duplicate call')
        return
      }

      console.log('🚀 Starting data load from API...')
      await Promise.all([
        this.loadGroups(),
        this.loadCategories(),
        this.loadPromotions(),
        this.loadProducts(),
      ])
      console.log('✅ API data loading completed')
    },

    // Load groups from backend
    async loadGroups() {
      this.loading.groups = true
      this.errors.groups = null

      try {
        // Simulating API call - replace with actual backend endpoint
        const response = await axios.get('/api/groups')
        this.groups = response.data
      } catch (error) {
        console.error('Error loading groups:', error)
        this.errors.groups = error.message
        // Keep local data as fallback
      } finally {
        this.loading.groups = false
      }
    },

    // Load categories from backend
    async loadCategories() {
      this.loading.categories = true
      this.errors.categories = null

      try {
        // Simulating API call - replace with actual backend endpoint
        const response = await axios.get('/api/categories')
        this.categories = response.data
      } catch (error) {
        console.error('Error loading categories:', error)
        this.errors.categories = error.message
        // Keep local data as fallback
      } finally {
        this.loading.categories = false
      }
    },

    // Load promotions from backend
    async loadPromotions() {
      this.loading.promotions = true
      this.errors.promotions = null

      try {
        // Simulating API call - replace with actual backend endpoint
        const response = await axios.get('/api/promotions')
        this.promotions = response.data
      } catch (error) {
        console.error('Error loading promotions:', error)
        this.errors.promotions = error.message
        // Keep local data as fallback
      } finally {
        this.loading.promotions = false
      }
    },

    // Load products from backend
    async loadProducts() {
      this.loading.products = true
      this.errors.products = null

      // Store local products as backup ONLY if products array is currently empty or this is the first load
      const localProducts = [...this.products]
      console.log('📦 Local products backup count:', localProducts.length)

      try {
        console.log('🔄 Loading products from backend...')
        const response = await axios.get('/api/products')

        if (response.data && response.data.length > 0) {
          console.log('✅ Backend products loaded:', response.data.length)

          // Check for duplicates in backend response
          const backendIds = response.data.map((p) => p.id)
          const uniqueBackendIds = [...new Set(backendIds)]
          if (backendIds.length !== uniqueBackendIds.length) {
            console.error('🚨 BACKEND RETURNING DUPLICATE PRODUCTS!')
            console.error('   - Backend total:', backendIds.length)
            console.error('   - Backend unique:', uniqueBackendIds.length)
          }

          console.log('🔄 Replacing products array (not merging)...')

          // COMPLETELY REPLACE products array to avoid duplicates
          this.products = response.data.map((product) => ({
            ...product,
            // Ensure required fields are present
            id: product.id || Date.now() + Math.random(),
            name: product.name || 'Unknown Product',
            price: parseFloat(product.price) || 0,
            // Handle rating - set default if not provided
            rating: product.rating || Math.random() * 2 + 3, // Random 3-5 rating as fallback
            // Handle review count
            reviewCount: product.reviewCount || Math.floor(Math.random() * 100) + 10,
            // Handle brand - use group or default
            brand: product.brand || 'Hola Foods',
            // Handle stock
            stock: product.stock || 50,
            // Handle original price for discounts
            originalPrice:
              product.originalPrice || parseFloat(product.price) * (1 + Math.random() * 0.3),
            // Handle category
            categoryId: product.categoryId || 1,
            // Handle active status
            isActive: product.isActive !== false,
            // Handle images
            images: product.images || [product.image] || [
                '/src/assets/images/products/product1.jpg',
              ],
          }))

          console.log('📦 Processed products:', this.products.length)
        } else {
          console.log('⚠️ Backend returned empty products, keeping local data')
          this.products = localProducts
        }
      } catch (error) {
        console.error('❌ Error loading products from backend:', error)
        console.log('🔄 Using local fallback products...')
        this.errors.products = error.message
        // Keep local data as fallback
        this.products = localProducts
      } finally {
        this.loading.products = false
        console.log('🎯 Final products count:', this.products.length)
      }
    },

    // Add a new product
    async addProduct(product) {
      try {
        const response = await axios.post('/api/products', product)
        this.products.push(response.data)
        return response.data
      } catch (error) {
        console.error('Error adding product:', error)
        throw error
      }
    },

    // Update a product
    async updateProduct(productId, updates) {
      try {
        const response = await axios.put(`/api/products/${productId}`, updates)
        const index = this.products.findIndex((p) => p.id === productId)
        if (index !== -1) {
          this.products[index] = { ...this.products[index], ...response.data }
        }
        return response.data
      } catch (error) {
        console.error('Error updating product:', error)
        throw error
      }
    },

    // Delete a product
    async deleteProduct(productId) {
      try {
        await axios.delete(`/api/products/${productId}`)
        const index = this.products.findIndex((p) => p.id === productId)
        if (index !== -1) {
          this.products.splice(index, 1)
        }
      } catch (error) {
        console.error('Error deleting product:', error)
        throw error
      }
    },

    // Update product stock
    updateProductStock(productId, newStock) {
      const product = this.products.find((p) => p.id === productId)
      if (product) {
        product.stock = newStock
      }
    },

    // Clear all errors
    clearErrors() {
      this.errors = {
        groups: null,
        categories: null,
        promotions: null,
        products: null,
      }
    },

    // Reset store to initial state
    resetStore() {
      this.$reset()
    },
  },
})
