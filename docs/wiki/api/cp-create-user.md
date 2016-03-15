#### Resource URL
`POST /api/control-panel/users`

#### Description
  Adds new user

#### Resource information:
  Requires authentication:yes  
  Response formats: `JSON`

#### Post parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `string` | yes      | username                          | Username
| `string` | yes      | password                          | User password
| `string` | yes      | email                             | User email


#### Example Request
`POST /control-panel/users`
```JSON
{
  "username": "admin",
  "password": "admin",
  "email": "admin@example.com"
}
```

#### Example Result
```JSON
{
	"username": "admin",
	"email": "admin@example.com",
	"created_at": "2016-03-10 14:21:13",
	"updated_at": "2016-03-10 14:21:13"
}
```