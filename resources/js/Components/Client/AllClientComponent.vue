<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

import CreateClientModal from "./CreateClientModal.vue";
import DeleteAllModal from "./DeleteAllModal.vue";
import DeleteClientModal from "./DeleteClientModal.vue";
import EditClientModal from "./EditClientModal.vue";

import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

const EasyDataTable = Vue3EasyDataTable;

const clients = ref([]);
const clientId = ref(null);
const search = ref("");
const searchField = ref("");

const createClientModalVisible = ref(false);
const deleteAllModalVisible = ref(false);
const deleteModalVisible = ref(false);
const editModalVisible = ref(false);

const editClientData = ref({
    name: "",
    email: "",
    contact_person: "",
});

const headers = [
    { text: "Name", value: "name" },
    { text: "Email", value: "email" },
    { text: "Contact Person", value: "contact_person" },
    { text: "Actions", value: "actions", sortable: false, width: 180 },
];

const fetchClients = async () => {
    try {
        const response = await axios.get("/get-clients");
        clients.value = response.data.data;
    } catch (error) {
        console.error("Error fetching clients:", error);
    }
};

const handleCreate = () => {
    createClientModalVisible.value = true;
};

const handleDeleteALL = () => {
    deleteAllModalVisible.value = true;
};

const handleDelete = (id) => {
    if (!id) return;
    clientId.value = id;
    deleteModalVisible.value = true;
};

const handleEdit = async (id) => {
    if (!id) return;
    try {
        const response = await axios.get(`/get-client/${id}`);
        if (response.status === 200) {
            editClientData.value = response.data.data;
            editModalVisible.value = true;
        } else {
            alert(response.data.data);
        }
    } catch (error) {
        console.error("Error handling edit:", error);
    }
};

const projectPage = () => router.visit("/project");
const timeLogPage = () => router.visit("/timeLog");
const reportPage = () => router.visit("/report");

onMounted(() => {
    fetchClients();
});
</script>

<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-primary text-center shadow" role="alert">
                📢 <strong>NOTE:</strong> This table displays all registered
                clients. You can search by name, email, or contact person.
            </div>
        </div>
    </div>

    <div class="card bg-primary-subtle border-primary m-5 pb-5 shadow">
        <div class="card-header bg-primary text-white p-0">
            <h5 class="mb-0 py-3 text-center w-100">🚹 Client List</h5>
        </div>

        <div class="card-body">
            <!-- Action buttons -->
            <button
                @click.prevent="handleCreate()"
                class="btn hover-effect btn-primary shadow mb-3 me-3"
            >
                <i class="bi bi-person-plus-fill me-1"></i> Add New Contact
            </button>
            <button
                @click.prevent="projectPage()"
                class="btn hover-effect btn-success shadow mb-3 me-3"
            >
                <i class="bi bi-kanban"></i> Projects
            </button>
            <button
                @click.prevent="timeLogPage()"
                class="btn hover-effect btn-warning shadow mb-3 me-3"
            >
                <i class="bi bi-clock"></i> Time Logs
            </button>
            <button
                @click.prevent="reportPage()"
                class="btn hover-effect btn-info shadow mb-3 me-3"
            >
                <i class="bi bi-bar-chart-line"></i> Reports
            </button>
            <button
                @click.prevent="handleDeleteALL()"
                class="btn hover-effect btn-danger shadow mb-3 me-3"
            >
                <i class="bi bi-trash"></i> Delete All Clients
            </button>
            <button class="btn disabled hover-effect btn-primary shadow me-3 mb-3">
                <i class="bi bi-people-fill"></i> Clients
            </button>

            <!-- Filters -->
            <div class="flex gap-3 mb-3">
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
                :items="clients"
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
                <template #item-actions="{ id }">
                    <div
                        class="d-flex justify-content-center align-items-center flex-wrap gap-2"
                    >
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

        <!-- Modals -->
        <CreateClientModal
            :visible="createClientModalVisible"
            @cancel="createClientModalVisible = false"
            @created="
                () => {
                    createClientModalVisible = false;
                    fetchClients();
                }
            "
        />

        <EditClientModal
            :visible="editModalVisible"
            :client="editClientData"
            @cancel="editModalVisible = false"
            @edited="
                () => {
                    editModalVisible = false;
                    fetchClients();
                }
            "
        />

        <DeleteAllModal
            :visible="deleteAllModalVisible"
            @cancel="deleteAllModalVisible = false"
            @deleted="
                () => {
                    deleteAllModalVisible = false;
                    fetchClients();
                }
            "
        />

        <DeleteClientModal
            :visible="deleteModalVisible"
            :clientId="clientId"
            @cancel="deleteModalVisible = false"
            @deleted="
                () => {
                    deleteModalVisible = false;
                    fetchClients();
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
