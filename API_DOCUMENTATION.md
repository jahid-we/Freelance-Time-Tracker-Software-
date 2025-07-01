### Authentication Routes

- **POST** `/register`  
  Register a new user.

- **POST** `/login`  
  Log in an existing user.

- **POST** `/reset-password-email`  
  Send reset password link to the user's email.

- **POST** `/reset-password`  
  Reset the user's password using a token.

- **GET** `/logout`  
  Log out the authenticated user.

---

### User Profile Routes

- **GET** `/get-user-profile`  
  Get the profile details of the authenticated user.

- **POST** `/update-user-profile`  
  Update the profile of the authenticated user.

- **POST** `/update-user-password`  
  Update the password of the authenticated user.

---

### Client Routes

- **POST** `/create-client`  
  Create a new client.

- **GET** `/get-clients`  
  Get a list of all clients.

- **GET** `/get-client/{id}`  
  Get details of a specific client by ID.

- **POST** `/update-client/{id}`  
  Update a specific client by ID.

- **DELETE** `/delete-client/{id}`  
  Delete a specific client by ID.

- **DELETE** `/delete-all-clients`  
  Delete all clients.

---

### Project Routes

- **POST** `/create-project`  
  Create a new project.

- **GET** `/get-all-projects`  
  Get a list of all projects.

- **GET** `/get-project/{id}`  
  Get details of a specific project by ID.

- **POST** `/update-project/{id}`  
  Update a specific project by ID.

- **DELETE** `/delete-project/{id}`  
  Delete a specific project by ID.

- **DELETE** `/delete-all-projects`  
  Delete all projects.

- **GET** `/get-projects-by-client/{clientId}`  
  Get all projects related to a specific client.

---

### Time Log Routes

- **POST** `/start-timelog/{projectId}`  
  Start tracking time for a specific project.

- **POST** `/end-timelog/{projectId}`  
  End time tracking for a specific project.

- **POST** `/manual-entry/{projectId}`  
  Manually enter time for a project.

- **GET** `/get-timelogs`  
  Get a list of all time logs.

- **GET** `/get-timelog/{id}`  
  Get details of a specific time log by ID.

- **POST** `/update-timelog/{id}`  
  Update a specific time log by ID.

- **DELETE** `/delete-timelog/{id}`  
  Delete a specific time log by ID.

- **DELETE** `/delete-all-timelogs`  
  Delete all time logs.

---

### Report Routes

- **GET** `/search?date=YYYY-MM-DD`  
  Get all time logs for a specific date.

- **GET** `/search?client_id=id&date=YYYY-MM-DD`  
  Get time logs for a specific client on a specific date.

- **GET** `/search?project_id=id&date=YYYY-MM-DD`  
  Get time logs for a specific project on a specific date.

- **GET** `/search?from=YYYY-MM-DD&to=YYYY-MM-DD`  
  Get time logs within a specific date range.

- **GET** `/search?client_id=id&from=YYYY-MM-DD&to=YYYY-MM-DD`  
  Get time logs for a specific client within a date range.

- **GET** `/search?project_id=id&from=YYYY-MM-DD&to=YYYY-MM-DD`  
  Get time logs for a specific project within a date range.

---

### Export PDF Routes

- **GET** `/export-pdf`  
  Get all time logs in a PDF format.

- **GET** `/export-pdf?date=YYYY-MM-DD`  
  Get all time logs for a specific date in a PDF format.

- **GET** `/export-pdf?client_id=id&date=YYYY-MM-DD`  
  Get time logs for a specific client on a specific date in a PDF format.

- **GET** `/export-pdf?project_id=id&date=YYYY-MM-DD`  
  Get time logs for a specific project on a specific date in a PDF format.

- **GET** `/export-pdf?from=YYYY-MM-DD&to=YYYY-MM-DD`  
  Get time logs within a specific date range in a PDF format.

- **GET** `/export-pdf?client_id=id&from=YYYY-MM-DD&to=YYYY-MM-DD`  
  Get time logs for a specific client within a date range in a PDF format.

- **GET** `/export-pdf?project_id=id&from=YYYY-MM-DD&to=YYYY-MM-DD`  
  Get time logs for a specific project within a date range in a PDF format.

- **GET** `/export-pdf?tag=billable`  
  Get time logs for the **billable** tag in a PDF format.

- **GET** `/export-pdf?tag=non-billable`  
  Get time logs for the **non-billable** tag in a PDF format.

---

### Page Routes

#### Home Page Routes

- **GET** `/`  
  Load the home page.

#### Authentication Page Routes

- **GET** `/registerPage`  
  Load the registration page.

- **GET** `/login`  
  Load the login page.

- **GET** `/reset-link`  
  Load the reset password email page.

- **GET** `/reset-password/{token}`  
  Load the reset password page using a token.

#### User Profile Page Routes

- **GET** `/profile`  
  Load the user profile page.

#### Dashboard Page Routes

- **GET** `/dashboard`  
  Load the dashboard page.

#### Client Page Routes

- **GET** `/client`  
  Load the client page.

#### Project Page Routes

- **GET** `/project`  
  Load the project page.

#### Time Log Page Routes

- **GET** `/timeLog`  
  Load the time log page.

#### Report Page Routes

- **GET** `/search`  
  Load the report page.

---

### Authentication Details

- **Middleware:**
  - Routes with `/auth` are protected by the **`auth`** middleware (token-based authentication).
  - Routes with `/guest` are available for unauthenticated users.
