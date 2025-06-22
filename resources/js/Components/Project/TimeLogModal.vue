<script setup>
import { ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
    visible: Boolean,
    projectId: Number,
});

const emit = defineEmits(["cancel", "created"]);

const newProjectId = ref(null);
const isCreating = ref(false);
const form = ref({
    description: "",
    billable: "billable", // Default to billable
});

watch(
    () => props.projectId,
    (newValue) => {
        if (newValue) newProjectId.value = newValue;
    },
    { immediate: true }
);

const handleCreate = async () => {
    isCreating.value = true;

    try {
        // Validate form data
        if (!form.value.description || !form.value.billable) {
            alert("Please fill in all fields.");
            isCreating.value = false;
            return;
        }

        const response = await axios.post(
            `/start-timelog/${props.projectId}`,
            form.value
        );

        if (response.status === 201) {
            emit("created");
            form.value.description = "";
            form.value.billable = "billable"; // Reset to default
            alert("Time log created successfully!");
        } else {
            alert(response.data.data);
            console.error("Error creating time log:", response.data.data);
        }
    } catch (error) {
        console.error("Error creating time log:", error);
    } finally {
        isCreating.value = false;
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light border-bottom-0">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-plus-circle me-2"></i>Start New Time Log
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="$emit('cancel')"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <input
                                v-model="form.description"
                                type="text"
                                placeholder="Description"
                                class="form-control"
                            />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                >Billable/Non-Billable</label
                            >
                            <select
                                v-model="form.billable"
                                class="form-select stylish-input mb-3"
                            >
                                <option value="billable">Billable</option>
                                <option value="non-billable">
                                    Non Billable
                                </option>
                            </select>
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
                        @click.prevent="handleCreate"
                        :disabled="isCreating"
                    >
                        <span v-if="isCreating">
                            <span
                                class="spinner-border spinner-border-sm me-1"
                                role="status"
                            ></span>
                            Creating...
                        </span>
                        <span v-else>
                            <i class="bi bi-plus-circle me-1"></i>Start New
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
