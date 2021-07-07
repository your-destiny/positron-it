<template>
  <div class="mt-4 mb-4 text-center text-3xl">{{getBooksTitle}}</div>
  <div class="text-right">
  <div v-if="getBooks.length > 0" class="pt-2 relative mx-auto text-gray-600">
    <input class=" border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
           type="search" v-model="search" name="search" placeholder="поиск...">
  </div>
  </div>
  <div class="mt-8 gap-4 grid grid-cols-3">
    <div  v-for="book in getBooks[paginate_index]">
      <inertia-link :href="route('book', {book: book.id})">
        <div class="w-full max-w-lg overflow-hidden rounded-lg shadow-lg sm:flex">
          <div class="w-full sm:w-1/3">
            <img v-if="book.thumbnailUrl" class="object-cover w-full h-48" :src="book.thumbnailUrl" alt="empty"/>
            <img v-else src="https://images.pexels.com/photos/4210787/pexels-photo-4210787.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" class="object-cover w-full h-48"  alt="empty"/>
          </div>
          <div class="flex-1 px-6 py-4">
            <h4 class="mb-3 text-xl font-semibold tracking-tight text-gray-800">
              {{book.title}}
            </h4>
            <p class="leading-normal text-gray-700">
              Артикул(isbn): {{book.isbn}}
            </p>
          </div>
        </div>
      </inertia-link>
    </div>
  </div>
  <div v-if="getBooks.length > 0" class="object-center items-center text-center"> <nav class=" mt-4 relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
    <button @click="paginate_index--" :disabled="paginate_index === 0" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
      <span class="sr-only">назад</span>
      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>
    </button>
    <div v-for="(item, index) in getBooks" style="margin-left: 0">
      <button v-if="index < 3 || index > getBooks.length - 1 - 3" @click="getChunk(index)" :class="{'bg-indigo-50': index === paginate_index}"  aria-current="page" class="z-10  border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
        {{index + 1}}
      </button>
      <span v-if="index === 3 && getBooks.length !== 4" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
          ...
        </span>
    </div>

    <button @click="paginate_index++" :disabled="paginate_index === getBooks.length - 1" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
      <span class="sr-only">вперед</span>
      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
      </svg>
    </button>
  </nav></div>

</template>

<script>
import CategoryNavLink from "@/Components/CategoryNavLink";
import Button from "@/Components/Button";
export default {
  name: "Books",
  components: {Button, CategoryNavLink},
  data(){
    return {
      search: '',
      paginate_index: 0,
      paginate_count: 0
    };
  },
  props: {
    categories: [Array, Object],
    paginate: [String, Number]
  },
  computed: {
    getBooks(){
      let needle = this.categories.hasOwnProperty('books')
          ? this.categories.books
          : [];

      if (this.search !== '') {
        let temp = needle.filter((el) => el.title.toLowerCase().includes(this.search.toLowerCase()));
        return this.sliceIntoChunks(temp, this.paginate);
      }

      return this.sliceIntoChunks(needle, this.paginate);
    },

    getBooksTitle(){
      if (!this.categories.hasOwnProperty('id')) {
        return 'Выберите категорию для показа книг';
      }

      if (this.categories.hasOwnProperty('books') && this.categories.books.length > 0) {
        return `Книги категории ${this.categories.name}`;
      }
      else {
        return 'У данной категории нет книг';
      }
    },
  },

  methods:{
    sliceIntoChunks(arr, size) {
      return arr.reduce((acc, val, i) => {
        let idx = Math.floor(i / size)
        let page = acc[idx] || (acc[idx] = [])
        page.push(val)

        return acc
      }, [])
    },

    getChunk(index){
      this.paginate_index = index;
    },

    dots(index){
      this.paginate_count++;
      return (index > 3 || index < this.getBooks.length - 1 - 3) && this.paginate_count >= 1;
    }
  },
}
</script>

<style scoped>

</style>
