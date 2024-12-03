$(document).ready(function(){

    //  updatePageCategoryStatus Status
    $(document).on("click",".updatePageCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var page_category_id = $(this).attr("page_category_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/page-categories/update-page-category-status',
            data:{status:status,page_category_id:page_category_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#page-category-"+page_category_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#page-category-"+page_category_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updatePageStatus Status
    $(document).on("click",".updatePageStatus",function(){
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/pages/update-page-status',
            data:{status:status,page_id:page_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateAcademicProgramMenuStatus Status
    $(document).on("click",".updateAcademicProgramMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var academic_program_menu_id = $(this).attr("academic_program_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/academic_program_menus/update-academic-program-menus-status',
            data:{status:status,academic_program_menu_id:academic_program_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#academic-program-menu-"+academic_program_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#academic-program-menu-"+academic_program_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateSupervisorStatus Status
    $(document).on("click",".updateSupervisorStatus",function(){
        var status = $(this).children("i").attr("status");
        var supervisor_id = $(this).attr("supervisor_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/supervisors/update-supervisor-status',
            data:{status:status,supervisor_id:supervisor_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#supervisor-"+supervisor_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#supervisor-"+supervisor_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

     //  updatePostStatus Status
     $(document).on("click",".updatePostStatus",function(){
        var status = $(this).children("i").attr("status");
        var post_id = $(this).attr("post_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/posts/update-post-status',
            data:{status:status,post_id:post_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#post-"+post_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#post-"+post_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateNewsStatus Status
    $(document).on("click",".updateNewsStatus",function(){
        var status = $(this).children("i").attr("status");
        var new_id = $(this).attr("new_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/news/update-news-status',
            data:{status:status,new_id:new_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#new-"+new_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#new-"+new_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateAdvStatus Status
    $(document).on("click",".updateAdvStatus",function(){
        var status = $(this).children("i").attr("status");
        var adv_id = $(this).attr("adv_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/advs/update-adv-status',
            data:{status:status,adv_id:adv_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#adv-"+adv_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#adv-"+adv_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateEventStatus Status
    $(document).on("click",".updateEventStatus",function(){
        var status = $(this).children("i").attr("status");
        var event_id = $(this).attr("event_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/events/update-event-status',
            data:{status:status,event_id:event_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#event-"+event_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#event-"+event_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateAlbumStatus Status
    $(document).on("click",".updateAlbumStatus",function(){
        var status = $(this).children("i").attr("status");
        var album_id = $(this).attr("album_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/albums/update-album-status',
            data:{status:status,album_id:album_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#album-"+album_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#album-"+album_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updatePlaylistStatus Status
    $(document).on("click",".updatePlaylistStatus",function(){
        var status = $(this).children("i").attr("status");
        var playlist_id = $(this).attr("playlist_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/playlists/update-playlist-status',
            data:{status:status,playlist_id:playlist_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#playlist-"+playlist_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#playlist-"+playlist_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateMainSliderStatus Status
    $(document).on("click",".updateMainSliderStatus",function(){
        var status = $(this).children("i").attr("status");
        var main_slider_id = $(this).attr("main_slider_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/main_sliders/update-main-slider-status',
            data:{status:status,main_slider_id:main_slider_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#main-slider-"+main_slider_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#main-slider-"+main_slider_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateAdvertisorSliderStatus Status
    $(document).on("click",".updateAdvertisorSliderStatus",function(){
        var status = $(this).children("i").attr("status");
        var advertisor_slider_id = $(this).attr("advertisor_slider_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/advertisor_sliders/update-advertisor-slider-status',
            data:{status:status,advertisor_slider_id:advertisor_slider_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#advertisor-slider-"+advertisor_slider_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#advertisor-slider-"+advertisor_slider_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateStatisticStatus Status
    $(document).on("click",".updateStatisticStatus",function(){
        var status = $(this).children("i").attr("status");
        var statistic_id = $(this).attr("statistic_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/statistics/update-statistic-status',
            data:{status:status,statistic_id:statistic_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#statistic-"+statistic_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#statistic-"+statistic_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateDocumentArchiveStatus Status
    $(document).on("click",".updateDocumentArchiveStatus",function(){
        var status = $(this).children("i").attr("status");
        var document_archive_id = $(this).attr("document_archive_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/document_archives/update-document-archive-status',
            data:{status:status,document_archive_id:document_archive_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#document-archive-"+document_archive_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#document-archive-"+document_archive_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateTagStatus Status
    $(document).on("click",".updateTagStatus",function(){
        var status = $(this).children("i").attr("status");
        var tag_id = $(this).attr("tag_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/tags/update-tag-status',
            data:{status:status,tag_id:tag_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#tag-"+tag_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#tag-"+tag_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateMainMenuStatus Status
    $(document).on("click",".updateMainMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var main_menu_id = $(this).attr("main_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/main_menus/update-main-menu-status',
            data:{status:status,main_menu_id:main_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#main-menu-"+main_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#main-menu-"+main_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateTracksMenuStatus Status
    $(document).on("click",".updateTracksMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var tracks_menu_id = $(this).attr("tracks_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/tracks_menus/update-tracks-menu-status',
            data:{status:status,tracks_menu_id:tracks_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#tracks-menu-"+tracks_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#tracks-menu-"+tracks_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateSupportMenuStatus Status
    $(document).on("click",".updateSupportMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var support_menu_id = $(this).attr("support_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/support_menus/update-support-menu-status',
            data:{status:status,support_menu_id:support_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#support-menu-"+support_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#support-menu-"+support_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateCompanyMenuStatus Status
    $(document).on("click",".updateCompanyMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var company_menu_id = $(this).attr("company_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/company_menus/update-company-menu-status',
            data:{status:status,company_menu_id:company_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#company-menu-"+company_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#company-menu-"+company_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });


    //  updateImportantLinkMenuStatus Status
    $(document).on("click",".updateImportantLinkMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var important_link_menu_id = $(this).attr("important_link_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/important_link_menus/update-important-link-menu-status',
            data:{status:status,important_link_menu_id:important_link_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#important-link-menu-"+important_link_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#important-link-menu-"+important_link_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateContactUsMenuStatus Status
    $(document).on("click",".updateContactUsMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var contact_us_menu_id = $(this).attr("contact_us_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/contact_us_menus/update-contact-us-menu-status',
            data:{status:status,contact_us_menu_id:contact_us_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#contact-us-menu-"+contact_us_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#contact-us-menu-"+contact_us_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });
    
    //  updatePoliciesPrivacyMenuStatus Status
    $(document).on("click",".updatePoliciesPrivacyMenuStatus",function(){
        var status = $(this).children("i").attr("status");
        var policies_privacy_menu_id = $(this).attr("policies_privacy_menu_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/policies_privacy_menus/update-policies-privacy-menu-status',
            data:{status:status,policies_privacy_menu_id:policies_privacy_menu_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#policies-privacy-menu-"+policies_privacy_menu_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#policies-privacy-menu-"+policies_privacy_menu_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updatePartnerStatus Status
    $(document).on("click",".updatePartnerStatus",function(){
        var status = $(this).children("i").attr("status");
        var partner_id = $(this).attr("partner_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/partners/update-partner-status',
            data:{status:status,partner_id:partner_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#partner-"+partner_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#partner-"+partner_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updatePresidentSpeechStatus Status
    $(document).on("click",".updatePresidentSpeechStatus",function(){
        var status = $(this).children("i").attr("status");
        var president_speech_id = $(this).attr("president_speech_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/president_speeches/update-president-speech-status',
            data:{status:status,president_speech_id:president_speech_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#president-speech-"+president_speech_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#president-speech-"+president_speech_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateTestimonialStatus Status
    $(document).on("click",".updateTestimonialStatus",function(){
        var status = $(this).children("i").attr("status");
        var testimonial_id = $(this).attr("testimonial_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/testimonials/update-testimonial-status',
            data:{status:status,testimonial_id:testimonial_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#testimonial-"+testimonial_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#testimonial-"+testimonial_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateCommonQuestionStatus Status
    $(document).on("click",".updateCommonQuestionStatus",function(){
        var status = $(this).children("i").attr("status");
        var common_question_id = $(this).attr("common_question_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/common_questions/update-common-question-status',
            data:{status:status,common_question_id:common_question_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#common-question-"+common_question_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#common-question-"+common_question_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //  updateCommonQuestionVideoStatus Status
    $(document).on("click",".updateCommonQuestionVideoStatus",function(){
        var status = $(this).children("i").attr("status");
        var common_question_video_id = $(this).attr("common_question_video_id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/common_question_videos/update-common-question-video-status',
            data:{status:status,common_question_video_id:common_question_video_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#common-question-video-"+common_question_video_id).html("<i class='fas fa-toggle-off fa-lg text-warning' aria-hidden='true' status='Inactive' style='font-size:1.6em' />");
                }else if (resp['status'] ==1 ){
                    $("#common-question-video-"+common_question_video_id).html("<i class='fas fa-toggle-on fa-lg text-success' aria-hidden='true' status='Active' style='font-size:1.6em' />");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

});