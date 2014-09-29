<?php

use yii\db\Schema;

class m140629_145437_add_auth_assignments extends \yii\db\Migration 
{
    
    public function up() 
    {
        $this->createTable('{{%auth_rule}}', array(
            'name' => 'varchar(64)',
            'data' => 'text',
            'created_at' => 'integer',
            'updated_at' => 'integer',
            'PRIMARY KEY (name)'
        ));

        $this->createTable('{{%auth_item}}', array(
            'name' => 'varchar(64)',
            'type' => 'integer NOT NULL',
            'description' => 'text',
            'rule_name' => 'varchar(64)',
            'data' => 'text',
            'created_at' => 'integer',
            'updated_at' => 'integer',
            'PRIMARY KEY (name)'
        ));
        
        $this->addForeignKey('fk_ai_ar', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'SET NULL', 'CASCADE');

        $this->createTable('{{%auth_item_child}}', array(
            'parent' => 'varchar(64)',
            'child' => 'varchar(64)',
            'PRIMARY KEY (parent,child)'
        ));

        $this->addForeignKey('fk_aic_aip', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_aic_aic', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        $this->createTable('{{%auth_assignment}}', array(
            'item_name' => 'varchar(64) NOT NULL',
            'user_id' => 'varchar(64) NOT NULL',
            'created_at' => 'integer',
            'PRIMARY KEY (item_name, user_id)'
        ));

        $this->addForeignKey('fk_aa_ai', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        $auth=Yii::$app->authManager;

        $manageUserGroups = $auth->createPermission("Manage User Groups");
        $manageUserGroups->description = "Edit user groups";
        $auth->add($manageUserGroups);
        
        $updateContentTypeStructure = $auth->createPermission("Update Content Type Structure");
        $updateContentTypeStructure->description = "Update the structure of content types";
        $auth->add($updateContentTypeStructure);

        
        $createUser = $auth->createPermission("Create User");
        $createUser->description = "Create a new user";
        $auth->add($createUser);
        
        $viewUser = $auth->createPermission("View User");
        $viewUser->description = "Read user profile information";
        $auth->add($viewUser);
        
        $updateUser = $auth->createPermission("Update User");
        $updateUser->description = "Update a users information";
        $auth->add($updateUser);
        
        $deleteUser = $auth->createPermission("Delete User");
        $deleteUser->description = "Remove a user";
        $auth->add($deleteUser);

        
        $createContent = $auth->createPermission("Create Content");
        $createContent->description = "Create any content";
        $auth->add($createContent);
        
        $viewContent = $auth->createPermission("View Content");
        $viewContent->description = "View content on the website";
        $auth->add($viewContent);
        
        $updateContent = $auth->createPermission("Update Content");
        $updateContent->description = "Update any content";
        $auth->add($updateContent);
        
        $deleteContent = $auth->createPermission("Delete Content");
        $deleteContent->description = "Delete any content";
        $auth->add($deleteContent);
        

        $viewMenu = $auth->createPermission("View Menu");
        $viewMenu->description = "View a menu in the admin area";
        $auth->add($viewMenu);
        
        $updateMenu = $auth->createPermission("Update Menu");
        $updateMenu->description = "Update a menu";
        $auth->add($updateMenu);
        
        $createMenuItem = $auth->createPermission("Create Menu Item");
        $createMenuItem->description = "Create a menu item";
        $auth->add($createMenuItem);
        
        $updateMenuItem = $auth->createPermission("Update Menu Item");
        $updateMenuItem->description = "Update a menu item";
        $auth->add($updateMenuItem);
        
        $deleteMenuItem = $auth->createPermission("Delete Menu Item");
        $deleteMenuItem->description = "Delete a menu item";
        $auth->add($deleteMenuItem);
        
        
        $updateSettings = $auth->createPermission("Update Settings");
        $updateSettings->description = "Update site settings";
        $auth->add($updateSettings);
        
        
        $viewLogs = $auth->createPermission("View Logs");
        $viewLogs->description = "View error and status logs";
        $auth->add($viewLogs);
        
        $clearLogs = $auth->createPermission("Clear Logs");
        $clearLogs->description = "Clear error and status logs";
        $auth->add($clearLogs);

        //Tasks used for grouping
        $user=$auth->createPermission("User");
        $auth->add($user);
        $auth->addChild($user, $viewUser);
        $auth->addChild($user, $createUser);
        $auth->addChild($user, $updateUser);
        $auth->addChild($user, $deleteUser);
        $auth->addChild($user, $manageUserGroups);

        $content=$auth->createPermission("Content");
        $auth->add($content);
        $auth->addChild($content, $viewContent);
        $auth->addChild($content, $createContent);
        $auth->addChild($content, $updateContent);
        $auth->addChild($content, $deleteContent);

        $menu=$auth->createPermission("Menu");
        $auth->add($menu);
        $auth->addChild($menu, $viewMenu);
        $auth->addChild($menu, $updateMenu);
        $auth->addChild($menu, $createMenuItem);
        $auth->addChild($menu, $updateMenuItem);
        $auth->addChild($menu, $deleteMenuItem);

        $general=$auth->createPermission("General");
        $auth->add($general);
        $auth->addChild($general, $accessBackend);
        $auth->addChild($general, $updateSettings);
        $auth->addChild($general, $updateContentTypeStructure);
        $auth->addChild($general, $viewLogs);

        $anonymous=$auth->createRole("Anonymous");
        $auth->add($anonymous);
        $auth->addChild($anonymous, $viewContent);

        $editor=$auth->createRole("Editor");
        $auth->add($editor);
        $auth->addChild($editor, $manageUserGroups);
        $auth->addChild($editor, $content);
        $auth->addChild($editor, $menu);
        $auth->addChild($editor, $accessBackend);
        $auth->addChild($editor, $viewUser);

        $admin=$auth->createRole("Admin");
        $auth->add($admin);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $manageUserGroups);
        $auth->addChild($admin, $content);
        $auth->addChild($admin, $menu);
        $auth->addChild($admin, $general);
        $auth->addChild($admin, $updateSettings);
        $auth->addChild($admin, $updateContentTypeStructure);
        
        $this->insert('{{%auth_assignment}}',['item_name' => 'Admin', 'user_id' => 1, 'created_at' => time()]);

        //$auth->assign("Admin",1);
        //$auth->assign("Editor",2);
    }

    public function down() 
    {
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_rule}}');
        return false;
    }

}
