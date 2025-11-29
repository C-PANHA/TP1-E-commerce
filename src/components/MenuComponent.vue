<template>
  <div class="menu-component">
    <div class="menu-tabs">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        :class="['menu-tab', { active: activeTab === tab.id }]"
        @click="setActiveTab(tab.id)"
      >
        {{ tab.name }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MenuComponent',
  props: {
    tabs: {
      type: Array,
      required: true,
      default: () => [],
    },
    activeTab: {
      type: String,
      default: 'all',
    },
  },
  emits: ['tab-changed'],
  methods: {
    setActiveTab(tabId) {
      this.$emit('tab-changed', tabId)
    },
  },
}
</script>

<style scoped>
.menu-component {
  margin-bottom: 30px;
}

.menu-tabs {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}

.menu-tab {
  padding: 12px 20px;
  background: none;
  border: none;
  color: #7e7e7e;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  border-radius: 6px;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.menu-tab:hover {
  color: #3bb77e;
  background-color: #f4f6fa;
}

.menu-tab.active {
  color: #3bb77e;
  font-weight: 600;
  background-color: #f4f6fa;
}

@media (max-width: 768px) {
  .menu-tabs {
    gap: 8px;
    justify-content: flex-start;
    overflow-x: auto;
    padding: 0 10px;
  }

  .menu-tab {
    padding: 10px 16px;
    font-size: 14px;
    flex-shrink: 0;
  }
}
</style>
