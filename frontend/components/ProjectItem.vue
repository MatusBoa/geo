<script setup lang="ts">
import type { Product } from "~/types/product"

defineProps<{
  project: Product,
}>()
</script>

<template>
  <div class="project-item">
    <h2>{{ project.name }}</h2>
    <div class="project-attributes">
      <div>Cena: {{ project.price.formatted }}</div>
      <div>Vytvořen: {{ project.created_at }}</div>
      <div>Upraven: {{ project.updated_at }}</div>
    </div>
  </div>
</template>

<style lang="scss">
.project-item {
  padding: 8px;
  border-radius: 8px;
  background: #fff;
  display: flex;
  flex-direction: column;
}

.project-attributes {
  display: flex;
  gap: 8px;
}
</style>
