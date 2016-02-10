#### Resource URL
`DELETE /api/control-panel/bans/{id}`

#### Description
  Deletes ban record

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id


#### Example Request
```javascript
DELETE /control-panel/bans/2
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```