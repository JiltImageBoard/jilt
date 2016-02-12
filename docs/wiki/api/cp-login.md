#### Resource URL
`POST /api/control-panel/login`

#### Description
  Tries to authenticate using specified post data.
  On success user gets cookie with auth data.

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`

#### Post parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | yes      | username             | Name of user
| `string` | yes      | password             | User password


#### Example Request
```javascript
POST /control-panel/login
{
  "username": "admin",
  "password": "admin",
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```
`Cookie: PHPSESSID={token}`