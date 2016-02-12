#### Resource URL
`GET /api/control-panel/users`

#### Description
  Gets user list

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Example Request
```javascript
GET /control-panel/users
```

#### Example Result
```javascript
{
	"users": [
	{
		"id": "1",
		"username": "admin",
		"email": "admin@example.com"
	},
	{
		"id": "2",
		"username": "admin2",
		"email": "admin2@example.com"
	},
	{
		"id": "3",
		"username": "admin3",
		"email": "admin3@example.com"
	}]
}
```