<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        //create fake information  using faker factory lab 
        $faker = Factory::create();


        //------------- 01- Roles ------------//
        //adminRole
        $adminRole = new Role();
        $adminRole->name         = 'admin';
        $adminRole->display_name = 'User Administrator'; // optional
        $adminRole->description  = 'User is allowed to manage and edit other users'; // optional
        $adminRole->allowed_route = 'admin';
        $adminRole->save();

        //supervisorRole
        $supervisorRole = Role::create([
            'name' => 'supervisor',
            'display_name' => 'User Supervisor',
            'description' => 'Supervisor is allowed to manage and edit other users',
            'allowed_route' => 'admin',
        ]);


        //customerRole
        $customerRole = new Role();
        $customerRole->name         = 'customer';
        $customerRole->display_name = 'Project Customer'; // optional
        $customerRole->description  = 'Customer is the customer of a given project'; // optional
        $customerRole->allowed_route = null;
        $customerRole->save();


        //------------- 02- Users  ------------//
        // Create Admin
        $admin = new User();
        $admin->first_name = 'Admin';
        $admin->last_name = 'System';
        $admin->username = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = now();
        $admin->mobile = '00967772036131';
        $admin->password = bcrypt('123123123');
        $admin->user_image = 'avator.svg';
        $admin->status = 1;
        $admin->remember_token = Str::random(10);
        $admin->save();

        // Create supervisor
        $supervisor = User::create([
            'first_name' => 'Supervisor',
            'last_name' => 'System',
            'username' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036132',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        // Create customer
        $customer = User::create([
            'first_name' => 'Khaleel',
            'last_name' => 'Raweh',
            'username' => 'khaleel',
            'email' => 'khaleelvisa@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036133',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        //------------- 03- AttachRoles To  Users  ------------//
        $admin->attachRole($adminRole);
        $supervisor->attachRole($supervisorRole);
        $customer->attachRole($customerRole);


        //------------- 04-  Create random customer and  AttachRole to customerRole  ------------//
        for ($i = 1; $i <= 20; $i++) {
            //Create random customer
            $random_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->email,
                'email_verified_at' => now(),
                'mobile' => '0096777' . $faker->numberBetween(1000000, 9999999),
                'password' => bcrypt('123123123'),
                'user_image' => 'avator.svg',
                'status' => 1,
                'remember_token' => Str::random(10),
            ]);

            //Add customerRole to RandomCusomer
            $random_customer->attachRole($customerRole);
        } //end for


        //------------- 05- Permission  ------------//
        //manage main dashboard page
        $manageMain = Permission::create(['name' => 'main', 'display_name' => ['ar' => 'الرئيسية', 'en'    => 'Main'], 'route' => 'index', 'module' => 'index', 'as' => 'index', 'icon' => 'fa fa-home', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '1']);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();


        //Customers
        // $manageCustomers = Permission::create(['name' => 'manage_customers', 'display_name' => ['ar'    =>  'إدارة المستخدمين',  'en' =>  'Manage Users'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user-cog', 'parent' => '0', 'parent_original' => '0',  'sidebar_link' => '1', 'appear' => '1', 'ordering' => '20',]);
        // $manageCustomers->parent_show = $manageCustomers->id;
        // $manageCustomers->save();
        // $showCustomers   =  Permission::create(['name'  => 'show_customers', 'display_name'    => ['ar'   =>     'الطلاب',   'en'    =>  'Stduents'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user-graduate', 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1']);
        // $createCustomers =  Permission::create(['name'  => 'create_customers', 'display_name'    => ['ar'   =>      'إضافة طالب',   'en'    =>  'Add New Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.create', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '0']);
        // $displayCustomers =  Permission::create(['name' => 'display_customers', 'display_name'     => ['ar'   =>      'عرض طالب',   'en'    =>  'Dsiplay Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.show', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);
        // $updateCustomers  =  Permission::create(['name' => 'update_customers', 'display_name'     => ['ar'   =>      'تعديل طالب',   'en'    =>  'Edit Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.edit', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);
        // $deleteCustomers =  Permission::create(['name'  => 'delete_customers', 'display_name'    => ['ar'   =>      'حذف طالب',   'en'    =>  'Delete Student'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.destroy', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);


        //Supervisor // we can hide suppervisor not to be in sidebar linke by  making in manage_supervisors 'sidebar_link' => '0'
        // $manageSupervisors = Permission::create(['name' => 'manage_supervisors', 'display_name' => ['ar'    =>  'المشرفين',    'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageSupervisors = Permission::create(['name' => 'manage_supervisors', 'display_name' => ['ar'    =>  'إدارة المشرفين',    'en'    =>  'Manage Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageSupervisors->parent_show = $manageSupervisors->id;
        $manageSupervisors->save();
        $showSupervisors   =  Permission::create(['name' => 'show_supervisors', 'display_name'    =>  ['ar'   =>  'المشرفين',   'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createSupervisors =  Permission::create(['name' => 'create_supervisors', 'display_name'    =>  ['ar'   =>  'إضافة مشرف جديد',   'en'    =>  'Add Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.create', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displaySupervisors =  Permission::create(['name' => 'display_supervisors', 'display_name'    =>  ['ar'   =>  'عرض مشرف',   'en'    =>  'Dsiplay Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.show', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupervisors  =  Permission::create(['name' => 'update_supervisors', 'display_name'    =>  ['ar'   =>  'تعديل مشرف',   'en'    =>  'Edit Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.edit', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupervisors =  Permission::create(['name' => 'delete_supervisors', 'display_name'    =>  ['ar'   =>  'حذف مشرف',   'en'    =>  'Delete Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.destroy', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);

        //instructors
        // $manageInstructors = Permission::create(['name' => 'manage_instructors', 'display_name' => ['ar'    =>  'المحاضرين',    'en'    =>  'instructors'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.index', 'icon' => 'fas fa-chalkboard-teacher', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '30',]);
        // $manageInstructors->parent_show = $manageInstructors->id;
        // $manageInstructors->save();
        // $showInstructors   =  Permission::create(['name' => 'show_instructors', 'display_name'    =>  ['ar'   =>  'المحاضرين',   'en'    =>  'instructors'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.index', 'icon' => 'fas fa-chalkboard-teacher', 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '1', 'appear' => '1']);
        // $createInstructors =  Permission::create(['name' => 'create_instructors', 'display_name'    =>  ['ar'   =>  'إضافة محاضر جديد',   'en'    =>  'Add Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.create', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '1', 'appear' => '0']);
        // $displayInstructors =  Permission::create(['name' => 'display_instructors', 'display_name'    =>  ['ar'   =>  'عرض محاضر',   'en'    =>  'Dsiplay Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.show', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '0', 'appear' => '0']);
        // $updateInstructors  =  Permission::create(['name' => 'update_instructors', 'display_name'    =>  ['ar'   =>  'تعديل محاضر',   'en'    =>  'Edit Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.edit', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '0', 'appear' => '0']);
        // $deleteInstructors =  Permission::create(['name' => 'delete_instructors', 'display_name'    =>  ['ar'   =>  'حذف محاضر',   'en'    =>  'Delete Instructor'], 'route' => 'instructors', 'module' => 'instructors', 'as' => 'instructors.destroy', 'icon' => null, 'parent' => $manageInstructors->id, 'parent_original' => $manageInstructors->id, 'parent_show' => $manageInstructors->id, 'sidebar_link' => '0', 'appear' => '0']);

        //specialization
        // $manageSpecializations = Permission::create(['name' => 'manage_specializations', 'display_name' => ['ar'    =>  'التخصصات',    'en'    =>  'specializations'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.index', 'icon' => 'fas fa-file-signature', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '35',]);
        // $manageSpecializations->parent_show = $manageSpecializations->id;
        // $manageSpecializations->save();
        // $showSpecializations   =  Permission::create(['name' => 'show_specializations', 'display_name'    =>  ['ar'   =>  'التخصصات',   'en'    =>  'specializations'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.index', 'icon' => 'fas fa-file-signature', 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '1', 'appear' => '1']);
        // $createSpecializations =  Permission::create(['name' => 'create_specializations', 'display_name'    =>  ['ar'   =>  'إضافة تخصص جديد',   'en'    =>  'Add specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.create', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '1', 'appear' => '0']);
        // $displaySpecializations =  Permission::create(['name' => 'display_specializations', 'display_name'    =>  ['ar'   =>  'عرض تخصص',   'en'    =>  'Dsiplay specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.show', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '0', 'appear' => '0']);
        // $updateSpecializations  =  Permission::create(['name' => 'update_specializations', 'display_name'    =>  ['ar'   =>  'تعديل تخصص',   'en'    =>  'Edit specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.edit', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '0', 'appear' => '0']);
        // $deleteSpecializations =  Permission::create(['name' => 'delete_specializations', 'display_name'    =>  ['ar'   =>  'حذف تخصص',   'en'    =>  'Delete specialization'], 'route' => 'specializations', 'module' => 'specializations', 'as' => 'specializations.destroy', 'icon' => null, 'parent' => $manageSpecializations->id, 'parent_original' => $manageSpecializations->id, 'parent_show' => $manageSpecializations->id, 'sidebar_link' => '0', 'appear' => '0']);



        //main sliders
        $manageMainSliders = Permission::create(['name' => 'manage_main_sliders', 'display_name' => ['ar'    =>  'إدارة عارض الشرائح', 'en' =>  'Manage Slide Viewer'], 'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.index', 'icon' => 'fas fa-sliders-h', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '75',]);
        $manageMainSliders->parent_show = $manageMainSliders->id;
        $manageMainSliders->save();
        $showMainSliders    =  Permission::create(['name' => 'show_main_sliders', 'display_name'    =>  ['ar'    =>  ' عارض الشرائح الرئيسي',   'en'    =>  'Main Slide Viewer'], 'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.index', 'icon' => 'fas  fa-sliders-h', 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createMainSliders  =  Permission::create(['name' => 'create_main_sliders', 'display_name'    =>  ['ar'    =>  'إضافة شريحة جديد',   'en'    =>  'Add Slide'], 'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.create', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayMainSliders =  Permission::create(['name' => 'display_main_sliders', 'display_name'    =>  ['ar'    =>  'عرض الشريحة',   'en'    =>  'Display Main Slide'],  'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.show', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateMainSliders  =  Permission::create(['name' => 'update_main_sliders', 'display_name'    =>  ['ar'    =>  'تعديل الشريحة',   'en'    =>  'Edit Main Slide'],  'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.edit', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteMainSliders  =  Permission::create(['name' => 'delete_main_sliders', 'display_name'    =>  ['ar'    =>  'حذف الشريحة',   'en'    =>  'Delete Main Slide'],  'route' => 'main_sliders', 'module' => 'main_sliders', 'as' => 'main_sliders.destroy', 'icon' => null, 'parent' => $manageMainSliders->id, 'parent_original' => $manageMainSliders->id, 'parent_show' => $manageMainSliders->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Advertisor sliders
        $manageAdvertisorSliders = Permission::create(['name' => 'manage_advertisor_sliders', 'display_name' => ['ar'    =>  'عارض شرائح الإعلانات', 'en'   =>  'Adv Slide Viewer'], 'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.index', 'icon' => 'fas fa-bullhorn', 'parent' => $manageMainSliders->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '80',]);
        $manageAdvertisorSliders->parent_show = $manageAdvertisorSliders->id;
        $manageAdvertisorSliders->save();
        $showAdvertisorSliders    =  Permission::create(['name' => 'show_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'عارض شرائح الإعلانات',   'en'    =>  'Adv Slide Viewer'], 'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.index', 'icon' => 'fas fa-bullhorn', 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createAdvertisorSliders  =  Permission::create(['name' => 'create_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'إضافة شريحة جديد',   'en'    =>  'Add Adv Slide'], 'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.create', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayAdvertisorSliders =  Permission::create(['name' => 'display_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'عرض الشريحة',   'en'    =>  'Display Adv Slide'],  'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.show', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateAdvertisorSliders  =  Permission::create(['name' => 'update_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'تعديل الشريحة',   'en'    =>  'Edit Adv Slide'],  'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.edit', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAdvertisorSliders  =  Permission::create(['name' => 'delete_advertisor_sliders', 'display_name'    =>  ['ar'   =>  'حذف الشريحة',   'en'    =>  'Delete Adv Slide'],  'route' => 'advertisor_sliders', 'module' => 'advertisor_sliders', 'as' => 'advertisor_sliders.destroy', 'icon' => null, 'parent' => $manageAdvertisorSliders->id, 'parent_original' => $manageAdvertisorSliders->id, 'parent_show' => $manageAdvertisorSliders->id, 'sidebar_link' => '0', 'appear' => '0']);


        // President Speeches
        $managePresidentSpeeches = Permission::create(['name' => 'manage_president_speeches', 'display_name' => ['ar'  =>  'كلمة المدير',    'en'    =>  'President Speeches'], 'route' => 'president_speeches', 'module' => 'president_speeches', 'as' => 'president_speeches.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '75',]);
        $managePresidentSpeeches->parent_show = $managePresidentSpeeches->id;
        $managePresidentSpeeches->save();
        $showAboutInstatutes   =  Permission::create(['name'  => 'show_president_speeches', 'display_name'       =>  ['ar'   =>  'كلمة المدير',   'en'    =>  'President Speeches'], 'route' => 'president_speeches', 'module' => 'president_speeches', 'as' => 'president_speeches.index', 'icon' => 'fas fas fa-newspaper', 'parent' => $managePresidentSpeeches->id, 'parent_original' => $managePresidentSpeeches->id, 'parent_show' => $managePresidentSpeeches->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createAboutInstatutes =  Permission::create(['name'  => 'create_president_speeches', 'display_name'     =>  ['ar'   =>  'إنشاء كلمة المدير',   'en'    =>  'Create President Speech'], 'route' => 'president_speeches', 'module' => 'president_speeches', 'as' => 'president_speeches.create', 'icon' => null, 'parent' => $managePresidentSpeeches->id, 'parent_original' => $managePresidentSpeeches->id, 'parent_show' => $managePresidentSpeeches->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayAboutInstatutes =  Permission::create(['name' => 'display_president_speeches', 'display_name'    =>  ['ar'   =>  'عرض كلمة المدير',   'en'    =>  'Display President Speech'], 'route' => 'president_speeches', 'module' => 'president_speeches', 'as' => 'president_speeches.show', 'icon' => null, 'parent' => $managePresidentSpeeches->id, 'parent_original' => $managePresidentSpeeches->id, 'parent_show' => $managePresidentSpeeches->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateAboutInstatutes  =  Permission::create(['name' => 'update_president_speeches', 'display_name'     =>  ['ar'   =>  'تعديل كلمة المدير',   'en'    =>  'Edit President Speech'], 'route' => 'president_speeches', 'module' => 'president_speeches', 'as' => 'president_speeches.edit', 'icon' => null, 'parent' => $managePresidentSpeeches->id, 'parent_original' => $managePresidentSpeeches->id, 'parent_show' => $managePresidentSpeeches->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAboutInstatutes =  Permission::create(['name'  => 'delete_president_speeches', 'display_name'     =>  ['ar'   =>  'حذف كلمة المدير',   'en'    =>  'Delete President Speech'], 'route' => 'president_speeches', 'module' => 'president_speeches', 'as' => 'president_speeches.destroy', 'icon' => null, 'parent' => $managePresidentSpeeches->id, 'parent_original' => $managePresidentSpeeches->id, 'parent_show' => $managePresidentSpeeches->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Partners
        $managePartners = Permission::create(['name' => 'manage_partners', 'display_name' => ['ar'  =>  'شركاؤنا',    'en'    =>  'Our Partners'], 'route' => 'partners', 'module' => 'partners', 'as' => 'partners.index', 'icon' => 'far fa-handshake', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '60',]);
        $managePartners->parent_show = $managePartners->id;
        $managePartners->save();
        $showPartners   =  Permission::create(['name'  => 'show_partners', 'display_name'       =>  ['ar'   =>  'شركاؤنا',   'en'    =>  'Our Partners'], 'route' => 'partners', 'module' => 'partners', 'as' => 'partners.index', 'icon' => 'far fa-handshake', 'parent' => $managePartners->id, 'parent_original' => $managePartners->id, 'parent_show' => $managePartners->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createPartners =  Permission::create(['name'  => 'create_partners', 'display_name'     =>  ['ar'   =>  'إنشاء شريك',   'en'    =>  'Create Our Partner'], 'route' => 'partners', 'module' => 'partners', 'as' => 'partners.create', 'icon' => null, 'parent' => $managePartners->id, 'parent_original' => $managePartners->id, 'parent_show' => $managePartners->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPartners =  Permission::create(['name' => 'display_partners', 'display_name'    =>  ['ar'   =>  'عرض شريك',   'en'    =>  'Display Our Partner'], 'route' => 'partners', 'module' => 'partners', 'as' => 'partners.show', 'icon' => null, 'parent' => $managePartners->id, 'parent_original' => $managePartners->id, 'parent_show' => $managePartners->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePartners  =  Permission::create(['name' => 'update_partners', 'display_name'     =>  ['ar'   =>  'تعديل شريك',   'en'    =>  'Edit Our Partner'], 'route' => 'partners', 'module' => 'partners', 'as' => 'partners.edit', 'icon' => null, 'parent' => $managePartners->id, 'parent_original' => $managePartners->id, 'parent_show' => $managePartners->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePartners =  Permission::create(['name'  => 'delete_partners', 'display_name'     =>  ['ar'   =>  'حذف شريك',   'en'    =>  'Delete Our Partner'], 'route' => 'partners', 'module' => 'partners', 'as' => 'partners.destroy', 'icon' => null, 'parent' => $managePartners->id, 'parent_original' => $managePartners->id, 'parent_show' => $managePartners->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Testimonials
        $manageTestimonials = Permission::create(['name' => 'manage_testimonials', 'display_name' => ['ar'   =>  'إدارة ماذا يقولوا عنا',   'en'    =>  'Manage Testimonials'], 'route' => 'testimonials', 'module' => 'testimonials', 'as' => 'testimonials.index', 'icon' => 'fas fa-certificate', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageTestimonials->parent_show = $manageTestimonials->id;
        $manageTestimonials->save();
        $showTestimonials   =  Permission::create(['name'  => 'show_testimonials', 'display_name'        =>  ['ar'   =>  'ماذا يقولوا عنا',   'en'    =>  'Testimonials'], 'route' => 'testimonials', 'module' => 'testimonials', 'as' => 'testimonials.index', 'icon' => 'fas fa-certificate', 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createTestimonials =  Permission::create(['name'  => 'create_testimonials', 'display_name'      =>  ['ar'   =>  'إضافة ماذا يقولوا عنا جديدة',   'en'    =>  'Create New Testimonial'], 'route' => 'testimonials/create', 'module' => 'testimonials', 'as' => 'testimonials.create', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayTestimonials =  Permission::create(['name' => 'display_testimonials', 'display_name'     =>  ['ar'   =>  'عرض ماذا يقولوا عنا',   'en'    =>  'Dispay Testimonial'], 'route' => 'testimonials/{testimonials}', 'module' => 'testimonials', 'as' => 'testimonials.show', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTestimonials  =  Permission::create(['name' => 'update_testimonials', 'display_name'      =>  ['ar'   =>  'تعديل ماذا يقولوا عنا',   'en'    =>  'Edit Testimonial'], 'route' => 'testimonials/{testimonials}/edit', 'module' => 'testimonials', 'as' => 'testimonials.edit', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTestimonials =  Permission::create(['name'  => 'delete_testimonials', 'display_name'      =>  ['ar'   =>  'حذف ماذا يقولوا عنا',   'en'    =>  'Delete Testimonial'], 'route' => 'testimonials/{testimonials}', 'module' => 'testimonials', 'as' => 'testimonials.destroy', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);


        //Common Questions
        $manageCommonQuestions = Permission::create(['name' => 'manage_common_questions', 'display_name' => ['ar'   =>  'إدارة الاسئلة الشائعة',   'en'    =>  'Asked Questions'], 'route' => 'common_questions', 'module' => 'common_questions', 'as' => 'common_questions.index', 'icon' => 'fas fa-question', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageCommonQuestions->parent_show = $manageCommonQuestions->id;
        $manageCommonQuestions->save();
        $showCommonQuestions   =  Permission::create(['name'  => 'show_common_questions', 'display_name'        =>  ['ar'   =>  'الاسئلة الشائعة',   'en'    =>  'Questions'], 'route' => 'common_questions', 'module' => 'common_questions', 'as' => 'common_questions.index', 'icon' => 'fas fa-question', 'parent' => $manageCommonQuestions->id, 'parent_original' => $manageCommonQuestions->id, 'parent_show' => $manageCommonQuestions->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCommonQuestions =  Permission::create(['name'  => 'create_common_questions', 'display_name'      =>  ['ar'   =>  'إنشاء سؤال',   'en'    =>  'Create Question'], 'route' => 'common_questions/create', 'module' => 'common_questions', 'as' => 'common_questions.create', 'icon' => null, 'parent' => $manageCommonQuestions->id, 'parent_original' => $manageCommonQuestions->id, 'parent_show' => $manageCommonQuestions->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayCommonQuestions =  Permission::create(['name' => 'display_common_questions', 'display_name'     =>  ['ar'   =>  'عرض سؤال',   'en'    =>  'Dispay Question'], 'route' => 'common_questions/{common_questions}', 'module' => 'common_questions', 'as' => 'common_questions.show', 'icon' => null, 'parent' => $manageCommonQuestions->id, 'parent_original' => $manageCommonQuestions->id, 'parent_show' => $manageCommonQuestions->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCommonQuestions  =  Permission::create(['name' => 'update_common_questions', 'display_name'      =>  ['ar'   =>  'تعديل سؤال',   'en'    =>  'Edit Question'], 'route' => 'common_questions/{common_questions}/edit', 'module' => 'common_questions', 'as' => 'common_questions.edit', 'icon' => null, 'parent' => $manageCommonQuestions->id, 'parent_original' => $manageCommonQuestions->id, 'parent_show' => $manageCommonQuestions->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCommonQuestions =  Permission::create(['name'  => 'delete_common_questions', 'display_name'      =>  ['ar'   =>  'حذف سؤال',   'en'    =>  'Delete Question'], 'route' => 'common_questions/{common_questions}', 'module' => 'common_questions', 'as' => 'common_questions.destroy', 'icon' => null, 'parent' => $manageCommonQuestions->id, 'parent_original' => $manageCommonQuestions->id, 'parent_show' => $manageCommonQuestions->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Common Question video
        $manageCommonQuestionVideos = Permission::create(['name' => 'manage_common_question_videos', 'display_name' => ['ar'   =>  'فيديوهات الاسئلة الشائعة',   'en'    =>  'Asked Question Videos'], 'route' => 'common_question_videos', 'module' => 'common_question_videos', 'as' => 'common_question_videos.index', 'icon' => 'fas fa-question', 'parent' => $manageCommonQuestions->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageCommonQuestionVideos->parent_show = $manageCommonQuestionVideos->id;
        $manageCommonQuestionVideos->save();
        $showCommonQuestionVideos   =  Permission::create(['name'  => 'show_common_question_videos', 'display_name'        =>  ['ar'   =>  'فيديوهات الأسئلة الشائعة',   'en'    =>  'Question Videos'], 'route' => 'common_question_videos', 'module' => 'common_question_videos', 'as' => 'common_question_videos.index', 'icon' => 'fas fa-question', 'parent' => $manageCommonQuestionVideos->id, 'parent_original' => $manageCommonQuestionVideos->id, 'parent_show' => $manageCommonQuestionVideos->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCommonQuestionVideos =  Permission::create(['name'  => 'create_common_question_videos', 'display_name'      =>  ['ar'   =>  'إنشاء فيدوا للأسئلة الشائعة',   'en'    =>  'Create Question Videos'], 'route' => 'common_question_videos/create', 'module' => 'common_question_videos', 'as' => 'common_question_videos.create', 'icon' => null, 'parent' => $manageCommonQuestionVideos->id, 'parent_original' => $manageCommonQuestionVideos->id, 'parent_show' => $manageCommonQuestionVideos->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayCommonQuestionVideos =  Permission::create(['name' => 'display_common_question_videos', 'display_name'     =>  ['ar'   =>  'عرض فيديوا للأسئلة الشائقة',   'en'    =>  'Dispay Question Videos'], 'route' => 'common_question_videos/{common_question_videos}', 'module' => 'common_question_videos', 'as' => 'common_question_videos.show', 'icon' => null, 'parent' => $manageCommonQuestionVideos->id, 'parent_original' => $manageCommonQuestionVideos->id, 'parent_show' => $manageCommonQuestionVideos->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCommonQuestionVideos  =  Permission::create(['name' => 'update_common_question_videos', 'display_name'      =>  ['ar'   =>  'تعديل فيديوا للأسئلة الشائعة',   'en'    =>  'Edit Question Videos'], 'route' => 'common_question_videos/{common_question_videos}/edit', 'module' => 'common_question_videos', 'as' => 'common_question_videos.edit', 'icon' => null, 'parent' => $manageCommonQuestionVideos->id, 'parent_original' => $manageCommonQuestionVideos->id, 'parent_show' => $manageCommonQuestionVideos->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCommonQuestionVideos =  Permission::create(['name'  => 'delete_common_question_videos', 'display_name'      =>  ['ar'   =>  'حذف فيديوا للأسئلة الشائعة',   'en'    =>  'Delete Question Videos'], 'route' => 'common_question_videos/{common_question_videos}', 'module' => 'common_question_videos', 'as' => 'common_question_videos.destroy', 'icon' => null, 'parent' => $manageCommonQuestionVideos->id, 'parent_original' => $manageCommonQuestionVideos->id, 'parent_show' => $manageCommonQuestionVideos->id, 'sidebar_link' => '0', 'appear' => '0']);



        // Main Menus
        $manageMainMenus = Permission::create(['name' => 'manage_main_menus', 'display_name' => ['ar' => 'إدارة القوائم', 'en' => 'Manage Menus'], 'route' => 'main_menus', 'module' => 'main_menus', 'as' => 'main_menus.index', 'icon' => 'fa fa-list-ul', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '85',]);
        $manageMainMenus->parent_show = $manageMainMenus->id;
        $manageMainMenus->save();
        $showMainMenus    =  Permission::create(['name' => 'show_main_menus',  'display_name' => ['ar'     => 'إدارة القائمة الرئيسية', 'en'  =>   'Main Menu'], 'route' => 'main_menus', 'module' => 'main_menus', 'as' => 'main_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => $manageMainMenus->id, 'parent_show' => $manageMainMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createMainMenus  =  Permission::create(['name' => 'create_main_menus', 'display_name'  => ['ar'     => 'إضافة عنصر قائمة رئيسية', 'en'  =>  'Add Main Menu Item'], 'route' => 'main_menus', 'module' => 'main_menus', 'as' => 'main_menus.create', 'icon' => null, 'parent' => $manageMainMenus->id, 'parent_original' => $manageMainMenus->id, 'parent_show' => $manageMainMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayMainMenus =  Permission::create(['name' => 'display_main_menus', 'display_name'  => ['ar'     => 'عرض عنصر قائمة رئيسية', 'en'  =>  'Display Main Menu Item'], 'route' => 'main_menus', 'module' => 'main_menus', 'as' => 'main_menus.show', 'icon' => null, 'parent' => $manageMainMenus->id, 'parent_original' => $manageMainMenus->id, 'parent_show' => $manageMainMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateMainMenus  =  Permission::create(['name' => 'update_main_menus', 'display_name'  => ['ar'     => 'تعديل عنصر قائمة رئيسية', 'en'  =>  'Edit Main Menu Item'], 'route' => 'main_menus', 'module' => 'main_menus', 'as' => 'main_menus.edit', 'icon' => null, 'parent' => $manageMainMenus->id, 'parent_original' => $manageMainMenus->id, 'parent_show' => $manageMainMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteMainMenus  =  Permission::create(['name' => 'delete_main_menus', 'display_name'  => ['ar'     => 'حذف عنصر قائمة رئيسية', 'en'  =>  'Delete Main Menu Item'], 'route' => 'main_menus', 'module' => 'main_menus', 'as' => 'main_menus.destroy', 'icon' => null, 'parent' => $manageMainMenus->id, 'parent_original' => $manageMainMenus->id, 'parent_show' => $manageMainMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Academic Programs menu AcademicProgramMenus
        $manageAcademicProgramMenus = Permission::create(['name' => 'manage_academic_program_menus', 'display_name' => ['ar'    =>  'إدارة البرامج الأكاديمية', 'en'   =>  'Academic Programs'], 'route' => 'academic_program_menus', 'module' => 'academic_program_menus', 'as' => 'academic_program_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '90',]);
        $manageAcademicProgramMenus->parent_show = $manageAcademicProgramMenus->id;
        $manageAcademicProgramMenus->save();
        $showAcademicProgramMenus    =  Permission::create(['name' => 'show_academic_program_menus',  'display_name' => ['ar'    =>  ' إدارة البرامج الأكاديمية',   'en'    =>  'Manage Academic Programs'], 'route' => 'academic_program_menus', 'module' => 'academic_program_menus', 'as' => 'academic_program_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageAcademicProgramMenus->id, 'parent_original' => $manageAcademicProgramMenus->id, 'parent_show' => $manageAcademicProgramMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createAcademicProgramMenus  =  Permission::create(['name' => 'create_academic_program_menus', 'display_name'  => ['ar'  =>  ' إضافة برنامج اكاديمي',   'en'    =>  'Add Academic Program'], 'route' => 'academic_program_menus', 'module' => 'academic_program_menus', 'as' => 'academic_program_menus.create', 'icon' => null, 'parent' => $manageAcademicProgramMenus->id, 'parent_original' => $manageAcademicProgramMenus->id, 'parent_show' => $manageAcademicProgramMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayAcademicProgramMenus =  Permission::create(['name' => 'display_academic_program_menus', 'display_name'  => ['ar'  =>  'عرض برنامج اكاديمي',   'en'    =>  'Display Academic Program'], 'route' => 'academic_program_menus', 'module' => 'academic_program_menus', 'as' => 'academic_program_menus.show', 'icon' => null, 'parent' => $manageAcademicProgramMenus->id, 'parent_original' => $manageAcademicProgramMenus->id, 'parent_show' => $manageAcademicProgramMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateAcademicProgramMenus  =  Permission::create(['name' => 'update_academic_program_menus', 'display_name'  => ['ar'  =>  'تعديل برنامج اكاديمي',   'en'    =>  'Edit Academic Program'], 'route' => 'academic_program_menus', 'module' => 'academic_program_menus', 'as' => 'academic_program_menus.edit', 'icon' => null, 'parent' => $manageAcademicProgramMenus->id, 'parent_original' => $manageAcademicProgramMenus->id, 'parent_show' => $manageAcademicProgramMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAcademicProgramMenus  =  Permission::create(['name' => 'delete_academic_program_menus', 'display_name'  => ['ar'  =>  'حذف برنامج اكاديمي',   'en'    =>  'Delete Academic Program'], 'route' => 'academic_program_menus', 'module' => 'academic_program_menus', 'as' => 'academic_program_menus.destroy', 'icon' => null, 'parent' => $manageAcademicProgramMenus->id, 'parent_original' => $manageAcademicProgramMenus->id, 'parent_show' => $manageAcademicProgramMenus->id, 'sidebar_link' => '0', 'appear' => '0']);


        //Topics menu
        $manageTopicsMenus = Permission::create(['name' => 'manage_topics_menus', 'display_name' => ['ar'    =>  'إدارة قائمة المواضيع', 'en'   =>  'Topics Menu'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '95',]);
        $manageTopicsMenus->parent_show = $manageTopicsMenus->id;
        $manageTopicsMenus->save();
        $showTopicsMenus    =  Permission::create(['name' => 'show_topics_menus',  'display_name' => ['ar'  =>  'إدارة قائمة المواضيع',   'en'    =>  'Topics Menu'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createTopicsMenus  =  Permission::create(['name' => 'create_topics_menus', 'display_name'  => ['ar'  =>  'إضافة قائمة موضوع',   'en'    =>  'Add Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.create', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayTopicsMenus =  Permission::create(['name' => 'display_topics_menus', 'display_name'  => ['ar'  =>  'عرض قائمة موضوع',   'en'    =>  'Display Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.show', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTopicsMenus  =  Permission::create(['name' => 'update_topics_menus', 'display_name'  => ['ar'  =>  'تعديل قائمة موضوع',   'en'    =>  'Edit Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.edit', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTopicsMenus  =  Permission::create(['name' => 'delete_topics_menus', 'display_name'  => ['ar'  =>  'حذف قائمة موضوع',   'en'    =>  'Delete Topic Menu Link'], 'route' => 'topics_menus', 'module' => 'topics_menus', 'as' => 'topics_menus.destroy', 'icon' => null, 'parent' => $manageTopicsMenus->id, 'parent_original' => $manageTopicsMenus->id, 'parent_show' => $manageTopicsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Tracks menu
        $manageTracksMenus = Permission::create(['name' => 'manage_tracks_menus', 'display_name' => ['ar'    =>  'إدارة قائمة المسارات', 'en'   =>  'Tracks Menu'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageTracksMenus->parent_show = $manageTracksMenus->id;
        $manageTracksMenus->save();
        $showTracksMenus    =  Permission::create(['name' => 'show_tracks_menus',  'display_name' => ['ar'  =>  'إدارة قائمة المسارات',   'en'    =>  'Tracks Menu'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createTracksMenus  =  Permission::create(['name' => 'create_tracks_menus', 'display_name'  => ['ar'  =>  'إضافة قائمة مسار',   'en'    =>  'Add Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.create', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayTracksMenus =  Permission::create(['name' => 'display_tracks_menus', 'display_name'  => ['ar'  =>  'عرض قائمة مسار',   'en'    =>  'Display Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.show', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTracksMenus  =  Permission::create(['name' => 'update_tracks_menus', 'display_name'  => ['ar'  =>  'تعديل قائمة مسار',   'en'    =>  'Edit Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.edit', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTracksMenus  =  Permission::create(['name' => 'delete_tracks_menus', 'display_name'  => ['ar'  =>  'حذف قائمة مسار',   'en'    =>  'Delete Track Menu Link'], 'route' => 'tracks_menus', 'module' => 'tracks_menus', 'as' => 'tracks_menus.destroy', 'icon' => null, 'parent' => $manageTracksMenus->id, 'parent_original' => $manageTracksMenus->id, 'parent_show' => $manageTracksMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Support menu
        $manageSupportMenus = Permission::create(['name' => 'manage_support_menus', 'display_name' => ['ar'    =>  'إدارة قائمة الدعم', 'en'   =>  'Support Menu'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $manageSupportMenus->parent_show = $manageSupportMenus->id;
        $manageSupportMenus->save();
        $showSupportMenus    =  Permission::create(['name' => 'show_support_menus',  'display_name' => ['ar'  =>  'إدارة قائمة الدعم',   'en'    =>  'Support Menu'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createSupportMenus  =  Permission::create(['name' => 'create_support_menus', 'display_name'  => ['ar'  =>  'إضافة قامة دعم',   'en'    =>  'Add Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.create', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displaySupportMenus =  Permission::create(['name' => 'display_support_menus', 'display_name'  => ['ar'  =>  'عرض قامة دعم',   'en'    =>  'Display Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.show', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupportMenus  =  Permission::create(['name' => 'update_support_menus', 'display_name'  => ['ar'  =>  'تعديل قامة دعم',   'en'    =>  'Edit Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.edit', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupportMenus  =  Permission::create(['name' => 'delete_support_menus', 'display_name'  => ['ar'  =>  'حذف قامة دعم',   'en'    =>  'Delete Support Menu Link'], 'route' => 'support_menus', 'module' => 'support_menus', 'as' => 'support_menus.destroy', 'icon' => null, 'parent' => $manageSupportMenus->id, 'parent_original' => $manageSupportMenus->id, 'parent_show' => $manageSupportMenus->id, 'sidebar_link' => '0', 'appear' => '0']);


        //company menu
        $manageCompanyMenu = Permission::create(['name' => 'manage_company_menus', 'display_name' => ['ar'    =>  'إدارة قائمة المؤسسة', 'en'   =>  'Company Menu'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '90',]);
        $manageCompanyMenu->parent_show = $manageCompanyMenu->id;
        $manageCompanyMenu->save();
        $showCompanyMenu    =  Permission::create(['name' => 'show_company_menus',  'display_name' => ['ar'  =>  'إدارة قوائم المؤسسة',   'en'    =>  'Manage Company Menu'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCompanyMenu  =  Permission::create(['name' => 'create_company_menus', 'display_name'  => ['ar'  =>  ' إضافة قائمة مؤسسة',   'en'    =>  'Add Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.create', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayCompanyMenu =  Permission::create(['name' => 'display_company_menus', 'display_name'  => ['ar'  =>  'عرض قائمة مؤسسة',   'en'    =>  'Display Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.show', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCompanyMenu  =  Permission::create(['name' => 'update_company_menus', 'display_name'  => ['ar'  =>  'تعديل قائمة مؤسسة',   'en'    =>  'Edit Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.edit', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCompanyMenu  =  Permission::create(['name' => 'delete_company_menus', 'display_name'  => ['ar'  =>  'حذف قائمة مؤسسة',   'en'    =>  'Delete Company Menu Link'], 'route' => 'company_menus', 'module' => 'company_menus', 'as' => 'company_menus.destroy', 'icon' => null, 'parent' => $manageCompanyMenu->id, 'parent_original' => $manageCompanyMenu->id, 'parent_show' => $manageCompanyMenu->id, 'sidebar_link' => '0', 'appear' => '0']);

        //importantlink menu
        $manageImportantLinkMenus = Permission::create(['name' => 'manage_important_link_menus', 'display_name' => ['ar'    =>  'إدارة قائمة روابط مهمة', 'en'   =>  'Important Link Menu'], 'route' => 'important_link_menus', 'module' => 'important_link_menus', 'as' => 'important_link_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $manageImportantLinkMenus->parent_show = $manageImportantLinkMenus->id;
        $manageImportantLinkMenus->save();
        $showImportantLinkMenus    =  Permission::create(['name' => 'show_important_link_menus',  'display_name' => ['ar'  =>  'إدارة قائمة روابط مهمة',   'en'    =>  'Important Link Menu'], 'route' => 'important_link_menus', 'module' => 'important_link_menus', 'as' => 'important_link_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageImportantLinkMenus->id, 'parent_original' => $manageImportantLinkMenus->id, 'parent_show' => $manageImportantLinkMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createImportantLinkMenus  =  Permission::create(['name' => 'create_important_link_menus', 'display_name'  => ['ar'  =>  'إضافة عنصر قائمة روابط مهمة ',   'en'    =>  'Add Important Link Menu Item'], 'route' => 'important_link_menus', 'module' => 'important_link_menus', 'as' => 'important_link_menus.create', 'icon' => null, 'parent' => $manageImportantLinkMenus->id, 'parent_original' => $manageImportantLinkMenus->id, 'parent_show' => $manageImportantLinkMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayImportantLinkMenus =  Permission::create(['name' => 'display_important_link_menus', 'display_name'  => ['ar'  =>  'عرض عنصر قائمة روابط مهمة ',   'en'    =>  'Display Important Link Menu Item'], 'route' => 'important_link_menus', 'module' => 'important_link_menus', 'as' => 'important_link_menus.show', 'icon' => null, 'parent' => $manageImportantLinkMenus->id, 'parent_original' => $manageImportantLinkMenus->id, 'parent_show' => $manageImportantLinkMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateImportantLinkMenus  =  Permission::create(['name' => 'update_important_link_menus', 'display_name'  => ['ar'  =>  'تعديل عنصر قائمة روابط مهمة ',   'en'    =>  'Edit Important Link Menu Item'], 'route' => 'important_link_menus', 'module' => 'important_link_menus', 'as' => 'important_link_menus.edit', 'icon' => null, 'parent' => $manageImportantLinkMenus->id, 'parent_original' => $manageImportantLinkMenus->id, 'parent_show' => $manageImportantLinkMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteImportantLinkMenus  =  Permission::create(['name' => 'delete_important_link_menus', 'display_name'  => ['ar'  =>  'حذف عنصر قائمة روابط مهمة ',   'en'    =>  'Delete Important Link Menu Item'], 'route' => 'important_link_menus', 'module' => 'important_link_menus', 'as' => 'important_link_menus.destroy', 'icon' => null, 'parent' => $manageImportantLinkMenus->id, 'parent_original' => $manageImportantLinkMenus->id, 'parent_show' => $manageImportantLinkMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //contactUs menu
        $manageContactUsMenus = Permission::create(['name' => 'manage_contact_us_menus', 'display_name' => ['ar'    =>  'إدارة قائمة تواصل معنا', 'en'   =>  'Contact Us Menu'], 'route' => 'contact_us_menus', 'module' => 'contact_us_menus', 'as' => 'contact_us_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $manageContactUsMenus->parent_show = $manageContactUsMenus->id;
        $manageContactUsMenus->save();
        $showContactUsMenus    =  Permission::create(['name' => 'show_contact_us_menus',  'display_name' => ['ar'  =>  'إدارة قائمة تواصل معنا',   'en'    =>  'Contact Us Menu'], 'route' => 'contact_us_menus', 'module' => 'contact_us_menus', 'as' => 'contact_us_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageContactUsMenus->id, 'parent_original' => $manageContactUsMenus->id, 'parent_show' => $manageContactUsMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createContactUsMenus  =  Permission::create(['name' => 'create_contact_us_menus', 'display_name'  => ['ar'  =>  'إضافة عنصر قائمة تواصل معنا ',   'en'    =>  'Add Contact Us Menu Item'], 'route' => 'contact_us_menus', 'module' => 'contact_us_menus', 'as' => 'contact_us_menus.create', 'icon' => null, 'parent' => $manageContactUsMenus->id, 'parent_original' => $manageContactUsMenus->id, 'parent_show' => $manageContactUsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayContactUsMenus =  Permission::create(['name' => 'display_contact_us_menus', 'display_name'  => ['ar'  =>  'عرض عنصر قائمة تواصل معنا ',   'en'    =>  'Display Contact Us Menu Item'], 'route' => 'contact_us_menus', 'module' => 'contact_us_menus', 'as' => 'contact_us_menus.show', 'icon' => null, 'parent' => $manageContactUsMenus->id, 'parent_original' => $manageContactUsMenus->id, 'parent_show' => $manageContactUsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateContactUsMenus  =  Permission::create(['name' => 'update_contact_us_menus', 'display_name'  => ['ar'  =>  'تعديل عنصر قائمة تواصل معنا ',   'en'    =>  'Edit Contact Us Menu Item'], 'route' => 'contact_us_menus', 'module' => 'contact_us_menus', 'as' => 'contact_us_menus.edit', 'icon' => null, 'parent' => $manageContactUsMenus->id, 'parent_original' => $manageContactUsMenus->id, 'parent_show' => $manageContactUsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteContactUsMenus  =  Permission::create(['name' => 'delete_contact_us_menus', 'display_name'  => ['ar'  =>  'حذف عنصر قائمة تواصل معنا ',   'en'    =>  'Delete Contact Us Menu Item'], 'route' => 'contact_us_menus', 'module' => 'contact_us_menus', 'as' => 'contact_us_menus.destroy', 'icon' => null, 'parent' => $manageContactUsMenus->id, 'parent_original' => $manageContactUsMenus->id, 'parent_show' => $manageContactUsMenus->id, 'sidebar_link' => '0', 'appear' => '0']);

        //PoliciesPrivacyMenu menu
        $managePoliciesPrivacyMenus = Permission::create(['name' => 'manage_policies_privacy_menus', 'display_name' => ['ar'    =>  'إدارة قائمة السياسات والخصوصية', 'en'   =>  'Policies Privacy Menu'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.index', 'icon' => 'fas fa-bars', 'parent' => $manageMainMenus->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '105',]);
        $managePoliciesPrivacyMenus->parent_show = $managePoliciesPrivacyMenus->id;
        $managePoliciesPrivacyMenus->save();
        $showPoliciesPrivacyMenus    =  Permission::create(['name' => 'show_policies_privacy_menus',  'display_name' => ['ar'  =>  'إدارة قائمة السياسات والخصوصية',   'en'    =>  'Policies Privacy Menu'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.index', 'icon' => 'fas fa-bars', 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPoliciesPrivacyMenus  =  Permission::create(['name' => 'create_policies_privacy_menus', 'display_name'  => ['ar'  =>  'إضافة عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Add Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.create', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPoliciesPrivacyMenus =  Permission::create(['name' => 'display_policies_privacy_menus', 'display_name'  => ['ar'  =>  'عرض عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Display Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.show', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePoliciesPrivacyMenus  =  Permission::create(['name' => 'update_policies_privacy_menus', 'display_name'  => ['ar'  =>  'تعديل عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Edit Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.edit', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePoliciesPrivacyMenus  =  Permission::create(['name' => 'delete_policies_privacy_menus', 'display_name'  => ['ar'  =>  'حذف عنصر قائمة السياسات والخصوصية ',   'en'    =>  'Delete Policies Privacy Menu Item'], 'route' => 'policies_privacy_menus', 'module' => 'policies_privacy_menus', 'as' => 'policies_privacy_menus.destroy', 'icon' => null, 'parent' => $managePoliciesPrivacyMenus->id, 'parent_original' => $managePoliciesPrivacyMenus->id, 'parent_show' => $managePoliciesPrivacyMenus->id, 'sidebar_link' => '0', 'appear' => '0']);


        //page Categories 
        $managePageCategories = Permission::create(['name' => 'manage_page_categories', 'display_name' => ['ar' => 'إدارة الصفحات', 'en' => 'Manage Pages'], 'route' => 'page_categories', 'module' => 'page_categories', 'as' => 'page_categories.index', 'icon' => 'far fa-file-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '115',]);
        $managePageCategories->parent_show = $managePageCategories->id;
        $managePageCategories->save();
        $showPages    =  Permission::create(['name' => 'show_page_categories',  'display_name' => ['ar'     => 'إدارة تصنيف الصفحات ', 'en'  =>   'manage Page Categories'], 'route' => 'page_categories', 'module' => 'page_categories', 'as' => 'page_categories.index', 'icon' => 'far fa-file-alt', 'parent' => $managePageCategories->id, 'parent_original' => $managePageCategories->id, 'parent_show' => $managePageCategories->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPages  =  Permission::create(['name' => 'create_page_categories', 'display_name'  => ['ar'     => 'إضافة تصنيف صفحة', 'en'  =>  'Add Page Category'], 'route' => 'page_categories', 'module' => 'page_categories', 'as' => 'page_categories.create', 'icon' => null, 'parent' => $managePageCategories->id, 'parent_original' => $managePageCategories->id, 'parent_show' => $managePageCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPages =  Permission::create(['name' => 'display_page_categories', 'display_name'  => ['ar'     => 'عرض تصنيف صفحة', 'en'  =>  'Display Page Category'], 'route' => 'page_categories', 'module' => 'page_categories', 'as' => 'page_categories.show', 'icon' => null, 'parent' => $managePageCategories->id, 'parent_original' => $managePageCategories->id, 'parent_show' => $managePageCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePages  =  Permission::create(['name' => 'update_page_categories', 'display_name'  => ['ar'     => 'تعديل تصنيف صفحة', 'en'  =>  'Edit Page Category'], 'route' => 'page_categories', 'module' => 'page_categories', 'as' => 'page_categories.edit', 'icon' => null, 'parent' => $managePageCategories->id, 'parent_original' => $managePageCategories->id, 'parent_show' => $managePageCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePages  =  Permission::create(['name' => 'delete_page_categories', 'display_name'  => ['ar'     => 'حذف تصنيف صفحة', 'en'  =>  'Delete Page Category'], 'route' => 'page_categories', 'module' => 'page_categories', 'as' => 'page_categories.destroy', 'icon' => null, 'parent' => $managePageCategories->id, 'parent_original' => $managePageCategories->id, 'parent_show' => $managePageCategories->id, 'sidebar_link' => '0', 'appear' => '0']);

        //pages 
        $managePages = Permission::create(['name' => 'manage_pages', 'display_name' => ['ar' => 'إدارة الصفحات', 'en' => 'Manage Pages'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.index', 'icon' => 'far fa-file-alt', 'parent' => $managePageCategories->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '115',]);
        $managePages->parent_show = $managePages->id;
        $managePages->save();
        $showPages    =  Permission::create(['name' => 'show_pages',  'display_name' => ['ar'     => 'إدارة الصفحة ', 'en'  =>   'Main Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.index', 'icon' => 'far fa-file-alt', 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $createPages  =  Permission::create(['name' => 'create_pages', 'display_name'  => ['ar'     => 'إضافة صفحة', 'en'  =>  'Add Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.create', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPages =  Permission::create(['name' => 'display_pages', 'display_name'  => ['ar'     => 'عرض صفحة', 'en'  =>  'Display Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.show', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePages  =  Permission::create(['name' => 'update_pages', 'display_name'  => ['ar'     => 'تعديل صفحة', 'en'  =>  'Edit Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.edit', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePages  =  Permission::create(['name' => 'delete_pages', 'display_name'  => ['ar'     => 'حذف صفحة', 'en'  =>  'Delete Page'], 'route' => 'pages', 'module' => 'pages', 'as' => 'pages.destroy', 'icon' => null, 'parent' => $managePages->id, 'parent_original' => $managePages->id, 'parent_show' => $managePages->id, 'sidebar_link' => '0', 'appear' => '0']);

        // posts
        $managePosts = Permission::create(['name' => 'manage_posts', 'display_name' => ['ar'  =>  'إدارة المدونة',    'en'    =>  'Manage Blogs'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $managePosts->parent_show = $managePosts->id;
        $managePosts->save();
        $showPosts   =  Permission::create(['name'  => 'show_posts', 'display_name'       =>  ['ar'   =>  'المنشورات',   'en'    =>  'Posts'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createPosts =  Permission::create(['name'  => 'create_posts', 'display_name'     =>  ['ar'   =>  'إنشاء منشور',   'en'    =>  'Create Post'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayPosts =  Permission::create(['name' => 'display_posts', 'display_name'    =>  ['ar'   =>  'عرض منشور',   'en'    =>  'Display Post'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updatePosts  =  Permission::create(['name' => 'update_posts', 'display_name'     =>  ['ar'   =>  'تعديل منشور',   'en'    =>  'Edit Post'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deletePosts =  Permission::create(['name'  => 'delete_posts', 'display_name'     =>  ['ar'   =>  'حذف منشور',   'en'    =>  'Delete Post'], 'route' => 'posts', 'module' => 'posts', 'as' => 'posts.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

        // news
        $manageNews = Permission::create(['name' => 'manage_news', 'display_name' => ['ar'  =>  'إدارة الاخبار',    'en'    =>  'Manage News'], 'route' => 'news', 'module' => 'news', 'as' => 'news.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $manageNews->parent_show = $manageNews->id;
        $manageNews->save();
        $showNews   =  Permission::create(['name'  => 'show_news', 'display_name'       =>  ['ar'   =>  'الاخبار',   'en'    =>  'News'], 'route' => 'news', 'module' => 'news', 'as' => 'news.index', 'icon' => 'fas fas fa-newspaper', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createNews =  Permission::create(['name'  => 'create_news', 'display_name'     =>  ['ar'   =>  'إنشاء خبر',   'en'    =>  'Create News'], 'route' => 'news', 'module' => 'news', 'as' => 'news.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayNews =  Permission::create(['name' => 'display_news', 'display_name'    =>  ['ar'   =>  'عرض خبر',   'en'    =>  'Display News'], 'route' => 'news', 'module' => 'news', 'as' => 'news.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateNews  =  Permission::create(['name' => 'update_news', 'display_name'     =>  ['ar'   =>  'تعديل خبر',   'en'    =>  'Edit News'], 'route' => 'news', 'module' => 'news', 'as' => 'news.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteNews =  Permission::create(['name'  => 'delete_news', 'display_name'     =>  ['ar'   =>  'حذف خبر',   'en'    =>  'Delete News'], 'route' => 'news', 'module' => 'news', 'as' => 'news.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

        // Advs
        $manageAdvs = Permission::create(['name' => 'manage_advs', 'display_name' => ['ar'  =>  'إدارة الإعلانات',    'en'    =>  'Manage Advertisements'], 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.index', 'icon' => 'fab fa-adversal', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $manageAdvs->parent_show = $manageAdvs->id;
        $manageAdvs->save();
        $showAdvs   =  Permission::create(['name'  => 'show_advs', 'display_name'       =>  ['ar'   =>  'الإعلانات',   'en'    =>  'Advertisements'], 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.index', 'icon' => 'fab fa-adversal', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createAdvs =  Permission::create(['name'  => 'create_advs', 'display_name'     =>  ['ar'   =>  'إنشاء اعلان',   'en'    =>  'Create Advertisement'], 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayAdvs =  Permission::create(['name' => 'display_advs', 'display_name'    =>  ['ar'   =>  'عرض اعلان',   'en'    =>  'Display Advertisement'], 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateAdvs  =  Permission::create(['name' => 'update_advs', 'display_name'     =>  ['ar'   =>  'تعديل اعلان',   'en'    =>  'Edit Advertisement'], 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAdvs =  Permission::create(['name'  => 'delete_advs', 'display_name'     =>  ['ar'   =>  'حذف اعلان',   'en'    =>  'Delete Advertisement'], 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

        // Events
        $manageEvents = Permission::create(['name' => 'manage_events', 'display_name' => ['ar'  =>  'إدارة الاحداث القادمة',    'en'    =>  'Manage ُEvents'], 'route' => 'events', 'module' => 'events', 'as' => 'events.index', 'icon' => 'far fa-calendar-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $manageEvents->parent_show = $manageEvents->id;
        $manageEvents->save();
        $showEvents   =  Permission::create(['name'  => 'show_events', 'display_name'       =>  ['ar'   =>  'الاحداث القادمة',   'en'    =>  'ُEvents'], 'route' => 'events', 'module' => 'events', 'as' => 'events.index', 'icon' => 'far fa-calendar-alt', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createEvents =  Permission::create(['name'  => 'create_events', 'display_name'     =>  ['ar'   =>  'إنشاء حدث',   'en'    =>  'Create Event'], 'route' => 'events', 'module' => 'events', 'as' => 'events.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayEvents =  Permission::create(['name' => 'display_events', 'display_name'    =>  ['ar'   =>  'عرض حدث',   'en'    =>  'Display Event'], 'route' => 'events', 'module' => 'events', 'as' => 'events.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateEvents  =  Permission::create(['name' => 'update_events', 'display_name'     =>  ['ar'   =>  'تعديل حدث',   'en'    =>  'Edit Event'], 'route' => 'events', 'module' => 'events', 'as' => 'events.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteEvents =  Permission::create(['name'  => 'delete_events', 'display_name'     =>  ['ar'   =>  'حذف حدث',   'en'    =>  'Delete Event'], 'route' => 'events', 'module' => 'events', 'as' => 'events.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        // Albums
        $manageAlbums  = Permission::create(['name' => 'manage_albums', 'display_name' => ['ar'  =>  'إدارة البومات الصور',    'en'    =>  'Manage Albums'], 'route' => 'albums', 'module' => 'albums', 'as' => 'albums.index', 'icon' => 'far fa-images', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $manageAlbums->parent_show = $manageAlbums->id;
        $manageAlbums->save();
        $showAlbums   =  Permission::create(['name'  => 'show_albums', 'display_name'       =>  ['ar'   =>  'البومات الصور',   'en'    =>  'Albums'], 'route' => 'albums', 'module' => 'albums', 'as' => 'albums.index', 'icon' => 'far fa-images', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createAlbums =  Permission::create(['name'  => 'create_albums', 'display_name'     =>  ['ar'   =>  'إنشاء البوم جديد',   'en'    =>  'Create Album'], 'route' => 'albums', 'module' => 'albums', 'as' => 'albums.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayAlbums =  Permission::create(['name' => 'display_albums', 'display_name'    =>  ['ar'   =>  'عرض البوم ',   'en'    =>  'Display Album'], 'route' => 'albums', 'module' => 'albums', 'as' => 'albums.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateAlbums  =  Permission::create(['name' => 'update_albums', 'display_name'     =>  ['ar'   =>  'تعديل البوم',   'en'    =>  'Edit Album'], 'route' => 'albums', 'module' => 'albums', 'as' => 'albums.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteAlbums =  Permission::create(['name'  => 'delete_albums', 'display_name'     =>  ['ar'   =>  'حذف البوم',   'en'    =>  'Delete Album'], 'route' => 'albums', 'module' => 'albums', 'as' => 'albums.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        // PlayLists
        $managePlayLists  = Permission::create(['name' => 'manage_playlists', 'display_name' => ['ar'  =>  'إدارة قوائم التشغيل  ',    'en'    =>  'Manage Playlists'], 'route' => 'playlists', 'module' => 'playlists', 'as' => 'playlists.index', 'icon' => 'fas fa-video', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '70',]);
        $managePlayLists->parent_show = $managePlayLists->id;
        $managePlayLists->save();
        $showPlayLists   =  Permission::create(['name'  => 'show_playlists', 'display_name'       =>  ['ar'   =>  'قوائم التشغيل',   'en'    =>  'Playlists'], 'route' => 'playlists', 'module' => 'playlists', 'as' => 'playlists.index', 'icon' => 'fas fa-video', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createPlayLists =  Permission::create(['name'  => 'create_playlists', 'display_name'     =>  ['ar'   =>  'إنشاء قائمة تشغيل جديد',   'en'    =>  'Create Playlist'], 'route' => 'playlists', 'module' => 'playlists', 'as' => 'playlists.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayPlayLists =  Permission::create(['name' => 'display_playlists', 'display_name'    =>  ['ar'   =>  'عرض قائمة تشغيل ',   'en'    =>  'Display Playlist'], 'route' => 'playlists', 'module' => 'playlists', 'as' => 'playlists.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updatePlayLists  =  Permission::create(['name' => 'update_playlists', 'display_name'     =>  ['ar'   =>  'تعديل قائمة تشغيل',   'en'    =>  'Edit Playlist'], 'route' => 'playlists', 'module' => 'playlists', 'as' => 'playlists.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deletePlayLists =  Permission::create(['name'  => 'delete_playlists', 'display_name'     =>  ['ar'   =>  'حذف قائمة تشغيل',   'en'    =>  'Delete Playlist'], 'route' => 'playlists', 'module' => 'playlists', 'as' => 'playlists.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        //Tags
        $manageTags = Permission::create(['name' => 'manage_tags', 'display_name' => ['ar'  =>  'إدارة الكلمات المفتاحية',  'en'    =>  'Manage Tags'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.index', 'icon' => 'fas fa-tags', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '130',]);
        $manageTags->parent_show = $manageTags->id;
        $manageTags->save();
        $showTags    =  Permission::create(['name' => 'show_tags',  'display_name' =>   ['ar'   =>  ' الكلمات المفتاحية',   'en'        =>  'Tags'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.index', 'icon' => 'fas fa-tags', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createTags  =  Permission::create(['name' => 'create_tags', 'display_name'  =>   ['ar'   =>  'إضافة كلمة مفتاحية',   'en'       =>  'Add New Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayTags =  Permission::create(['name' => 'display_tags', 'display_name'  =>   ['ar'   =>  'استعراض كلمة مفتاحية',   'en'      =>  'Display Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateTags  =  Permission::create(['name' => 'update_tags', 'display_name'  =>   ['ar'   =>  'تعديل كلمة مفتاحية',   'en'        =>  'Update Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTags  =  Permission::create(['name' => 'delete_tags', 'display_name'  =>   ['ar'   =>  'حذف لكمة مفتاحية',   'en'          =>  'Delete Tag'], 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

        //manage Document Archives
        $manageDocumentArchives = Permission::create(['name' => 'manage_document_archives', 'display_name' => ['ar'    =>  'إدارة الإرشيف',   'en'    =>  'Manage Archives'], 'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-folder-minus', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '135',]);
        $manageDocumentArchives->parent_show = $manageDocumentArchives->id;
        $manageDocumentArchives->save();
        $showDocumentArchives    =  Permission::create(['name' => 'show_document_archives', 'display_name'       =>    ['ar'   =>  'إرشيف الوثائق',   'en'    =>  ' Document Archives'],   'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-folder-minus', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createDocumentArchives  =  Permission::create(['name' => 'create_document_archives', 'display_name'     =>    ['ar'   =>  'إضافة إرشيف وثيقة جديد',   'en'    =>  'Add Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentArchives =  Permission::create(['name' => 'display_document_archives', 'display_name'    =>    ['ar'   =>  ' عرض إرشيف وثيقة',   'en'    =>  'Display Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentArchives  =  Permission::create(['name' => 'update_document_archives', 'display_name'     =>    ['ar'   =>  'تعديل إرشيف وثيقة',   'en'    =>  'Edit Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentArchives  =  Permission::create(['name' => 'delete_document_archives', 'display_name'     =>    ['ar'   =>  'حذف إرشيف وثيقة',   'en'    =>  'Delete Document Archive'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

        // Statistics
        $manageStatistics = Permission::create(['name' => 'manage_Statistics', 'display_name' => ['ar'  =>  'إدارة إحصائيات الجامعة',    'en'    =>  'Manage Statistics'], 'route' => 'statistics', 'module' => 'statistics', 'as' => 'statistics.index', 'icon' => 'far fa-calendar-alt', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '140',]);
        $manageStatistics->parent_show = $manageStatistics->id;
        $manageStatistics->save();
        $showStatistics   =  Permission::create(['name'  => 'show_Statistics', 'display_name'       =>  ['ar'   =>  'إحصائيات الجامعة',   'en'    =>  'Statistics'], 'route' => 'statistics', 'module' => 'statistics', 'as' => 'statistics.index', 'icon' => 'far fa-calendar-alt', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $createStatistics =  Permission::create(['name'  => 'create_Statistics', 'display_name'     =>  ['ar'   =>  'إنشاء إحصاء جديد',   'en'    =>  'Create Statistic'], 'route' => 'statistics', 'module' => 'statistics', 'as' => 'statistics.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $displayStatistics =  Permission::create(['name' => 'display_Statistics', 'display_name'    =>  ['ar'   =>  'عرض إحصاء',   'en'    =>  'Display Statistic'], 'route' => 'statistics', 'module' => 'statistics', 'as' => 'statistics.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $updateStatistics  =  Permission::create(['name' => 'update_Statistics', 'display_name'     =>  ['ar'   =>  'تعديل إحصاء',   'en'    =>  'Edit Statistic'], 'route' => 'statistics', 'module' => 'statistics', 'as' => 'statistics.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
        $deleteStatistics =  Permission::create(['name'  => 'delete_Statistics', 'display_name'     =>  ['ar'   =>  'حذف إحصاء',   'en'    =>  'Delete Statistic'], 'route' => 'statistics', 'module' => 'statistics', 'as' => 'statistics.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);


        //Site Settings Holder 
        $manageSiteSettings = Permission::create(['name' => 'manage_site_settings', 'display_name' => ['ar' =>  'الاعدادات العامة', 'en'    =>  'General Settings'], 'route' => 'settings', 'module' => 'settings', 'as' => 'settings.index', 'icon' => 'fa fa-cog', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '180',]);
        $manageSiteSettings->parent_show = $manageSiteSettings->id;
        $manageSiteSettings->save();

        // Site Infos 
        $displaySiteInfos =  Permission::create(['name' => 'display_site_infos', 'display_name'     => ['ar'   =>  'إدارة  بيانات الموقع', 'en'  =>  'Manage Site Infos'], 'route' => 'settings.site_main_infos', 'module' => 'settings.site_main_infos', 'as' => 'settings.site_main_infos.show', 'icon' => 'fa fa-info-circle', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteInfos  =  Permission::create(['name' => 'update_site_infos', 'display_name'      => ['ar'    =>  'تعديل بيانات الموقع', 'en'    =>  'Edit Site Infos'], 'route' => 'settings.site_main_infos', 'module' => 'settings.site_main_infos', 'as' => 'settings.site_main_infos.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site Contacts  
        $displaySiteContacts =  Permission::create(['name' => 'display_site_contacts', 'display_name'   => ['ar'    =>  'إدارة  بيانات الإتصال ', 'en' =>  'Manage Site Contact '], 'route' => 'settings.site_contacts', 'module' => 'settings.site_contacts', 'as' => 'settings.site_contacts.show', 'icon' => 'fa fa-address-book', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteContacts  =  Permission::create(['name' => 'update_site_contacts', 'display_name'    => ['ar'    =>  'تعديل بيانات الإتصال ', 'en'   =>  'Edit Site Contact '], 'route' => 'settings.site_contacts', 'module' => 'settings.site_contacts', 'as' => 'settings.site_contacts.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site Socials
        $displaySiteSocails =  Permission::create(['name' => 'display_site_socials', 'display_name'     =>  ['ar'   =>  ' إدارة  حسابات التواصل  ',   'en'    =>  'Manage Site Socials'], 'route' => 'settings.site_socials', 'module' => 'settings.site_socials', 'as' => 'settings.site_socials.show', 'icon' => 'fas fa-rss', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteSocails  =  Permission::create(['name' => 'update_site_socials', 'display_name'      =>  ['ar'   =>  'تعديل حسابات التواصل ',   'en'    =>  'Edit Site Contact Infos'], 'route' => 'settings.site_socials', 'module' => 'settings.site_socials', 'as' => 'settings.site_socials.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);

        // Site SEO
        $displaySiteMetas =  Permission::create(['name' => 'display_site_meta', 'display_name'     =>  ['ar'   =>  'إدارة  SEO',   'en'    =>  'Manage Site SEO'], 'route' => 'settings.site_meta', 'module' => 'settings.site_meta', 'as' => 'settings.site_meta.show', 'icon' => 'fa fa-tag', 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '1', 'appear' => '1']);
        $updateSiteMetas  =  Permission::create(['name' => 'update_site_meta', 'display_name'      =>  ['ar'   =>  'تعديل SEO',   'en'    =>  'Edit Site SEO'], 'route' => 'settings.site_meta', 'module' => 'settings.site_meta', 'as' => 'settings.site_meta.edit', 'icon' => null, 'parent' => $manageSiteSettings->id, 'parent_original' => $manageSiteSettings->id, 'parent_show' => $manageSiteSettings->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
