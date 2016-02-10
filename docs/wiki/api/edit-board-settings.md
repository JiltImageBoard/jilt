#### Resource URL
`PUT /api/boards/{name}`

#### Description
  Edits board settings

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | name                              | Name of board

#### Put parameters
| type     | required           | name                 | description
|----------|--------------------|----------------------|-------------
| `string` | yes                | name                 | Name of new board
| `string` | yes                | description          | Description of a new board
| `int`    | yes                | min_file_size        | Min file size in bytes
| `int`    | yes                | max_file_size        | Max file size in bytes
| `string` | yes                | min_image_resolution | Min image resolution in format {width}x{height}
| `string` | yes                | max_image_resolution | Max image resolution in format {width}x{height}
| `int`    | yes                | max_message_length   | Max count of chars for message
| `int`    | yes                | max_threads_on_page  | Max number of threads that board page can contain
| `int`    | yes                | max_board_pages      | Max number of pages that board can contain
| `string` | yes                | thread_max_posts     | Max count of posts that thread on that board can contain
| `string` | yes                | default_name         | Default name
| `bool`   | yes                | is_closed            | Is board closed


#### Example Request
```javascript
PUT /boards/test/
{
  "name": "test",
  "description": "A test board",
  "min_file_size": 1,
  "max_file_sze": 1000,
  "min_image_resolution": "1000x1000",
  "max_image_resolution": "5000x5000",
  "max_message_length": 300,
  "max_threads_on_page": 5,
  "max_board_pages": 100,
  "thread_max_posts": 500,
  "default_name": "Anon",
  "is_closed": false
}
```
#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```