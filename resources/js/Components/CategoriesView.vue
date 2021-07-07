<template>
  <div class="mb-4 text-center text-3xl">{{getCategoriesTitle}}</div>
  <div class="mb-8 grid grid-cols-4 gap-4 text-center">
    <div  v-for="category in getCategories">
      <category-nav-link  :href="route('category', {category: category.id})" :active="route().current('category', {category: category.id})">
        {{ category.name }}
      </category-nav-link>
    </div>
  </div>
</template>

<script>
import CategoryNavLink from "@/Components/CategoryNavLink";
import NavLink from "@/Components/NavLink";
import Button from "@/Components/Button";

export default {
name: "CategoriesView",
  components: {Button, NavLink, CategoryNavLink},
  props:{
  categories: [Array, Object]
  },
  computed: {
    getCategories() {
      return this.categories.hasOwnProperty('children')
          ? this.categories.children
          : this.categories;
    },
    getCategoriesTitle() {
      if (this.categories.hasOwnProperty('children')) {
        if (this.categories.children.length > 0)
          return `Категории подкатегории ${this.categories.name}`;
        else {
          return `У категории нет подкатегорий`;
        }
      }
      else {
        return 'Категории';
      }
    },
  }
}
</script>

<style scoped>

</style>
