> [!NOTE]
> This project is a demo. It may have a domain (and/or database schema) that doesn't make much sense in a real project.

## Installation

To run this project, do the following:

1. Clone the project.
2. Run `docker-compose up`.

3. Go inside the container to install `composer` dependencies. You can enter with VS Code Docker extension (`Attach Shell`) or via CLI:

```sh
docker-compose exec app sh
composer install
```

4. Run migrations and seeders:

```sh
yii migrate/up
yii seed
```

5. Test user:
```
email: test@gmail.com
password: pass1234
```
