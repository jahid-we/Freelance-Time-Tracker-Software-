<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  visible: Boolean,
});

const form = ref({
  name: "",
  email: "",
});

const originalEmail = ref("");

const fetchUserProfile = async () => {
    try {
        const response = await axios.get("/get-user-profile");
        if (response.status === 200) {
            form.value.name = response.data.data.name;
            form.value.email = response.data.data.email;
            originalEmail.value = response.data.data.email;
        }
    } catch (error) {
        console.error("Error fetching user profile:", error);
    }
};

const isUpdating = ref(false);
const emit = defineEmits(["cancel", "updated"]);

const handleUpdate = async () => {
  if (!form.value.name || !form.value.email) return;

  isUpdating.value = true;
  try {
    const response = await axios.post("/update-user-profile", form.value);

    if (response.status === 200) {
      if (form.value.email !== originalEmail.value) {
        alert("Profile Info changed. You will be redirected to log in again.");
        setTimeout(() => {
          router.visit("/login");
        }, 1000);
        return;
      }
      window.location.reload();
      alert("Profile updated successfully!");
      emit("updated");
    }
  } catch (error) {
    console.error("Profile update failed:", error);
    alert("Failed to update profile. Please try again.");
  } finally {
    isUpdating.value = false;
  }
};

onMounted(() => {
  fetchUserProfile();
});
</script>



<template>
  <div
    v-if="visible"
    class="modal fade show d-block"
    tabindex="-1"
    style="background-color: rgba(0, 0, 0, 0.5)"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title fw-semibold">
            <i class="bi bi-pencil-square me-2"></i>Update Profile Information
          </h5>
          <button
            type="button"
            class="btn-close"
            @click="$emit('cancel')"
          ></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-2 g-3">
              <div class="col">
                <label class="form-label">Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  placeholder="Name"
                  class="form-control"
                />
              </div>
              <div class="col">
                <label class="form-label">Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="Email"
                  class="form-control"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 justify-content-end">
          <button
            type="button"
            class="btn btn-outline-secondary"
            @click="$emit('cancel')"
          >
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click.prevent="handleUpdate()"
            :disabled="isUpdating"
          >
            <span v-if="isUpdating">
              <span class="spinner-border spinner-border-sm me-1" role="status"></span>
              Updating...
            </span>
            <span v-else>
              <i class="bi bi-save me-1"></i>Update Profile
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
