<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  visible: Boolean,
})
const emit = defineEmits(['cancel', 'created']);

const isCreating = ref(false)

const client = ref({
    name: '',
    email: '',
    contact_person: ''
})

const handleCreate = async () => {
  isCreating.value = true
  try {
    // Validate client data
    if (!client.value.name || !client.value.email || !client.value.contact_person) {
      alert('Please fill in all fields.')
      isCreating.value = false
      return
    }
    const response = await axios.post('/create-client', client.value)
    if (response.status === 200) {

      emit('created')
      client.value = { name: '', email: '', contact_person: '' } // Reset form
      alert('Client created successfully!')
    } else {
      console.error('Error creating client:', response.data.message)
    }
  } catch (error) {
    console.error('Error creating client:', error)
  } finally {
    isCreating.value = false
  }
}

</script>

<template>
<div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title fw-semibold">
            <i class="bi bi-plus-circle me-2"></i>Add New Client
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input v-model="client.name" type="text" placeholder="Name" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input v-model="client.email" type="email" placeholder="Email" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Contact Person</label>
              <input v-model="client.contact_person" type="text" placeholder="Phone" class="form-control" />
            </div>

          </div>
        </div>
        <div class="modal-footer border-top-0 justify-content-end">
          <button type="button" class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-primary" @click.prevent="handleCreate" :disabled="isCreating">
            <span v-if="isCreating">
              <span class="spinner-border spinner-border-sm me-1" role="status"></span>
              Creating...
            </span>
            <span v-else>
              <i class="bi bi-plus-circle me-1"></i>Add Contact
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-content {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
