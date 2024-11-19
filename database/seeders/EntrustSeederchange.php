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
        //Testimonials
        $manageTestimonials = Permission::create(['name' => 'manage_testimonials', 'display_name' => ['ar'   =>  'إدارة الشهادات',   'en'    =>  'Manage Testimonials'], 'route' => 'testimonials', 'module' => 'testimonials', 'as' => 'testimonials.index', 'icon' => 'fas fa-question', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '100',]);
        $manageTestimonials->parent_show = $manageTestimonials->id;
        $manageTestimonials->save();
        $showTestimonials   =  Permission::create(['name'  => 'show_testimonials', 'display_name'        =>  ['ar'   =>  'الشهادات',   'en'    =>  'Testimonials'], 'route' => 'testimonials', 'module' => 'testimonials', 'as' => 'testimonials.index', 'icon' => 'fas fa-question', 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createTestimonials =  Permission::create(['name'  => 'create_testimonials', 'display_name'      =>  ['ar'   =>  'إضافة شهادة ترويجية جديدة',   'en'    =>  'Create New Testimonial'], 'route' => 'testimonials/create', 'module' => 'testimonials', 'as' => 'testimonials.create', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayTestimonials =  Permission::create(['name' => 'display_testimonials', 'display_name'     =>  ['ar'   =>  'عرض شهادة ترويجية',   'en'    =>  'Dispay Testimonial'], 'route' => 'testimonials/{testimonials}', 'module' => 'testimonials', 'as' => 'testimonials.show', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateTestimonials  =  Permission::create(['name' => 'update_testimonials', 'display_name'      =>  ['ar'   =>  'تعديل شهادة ترويجية',   'en'    =>  'Edit Testimonial'], 'route' => 'testimonials/{testimonials}/edit', 'module' => 'testimonials', 'as' => 'testimonials.edit', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteTestimonials =  Permission::create(['name'  => 'delete_testimonials', 'display_name'      =>  ['ar'   =>  'حذف شهادة ترويجية',   'en'    =>  'Delete Testimonial'], 'route' => 'testimonials/{testimonials}', 'module' => 'testimonials', 'as' => 'testimonials.destroy', 'icon' => null, 'parent' => $manageTestimonials->id, 'parent_original' => $manageTestimonials->id, 'parent_show' => $manageTestimonials->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
