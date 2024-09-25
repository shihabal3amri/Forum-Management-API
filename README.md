### Forum Management API

This project is a **Forum Management System** built using **Laravel** with a **PostgreSQL** database. The system supports forums, categories, posts, comments, tagging, and private messaging between users. It also includes full-text search for posts and comments and uses **Laravel Passport** for API authentication.

### Prerequisites

Before setting up the project, ensure you have the following installed:

- **PHP**
- **Composer** (PHP dependency manager)
- **Laravel**
- **PostgreSQL** (Database)
- **Postman** (for API testing)

### Installation Instructions

#### Step 1: Install Dependencies

Run the following command to install all the required dependencies:

```bash
composer install
```

#### Step 2: Set Up Environment Variables

Create a copy of `.env.example` and rename it to `.env`:

```bash
cp .env.example .env
```

Modify the necessary fields in the `.env` file to set up your database connection and application URL:

```env
APP_URL=http://localhost:8000
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=postgres_db
DB_USERNAME=postgres_username
DB_PASSWORD=postgres_password
```

#### Step 3: Run Database Migrations

Run the following command to migrate the database:

```bash
php artisan migrate
```

#### Step 4: Install Laravel Passport

Run the following command to install Passport, which is used for API authentication:

```bash
php artisan passport:install
```

Follow the prompts:
- When asked `Would you like to run all pending database migrations?`, answer `yes`.
- When asked to generate personal access and password grant clients, answer `yes`.

#### Step 5: Seed the Database

Run the following command to seed the database with initial data:

```bash
php artisan db:seed
```

#### Step 6: Run the Application

To start the server, run the following command:

```bash
php artisan serve
```

The application will now be available at `http://localhost:8000`.

#### Login with Seeded User

You can log in using the user created by the seeder:

- **Email**: `userone@example.com`
- **Password**: `password123`

### API Endpoints

Here are the main endpoints available in the Forum Management API:

#### 1. User Registration

- **Endpoint**: `POST /api/register`
- **Description**: Registers a new user.

**Request**:

```json
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response**:

```json
{
  "token": "your_auth_token",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  }
}
```

#### 2. User Login

- **Endpoint**: `POST /api/login`
- **Description**: Logs in a user and returns an access token.

**Request**:

```json
{
  "email": "johndoe@example.com",
  "password": "password123"
}
```

**Response**:

```json
{
  "token": "your_auth_token",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  }
}
```

#### 3. Get All Forums with Categories

- **Endpoint**: `GET /api/forums`
- **Description**: Retrieves all forums with their associated categories, paginated.

**Response**:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Tech Forum",
      "categories": [
        { "id": 1, "name": "General Discussion" },
        { "id": 2, "name": "Announcements" }
      ]
    }
  ],
  "total": 1,
  "per_page": 10
}
```

#### 4. Get Posts by Forum and Category

- **Endpoint**: `GET /api/forums/{forum}/categories/{category}/posts`
- **Description**: Retrieves posts in a specific forum and category, with their comments and tags, paginated.

**Response**:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "content": "This is a post in the General Discussion",
      "tags": [
        { "id": 1, "name": "Laravel" }
      ],
      "comments": {
        "current_page": 1,
        "data": [
          { "id": 1, "content": "This is a comment" }
        ],
        "total": 2,
        "per_page": 5
      }
    }
  ],
  "total": 5,
  "per_page": 10
}
```

#### 5. Get Posts by User

- **Endpoint**: `GET /api/users/{user}/posts`
- **Description**: Retrieves all posts created by a specific user, with their comments and tags, paginated.

**Response**:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "content": "This is a post created by the user",
      "tags": [
        { "id": 1, "name": "Laravel" }
      ],
      "comments": {
        "current_page": 1,
        "data": [
          { "id": 1, "content": "This is a comment" }
        ],
        "total": 2,
        "per_page": 5
      }
    }
  ],
  "total": 5,
  "per_page": 10
}
```

#### 6. Get Private Messages for the Authenticated User

- **Endpoint**: `GET /api/messages`
- **Description**: Retrieves all messages sent and received by the authenticated user, paginated.

**Response**:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "message": "Hello, how are you?",
      "sender_id": 1,
      "receiver_id": 2
    }
  ],
  "total": 10,
  "per_page": 10
}
```

#### 7. Full-Text Search for Posts and Comments

- **Endpoint**: `GET /api/search`
- **Description**: Performs a full-text search across posts and comments.

**Request**:

```http
GET /api/search?query=laravel
```

**Response**:

```json
{
  "posts": [
    {
      "id": 1,
      "content": "This is a post about Laravel",
      "comments": [
        { "id": 1, "content": "I love Laravel!" }
      ]
    }
  ],
  "comments": [
    {
      "id": 2,
      "content": "This comment mentions Laravel",
      "post": { "id": 1, "content": "This is a post about Laravel" }
    }
  ]
}
```

### Conclusion

This project provides a basic forum management system with full-text search capabilities and private messaging between users. It uses Laravel Passport for secure API authentication, and endpoints are available for users to register, log in, retrieve forums, posts, comments, and private messages. The project supports pagination and full-text search for both posts and comments.