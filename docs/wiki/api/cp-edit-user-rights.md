#### Resource URL
`PUT /api/control-panel/users/{id}/cp-rights`

#### Description
  Edits user rights for control panel.

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id

#### Put parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `bool`   | optional | can_create_boards                 | Can this user create boards?
| `bool`   | optional | can_delete_boards                 | Can this user delete boards?
| `bool`   | optional | is_admin                          | This user is admin?


#### Example Request
```javascript
PUT /control-panel/users/5/cp-rights
{
  "can_create_boards": true,
  "can_delete_boards": true,
  "is_admin": false
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```