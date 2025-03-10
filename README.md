# Smart Futures Assessment - Symfony Framework

This project is a code exercise submission for the Senior Software Developer position at Smart Futures, located at 6401 Penn Ave, Suite 300, Pittsburgh, PA 15206 (412.288.3900, info@smartfutures.org). It demonstrates proficiency in PHP, Symfony, Doctrine ORM, and API Platform as per the assessment requirements.

## Objective

Develop a PHP application using the following technology stack:
- **Symfony Framework**
- **Doctrine ORM**
- **API Platform** ([https://api-platform.com/](https://api-platform.com/))

This application is designed as a **read-only** GraphQL API, meaning GraphQL queries are required, but mutations are not necessary. Authentication is also not required for this assessment.

## Features & Requirements

### GraphQL Endpoint
- The application must expose a **GraphQL endpoint** at `/graphql`.
- The endpoint should allow querying the following entities stored in a database:
  - **Author**
  - **Book**
  - **Customer**
  - **Purchase**

### Database Schema
Using Doctrine ORM, the following entity relationships should be implemented:
- **Author**: Has multiple books.
- **Book**: Belongs to an author and can be purchased by customers.
- **Customer**: Can purchase multiple books.
- **Purchase**: Represents a customer’s book purchase.

### API & Data Access
- The GraphQL API must allow retrieving authors, books, customers, and purchases.
- Queries should be structured with appropriate entity relationships to fetch relevant data efficiently.
- No authentication or mutation support is required.

## Project Structure

The project is organized as follows:

```
smartfutures-symfony-assessment/
├── bin/                              # Symfony binary
├── config/                           # Configuration files
├── migrations/                       # Database migrations
├── public/                           # Web entry point (index.php)
├── src/                              # Application source code
│   ├── Controller/                   # Symfony controllers
│   ├── DataFixtures/                 # Database seeders
│   │   ├── AppFixtures.php           # Loads initial test data
│   ├── Entity/                       # Doctrine ORM entities
│   │   ├── Author.php                # Author entity
│   │   ├── Book.php                  # Book entity
│   │   ├── Customer.php              # Customer entity
│   │   ├── Purchase.php              # Purchase entity
│   ├── Repository/                   # Doctrine repositories for database queries
│   │   ├── AuthorRepository.php      # Query logic for authors
│   │   ├── BookRepository.php        # Query logic for books
│   │   ├── CustomerRepository.php    # Query logic for customers
│   │   ├── PurchaseRepository.php    # Query logic for purchases
│   ├── Kernel.php                     # Symfony application kernel
├── templates/                        # Twig templates (if applicable)
├── var/                              # Symfony cache and logs
├── vendor/                           # Composer dependencies
├── .env                              # Environment variables
├── .gitignore                        # Ignore unnecessary files
├── composer.json                     # PHP dependencies and scripts
├── composer.lock                     # Locked dependency versions
├── symfony.lock                      # Symfony version lockfile
└── README.md                         # Project documentation
```

## Installation & Setup

### Prerequisites
- **PHP 8.0+**
- **Composer**
- **Symfony CLI** (optional, recommended for running the project locally)
- **MySQL or PostgreSQL** (configured via `.env` file)

### Step-by-Step Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/smartfutures-symfony-assessment.git
   cd smartfutures-symfony-assessment
   ```
2. Ensure the `.env` file is set up:
   ```bash
   [ -f .env ] || cp .env.example .env && sed -i "s/GENERATE_YOUR_SECRET_HERE/$(php -r 'echo bin2hex(random_bytes(16));')/" .env
   ```
3. Install dependencies, optimize autoloading, create and migrate the database, load sample data, and start the Symfony server in a single command:
   ```bash
   composer install && composer dump-autoload -o && php bin/console doctrine:database:create && php bin/console doctrine:migrations:migrate && php bin/console doctrine:fixtures:load && symfony serve
   ```

### Alternative Step-by-Step Setup
1. Install dependencies:
   ```bash
   composer install
   ```
2. Optimize autoloading:
   ```bash
   composer dump-autoload -o
   ```
3. Ensure the database connection is set to SQLite in the `.env` file:
   ```bash
   DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
   ```
4. Create and migrate the database:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
5. Load sample data to populate the database:
   ```bash
   php bin/console doctrine:fixtures:load
   ```
6. Start the Symfony server:
   ```bash
   symfony serve
   ```
7. Access the GraphQL endpoint at:
   ```bash
   http://localhost:8000/graphql
   ```
8. Verify data exists in the database:
   ```bash
   php bin/console doctrine:query:sql "SELECT * FROM customer;"
   ```
   If no data is returned, reload fixtures:
   ```bash
   php bin/console doctrine:fixtures:load
   ```

## Available Commands

### Start Symfony Server
```bash
symfony serve
```

### Run Migrations
```bash
php bin/console doctrine:migrations:migrate
```

### Load Database Fixtures
```bash
php bin/console doctrine:fixtures:load
```

### Check GraphQL Schema
```bash
php bin/console debug:config api_platform
```

