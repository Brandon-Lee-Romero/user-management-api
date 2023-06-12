
# USER MANAGEMENT API

## Description

The User Management API provides CRUD operations with bulk delete, search functionality, and pagination for managing users.

## Post-Installation Instructions
After installing the User Management API, you may need to perform the following steps:
1. Configure Database Connection
2. Run Database Migration and seed : `php artisan migrate --seed`   This will seed 10 random user
   <br>  Default admins
        <ul> 
              <li><strong> username : admin-01 to admin-05 </strong> </li>
              <li><strong> password : password  </strong>  </li>
        </ul>
 3. Generate Application Key : `php artisan key:generate`
 4. Start the api server : `php artisan serve` 

## API Documentation
The User Management API exposes the following endpoints:
| Method | Endpoint            | Description                      |
| :----- | :------------------ | :------------------------------- |
| GET    | `/users`            | Retrieves a list of all users.   |
| POST   | `/users`            | Creates a new user.              |
| GET    | `/users/{id}`       | Retrieves a specific user by ID. |
| PUT    | `/users/{id}`       | Updates an existing user by ID.  |
| DELETE | `/users/{id}`       | Deletes a user by ID.            |
| DELETE | `/users/bulk-destroy`| Deletes selected users.            |

***

### USER CREATE
POST url : `/users`

**Request Body:**
   - `first_name'` : required string min:2 max:50,
   - `last_name'` : required string min:2 max:50,
   - `address'` : required string min:5 max:150,
   - `postcode' ` : required string min:4 max:150,
   - `contact_number'` : required numeric digits:11 unique:users,
   - `email'` : required email unique:users,
   - `username'` : required string min:4 max:20 unique:users,
   - `password'` : required min:6 max:24 confirmed

**Request Body Example:**
```josn
{
    "first_name": "John",
    "last_name": "Doe",
    "address": "1784 Yost Village Apt. 206\nVerdafurt, OK 18132",
    "postcode": "2066",
    "contact_number": "09112345678",
    "email": "johndoe@mail.com",
    "username": "johndoe",
    "password": 123456,
    "password_confirmation" : 123456
}
```

**Response Example:**

```json

{
    "status": "success",
    "message": "Users created successfully",
    "data": {
        "first_name": "John",
        "last_name": "Doe",
        "address": "1784 Yost Village Apt. 206\nVerdafurt, OK 18132",
        "postcode": "2066",
        "contact_number": "09112345678",
        "email": "johndoe@mail.com",
        "username": "johndoe",
        "updated_at": "2023-06-12T04:10:05.000000Z",
        "created_at": "Jun-12-2023",
        "id": 17
    }
}
```
***

### USER UPDATE
PUT url : `/users/17` 

*you can update any of the input fields from the user model*
 
**Request Body Example:**
```josn
{
   "username": "updatedjohn"
}
```
**Response Example:**

```json

{
    "status": "success",
    "message": "User updated successfully"
}
```
***

### USER DETAILS
GET url : `/users/17` 
 
**Response Example:**

```json

{
    "status": "success",
    "message": "User retrieved successfully",
    "data": {
        "id": 17,
        "first_name": "John",
        "last_name": "Doe",
        "address": "1784 Yost Village Apt. 206\nVerdafurt, OK 18132",
        "postcode": "2066",
        "contact_number": "09112345678",
        "email": "johndoe@mail.com",
        "username": "updatedjohn",
        "created_at": "Jun-12-2023",
        "updated_at": "2023-06-12T04:17:47.000000Z"
    }
}
```

***
### USER DELETE
DELETE url : `/users/15` 
 
**Response Example:**

```json

{
    "status": "success",
    "message": "User deleted successfully"
}
```
***

### USER BULK DELETE
DELETE url : `/users/15` 

*accepts array of id from existing users*

 **Request Body Example:**
```josn
{
  "id" : [6, 8, 3]
}
```
**Response Example:**

```json

{
    "status": "success",
    "message": "Users deleted successfully "
}
```
***

### USER LIST
**Parameters for listing users :**
    
- `page` (optional): The page number for pagination.
- `limit` (optional): The number of users per page.
- `sort` (optional) : The sort column from the users table.
- `order` (optional) : The order of the users in ascendig or descending order
- `search` (optional) : The key word to filter users.

**Response Example:**

```json
[
   "status": "success",
    "message": "Users retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
           
            {
                "id": 7,
                "first_name": "Isobel",
                "last_name": "Douglas",
                "address": "11447 Baumbach Plaza Suite 904\nNew Zoramouth, HI 11278-1972",
                "postcode": "99115",
                "contact_number": "09158656649",
                "email": "rory68@example.org",
                "username": "jerrod.waelchi",
                "created_at": "Jun-12-2023",
                "updated_at": "2023-06-12T02:53:13.000000Z"
            },
            {
                "id": 6,
                "first_name": "Laverna",
                "last_name": "Waelchi",
                "address": "1784 Yost Village Apt. 206\nVerdafurt, OK 18132",
                "postcode": "53580",
                "contact_number": "09409727338",
                "email": "johnson.shaina@example.com",
                "username": "vlakin",
                "created_at": "Jun-12-2023",
                "updated_at": "2023-06-12T02:53:13.000000Z"
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/users?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://127.0.0.1:8000/api/users?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/users?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://127.0.0.1:8000/api/users",
        "per_page": 50,
        "prev_page_url": null,
        "to": 10,
        "total": 10
    }
] 
```
## TESTING
**To run the test:**
 - Configure Database Connection For Testing 
    ``` TEST_DB_CONNECTION=mysql
        TEST_DB_HOST=127.0.0.1
        TEST_DB_PORT=3306
        TEST_DB_DATABASE=user-management-test
        TEST_DB_USERNAME=root
        TEST_DB_PASSWORD=  
      ```
 - run `php artisan migrate --database=mysql_test`
 - ADD test/Unit directory if not found
 - RUN `php artisan test`

**provided below are the test cases: **

```
   PASS  Tests\Feature\AuthenticationTest
  ✓ admin can login                                                                                                                                                        0.41s  
  ✓ user with non admin type cannot login                                                                                                                                  0.07s  
  ✓ admin can logout                                                                                                                                                       0.01s  

   PASS  Tests\Feature\UserTest
  ✓ admin can create user                                                                                                                                                  0.07s  
  ✓ admin can get user                                                                                                                                                     0.01s  
  ✓ admin can list users                                                                                                                                                   0.01s  
  ✓ admin can search created users                                                                                                                                         0.01s  
  ✓ admin can update user                                                                                                                                                  0.02s  
  ✓ admin can delete user                                                                                                                                                  0.03s  
  ✓ admin can delete multiple user 
 ```



