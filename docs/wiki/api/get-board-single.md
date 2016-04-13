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
```JSON
[{
	"boardName": "test",
	"number": 1,
	"isSticked": 1,
	"isLocked": 1,
	"isChat": 0,
	"isOpMarkEnabled": 1,
	"name": "TestName",
	"subject": "TestSubject",
	"message": "TestMessage",
	"files": [], 
	"isModPost": 0,
	"createdAt": "2016-02-05 19:58:40",
	"updatedAt": "2016-02-05 19:58:40"
}, {
	"boardName": "test",
	"number": 2,
	"isSticked": 1,
	"isLocked": 1,
	"isChat": 0,
	"isOpMarkEnabled": 1,
	"name": "TestName",
	"subject": "TestSubject",
	"message": "TestMessage",
	"files": [],
	"isModPost": 0,
	"createdAt": "2016-02-05 19:58:40",
	"updatedAt": "2016-02-05 19:58:40"
}]
```