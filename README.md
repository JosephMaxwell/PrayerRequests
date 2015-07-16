PrayerRequests
======

A Symfony project intended to work as an API back end for a prayer request application. The goal is to improve my testing skills, build on my knowledge of Symfony, and help me become more familiar with the API concept. Since it is practically just a database abstraction layer, I decided to go with more functional testing instead of unit testing.

To update schema `cd` into the VM:<br />
`cd /var/www/sites/prayer.dev`

Build the base models:<br />
`php app/console propel:model:build`

Migrate the schema to ensure all is set:<br />
`php app/console propel:migration:generate-diff`<br />
`php app/console propel:migration:migrate`

For the functional testing, it needs:

- User 1: bassplayer7
- User 2: keysplayer8

- PrayerRequest 1:
    - UserId: 1 (bassplayer7)
    - Title: first test
- PrayerRequest 2:
    - UserId: 2 (keysplayer8)
    - Title: test
