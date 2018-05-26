# How to run

- run `docker-compose up -d`
- add `dkzp-backend.local dkzp-frontend.local` to your hosts file

Reset all - `docker-compose down -v`


## Backend

- Migrations - in BE container run `php bin/console app:migrate-data --truncate-tables`

### Installation
