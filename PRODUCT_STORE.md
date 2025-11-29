# Product Store Documentation

## Overview

The Product Store is a Pinia-based state management solution for your e-commerce application. It manages products, categories, groups, and promotions with both local data and backend API integration.

## Store Structure

### State

- `groups[]` - Product group categories (Electronics, Fashion, etc.)
- `categories[]` - Product subcategories within groups
- `promotions[]` - Active promotions and sales
- `products[]` - Individual product listings
- `loading{}` - Loading states for each data type
- `errors{}` - Error states for each data type

### Key Features

- 📦 **10 Sample Products** across different categories
- 🏷️ **4 Product Groups** with 10+ subcategories
- 🎯 **4 Active Promotions** with different discount types
- 🔍 **Advanced Search** and filtering capabilities
- 💾 **Local Data Fallback** when API is unavailable
- ⚡ **Real-time Updates** and state management

## Usage Examples

### Basic Store Usage

```javascript
import { useProductStore } from '@/stores/productStore.js'

const productStore = useProductStore()

// Load all data
await productStore.loadAllData()

// Get featured products
const featured = productStore.featuredProducts

// Search products
const results = productStore.searchProducts('smartphone')

// Get products by category
const smartphones = productStore.getProductsByCategory(1)
```

### Getters Available

- `activeGroups` - All active product groups
- `activeCategories` - All active categories
- `activePromotions` - Currently valid promotions
- `featuredProducts` - Featured product listings
- `productsOnSale` - Products with discounted prices
- `searchProducts(term)` - Search products by name/description/tags
- `getCategoriesByGroup(groupId)` - Categories within a specific group
- `getProductsByCategory(categoryId)` - Products in a category
- `getProductById(productId)` - Single product by ID

### Actions Available

- `loadAllData()` - Load all data from backend APIs
- `loadGroups()`, `loadCategories()`, `loadPromotions()`, `loadProducts()` - Load specific data types
- `addProduct(product)` - Add new product
- `updateProduct(id, updates)` - Update existing product
- `deleteProduct(id)` - Remove product
- `updateProductStock(id, stock)` - Update product inventory
- `clearErrors()` - Clear all error states
- `resetStore()` - Reset to initial state

## Sample Data

### Product Groups

1. **Electronics** - Smartphones, Laptops, Audio & Video
2. **Fashion** - Men's/Women's Clothing, Shoes
3. **Home & Garden** - Furniture, Kitchen & Dining
4. **Sports & Fitness** - Fitness Equipment, Outdoor Sports

### Featured Products

- iPhone 15 Pro ($999.99)
- Samsung Galaxy S24 ($849.99)
- MacBook Pro 14" ($1,599.99)
- Sony WH-1000XM5 Headphones ($349.99)
- Adjustable Dumbbells Set ($199.99)

### Active Promotions

- **Black Friday Sale** - 50% off Electronics
- **Free Shipping Weekend** - Free shipping over $50
- **New Year Fashion Sale** - 30% off Fashion items
- **Electronics Flash Sale** - $25 off orders over $200

## API Integration

The store is configured to work with these backend endpoints:

- `GET /api/groups` - Product groups
- `GET /api/categories` - Product categories
- `GET /api/promotions` - Active promotions
- `GET /api/products` - Product listings
- `POST /api/products` - Create new product
- `PUT /api/products/:id` - Update product
- `DELETE /api/products/:id` - Remove product

### Fallback Strategy

If backend APIs are unavailable, the store automatically falls back to comprehensive local data, ensuring your application continues to work seamlessly.

## Demo Component

The `StoreDemo.vue` component demonstrates all store capabilities:

- Display active groups, categories, and promotions
- Show featured and sale products
- Demonstrate search functionality
- Handle loading and error states
- Trigger data reload actions

## Getting Started

1. **Import the store** in your components:

```javascript
import { useProductStore } from '@/stores/productStore.js'
```

2. **Initialize in setup()** or mounted():

```javascript
const productStore = useProductStore()
await productStore.loadAllData()
```

3. **Use reactive data** in templates:

```vue
<div v-for="product in productStore.featuredProducts" :key="product.id">
  {{ product.name }} - ${{ product.price }}
</div>
```

## Error Handling

The store includes comprehensive error handling:

- Network request failures
- API endpoint unavailability
- Data validation errors
- Loading state management

Errors are stored in `store.errors` and can be cleared with `store.clearErrors()`.

## Performance Tips

- Use getters for computed data instead of filtering in components
- Load data once in app initialization, use store state throughout
- Implement pagination for large product lists
- Use `searchProducts()` getter for client-side search instead of repeated API calls
