<template>
  <div class="max-h-screen overflow-y-auto shadow-lg">
    <div class="modal-card rounded-xl bg-white shadow-lg">
      <header class="modal-card-head bg-white relative items-start">
        <slot name="header">
          <p class="modal-card-title flex items-center justify-between text-xl font-weight-normal">
            <span style="width: 24px; height: 48px" />
            <span class="text-2xl flex-1 text-center font-bold capitalize">{{ header }}</span>
            <a
              href="#"
              class="text-black self-start"
              @click.prevent="closeModal"
            >
              <span class="icon">
                <FontAwesomeIcon
                  :icon="['fas', 'times']"
                />
              </span>
            </a>
          </p>
        </slot>
      </header>
      <section class="modal-card-body p-0 overflow-auto">
        <slot>
          <div class="modal-card-body bg-white p-4 md:p-6 text-sm sm:text-base md:text-lg">
            <p class="mb-4">
              {{ content }}
            </p>
          </div>
        </slot>
      </section>
      <div class="card-footer">
        <div class="card-footer-item flex-col">
          <slot name="footer">
            {{ footer }}
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Blur from '@/mixins/Blur'

export default {
  name: 'AccordionModal',
  mixins: [Blur],
  props: {
    header: {
      type: String,
      default: '',
    },
    content: {
      type: String,
      default: '',
    },
    footer: {
      type: String,
      default: '',
    },
  },
  methods: {
    closeModal () {
      this.$emit('close')
      this.$parent.$emit('close')
      this.unBlur()
    },
  },
}
</script>
