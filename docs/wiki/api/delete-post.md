#### Resource URL
`DELETE /api/boards/{name}/threads/{thread_num}/posts/{post_num}`

#### Description
  Deletes post

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                 | description
|----------|----------|----------------------|-------------
| `string` | required | name                 | Board name
| `int`    | required | thread_num           | Thread number
| `int`    | required | post_num             | Post number


#### Example Request
`DELETE /boards/test/threads/123/posts/1`

#### Example Result
Status code: `204`

```