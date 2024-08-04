# NBA SIMULATION
This project has been dockerized and can be run using the following commands:

---
### Clone the repository.
```
git clone https://github.com/daskafa/nba-simulation.git
```

### Go to the project directory.
```
cd nba-simulation
```

### Edit the docker-compose.yml file if necessary.
### Start the docker containers.
```
docker-compose up -d
```

#### Go to the src directory and create the .env file and add the information you specified in the docker-compose.yaml file to your file. (For example, your database information)
### Enter MySQL IP Address in the .env file
```
docker inspect --format='{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' mysql
```

### While in the src directory, install composer dependencies.
```
composer install
```

### Generate the application key.
```
docker exec -it nba-simulation-app php artisan key:generate
```

### Run the Artisan command. (You can also use this command to reset the system.)
```
docker exec -it nba-simulation-app php artisan app:prepare-simulation
```

*That's all, thanks.*