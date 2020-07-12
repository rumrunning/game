# Rum Running Game
A text-based PHP game built using Laravel.

### Setup
```bash
cp .env.example .env

# Add commposer token to the .env file
# https://github.com/settings/tokens/new?description=rum-running-dev
nano .env

# Build images
docker-compose build --build-arg=COMPOSER_TOKEN={YOUR_TOKEN_HERE}

# Install vendor files
docker-compose run app composer install

# Set the application key
docker-compose run app php artisan key:generate

# Now run
docker-compose up

# In another terminal SSH into the app container
docker-compose exec app bash

# Run migrations within the app container
php artisan migrate:fresh --seed
```