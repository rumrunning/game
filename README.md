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

## Understanding Skill Set Points

Skill points as stored as a multiple of 1000. 
This gives greater flexibility over 100 and finer control over percentage chances, such as 0.015. 
Awarding a player 10 skill points will convert to 0.01 when calculating a percentage chance.

E.g. When a players skill points are at 0.01 (known as 10), and an action difficulty is 0.1,
and providing that there is no random chance involved, a player will have a 1% chance when committing the action.
