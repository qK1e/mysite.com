function uploadPhoto(e)
{
    let file_input = document.getElementById("photo-input");
    file_input.click();
    e.preventDefault();
}

function displayPhoto(files)
{
    if(files && files[0])
    {
        let file = files[0];
        let reader = new FileReader();
        let img = document.getElementById("photo");
        img.file = file;

        reader.onload = ( function(aImg) { return function(e) { aImg.src = e.target.result; }; } )(img);

        reader.readAsDataURL(file);
    }
}