<script setup>
import { ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
    visible: Boolean,
    client: Object,
});
const emit = defineEmits(["cancel", "edited"]);

const newClientData = ref({
    id:"",
    name: "",
    email: "",
    contact_person: "",
});

watch(
    () => props.client,
    (newValue) => {
        if (newValue) {
            newClientData.value = { ...newValue };
        }
    },
    { immediate: true }
);

const isEditing = ref(false);



const handleUpdate = async () => {
    if (!newClientId.value) {
        alert("No valid client ID provided for update");
        console.error("No valid client ID provided for update");
        return;
    }

    isEditing.value = true;
    try {
        const response = await axios.post(`/update-client/${newClientData.id}`, newClientData.value);
        if (response.status === 200) {
            emit("edited");
            alert("Client updated successfully!");
        } else {
            alert(response.data.data);
            console.error("Error updating client:", response.data.data);
        }
    } catch (error) {
        console.error("Error updating client:", error);
    } finally {
        isEditing.value = false;
    }
};
watch(
    () => props.visible,
    (newValue) => {
        if (!newValue) {
            newClientData.value = { name: "", email: "", contact_person: "" }; // Reset form data
        }
    }
);
</script>

<template>

<div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title fw-semibold">
            <i class="bi bi-pencil-square me-2"></i>Edit Contact
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input v-model="newClientData.name" type="text" placeholder="Name" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input v-model="newClientData.email" type="email" placeholder="Email" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Contact Person</label>
              <input v-model="newClientData.contact_person" type="text" placeholder="Phone" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 justify-content-end">
          <button class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button class="btn btn-primary" @click="handleUpdate" :disabled="isUpdating">
            <span v-if="isUpdating">
              <span class="spinner-border spinner-border-sm me-1"></span> Updating...
            </span>
            <span v-else>
             <i class="bi bi-arrow-repeat me-1"></i>Update Contact
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
