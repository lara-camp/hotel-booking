# Hotel Booking System
This is a hotel booking system possessing features to ease admin's works and helps users make booking easily. 
The project is created using Laravel, Vue and Inertia. 

# Features
- Authentication and Authorization
- Profile Update
- Easy Reservation
- CRUD for reservations, rooms and room types
- Data Reporting for Admin
- Reservations and Rooms Filter
- Mail Notification upon complete reservation

# Project Setup
Download the repository or copy the repository link and run the command below.
```
git clone <link>
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

Generate the key for the project first. Then, create the database for the project and run the migrations.
```
php artian key:generate 
php artisan migrate 
```
