<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

import CreateClientModal from "./CreateClientModal.vue";
import DeleteAllModal from "./DeleteAllModal.vue";
import DeleteClientModal from "./DeleteClientModal.vue";
import EditClientModal from "./EditClientModal.vue";

import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

const EasyDataTable = Vue3EasyDataTable;

const clients = ref([]);
const clientId=ref(null)
const search = ref("");
const searchField = ref("");

// Modal visibility states
const createClientModalVisible = ref(false);
const deleteAllModalVisible = ref(false);
const deleteModalVisible = ref(false);
const editModalVisible = ref(false);


// Table headers
const headers = [
    { text: "Name", value: "name" },
    { text: "Email", value: "email" },
    { text: "Contact Person", value: "contact_person" },
    { text: "Actions", value: "actions" },
];

// Edit Client Modal Data
const editClientData = ref({
    name: "",
    email: "",
    contact_person: "",
});

// Fetch clients from API
const fetchClients = async () => {
    try {
        const response = await axios.get("/get-clients");
        clients.value = response.data.data;
    } catch (error) {
        console.error("Error fetching clients:", error);
    }
};

// Handle Create action
const handleCreate =() => {
    createClientModalVisible.value = true;
};
const handleDeleteALL =() => {
    deleteAllModalVisible.value = true;
};
const handleDelete = (id) => {
    if (!id) {
    alert("No valid id provided for deletion");
    console.error("No valid id provided for deletion");
    return;
  }
    clientId.value = id;
    deleteModalVisible.value = true;
};
const handleEdit = async (id) => {
    if (!id) {
        alert("No valid id provided for editing");
        console.error("No valid id provided for editing");
        return;
    }
    try{
        const response =await axios.get(`/get-client/${id}`);
        if (response.status === 200) {
            editClientData.value = response.data.data;
            editModalVisible.value = true;
        } else {
            alert(response.data.data);
            console.error("Error fetching client data:", response.data.data);
        }
    }catch (error) {
        console.error("Error handling edit:", error);
    }
};

// Call on component mount
onMounted(() => {
    fetchClients();
});
</script>

<template>
    <div class="card  bg-primary-subtle border-primary m-5 pb-5 shadow">
        <div class="card-header bg-primary text-center text-white">
            <h5 class="mb-0">Client List</h5>
        </div>

        <div class="card-body">
            <Button
                @click.prevent="handleCreate()"
                class="btn hover-effect btn-outline-primary shadow-sm mb-3"
            >
                <i class="bi bi-person-plus-fill me-1"></i> Add New Contact
            </Button>
            <Button

                class="btn hover-effect btn-outline-success shadow-sm mb-3 mx-2"
            >
                <i class="bi bi-kanban"></i> Projects
            </Button>
            <Button

                class="btn hover-effect btn-outline-warning shadow-sm mb-3 mx-2 "
            >
                <i class="bi bi-clock"></i> Time Logs
            </Button>
            <Button

                class="btn hover-effect btn-outline-info shadow-sm mb-3 mx-2 "
            >
                <i class="bi bi-bar-chart-line"></i> Reports
            </Button>
            <Button
                @click.prevent="handleDeleteALL()"
                class="btn hover-effect btn-outline-danger shadow-sm mb-3 mx-2"
            >
                <i class="bi bi-trash"></i> Delete All Clients
            </Button>
            <div class="flex gap-3 mb-3">
                <!-- Select Field to Search By -->
                <select
                    v-model="searchField"
                    class="form-select stylish-input mb-3"
                    style="max-width: 150px"
                >
                    <option disabled value="">Default</option>
                    <option value="email">Email</option>
                    <option value="name">Name</option>
                    <option value="contact_person">Contact Person</option>
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
                :items="clients"
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
                            class="btn btn-sm btn-outline-primary"
                            @click="handleEdit(id)"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            @click="handleDelete(id)"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </template>
            </EasyDataTable>
        </div>
        <CreateClientModal
            :visible="createClientModalVisible"
            @cancel="createClientModalVisible = false"
            @created="() => { createClientModalVisible = false; fetchClients(); }"
        />

        <EditClientModal
            :visible="editModalVisible"
            :client="editClientData"
            @cancel="editModalVisible = false"
            @edited="() => { editModalVisible = false; fetchClients(); }"
        />

        <DeleteAllModal
            :visible="deleteAllModalVisible"
            @cancel="deleteAllModalVisible = false"
            @deleted="() => { deleteAllModalVisible = false; fetchClients(); }"
        />

        <DeleteClientModal
            :visible="deleteModalVisible"
            :clientId="clientId"
            @cancel="deleteModalVisible = false"
            @deleted="() => { deleteModalVisible = false; fetchClients(); }"
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
