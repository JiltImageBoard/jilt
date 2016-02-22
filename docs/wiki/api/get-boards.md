#### Resource URL
`GET /api/boards/`

#### Description
  Gets all boards

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`


#### Example Request
```javascript
GET /api/boards/
```

#### Example Result
```
HTTP/1.1 200 OK
[{
	"name": "test1",
	"description": "test1"
}, {
	"name": "test",
	"description": "Test board"
}]
```