<script setup>
import { ref,onMounted } from "vue";
import axios from "axios";

const date = ref("");
const from = ref("");
const to = ref("");
const clients = ref([]);
const client_id = ref("");
const projects = ref([]);
const project_id = ref("");
const totalHours = ref(null);
const loading = ref(false);

// Fetch clients from API
const fetchClients = async () => {
    try {
        const response = await axios.get("/get-clients");
        if (response.status === 200) {
            clients.value = response.data.data;
        } else {
            alert("⚠ " + response.data.data);
        }
    } catch (error) {
        console.error("Error fetching clients:", error);
        alert("❌ Failed to fetch clients.");
    }
};

// Fetch projects based on selected client

const fetchProjects = async () => {
    try {
        const response = await axios.get("/get-all-projects");
        if (response.status === 200) {
            projects.value = response.data.data;
        }else {
            alert("⚠ " + response.data.data);
        }
    } catch (error) {
        console.error("Error fetching Projects:", error);
        alert("❌ Failed to fetch projects.");
    }
};

const fetchLogs = async () => {
    loading.value = true;
    totalHours.value = null;

    // Build dynamic params
    const params = {};
    if (date.value) params.date = date.value;
    if (from.value) params.from = from.value;
    if (to.value) params.to = to.value;
    if (client_id.value) params.client_id = client_id.value;
    if (project_id.value) params.project_id = project_id.value;

    try {
        const response = await axios.get("/search", { params });

        if (response.data.success) {
            totalHours.value = response.data.data.formatted;
        } else {
            alert("⚠ " + response.data.message);
        }
    } catch (error) {
        console.error(error);
        alert("❌ Failed to fetch total hours.");
    } finally {
        loading.value = false;
    }
};

// Reset filters and data
const clearFilters = () => {
    date.value = "";
    from.value = "";
    to.value = "";
    client_id.value = "";
    project_id.value = "";
    totalHours.value = null;
};

// Fetch clients on component mount
onMounted(() => {
    fetchClients();
    fetchProjects();
});

</script>

<template>
    <div class="container mt-5">
        <!-- Filter Form -->
        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0 py-3 text-center w-100">🔍 Filter Logs</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input
                            type="date"
                            v-model="date"
                            class="form-control"
                        />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Select Project</label>
                        <select
                            v-model="project_id"
                            class="form-select stylish-input mb-3"
                        >
                            <option disabled value="">Default</option>
                            <option
                                v-for="project in projects"
                                :key="project.id"
                                :value="project.id"
                            >
                                {{ project.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Select Client</label>
                        <select
                            v-model="client_id"
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
                    <div class="col-md-6">
                        <label class="form-label">From</label>
                        <input
                            type="date"
                            v-model="from"
                            class="form-control"
                        />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">To</label>
                        <input type="date" v-model="to" class="form-control" />
                    </div>
                    <div
                        class="col-12 d-flex justify-content-between align-items-center"
                    >
                        <div v-if="totalHours !== null" class="text-success">
                            ✅ Total Logged Hours:
                            <strong>{{ totalHours }}</strong>
                        </div>
                        <div class="text-end">
                            <button
                                class="btn btn-dark"
                                @click="fetchLogs"
                                :disabled="loading"
                            >
                                <span v-if="loading">🔄 Loading...</span>
                                <span v-else>🔍 Search</span>
                            </button>
                            <button
                                class="btn btn-outline-secondary ms-2"
                                @click="clearFilters"
                            >
                                <i class="bi bi-x-circle"></i> Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
