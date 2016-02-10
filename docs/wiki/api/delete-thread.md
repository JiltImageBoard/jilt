#### Resource URL
`DELETE /api/boards/{name}/threads/{thread_num}`

#### Description
  Deletes thread by thread number and board name

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | optional | name                 | Board name
| `string` | optional | thread_nm            | Thread number


#### Example Request
```javascript
DELETE /boards/test/threads/123
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```