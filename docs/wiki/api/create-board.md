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
| `int`    | default: 1         | minFileSize          | Min file size in bytes
| `int`    | default: 20971520  | maxFileSize          | Max file size in bytes
| `string` | default: 1x1       | minImageResolution   | Min image resolution in format {width}x{height}
| `string` | default: 5000x5000 | maxImageResolution   | Max image resolution in format {width}x{height}
| `int`    | default: 30000     | maxMessageLength     | Max count of chars for message
| `int`    | default: 15        | maxThreadsOnPage     | Max number of threads that board page can contain
| `int`    | default: 100       | maxBoardPages        | Max number of pages that board can contain
| `int`    | default: 500       | threadMaxPosts       | Max count of posts that thread on that board can contain
| `string` | default: 'Anon'    | defaultName          | Default name
| `bool`   | default: false     | isClosed             | Is board closed
| `array`  | yes                | mimeTypes          | File formats ids
| `array`  | yes                | wordFilters          | Wordfilters ids
| `array`  | yes                | fileRatings          | File ratings ids
| `array`  | yes                | markupTypes          | Markup types ids

#### Example Request
`POST /boards/`
```JSON
{
   "name": "test",
   "description": "Test board"
}
```

#### Example Result
Status code: `201`
```JSON
{
	"id": 1,
	"name": "test",
	"description": "Test board",
	"createdAt": "2016-04-13 11:06:13",
	"updatedAt": "2016-04-13 11:06:13",
	"minFileSize": 1,
	"maxFileSize": 20971520,
	"minImageResolution": "1x1",
	"maxImageResolution": "5000x5000",
	"maxMessageLength": 30000,
	"maxThreadsOnPage": 15,
	"maxBoardPages": 100,
	"threadMaxPosts": 500,
	"defaultName": "Anon",
	"isClosed": 0,
	"isDeleted": 0
}
```