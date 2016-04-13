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

```