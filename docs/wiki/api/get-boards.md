#### Resource URL
`GET /api/boards/`

#### Description
  Gets all boards

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`


#### Example Request
`GET /api/boards/`

#### Example Result
```JSON
HTTP/1.1 200 OK
[{
    "id": 1,
	"name": "test1",
	"description": "test1"
}, {
    "id": 2,
	"name": "test",
	"description": "Test board"
}]
```