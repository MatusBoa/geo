<script lang="ts" setup>
import useApiService from "~/composables/useApiService.js"
import type { Product } from "~/types/product"
import type { PaginatedApiResponse } from "~/types/api"

onMounted(() => {
  loadProjects();
})

const projects = ref([]);
const loadProjects = async () => {
  const project = await useApiService().get<PaginatedApiResponse<Product>>('/api/v1/products')

  projects.value = project.items;
}
</script>

<template>
  <h1>Projekty</h1>
  <div class="project-list">
    <ProjectItem v-for="project in projects" :project="project"/>
  </div>
</template>

<style lang="scss">
.project-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
</style>
