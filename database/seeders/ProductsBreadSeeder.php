<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class ProductsBreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Data Type for Products
        $dataType = DataType::updateOrCreate(
            ['slug' => 'products'],
            [
                'name' => 'products',
                'display_name_singular' => 'Product',
                'display_name_plural' => 'Products',
                'icon' => 'voyager-bag',
                'model_name' => 'App\\Models\\Product',
                'policy_name' => null,
                'controller' => null,
                'generate_permissions' => true,
                'server_side' => true,
                'description' => 'Amazon Affiliate Products',
                'details' => [
                    'order_column' => 'order',
                    'order_display_column' => 'title',
                    'order_direction' => 'asc',
                    'default_search_key' => 'title',
                ],
            ]
        );

        // Create Permissions
        $this->createPermissions('products');

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

        // Short Description
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'short_description'],
            [
                'type' => 'text_area',
                'display_name' => 'Short Description',
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

        // Full Description
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'full_description'],
            [
                'type' => 'rich_text_box',
                'display_name' => 'Full Description',
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

        // Amazon Affiliate URL
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'amazon_affiliate_url'],
            [
                'type' => 'text',
                'display_name' => 'Amazon Affiliate URL',
                'required' => true,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'validation' => (object) ['rule' => 'required|url'],
                ],
            ]
        );

        // Amazon ASIN
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'amazon_asin'],
            [
                'type' => 'text',
                'display_name' => 'Amazon ASIN',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'description' => 'For future Amazon PA API integration',
                ],
            ]
        );

        // Price Text
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'price_text'],
            [
                'type' => 'text',
                'display_name' => 'Price (Display)',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'description' => 'e.g., "$99.99"',
                ],
            ]
        );

        // Original Price Text
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'original_price_text'],
            [
                'type' => 'text',
                'display_name' => 'Original Price',
                'required' => false,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'description' => 'Shown as strikethrough',
                ],
            ]
        );

        // Discount Text
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'discount_text'],
            [
                'type' => 'text',
                'display_name' => 'Discount Text',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'description' => 'e.g., "20% OFF"',
                ],
            ]
        );

        // Category
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'product_belongsto_category_relationship'],
            [
                'type' => 'relationship',
                'display_name' => 'Category',
                'required' => true,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'model' => 'App\\Models\\Category',
                    'table' => 'categories',
                    'type' => 'belongsTo',
                    'column' => 'category_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => '',
                    'pivot' => 0,
                    'taggable' => null,
                ],
            ]
        );

        // Category ID (hidden)
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'category_id'],
            [
                'type' => 'number',
                'display_name' => 'Category ID',
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

        // Images
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'images'],
            [
                'type' => 'multiple_images',
                'display_name' => 'Product Images',
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

        // Highlights
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'highlights'],
            [
                'type' => 'text_area',
                'display_name' => 'Highlights (JSON)',
                'required' => false,
                'browse' => false,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'description' => 'Enter as JSON array: ["Feature 1", "Feature 2"]',
                ],
            ]
        );

        // Featured
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'featured'],
            [
                'type' => 'checkbox',
                'display_name' => 'Featured',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'on' => 'Yes',
                    'off' => 'No',
                    'checked' => false,
                ],
            ]
        );

        // Deal of the Day
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'deal_of_the_day'],
            [
                'type' => 'checkbox',
                'display_name' => 'Deal of the Day',
                'required' => false,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'on' => 'Yes',
                    'off' => 'No',
                    'checked' => false,
                ],
            ]
        );

        // Status
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'status'],
            [
                'type' => 'select_dropdown',
                'display_name' => 'Status',
                'required' => true,
                'browse' => true,
                'read' => true,
                'edit' => true,
                'add' => true,
                'delete' => false,
                'order' => $order++,
                'details' => (object) [
                    'default' => 'draft',
                    'options' => (object) [
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ],
                ],
            ]
        );

        // SEO Title
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'seo_title'],
            [
                'type' => 'text',
                'display_name' => 'SEO Title',
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

        // SEO Description
        DataRow::updateOrCreate(
            ['data_type_id' => $dataType->id, 'field' => 'seo_description'],
            [
                'type' => 'text_area',
                'display_name' => 'SEO Description',
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
                ['menu_id' => $menu->id, 'title' => 'Products'],
                [
                    'url' => '',
                    'route' => 'voyager.products.index',
                    'target' => '_self',
                    'icon_class' => 'voyager-bag',
                    'color' => null,
                    'parent_id' => null,
                    'order' => 8,
                ]
            );
        }
    }
}
