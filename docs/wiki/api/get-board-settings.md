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
	"id": 1,
	"description": "A test board",
	"min_file_size": 1,
	"max_file_size": 20971520,
	"min_image_resolution": "1x1",
	"max_image_resolution": "5000x5000",
	"max_message_length": 30000,
	"max_threads_on_page": 15,
	"max_board_pages": 100,
	"thread_max_posts": 500,
	"default_name": "Anon",
	"is_closed": 0
}
```

