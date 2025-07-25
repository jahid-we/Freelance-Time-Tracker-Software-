<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";

dayjs.extend(utc); // Enable UTC support

const props = defineProps({
    visible: Boolean,
});
const emit = defineEmits(["cancel", "created"]);
const projects = ref([]);
const projectId = ref(null);

const fetchProjects = async () => {
    try {
        const response = await axios.get("/get-all-projects");
        projects.value = response.data.data;

        // Set first project as default if exists
        if (projects.value.length > 0) {
            projectId.value = projects.value[0].id;
        }
    } catch (error) {
        console.error("Error fetching Projects:", error);
    }
};

const form = ref({
    start_time: "",
    end_time: "",
    description: "",
    tags: "",
});

const isCreating = ref(false);

const handleCreate = async () => {
    const start = dayjs(form.value.start_time);
    const end = dayjs(form.value.end_time);

    // ❗ Validation: start_time must be before end_time
    if (!start.isBefore(end)) {
        alert("Start time must be earlier than end time.");
        return;
    }

    isCreating.value = true;

    // Convert local datetime to UTC string before sending
    const dataToSend = {
        ...form.value,
        start_time: dayjs(form.value.start_time)
            .utc()
            .format("YYYY-MM-DD HH:mm:ss"),
        end_time: dayjs(form.value.end_time)
            .utc()
            .format("YYYY-MM-DD HH:mm:ss"),
    };

    try {
        const response = await axios.post(
            `/manual-entry/${projectId.value}`,
            dataToSend
        );
        if (response.status === 201) {
            form.value = {
                start_time: "",
                end_time: "",
                description: "",
                tags: "",
            };
            // Set first project as default if exists
            if (projects.value.length > 0) {
            projectId.value = projects.value[0].id;
            }
            emit("created");
            alert("Time log created successfully!");
        } else {
            alert(response.data.data);
            console.error("Error updating time log:", response.data.data);
        }
    } catch (error) {
        console.error("Error updating time log:", error);
    } finally {
        isCreating.value = false;
    }
};

onMounted(() => {
    fetchProjects();
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
                        <i class="bi bi-pencil-square me-2"></i>Manually Time
                        Log Entry
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
                            <label class="form-label">Select Project</label>
                            <select
                                v-model="projectId"
                                class="form-select stylish-input mb-3"
                            >
                                <option disabled>Default</option>
                                <option
                                    v-for="project in projects"
                                    :key="project.id"
                                    :value="project.id"
                                >
                                    {{ project.title }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Time</label>
                            <input
                                v-model="form.start_time"
                                type="datetime-local"
                                placeholder="Start Time"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Time</label>
                            <input
                                v-model="form.end_time"
                                type="datetime-local"
                                placeholder="End Time"
                                class="form-control"
                            />
                        </div>
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
                            <select v-model="form.tags" class="form-select">
                                <option disabled value="">Select Type</option>
                                <option value="billable">Billable</option>
                                <option value="non-billable">
                                    Non-Billable
                                </option>
                            </select>
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
                        @click="handleCreate()"
                        :disabled="isCreating"
                    >
                        <span v-if="isCreating">
                            <span
                                class="spinner-border spinner-border-sm me-1"
                            ></span>
                            Updating...
                        </span>
                        <span v-else>
                            <i class="bi bi-arrow-repeat me-1"></i>Create Time
                            Log
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
>
