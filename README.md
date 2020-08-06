# Social-Network
This is my first Application with Laravel, VueJs and Docker
## Usage
All you need to run this application is docker-compose and yarn:
1. Don't forget to copy .env.example to .env in laravel project:
```bash
cp /src/.env.example /src/.env
```
2. docker-compose
```bash
docker-compose up -d --build
```
3. Migrate database
```bash
docker-compose exec php php artisan migrate:fresh --seed --seeder=SSeeder
```
4. Run front-end:
```bash
cd frontend
yarn
yarn serve
```
### Enjoy

