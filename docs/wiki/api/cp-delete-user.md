#### Resource URL
`DELETE /api/control-panel/users/{id}`

#### Description
  Deletes user.

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id


#### Example Request
```javascript
DELETE /control-panel/users/5
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```