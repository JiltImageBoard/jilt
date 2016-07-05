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
`POST /control-panel/login`
```JSON
{
  "username": "admin",
  "password": "admin"
}
```

#### Example Result
Status code: `200`

`Cookie: PHPSESSID={token}`