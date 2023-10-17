# Hotel Booking System
This is a hotel booking system possessing features to ease admin's works and helps users make booking easily.
The project is created using Laravel, Vue and Inertia.

# Features
- CRUD for reservations, rooms and room types
- Easy Reservation
- Authentication and Authorization
- Data Reporting for Admin
- Profile Update
- Reservations and Rooms Filter
- Mail Notification upon complete reservation
- Database caching

# Project Setup
Download the repository or copy the repository link and run the command below.
```
git clone https://github.com/lara-camp/hotel-booking.git
```

Go to the project directory and install the necessary packages.
```
cd hotel-booking
npm install
composer install
```

After the packages are installed, create a .env file and edit as needed.
```
cp .env.example .env
```
Please don't forget to add mailing address to .env file.
If you don't have one, setup as below.
``` env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=kaungzayyan19@gmail.com
MAIL_PASSWORD=mmuimbenizphqybd
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="hotelbookgin@laracamp.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Generate the key for the project first. Then, create the database for the project and run the migrations.
```
php artian key:generate
php artisan migrate
```
