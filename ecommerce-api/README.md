# Ecommerce API

## Overview
The Ecommerce API is a RESTful API designed to manage an online store's operations, including product management, user authentication, comments, shopping cart functionality, and order processing.

## Project Structure
```
ecommerce-api/
├── config/
│   └── database.php              # Database connection settings
├── controllers/
│   ├── ProductController.php      # Handles product-related operations
│   ├── UserController.php         # Manages user authentication and data
│   ├── CommentController.php      # Manages comments on products
│   ├── CartController.php         # Handles shopping cart operations
│   └── OrderController.php        # Manages order processing
├── models/
│   ├── Product.php                # Defines product data structure
│   ├── User.php                   # Defines user data structure
│   ├── Comment.php                # Defines comment data structure
│   ├── Cart.php                   # Defines shopping cart data structure
│   └── Order.php                  # Defines order data structure
├── routes/
│   └── api.php                   # API routes definition
├── public/
│   └── index.php                 # Entry point for the application
├── postman/
│   └── ecommerce.postman_collection.json  # Postman tests for the API
├── schema/
│   └── schema.sql                # MySQL database schema
├── .gitignore                    # Files and directories to ignore in version control
├── README.md                     # Project documentation
└── composer.json                 # PHP dependencies management (optional)
```

## Setup Instructions
1. **Clone the repository**:
   ```
   git clone <repository-url>
   cd ecommerce-api
   ```

2. **Install dependencies** (if using Composer):
   ```
   composer install
   ```

3. **Configure the database**:
   - Update the `config/database.php` file with your database connection settings.

4. **Set up the database schema**:
   - Run the SQL commands in `schema/schema.sql` to create the necessary tables.

5. **Run the application**:
   - Use a local server or deploy to a web server that supports PHP.

## Usage
- The API endpoints can be tested using the Postman collection located in `postman/ecommerce.postman_collection.json`.
- Refer to the `routes/api.php` file for available endpoints and their corresponding methods.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.