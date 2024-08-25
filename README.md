<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://zipmend.com/wp-content/uploads/2023/12/zipmend-Express-Courier-service-and-freight-forwarding.svg" width="400" alt="Laravel Logo"></a></p>


## About Zipmend

The total distance between cities in the database is measured using Google API through a custom API implementation.

- cp .env.example .env
- composer install
- php artisan key generate
- php artisan db:seed

### API 

- Basic Authentication
- Encode the api key in base 64, send it in the header or as the "api_key" get parameter.

```php

$apiKey = 'api key';

$encodedApiKey = base64_encode($apiKey);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://127.0.0.1:8000/api/v1/calculate',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "addresses": [
        {
            "country": "DE",
            "zip":  "10115",
            "city": "Berlin"
        },
        {
            "country": "DE",
            "zip": "20095",
            "city": "Hamburg"
        },
        {
            "country": "DE",
            "zip": "01067",
            "city": "Dresden"
        }
    ] 
}
',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authentication: Basic ' . $encodedApiKey,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

echo $response;
```
