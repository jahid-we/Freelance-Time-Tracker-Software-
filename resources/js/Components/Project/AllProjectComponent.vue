<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import CreateProjectModal from "./CreateProjectModal.vue";
import EditProjectModal from "./EditProjectModal.vue";
import DeleteProjectModal from "./DeleteProjectModal.vue";
import DeleteAllModal from "./DeleteAllModal.vue";
import TimeLogModal from "./TimeLogModal.vue";

const EasyDataTable = Vue3EasyDataTable;

const projects = ref([]);
const timeLogs = ref([]);
const activeLogs = ref({});
const projectId = ref(null);
const timeLogProjectId = ref(null);
const search = ref("");
const searchField = ref("");
const editProjectData = ref({
    id: "",
    client_id: "",
    title: "",
    description: "",
    status: "",
    deadline: "",
});

const createProjectModalVisible = ref(false);
const editProjectModalVisible = ref(false);
const deleteProjectModalVisible = ref(false);
const deleteAllModalVisible = ref(false);
const timeLogModalVisible = ref(false);

const headers = [
    { text: "Client Name", value: "client.name" },
    { text: "Title", value: "title" },
    { text: "Description", value: "description" },
    { text: "Deadline", value: "deadline" },
    { text: "Status", value: "status" },
    { text: "Actions", value: "actions", sortable: false, width: 200 },
];

const fetchProjects = async () => {
    try {
        const response = await axios.get("/get-all-projects");
        projects.value = response.data.data;
    } catch (error) {
        console.error("Error fetching Projects:", error);
    }
};

const fetchTimeLogs = async () => {
    try {
        const response = await axios.get("/get-timelogs");
        timeLogs.value = response.data.data;
        activeLogs.value = {};

        timeLogs.value.forEach((log) => {
            if (log.is_running === 1) {
                activeLogs.value[log.project_id] = true;
            }
        });
    } catch (error) {
        console.error("Error fetching Time Logs:", error);
    }
};

const startTimeLog = async (id) => {
    if (!id) {
        alert("Invalid project ID");
        return;
    }
    timeLogProjectId.value = id;
    timeLogModalVisible.value = true;
};

const stopTimeLog = async (id) => {
    try {
        const response = await axios.post(`end-timelog/${id}`);
        if (response.status === 200) {
            alert("Time log stopped Successfully!");
            await fetchTimeLogs();
            await fetchProjects();
        }
    } catch (error) {
        console.error("Stop error", error);
    }
};

const handleCreate = () => {
    createProjectModalVisible.value = true;
};

const handleEdit = async (id) => {
    if (!id) return;
    try {
        const response = await axios.get(`/get-project/${id}`);
        if (response.status === 200) {
            editProjectData.value = response.data.data;
            editProjectModalVisible.value = true;
        } else {
            alert(response.data.data);
        }
    } catch (error) {
        console.error("Error handling edit:", error);
    }
};

const handleDelete = (id) => {
    if (!id) return;
    projectId.value = id;
    deleteProjectModalVisible.value = true;
};

const handleDeleteAll = () => {
    deleteAllModalVisible.value = true;
};

const handleClients = () => {
    router.visit("/client");
};

const handleTimeLogs = () => {
    router.visit("/timeLog");
};

onMounted(() => {
    fetchTimeLogs();
    fetchProjects();
});
</script>

<template>
    <div class="card bg-success-subtle border-success m-5 pb-5 shadow">
        <div class="card-header bg-success text-white p-0">
            <h5 class="mb-0 py-3 text-center w-100">Project List</h5>
        </div>

        <div class="card-body">
            <Button
                @click.prevent="handleCreate()"
                class="btn hover-effect btn-success shadow mb-3"
            >
                <i class="bi bi-kanban"></i> Add New Projects
            </Button>
            <Button
                @click.prevent="handleClients()"
                class="btn hover-effect btn-primary shadow mb-3 mx-2"
            >
                <i class="bi bi-people-fill"></i> Clients
            </Button>
            <Button
                @click.prevent="handleTimeLogs()"
                class="btn hover-effect btn-warning shadow mb-3 mx-2"
            >
                <i class="bi bi-clock"></i> Time Logs
            </Button>
            <Button class="btn hover-effect btn-info shadow mb-3 mx-2">
                <i class="bi bi-bar-chart-line"></i> Reports
            </Button>
            <Button
                @click.prevent="handleDeleteAll()"
                class="btn hover-effect btn-danger shadow mb-3 mx-2"
            >
                <i class="bi bi-trash"></i> Delete All Projects
            </Button>

            <div class="flex gap-3 mb-3">
                <select
                    v-model="searchField"
                    class="form-select stylish-input mb-3"
                    style="max-width: 150px"
                >
                    <option disabled value="">Default</option>
                    <option value="client.name">Client Name</option>
                    <option value="title">Title</option>
                    <option value="description">Description</option>
                    <option value="deadline">Deadline</option>
                    <option value="status">Status</option>
                </select>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search..."
                    class="form-control stylish-input"
                />
            </div>

            <EasyDataTable
                buttons-pagination
                :headers="headers"
                :items="projects"
                :search-value="search"
                :search-field="searchField"
                :items-per-page="5"
                :rows-per-page="10"
                show-index
                table-class-name="custom-table"
            >
                <template #item-actions="{ id }">
                    <div
                        class="d-flex justify-content-center align-items-center flex-wrap gap-1"
                    >
                        <button
                            class="btn btn-sm btn-outline-success"
                            @click.prevent="handleEdit(id)"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            @click.prevent="handleDelete(id)"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                        <button
                            v-if="!activeLogs[id]"
                            class="btn btn-sm btn-outline-primary"
                            @click.prevent="startTimeLog(id)"
                        >
                            <i class="bi bi-play-fill"></i> Start
                        </button>
                        <button
                            v-if="activeLogs[id]"
                            class="btn btn-sm btn-outline-danger"
                            @click.prevent="stopTimeLog(id)"
                        >
                            <i class="bi bi-stop-fill"></i> Stop
                        </button>
                    </div>
                </template>
            </EasyDataTable>
        </div>

        <CreateProjectModal
            :visible="createProjectModalVisible"
            @cancel="createProjectModalVisible = false"
            @created="
                {
                    createProjectModalVisible = false;
                    fetchProjects();
                }
            "
        />
        <EditProjectModal
            :visible="editProjectModalVisible"
            :project="editProjectData"
            @cancel="editProjectModalVisible = false"
            @edited="
                {
                    editProjectModalVisible = false;
                    fetchProjects();
                }
            "
        />
        <DeleteProjectModal
            :visible="deleteProjectModalVisible"
            :projectId="projectId"
            @cancel="deleteProjectModalVisible = false"
            @deleted="
                {
                    deleteProjectModalVisible = false;
                    fetchProjects();
                }
            "
        />
        <DeleteAllModal
            :visible="deleteAllModalVisible"
            @cancel="deleteAllModalVisible = false"
            @deleted="
                {
                    deleteAllModalVisible = false;
                    fetchProjects();
                }
            "
        />
        <TimeLogModal
            :visible="timeLogModalVisible"
            :projectId="timeLogProjectId"
            @cancel="timeLogModalVisible = false"
            @created="
                {
                    timeLogModalVisible = false;
                    fetchTimeLogs();
                    fetchProjects();
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
