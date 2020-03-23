# To access passed data

use variable `$Data`

# To define views payload segment
use the line below to show where the payload ends

```
<!--PAYLOAD_CONTENT_END-->
```

# To start content segment
use the line below to show where the content must be placed

```
<!--VIEW_CONTENT-->
```

# A sample view

```
<?php
// var_dump($Data);
?>
<!--PAYLOAD_CONTENT_END-->
Body Here
```