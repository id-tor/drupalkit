Image for running Behat tests in drupal starter environment.
============

This image includes:

[Behat](https://packagist.org/packages/behat/behat)

[Mink](https://packagist.org/packages/behat/mink)

[Mink extension](https://packagist.org/packages/behat/mink-extension)

[Mink goutte driver](https://packagist.org/packages/behat/mink-goutte-driver)

[Mink selenium2 driver](https://packagist.org/packages/behat/mink-selenium2-driver)

[Drupal extension](https://packagist.org/packages/drupal/drupal-extension)

[Guzzle](https://packagist.org/packages/guzzlehttp/guzzle)

[PHP Unit](https://packagist.org/packages/phpunit/phpunit)

[Faker](https://packagist.org/packages/fzaninotto/faker)

[PHPspec2-expect](https://packagist.org/packages/bossa/phpspec2-expect)

[Behat cucumber json formatter](https://packagist.org/packages/vanare/behat-cucumber-json-formatter)

Also, it uses official [selenium/standalone-chrome](https://github.com/SeleniumHQ/docker-selenium) image.

### Configuration of the environment.

* Put your custom contexts into "features/bootstrap/" folder.

* Configure behat.yml for your custom contexts if needed.

* Put your tests  into "features/" folder.

#####For Drupal 8 you also need to

* Change volumes in docker-compose

```
./../drupal7:/drupal
```

to 

```
./../drupal8:/drupal
```

* Add the following line into your settings php. It is needed to grant access to you site for GouteDriver/Selenium Server through Nginx container.
```
$settings['trusted_host_patterns'][] = '^nginx$';
```

### In order to run tests:

Add the following command after drush command for site build.

```
docker-compose -f docker-compose.yml -f docker-compose.ci.yml -f docker-compose.behat.yml exec behat /srv/entrypoint.sh "--format=pretty --out=std --format=cucumber_json --out=std" 
```

E.x.,

```
...
sudo docker-compose -f docker-compose.yml -f docker-compose.ci.yml -T --user www-data php /bin/sh -c "cd /var/www/html;
drush sql-drop -y;
gunzip < /var/db_dump/${DB_DUMP_NAME} | drush sql-cli;
drush rebuild;
drush cim -y;
drush updb -y;
drush rebuild; 
exit;
docker-compose -f docker-compose.yml -f docker-compose.ci.yml -f docker-compose.behat.yml exec behat /srv/entrypoint.sh "--format=pretty --out=std --format=cucumber_json --out=std"; 
```

### Some additional information. 

* Reports and text files with information about screenshots are saved in artifacts/ folder.

* Screenshots will be uploaded to [https://wsend.net/](https://wsend.net/).

### For additional information visit [page of the image](https://hub.docker.com/r/bergil/docker-behat/).
