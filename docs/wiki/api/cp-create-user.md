#### Resource URL
`POST /api/control-panel/users`

#### Description
  Adds new user

#### Resource information:
  Requires authenticationyes  
  Response formats: `JSON`

#### Post parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `string` | yes      | username                          | Username
| `string` | yes      | password                          | User password
| `string` | yes      | email                             | User email


#### Example Request
```javascript
POST /control-panel/users
{
  "username": "admin",
  "password": "admin",
  "email": "admin@example.com"
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```