# PDF Backup

This is an application for backing up data from PDF Systems' various web-based applications.

## Docker

### Production
For production systems, `docker-compose-prod.yml` should serve as the basis for running the application, which runs a single container for the web application.
By default, a named Docker volume is used to store backed up files. This can be changed as needed, such as by using an NFS mount, bind mount, etc...

#### .env
Only the `APP_KEY` and `APP_URL` environment variables are required, along with connection information for the database.

## Usage

### Setup
After setting up the environment variables, start the application using Docker or Docker Compose and perform the
following initial setup steps.

#### Create Role(s) (optional)
```bash
docker exec -it {container_name} php artisan role:create
```

#### Create Initial User
```bash
docker exec -it {container_name} php artisan user:create
```

#### Create User Token
```bash
docker exec -it {container_name} php artisan user:create-token
```
Once created, be sure to copy the token and paste it into your application as it will not be shown again.

#### Create Application
```bash
docker exec -it {container_name} php artisan application:create
```
Once created, you will need to copy the `id` of the application and paste it into your application configuration.

### API

Once the application is set up, you can use the API to create backups for defined applications.
All API requests should include the `Authorization` header with a Bearer token for the user created in the setup step.

#### Create Backup
POST `/api/backup`
```json
{
    "application_id": 1,
    "filename": "Database.tar.gz",
    "type": "database",
    "mime_type": "application/gzip",
    "meta": {
        "foo": "bar"
    }
}
```
