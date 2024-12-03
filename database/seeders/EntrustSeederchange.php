<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelstatistics;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Dictionary : 
     *              01- Roles 
     *              02- Users
     *              03- AttachRoles To  Users
     *              04- Create random customer and  AttachRole to customerRole
     * 
     * 
     * @return void
     */
    public function run()
    {

        //PoliciesPrivacyMenu menu
        $managePoliciesPrivacyMenus = Permission::create(['name' => 'manage_policies_privacy_menus', 'display_name' => ['ar'    =>  'إدارة قائمة السياسات والخصوصية', 'en'   =>  'Policies Privacy Menu'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $managePoliciesPrivacyMenus->parent_show = $managePoliciesPrivacyMenus->id;
        $managePoliciesPrivacyMenus->save();
        $showPoliciesPrivacyMenus    =  Permission::create(['name' => 'show_policies_privacy_menus',  'display_name' => ['ar'  =>  'إدارة قائمة السياسات والخصوصية',   'en'    =>  'Policies Privacy Menu'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.index', 'icon' => 'fas fa-bars', 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPoliciesPrivacyMenus  =  Permission::create(['name' => 'create_policies_privacy_menus', 'display_name'  => ['ar'  =>  'إضافة عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Add Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.create', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPoliciesPrivacyMenus =  Permission::create(['name' => 'display_policies_privacy_menus', 'display_name'  => ['ar'  =>  'عرض عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Display Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.show', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePoliciesPrivacyMenus  =  Permission::create(['name' => 'update_policies_privacy_menus', 'display_name'  => ['ar'  =>  'تعديل عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Edit Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.edit', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePoliciesPrivacyMenus  =  Permission::create(['name' => 'delete_policies_privacy_menus', 'display_name'  => ['ar'  =>  'حذف عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Delete Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.destroy', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
