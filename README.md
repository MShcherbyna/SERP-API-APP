# SERP API test task

## Getting Started

- Rename ".env.example" to ".env" set access to work with DataForSeo and update the .env file along with database connection.
- SE_TOKEN this is an arbitrary password that will be used to check postback requests

```bash
mv .env.example .env
```

- Install dependencies for app

```bash
composer install && composer update
npm install
npm run dev
```

- Create necessary tables

```bash
php artisan migrate
```

## Usage

I use postback for getting task result, so you should have some real host for testing or you can use ngrok tools for that https://ngrok.com/

