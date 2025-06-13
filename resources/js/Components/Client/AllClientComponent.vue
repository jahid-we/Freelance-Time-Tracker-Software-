<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { computed } from "vue";

import CreateClientModal from "./CreateClientModal.vue";
import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

const EasyDataTable = Vue3EasyDataTable;

const clients = ref([]);
const search = ref("");
const searchField = ref("");

// Modal visibility states
const createClientModalVisible = ref(false);

// Table headers
const headers = [
    { text: "Name", value: "name" },
    { text: "Email", value: "email" },
    { text: "Contact Person", value: "contact_person" },
    { text: "Actions", value: "actions" },
];

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

// Call on component mount
onMounted(() => {
    fetchClients();
});
</script>

<template>
    <div class="card bg-primary-subtle border-primary m-5 pb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Client List</h5>
        </div>

        <div class="card-body">
            <Button
                @click.prevent="handleCreate"
                class="btn btn-outline-primary shadow-sm mb-3"
            >
                <i class="bi bi-person-plus-fill me-1"></i> Add New Contact
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
                <template #item-actions="{ item }">
                    <div class="d-flex justify-content-center gap-2">
                        <button
                            class="btn btn-sm btn-outline-primary"
                            @click="handleEdit(item)"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            @click="handleDelete(item)"
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
</style>
