const dropArea = document.querySelector(".drag-area"),
button = document.querySelector(".load-btn"),
closeBtn = document.querySelector(".btn-close"),
fileInput = document.querySelector(".file-input");
let file;

$(".file-input").change(function(){
  file = this.files[0];
  dropArea.classList.add("active");
  showFile();
});

button.onclick = ()=>{
  fileInput.click();
}

closeBtn.onclick = ()=>{
  document.querySelector(".file-input").value = null;
  document.querySelector("#preview").style.display = "none";
  document.querySelector(".submit-btn").style.display = "none";
  dropArea.classList.remove("active");
}

function showFile(){
    let fileReader = new FileReader();
    fileReader.onload = ()=>{
      let fileURL = fileReader.result;
      document.querySelector("#preview").src = fileURL;
    }
    fileReader.readAsDataURL(file);
    document.querySelector("#preview").style.display = "block";
    document.querySelector(".submit-btn").style.display = "block";
}
