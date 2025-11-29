# Reyken Traders - Laravel Migration

This is the Laravel version of the Reyken Traders e-commerce website.

## Setup Instructions

1. **Install Dependencies**
   ```bash
   cd reykentrade_laravel
   composer install
   ```

2. **Configure Environment**
   - Copy `.env.example` to `.env` if not already done
   - Update database credentials in `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=s24000041_reykentraders
     DB_USERNAME=s24000041_reykentraders
     DB_PASSWORD=babclarencereve
     ```

3. **Run Migrations**
   ```bash
   php artisan migrate
   ```

4. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```
   (This links `public/storage` to `storage/app/public` for uploaded images)

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

6. **Access the Application**
   - Open your browser and go to `http://localhost:8000`

## Key Changes from Original

- All backend logic moved from JavaScript to PHP controllers
- JavaScript now only handles UI/styling interactions
- Form submissions replace AJAX/fetch calls
- Server-side rendering replaces client-side data fetching
- Laravel authentication replaces session-based auth
- Eloquent ORM replaces raw SQL queries

## Features

- User authentication (login/register)
- Product listing and search
- Shopping cart functionality
- Order processing
- Seller dashboard for product management
- Order management for sellers

## Notes

- All images should be in `storage/app/public/uploads/`
- CSS and JavaScript files are in `public/css/` and `public/scripts/`
- Views use Blade templating engine
- All routes are defined in `routes/web.php`
