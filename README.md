# Multi-Source Data Providers Task

## Task Summery
- I have made three endpoints :
    - First-one is ``` Store Users/Transactions From Providers ``` which reads json files and save it in DB.
    - Second-one is ``` List Transactions ``` which list all transactions from DB and apply various filters on them see attached post-man collection.
    - Third-one is ``` List Users ``` which list all users from DB and apply various filters on them see attached post-man collection.
    
## Prerequisite Before Initialization
- PHP >= 8.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension


## Before Installation
- We have to create two databases one for ( production ) and other for ( testing )
- Also, we have to copy .env.example to .env
- Then, we have to add production => database name and credentials inside .env file
- Finally, we have to add testing => database name and credentials inside phpunit.xml

## Installation Steps
- We have to run ``` composer install```
- At first, we have to run ``` php artisan migrate ```
- Then we have to run ``` php artisan key:generate ```
- Then if you need to run test please use this command``` ./vendor/bin/phpunit  ```
- Finally, for running our application please run ``` php artisan serve  ```

## Testing Our Application

- PostMan Collection included in project files in main path for easy testing, also here's a link for importing the collection directly https://www.getpostman.com/collections/2d75a1d56023a1062de3.
- storage folder includes liveFiles folder which contain provider's JSON files, also it contains mockingFiles for providers' JSON files for testing purpose.


## Summery

- Adapter Design Pattern has been used for solving multi-source data issue.
- Also, adapter gives me the ability to mock our source files during testing.
- Finally, Thanks for your consideration of my profile.
