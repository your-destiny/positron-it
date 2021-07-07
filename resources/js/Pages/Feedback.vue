<template>
  <breeze-validation-errors class="mb-4" />

  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

  <form @submit.prevent="submit">
    <div>
      <breeze-label for="email" value="Email" />
      <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="email" />
    </div>

    <div class="mt-4">
      <breeze-label for="name" value="ФИО" />
      <breeze-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
    </div>

    <div class="mt-4">
      <breeze-label for="message" value="Сообщение" />
      <text-area required id="message" type="text" class="mt-1 block w-full" v-model="form.message"  autocomplete="message" />
    </div>

    <div class="mt-4">
      <breeze-label for="tel" value="Телефон" />
      <breeze-input id="tel" type="tel" class="mt-1 block w-full" v-model="form.tel" autocomplete="tel" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <breeze-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Войти
      </breeze-button>
    </div>
  </form>
</template>

<script>
import BreezeButton from '@/Components/Button'
import BreezeGuestLayout from "@/Layouts/Guest"
import BreezeInput from '@/Components/Input'
import BreezeCheckbox from '@/Components/Checkbox'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'
import TextArea from "@/Components/TextArea";

export default {
  name: 'Feedback',
  layout: BreezeGuestLayout,

  components: {
    TextArea,
    BreezeButton,
    BreezeInput,
    BreezeCheckbox,
    BreezeLabel,
    BreezeValidationErrors
  },

  props: {
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: '',
        name: '',
        message: '',
        tel: ''
      })
    }
  },

  methods: {
    submit() {
      this.form.post(this.route('feedback'), {
        onFinish: () => '',
      })
    }
  }
}
</script>
