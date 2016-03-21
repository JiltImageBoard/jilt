#### Resource URL
`GET /api/control-panel/users`

#### Description
  Gets user list

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Example Request
`GET /control-panel/users`

#### Example Result
```JSON
[{
	"id": 2,
	"username": "test",
	"email": "test@gmail.com",
	"created_at": "2016-03-10 14:10:21",
	"updated_at": "2016-03-10 14:10:21"
}, {
	"id": 3,
	"username": "testtest",
	"email": "testtest@gmail.com",
	"created_at": "2016-03-10 14:19:30",
	"updated_at": "2016-03-10 14:19:30"
}, {
	"id": 4,
	"username": "testtest1",
	"email": "te23ttest@gmail.com",
	"created_at": "2016-03-10 14:21:13",
	"updated_at": "2016-03-10 14:21:13"
}]
```