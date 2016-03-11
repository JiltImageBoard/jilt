#### Resource URL
`GET /api/boards/{name}/threads/{thread_num}`

#### Description
  Gets thread by num and board name

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Name of board
| `string` | required | thread_num           | Thread num


#### Example Request
```javascript
GET /boards/test/threads/123
```

#### Example Result
```javascript
//TODO
```
