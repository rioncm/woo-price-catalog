# Price Catalog

## Description

The Price Catalog plugin for WooCommerce allows you to manage and display customer-specific pricing for products. This plugin ensures that logged-in customers see their predetermined prices throughout the entire transaction process. If no specific price is set for a customer, the default site-wide pricing is applied. Prices can be set for individual products or variations and are managed via a REST API.

## Features

- Display customer-specific pricing on product pages and throughout the transaction.
- Default to site-wide pricing if no specific customer price is set.
- Manage prices for products and variations tied to WooCommerce product/variant IDs.
- REST API for CRUD operations and batch processing of customer-specific prices.
- Limited display and management in the WordPress interface.


## File Structure
price-catalog/
├── price-catalog.php
├── includes/
│ ├── class-price-catalog.php
│ └── class-price-catalog-api.php
├── assets/
│ ├── js/
│ ├── css/
├── languages/

## Installation

1. Clone this repo and create a zip file called price-catalog.zip according to the File Structure .
2. Upload the plugin zip file via the WordPress admin dashboard or extract it to the `wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

See overview.md for full documentation


### LICENSE 

MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
