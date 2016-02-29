#### Resource URL
`POST /api/boards/{name}/threads`

#### Description
  Adds thread to specific board. Needs at least one image or message

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Name of board

#### Post parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | optional | name                 | Poster name
| `string` | optional | text                 | Thread message text
| `string` | optional | subject              | Thread subject
| `array`  | optional | files                | Thread files
| `bool`   | optional | is_chat              | Is chat

#### Example Request
```javascript
POST /boards/test/threads
{
  "name": "Anon",
  "text": "Example message",
  "subject": "Example subject"
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```
