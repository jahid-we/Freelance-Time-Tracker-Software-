<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const date = ref("");
const from = ref("");
const to = ref("");
const clients = ref([]);
const client_id = ref("");
const projects = ref([]);
const project_id = ref("");
const tag = ref("");
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

// Fetch all projects
const fetchProjects = async () => {
    try {
        const response = await axios.get("/get-all-projects");
        if (response.status === 200) {
            projects.value = response.data.data;
        } else {
            alert("⚠ " + response.data.data);
        }
    } catch (error) {
        console.error("Error fetching Projects:", error);
        alert("❌ Failed to fetch projects.");
    }
};


// Export PDF using current filters
const exportPdf = () => {
    const params = new URLSearchParams();
    if (date.value) params.append("date", date.value);
    if (from.value) params.append("from", from.value);
    if (to.value) params.append("to", to.value);
    if (client_id.value) params.append("client_id", client_id.value);
    if (project_id.value) params.append("project_id", project_id.value);
    if (tag.value) params.append("tag", tag.value);

    const url = `/export-pdf?${params.toString()}`;
    window.open(url, "_blank");
};

// Reset all filters
const clearFilters = () => {
    date.value = "";
    from.value = "";
    to.value = "";
    client_id.value = "";
    project_id.value = "";
    tag.value = ""; // reset tag
    totalHours.value = null;
};

const projectPage = () => router.visit("/project");
const timeLogPage = () => router.visit("/timeLog");
const clientPage = () => router.visit("/client");

// On mount, load clients and projects
onMounted(() => {
    fetchClients();
    fetchProjects();
});
</script>

<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8">
            <div
                class="alert alert-info text-center shadow-sm mb-2 shadow"
                role="alert"
            >
                📢 <strong>NOTE:</strong> Use the options below to generate and
                export a PDF report of your time logs based on selected filters.
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <!-- Navigation Buttons -->
        <Button
            @click.prevent="clientPage()"
            class="btn hover-effect btn-primary shadow me-3 mb-3"
        >
            <i class="bi bi-people-fill"></i> Clients
        </Button>
        <Button
            @click.prevent="projectPage()"
            class="btn hover-effect btn-success shadow mb-3 me-3"
        >
            <i class="bi bi-kanban"></i> Projects
        </Button>
        <Button
            @click.prevent="timeLogPage()"
            class="btn hover-effect btn-warning shadow mb-3 me-3"
        >
            <i class="bi bi-clock"></i> Time Logs
        </Button>
        <Button disabled class="btn hover-effect btn-info shadow mb-3 me-3">
            <i class="bi bi-bar-chart-line"></i> Reports
        </Button>

        <!-- Filter Card -->
        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0 py-3 text-center w-100">
                    Get PDF Of Time Logs
                </h5>
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
                    <div class="col-md-4">
                        <label class="form-label">Tag</label>
                        <select v-model="tag" class="form-select">
                            <option value="">Default</option>
                            <option value="billable">Billable</option>
                            <option value="non-billable">Non-billable</option>
                        </select>
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
                                class="btn btn-info ms-2"
                                @click="exportPdf"
                            >
                                <i class="bi bi-file-earmark-pdf"></i> Export
                                PDF
                            </button>
                            <button
                                class="btn btn-outline-secondary ms-2"
                                @click="clearFilters"
                            >
                                <i class="bi bi-x-circle"></i> Clear Fields
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.hover-effect {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}
</style>
