<template>
  <inertia-link :href="href" >
  <div :class="classes" class="px-4 py-3 leading-normal rounded-lg" role="alert">
      <slot />
  </div>
  </inertia-link>
</template>

<script>
export default {
  props: ['href', 'active'],

  computed: {
    classes() {
      return this.active
          ? 'text-green-700 bg-green-100'
          : 'text-blue-700 bg-blue-100'
    }
  }
}
</script>
