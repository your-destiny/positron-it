<template>
<category-books>
  <categories-view :categories="book.categories"/>
  <BookDetailComponent :book="book" />
</category-books>
</template>

<script>
import CategoryBooks from "@/Layouts/CategoryBooks";
import BookDetailComponent from "@/Components/BookDetailComponent";
import CategoriesView from "@/Components/CategoriesView";
import Books from "@/Components/Books";
export default {
  name: "BookDetail",
  components: {Books, CategoriesView, BookDetailComponent, CategoryBooks},
  props:{
    book: [Array, Object],
  }
}
</script>

<style scoped>

</style>
