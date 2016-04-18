#### Resource URL
`GET /api/boards/{name}/threads/{thread_num}/posts/{post_num}`

#### Description
  Gets post by board name, thread number and post number

#### Resource information:
  Requires authentication: no  
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Board name
| `int`    | required | thread_num           | Thread number
| `int`    | required | post_num             | Post number


#### Example Request
`GET /boards/test/threads/123/posts/1`

#### Example Result
Status code: `200`
```JSON

```