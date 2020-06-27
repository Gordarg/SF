# To disallow unauthorized People to access the method

Call the function `CheckLogin` from any controller

```
$this->CheckLogin('ROLE'); // Roles: admin, visitor, etc...
```