<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";

dayjs.extend(utc); // Enable UTC support

const props = defineProps({
    visible: Boolean,
    timeLog: Object,
});
const emit = defineEmits(["cancel", "edited"]);

const newTimeLogData = ref({
    id: "",
    start_time: "",
    end_time: "",
    description: "",
    tags: "",
});

// Convert API times to local for input fields
watch(
    () => props.timeLog,
    (newValue) => {
        if (newValue) {
            newTimeLogData.value = {
                ...newValue,
                start_time: dayjs
                    .utc(newValue.start_time)
                    .local()
                    .format("YYYY-MM-DDTHH:mm"),
                end_time: dayjs
                    .utc(newValue.end_time)
                    .local()
                    .format("YYYY-MM-DDTHH:mm"),
            };
        }
    },
    { immediate: true }
);

const isEditing = ref(false);

const handleUpdate = async () => {
    if (!newTimeLogData.value.id) {
        alert("No valid time log ID provided for update");
        return;
    }

    const start = dayjs(newTimeLogData.value.start_time);
    const end = dayjs(newTimeLogData.value.end_time);

    // ❗ Validation: start_time must be before end_time
    if (!start.isBefore(end)) {
        alert("Start time must be earlier than end time.");
        return;
    }

    isEditing.value = true;

    // Convert local datetime to UTC string before sending
    const dataToSend = {
        ...newTimeLogData.value,
        start_time: dayjs(newTimeLogData.value.start_time)
            .utc()
            .format("YYYY-MM-DD HH:mm:ss"),
        end_time: dayjs(newTimeLogData.value.end_time)
            .utc()
            .format("YYYY-MM-DD HH:mm:ss"),
    };

    try {
        const response = await axios.post(
            `/update-timelog/${newTimeLogData.value.id}`,
            dataToSend
        );
        if (response.status === 200) {
            emit("edited");
            alert("Time log updated successfully!");
        } else {
            alert(response.data.data);
            console.error("Error updating time log:", response.data.data);
        }
    } catch (error) {
        console.error("Error updating time log:", error);
    } finally {
        isEditing.value = false;
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
                        <div class="col-md-6">
                            <label class="form-label">Start Time</label>
                            <input
                                v-model="newTimeLogData.start_time"
                                type="datetime-local"
                                placeholder="Start Time"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Time</label>
                            <input
                                v-model="newTimeLogData.end_time"
                                type="datetime-local"
                                placeholder="End Time"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <input
                                v-model="newTimeLogData.description"
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
                                v-model="newTimeLogData.tags"
                                class="form-select"
                            >
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
                        @click.prevent="handleUpdate()"
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
>
