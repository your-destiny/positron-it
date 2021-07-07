<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link :href="route('categories')">
          Категории и книги
        </inertia-link>
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <slot />
          </div>
        </div>
      </div>
    </div>
  </breeze-authenticated-layout>
</template>

<script>
  import BreezeAuthenticatedLayout from '@/Layouts/Authenticated';
  import CategoryNavLink from "@/Components/CategoryNavLink";
  import Books from "@/Components/Books";
  import BookDetail from "@/Components/BookDetailComponent";
  import CategoriesView from "@/Components/CategoriesView";
  import NavLink from "@/Components/NavLink";
  export default {

    components: {
      NavLink,
      CategoriesView,
      BookDetail,
      Books,
      BreezeAuthenticatedLayout,
      CategoryNavLink,
    },

    props: {
      categories: [Array, Object],
    },
  }
</script>
