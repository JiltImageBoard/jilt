#### Resource URL
`GET /api/control-panel/users/{id}`

#### Description
  Gets user by id

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id


#### Example Request
`GET /control-panel/users/5`

#### Example Result
```JSON
{
	"username": "test",
	"email": "test@gmail.com",
	"created_at": "2016-03-10 14:10:21",
	"updated_at": "2016-03-10 14:10:21"
}
```