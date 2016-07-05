#### Resource URL
`GET /api/boards/{name}`

#### Description
  Gets board settings

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | name                              | Name of board


#### Example Request
`GET /api/boards/test`

#### Example Result
Status code: `200`
```JSON
{
	"id": 86,
	"name": "test",
	"description": "Test board",
	"createdAt": "2016-02-17 13:24:21",
	"updatedAt": "2016-02-22 10:54:44",
	"minFileSize": 1,
	"maxFileSize": 1,
	"minImageResolution": "1",
	"maxImageResolution": "1",
	"maxMessageLength": 1,
	"maxThreadsOnPage": 1,
	"maxBoardPages": 1,
	"threadMaxPosts": 1,
	"defaultName": "Anon",
	"isClosed": 0,
	"isDeleted": 0
}
```

