#!/usr/bin/env bash
role=${CONTAINER_ROLE:-app}
echo $role;

FILE=/var/www/artisan

while [ true ]
  do
  if [ -f "$FILE" ]; then
  # Take action if $DIR exists. #
    if [ "$role" = "app" ]; then
        /usr/local/sbin/php-fpm
    elif [ "$role" = "schedule" ]; then
        php /var/www/artisan schedule:run --verbose --no-interaction &
    elif [ "$role" = "queue" ]; then
        php /var/www/artisan queue:work --timeout=30
    fi
    sleep 60
  fi
done

