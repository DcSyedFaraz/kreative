# Database Seeders Documentation

This document explains how to use the comprehensive database seeders to populate your application with test data.

## Available Seeders

### 1. DatabaseSeeder (Main Seeder)
- Creates roles (admin, user, service provider)
- Creates test users with different roles
- Calls all other seeders in the correct order

### 2. ServiceSeeder
- Creates 15 different services (Photography, Videography, Graphic Design, etc.)
- Each service has a name and description

### 3. ProfileSeeder
- Creates profiles for all users
- Generates realistic contact information, bios, and professional details
- Service providers get additional fields like experience years and hourly rates

### 4. PackageSeeder
- Creates packages for service providers (2-4 packages per provider)
- Each package has 3-6 package items
- Includes realistic pricing and descriptions

### 5. ReviewSeeder
- Creates customer reviews (clients reviewing service providers)
- Creates general reviews for users
- Generates realistic review content and ratings

### 6. ChatSeeder
- Creates chat rooms between service providers and clients
- Generates realistic conversation messages
- Includes both read and unread messages for testing

### 7. CustomPackageSeeder
- Creates custom packages requested by clients
- Includes various statuses (pending, in_progress, completed, cancelled)
- Realistic requirements and budgets

## How to Run Seeders

### Run All Seeders
```bash
php artisan db:seed
```

### Run Specific Seeder
```bash
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=ChatSeeder
php artisan db:seed --class=PackageSeeder
```

### Fresh Database with Seeders
```bash
php artisan migrate:fresh --seed
```

## Test Users Created

### Admin User
- **Email**: admin@gmail.com
- **Password**: 12345678
- **Role**: admin

### Service Provider
- **Email**: provider@gmail.com
- **Password**: 12345678
- **Role**: service provider

### Regular User
- **Email**: user@gmail.com
- **Password**: 12345678
- **Role**: user

### Additional Users
- 10 additional users with random roles (user or service provider)
- All users have profiles, packages, and reviews

## Data Generated

### Services (15 total)
- Photography, Videography, Graphic Design, Web Development
- Event Planning, Catering, Music & Entertainment
- Interior Design, Fitness Training, Tutoring
- Consulting, Translation, Cleaning Services
- Pet Care, Transportation

### Chat Data
- Multiple chat rooms between service providers and clients
- 5-15 messages per chat room
- Mix of read and unread messages
- Realistic conversation flow

### Packages
- 2-4 packages per service provider
- 3-6 items per package
- Realistic pricing ($99-$699)

### Reviews
- Customer reviews for service providers
- General reviews for users
- Mostly positive ratings (3-5 stars)

### Custom Packages
- Various custom package requests
- Different statuses and budgets
- Realistic requirements and deadlines

## Testing the Chat Functionality

1. **Login as different users** to test the chat system
2. **Check unread message counts** on the chat index page
3. **Enter chat rooms** to see messages marked as read
4. **Send new messages** to test the real-time functionality

### Test Scenarios

1. **Login as user@gmail.com** and check chat index
2. **Login as provider@gmail.com** and check chat index
3. **Enter different chat rooms** to see message status changes
4. **Send messages** between different users
5. **Check unread counts** update correctly

## Customization

### Modify Seeder Data
You can modify the seeder files to:
- Change the number of records created
- Modify the content of messages, reviews, etc.
- Adjust pricing ranges
- Change user roles and permissions

### Add New Seeders
To add new seeders:
1. Create seeder: `php artisan make:seeder NewSeeder`
2. Add logic to the seeder file
3. Call it in DatabaseSeeder.php

## Notes

- All seeders are designed to work together
- Data is realistic and suitable for testing
- Seeders handle relationships between models
- Random data generation ensures variety
- All users are created with 'approved' status

## Troubleshooting

### Common Issues
1. **Foreign key constraints**: Make sure to run seeders in the correct order
2. **Duplicate data**: Use `migrate:fresh --seed` to start clean
3. **Missing relationships**: Check that all required models exist

### Reset Database
```bash
php artisan migrate:fresh --seed
```

This will:
- Drop all tables
- Run all migrations
- Run all seeders
- Give you a fresh database with test data
