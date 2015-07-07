#!/usr/bin/env bash
cd /var/www/sites/prayer.dev
rm -rf app/cache/*
rm -rf app/logs/*
chmod 777 app/cache
chmod 777 app/logs
php app/console assetic:dump
php app/console cache:clear