function truncate(string) {
    if (string.length > 30) {
        return string.slice(0, 5) + "...";
    }
    
    return string;
}

$('#logout').on("click", function() {
    window.location.href = "logout.php";
});

var fileName = "";
$(".custom-file-input").on("change", function() {
    if ($(this).val() != "") {
        $("#assigment_submit button").css({"display": "block"});
    }
    fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(truncate(fileName));
    $("#share_form").submit();
});
$("#share_form").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
        url: "upload_file.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
        }
    })
})

$("#sidebar").mCustomScrollbar({
    theme: "minimal"
});

$('#dismiss, .overlay').on('click', function () {
    $('#sidebar').removeClass('active');
    $('.overlay').removeClass('active');
});

$('#sidebarCollapse').on('click', function () {
    $('#sidebar').addClass('active');
    $('.overlay').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
});

$("[rel=popover]").popover({
    html : true,
    content: function(){
        return $("#pop").html();
    }
});

$('#assignment_delete').on('show.bs.modal', function(e) {
    var title = $(e.relatedTarget).data("title");

    $(e.currentTarget).find('b').html(title);
});

$('#people_delete').on('show.bs.modal', function(e) {
    var name = $(e.relatedTarget).data("name");

    $(e.currentTarget).find('b').html(name);
});

$(function() {
    var classroom_id = "";
    var component_id = "";
    var user_id = "";
    var role = 0;

    $('#comment').on('show.bs.modal', function(e) {
        classroom_id = $(e.relatedTarget).data("classroom_id");
        component_id = $(e.relatedTarget).data("component_id");
        user_id = $(e.relatedTarget).data("user_id");
        role = $(e.relatedTarget).data("role");

        $.ajax({
            url:'load_comment.php',
            method:'POST',
            data: {
                classroom_id : classroom_id,
                user_id : user_id, 
                component_id : component_id,
                role : role
            },
            success: function(data){
              console.log(data);
              $('#show_comment').html(data);
              $('#comment_content').val('');
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#post_comment').click(function() {
        let content = $('#comment_content').val();
        if (content != "") {
            $.ajax({
                url:'post_comment.php',
                method:'POST',
                data: {
                    content: content, 
                    user_id : user_id,
                    component_id : component_id,
                    classroom_id : classroom_id,
                    role : role
                },
                success: function(data){
                  console.log(data);
                  $('#show_comment').html(data);
                  $('#comment_content').val('');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
        else {
            $('#comment_content').val('');
        }
    });
});

var course_code = "";
var classroom_name = "";
var description = "";
var timeline = "";
var content = "";
var assignment_title = "";
var assignment_details = "";
var assignment_due_date = "";
var email = "";
var mail_content = "";
function getCourseCode(value){
    course_code = value;
}
function getCourseName(value){
    classroom_name = value;
}
function getDetails(value){
    description = value;
}
function getCourseTimeline(value){
    timeline = value;
}
function getComponentDetail(value) {
    content = value;
}
function getComponentAssignmentTitle(value) {
    assignment_title = value;
}
function getComponentAssignmentDetail(value) {
    assignment_details = value;
}
function getComponentAssignmentDueDate(value) {
    assignment_due_date = value;
}
function getEmail(value) {
    email = value;
}
function getMailContent(value) {
    mail_content = value;
}

$(function(){
    let user_id = "";
    let classroom_id = "";
    let name = "";
    $('#add_course').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        name = $(e.relatedTarget).data("lecture");
        
        $(e.currentTarget).find('input#course-code').val(classroom_id);
        $(e.currentTarget).find('input#lecture').val(name);
        $(e.currentTarget).find('input#course-name').val("");
        $(e.currentTarget).find('textarea#course-detail').val("");
        $(e.currentTarget).find('input#staring-date').val("");
    });

    $('#btn_create').click(function(){
        $.ajax({
            url:'create_course.php',
            method:'POST',
            data: { 
                user_id: user_id,
                classroom_id: classroom_id,
                classroom_name: classroom_name,
                description: description,
                timeline: timeline,
                name: name
            },
            success: function(data){
                console.log(data);
                $('#dashboard-ajax').html(data);
                location.reload();
            },
            error: function(data) {
              console.log(data);
            }
        })
    });
})

$(function(){
    let user_id = "";
    let classroom_id = "";
    let name = "";
    let descriptions = "";
    let staring_date = "";
    let lecture = "";

    $('#edit_course').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        name = $(e.relatedTarget).data("name");
        descriptions = $(e.relatedTarget).data("description");
        staring_date = $(e.relatedTarget).data("staring_date");
        lecture = $(e.relatedTarget).data("lecture");

        $(e.currentTarget).find('input#course-name').val(name);
        $(e.currentTarget).find('input#course-code').val(classroom_id);
        $(e.currentTarget).find('textarea#course-detail').val(descriptions);
        $(e.currentTarget).find('input#staring-date').val(staring_date);
        $(e.currentTarget).find('input#lecture').val(lecture);

        if (classroom_name == "") {
            classroom_name = name;
        }
        if (description == "") {
            description = descriptions;
        }
        if (timeline == "") {
            timeline = staring_date;
        }
    });

    $('#btn_edit_course').click(function(){
        $.ajax({
            url:'edit_course.php',
            method:'POST',
            data: { 
                user_id: user_id,
                classroom_id: classroom_id,
                name: classroom_name,
                description: description,
                staring_date: timeline,
                lecture: lecture
            },
            success: function(data){
                console.log(data);
                $('#dashboard-ajax').html(data);
                location.reload();
            },
            error: function(data) {
              console.log(data);
            }
        })
    });
})

$(function() {
    let user_id = "";
    let classroom_id = "";
    let name = "";
    
    $('#delete_course').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        name = $(e.relatedTarget).data("name");

        $(e.currentTarget).find('b').html(name);
    });

    $('#btn_delete_course').click(function(){
        $.ajax({
            url:'delete_course.php',
            method:'POST',
            data: {
                user_id: user_id, 
                classroom_id: classroom_id
            },
            success: function(data){
                console.log(data);
                $('#dashboard-ajax').html(data);
                location.reload();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function(){
    let user_id = "";
    $('#join_course').on('show.bs.modal', function(e) {
       user_id = $(e.relatedTarget).data("user_id");
    });

    $('#btn_join').click(function(){
        $.ajax({
            url:'insert_course_code.php',
            method:'POST',
            data: { 
                user_id: user_id,
                course_code: course_code
            },
            success: function(data){
                console.log(data);
                if (data == "1") {
                    $(".modal-error #exist").css({"display": "block"});
                    $(".modal-error #duplicate").css({"display": "none"});
                }
                else if (data == "2") {
                    $(".modal-error #exist").css({"display": "none"});
                    $(".modal-error #duplicate").css({"display": "block"});
                }
                else {
                    $('#dashboard-ajax').html(data);
                    $(".modal-error #exist").css({"display": "none"});
                    $(".modal-error #duplicate").css({"display": "none"});
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
})

function accept(classroom_id, user_id) {
    $.ajax({
        url:'update_passed.php',
        method:'POST',
        data: { 
            classroom_id: classroom_id,
            user_id: user_id
        },
        success: function(data){
          console.log(data);
          location.reload();
      },
      error: function(data) {
          console.log(data);
      }
    })
}

function reject(classroom_id, user_id, email) {
    $.ajax({
        url:'delete_people.php',
        method:'POST',
        data: { 
            user_id: user_id, 
            classroom_id: classroom_id,
            email: email
        },
        success: function(data){
            console.log(data);
            $('#tbody').html(data);
      },
      error: function(data) {
            console.log(data);
      }
    })
}

function remove(comment_id, classroom_id, component_id, user_id, role) {
    $.ajax({
        url:'delete_comment.php',
        method:'POST',
        data: {
            comment_id: comment_id,
            classroom_id: classroom_id,
            component_id: component_id,
            user_id: user_id,
            role : role
        },
        success: function(data){
            console.log(data);
            $('#show_comment').html(data);
            $('#comment_content').val('');
        },
        error: function(data) {
            console.log(data);
        }
    })
}

$(function() {
    let user_id = "";
    let classroom_id = "";
    let email = "";
    
    $('#people_delete').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        email = $(e.relatedTarget).data("email");
    });

    $('#btn_people_delete').click(function(){
        $.ajax({
            url:'delete_people.php',
            method:'POST',
            data: {
                user_id: user_id, 
                classroom_id: classroom_id,
                email: email
            },
            success: function(data){
                console.log(data);
                $('#tbody').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let user_id = "";
    let classroom_id = "";
    
    $('#share').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
    });

    $('#btn_share').click(function(){
        $.ajax({
            url:'insert_component.php',
            method:'POST',
            data: {
                user_id: user_id, 
                classroom_id: classroom_id,
                content: content,
                file: fileName
            },
            success: function(data){
                console.log(data);
                $('#view').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let component_id = "";
    let classroom_id = "";
    
    $('#material').on('show.bs.modal', function(e) {
        component_id = $(e.relatedTarget).data("component_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");

        $.ajax({
            url:'load_component_material.php',
            method:'POST',
            data: {
                component_id: component_id, 
                classroom_id: classroom_id
            },
            success: function(data){
                console.log(data);
                $('#show_material').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let user_id = "";
    let component_id = "";
    let classroom_id = "";
    let contents = "";
    
    $('#edit_component').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        component_id = $(e.relatedTarget).data("component_id");
        contents = $(e.relatedTarget).data("content");

        $(e.currentTarget).find('textarea[id="component-detail"]').val(contents);
    });

    $('#btn_edit_component').click(function(){
        $.ajax({
            url:'update_component.php',
            method:'POST',
            data: {
                user_id: user_id,
                component_id: component_id,
                classroom_id: classroom_id,
                content: content,
                file: fileName
            },
            success: function(data){
                console.log(data);
                location.reload();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let user_id = "";
    let component_id = "";
    let classroom_id = "";

    $('#delete_component').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        component_id = $(e.relatedTarget).data("component_id");
    });

    $('#btn_component_delete').click(function(){
        $.ajax({
            url:'delete_component.php',
            method:'POST',
            data: {
                user_id: user_id,
                component_id: component_id,
                classroom_id: classroom_id
            },
            success: function(data){
                console.log(data);
                location.reload();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let user_id = "";
    let classroom_id = "";
    
    $('#create').on('show.bs.modal', function(e) {
        user_id = $(e.relatedTarget).data("user_id");
        classroom_id = $(e.relatedTarget).data("classroom_id");
    });

    $('#btn_assignment_create').click(function(){
        $.ajax({
            url:'insert_assignment.php',
            method:'POST',
            data: {
                user_id: user_id, 
                classroom_id: classroom_id,
                title: assignment_title,
                due_date: assignment_due_date,
                content: assignment_details,
                file: fileName
            },
            success: function(data){
                console.log(data);
                $('#tbody').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let component_id = "";
    let classroom_id = "";
    
    $('#edit').on('show.bs.modal', function(e) {
        classroom_id = $(e.relatedTarget).data("classroom_id");
        component_id = $(e.relatedTarget).data("component_id");

        var title = $(e.relatedTarget).data("title");
        assignment_title = title;
        var details = $(e.relatedTarget).data("details");
        assignment_details = details;
        var date = $(e.relatedTarget).data("date");         //year-month-date
        assignment_due_date = date;
    
        $(e.currentTarget).find('input[id="assignment-title"]').val(title);
        $(e.currentTarget).find('textarea[id="assignment-details"]').val(details);
        $(e.currentTarget).find('input[id="date"]').val(date);
    });

    $('#btn_assignment_edit').click(function(){
        $.ajax({
            url:'update_assignment.php',
            method:'POST',
            data: {
                classroom_id: classroom_id,
                component_id: component_id,
                title: assignment_title,
                due_date: assignment_due_date,
                content: assignment_details
            },
            success: function(data){
                console.log(data);
                $('#tbody').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let component_id = "";
    let classroom_id = "";
    
    $('#assignment_delete').on('show.bs.modal', function(e) {
        var title = $(e.relatedTarget).data("title");
        classroom_id = $(e.relatedTarget).data("classroom_id");
        component_id = $(e.relatedTarget).data("component_id");

        $(e.currentTarget).find('b').html(title);
    });

    $('#btn_assignment_delete').click(function(){
        $.ajax({
            url:'delete_assignment.php',
            method:'POST',
            data: {
                classroom_id: classroom_id,
                component_id: component_id
            },
            success: function(data){
                console.log(data);
                $('#tbody').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let name = "";
    let classroom_id = "";
    let classroom_name = "";
    let email_lecture = "";

    $('#add').on('show.bs.modal', function(e) {
        classroom_id = $(e.relatedTarget).data("classroom_id");
        name = $(e.relatedTarget).data("name");
        classroom_name = $(e.relatedTarget).data("classroom_name");
        email_lecture = $(e.relatedTarget).data("email");
    });

    $('#btn_add_people').click(function(){
        $.ajax({
            url:'email_people.php',
            method:'POST',
            data: {
                classroom_id: classroom_id,
                name: name,
                classroom_name: classroom_name,
                email: email,
                email_lecture: email_lecture
            },
            success: function(data){
                console.log(data);
                if (data == "1") {
                    $('.modal-error #duplicate').css({"display": "block"});
                }
                else {
                    $('#tbody').html(data);
                    $('.modal-error #duplicate').css({"display": "none"});
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$(function() {
    let email = "";
    let name = "";
    let email_lecture = "";

    $('#mail').on('show.bs.modal', function(e) {
        email = $(e.relatedTarget).data("email");
        name = $(e.relatedTarget).data("name");
        email_lecture = $(e.relatedTarget).data("email_lecture");
    
        $(e.currentTarget).find('input[id="email-name"]').val(email);
    });

    $('#btn_send').click(function(){
        $.ajax({
            url:'email_send.php',
            method:'POST',
            data: {
                email: email,
                name: name,
                email_lecture: email_lecture,
                content: mail_content
            },
            success: function(data){
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
});

$("#search_people").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".filter_people").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

$("#search_assignment").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".filter_assignment").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// Admin
$(document).ready(function () {
    $('.datatable').dataTable();
});
 
function changeType(idbtn,userid,classroomid){
    if (idbtn == "btn_on") {
        idbtn = "btn_off";
        btn = "OFF";
    } else{
        idbtn = "btn_on";
        btn="ON";
    }
    $.ajax({
        url:"changeAccount.php",
        method:"POST",
        data: {
            userid: userid,action: btn, classroomid : classroomid
        },
        success: function(data){
            console.log(data);
            $('#tk'+userid+classroomid).html('<button id="'+idbtn+'" onclick="changeType(this.id,'+userid+','+"'"+classroomid+"'"+');">'+btn+'</button> ');
        },
        error: function(data){
            console.log(data);
        }
    });

} 

function deleteUser(userid){
    $.ajax({
        url:"changeAccount.php",
        method:"POST",
        data: {
            user_id: userid
        },
        success: function(data){
            console.log(data);
             //$('#show_user').html('');
            $('#show_user').html(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}   


function deleteClass(classroomid){
    $.ajax({
        url:"changeAccount.php",
        method:"POST",
        data: {
            classroom_id: classroomid
        },
        success: function(data){
            console.log(data);
             //$('#show_user').html('');
            $('#show_class').html(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}   

$('#logout').on("click", function() {
    window.location.href = "logout.php";
});

function deleteComponent(componentid){
    $.ajax({
        url:"changeAccount.php",
        method:"POST",
        data: {
            component_id: componentid
        },
        success: function(data){
            console.log(data);
             //$('#show_user').html('');
            $('#show_component').html(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}   

$('#logout').on("click", function() {
    window.location.href = "logout.php";
});