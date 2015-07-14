PrayerRequests
======

A Symfony project intended to work as an API back end for a prayer request application. The goal is to improve my unit testing skills, build on my knowledge of Symfony, and help me become more familiar with the API concept.

To update schema `cd` into the VM:
`cd /var/www/sites/prayer.dev`

Update the schema:
`php app/console doctrine:schema:update --force`

Generate entities if needed:
`php app/console doctrine:generate:entities JesseMaxwellPrayerBundle`
