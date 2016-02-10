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
```javascript
DELETE /boards/test
```

#### Example Result
```javascript
{
  "errorCode" : 0,
  "errorMessage" : ""
}
```