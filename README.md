# Magento 2.4 Docker Setup

This repository provides a Docker-based development environment for Magento 2.4. It includes Nginx, PHP 7, MySQL, and Magento 2.

## Prerequisites

Before setting up the project, make sure you have the following software installed on your system:

- Docker
- Docker Compose

## Getting Started

To get started with the Magento 2.4 Docker setup, follow the steps below:

1. Clone this repository to your local machine:
    
2. Navigate into the project directory:
   cd magento2-docker

3. Update your hosts file:
- Open the hosts file on your local machine (not inside the Docker container).
- Add the following entry: `127.0.0.1 magento2.local`

4. Build and start the Docker containers:
   `docker-compose up -d`

5. Wait for the containers to start and the Magento installation to complete (this may take a few minutes).

6. Access Magento 2 in your web browser:
- Open `http://magento2.local` in your preferred web browser.

## Directory Structure

The project directory has the following structure:

- `src`: This directory contains the Magento 2 source code. You can modify or add files here.
- `nginx`: This directory contains the Nginx configuration file.
- `db_data`: This directory stores persistent MySQL data.

## Connecting to Containers

You can connect to the Docker containers using the following commands:

- Connect to the Nginx container:
  `docker-compose exec webserver bash`
  
- Connect to the PHP container:
   `docker-compose exec php bash`

- Connect to the MySQL container:
  `docker-compose exec db bash`

## Notes

- The MySQL data is persistent, meaning it will be retained even if you shut down and restart the Docker containers.
- If you make any changes to the Docker configuration or the Magento code, you may need to rebuild the containers using `docker-compose up -d --build`.

Feel free to explore and customize the setup according to your project requirements.

