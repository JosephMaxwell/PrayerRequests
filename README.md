Prayer Request API
======

A Symfony project intended to work as an API back end for a prayer request application. The goal is to improve my testing skills, build on my knowledge of Symfony, and help me become more familiar with the API concept. Since it is practically just a database abstraction layer, I decided to go with more functional testing instead of unit testing.

To update schema `cd` into the VM:<br />
`cd /var/www/sites/prayer.dev`

Build the base models:<br />
`php app/console propel:model:build`

Migrate the schema to ensure all is set:<br />
`php app/console propel:migration:generate-diff`<br />
`php app/console propel:migration:migrate`

# Documentation:
Navigate to `/docs` to view the API documentation.


# Functional Testing Requirements:

*If the install goes correctly, these should be populated automatically in the DB.*

## User Table:

Id | User
------------- | -------------
1 | bassplayer7
2 | keysplayer8

## PrayerRequest Table

UserId | Title
------------- | ------------- | ---
1 (bassplayer7) | first test
2 (keysplayer8) | test
