#### Resource URL
`GET /api/boards/{name}/pages/{pageNum}`

#### Description
  Gets threads from the board

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`


#### Url parameters
| type     | required           | name                 | description
|----------|--------------------|----------------------|-------------
| `string` | yes                | name                 | Name of board
| `int`    | default:0          | pageNum              | Page number


#### Example Request
`GET /boards/test/pages/0`

//TODO: Доделать файлы
#### Example Result
Status code: `200`
```JSON
[{
	"id": 135,
	"boardName": "test",
	"number": 2,
	"isSticked": 0,
	"isLocked": 0,
	"isChat": 0,
	"isOpMarkEnabled": 0,
	"name": "Anon",
	"subject": "Test",
	"message": "Test",
	"files": [],
	"isModPost": 0,
	"createdAt": "2016-04-18 08:35:38",
	"updatedAt": "2016-04-18 08:35:38"
}]
```