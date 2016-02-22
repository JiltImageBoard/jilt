#### Resource URL
`GET /api/boards/{name}`

#### Description
  Gets board settings

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | name                              | Name of board


#### Example Request
```javascript
GET /api/boards/test
```
#### Example Result
```
HTTP/1.1 200 OK
{
	"name": "test",
	"description": "Test board",
	"created_at": "2016-02-17 13:24:21",
	"updated_at": "2016-02-21 15:08:03",
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
	"fileFormats": [1, 2],
	"wordFilters": [1],
	"fileRatings": [1],
	"markupTypes": [1],
	"threads": [3, 4]
}
```

