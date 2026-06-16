# E-commerce Database Schema

## users

- id (int, primary key, auto increment)
- name (string)
- email (string, unique)
- password (string)
- role (string, default 'customer')
- timestamps

## categories

- id, name, slug (unique), parent_id (foreign key to categories.id), timestamps

## products

- id, name, slug (unique), description, price (decimal), stock_quantity, category_id (foreign key to categories), image_urls (json), timestamps

## carts

- id, user_id (foreign key to users), timestamps

## cart_items

- id, cart_id (foreign key to carts), product_id (foreign key to products), quantity, timestamps

## orders

- id, user_id (foreign key to users), total_amount, status, shipping_address, payment_method, timestamps

## order_items

- id, order_id (foreign key to orders), product_id, quantity, price_at_time, timestamps
