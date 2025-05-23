## 🧠 Objective

Upgrade this Laravel 10 application to Laravel 12 and refactor/update the code where necessary to meet modern standards and best practices.

## Tasks

### Upgrade to Laravel 12

- ✅ Correct and complete upgrade to Laravel 12
- ✅ Fix or update deprecated features or breaking changes
- ✅ Identify and resolve upgrade blockers
- ✅ Clean, PSR-12-compliant code
- ✅ Application must be functional after upgrade

### Task #1

The user list page is no longer working properly — interactive features like sorting, pagination, and delete no longer respond.
Investigate and fix the issue.
💬 Hint: It was working before using Livewire.

## DONE
-- used php artisan livewire:upgrade  
- fixed search
- made changes in the app/livewire/userTable.php to make the edit popup functions work, also added the missing modal from the resources/views/livewire/user-table.blade.php


### Task #2

The user registration is broken.
Your job is to:

- Fix the registration process so it works correctly again
- Explain why this bug happened

## DONE
-fixed, the error was the missing field in the model User.

### Task #3

Refactor the user registration logic so that it is handled by a dedicated service class instead of being written directly in the controller.

- Create a service class called UserRegistrationService
- Move the logic for creating the user, hashing the password, and sending the welcome email into this class
- Use the service in the controller instead of writing logic inline

## DONE

### Task #4

Currently, when users are deleted from the app, they are removed from the database.
Modify the app so that deleted users are not permanently removed, but instead are
soft deleted and can be later restored or permanently deleted if needed.

## DONE

### Task #5

Translate the email verification notification into Romanian and add a custom line
of text in the email body (e.g. a friendly reminder or app-specific instruction).
Add an extra line like: „Dacă ai probleme cu linkul de mai jos, contactează echipa de suport.”

## DONE

### Task #6

After a user registers, send them a custom welcome email. The email should:

- Use a job to send the email
- Have a friendly message (in Romanian)
- Be sent only once upon registration


## DONE
--done cerating the necessary stuff to send emails via jobs

### Task #7

Restrict access to the users list page:

- Only users with role admin or editor can view the page.
done
- Only users with role admin can delete users.
done
- All other roles (e.g. viewer, user, guests) should be blocked from accessing or modifying anything on this page.

## DONE

### Task #8

Create a middleware that logs all incoming request headers to a custom log file.
📁 The log file should be saved to: storage/logs/request-headers.log

## DONE

### Task #9

Create a protected API route that returns the authenticated user's details in JSON format.

- The endpoint should be: GET /api/me
- It should return the user’s name, email, and role
- The route must be protected (authenticated users only)

## DONE
- created new api route
- everyting worked perfectly
gettoken
curl -X POST http://localhost/api/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"deta.mihai+the@gmail.com", "password":"password"}'

 use token
 curl -H "Authorization: Bearer TOKEN" http://localhost/api/me


### Task #10

Write an import process that reads orase.csv from storage and insert the values to database

- Make a command to import the file
- Ensure cities are correctly linked to their respective county using a foreign key.

## DONE
structure: orase <--> judete
cmd:
- php artisan migrate --path=database/migrations/2025_05_13_153826_create_judete_table.php
- php artisan migrate

NEW command is:
php artisan app:importorasecsv


### Task #11

Use the AccuWeather API to fetch and display the current weather based on the user’s browser location (latitude and longitude).

- Use key: 9rMVctoASUzWlOlzs2t5IXNEANjE924X
- Get User Location
- Get weather info from AccuWeather
- Show weather in a small box on the dashboard or home page. Display: temperature, weather text (e.g. "Partly Cloudy"), and icon.

## DONE
- you need to add the api key i the .env file as 
WEATHER_KEY=9rMVctoASUzWlOlzs2t5IXNEANjE924X
- the method used is with javascript so its easier for the location to be received


### Task #12

Replicate the existing user list table using DataTables instead of Livewire. The DataTables version should:

- Be styled with TailwindCSS
- Support searching, pagination, and sorting
- Load data using AJAX
- Display the same columns: ID, Name, Email, Registered Date
- Include the same actions: Edit, Delete

## DONE