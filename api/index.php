<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function sendFile()
        {
        let file = document.querySelector("#files");
        
        let form = new FormData();
        form.append("file", file.files[0]);
        
        const options = {
            method: 'POST',
            body: form
        }

        fetch("http://localhost:8080/file/create.php",options).then(async (response)=>{
           console.log(await response.text());
        });
        }
    </script>
</head>
<body>
    <input type="file" id="files"/>
    <input type="button" onclick="sendFile()" />
</body>
</html>