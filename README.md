# Vending Machine CLI Application

## Description

This application simulates a vending machine interface via command line. It allows users to input coins, select a
product, and receive the appropriate change. The application is built using Symfony Console and is designed to provide
an interactive CLI experience for managing vending machine operations. It supports multiple coin denominations and
product selections.

## Features

- **Insert Coins**: Users can input multiple coin denominations.
- **Select Product**: Users choose a product by its unique code.
- **Calculate Change**: The application calculates the minimum number of coins to be returned as change.
- **Error Handling**: Provides error messages for insufficient funds or invalid inputs.

## How to Use

1. **Start the Application**: Run the vending machine command:
   ```bash
   php bin/console app:vending-machine
    ```
2. **Insert Coins**: Enter the coin denominations (e.g., 1, 2, 5, 10, 20, 50, 100).
3. **Select Product**: Choose a product by entering its unique code (e.g., A, B, C).
4. **Receive Change**: The application will display the change in coins to be returned.

## Setup Instructions

### Prerequisites

- Docker
- Docker Compose
- PHP 8.0 or higher (for local setup without Docker)

### Running with Docker

1. **Build the Docker image and start the container:**

   Navigate to the project's root directory and run:
    ```bash
    docker-compose -f .docker/docker-compose.yml up --build
    ```

2. **Access the container shell:**
   ```bash
    docker exec -it vending-machine-app bash
    ```

3. **install dependencies:**
    ```bash
    composer install
    ```

4. **Run the vending machine command:**
    ```bash
    php bin/console app:vending-machine
    ```

### Running Locally

1. **Install dependencies:**

   Navigate to the project's root directory and run:
    ```bash
    composer install
    ```

2. **Run the vending machine command:**
    ```bash
    php bin/console app:vending-machine
    ```

## Testing

To run the test suite, execute the following command:

```bash
php bin/phpunit
```

Make sure everything is green :white_check_mark: