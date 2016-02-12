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
```javascript
GET /control-panel/users/5
```

#### Example Result
```javascript
{
  "username": "admin",
  "email": "admin@example.com"
}
```