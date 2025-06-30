<script setup>
import { ref } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    visible: Boolean,
});

const emit = defineEmits(["cancel", "updated"]);
const isUpdating = ref(false);

const passwordForm = ref({
    current_password: "",
    new_password: "",
    new_password_confirmation: "",
});

const handleUpdate = async () => {
    if (
        !passwordForm.value.current_password ||
        !passwordForm.value.new_password ||
        !passwordForm.value.new_password_confirmation
    ) {
        alert("Please fill in all fields.");
        return;
    } else if (
        passwordForm.value.new_password !==
        passwordForm.value.new_password_confirmation
    ) {
        alert("New passwords do not match.");
        return;
    } else if (passwordForm.value.new_password.length < 6) {
        alert("New password must be at least 6 characters long.");
        return;
    }

    isUpdating.value = true;
    try {
        const response = await axios.post(
            "/update-user-password",
            passwordForm.value
        );

        if (response.status === 200) {
            alert("Password updated successfully!");
            emit("cancel");
            setTimeout(() => {
                router.visit("/login");
            }, 1000); // Redirect to login after 1 second

            // Reset the form
            passwordForm.value = {
                current_password: "",
                new_password: "",
                new_password_confirmation: "",
            };
        }
    } catch (error) {
        console.error("Password update failed:", error);
        alert(
            error.response?.data?.data ||
                "Failed to update password. Please try again."
        );
    } finally {
        isUpdating.value = false;
    }
};
</script>

<template>
    <div
        v-if="visible"
        class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0, 0, 0, 0.5)"
    >
        <div
            class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down"
        >
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light border-bottom-0">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-lock me-2"></i>Update Password
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="$emit('cancel')"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <label class="form-label"
                                    >Current Password</label
                                >
                                <input
                                    v-model="passwordForm.current_password"
                                    type="password"
                                    placeholder="Current Password"
                                    class="form-control"
                                />
                            </div>
                            <div class="col">
                                <label class="form-label">New Password</label>
                                <input
                                    v-model="passwordForm.new_password"
                                    type="password"
                                    placeholder="New Password"
                                    class="form-control"
                                />
                            </div>
                            <div class="col">
                                <label class="form-label"
                                    >Confirm New Password</label
                                >
                                <input
                                    v-model="
                                        passwordForm.new_password_confirmation
                                    "
                                    type="password"
                                    placeholder="Confirm New Password"
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
                            <span
                                class="spinner-border spinner-border-sm me-1"
                                role="status"
                            ></span>
                            Updating...
                        </span>
                        <span v-else>
                            <i class="bi bi-lock me-1"></i>Update Password
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
