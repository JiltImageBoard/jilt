#### Resource URL
`PUT /api/boards/{name}/threads/{thread_num}`

#### Description
  Edits thread if editor authorized or thread is posted by editor.

#### Resource information:
  Requires authentication: optional
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Name of board
| `int`    | required | thread_num           | Thread number

#### Put parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | optional | name                 | Poster name
| `string` | optional | subject              | Thread subject
| `string` | optional | message              | Thread message
| `array`  | optional | images               | Thread images


#### Example Request
```javascript
PUT /boards/test/threads/123/edit
{
  "name": "Anon",
  "message": "Edited message",
  "subject": "Edited subject",
  "images": []
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```