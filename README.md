### Forum Management API

This project is a **Forum Management System** focused on demonstrating **full-text search** and **indexing** capabilities using **PostgreSQL**. The primary objective of this API is to showcase efficient querying of large datasets through optimized indexing and partitioning strategies. The system includes features like **posts**, **comments**, and **private messaging**, and the project allows users to test fetch operations for these entities, including full-text search and paginated retrieval. **The API is read-only**, meaning it does not provide endpoints for creating or modifying forums, posts, or categories, but focuses on retrieving and searching data efficiently.

Additionally, the project includes a custom Artisan command to manage **partitioning** for tables like **posts**, **comments**, and **private messages** to enhance database performance as data grows over time.

### Key Features:
- **Full-Text Search**: Perform efficient searches on posts and comments using PostgreSQL's full-text search capabilities.
- **Indexing**: Optimized indexing on content fields to demonstrate fast and scalable queries.
- **Pagination**: Supports pagination for posts, comments, and private messages.
- **API Authentication**: Secured API using **Laravel Passport**.
- **Read-Only API**: The project focuses on querying and fetching data, and does not include endpoints for creating or modifying forums, posts, categories, or other entities.

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

### Example: Running Partition Creation Command

You can use the custom Artisan command to create new partitions for the `posts`, `comments`, and `private_messages` tables dynamically. This is useful for optimizing performance by splitting large datasets into smaller, manageable partitions based on the year.

#### Command Example:

To create a new partition for the current year:

```bash
php artisan partitions:create
```

To create a new partition for a specific year, for example, 2025:

```bash
php artisan partitions:create 2025
```

This command ensures that new partitions are created only if they do not already exist.

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

This project primarily focuses on **query performance**, showcasing how **full-text search** and **partitioning** strategies can be applied to a forum-like system. With the ability to handle large datasets efficiently through indexing and partitioning, users can test various queries, including retrieving posts, comments, and private messages. The inclusion of a custom partitioning command allows easy creation of new partitions, ensuring optimal performance as the dataset grows. This project does not include write operations such as creating or modifying posts, forums, or categories, but instead highlights read operations and their performance optimizations.