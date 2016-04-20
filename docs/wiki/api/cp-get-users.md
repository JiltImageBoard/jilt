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
Status code: `200`
```JSON
[{
	"id": 1,
	"username": "Test",
	"email": "Test@Test.com",
	"createdAt": "2016-03-12 17:15:43",
	"updatedAt": "2016-04-18 12:15:14",
	"authKey": "",
	"isAdmin": 1,
	"canCreateBoards": 1,
	"canDeleteBoards": 1
}, {
	"id": 2,
	"username": "Test2",
	"email": "Test2@ya.riu",
	"createdAt": "2016-04-18 15:11:58",
	"updatedAt": "2016-04-18 15:11:58",
	"authKey": "",
	"isAdmin": 0,
	"canCreateBoards": 0,
	"canDeleteBoards": 0
}, {
	"id": 3,
	"username": "Test2",
	"email": "Test2@ya.riu",
	"createdAt": "2016-04-18 15:12:36",
	"updatedAt": "2016-04-18 15:12:36",
	"authKey": "",
	"isAdmin": 0,
	"canCreateBoards": 0,
	"canDeleteBoards": 0
}]
```