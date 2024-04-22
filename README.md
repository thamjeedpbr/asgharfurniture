# asgharfurniture

Steps to follow to run this project

1. Create Env file

```bash
  cp .env.example .env
```

2. Generate the key

```bash
  php artisan key:generate
```
4. Connect with Database

3. Install composer  

```bash
  composer install
```

4. Connect the Database

5. Run Migration

```bash
  php artisan migrate
```

6. Command to Create a user

```bash
  php artisan db:seed
```

7. Run the application 

```bash
  php php artisan serve
```

8. Now you can use the application a postman collection is available in this repository to check the api
