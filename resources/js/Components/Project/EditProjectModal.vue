<script setup>
import { ref, watch, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    visible: Boolean,
    project: Object,
});
const emit = defineEmits(["cancel", "edited"]);

const clients = ref([]);
const newProjectData = ref({
    id: "",
    client_id: "",
    title: "",
    description: "",
    status: "",
    deadline: "",
});

watch(
    () => props.project,
    (newValue) => {
        if (newValue) {
            newProjectData.value = { ...newValue };
        }
    },
    { immediate: true }
);

// Fetch clients from API
const fetchClients = async () => {
    try {
        const response = await axios.get("/get-clients");
        clients.value = response.data.data;
    } catch (error) {
        console.error("Error fetching clients:", error);
    }
};
const isEditing = ref(false);

const handleUpdate = async () => {
    if (!newProjectData.value.id) {
        alert("No valid project ID provided for update");
        console.error("No valid project ID provided for update");
        return;
    }

    isEditing.value = true;
    try {
        const response = await axios.post(`/update-project/${newProjectData.value.id}`, newProjectData.value);
        if (response.status === 200) {
            emit("edited");
            alert("Project updated successfully!");
        } else {
            alert(response.data.data);
            console.error("Error updating project:", response.data.data);
        }
    } catch (error) {
        console.error("Error updating project:", error);
    } finally {
        isEditing.value = false;
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
                        <i class="bi bi-pencil-square me-2"></i>Edit Contact
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
                            <label class="form-label">Client Name</label>
                            <select
                                v-model="newProjectData.client_id"
                                class="form-select stylish-input mb-3"
                            >
                                <option disabled value="">Default</option>
                                <option
                                    v-for=" client in clients"
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
                                v-model="newProjectData.title"
                                type="text"
                                placeholder="Title"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Description</label>
                            <input
                                v-model="newProjectData.description"
                                type="text"
                                placeholder="Description"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select
                                v-model="newProjectData.status"
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
                                v-model="newProjectData.deadline"
                                class="form-control"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-end">
                    <button
                        class="btn btn-outline-secondary"
                        @click="$emit('cancel')"
                    >
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                    <button
                        class="btn btn-primary"
                        @click="handleUpdate"
                        :disabled="isEditing"
                    >
                        <span v-if="isEditing">
                            <span
                                class="spinner-border spinner-border-sm me-1"
                            ></span>
                            Updating...
                        </span>
                        <span v-else>
                            <i class="bi bi-arrow-repeat me-1"></i>Update
                            Contact
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
