## Description of MVP for short-term car rentals

For this MVP was decided to use:
- Architecture - monolith
- Backend: PHP 8.2+, Symfony 7.3, MariaDB
- Frontend: React, TailwindCSS.

### How to set up
This project is running with the help of Docker

##### Demo
- Demo is available at the temporary URL https://lemonchiffon-rabbit-703071.hostingersite.com/
- For testing purposes, DB could be reset to the init stage by visiting the URL https://lemonchiffon-rabbit-703071.hostingersite.com/api/resetDB

#### Installation steps:
For local set up:
- Copy this repository to the needed folder
- Open a terminal in this directory and run
  - docker-compose up -d
  - Go inside of Docker image and run commands
  - php bin/console doctrine:database:create
  - php bin/console doctrine:schema:update --force
  - php bin/console app:load-fixtures

With these commands, a UI of the project should be available at URL http://localhost

### List of endpoints:

#### GET /api/vehicles - all available vehicles to rent
Query parameters:
- startDatetime - datetime in format 2025-09-29
- endDatetime - datetime in format 2025-09-30

Responses:
- Status 200 - array of JSON objects 
```json
[
    {
    "id": 5,
    "name": "Audi A4",
    "make": "Audi",
    "model": "A4 Avant",
    "productionYear": 2023,
    "price": 548,
    "image": "https://abo.miles-mobility.com/media/290/download/Audi_A4_avant_diagonal-left.jpg?v=1",
    "seats": 5,
    "doors": 5,
    "gearbox": "Automatic",
    "vehicleType": "Petrol",
    "power": 146,
    "powertrain": "2WD",
    "bodyType": "Station Wagon",
    "minimumDriverAge": 23,
    "insuranceDeductible": 900,
    "mileage": 500
    }
]
```

#### POST /api/vehicles - create a new vehicle
In progress

#### GET /api/vehicles/{id} - information about a specific vehicle
Responses:
- Status 200, JSON object
```json
{
"id": 5,
"name": "Audi A4",
"make": "Audi",
"model": "A4 Avant",
"productionYear": 2023,
"price": 548,
"image": "https://abo.miles-mobility.com/media/290/download/Audi_A4_avant_diagonal-left.jpg?v=1",
"seats": 5,
"doors": 5,
"gearbox": "Automatic",
"vehicleType": "Petrol",
"power": 146,
"powertrain": "2WD",
"bodyType": "Station Wagon",
"minimumDriverAge": 23,
"insuranceDeductible": 900,
"mileage": 500
}
```
Status 500 - for not existing vehicle

#### PATCH /api/vehicles/{id} - update information about the vehicle
In progress

#### DELETE /api/vehicles/{id} - soft-delete for concrete vehicle
Responses:
- 200 - Success
- 500 - The vehicle is not found

#### POST /api/reservations
Expected JSON data object in format
```json
{
"vehicleId":5,
"pickupDatetime":"2025-09-29T08:00",
"returnDatetime":"2025-09-30T08:00",
"pickupCity":"Berlin", 
"returnCity":"Berlin",
"returnAtDifferentLocation":true
}
```
Responses: 
- 200 - The reservation is successful
- 422 - If the car is already booked

#### GET /api/reservations - List of all reservations
Response - array of JSON objects in format
```json
[
    {
    "id": 44,
    "status": "pending",
    "pickupDatetime": "2025-09-29 08:00",
    "returnDatetime": "2025-10-01 08:00",
    "pickupCity": "Berlin",
    "returnCity": "Berlin",
    "returnAtDifferentLocation": false,
    "vehicle": {
        "id": 4,
        "name": "Ford Puma (155)",
        "make": "Ford",
        "model": "Puma",
        "productionYear": 2023,
        "price": 399,
        "image": "https://abo.miles-mobility.com/media/437/download/Ford_Puma-155_diagonal_left.jpg?v=1",
        "seats": 5,
        "doors": 5,
        "gearbox": "Automatic",
        "vehicleType": "Petrol",
        "power": 155,
        "powertrain": "2WD",
        "bodyType": "SUV",
        "minimumDriverAge": 18,
        "insuranceDeductible": 900,
        "mileage": 500
        }
    }
]
```

#### GET /api/reservations/{id} - Get a specific reservation
Responses:
- Status 200 - JSON object in format
```json
{
"id": 44,
"status": "pending",
"pickupDatetime": "2025-09-29 08:00",
"returnDatetime": "2025-10-01 08:00",
"pickupCity": "Berlin",
"returnCity": "Berlin",
"returnAtDifferentLocation": false,
"vehicle": {
    "id": 4,
    "name": "Ford Puma (155)",
    "make": "Ford",
    "model": "Puma",
    "productionYear": 2023,
    "price": 399,
    "image": "https://abo.miles-mobility.com/media/437/download/Ford_Puma-155_diagonal_left.jpg?v=1",
    "seats": 5,
    "doors": 5,
    "gearbox": "Automatic",
    "vehicleType": "Petrol",
    "power": 155,
    "powertrain": "2WD",
    "bodyType": "SUV",
    "minimumDriverAge": 18,
    "insuranceDeductible": 900,
    "mileage": 500
    }
}
```
- Status 500 - The reservation is not found

#### PATCH /api/reservations/{id} - Update a specific reservation
In progress

#### DELETE /api/reservations/{id} - soft-delete of a specific reservation
Responses:
Status 200 - Success
Status 500 - The reservation is not found

### Known gaps:
- Endpoints are not protected from requests from locations other than our domain
  - Could be done with a check of the headers Origin or Referer
- Not all endpoints are finished
