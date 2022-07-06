# Welcome to Softnauts!  

## Your task:

Implement an API endpoint `POST /api/gold`, return **average** gold price for any given date range. To get real gold prices, use NBP service at http://api.nbp.pl/ (this link will open API doc). Yes, we will check if return values are real.
You may use prepared App\Controller\GoldController if You want.

### API request
POST request format should be 
```
{
    "from": "2021-01-01T00:00:00+00:00", 
    "to": "2021-01-31T00:00:00+00:00"
}
```
where timestamp is a string, with time and timezone included. All other date formats, missing fields, missing timezones, or other errors, must return relevant HTTP status code. 

### API response 
It should be a JSON, with format:
```
{ 
    "from": "2021-01-04T00:00:00+00:00", 
    "to": "2021-01-29T00:00:00+00:00", 
    "avg": 12345.67 
}
```
Note, that in our example, requested **"from"** is not equal to received **"from"**! That's because NBP don't have data for weekends. Respond with real data!

### Unit testing
Make sure that unit tests in `tests/GoldControllerTest.php` are working, and not returning errors. You may prepare few additional test cases if necessary.

### Additional constraints:
1. We will be checking:
    1. If code compiles, and returns real data
    2. If unit tests are all green
    3. Code structure, cleanliness and Your design decisions (SOLID, design patterns, and/or conformance to Symfony guidelines).
2. You can do *anything You want* with this project. Remove our code, install libraries, add dependencies, create services, anything. 
    1. Of course, these additions should be sane. 
    2. But if You do something "strange" and successfully defend it at the meeting - a big plus!
3. You _have_ to use **PHP >= 8.1** and Composer 2
4. Please, write in English! (variable names, comments, commit messages - all of it)

### Installation:
1. `git clone git@bitbucket.org:softnauts/php-gold-prices.git` 
2. `composer install`

## Returning an assignment
Push source code into Your own public repository (GitHub, BitBucket, whatever), and send us the link.
