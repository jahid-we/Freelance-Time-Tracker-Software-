<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import dayjs from "dayjs";

import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import CreateTimeLogModal from "./CreateTimeLogModal.vue";
import EditTimeLogModal from "./EditTimeLogModal.vue";
import DeleteTimeLogModal from "./DeleteTimeLogModal.vue";
import DeleteAllModal from "./DeleteAllModal.vue";

const EasyDataTable = Vue3EasyDataTable;

const createTimeLogModalVisible = ref(false);
const editTimeLogModalVisible = ref(false);
const deleteTimeLogModalVisible = ref(false);
const deleteAllModalVisible = ref(false);

const timeLogs = ref([]);
const timeLogId = ref(null);
const search = ref("");
const searchField = ref("");

const headers = [
    { text: "Client", value: "project.client.name" },
    { text: "Project", value: "project.title" },
    { text: "Project Description", value: "project.description" },
    { text: "TimeLog Description", value: "description" },
    { text: "Start Time", value: "start_time" },
    { text: "End Time", value: "end_time" },
    { text: "Total Hours", value: "hours" },
    { text: "Billable/Non-Billable", value: "tags" },
    { text: "Actions", value: "actions", sortable: false, width: 180 },
];

const fetchTimeLogs = async () => {
    try {
        const response = await axios.get("/get-timelogs");
        timeLogs.value = response.data.data;
    } catch (error) {
        console.error("Error fetching time logs:", error);
    }
};
const handleCreateModal = () => {
    createTimeLogModalVisible.value = true;
};

const editTimeLogData = ref({});
const handleEditModal = async (id) => {
    if (!id) {
        alert("Invalid Time Log ID");
        return;
    }
    try {
        const response = await axios.get(`/get-timelog/${id}`);
        if (response.status === 200) {
            editTimeLogData.value = response.data.data;
            editTimeLogModalVisible.value = true;
        } else {
            console.error("Failed to fetch time log data");
        }
    } catch (error) {
        console.error("Error fetching time log data:", error);
    }
};

const handleDeleteModal = (id) => {
    if (!id) {
        alert("Invalid Time Log ID");
        return;
    }
    timeLogId.value = id;
    deleteTimeLogModalVisible.value = true;
};

const handleDeleteAllModal = () => {
    deleteAllModalVisible.value = true;
};

// Handle navigation

const clientPage = () => router.visit("/client");
const projectPage = () => router.visit("/project");
const reportPage = () => router.visit("/report");

onMounted(() => {
    fetchTimeLogs();
});
</script>

<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8">
            <div
                class="alert alert-warning text-center shadow-sm mb-4"
                role="alert"
            >
                📢 <strong>NOTE:</strong> This table shows all
                manual and running time entries. You can search by
                <em>client</em>, <em>project</em>, <em>description</em>,
                <em>tags</em>, or <em>time range</em>.
            </div>
        </div>
    </div>
    <div class="card bg-warning-subtle border-warning m-5 pb-5 shadow">
        <div class="card-header bg-warning text-white p-0">
            <h5 class="mb-0 py-3 text-center w-100">⏱ Manage Time Logs</h5>
        </div>

        <div class="card-body">
            <!-- Action buttons -->
            <button
                @click.prevent="handleCreateModal()"
                class="btn hover-effect btn-primary shadow mb-3 "
            >
                <i class="bi bi-clock"></i> Manually Add Time Log
            </button>
            <button
                @click.prevent="clientPage()"
                class="btn hover-effect btn-primary shadow mb-3 mx-2"
            >
                <i class="bi bi-people-fill"></i> Clients
            </button>
            <button
                @click.prevent="projectPage()"
                class="btn hover-effect btn-success shadow mb-3 mx-2"
            >
                <i class="bi bi-kanban"></i> Projects
            </button>
            <button @click.prevent="reportPage()" class="btn hover-effect btn-info shadow mb-3 mx-2">
                <i class="bi bi-bar-chart-line"></i> Reports
            </button>
            <button
                @click.prevent="handleDeleteAllModal()"
                class="btn hover-effect btn-danger shadow mb-3 mx-2"
            >
                <i class="bi bi-trash"></i> Delete All Time Logs
            </button>
            <button class="btn disabled hover-effect btn-warning shadow mx-2 mb-3">
                <i class="bi bi-clock"></i> Time Logs
            </button>

            <!-- Filters -->
            <div class="flex gap-3 mb-3">
                <select
                    v-model="searchField"
                    class="form-select stylish-input mb-3"
                    style="max-width: 150px"
                >
                    <option disabled value="">Default</option>
                    <option value="project.client.name">Client</option>
                    <option value="project.title">Project</option>
                    <option value="description">TimeLog Description</option>
                    <option value="start_time">Start Time</option>
                    <option value="end_time">End Time</option>
                    <option value="hours">Total Hours</option>
                    <option value="tags">Billable/Non-Billable</option>
                </select>

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search..."
                    class="form-control stylish-input"
                />
            </div>

            <!-- Data Table -->
            <EasyDataTable
                buttons-pagination
                :headers="headers"
                :items="timeLogs"
                table-class="table table-bordered"
                header-text-direction="left"
                body-text-direction="left"
                alternating
                theme-color="#0d6efd"
                :search-value="search"
                :search-field="searchField"
                :items-per-page="5"
                :rows-per-page="10"
                show-index
                table-class-name="custom-table"
            >
                <template #item-start_time="{ start_time }">
                    {{ dayjs(start_time).format("MMM D, YYYY h:mm A") }}
                </template>

                <template #item-end_time="{ end_time }">
                    {{ dayjs(end_time).format("MMM D, YYYY h:mm A") }}
                </template>
                <template #item-actions="{ id }">
                    <div
                        class="d-flex justify-content-center align-items-center flex-wrap gap-2"
                    >
                        <button
                            @click.prevent="handleEditModal(id)"
                            class="btn btn-sm btn-outline-warning"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button
                            @click.prevent="handleDeleteModal(id)"
                            class="btn btn-sm btn-outline-danger"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </template>
            </EasyDataTable>
        </div>
        <CreateTimeLogModal
            :visible="createTimeLogModalVisible"
            @cancel="createTimeLogModalVisible = false"
            @created="
                {
                    createTimeLogModalVisible = false;
                    fetchTimeLogs();
                }
            "
        />
        <EditTimeLogModal
            :visible="editTimeLogModalVisible"
            :timeLog="editTimeLogData"
            @cancel="editTimeLogModalVisible = false"
            @edited="
                {
                    editTimeLogModalVisible = false;
                    fetchTimeLogs();
                }
            "
        />
        <DeleteTimeLogModal
            :visible="deleteTimeLogModalVisible"
            :timeLogId="timeLogId"
            @cancel="deleteTimeLogModalVisible = false"
            @deleted="
                {
                    deleteTimeLogModalVisible = false;
                    fetchTimeLogs();
                }
            "
        />
        <DeleteAllModal
            :visible="deleteAllModalVisible"
            @cancel="deleteAllModalVisible = false"
            @deleted="
                {
                    deleteAllModalVisible = false;
                    fetchTimeLogs();
                }
            "
        />
    </div>
</template>

<style scoped>
.custom-table {
    width: 100%;
    overflow-x: auto;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    font-family: "Poppins", sans-serif;
}

@media (max-width: 768px) {
    .custom-table {
        display: block;
        white-space: nowrap;
    }
}

.custom-table thead th {
    background-color: #f8f9fa;
    color: #333;
    font-weight: 600;
    font-size: 15px;
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #dee2e6;
}

.custom-table tbody td {
    font-size: 14px;
    color: #555;
    padding: 14px 10px;
    vertical-align: middle;
    text-align: center;
}

/* Ensure last column ("Actions") is centered */
.custom-table thead th:last-child,
.custom-table tbody td:last-child {
    text-align: center !important;
    vertical-align: middle;
}

.custom-table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

.stylish-input {
    font-size: 16px;
    padding: 10px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.d-flex.gap-2 {
    gap: 6px;
}

.hover-effect {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}
</style>
