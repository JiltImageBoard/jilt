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
Status code: `200`
```JSON
{
	"id": 14,
	"username": "Test",
	"email": "Test@desu.com",
	"createdAt": "2016-03-12 17:15:43",
	"updatedAt": "2016-04-18 12:15:14",
	"authKey": "",
	"isAdmin": 1,
	"canCreateBoards": 1,
	"canDeleteBoards": 1
}
```