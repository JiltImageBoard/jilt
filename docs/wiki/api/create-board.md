#### Resource URL
`POST /api/boards/`

#### Description
  Adds new board

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Post parameters
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
| `array`  | yes                | fileFormats          | File formats ids
| `array`  | yes                | wordFilters          | Wordfilters ids
| `array`  | yes                | fileRatings          | File ratings ids
| `array`  | yes                | markupTypes          | Markup types ids

#### Example Request
```javascript
POST /boards/
{
   "name": "test",
   "description": "Test board"
}
```

#### Example Result
```
HTTP/1.1 201 OK
{
	"name": "test",
	"description": "Test board",
	"created_at": "2016-02-22 09:32:41",
	"updated_at": "2016-02-22 09:32:41",
	"min_file_size": 1,
	"max_file_size": 1,
	"min_image_resolution": "1",
	"max_image_resolution": "1",
	"max_message_length": 1,
	"max_threads_on_page": 1,
	"max_board_pages": 1,
	"thread_max_posts": 1,
	"default_name": "Anon",
	"is_closed": 0,
	"is_deleted": 0,
	"fileFormats": [1],
	"wordFilters": [1],
	"fileRatings": [1],
	"markupTypes": [1]
}
```