# Notification Service

> This is a service that sends notification to all subscribers of a given topic when a message is published to the topic

## Installation

[PHP](https://php.net) 7.4+ and [Composer](https://getcomposer.org) are required.

git clone the repository

You'll then need to run `composer install` or `composer update` to download and install the dependencies. <br>

run ```cp .env.example .env``` and update the database credentials to suit yours

run ```php artisan migrate```

run ```php artisan serve to serve the application```

## Usage

**Subscribe**
----
  Subscribes a user to the notification service

* **URL**

  /subscribe/{topic}

* **Method:**

  `POST`
  
*  **URL Params**
 
   `None`

* **Data Params**

   ```
   url=[string],
  ```

* **Success Response:**

  * **status:** true <br />
  **statusCode:** 00 <br />
    **message:** `You have successfully subscribed` <br/>
    **data:** `{"url":"url","topic":"topic"}`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/subscribe/polictics",
      dataType: "json",
      type : "POST",
      data: { url: 'https://www.myurl.com'}
      success : function(r) {
        console.log(r);
      }
    });
  ```

  **Publish**
----
  Publishes a message to a topic

* **URL**

  /publish/{topic}

* **Method:**

  `POST`
  
*  **URL Params**
 
   `None`

* **Success Response:**

  * **status:** true <br />
  **statusCode:** 00 <br />
    **message:** `You have successfully published message to topic` <br/>


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/publish/polictics",
      dataType: "json",
      type : "POST",
      data: { subject:"Plictiics news", contents:[{section:"section one content"}]}
      success : function(r) {
        console.log(r);
      }
    });
  ```
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
