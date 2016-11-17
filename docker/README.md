## Deployment instructions

#### Files description.

 - `docker-compose.yml` - common settings for all environments.
 - `docker-compose.override.yml` - for local environment.
 - `docker-compose.сі.yml` - some specific for instances creation.
 - `docker-compose.prod.yml` - for deploy site in production.
 - `docker-compose.behat.yml` - for behat tests environment.

#### Deploy instructions.

##### Local

 - Copy `default.settings.local.php` to `settings.local.php`
 - `docker-compose up -d`

##### CI Builds

 - `docker-compose -f docker-compose.yml -f docker-compose.сі.yml up -d`

##### Production

 - `docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d`
 
##### Behat tests

 - `docker-compose -f docker-compose.yml -f docker-compose.сі.yml -f docker-compose.behat.yml up -d`
