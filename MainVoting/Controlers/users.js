readOne();
var img = document.getElementById("image");
var saveUser = document.getElementById("saveUser");
var file = document.getElementById("file");
var color = "red";
var success = "green";


// vars
var username = document.getElementById("username");
var email = document.getElementById("email");
var password = document.getElementById("password");

var fileDefaultImage='../uploads/default.png';
var arrayImage= fileDefaultImage.split("/");
var defaultImage=arrayImage[2];


// save user
saveUser.addEventListener("click",  (e)=> {
e.preventDefault();
  if (CheckBlanks(username, password, email)){
    showToast("All Fields Are Required.....", "error", color);
    Erase(fileImage);
  }
  else if (ImageIsNotSelected()) {
    var fileImage = document.querySelector('input[type="file"]');
    var myfile= new File([new Blob([defaultImage])],defaultImage,{
      type: "image/png"
    }
    );
    var trans = new DataTransfer();
    trans.items.add(myfile);
    fileImage.files=trans.files;
    console.log(fileImage.files[0]);
    findUser(username.value,(responseUser)=>
     {
       if(!responseUser['isExist']){
          findEmail(email.value,(responseEmail)=>
          {
              if(!responseEmail['isExist'])
                {
                //document.getElementById('file').addEventListener('change', ()=>read(fileImage))
                 AddUser(fileImage);
                 Erase(fileImage);
                }
                else{
                showToast("This Email already Take Choose Another One","error",color)
                Erase(fileImage);
                }
          })
    }else{
      showToast("This Username already Take Choose Another One","error",color)
      Erase(fileImage);
    }
     })
   }
   else{
    var fileImage = document.querySelector('input[type="file"]');
    findUser(username.value,(responseUser)=>
     {
       if(!responseUser['isExist']){
          findEmail(email.value,(responseEmail)=>
          {
              if(!responseEmail['isExist'])
                {
                //document.getElementById('file').addEventListener('change', ()=>read(fileImage))
                 AddUserWithImage(fileImage);
                 Erase(fileImage);
                }
                else{
                showToast("This Email already Take Choose Another One","error",color)
                Erase(fileImage);
                }
          })
    }else{
      showToast("This Username already Take Choose Another One","error",color)
      Erase(fileImage);
    }
     })
   }
})






function Erase(file){
 file.value="";
 username.value="";
 email.value="";
 password.value="";
}

// toest
function showToast(message, type, backgroundColor) {
  if (type == "error") {
    Toastify({
      text: message,
      duration: 3000,
      // destination: "https://github.com/apvarun/toastify-js",
      newWindow: true,
      close: true,
      // gravity: "top", // `top` or `bottom`
      position: "center", // `left`, `center` or `right`
      stopOnFocus: true, // Prevents dismissing of toast on hover
      style: {
        background: backgroundColor,
      },

    }).showToast();
  } else {
    Toastify({
      text: message,
      duration: 3000,
      // destination: "https://github.com/apvarun/toastify-js",
      newWindow: true,
      close: true,
      gravity: "top", // `top` or `bottom`
      position: "center", // `left`, `center` or `right`
      stopOnFocus: true, // Prevents dismissing of toast on hover
      style: {
        background: backgroundColor,
      },

    }).showToast();
  }
}



function isvalidImage(type) {
  return type == "jpg" || type == "png";
}
function ImageIsNotSelected() {
  return file.files.length == 0;
}



function CheckBlanks(...userInputs) {
  var isValid = false;
  userInputs.forEach((input) => {
    if (input.value == "")
      isValid = true;
  })

  return isValid;
}





function findUser(username,isExist){
  var data ={
    target: username,
    action: "findUser"
  }
  $.ajax({
    method: "POST",
    dataType: "JSON",
    data: data,
  url : "./Api/users.api.php",
  success: (response)=>{
       isExist(response)
  },
  error: (response)=>{
    console.log(response)
  }
  });
}

function findEmail(email,isExist){
  var data ={
    target: email,
    action: "findEmail"
  }
  $.ajax({
    method: "POST",
    dataType: "JSON",
    data: data,
  url : "./Api/users.api.php",
  success: (response)=>{
       isExist(response)
  },
  error: (response)=>{
    console.log(response)
  }
  });
}


function readOne(){
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
        tr+=`<td><i class="fa-solid fa-user-xmark text-danger" style="font-size:30px; cursor: pointer;" id="deleteIcon" deleteUser="${items['USERID']}"></i></td>`
         
        tr+="</tr>";
      })
      $("#users tbody").append(tr);
  },
  error: (response)=>{
    console.log(response)
  }
  });
}
function read(file) {
  var GetFile = new FileReader();

   GetFile .onload=function(){
        
        // DO Somthing
alert(GetFile.result);
GetFile.readAsText(file.files[0]);


}
}
   


function AddUser(file){
  var data ={
      userName: username.value,
      Email: email.value,
      Pass : password.value,
      image: `${username.value}-${defaultImage}`,
      action: "insert",
     // file: File
    };
    var formData = new FormData();
    formData.append("file",file.files[0])
    formData.append("username",$("#username").val())
    formData.append("password",$("#password").val())
    formData.append("email",$("#email").val())
    formData.append("type",$("#type").val())
    formData.append("status",$("#status").val())
    formData.append("action","insert")

      $.ajax({
        method: "POST",
        dataType: "JSON",
        data: formData,
        Cache: false,
        contentType: false,
        processData: false,
      url : "./Api/users.api.php",
     
      success: (response)=>{
        showToast(response['response'],"success",success);
      
      },
      error: (response)=>{
        showToast(`Error Occurred: ${response['statusText\nresponseText']}`,"success",success);
      }

      });
}




function AddUserWithImage(file){
  var data ={
      userName: username.value,
      Email: email.value,
      Pass : password.value,
      image: `${username.value}-${defaultImage}`,
      action: "insert",
     // file: File
    };
    var formData = new FormData();
    formData.append("file",file.files[0])
    formData.append("username",$("#username").val())
    formData.append("password",$("#password").val())
    formData.append("email",$("#email").val())
    formData.append("type",$("#type").val())
    formData.append("status",$("#status").val())
    formData.append("action","AddUserWithImage")

      $.ajax({
        method: "POST",
        dataType: "JSON",
        data: formData,
        Cache: false,
        contentType: false,
        processData: false,
      url : "./Api/users.api.php",
     
      success: (response)=>{
        showToast(response['response'],"success",success);
      
      },
      error: (response)=>{
        showToast(`Error Occurred: ${response['statusText\nresponseText']}`,"success",success);
      }

      });
}


