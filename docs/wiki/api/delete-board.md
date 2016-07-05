#### Resource URL
`DELETE /api/boards/{board_name}`

#### Description
  Deletes board by board name

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | yes      | name                 | Name board to delete


#### Example Request
`DELETE /boards/test`

#### Example Result
Status code: `204`