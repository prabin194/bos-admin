<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components/VForm'

interface Emit {
  (e: 'update:isDrawerOpen', value: boolean): void
  (e: 'productData', value: object): void
}

interface Props {
  isDrawerOpen: boolean
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const isFormValid = ref(false)
const refForm = ref<VForm>()

const product = ref({
  en: { title: '', description: '' },
  ne: { title: '', description: '' },
  price: '',
  status: 'Approved',
})

const currentTab = ref('nepali')

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isDrawerOpen', false)

  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit('productData', product.value)
      emit('update:isDrawerOpen', false)
      nextTick(() => {
        refForm.value?.reset()
        refForm.value?.resetValidation()
      })
    }
  })
}

const handleDrawerModelValueUpdate = (val: boolean) => {
  emit('update:isDrawerOpen', val)
}
</script>

<template>
  <VNavigationDrawer
    temporary
    :width="800"
    location="end"
    class="scrollable-content"
    :model-value="props.isDrawerOpen"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Title -->
    <AppDrawerHeaderSection
      title="Add Product Tree"
      @cancel="closeNavigationDrawer"
    />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!-- 👉 Form -->
          <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
          >
            <VTabs
              v-model="currentTab"
              grow
            >
              <VTab>
                <span>Nepali</span>
              </VTab>
              <VTab>
                <span>English</span>
              </VTab>
            </VTabs>
            <VWindow v-model="currentTab">
              <VWindowItem>
                <VCol cols="12">
                  <AppTextField
                    v-model="product.ne.title"
                    :rules="[requiredValidator]"
                    label="Title"
                    placeholder="Plant Name"
                  />
                </VCol>
                <VCol cols="12">
                  <AppTextarea
                    v-model="product.ne.description"
                    :rules="[requiredValidator]"
                    label="Description"
                    placeholder="Write the product description..."
                  />
                </VCol>
              </VWindowItem>
              <VWindowItem>
                <VCol cols="12">
                  <AppTextField
                    v-model="product.en.title"
                    :rules="[requiredValidator]"
                    label="Title"
                    placeholder="Plant Name"
                  />
                </VCol>
                <VCol cols="12">
                  <AppTextarea
                    v-model="product.en.description"
                    :rules="[requiredValidator]"
                    label="Description"
                    placeholder="Write the product description..."
                  />
                </VCol>
              </VWindowItem>
            </VWindow>
            <VRow class="px-3">
              <VCol cols="12">
                <AppTextField
                  v-model="product.price"
                  type="number"
                  prefix="Rs."
                  :rules="[requiredValidator]"
                  label="Price"
                  placeholder="100"
                />
              </VCol>

              <!-- 👉 Submit and Cancel -->
              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                >
                  Submit
                </VBtn>
                <VBtn
                  type="reset"
                  variant="outlined"
                  color="secondary"
                  @click="closeNavigationDrawer"
                >
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>
