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
| `string` | optional           | description          | Description of a new board
| `int`    | default: 1         | min_file_size        | Min file size in bytes
| `int`    | default: 20971520  | max_file_size        | Max file size in bytes
| `string` | default: 1x1       | min_image_resolution | Min image resolution in format {width}x{height}
| `string` | default: 5000x5000 | max_image_resolution | Max image resolution in format {width}x{height}
| `int`    | default: 30000     | max_message_length   | Max count of chars for message
| `int`    | default: 15        | max_threads_on_page  | Max number of threads that board page can contain
| `int`    | default: 100       | max_board_pages      | Max number of pages that board can contain
| `int`    | default: 500       | thread_max_posts     | Max count of posts that thread on that board can contain
| `string` | default: 'Anon'    | default_name         | Default name
| `bool`   | default: false     | is_closed            | Is board closed
| `array`  | yes                | mimeTypes          | File formats ids
| `array`  | yes                | wordFilters          | Wordfilters ids
| `array`  | yes                | fileRatings          | File ratings ids
| `array`  | yes                | markupTypes          | Markup types ids


#### Example Request
`PUT /boards/test/`
```JSON
{
  "name": "test",
  "description": "A test board",
  "min_file_size": 1,
  "max_file_sze": 1,
  "min_image_resolution": "1000x1000",
  "max_image_resolution": "5000x5000",
  "max_message_length": 300,
  "max_threads_on_page": 5,
  "max_board_pages": 100,
  "thread_max_posts": 500,
  "default_name": "Anon",
  "is_closed": false,
  "mimeTypes": [1],
  "wordFilters": [1],
  "fileRatings": [1],
  "markupTypes": [1]
}
```
#### Example Result
Status code: `200`
```JSON
{
	"id": 86,
	"name": "test",
	"description": "A test board",
	"createdAt": "2016-02-17 13:24:21",
	"updatedAt": "2016-04-18 08:59:15",
    "min_file_size": 1,
    "max_file_sze": 1,
    "min_image_resolution": "1000x1000",
    "max_image_resolution": "5000x5000",
    "max_message_length": 300,
    "max_threads_on_page": 5,
    "max_board_pages": 100,
    "thread_max_posts": 500,
	"defaultName": "Anon",
	"isClosed": 0,
	"isDeleted": 0
}
```