<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class DealsBreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Data Type for Deals
        $dataType = DataType::updateOrCreate(
            ['slug' => 'deals'],
            [
                'name' => 'deals',
                'display_name_singular' => 'Deal',
                'display_name_plural' => 'Deals',
                'icon' => 'voyager-tag',
                'model_name' => 'App\\Models\\Deal',
                'policy_name' => null,
                'controller' => null,
                'generate_permissions' => true,
                'server_side' => true,
                'description' => 'Deals and Collections',
                'details' => [
                    'order_column' => 'order',
                    'order_display_column' => 'title',
                    'order_direction' => 'asc',
                    'default_search_key' => 'title',
                ],
            ]
        );

        // Create Permissions
        $this->createPermissions('deals');

        // Create Data Rows
        $this->createDataRows($dataType);

        // Add Menu Item
        $this->addMenuItem();
    }

    private function createPermissions($tableName)
    {
        $permissions = ['browse', 'read', 'edit', 'add', 'delete'];

        foreach ($permissions as $key) {
            Permission::firstOrCreate([
                'key' => $key . '_' . $tableName,
                'table_name' => $tableName,
            ]);
        }

        // Assign permissions to admin role
        $adminRole = \TCG\Voyager\Models\Role::where('name', 'admin')->first();
        if ($adminRole) {
            $permissions = Permission::where('table_name', $tableName)->get();
            $adminRole->permissions()->syncWithoutDetaching($permissions->pluck('id')->toArray());
        }
    }

    private function createDataRows(DataType $dataType)
    {
        $order = 0;

        // ID
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'id'],
            [
                'type' => 'number',
                'display_name' => 'ID',
                'required' => true,
                'browse' => false,
                'read' => false,
                'edit' => false,
                'add' => false,
                'delete' => false,
                'order' => $order++,
                'details' => new \stdClass(),
            ]
        );

        // Title
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'title'],
            [
                'type' => 'text',
                'display_name' => 'Title',
                'required' => true,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => true,
                'order' => $order++,
                'details' => (object) [
                    'validation' => (object) ['rule' => 'required|max:255'],
                ],
            ]
        );

        // Slug
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'slug'],
            [
                'type' => 'text',
                'display_name' => 'Slug',
                'required' => true,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'slugify' => (object) ['origin' => 'title'],
                ],
            ]
        );

        // Banner Image
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'banner_image'],
            [
                'type' => 'image',
                'display_name' => 'Banner Image',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'resize' => (object) [
                        'width' => '1200',
                        'height' => '600',
                    ],
                    'quality' => '90',
                    'upsize' => true,
                ],
            ]
        );

        // Description
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'description'],
            [
                'type' => 'rich_text_box',
                'display_name' => 'Description',
                'required' => false,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => new \stdClass(),
            ]
        );

        // Active
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'active'],
            [
                'type' => 'checkbox',
                'display_name' => 'Active',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'on' => 'Active',
                    'off' => 'Inactive',
                    'checked' => true,
                ],
            ]
        );

        // Start Date
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'start_date'],
            [
                'type' => 'timestamp',
                'display_name' => 'Start Date',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => new \stdClass(),
            ]
        );

        // End Date
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'end_date'],
            [
                'type' => 'timestamp',
                'display_name' => 'End Date',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => new \stdClass(),
            ]
        );

        // Order
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'order'],
            [
                'type' => 'number',
                'display_name' => 'Order',
                'required' => false,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'default' => 0,
                ],
            ]
        );

        // Products Relationship
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'deal_belongstomany_product_relationship'],
            [
                'type' => 'relationship',
                'display_name' => 'Products',
                'required' => false,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'model' => 'App\\Models\\Product',
                    'table' => 'products',
                    'type' => 'belongsToMany',
                    'column' => 'id',
                    'key' => 'id',
                    'label' => 'title',
                    'pivot_table' => 'deal_product',
                    'pivot' => '1',
                    'taggable' => '1',
                ],
            ]
        );

        // Created At
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'created_at'],
            [
                'type' => 'timestamp',
                'display_name' => 'Created At',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => false,
                'add' => false,
                'delete' => false,
                'order' => $order++,
                'details' => new \stdClass(),
            ]
        );

        // Updated At
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'updated_at'],
            [
                'type' => 'timestamp',
                'display_name' => 'Updated At',
                'required' => false,
                'browse' => false,
                'read' => true,
                'edit' => false,
                'add' => false,
                'delete' => false,
                'order' => $order++,
                'details' => new \stdClass(),
            ]
        );
    }

    private function addMenuItem()
    {
        $menu = Menu::where('name', 'admin')->first();

        if ($menu) {
            MenuItem::updateOrCreate(
                ['menu_id' => $menu->id, 'title' => 'Deals'],
                [
                    'url' => '',
                    'route' => 'voyager.deals.index',
                    'target' => '_self',
                    'icon_class' => 'voyager-tag',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 9,
                ]
            );
        }
    }
}
