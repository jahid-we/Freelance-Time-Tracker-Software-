<script setup>

</script>

<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">⏱ Manage Time Logs</h2>

    <!-- Action Buttons -->
    <div class="mb-4 d-flex flex-wrap gap-2">
      <button class="btn btn-primary">Start Time Log</button>
      <button class="btn btn-warning">End Time Log</button>
      <button class="btn btn-success">Manual Time Entry</button>
      <button class="btn btn-secondary">Update Time Log</button>
      <button class="btn btn-danger">Delete All Logs</button>
    </div>

    <!-- Search Filters -->
    <div class="card mb-4">
      <div class="card-header">🔍 Filter Logs</div>
      <div class="card-body row g-3">
        <div class="col-md-4">
          <label for="date" class="form-label">Date</label>
          <input type="date" id="date" class="form-control" />
        </div>
        <div class="col-md-4">
          <label for="project_id" class="form-label">Project ID</label>
          <input type="number" id="project_id" class="form-control" />
        </div>
        <div class="col-md-4">
          <label for="client_id" class="form-label">Client ID</label>
          <input type="number" id="client_id" class="form-control" />
        </div>
        <div class="col-md-6">
          <label for="from" class="form-label">From</label>
          <input type="date" id="from" class="form-control" />
        </div>
        <div class="col-md-6">
          <label for="to" class="form-label">To</label>
          <input type="date" id="to" class="form-control" />
        </div>
        <div class="col-12 text-end">
          <button class="btn btn-dark">Search</button>
        </div>
      </div>
    </div>

    <!-- Logs Table -->
    <div class="card">
      <div class="card-header">📋 Time Log Entries</div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Project</th>
              <th>Description</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Hours</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Placeholder rows -->
            <tr>
              <td>1</td>
              <td>Project A</td>
              <td>Worked on API</td>
              <td>2024-06-20 10:00</td>
              <td>2024-06-20 12:00</td>
              <td>2.00</td>
              <td>
                <button class="btn btn-sm btn-secondary">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
            <!-- More rows dynamically -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
