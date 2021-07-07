<template>
  <category-books :categories="categories">
    <categories-view :categories="categories"/>
    <hr class="border-2">
    <books :categories="categories" :paginate="paginate" />
  </category-books>
</template>

<script>
import CategoryBooks from "@/Layouts/CategoryBooks";
import BookDetailComponent from "@/Components/BookDetailComponent";
import Books from "@/Components/Books";
import CategoriesView from "@/Components/CategoriesView";
export default {
  components: {CategoriesView, Books, BookDetailComponent, CategoryBooks},
  props: {
    categories: [Array, Object],
    paginate: [String, Number]
  },
}
</script>

