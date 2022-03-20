# Tweeter Clone


### Installation (first time)

1. Open in cmd or terminal app and navigate to project folder
2. Run following commands

    ```bash
    composer install
    cp .env.example .env
    ```

3. Set the database information in .env
   DB_DATABASE, DB_USERNAME, DB_PASSWORD

4. Run following commands

    ```bash
    php artisan key:generate
    php artisan passport:install
    php artisan migrate --seed
    ```

### Auth
    Set API_URL in .env
#### Admin
- Email: `admin@admin.com`
- Password: `admin_password`

#### Normal users
You can find them in database or by calling this API (with admin logged in):
```bash
{{baseUrl}}/api/users
```

### For the APIs, you can import the file (`tweeter.postman_collection.json`) to postman and test the APIs
