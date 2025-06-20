<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import CreateProjectModal from "./CreateProjectModal.vue";
import EditProjectModal from "./EditProjectModal.vue";
import DeleteProjectModal from "./DeleteProjectModal.vue";
import DeleteAllModal from "./DeleteAllModal.vue";

const EasyDataTable = Vue3EasyDataTable;

const projects = ref([]);
const projectId=ref(null)
const search = ref("");
const searchField = ref("");
const editProjectData = ref({
    id: "",
    client_id: "",
    title: "",
    description: "",
    status: "",
    deadline: ""
});

// Modal visibility states
const createProjectModalVisible = ref(false);
const editProjectModalVisible = ref(false);
const deleteProjectModalVisible = ref(false);
const deleteAllModalVisible = ref(false);

const headers= [
    {text:"Client Name", value:"client.name"},
    {text:"Title", value:"title"},
    {text:"Description", value:"description"},
    {text:"Deadline", value:"deadline"},
    {text:"Status", value:"status"},
    {text:"Actions", value:"actions"},
];

const fetchProjects = async () => {
    try {
        const response = await axios.get("/get-all-projects");
        projects.value = response.data.data;
    } catch (error) {
        console.error("Error fetching Projects:", error);
    }
};

// Handle Create action
const handleCreate = () => {
    createProjectModalVisible.value = true;
};

const handleEdit = async (id) => {
    if (!id) {
        alert("No valid id provided for editing");
        console.error("No valid id provided for editing");
        return;
    }
      try{
        const response =await axios.get(`/get-project/${id}`);
        if (response.status === 200) {
            editProjectData.value = response.data.data;
            editProjectModalVisible.value = true;
        } else {
            alert(response.data.data);
            console.error("Error fetching client data:", response.data.data);
        }
    }catch (error) {
        console.error("Error handling edit:", error);
    }
};

const handleDelete = (id) => {
    if (!id) {
    alert("No valid id provided for deletion");
    console.error("No valid id provided for deletion");
    return;
  }
    projectId.value = id;
    deleteProjectModalVisible.value = true;
};

const handleDeleteAll = () => {
    deleteAllModalVisible.value = true;
};

// Call on component mount
onMounted(() => {
    fetchProjects();
});

</script>

<template>
<div class="card  bg-success-subtle border-success m-5 pb-5 shadow">
        <div class="card-header bg-success text-center text-white">
            <h5 class="mb-0">Project List</h5>
        </div>

        <div class="card-body">
            <Button
                @click.prevent="handleCreate()"
                class="btn hover-effect btn-outline-success shadow-sm mb-3"
            >
                <i class="bi bi-person-plus-fill me-1"></i> Add New Projects
            </Button>
            <Button
                @click.prevent="handleDeleteAll()"
                class="btn hover-effect btn-outline-danger shadow-sm mb-3 mx-2"
            >
                <i class="bi bi-trash"></i> Delete All Projects
            </Button>
            <div class="flex gap-3 mb-3">
                <!-- Select Field to Search By -->
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

                <!-- Search Input -->
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
                    <div class="d-flex justify-content-center gap-2">
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
                    </div>
                </template>
            </EasyDataTable>
        </div>

        <CreateProjectModal
            :visible="createProjectModalVisible"
            @cancel="createProjectModalVisible = false"
            @created="{ createProjectModalVisible = false; fetchProjects(); }"
        />
        <EditProjectModal
            :visible="editProjectModalVisible"
            :project="editProjectData"
            @cancel="editProjectModalVisible = false"
            @edited="{ editProjectModalVisible = false; fetchProjects(); }"
        />
        <DeleteProjectModal
            :visible="deleteProjectModalVisible"
            :projectId="projectId"
            @cancel="deleteProjectModalVisible = false"
            @deleted="{ deleteProjectModalVisible = false; fetchProjects(); }"
        />
        <DeleteAllModal
            :visible="deleteAllModalVisible"
            @cancel="deleteAllModalVisible = false"
            @deleted="{ deleteAllModalVisible = false; fetchProjects(); }"
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
    gap: 6px; /* ensures consistent spacing */
}
.hover-effect {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}
</style>
