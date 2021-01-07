# Authentication microservice using Lumen

![StyleCI](https://github.styleci.io/repos/327249822/shield?branch=master)

## Purpose

This is a trial project to build a authentication service using Lumen that
provides minimum functionalities. Although this is a trial project, I hope to
make it suitable for later (or others) use as boilerplate or foundation for
production projects or products.

## Features

This package is built using [jwt-auth](https://github.com/tymondesigns/jwt-auth)
to provide JWT authentication service. It *only* supports HTTP authorization
header with JWT tokens. And the token type must be `bearer`.

The database consists of a minimum set of columns, including user credentials.
Other user properties are expected to be handled by separate service rather than
this one. To expand the data scope, one has to amend database migration
and `AuthController`.

## List of end points

### `/register`

Creates a new user. Parameters include `name`, `email`, and `password` with
confirmation. Do *not* provide authorization header to this end point.

#### Request parameters

```json
{
    "name": "new-user",
    "email": "some.one@example.com",
    "password": "just a password",
    "password_confirmation": "just a password"
}
```

All these fields are required, and the `password` and `password_confirmation`
must be identical. Although this is a JSON end point, it accepts good old form
data too. Upon success, it returns some information about the created record.

#### Success response

```json
{
  "user": {
    "name": "test-user1",
    "email": "someone1@example.com",
    "updated_at": "2021-01-07T10:32:49.000000Z",
    "created_at": "2021-01-07T10:32:49.000000Z",
    "id": 230
  },
  "message": "User has been successfully created."
}
```

#### Customization

To expand or change registration information, such as adding phone number. One
has to first add the phone number to database migration, update validation rules
and the `User` model creation inside `AuthController::register()`.

### /login

Checks the provided credentials and generates a JWT token if the credentials are
valid. Do *not* provide authorization header to this end point.

#### Request parameters

```json
{
    "email": "some.one@example.com",
    "password": "just a password"
}
```

#### Success response

```json
{
  "token": "the newly generated JWT token",
  "token_type": "bearer",
  "expires_in": 3600
}
```

Please note that the `token_type` will always be `"bearer"`, and `expires_in` is
in seconds. As mentioned above, when using this token, the type of the HTTP
authorization header must be `bearer`. e.g. `Authorization: bearer JWT_token`

#### Customization

To change the login field, say using phone number instead of email. Beside
modifications mentioned in registration customization, one has to change the
`AuthController::login()` method to use the new identify field.

### /refresh

Refresh a token. The authorization header is required. There is no request body.

#### Request parameters

##### HTTP header

```text
Authorization: bearer JWT_token
```

#### Success response

```json
{
  "token": "the newly generated JWT token",
  "token_type": "bearer",
  "expires_in": 3600
}
```

### /logout

Logout the token, rendering it invalid for further use. The authorization header
is required. There is no request body.

#### Request parameters

##### HTTP header

```text
Authorization: bearer JWT_token
```

#### Success response

```json
{
  "message": "See you soon."
}
```
