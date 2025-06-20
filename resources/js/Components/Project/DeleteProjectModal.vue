<script setup>
import { ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
    visible: Boolean,
    projectId: Number,
});
const emit = defineEmits(["cancel", "deleted"]);

const newProjectId = ref(null);
const isDeleting = ref(false);

watch(
    ()=> props.projectId,
    (newValue) =>{
        if (newValue) newProjectId.value = newValue;
    },
    { immediate: true }
);

const handleDelete = async () => {
    if (!newProjectId.value) {
        alert("No valid project ID provided for deletion");
        console.error("No valid project ID provided for deletion");
        return;
    }

    isDeleting.value = true;
    try {
        const response = await axios.delete(`/delete-project/${newProjectId.value}`);
        if (response.status === 200) {
            emit("deleted");
            alert("Project deleted successfully!");
        } else {
            alert(response.data.data);
            console.error("Error deleting project:", response.data.data);
        }
    } catch (error) {
        console.error("Error deleting project:", error);
    } finally {
        isDeleting.value = false;
    }
};

</script>

<template>
<div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title text-danger fw-bold">
            <i class="bi bi-trash me-2"></i>Confirm Deletion
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-2">Do you really want to delete this Project?</p>
          <p class="text-danger small"><i class="bi bi-info-circle me-1"></i>This action is permanent and cannot be undone.</p>
        </div>
        <div class="modal-footer border-top-0 justify-content-end">
          <button type="button" class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-danger" @click="handleDelete()" :disabled="isDeleting">
            <span v-if="isDeleting">
              <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
              Deleting...
            </span>
            <span v-else>
              <i class="bi bi-trash me-1"></i>Delete
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
