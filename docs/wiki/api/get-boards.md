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
Status code: `200`
```JSON
[{
    "id": 1,
	"name": "Test board 1",
	"description": "Test board 1"
},{
    "id": 2,
   	"name": "Test board 2",
   	"description": "Test board 2"
   }]
```