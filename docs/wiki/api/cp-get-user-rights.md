#### Resource URL
`GET /api/control-panel/users/{id}/cp-rights`

#### Description
  Gets user rights for control panel.

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id


#### Example Request
```javascript
GET /control-panel/users/5/cp-rights
```

#### Example Result
```javascript
{
  "can_create_boards": false,
  "can_delete_boards": false,
  "is_admin": false
}
```