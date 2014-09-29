User Permissions
================

SnapCMS makes use of Yii2's RBAC DBManager class but removes some of its flexibility in favour of ease of use.

The way this is achieved is by only allowing three distinct levels of permissions.

1. Roles, such as Admin/Editor etc.
2. Permissions groups such as Content/Users etc. (These are also permissions as far as Yii is concerned)
3. The actual permissions, such as Edit Content, Update Content etc.

Groups cannot be selected in the back end for simplicity, they are purely used for organisational purposes.