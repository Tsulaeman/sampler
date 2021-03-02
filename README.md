## Running the app
cd into the app root and run the following in order; <br/>
`composer install` <br/>
`php artisan migrate` <br/>
`php artisan passport:install` <br/>
`php artisan passport:client --personal` <br/>
`php artisan seed` <br/>
`php artisan serve`

Now you app should have started.

## APIs

The full API documentation can be found [here](https://documenter.getpostman.com/view/5214187/TWDfCsiF)

## Troubleshooting

If you get an error stating that "No personal access client defined" you will need to run `php artisan passport:client --personal` this might be because you rolled back migrations etc.