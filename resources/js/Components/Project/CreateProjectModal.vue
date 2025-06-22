<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    visible: Boolean,
});

const emit = defineEmits(["cancel", "created"]);

const clients = ref([]);

const project = ref({
    client_id: "",
    title: "",
    description: "",
    status: "active",
    deadline: "",
});

const isCreating = ref(false);

// Fetch clients from API
const fetchClients = async () => {
    try {
        const response = await axios.get("/get-clients");
        clients.value = response.data.data;
    } catch (error) {
        console.error("Error fetching clients:", error);
    }
};

const handleCreate = async () => {
    isCreating.value = true;

    try {
        // Validate project data
        if (
            !project.value.client_id ||
            !project.value.title ||
            !project.value.description
        ) {
            alert("Please fill in all fields.");
            isCreating.value = false;
            return;
        }

        const response = await axios.post("/create-project", project.value, {
            headers: {
                "Content-Type": "application/json",
            },
        });

        if (response.status === 201) {
            emit("created");
            project.value = {
                client_id: "",
                title: "",
                description: "",
                status: "active",
                deadline: "",
            };
            alert("Project created successfully!");
        } else {
            console.error("Unexpected response:", response);
            alert("Something went wrong.");
        }
    } catch (error) {
        console.error("Error creating project:", error?.response ?? error);
        if (error.response?.status === 422) {
            const errors =
                error.response.data?.errors || error.response.data?.data;
            const firstError = Object.values(errors)[0][0];
            alert(firstError);
        } else {
            alert("An unexpected error occurred.");
        }
    } finally {
        isCreating.value = false;
    }
};

onMounted(() => {
    fetchClients();
});
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
                        <i class="bi bi-plus-circle me-2"></i>Add New Project
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="$emit('cancel')"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Select Client</label>
                            <select
                                v-model="project.client_id"
                                class="form-select stylish-input mb-3"
                            >
                                <option disabled value="">Default</option>
                                <option
                                    v-for="client in clients"
                                    :key="client.id"
                                    :value="client.id"
                                >
                                    {{ client.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Title</label>
                            <input
                                type="text"
                                v-model="project.title"
                                placeholder="Title"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Description</label>
                            <input
                                type="text"
                                v-model="project.description"
                                placeholder="Description"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select
                                v-model="project.status"
                                class="form-select stylish-input mb-3"
                            >
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Deadline</label>
                            <input
                                type="date"
                                v-model="project.deadline"
                                class="form-control"
                            />
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
                            <i class="bi bi-plus-circle me-1"></i>Add Project
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
