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
`POST /boards/test/threads/123/posts`
```JSON

```

#### Example Result
Status code: `201`
```JSON

```