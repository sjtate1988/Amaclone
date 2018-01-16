Amaclone Project - A clone of Amazon

This version can be found live at https://amaclone.drsjtate.uk

Technologies used:
- HTML and CSS
- JavaScript
- php

This is a group project with Femke Buijs, Iwona Kuzia and Alessandro Foti.
I have made some adaptations to the project myself.

The key features of this project are:
- Fully mobile-responsive web application.
- Fully functional registration and log-in pages, which redirect once successful.
- A carousel feature on the main index.php page.
- The ability to add, remove and alter the quantity of products on the cart.
- Search functionality to search through product names and authors.
- A chat feature, where you can talk to a customer services assistant.
- Pop ups to indicate the customer has added an item to the cart.
- An automated email system for customer enquiries.

You need to create two files to have the full functionality:
- mailgun.php
- reso/base.php

mailgun.php requires the following:
<?php
$apiKey set to your own mailgun account
$curlURL set to your own curlURL
?>

reso/base.php requires:

<?php
session_start();
$con = mysqli_connect('localhost', user_name, password, databse_name or die(mysqli_connect_errno());
?>

In order to make this project work you need to set up your own MySQL Database:
Tables:
        users:        user_id         PK AI         int(11)
                      firstname                     varchar(32)
                      lastname                      varchar(64)
                      email                         varchar(64)
                      password                      varchar(64)
                      date_joined                   TIMESTAMP

        products:     product_id      PK AI         int(11)
                      title                         varchar(64)
                      author                        varchar(64)
                      description                   varchar(2048) OR text
                      price                         decimal(6,2)
                      img                           varchar(128)
                      genre_id        FK (genres)   int(11)

        genres:       genre_id        PK AI         int(11)
                      genre                         varchar(16)

        addresses:    address_id      PK AI         int(11)
                      user_id         FK (users)    int(11)
                      address_name                  varchar(16)
                      address_no                    int(8)
                      phone_no                      int(11)
                      address_street                varchar(64)
                      address_city                  varchar(64)
                      postal_code                   varchar(8)
                      country                       varchar(64)

        orders:       order_id        PK AI         int(11)
                      user_id         FK (users)    int(11)
                      order_date                    TIMESTAMP
                      total_price                   decimal(5,2)

        order_items:  order_item_id   PK AI         int(11)
                      order_id        FK (orders)   int(11)
                      product_id      FK (products) int(11)
                      quantity                      int(4)
