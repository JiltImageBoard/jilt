#### Resource URL
`PUT /api/boards/{name}/threads/{thread_num}/posts/{post_num}`

#### Description
  Edits post if editor authorized or post is posted by editor.

#### Resource information:
  Requires authentication: optional
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Board name
| `int`    | required | thread_num           | Thread number
| `int`    | required | post_num             | Post number

#### Put parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | optional | name                 | Poster name
| `string` | optional | message              | Message
| `string` | optional | subject              | Subject
| `array`  | optional | images               | Images


#### Example Request
`PUT /boards/test/threads/123/posts/1`
```JSON
{
  "name": "Anon",
  "message": "Edited message",
  "subject": "Edited subject"
}
```

#### Example Result

Status code: `200`
```JSON
```