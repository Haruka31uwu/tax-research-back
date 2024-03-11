# API REST SLIM FRAMEWORK
## REQUIREMENTS
- PHP 7.0 or higher
- Composer
- MySQL
## INSTALLATION
- Clone the repository
- Go to the project folder
- Run `composer install`
- Create a database
- Configure the database connection in `src/Config.php`
- Configure the migrations system settings in `phinx.yml`
- Run `./vendor/bin/phinx migrate`
- Run `php -S localhost:9000 index.php`
- Frontend should be running on `http://localhost:3000` 
