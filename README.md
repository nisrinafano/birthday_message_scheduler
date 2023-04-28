# Birthday Message Scheduler

This project is made by Nisrina Fadhilah Fano as a assessment test for the recruitment process at Upscalix.

<b>Framework: Laravel 8</b>

<b>Prequisites:</b>
- XAMPP with PHP version >= 7.3
- Postman

## Steps to run this project in local environment:
0. Start Apache and MySQL server
1. Clone this project inside xampp/htdocs folder
2. Copy `.env.example` file and rename the new file to `.env`
3. Create a new database and change the value of `DB_DATABASE` with your database name
4. Open terminal, navigate to this project folder
5. Run `php artisan migrate` to create the table
7. Run `php artisan serve` to start
8. Now you're ready to test the REST API with Postman

## Example Request
- [POST]  /user_birthday/add <br>
        <b>Request body :</b>
        ```
        {
            {
                "first_name": "Brown",
                "last_name": "Fox",
                "email" : "brownfox1@noemail.com",
                "birthdate" : "1990-04-29",
                "location" : "Brunei",
                "timezone" : "Asia/Brunei"
            }
        }
        ```
- [PUT]  /user_birthday/update/{id} <br>
        <b>Request body :</b>
        ```
        {
            {
                "first_name": "Brown",
                "last_name": "Fox",
                "email" : "brownfox1@noemail.com",
                "birthdate" : "1990-04-29",
                "location" : "Brunei",
                "timezone" : "Asia/Brunei"
            }
        }
        ```
- [DELETE]  /user_birthday/delete/{id} <br>
