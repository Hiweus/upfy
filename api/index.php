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
        form.append("user", "13");
        form.append("file", file.files[0]);
        

        let myHeaders = new Headers();
        myHeaders.append("token", "289242e6e0c6c5bc8b2447958792b2d6032fdfa6f5a63e8567d5e86817b2f081");
        
        const options = {
            method: 'POST',
            body: form,
            headers:myHeaders
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