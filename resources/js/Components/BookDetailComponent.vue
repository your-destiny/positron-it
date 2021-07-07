<template>

  <div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">

    <!--Main Col-->
    <div id="profile" class="w-full  rounded-lg lg:rounded-l-lg lg:rounded-r-none shadow-2xl bg-white  mx-6 lg:mx-0">


      <div class="p-4 md:p-12 text-center lg:text-left">
        <!-- Image for mobile view-->
        <img class="block  shadow-xl mx-auto -mt-16 h-48 w-40 bg-cover bg-center " :src="book.thumbnailUrl" />

        <h1 class="text-3xl font-bold pt-8 lg:pt-0">{{book.title}}</h1>

        <div class="mx-auto lg:mx-0  pt-3 border-b-2 border-green-500 opacity-25"></div>
        <p class="pt-4 text-base font-bold flex items-center justify-center lg:justify-start">Количество страниц: {{book.pageCount}}</p>
        <p class="pt-4 text-base font-bold flex items-center justify-center lg:justify-start">Артикул(isbn): {{book.isbn}}</p>
        <p class="pt-4 text-base font-bold flex items-center justify-center lg:justify-start">Авторы: &nbsp;
          <span v-for="author in book.authors">
          {{author.name}}, &nbsp;
          </span>
        </p>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BookDetailComponent",

  props:{
    book: Array
  },
}
</script>

<style scoped>

</style>
