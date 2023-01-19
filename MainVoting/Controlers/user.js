readOne();
function readOne(){
    $("#users tbody").html("");
    var data ={
    
      action: "readOne"
    }
    $.ajax({
      method: "POST",
      dataType: "JSON",
      data: data,
    url : "./Api/users.api.php",
    success: (response)=>{
      var tr=""
        console.log(response)
        response.forEach((items)=>{
          tr+="<tr>";
  
          for(i in items){
            if(i=="Photo")
            tr+=`<td><img style="border-radius: 40%" src="./uploads/${items[i]}" alt="No" width="50px"></td>`
            else
            tr+=`<td>${items[i]}</td>`
          
          }
          tr+=`<td><i class="fa-solid fa-user-xmark text-danger" style="font-size:30px; cursor: pointer; margin-right: 10px;" id="deleteIcon" deleteUser="${items['USERID']}"></i> 
          <i class="fa-solid fa-pen-to-square" id="editIcon" editUser="${items['USERID']}" style="font-size:30px; cursor: pointer;"></i></td>`
           
          tr+="</tr>";
        })
        $("#users tbody").append(tr);
    },
    error: (response)=>{
      console.log(response)
    }
    });
  }
// table
$("#users tbody").on("click","i#deleteIcon",function(){
    var id = $(this).attr("deleteUser");
    Swal.fire({
        title: 'Are you sure?',
        text: `You Gonna Delete The Record That Has an ID ${id} 
        ....`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
        deleteUser(id);
       
        }else
           return;
      })
  })


  $("#users tbody").on("click","i#editIcon",function(){
    var id = $(this).attr("editUser");
   window.location=`./EditUser.php?id=${id}`;
  })
  function deleteUser(id){
    let dataValue ={
        targetID: id,
        action:"deleteUser"
    }
    $.ajax({
        method: "POST",
        dataType: "JSON",
        data: dataValue,      
      url : "./Api/users.api.php",
      success: (response)=>{
        Swal.fire(
            'Deleted!',
            `${response['responseMessage']}`,
            'success'
          )
          readOne();
      },
      error: (response)=>{
        Swal.fire(
            'ERROR ENCOUNTERED!',
            `${response['responseText']}`,
            'error'
          )
      }

      });
  }
  var saveUser = document.getElementById("saveChanges");
saveUser.addEventListener("click",(e)=>{
    e.preventDefault();
   
      var formData = new FormData();
      formData.append("username",$("#username").val())
      formData.append("email",$("#email").val())
      formData.append("type",$("#type").val())
      formData.append("status",$("#status").val())
      formData.append("targetID",$("#targetID").val())
      formData.append("action","update")
  
        $.ajax({
          method: "POST",
          dataType: "JSON",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,

        url : "./Api/users.api.php",   
        success: (response)=>{
//         //  showToast(response['response'],"success",success);
       alert(response['response']);
        },
        error: (response)=>{
         // showToast(`Error Occurred: ${response['statusText\nresponseText']}`,"success",success);
        }
  
        });
})
