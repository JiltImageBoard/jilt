#### Resource URL
`PUT /api/control-panel/users/{id}`

#### Description
  Edits user.

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
| `string` | optional | username                          | New username
| `string` | optional | password                          | New password
| `string` | optional | email                             | New email


#### Example Request
`PUT /control-panel/users/5`
```JSON

```

#### Example Result
```JSON

```