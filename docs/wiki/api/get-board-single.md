#### Resource URL
`GET /api/boards/{name}/pages/{page_num}`

#### Description
  Gets threads from the board

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`


#### Url parameters
| type     | required           | name                 | description
|----------|--------------------|----------------------|-------------
| `string` | yes                | name                 | Name of board
| `int`    | default:0          | page_num             | Page number


#### Example Request
```javascript
GET /boards/test/pages/1
```

#### Example Result
```
//TODO
```