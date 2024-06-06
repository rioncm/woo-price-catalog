Sure! Here's the detailed endpoint documentation for your `price-catalog` plugin in Markdown format.

```markdown
# Price Catalog API Documentation

## Overview

The Price Catalog API provides endpoints to manage customer-specific pricing for WooCommerce products. This includes operations for creating, updating, retrieving, deleting, and performing bulk operations on prices.

## Base URL

```
/wp-json/price-catalog/v1/
```

## Endpoints

### 1. Create Price

**Endpoint:**

```
POST /price
```

**Description:**

Adds or updates a customer-specific price for a product.

**Request Parameters:**

- `user_id` (integer, required): The ID of the user.
- `product_id` (integer, required): The ID of the product.
- `price` (float, required): The specific price for the customer.

**Example Request:**

```json
{
    "user_id": 1,
    "product_id": 101,
    "price": 99.99
}
```

**Response:**

- `200 OK` - Price added/updated successfully.

**Permissions:**

Requires `manage_options` capability.

---

### 2. Get Price

**Endpoint:**

```
GET /price/{id}
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

### 3. Delete Price

**Endpoint:**

```
DELETE /price/{id}
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

### 4. Batch Update Prices

**Endpoint:**

```
POST /prices/batch
```

**Description:**

Performs bulk operations to add, update, or delete customer-specific prices.

**Request Parameters:**

- `prices` (array of objects, required): Array of price data objects.
  - `user_id` (integer, required): The ID of the user.
  - `product_id` (integer, required): The ID of the product.
  - `price` (float, optional): The specific price for the customer (required for update operations).
  - `operation` (string, optional): The operation to perform (`update` or `delete`). Defaults to `update`.

**Example Request:**

```json
{
    "prices": [
        {
            "user_id": 1,
            "product_id": 101,
            "price": 99.99,
            "operation": "update" // or "delete"
        },
        {
            "user_id": 2,
            "product_id": 102,
            "price": 89.99,
            "operation": "update"
        },
        {
            "user_id": 3,
            "product_id": 103,
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
```

This Markdown documentation provides a clear and detailed overview of the available endpoints, their purposes, required parameters, and example requests/responses. You can use this documentation to guide the development and usage of the `price-catalog` plugin's API.