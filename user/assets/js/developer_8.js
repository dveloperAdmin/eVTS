function msg(icon, status){
    Swal.fire({
        icon: icon,
        title: status,
        showCloseButton: true,
        confirmButton: true,
        
      })
}




$(".col_1").css("display","none");
$("#sub_id").css("display","none");

$("#govt_id_type").change(function(){
    let type = $(this).val();
    
    if(type !=""){
        $("#id_no").removeAttr("disabled");
        if(type == "Aadhaar"){
            $("#id_no").attr("maxlength","12");
        }else if(type == "PAN"){
            
            $("#id_no").attr("maxlength","10");
        }else{
            $("#id_no").attr("maxlength","20");
        }
    }else{
        $("#id_no").attr("disabled", "disabled");
    }
})

$("#id_no").keyup(function(){
    // console.log("yes");
    let id_no=$(this).val();
    let id_type = $("#govt_id_type").val();
    if(id_no!="" && id_type!=""){

        $(".col_1").css("display","block");
        $("#f_1").css("padding","3rem");
        
    
        $.ajax
        ({
            type: "POST",
            url: "ajax.php",
            data: {"id_no":id_no, "type":id_type},
            dataType: "json",
            success: function(data)
            {
                if(data.length!=0){
                    // $("#visit_n").attr("value","");
                    // $("#com_name").attr("value","");
                    // $("#desig").attr("value","");
                    // $("#add_ss").attr("value","");
                    // $("#gmail").attr("value","");
                    // $("#cont").attr("value","");

                    $("#v_salu").val(data[0]);
                    $("#visit_n").val(data[1]);
                    $("#com_name").val(data[2]);
                    $("#desig").val(data[3]);
                    $("#add_ss").val(data[4]);
                    $("#gmail").val(data[5]);
                    $("#cont").val(data[6]);
                }
            } 
        });
    }else{
      
        //  $(".col_1").css("display","none");
         $("#visit_n, #com_name, #desig, #add_ss, #gmail, #cont").val("");
        $("#f_1").css("padding","20px");
    }

})

$("#save_next").submit(function(e){
    let id_type = $("#govt_id_type").val();
    let id_no=$("#id_no").val();
    let file = ("#file_upload").val();
    if(id_type !=""){
        
        if (id_no!=""){
            
            if(id_type== "Aadhaar"){
                console.log(id_type);
                if(id_no.length!= 12){
                    e.preventDefault();
                    msg("error", "Please Currect Id NO..");
                    // stopEvent(e);
                }
                
            }else if(id_type == "PAN"){
                console.log(id_type);
                if(id_no.length!= 10){
                    e.preventDefault();
                    msg("error", "Please Currect Id NO..");
                    // stopEvent(e);
                }
                
            }else {
                if(id_no.length > 20){
                    e.preventDefault();
                    msg("error", "Please Currect Id NO..");
                    // stopEvent(e);
                }
            }
        }else{
            // console.log(id_type);
            e.preventDefault();
            msg("error", "Please Fill The Proper Id NO..");
        }
        
    }else{
        $("#id_no").attr("disabled", "disabled");
    }
    if(file == ""){
        e.preventDefault();
        msg("error", "Please fill all the fields... ");
    }

})

$("#vehicle").change(function(){
    let v_no  = $(this).val();
    if(v_no != "NO" && v_no!="Cycle"){
        $("#v_no").removeAttr("disabled");

        $("#v_no").attr("required", "true");
    }else{
        $("#v_no").attr("required", "true");
        $("#v_no").attr("disabled", "disabled");

    }
})

$("#img_sub").submit(function(e){
    let img5 = $("#img2").val();
    // console.log(img5);
    if(img5 == ""){
        
        e.preventDefault();
        msg("error", "You Should Click A Picture ");
    }
})

$("#click_pic").click(function(){
    let img = $("#img2").val();
    if(img !=""){
        $("#sub_id").css("display","grid");
    }else{
        $("#sub_id").css("display","none");
    }
})


$("#print_url").click(function(){
    
})

$("#file_upload").change(function(){
    let file_name = $(this).val();
    let extension = file_name.split('.').pop();
    var fileExtension = ['jpeg', 'jpg', 'png'];
    let fsize= this.files[0].size;
    let file =  Math.round((fsize / 1024));
    if(file >3072){
        Swal.fire({
            icon: 'warning',
            title: 'Picture size within 3 MB',
            showCloseButton: true,
            confirmButton: true,
        })     
        $(this).val(''); 
    }else if($.inArray(extension.toLowerCase(), fileExtension) == -1) {
        Swal.fire({
            icon: 'warning',
            title: 'Picture formate should be in .png, .jpg, .jpeg ',
            showCloseButton: true,
            confirmButton: true,
        })     
      
        $(this).val('');
    }

})