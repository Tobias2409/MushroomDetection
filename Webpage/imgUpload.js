let $ = document.querySelector.bind(document)


$("#upload").onchange = () => {
    $("#imageResult").src = URL.createObjectURL($("#upload").files[0]);
    $("#imageResultContainer").style.visibility = "visible";
    $("#upload-label").innerHTML = $("#upload").files[0].name;
};