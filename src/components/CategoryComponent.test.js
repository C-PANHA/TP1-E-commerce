import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import CategoryComponent from './CategoryComponent.vue'

describe('CategoryComponent', () => {
  it('renders props correctly', () => {
    const wrapper = mount(CategoryComponent, {
      props: {
        title: 'Test Category',
        image: 'test-image.png',
        items: 10,
        bgColor: '#ffffff'
      }
    })

    expect(wrapper.text()).toContain('Test Category')
    expect(wrapper.text()).toContain('10 items')
    expect(wrapper.find('img').attributes('src')).toBe('test-image.png')
  })

  it('applies background color', () => {
    const wrapper = mount(CategoryComponent, {
      props: {
        title: 'Test',
        image: 'test.png',
        items: 5,
        bgColor: '#ff0000'
      }
    })

    expect(wrapper.attributes('style')).toContain('background-color: rgb(255, 0, 0)')
  })
})