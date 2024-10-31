# PHP Login Application (PHP - MSSQL)

A simple PHP application with user authentication features, including login, sign-up, and logout. This application runs in a Docker environment for easy setup and deployment.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- **User Registration**: New users can create an account.
- **User Login**: Registered users can log in.
- **User Logout**: Users can log out securely.

## Installation

### Prerequisites

- Docker and Docker Compose should be installed on your machine.

### Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/kirucarlos/phpapp.git
   cd phpapp
   ```

2. **Database Credentials**:
   Ensure to adjust the necessary database credentials and other configurations (e.g., DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD) in the different files.

3. **Build and Run the Docker Container**:
   Run the following command to build and start the Docker containers:
   ```bash
   docker-compse build
   docker-compose up -d
   ```

4. **Access the Application**:
   The application should now be running at `http://localhost/app` (or whichever port you configured in the Docker setup).

## Usage

- **Sign Up**: Visit the sign-up page to create a new account.
- **Login**: Use the login page to access your account.
- **Logout**: Click the logout link to end your session.

## Contributing

Contributions are welcome!

## License

This project is licensed under the MIT License.

---

Let me know if you’d like any additional details added!
