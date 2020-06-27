# Rum Running Game
A text-based PHP game build using Laravel.

### Setup
```bash
cp .env.example .env

# Add commposer token to the .env file
# https://github.com/settings/tokens/new?description=rum-running-dev
nano .env

# Set the application key
docker-compose run app php artisan key:generate

# Now run
docker-compose up
```