#### Resource URL
`POST /api/boards/{name}/threads/{thread_num}/posts`

#### Description
  Adds post to thread. Need at least one image or message.

#### Resource information:
  Requires authentication: no
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Board name
| `int`    | required | thread_num           | Thread number

#### Post parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | optional | name                 | Poster name
| `string` | optional | message              | Message
| `string` | optional | subject              | Subject
| `array`  | optional | images               | Images


#### Example Request
```javascript
POST /boards/test/threads/123/posts
{
  "name": "Anon",
  "message": "Example message"
}
```

#### Example Result
```javascript
{
    "errorCode": 0,
    "errorMessage": ""
}
```