# Yii2 e-commerce web application

This is an incomplete e-commerce web application based on the Yii 2 Advanced Project Template and uploaded on GitHub for demostration purposes. My original intention was to create a web application through which the services of creating various legal documents could be sold. It has support for multiple display languages - it is partially translated in Latvian and the same variables are there also for Russian, however their values are only placeholders. It allows for the creation of services as entities with the following properties:

- name
- price
- category
- is_new
- has_discount
- description
- product_image
- extra_images

There is also a partial implementation of "product" entities. It is also possible to create service categories and blog posts. Users can view the services in the "Catalog" section, where they can be filtered by category, sorted by price and added to the cart (with a quantity of 1). Upon clicking on the name of a service, it's own page can be viewed, where it's possible to specify the quantity to add to the cart, as well as view any extra images it may have. Upon navigating to the cart, the total added services and their cost can be viewed. Upon clicking on the "Proceed" button, a form for entering the customer's data is displayed. After entering the data and clicking the "Order" button, an "order success" message is displayed and an invoice is generated and saved - it can be viewed in a special section by an administrator. Sending of the invoice to the customer through e-mail is not currently implemented.

## Local setup (Docker)

These instructions are for setting up the project locally.  
You’ll get:

- Frontend: `http://localhost:20080`
- Backend: `http://localhost:21080`

### Prerequisites

- Docker Engine + Docker Compose v2
  - Verify:
    ```bash
    docker --version
    docker compose version
    ```

### 1) Clone the repository

```bash
git clone https://github.com/mikuslusens/yii2-ecommerce-webapp.git
cd yii2-ecommerce-webapp
```

### 2) Start the containers

Build images and start services:

```bash
docker compose up -d --build
```

Check status:

```bash
docker compose ps
```

### 3) Install PHP dependencies (Composer)

```bash
docker compose exec frontend composer install --no-interaction
```

### 4) Initialize database

Run:

```bash
docker compose exec -T mysql mysql -u yii2advanced -psecret123 yii2advanced < dump-yii2advanced-202601141605.sql
```

Verify tables exist:

```bash
docker compose exec mysql mysql -u yii2advanced -psecret123 -e "SHOW TABLES;" yii2advanced
```

### 5) File permissions (Yii runtime/assets & images directory)

Run:

```bash
docker compose exec frontend bash -lc 'chgrp -R www-data /app/frontend/runtime /app/frontend/web/assets /app/frontend/web/images && chmod -R g+w /app/frontend/runtime /app/frontend/web/assets /app/frontend/web/images && find /app/frontend/runtime /app/frontend/web/assets /app/frontend/web/images -type d -exec chmod g+s {} +'
docker compose exec backend  bash -lc 'chgrp -R www-data /app/backend/runtime  /app/backend/web/assets  && chmod -R g+w /app/backend/runtime  /app/backend/web/assets  && find /app/backend/runtime  /app/backend/web/assets  -type d -exec chmod g+s {} +'
```

### 6) Open the application

* Frontend: `http://localhost:20080`
* Backend: `http://localhost:21080`

To gain access to all features, go to 'http://localhost:20080/site/login' and enter the following credentials:

Username: admin
Password: passwd

### Useful commands

View logs:

```bash
docker compose logs -f frontend
docker compose logs -f backend
docker compose logs -f mysql
```

Restart services:

```bash
docker compose restart frontend backend mysql
```

Stop everything:

```bash
docker compose down
```

Stop + remove volumes (deletes DB data):

```bash
docker compose down -v
```