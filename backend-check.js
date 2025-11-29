// Quick Backend Health Check & Setup
import axios from 'axios'
import fs from 'fs'
import path from 'path'
import { fileURLToPath } from 'url'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

async function checkBackendHealth() {
  console.log('🔍 Checking Backend Health...\n')

  try {
    // Test basic connection
    const response = await axios.get('http://localhost:3000/api/products')
    console.log('✅ Backend is responding')
    console.log(`📊 Found ${response.data.length} products`)

    // Test image structure
    if (response.data.length > 0) {
      const sampleProduct = response.data[0]
      console.log('\n📋 Sample Product Structure:')
      console.log('- ID:', sampleProduct.id)
      console.log('- Name:', sampleProduct.name)
      console.log('- Image:', sampleProduct.image)
      console.log('- Group:', sampleProduct.group)
      console.log('- Category ID:', sampleProduct.categoryId)

      // Parse image if it's JSON string
      try {
        const imageArray = JSON.parse(sampleProduct.image)
        console.log('- Parsed Image:', imageArray[0])

        // Test if image file exists
        const imagePath = path.join(__dirname, '..', imageArray[0])
        if (fs.existsSync(imagePath)) {
          console.log('✅ Image file exists on backend')
        } else {
          console.log('❌ Image file not found at:', imagePath)
        }
      } catch (e) {
        console.log('- Image format: Not JSON string')
      }
    }

    console.log('\n🎯 Backend Status: HEALTHY')
  } catch (error) {
    console.error('❌ Backend Health Check Failed:')
    console.error('- Error:', error.message)
    console.error('- Make sure your backend server is running on port 3000')

    console.log('\n🚀 To start backend server:')
    console.log('1. Navigate to your backend directory')
    console.log('2. Run: npm start (or node server.js)')
  }
}

// Run the health check
checkBackendHealth()
