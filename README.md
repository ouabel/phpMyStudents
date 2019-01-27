# Setup
### 1. Clone repository
`git clone https://github.com/ouabel/phpMyStudents.git`
### 2. Install dependencies
`composer install`
### 3. Config database
Edit `.env` or create `.env.local`
### 4. Create database
`php bin/console doctrine:database:create`
### 5. Run migrations
`php bin/console doctrine:migrations:migrate`
### 6. Load Fixtures
`php bin/console doctrine:fixtures:load`
### 7. Run server
`php bin/console server:run`
