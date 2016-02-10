#### Resource URL
`GET /api/boards/{name}/threads/{thread_id}`

#### Description
  Gets thread by id and board name

#### Resource information:
  Requires authentication: no
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Name of board
| `string` | required | thread_id            | Thread id


#### Example Request
```javascript
GET /boards/test/threads/123
```

#### Example Result
```javascript
//TODO
```