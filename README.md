# MONO - PHP FRAMEWORK

Mono is a powerful, fast, and lightweight PHP framework designed to simplify and accelerate web application development. It leverages an object-oriented approach and adheres to the MVC (Model-View-Controller) architecture, ensuring a clean and modular codebase. Mono also includes a robust command-line interface (CLI) to streamline development tasks.

---

## Features

- **Object-Oriented Design**: Promotes reusable and maintainable code.
- **MVC Architecture**: Separates application logic, user interface, and data, fostering scalability.
- **Built-in Command-Line Interface**: Enables developers to manage the project, generate files, and execute tasks efficiently.
- **Hybrid Routing System**: Combines file-based routing with route attributes for flexibility and high performance.
- **Built-in ORM (Object-Relational Mapping)**: Simplifies database interactions with an intuitive and efficient abstraction layer.
- **Twig Templating Engine Integration**: Supports dynamic and flexible rendering of views with the Twig templating engine.
- **Customizable and Lightweight**: Suitable for projects of all sizes, from small-scale applications to enterprise-level solutions.

---

## Getting Started

### Prerequisites

Ensure that your system meets the following requirements:

- **PHP Version**: PHP 8.0 or higher.
- **Composer**: Installed globally for dependency management.
- **Node**: Installed globally for dependency management.

---

## Creating a New Mono Project

To start a new Mono project, use the following Composer command:

```bash
composer create-project zorncbllr/php-mono <project-name> -s dev
```
Use npm install to install node dependencies.

```bash
cd <project-name>
npm install
```

What Happens?

This command will download and set up a fresh Mono project in the <project-name> directory.
All required dependencies will be installed automatically.
Serving the Project
To quickly serve your project in a local development environment, Mono provides an easy-to-use CLI command.

## Steps to Serve:

Navigate to the root directory of your Mono project.

Run one of the following commands:

```bash
composer run dev
```

What Happens?

The command starts a local development server, typically accessible at http://localhost:8000.

This eliminates the need to configure external web servers during development.

## Creating a Controller

Controllers are a vital part of the MVC architecture. Mono simplifies the creation of controllers through its CLI.

## Generating a Controller

Run one of the following commands to generate a new controller:

```bash
php mono -g con <filename>
```

or

```bash
php mono gen controller <filename>
```

or

```bash
php mono generate controller <filename>
```

What Happens?

A new PHP file named <filename>.php is created in the controllers directory.

The file contains a boilerplate controller class with a default route handler for the index action.

Example: Generated Controller

Below is an example of a generated Home controller:

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return 'Home Controller';
    }
}
```

# Routing in Mono

Mono features a hybrid routing system that combines the simplicity of file-based routing with the power of route attributes. This dual approach ensures flexibility and speed.

## Key Concepts

### File-Based Routing:

Base routes are derived from the controller file names.

Example:

Controller File: Home.php

Base Route: /home

### Route Attributes:

Use PHP attributes (e.g., #[Get()]) to define HTTP methods and customize routes directly in the controller.

Example: #[Get('/custom-route')] defines a custom GET route.

Example: Routing in Action

### File-Based Routing Example:

For a controller named Home.php, the default route is:

```arduino
/home
```

### Custom Route Example:

```php
<?php

class Home extends Controller
{
    #[Get('/dashboard')]
    public function dashboard(Request $request)
    {
        return 'Welcome to the Dashboard!';
    }
}
```

Access this route via http://localhost:8000/dashboard.

# Models in Mono

Mono's Model classes act as blueprints for database tables, providing powerful methods to interact with your database. They simplify CRUD (Create, Read, Update, Delete) operations, migrations, and schema management while keeping your codebase clean and maintainable.

---

## Creating a Model

To create a new model, use the Mono CLI:

```bash
php mono -g mod <filename>
```

or

```bash
php mono gen model <filename>
```

or

```bash
php mono generate model <filename>
```

What Happens?

A new model class file <filename>.php will be created in the models directory.

The generated class will include:

A default id attribute.

A commented static function for database migration setup, which you can configure to suit your needs.

## Model Basics

### Table Mapping

The model class name maps to the corresponding database table name with an appended 's'.

For example:

User.php refers to the users table in your database.

## Built-in Methods

Mono models come with several powerful static and public methods:

### Static Methods

- **find()**
- **findById()**
- **query()**
- **migrateModel()**
- **initModels()**

### Public Methods

- **save()**
- **update()**
- **delete()**

## MigrateModel Method

The migrateModel() method is used to define and initialize your database table schema. This method allows you to specify the columns and their configurations.

Steps to Migrate:
Define your table structure in the migrateModel() method of your model class.
Run the following command to push the changes to your database:

```bash
php mono db push
```

Example: User Model with Migration

```php
<?php

class User extends Model
{
    public $id, $username, $password;

    public function __construct($id = null, $username = null, $password = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function initUser()
    {
        self::migrateModel("
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(100) NOT NULL
        ");
    }
}
```

Ensure your database configurations are correctly set in the src/config folder before running migrations.

## Save() Method

The save() method saves a new instance of your model to the corresponding database table.

Example:

```php
$new_user = new User(
    username: "zornnn",
    password: "zorn123456"
);

$new_user->save();
```

#### Error Handling:

The save() method throws a PDOException on error. Use a try-catch block to handle exceptions gracefully:

```php
try {
    $new_user = new User(
        username: "zornnn",
        password: "zorn123456"
    );

    $new_user->save();

    http_response_code(201);
    return json([
        'message' => 'New user created.'
    ]);
} catch (PDOException $e) {
    http_response_code(400);
    return json([
        'message' => $e->getMessage()
    ]);
}
```

## Find() and FindById() Methods

#### find() Method

Retrieves all rows from the table.
Accepts optional filtering criteria.
Example:

```php
// Retrieve all users
$users = User::find();

// Retrieve specific users by criteria
$user = User::find(['username' => $username]);
```

The find() method returns an array of objects, where each object is an instance of the model class.

###### findById() Method

Retrieves a specific row based on its primary key (id).
Example:

```php
$user = User::findById(id: 1);
```

The findById() method returns a single object of the calling model class.

Note:
The findById() method requires the primary key column to be named id.

## Update() Method

The update() method updates specific data in the database. It accepts arguments corresponding to the model's constructor but only patches the specified fields.

Example:

```php
$user = User::findById(id: 1);

$user->update(
    username: 'new_username123'
);
```

#### Error Handling:

Use a try-catch block to handle errors:

```php
try {
$user = User::findById(id: 1);

    $user->update(
        username: 'new_username123'
    );

    http_response_code(201);
    return json([
        'message' => 'User has been updated.'
    ]);

} catch (PDOException $e) {
    http_response_code(400);
    return json([
    'message' => $e->getMessage()
    ]);
}
```

## Delete() Method

The delete() method removes a specific row from the database.

Example:

```php
try {
$user = User::findById(id: 1);

    $user->delete();

    http_response_code(205);
    return json([
        'message' => 'User has been deleted.'
    ]);

} catch (PDOException $e) {
    http_response_code(400);
    return json([
    'message' => $e->getMessage()
    ]);
}
```

Mono's models are designed to simplify database operations and improve development productivity. With built-in methods and flexible schema management, working with your database becomes seamless and efficient.

# Middleware in Mono

Middlewares in Mono allow you to manage authentication, authorization, and request validation processes. They are reusable, flexible, and can be applied to specific controller methods or entire controllers.

---

## Creating a Middleware

Use the Mono CLI to generate a new middleware class:

```bash
php mono -g mid <filename>
```

or

```bash
php mono gen middleware <filename>
```

or

```bash
php mono generate middleware <filename>
```

What Happens?

A new middleware class file <filename>.php will be created in the middleware directory.

The generated class will include a runnable() method that gets executed when the middleware is triggered.

Example: Basic Middleware

```php
<?php

use App\Core\Middleware;

class Auth extends Middleware
{
    static function runnable(Request $request, callable $next)
    {
        echo 'Auth Middleware';

        return $next();
    }
}
```

The $next() callable moves the request to the next middleware in the pipeline or to the target controller.

You can use this method to intercept and handle requests.

## Handling Responses in Middleware

Inside the runnable() method, you can return various responses based on your needs:

- **Void:** To terminate the request flow without a response.
- **json():** To return JSON responses for API endpoints.
- **view():** To render views for UI responses.
- **redirect():** To redirect users to another route.

## Example: JWT Authentication Middleware

Middlewares are an ideal place to handle authentication and authorization processes. You can use Mono's native JWT handling capabilities to verify tokens.

```php
<?php

use App\Core\Middleware;

class Auth extends Middleware
{
    static function runnable(Request $request, callable $next)
    {
        $jwt = $request->cookies['auth_token'] ?? "";

        $key = "sample_secret_key";

        $payload = Token::verify($jwt, $key);

        if (!$payload) {
            return redirect('/login');
        }

        return $next();
    }
}
```

## Using Middlewares

Middlewares can be applied to individual controller methods or entire controllers using the #[Middleware] attribute.

## Applying to a Method

To use a middleware for a specific method, instantiate it within the #[Middleware] attribute above the target method.

Example:

```php
<?php

class Home extends Controller
{
    #[Get()]
    #[Middleware(new Auth)]
    public function index(Request $request)
    {
        return view('Home');
    }
}
```

In this example, the Auth middleware will be triggered before the index() method is executed.

## Applying to a Controller

Middlewares can also be applied to an entire controller. This allows you to manage requests for all methods within the controller.

Example:

```php
<?php

#[Middleware(new Auth)]
class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return view('Home');
    }

    #[Post()]
    public function create(Request $request)
    {
        // Logic for creating a new resource
    }
}
```

In this example, the Auth middleware will handle requests for both index() and create() methods.

Middlewares in Mono provide a powerful way to handle cross-cutting concerns such as security, validation, and logging. By reusing middleware classes, you can keep your code modular, maintainable, and clean.

# Views in Mono Framework

Mono Framework leverages the **Twig templating engine** to provide dynamic and powerful rendering capabilities for your application. Views in Mono allow you to create clean, reusable, and easily maintainable HTML templates for your web application.

---

## Creating a View

Use the Mono CLI to generate a new view file:

```bash
php mono -g vw <filename>
```

or

```bash
php mono gen view <filename>
```

or

```bash
php mono generate view <filename>
```

What Happens?

A new Twig template file <filename>.twig will be created in the views directory.

The generated file contains a default HTML snippet and an <h1> tag with the name of the file.

###### Example Generated View:

For a view named Home:

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
  </head>
  <body>
    <h1>Home</h1>
  </body>
</html>
```

## Returning a View in Mono

To render a view from a controller, use the view() function.

Example:

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return view("Home");
    }
}
```

The view("Home") function renders the Home.twig template located in the views directory.

## Passing Data to a View

The view() function allows you to pass data from the controller to the view as an associative array.

Example:
Controller:

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return view("Home", ["name" => "KENDRICK"]);
    }
}
```

View (Home.twig):

```html
<h1>{{ name }}</h1>
```

In this example, the name variable from the controller is accessible in the view using Twig's {{ variable }} syntax.

The rendered HTML will output: <h1>KENDRICK</h1>.

#### Benefits of Twig Templating

Twig provides numerous advantages, including:

- **Separation of Concerns:** Keep your presentation layer clean and separate from your business logic.
- **Reusable Components:** Use Twig's features like includes and blocks for reusable and modular templates.
- **Security:** Twig escapes output by default, preventing XSS attacks.
- **Dynamic Rendering:** Easily loop through data or apply conditional logic.

###### Example of Dynamic Rendering with Twig:

Controller:

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return view("Home", ["users" => ["Alice", "Bob", "Charlie"]]);
    }
}
```

View (Home.twig):

```html
<h1>Users</h1>
<ul>
  {% for user in users %}
  <li>{{ user }}</li>
  {% endfor %}
</ul>
```

Rendered HTML:

```html
<h1>Users</h1>
<ul>
  <li>Alice</li>
  <li>Bob</li>
  <li>Charlie</li>
</ul>
```

### Learn More About Twig

To explore more features of Twig, such as filters, macros, and advanced templating capabilities, refer to the Twig Documentation.

# Services in Mono Framework

Services in Mono are designed to encapsulate business logic and functionality that can be reused across multiple controllers. This helps keep your controllers clean and focused on handling routes, while the service layer manages complex logic.

---

## Creating a Service

To generate a new service, use the Mono CLI:

```bash
php mono -g ser <filename>
```

or

```bash
php mono gen ser <filename>
```

or

```bash
php mono generate service <filename>
```

What Happens?

A new service class <filename>.php will be created in the services directory.

The service class will contain static methods similar to those found in controllers.

If a controller does not exist for the service, it will be automatically created for you.

Example: Service Class

```php
<?php

class ProductsService
{
    static function index(Request $request)
    {
        $product = [
            'name' => 'Brandyy',
            'brand' => 'Brand X',
            'expiration' => 'November 23, 2030'
        ];

        return json([
            'product' => $product
        ]);
    }
}
```

In this example, the ProductsService contains a static index() method that returns a product in JSON format.

## Using a Service in a Controller

Once the service is created, you can call its static methods from within your controllers. This decouples business logic from route handling, making your code more modular and maintainable.

Example: Controller Using the Service

```php
<?php

class Products extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return ProductsService::index($request);
    }
}
```

In this example, the ProductsController calls the index() method from ProductsService.

#### Benefits of Using Services

- **Separation of Concerns:** Services help separate complex business logic from the controller, making the controller focused only on routing.
- **Code Reusability:** Services can be reused across multiple controllers, avoiding duplicate code and promoting DRY (Don’t Repeat Yourself) principles.
- **Better Organization:** Using services helps keep your application well-structured, with clear responsibilities assigned to different layers.
- **Easier Refactoring:** Services make it easier to refactor and maintain complex logic over time.

#### When to Use Services?

- When the logic behind a specific task is too complex for a controller.
- When you need to share logic across multiple controllers.
- When you want to cleanly separate business logic from HTTP-related functionality.

# Routing with Mono Framework

Mono uses a hybrid routing system that combines both file-based routing and attribute-based routing. This approach results in improved performance while maintaining flexibility for complex routing needs. The hybrid nature allows for fast routing while still enabling advanced features like dynamic and nested routes.

---

## Base Routes

In Mono, base routes are defined by the name of the controller file. The file name of the controller determines the base path for its routes.

### Example: Base Route

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return 'Welcome to the Home Page!';
    }
}
```

The Home.php controller corresponds to the /home route.
By default, the Home.php controller is linked to the / route, so /home and / point to the same controller.
Nested Routes
Nested routes are routes defined within a controller that extend the base route. They are appended to the base route path.

Example: Nested Route

```php
<?php

class Users extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return 'Users Controller';
    }

    #[Get('/profile')]
    public function profile(Request $request)
    {
        return 'This is the Profile route handler';
    }
}
```

/users maps to the index() method.
/users/profile maps to the profile() method.

Explanation:

The route path /profile is appended to the controller's base route (/users).

This approach allows for clear and logical route structure, making the system flexible and extensible.

## Dynamic Routes

Dynamic routes allow for capturing variable parts of a URL. In Mono, dynamic segments are indicated by a colon (:) before the parameter name.

Example: Dynamic Route

```php
<?php

class Users extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return 'Users Controller';
    }

    #[Get('/:id')]
    public function show(Request $request)
    {
        return 'User ID: ' . $request->param['id'];
    }
}
```

/users/12 will pass 12 to the show() method as the id parameter.

Dynamic routes are useful for handling resources that can be identified by unique identifiers, such as user IDs.

Example Requests:

/users/12 will result in User ID: 12.
/users/11 will result in User ID: 11.

## Parsing Dynamic Route Parameters

To access the dynamic parameters, use the $request->param array. This array contains the values of the dynamic segments in the URL.

### Example: Accessing Dynamic Parameter

For the route /users/:id, you can access the id parameter like this:

```php
$id = $request->param['id']; // Example: $id = 12
```

## Query Parameters

In addition to route parameters, you can also retrieve query parameters from the URL using $request->query. These parameters are typically appended to the URL after a question mark (?).

Example: Query Parameters

For the URL /users?id=12, you can access the query parameter like this:

```php
$userId = $request->query['id']; // Example: $userId = 12
```

## Request Methods

Mono supports several HTTP methods to define how routes are handled. These methods are represented by the following route attributes:

#[Get()] for GET requests #[Post()] for POST requests #[Put()] for PUT requests #[Patch()] for PATCH requests #[Delete()] for DELETE requests

Example: Request Method Attributes

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return view('Home');
    }

    #[Post('/submit')]
    public function submit(Request $request)
    {
        return json(['message' => 'Form Submitted']);
    }
}
```

/home is mapped to the index() method via the GET request.
/home/submit is mapped to the submit() method via the POST request.

## Handling Different Request Methods

If you define multiple methods for the same path but with different HTTP methods, Mono will treat each request method separately.

# The Route Attributes: Get(), Post(), Patch(), Put(), Delete()

Mono uses route attributes to define how requests are mapped to controller methods. These attributes function similarly to annotations in other languages and allow for clean, expressive routing definitions.

Each attribute corresponds to a specific HTTP method and can include an optional path parameter to specify a route.

Example: Route Attribute Usage

```php
<?php

class Home extends Controller
{
    #[Get()]
    public function index(Request $request)
    {
        return view("Home");
    }

    #[Get('/profile')]
    public function profile(Request $request)
    {
        return view("Profile");
    }
}
```

#[Get()] corresponds to the /home route (default route for the Home.php controller). #[Get('/profile')] corresponds to /home/profile.

By default, if no specific path is provided, Mono assumes that the route corresponds to the controller's base route.

### Summary

Mono’s hybrid routing system combines the performance benefits of file-based routing with the flexibility of attribute-based routing. This makes it easy to define both simple and complex routes, including dynamic and nested routes, while keeping the routing system fast and efficient. Whether you need basic routes or dynamic paths, Mono’s routing system has you covered.

# Native JWT Token Class: sign() and verify() Methods

In Mono, the native JWT token functionality is provided through the Token class, which includes two static methods: sign() and verify(). These methods are used to handle authentication by generating and verifying JWT tokens.

---

## Sign() Method

The sign() method is used to create a hashed token by providing a payload and a secret key. You can also set an expiration time for the token.

### Example: Signing a Token

```php
$payload = [
    'userId' => 07737477
];

$secret = 'hGS7asBcczaUcsa';

$jwt = Token::sign($payload, $secret);
```

This will generate a JWT token with the provided payload and secret key.
Example: Signing a Token with Expiration

```php
$payload = [
    'userId' => 07737477
];

$secret = 'hGS7asBcczaUcsa';

$jwt = Token::sign($payload, $secret, 60 _ 60 _ 24); // Token expires in 24 hours
```

The third argument is the expiration time in seconds. In this example, the token expires in 24 hours.

## Verify() Method

The verify() method is used to check the validity of the JWT token. If the token is valid, it returns the decrypted payload; otherwise, it returns false.

Example: Verifying a Token

```php
$payload = Token::verify($jwt, $secret);

if (!$payload) {
    return redirect('/login');
}
```

This example verifies the token using the same secret key. If the token is invalid, the user is redirected to the login page.

Both sign() and verify() methods are essential for handling authentication in your application, ensuring that users are properly authenticated using JWT tokens.

# Validator Class

Mono also provides a Validator class to help you validate data, such as user inputs, by passing a set of filters and the data to be validated.

## Using the Validator Class

To validate data, you need to pass an array of validation rules and the data you want to validate. The validator will check if the data meets the specified criteria.

Example: Validating User Input

```php
$email = $request->body['email'];
$password = $request->body['password'];

$result = new Validator([
    'email' => [
    'type' => 'email',
    'required' => true,
    ],
    'password' => [
        'required' => true,
        'length' => [
            'min' => 8,
            'max' => 50
        ],
        'message' => 'Password must be at least 8 characters long.'
    ]
    ], ['email' => $email, 'password' => $password]);

if (!$result->isValid()) {
    return json(['errors' => $result->getErrors()]);
}

return json(['msg' => 'Registered successfully.']);
```

In this example, the Validator checks:

The email is a valid email and is required.

The password is required and its length is between 8 and 50 characters. If the password is shorter than 8 characters, it returns a custom error message.

## Validator Features

Type: You can specify the type of data (e.g., email, number, etc.).
Required: This flag ensures that the data is present.
Length: You can specify a minimum and maximum length for string data.
Custom Messages: You can provide custom error messages. If no custom message is provided, a default error message is used.
Checking Validation Results
You can use the following methods to handle validation results:

isValid(): Returns true if all validations pass; otherwise, false.
getErrors(): Returns an array of error messages if the validation fails.
Example: Handling Errors

```php
if (!$result->isValid()) {
    return json(['errors' => $result->getErrors()]);
}
```

This example checks if the validation passed and returns any errors if they exist.

### Summary

JWT Token Methods:
sign() for generating a token.
verify() for validating a token.
Validator Class:
Provides flexible and powerful data validation.
Supports multiple validation rules, custom messages, and error handling.
These tools help ensure that your application handles authentication and data validation securely and efficiently.
