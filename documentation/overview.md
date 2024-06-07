Certainly! Here is the updated documentation in Markdown format, including the new fields and endpoints:

```markdown
# Price Catalog

## Description

The Price Catalog plugin for WooCommerce allows you to manage and display customer-specific pricing for products. This plugin ensures that logged-in customers see their predetermined prices throughout the entire transaction process. If no specific price is set for a customer, the default site-wide pricing is applied. Prices can be set for individual products or variations and are managed via a REST API.

## Features

- Display customer-specific pricing on product pages and throughout the transaction.
- Default to site-wide pricing if no specific customer price is set.
- Manage prices for products and variations tied to WooCommerce product/variant IDs.
- REST API for CRUD operations and batch processing of customer-specific prices.
- Limited display and management in the WordPress interface.

## Installation

1. Download the plugin zip file.
2. Upload the plugin zip file via the WordPress admin dashboard or extract it to the `wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

### Endpoints

#### 1. Create Price

**Endpoint:**

```
POST /wp-json/price-catalog/v1/price
```

**Description:**

Adds or updates a customer-specific price for a product.

**Request Parameters:**

- `user_id` (integer, required): The ID of the user.
- `username` (string, required): The username of the user.
- `product_id` (integer, required): The ID of the product.
- `sku` (string, required): The SKU of the product.
- `price` (float, required): The specific price for the customer.

**Example Request:**

```json
{
    "user_id": 1,
    "username": "user1",
    "product_id": 101,
    "sku": "SKU101",
    "price": 99.99
}
```

**Response:**

- `200 OK` - Price added/updated successfully.

**Permissions:**

Requires `manage_options` capability.

---

#### 2. Get Price

**Endpoint:**

```
GET /wp-json/price-catalog/v1/price/{id}
```

**Description:**

Retrieves the customer-specific price for a given ID.

**Path Parameters:**

- `id` (integer, required): The ID of the price entry.

**Example Request:**

```
GET /wp-json/price-catalog/v1/price/1
```

**Response:**

- `200 OK` - Returns the price details.
- `404 Not Found` - Price not found.

**Permissions:**

Requires `manage_options` capability.

---

#### 3. Delete Price

**Endpoint:**

```
DELETE /wp-json/price-catalog/v1/price/{id}
```

**Description:**

Deletes the customer-specific price for a given ID.

**Path Parameters:**

- `id` (integer, required): The ID of the price entry.

**Example Request:**

```
DELETE /wp-json/price-catalog/v1/price/1
```

**Response:**

- `200 OK` - Price deleted successfully.
- `404 Not Found` - Price not found.

**Permissions:**

Requires `manage_options` capability.

---

#### 4. Batch Update Prices

**Endpoint:**

```
POST /wp-json/price-catalog/v1/prices/batch
```

**Description:**

Performs bulk operations to add, update, or delete customer-specific prices.

**Request Parameters:**

- `prices` (array of objects, required): Array of price data objects.
  - `user_id` (integer, required): The ID of the user.
  - `username` (string, required): The username of the user.
  - `product_id` (integer, required): The ID of the product.
  - `sku` (string, required): The SKU of the product.
  - `price` (float, optional): The specific price for the customer (required for update operations).
  - `operation` (string, optional): The operation to perform (`update` or `delete`). Defaults to `update`.

**Example Request:**

```json
{
    "prices": [
        {
            "user_id": 1,
            "username": "user1",
            "product_id": 101,
            "sku": "SKU101",
            "price": 99.99,
            "operation": "update"
        },
        {
            "user_id": 2,
            "username": "user2",
            "product_id": 102,
            "sku": "SKU102",
            "price": 89.99,
            "operation": "update"
        },
        {
            "user_id": 3,
            "username": "user3",
            "product_id": 103,
            "sku": "SKU103",
            "operation": "delete"
        }
    ]
}
```

**Response:**

- `200 OK` - Bulk operation completed. Returns an array of operation statuses.

**Permissions:**

Requires `manage_options` capability.

---

#### 5. Get Prices

**Endpoint:**

```
GET /wp-json/price-catalog/v1/prices
```

**Description:**

Retrieves all price entries based on `user_id` or `username`.

**Query Parameters:**

- `user_id` (integer, optional): The ID of the user.
- `username` (string, optional): The username of the user.

**Example Request:**

```
GET /wp-json/price-catalog/v1/prices?user_id=1
GET /wp-json/price-catalog/v1/prices?username=user1
```

**Response:**

- `200 OK` - Returns the price entries.
- `400 Bad Request` - Invalid request parameters.
- `404 Not Found` - No prices found.

**Permissions:**

Requires `manage_options` capability.

---

## Development

### Setup

1. Clone the repository: `git clone https://github.com/yourusername/price-catalog.git`
2. Navigate to the plugin directory: `cd price-catalog`
3. Make your changes and commit them.

### File Structure

```
price-catalog/
├── price-catalog.php
├── includes/
│   ├── class-price-catalog.php
│   └── class-price-catalog-api.php
├── assets/
│   ├── js/
│   ├── css/
├── languages/
```

### Contribution

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/new-feature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/new-feature`).
5. Create a new Pull Request.

## License

This plugin is licensed under the [MIT License](LICENSE).

## Credits

- Developed by Rion Morgentern.
- Contributions welcome.

## Support

For support, please open an issue in the [GitHub repository](https://github.com/yourusername/price-catalog/issues).
```

This updated README includes the new fields (`username` and `sku`) and the new GET endpoint for retrieving all entries based on `user_id` or `username`.